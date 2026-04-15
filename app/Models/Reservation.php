<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    const STATUS_PENDING        = 'pending';
    const STATUS_CONFIRMED      = 'confirmed';
    const STATUS_EXPIRED        = 'expired';
    const STATUS_CANCELLED      = 'cancelled';
    const STATUS_PAYMENT_FAILED = 'payment_failed';
    const STATUS_NO_SHOW        = 'no_show';

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

    public function isRefundable()
    {
        if (!$this->reservation_date || !$this->start_time) {
            return false;
        }
        
        $matchDateTime = \Carbon\Carbon::parse($this->reservation_date->format('Y-m-d') . ' ' . $this->start_time);
        return now()->diffInHours($matchDateTime, false) > 24;
    }

    public function calculateRefundAmount()
    {
        if (!$this->reservation_date || !$this->start_time) {
            return 0;
        }

        $matchDateTime = \Carbon\Carbon::parse($this->reservation_date->format('Y-m-d') . ' ' . $this->start_time);
        $hoursRemaining = now()->diffInHours($matchDateTime, false);

        if ($hoursRemaining > 48) {
            return (float) $this->total_price;
        } elseif ($hoursRemaining > 24) {
            return (float) $this->total_price * 0.5;
        }

        return 0;
    }
}