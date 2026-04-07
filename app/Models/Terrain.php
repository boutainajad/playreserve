<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sport_type', 'description', 'price_per_hour', 'is_available', 'club_id', 'image'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function creneaux()
    {
        return $this->hasMany(Creneau::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}