<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Reservation;
use App\Models\Waitlist;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExpirePendingReservations implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $expiredReservations = Reservation::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(15))
            ->get();

        foreach ($expiredReservations as $reservation) {
            $reservation->update(['status' => 'expired']);

            $firstInWaitlist = Waitlist::where('terrain_id', $reservation->terrain_id)
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
                Log::info("User {$firstInWaitlist->user_id} notified for released slot in Terrain {$reservation->terrain_id}.");
            }
        }
    }
}
