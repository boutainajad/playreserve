<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $reservations = $user->reservations()
            ->with('terrain.club')
            ->orderBy('reservation_date', 'desc')
            ->get();

        $clubsQuery = Club::with('terrains');
        
        if ($request->filled('city')) {
            $clubsQuery->where('city', $request->city);
        }
        
        $clubs = $clubsQuery->get();

        $cities = Club::select('city')->distinct()->pluck('city');

        return view('dashboard.membre', [
            'reservations' => $reservations,
            'clubs' => $clubs,
            'cities' => $cities
        ]);
    }

    public function ownerDashboard()
    {
        $user = auth()->user();
        $club = $user->club;

        if (!$club) {
            return redirect()->route('home')->with('error', 'No club associated with your account.');
        }

        $terrains = $club->terrains;
        $terrainIds = $terrains->pluck('id');
        
        $reservations = Reservation::whereIn('terrain_id', $terrainIds)
            ->with(['user', 'terrain'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = 0;
        $activeBookings = 0;

        foreach ($reservations as $res) {
            if ($res->status === 'confirmed') {
                $totalRevenue += $res->total_price;
                $activeBookings++;
            }
        }

        return view('dashboard.owner', [
            'club' => $club,
            'terrains' => $terrains,
            'reservations' => $reservations,
            'totalRevenue' => $totalRevenue,
            'activeBookings' => $activeBookings
        ]);
    }

    public function adminDashboard()
    {
        $clubs = Club::all();
        $users = User::all();
        $reservations = Reservation::all();

        return view('dashboard.admin', [
            'clubs' => $clubs,
            'users' => $users,
            'reservations' => $reservations
        ]);
    }
}