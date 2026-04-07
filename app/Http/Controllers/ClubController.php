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
}