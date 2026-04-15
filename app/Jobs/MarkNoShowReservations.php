<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MarkNoShowReservations implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $reservations = Reservation::where('status', 'confirmed')->get();
        
        foreach ($reservations as $reservation) {
            if ($reservation->reservation_date && $reservation->start_time) {
                $startDateTime = Carbon::parse($reservation->reservation_date->format('Y-m-d') . ' ' . $reservation->start_time);
                if (now()->greaterThanOrEqualTo($startDateTime->addHours(1))) {
                    $reservation->update(['status' => 'no_show']);
                    Log::info("Reservation {$reservation->id} marked as no_show.");
                }
            }
        }
    }
}
