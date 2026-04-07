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
            ->whereIn('status', ['pending', 'confirmed'])
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

        $alreadyBooked = Reservation::where('terrain_id', $validated['terrain_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('start_time', $validated['start_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()
                ->with('error', 'This slot is already reserved.')
                ->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'terrain_id' => $validated['terrain_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $validated['total_price'],
            'status' => 'pending',
        ]);

        return redirect()->route('paiement.show', $reservation->id);
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

        if ($reservation->status === 'cancelled') {
            return redirect()->back()->with('error', 'Already cancelled.');
        }

        $dateString = $reservation->reservation_date->format('Y-m-d');
        $timeString = $reservation->start_time;
        $matchDateTime = Carbon::parse($dateString . ' ' . $timeString);
        
        $hoursRemaining = now()->diffInHours($matchDateTime, false);

        if ($hoursRemaining < 24) {
            return redirect()->back()->with('error', 'Must cancel 24h before.');
        }

        $reservation->update(['status' => 'cancelled']);

        if ($reservation->paiement) {
            $reservation->paiement->update(['status' => 'refunded']);
        }

        return redirect()->back()->with('success', 'Cancelled and refunded.');
    }
}