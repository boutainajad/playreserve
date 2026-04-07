<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Terrain;
use App\Models\Creneau;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Les clubs sont créés uniquement par les propriétaires lors de leur inscription.');
    }
}