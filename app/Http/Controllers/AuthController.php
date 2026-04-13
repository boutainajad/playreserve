<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email or password incorrect']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'membre',
            'phone' => $validated['phone'] ?? null,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Registration successful');
    }

    public function showOwnerRegisterForm()
    {
        return view('auth.owner-register');
    }

    public function registerOwner(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string',
        ]);

        $clubData = $request->validate([
            'club_name' => 'required|string|max:255',
            'club_city' => 'required|string|max:255',
            'club_address' => 'required|string|max:255',
            'club_phone' => 'required|string|max:20',
            'club_email' => 'required|email|unique:clubs,email',
            'club_description' => 'nullable|string',
            'club_logo' => 'nullable|image|max:2048',
            'club_cover_image' => 'nullable|image|max:4096',
        ]);

        $exists = Club::where('name', $clubData['club_name'])
                      ->where('city', $clubData['club_city'])
                      ->exists();

        if ($exists) {
            return back()->withErrors(['club_name' => 'A club with this name already exists in this city.']);
        }

        $logoPath = null;
        if ($request->hasFile('club_logo')) {
            $logoPath = $request->file('club_logo')->store('clubs/logos', 'public');
        }

        $coverPath = null;
        if ($request->hasFile('club_cover_image')) {
            $coverPath = $request->file('club_cover_image')->store('clubs/covers', 'public');
        }

        $club = Club::create([
            'name' => $clubData['club_name'],
            'city' => $clubData['club_city'],
            'address' => $clubData['club_address'],
            'phone' => $clubData['club_phone'],
            'email' => $clubData['club_email'],
            'description' => $clubData['club_description'] ?? null,
            'logo' => $logoPath,
            'cover_image' => $coverPath,
            'latitude' => $request->input('club_latitude'),
            'longitude' => $request->input('club_longitude'),
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role' => 'owner',
            'phone' => $userData['phone'],
            'club_id' => $club->id,
        ]);

        Auth::login($user);
        return redirect()->route('owner.dashboard')->with('success', 'Club created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}