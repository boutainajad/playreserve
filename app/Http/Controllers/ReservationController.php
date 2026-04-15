<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Request $request, $terrain_id)
    {
        $terrain = Terrain::findOrFail($terrain_id);
        $date = $request->get('date', date('Y-m-d'));
        $dayOfWeek = date('l', strtotime($date));

        $creneaux = $terrain->creneaux()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        $existingReservations = Reservation::where('terrain_id', $terrain_id)
            ->where('reservation_date', $date)
            ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
            ->get();

        foreach ($creneaux as $slot) {
            $isReserved = false;
            
            foreach ($existingReservations as $res) {
                $resStartTime = date('H:i', strtotime($res->start_time));
                $slotStartTime = date('H:i', strtotime($slot->start_time));
                
                if ($resStartTime === $slotStartTime) {
                    $isReserved = true;
                    break;
                }
            }
            
            $slot->is_reserved = $isReserved;
        }

        return view('reservations.create', compact('terrain', 'creneaux', 'date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'terrain_id' => 'required',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'total_price' => 'required',
        ]);

        $lockKey = "reservation_lock_{$validated['terrain_id']}_{$validated['reservation_date']}_{$validated['start_time']}";
        $lock = \Illuminate\Support\Facades\Cache::lock($lockKey, 10);

        if (!$lock->get()) {
            return redirect()->back()
                ->with('error', 'Ce créneau est en cours de réservation par quelqu\'un d\'autre.')
                ->withInput();
        }

        try {
            $alreadyBooked = Reservation::where('terrain_id', $validated['terrain_id'])
                ->where('reservation_date', $validated['reservation_date'])
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->exists();

            if ($alreadyBooked) {
                return redirect()->back()
                    ->with('error', 'Ce créneau vient d\'être réservé.')
                    ->withInput();
            }

            $userHasReservation = Reservation::where('user_id', auth()->id())
                ->where('reservation_date', $validated['reservation_date'])
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->exists();

            if ($userHasReservation) {
                return redirect()->back()
                    ->with('error', 'Vous avez déjà une réservation active sur cette plage horaire.');
            }

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'terrain_id' => $validated['terrain_id'],
                'reservation_date' => $validated['reservation_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'total_price' => $validated['total_price'],
                'status' => Reservation::STATUS_PENDING,
            ]);

            return redirect()->route('paiement.show', $reservation->id);
            
        } finally {
            $lock->release();
        }
    }

    public function history()
    {
        $user = auth()->user();
        $reservations = $user->reservations()
            ->with(['terrain.club', 'paiement'])
            ->orderBy('reservation_date', 'desc')
            ->get();
            
        return view('reservations.history', compact('reservations'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', auth()->id())->findOrFail($id);

        if (in_array($reservation->status, [Reservation::STATUS_CANCELLED, Reservation::STATUS_EXPIRED, Reservation::STATUS_NO_SHOW])) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        $refundAmount = $reservation->calculateRefundAmount();
        $isRefundable = $reservation->isRefundable();

        if (!$isRefundable && request()->input('confirm_no_refund') !== '1') {
            $refundText = $refundAmount > 0 ? "Des frais d'annulation de 50% s'appliquent. Vous serez remboursé de {$refundAmount} DH." : "Annulation moins de 24h avant le créneau — aucun remboursement ne sera effectué.";
            return redirect()->back()->with('warning', "{$refundText} Confirmez pour annuler.");
        }

        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);

        if ($reservation->paiement && $refundAmount > 0) {
            $reservation->paiement->update([
                'status' => 'refunded', 
                'payment_details' => 'Refunded amount: ' . $refundAmount 
            ]);
        }

        $firstInWaitlist = \App\Models\Waitlist::where('terrain_id', $reservation->terrain_id)
            ->where('reservation_date', $reservation->reservation_date->format('Y-m-d'))
            ->where('start_time', $reservation->start_time)
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($firstInWaitlist) {
            $firstInWaitlist->update([
                'status' => 'notified',
                'notified_at' => now()
            ]);
            
            if ($firstInWaitlist->user) {
                $firstInWaitlist->user->notify(new \App\Notifications\WaitlistSlotAvailable($firstInWaitlist));
            }
        }

        $message = "Réservation annulée.";
        if ($refundAmount > 0) {
            $perc = ($refundAmount == $reservation->total_price) ? '100%' : '50%';
            $message .= " Vous avez été remboursé à {$perc} (" . $refundAmount . " DH).";
        } else {
            $message .= " Aucun remboursement (annulation tardive).";
        }

        return redirect()->back()->with('success', $message);
    }

    public function joinWaitlist(Request $request)
    {
        $validated = $request->validate([
            'terrain_id' => 'required',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $alreadyIn = \App\Models\Waitlist::where('user_id', auth()->id())
            ->where('terrain_id', $validated['terrain_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('start_time', $validated['start_time'])
            ->whereIn('status', ['waiting', 'notified'])
            ->exists();

        if ($alreadyIn) {
            return redirect()->back()->with('error', 'Vous êtes déjà sur la liste d\'attente pour ce créneau.');
        }

        \App\Models\Waitlist::create([
            'user_id' => auth()->id(),
            'terrain_id' => $validated['terrain_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'waiting'
        ]);

        return redirect()->back()->with('success', 'Vous avez rejoint la liste d\'attente avec succès. Vous serez notifié si le créneau se libère.');
    }
}