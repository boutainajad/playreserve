@extends('layouts.app')

@section('title', 'Payment')

@push('styles')
<script src="https://js.stripe.com/v3/"></script>
<style>
    .card-input-wrapper {
        width: 100%;
        padding: 14px 18px;
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.2s ease;
        position: relative;
        z-index: 10;
        cursor: text;
    }
    .card-input-wrapper.focused {
        border-color: #3461ff;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(52, 97, 255, 0.1);
    }
    .card-input-wrapper.invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    .stripe-element-container {
        min-height: 24px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-8">
    
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-[#0B1526] tracking-tight mb-2 flex items-center justify-center gap-3">
            <i class="bi bi-shield-check text-playtomic-lime"></i> Secure Checkout
        </h1>
        <p class="text-gray-500 font-medium">Complete your reservation by providing your payment details.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start animate-fade-in-up">
        
        <div class="lg:col-span-3">
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-playtomic-blue rounded-t-[32px]"></div>
                
                <h3 class="text-[#0B1526] font-black text-xl mb-8 flex items-center gap-2">
                    <i class="bi bi-credit-card-2-back text-playtomic-blue"></i> Payment Method
                </h3>

                <form id="payment-form" method="POST" action="{{ route('paiement.process', $reservation->id) }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="payment_intent_id" id="payment_intent_id">
                    
                    @if($isMock)
                        <div class="space-y-6 animate-fade-in">
                            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 mb-6 flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <i class="bi bi-info-circle-fill"></i>
                                </div>
                                <p class="text-xs text-blue-800 font-medium">
                                    <span class="font-bold">Sandbox Mode:</span> Use any test card details (e.g. 4242...) to complete this simulation.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5">
                                <div class="relative group">
                                    <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Card Number</label>
                                    <div class="relative">
                                        <input type="text" id="mock-card-number" placeholder="0000 0000 0000 0000" maxlength="19" class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-playtomic-blue outline-none transition-all font-mono text-lg tracking-wider" required>
                                        <div class="absolute right-5 top-1/2 -translate-y-1/2 flex gap-1 pointer-events-none opacity-40">
                                            <i class="bi bi-credit-card-2-front text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-5">
                                    <div class="group">
                                        <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Expiry Date</label>
                                        <input type="text" id="mock-card-expiry" placeholder="MM / YY" maxlength="7" class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-playtomic-blue outline-none transition-all font-mono text-lg" required>
                                    </div>
                                    <div class="group">
                                        <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">CVC / CVV</label>
                                        <input type="password" id="mock-card-cvc" placeholder="***" maxlength="4" class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-playtomic-blue outline-none transition-all font-mono text-lg" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6 animate-fade-in">
                            <div class="group">
                                <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Card Number</label>
                                <div class="card-input-wrapper" id="card-number-wrapper">
                                    <div id="card-number-element" class="stripe-element-container"></div>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300" id="card-brand-icon">
                                        <i class="bi bi-credit-card-2-front text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div class="group">
                                    <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Expiry Date</label>
                                    <div class="card-input-wrapper" id="card-expiry-wrapper">
                                        <div id="card-expiry-element" class="stripe-element-container"></div>
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-[11px] uppercase tracking-[0.2em] font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">CVC / CVV</label>
                                    <div class="card-input-wrapper" id="card-cvc-wrapper">
                                        <div id="card-cvc-element" class="stripe-element-container"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="card-errors" role="alert" class="text-red-500 text-xs font-bold mt-2 text-center bg-red-50 py-2 rounded-xl hidden"></div>
                        </div>
                    @endif

                    <div class="pt-4">
                        <button id="submit-button" type="submit" class="w-full py-5 bg-playtomic-blue text-white font-black rounded-2xl transition-all shadow-lg shadow-playtomic-blue/30 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0.5 flex items-center justify-center gap-3 text-lg">
                            <span id="button-text">Pay {{ number_format($reservation->total_price, 0) }} DH</span>
                            <i class="bi bi-arrow-right font-black" id="button-icon"></i>
                            <div id="spinner" class="hidden animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></div>
                        </button>
                    </div>

                    <div class="flex items-center justify-center gap-6 mt-8 opacity-40">
                        <i class="bi bi-stripe text-2xl"></i>
                        <i class="bi bi-shield-lock-fill text-xl"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#0B1526]">Encrypted & Secure</span>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-[#F8F9FB] border border-gray-100 rounded-[32px] p-8 sticky top-28">
                <h4 class="text-[#0B1526] font-black text-lg mb-6 uppercase tracking-tight">Booking Summary</h4>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-playtomic-blue text-xl flex-shrink-0 border border-gray-100">
                             @if($reservation->terrain->sport_type == 'football') <i class="bi bi-dribbble"></i>
                             @elseif($reservation->terrain->sport_type == 'basketball') <i class="bi bi-basket"></i>
                             @else <i class="bi bi-grid-3x3-gap-fill"></i> @endif
                        </div>
                        <div>
                            <div class="text-[11px] font-black text-playtomic-blue uppercase tracking-widest mb-0.5">Court</div>
                            <div class="text-base font-bold text-[#0B1526]">{{ $reservation->terrain->name }}</div>
                            <div class="text-sm text-gray-500 font-medium">{{ $reservation->terrain->club->name }}, {{ $reservation->terrain->club->city }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-playtomic-lime text-xl flex-shrink-0 border border-gray-100">
                            <i class="bi bi-calendar-range"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-black text-playtomic-lime uppercase tracking-widest mb-0.5">Schedule</div>
                            <div class="text-base font-bold text-[#0B1526]">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('l, d M Y') }}</div>
                            <div class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500 font-bold">Base Price</span>
                            <span class="text-[#0B1526] font-bold">{{ number_format($reservation->total_price, 0) }} DH</span>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-500 font-bold">Service Fee</span>
                            <span class="text-playtomic-lime font-black">FREE</span>
                        </div>
                        
                        <div class="flex justify-between items-center bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                            <span class="text-[#0B1526] font-black">Total to pay</span>
                            <span class="text-2xl font-black text-playtomic-blue">{{ number_format($reservation->total_price, 0) }} DH</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isMock = {{ $isMock ? 'true' : 'false' }};
        const stripeKey = '{{ $stripeKey }}'.trim();
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const spinner = document.getElementById('spinner');
        const buttonIcon = document.getElementById('button-icon');
        const buttonText = document.getElementById('button-text');
        
        let stripe, elements, card;

        if (!isMock) {
            try {
                stripe = Stripe(stripeKey);
                if (!stripe) throw new Error("Stripe object could not be created.");
                
                elements = stripe.elements();
                
                const style = {
                    base: {
                        color: '#0B1526',
                        fontFamily: '"Inter", sans-serif',
                        fontSize: '16px',
                        fontWeight: '600',
                        '::placeholder': { color: '#94a3b8' }
                    },
                    invalid: {
                        color: '#ef4444'
                    }
                };

                const cardNumber = elements.create('cardNumber', { style: style, showIcon: false });
                const cardExpiry = elements.create('cardExpiry', { style: style });
                const cardCvc = elements.create('cardCvc', { style: style });

                cardNumber.mount('#card-number-element');
                cardExpiry.mount('#card-expiry-element');
                cardCvc.mount('#card-cvc-element');
                
                const setupEvents = (element, wrapperId) => {
                    const wrapper = document.getElementById(wrapperId);
                    const errorDisplay = document.getElementById('card-errors');

                    element.on('focus', () => wrapper.classList.add('focused'));
                    element.on('blur', () => wrapper.classList.remove('focused'));
                    
                    element.on('change', (event) => {
                        if (event.error) {
                            wrapper.classList.add('invalid');
                            errorDisplay.textContent = event.error.message;
                            errorDisplay.classList.remove('hidden');
                        } else {
                            wrapper.classList.remove('invalid');
                            errorDisplay.classList.add('hidden');
                        }

                        if (event.brand && wrapperId === 'card-number-wrapper') {
                            const iconContainer = document.getElementById('card-brand-icon');
                            const icon = iconContainer.querySelector('i');
                            const brands = {
                                'visa': 'bi-credit-card-2-front',
                                'mastercard': 'bi-credit-card',
                                'amex': 'bi-credit-card-2-back',
                                'unknown': 'bi-credit-card-2-front'
                            };
                            
                            const brandIcon = brands[event.brand] || brands['unknown'];
                            icon.className = `bi ${brandIcon} text-xl`;
                        }
                    });
                };

                setupEvents(cardNumber, 'card-number-wrapper');
                setupEvents(cardExpiry, 'card-expiry-wrapper');
                setupEvents(cardCvc, 'card-cvc-wrapper');

                card = cardNumber;

            } catch (error) {
                console.error("Stripe Error:", error);
                alert("Stripe Initialization Failed: " + error.message);
            }
        } else {
            const cardNumberInput = document.getElementById('mock-card-number');
            const cardExpiryInput = document.getElementById('mock-card-expiry');

            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.match(/.{1,4}/g)?.join(' ') || value;
                    e.target.value = value;
                });
            }

            if (cardExpiryInput) {
                cardExpiryInput.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 2) {
                        value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }
        }

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            buttonIcon.classList.add('hidden');
            buttonText.innerText = 'Processing...';

            if (isMock) {
                const cardNumber = document.getElementById('mock-card-number').value.replace(/\s/g, '');
                if (cardNumber.length < 16) {
                    setTimeout(() => {
                        alert('Invalid card number. Please use at least 16 digits.');
                        submitButton.disabled = false;
                        spinner.classList.add('hidden');
                        buttonIcon.classList.remove('hidden');
                        buttonText.innerText = 'Pay {{ number_format($reservation->total_price, 0) }} DH';
                    }, 500);
                    return;
                }

                setTimeout(() => {
                    document.getElementById('payment_intent_id').value = 'mock_pi_' + Math.random().toString(36).substr(2, 9);
                    form.submit();
                }, 1500);
                return;
            }

            const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: '{{ auth()->user()->name }}',
                        email: '{{ auth()->user()->email }}'
                    }
                }
            });

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                
                submitButton.disabled = false;
                spinner.classList.add('hidden');
                buttonIcon.classList.remove('hidden');
                buttonText.innerText = 'Pay {{ number_format($reservation->total_price, 0) }} DH';
            } else {
                if (paymentIntent.status === 'succeeded') {
                    document.getElementById('payment_intent_id').value = paymentIntent.id;
                    form.submit();
                }
            }
        });
    });
</script>
@endpush
@endsection