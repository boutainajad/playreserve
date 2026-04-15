<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaiementController extends Controller
{
    public function show($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);

        if ($reservation->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'This reservation cannot be paid for.');
        }

        if (config('services.stripe.mock')) {
            return view('paiement.show', [
                'reservation' => $reservation,
                'clientSecret' => 'mock_secret_' . uniqid(),
                'stripeKey' => 'mock_key',
                'isMock' => true
            ]);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $reservation->total_price * 100,
                'currency' => 'mad',
                'metadata' => ['reservation_id' => $reservation->id],
            ]);

            return view('paiement.show', [
                'reservation' => $reservation,
                'clientSecret' => $paymentIntent->client_secret,
                'stripeKey' => config('services.stripe.key'),
                'isMock' => false
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return redirect()->route('dashboard')->with('error', 'Stripe API Key error: The provided keys are invalid. Please update your .env file with real Stripe keys or set STRIPE_MOCK=true for testing.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Could not initialize payment: ' . $e->getMessage());
        }
    }

    public function process(Request $request, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        if (config('services.stripe.mock') && str_starts_with($request->payment_intent_id, 'mock_')) {
            Paiement::create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price,
                'status' => 'completed',
                'transaction_id' => $request->payment_intent_id,
                'payment_method' => 'stripe_mock',
                'payment_details' => json_encode(['mock' => true]),
            ]);

            $reservation->update(['status' => 'confirmed']);

            return redirect()->route('dashboard')->with('success', 'Demo Payment successful! Your reservation is confirmed.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status === 'succeeded') {
                Paiement::create([
                    'reservation_id' => $reservation->id,
                    'amount' => $reservation->total_price,
                    'status' => 'completed',
                    'transaction_id' => $paymentIntent->id,
                    'payment_method' => 'stripe',
                    'payment_details' => json_encode($paymentIntent),
                ]);

                $reservation->update(['status' => 'confirmed']);

                return redirect()->route('dashboard')->with('success', 'Payment successful! Your reservation is confirmed.');
            } else {
                $reservation->update(['status' => Reservation::STATUS_PAYMENT_FAILED]);
                return redirect()->back()->with('error', 'Payment failed or is still processing. The court has been released, please try again if available.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }
}