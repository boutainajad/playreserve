<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;
    
    protected $table = 'creneaux';
    
    protected $fillable = [
        'terrain_id', 'day_of_week', 'start_time', 'end_time', 'is_available'
    ];
    
    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }
}