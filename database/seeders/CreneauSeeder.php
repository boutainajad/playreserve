<?php

namespace Database\Seeders;

use App\Models\Terrain;
use App\Models\Creneau;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreneauSeeder extends Seeder
{
    public function run(): void
    {
        $terrains = Terrain::all();

        if ($terrains->isEmpty()) {
            $this->command->warn('No terrains found. Please create terrains first via the owner dashboard.');
            return;
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $startHour = 8;
        $endHour   = 22;
        $duration  = 60;

        $count = 0;

        foreach ($terrains as $terrain) {
            foreach ($days as $day) {
                $current = Carbon::createFromTime($startHour, 0, 0);
                $end     = Carbon::createFromTime($endHour, 0, 0);

                while ($current->lt($end)) {
                    $slotEnd = (clone $current)->addMinutes($duration);
                    if ($slotEnd->gt($end)) break;

                    $exists = Creneau::where('terrain_id', $terrain->id)
                        ->where('day_of_week', $day)
                        ->where('start_time', $current->format('H:i'))
                        ->exists();

                    if (!$exists) {
                        Creneau::create([
                            'terrain_id'  => $terrain->id,
                            'day_of_week' => $day,
                            'start_time'  => $current->format('H:i'),
                            'end_time'    => $slotEnd->format('H:i'),
                            'is_available' => true,
                        ]);
                        $count++;
                    }

                    $current->addMinutes($duration);
                }
            }
        }

        $this->command->info("✅ Created {$count} creneaux for {$terrains->count()} terrain(s).");
    }
}
