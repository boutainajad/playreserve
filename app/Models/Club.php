<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ville',
        'description',
        'statut',
    ];

    public function terrains()
    {
        return $this->hasMany(Terrain::class);
    }

    public function administrateurs()
    {
        return $this->hasMany(User::class, 'club_id');
    }
}