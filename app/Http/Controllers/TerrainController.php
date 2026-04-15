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
            'image' => 'nullable|image|max:4096',
        ]);

        $terrain = new Terrain();
        $terrain->name = $validatedData['name'];
        $terrain->sport_type = $validatedData['sport_type'];
        $terrain->price_per_hour = $validatedData['price_per_hour'];
        $terrain->description = $validatedData['description'] ?? null;
        $terrain->is_available = true;
        $terrain->club_id = $club->id;
        
        if ($request->hasFile('image')) {
            $terrain->image = $request->file('image')->store('terrains', 'public');
        }

        $terrain->save();

        return redirect()->route('owner.dashboard')->with('success', 'Terrain added successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $club = $user->club;

        if (!$user || $user->role !== 'owner' || !$club) {
            abort(403, 'Unauthorized action.');
        }

        $terrain = Terrain::where('id', $id)->where('club_id', $club->id)->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $terrain->name = $validatedData['name'];
        $terrain->sport_type = $validatedData['sport_type'];
        $terrain->price_per_hour = $validatedData['price_per_hour'];
        $terrain->description = $validatedData['description'] ?? null;
        
        if ($request->hasFile('image')) {
            $terrain->image = $request->file('image')->store('terrains', 'public');
        }

        $terrain->save();

        return redirect()->route('owner.dashboard')->with('success', 'Terrain updated successfully!');
    }

    public function search(Request $request)
    {
        $query = Terrain::with('club');
        
        if ($request->filled('city')) {
            $query->whereHas('club', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            });
        }
        
        if ($request->filled('sport_type')) {
            $query->where('sport_type', $request->sport_type);
        }
        
        if ($request->filled('date') && $request->filled('time')) {
            $date = $request->date;
            $time = $request->time;
            $dayOfWeek = date('l', strtotime($date));
            
            $query->whereHas('creneaux', function ($creneauQuery) use ($dayOfWeek, $time) {
                $creneauQuery->where('day_of_week', $dayOfWeek)
                             ->where('is_available', true)
                             ->where('start_time', '<=', $time)
                             ->where('end_time', '>', $time);
            })->whereDoesntHave('reservations', function ($resQuery) use ($date, $time) {
                $resQuery->where('reservation_date', $date)
                         ->whereIn('status', ['pending', 'confirmed'])
                         ->where('start_time', '<=', $time)
                         ->where('end_time', '>', $time);
            });
        }
        
        $terrains = $query->get();
        return view('terrains.search', compact('terrains'));
    }
}
