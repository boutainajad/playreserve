<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\TerrainController;
use App\Models\Club;

Route::get('/', function () {
    $clubs = Club::take(3)->get();
    return view('welcome', compact('clubs'));
})->name('home');

Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubs/{id}', [ClubController::class, 'show'])->name('clubs.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register/owner', [AuthController::class, 'showOwnerRegisterForm'])->name('register.owner');
Route::post('/register/owner', [AuthController::class, 'registerOwner'])->name('register.owner');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservations/create/{terrain_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/mes-reservations', [ReservationController::class, 'history'])->name('reservations.history');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/paiement/{reservation_id}', [PaiementController::class, 'show'])->name('paiement.show');
    Route::post('/paiement/{reservation_id}', [PaiementController::class, 'process'])->name('paiement.process');
});

Route::get('/owner/dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'owner') {
        abort(403);
    }
    return app(DashboardController::class)->ownerDashboard();
})->name('owner.dashboard');

Route::post('/owner/terrains', [TerrainController::class, 'store'])->name('owner.terrains.store');
Route::post('/owner/terrains/{id}/creneaux', [CreneauController::class, 'bulkStore'])->name('owner.creneaux.bulk');
Route::patch('/owner/creneaux/{id}/toggle', [CreneauController::class, 'toggle'])->name('owner.creneaux.toggle');

Route::get('/admin/dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    return app(DashboardController::class)->adminDashboard();
})->name('admin.dashboard');