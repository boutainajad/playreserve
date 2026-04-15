<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $fillable = [
        'user_id',
        'terrain_id',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'notified_at',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }
}
