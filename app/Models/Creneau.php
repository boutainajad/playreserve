<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;

    protected $fillable = [
        'terrain_id',
        'date_creneau',
        'heure_debut',
        'heure_fin',
        'statut',
    ];

    protected $casts = [
        'date_creneau' => 'date',
        'heure_debut' => 'string',
        'heure_fin' => 'string',
    ];

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}