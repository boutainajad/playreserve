<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Waitlist;
use Carbon\Carbon;

class UpdateReservations extends Command
{
    protected $signature = 'res:update';
    protected $description = 'Met à jour le statut des réservations et gère la liste d\'attente';

    public function handle()
    {
        $this->expirePending();
        $this->markNoShows();
        $this->cycleWaitlist();
        
        $this->info('Update successful.');
    }

    private function expirePending()
    {
        $expiryTime = now()->subMinutes(15);
        $expired = Reservation::where('status', Reservation::STATUS_PENDING)
            ->where('created_at', '<=', $expiryTime)
            ->get();

        foreach ($expired as $res) {
            $res->update(['status' => Reservation::STATUS_EXPIRED]);
            $this->notifyWaitlist($res);
        }
    }

    private function markNoShows()
    {
        $now = now();
        $noShows = Reservation::where('status', Reservation::STATUS_CONFIRMED)
            ->where(function ($query) use ($now) {
                $query->where('reservation_date', '<', $now->format('Y-m-d'))
                      ->orWhere(function ($q) use ($now) {
                          $q->where('reservation_date', $now->format('Y-m-d'))
                            ->where('end_time', '<', $now->format('H:i:s'));
                      });
            })
            ->get();

        foreach ($noShows as $res) {
            $res->update(['status' => Reservation::STATUS_NO_SHOW]);
        }
    }

    private function cycleWaitlist()
    {
        $priorityExpiry = now()->subMinutes(30);
        $staleNotifications = Waitlist::where('status', 'notified')
            ->where('notified_at', '<=', $priorityExpiry)
            ->get();

        foreach ($staleNotifications as $wait) {
            $wait->update(['status' => 'expired']);
            
            $nextInLine = Waitlist::where('terrain_id', $wait->terrain_id)
                ->where('reservation_date', $wait->reservation_date)
                ->where('start_time', $wait->start_time)
                ->where('status', 'waiting')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($nextInLine) {
                $nextInLine->update([
                    'status' => 'notified',
                    'notified_at' => now()
                ]);
                
                if ($nextInLine->user) {
                    $nextInLine->user->notify(new \App\Notifications\WaitlistSlotAvailable($nextInLine));
                }
            }
        }
    }

    private function notifyWaitlist($reservation)
    {
        $next = Waitlist::where('terrain_id', $reservation->terrain_id)
            ->where('reservation_date', $reservation->reservation_date->format('Y-m-d'))
            ->where('start_time', $reservation->start_time)
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($next) {
            $next->update([
                'status' => 'notified',
                'notified_at' => now()
            ]);
            
            if ($next->user) {
                $next->user->notify(new \App\Notifications\WaitlistSlotAvailable($next));
            }
        }
    }
}
