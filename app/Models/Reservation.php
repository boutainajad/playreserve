<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'terrain_id', 'reservation_date', 'start_time', 
        'end_time', 'total_price', 'status', 'cancelled_at', 'cancellation_reason'
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}