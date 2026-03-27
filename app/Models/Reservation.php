<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'creneau_id',
        'montant_total',
        'statut',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}