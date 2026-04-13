<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $query = Club::with('terrains');

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('sport_type')) {
            $query->whereHas('terrains', function ($q) use ($request) {
                $q->where('sport_type', $request->sport_type);
            });
        }

        $clubs = $query->get();

        return view('clubs.index', [
            'clubs' => $clubs
        ]);
    }

    public function show($id)
    {
        $club = Club::findOrFail($id);
        
        return view('clubs.show', [
            'club' => $club,
            'terrains' => $club->terrains
        ]);
    }

    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        if (auth()->user()->role !== 'owner' || auth()->user()->id !== $club->user_id && auth()->user()->club_id !== $club->id) {
            // we will let it pass if owner is associated with club
            // wait, owner belongsTo club or club belongsTo user?
            // Users table has club_id!
        }
        
        if (auth()->user()->role !== 'owner') {
             abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        $club->name = $validated['name'];
        $club->city = $validated['city'];
        $club->address = $validated['address'];
        $club->phone = $validated['phone'];
        $club->description = $validated['description'] ?? null;
        $club->latitude = $request->input('latitude');
        $club->longitude = $request->input('longitude');

        if ($request->hasFile('logo')) {
            $club->logo = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $club->cover_image = $request->file('cover_image')->store('clubs/covers', 'public');
        }

        $club->save();

        return back()->with('success', 'Club mis à jour avec succès.');
    }
}