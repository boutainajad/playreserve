<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function show($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        
        return view('paiement.show', [
            'reservation' => $reservation
        ]);
    }

    public function process(Request $request, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        
        $cardData = $request->validate([
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|size:3',
        ]);
        
        Paiement::create([
            'reservation_id' => $reservation->id,
            'amount' => $reservation->total_price,
            'status' => 'completed',
            'transaction_id' => 'TRX_' . strtoupper(uniqid()),
            'payment_method' => 'card',
            'payment_details' => json_encode([
                'last4' => substr($cardData['card_number'], -4)
            ]),
        ]);
        
        $reservation->update(['status' => 'confirmed']);
        
        return redirect()->route('dashboard')->with('success', 'Payment successful');
    }
}