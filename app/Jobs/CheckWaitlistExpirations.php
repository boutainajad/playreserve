<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Waitlist;
use Illuminate\Support\Facades\Log;

class CheckWaitlistExpirations implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $expiredWaitlists = Waitlist::where('status', 'notified')
            ->where('notified_at', '<', now()->subMinutes(30))
            ->get();

        foreach ($expiredWaitlists as $waitlist) {
            $waitlist->update(['status' => 'expired']);

            $nextInWaitlist = Waitlist::where('terrain_id', $waitlist->terrain_id)
                ->where('reservation_date', $waitlist->reservation_date->format('Y-m-d'))
                ->where('start_time', $waitlist->start_time)
                ->where('status', 'waiting')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($nextInWaitlist) {
                $nextInWaitlist->update([
                    'status' => 'notified',
                    'notified_at' => now()
                ]);
                
                if ($nextInWaitlist->user) {
                    $nextInWaitlist->user->notify(new \App\Notifications\WaitlistSlotAvailable($nextInWaitlist));
                }
                Log::info("User {$nextInWaitlist->user_id} notified for released slot in Terrain {$waitlist->terrain_id} after previous waitlisted user expired.");
            }
        }
    }
}
