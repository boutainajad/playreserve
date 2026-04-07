<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use Illuminate\Http\Request;

class TerrainController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $club = $user->club;
        
        if (!$club) {
            return redirect()->back()->with('error', 'You must have a club to add terrains.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $terrain = new Terrain();
        $terrain->name = $validatedData['name'];
        $terrain->sport_type = $validatedData['sport_type'];
        $terrain->price_per_hour = $validatedData['price_per_hour'];
        $terrain->description = $validatedData['description'] ?? null;
        $terrain->is_available = true;
        $terrain->club_id = $club->id;
        
        $terrain->save();

        return redirect()->route('owner.dashboard')->with('success', 'Terrain added successfully!');
    }
}
