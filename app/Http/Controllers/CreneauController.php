<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Models\Creneau;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreneauController extends Controller
{
    public function bulkStore(Request $request, $terrain_id)
    {
        $terrain = Terrain::findOrFail($terrain_id);
        $user = auth()->user();
        
        if ($user->club_id !== $terrain->club_id && $user->role !== 'admin') {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'days' => 'required|array',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:30|max:180',
        ]);

        $days = $validated['days'];
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
        $duration = $validated['duration'];

        $count = 0;

        foreach ($days as $day) {
            $currentSlotTime = clone $startTime;
            
            while ($currentSlotTime->lt($endTime)) {
                $nextSlotTime = (clone $currentSlotTime)->addMinutes($duration);
                
                if ($nextSlotTime->gt($endTime)) {
                    break;
                }

                $exists = Creneau::where('terrain_id', $terrain->id)
                    ->where('day_of_week', $day)
                    ->where('start_time', $currentSlotTime->format('H:i:s'))
                    ->where('end_time', $nextSlotTime->format('H:i:s'))
                    ->exists();

                if (!$exists) {
                    Creneau::create([
                        'terrain_id' => $terrain->id,
                        'day_of_week' => $day,
                        'start_time' => $currentSlotTime->format('H:i'),
                        'end_time' => $nextSlotTime->format('H:i'),
                        'is_available' => true,
                    ]);
                    $count++;
                }

                $currentSlotTime->addMinutes($duration);
            }
        }

        return back()->with('success', 'Successfully created ' . $count . ' slots.');
    }

    public function toggle($id)
    {
        $creneau = Creneau::findOrFail($id);
        $user = auth()->user();
        
        if ($user->club_id !== $creneau->terrain->club_id && $user->role !== 'admin') {
            abort(403);
        }

        $creneau->is_available = !$creneau->is_available;
        $creneau->save();

        return back()->with('success', 'Slot status updated.');
    }
}
