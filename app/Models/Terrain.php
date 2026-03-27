<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'nom',
        'type_sport',
        'prix_par_creneau',
        'estActif',
    ];

    protected $casts = [
        'estActif' => 'boolean',
        'prix_par_creneau' => 'decimal:2',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function creneaux()
    {
        return $this->hasMany(Creneau::class);
    }
}