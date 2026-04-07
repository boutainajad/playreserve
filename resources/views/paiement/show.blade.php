@extends('layouts.app')

@section('title', 'Payment')

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
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-playtomic-blue"></div>
                
                <h3 class="text-[#0B1526] font-black text-xl mb-8 flex items-center gap-2">
                    <i class="bi bi-credit-card-2-back text-playtomic-blue"></i> Payment Method
                </h3>

                <form method="POST" action="{{ route('paiement.process', $reservation->id) }}" class="space-y-6">
                    @csrf
                    
                    <div class="group">
                        <label class="block text-[12px] uppercase tracking-widest font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Card Number</label>
                        <div class="relative">
                            <input type="text" name="card_number" 
                                   class="w-full px-6 py-4 bg-[#f4f5f7] border-2 border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-0 focus:border-playtomic-blue font-black text-lg transition-all" 
                                   placeholder="0000 0000 0000 0000" maxlength="16" required>
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 flex gap-2">
                                <i class="bi bi-credit-card text-gray-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[12px] uppercase tracking-widest font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">CVV</label>
                            <div class="relative">
                                <input type="text" name="cvv" 
                                       class="w-full px-6 py-4 bg-[#f4f5f7] border-2 border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-0 focus:border-playtomic-blue font-black text-lg transition-all" 
                                       placeholder="123" maxlength="3" required>
                                <i class="bi bi-lock absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-[12px] uppercase tracking-widest font-black text-gray-400 mb-2 transition-colors group-focus-within:text-playtomic-blue">Expires</label>
                            <div class="relative">
                                <input type="text" name="expiry_date" 
                                       class="w-full px-6 py-4 bg-[#f4f5f7] border-2 border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-0 focus:border-playtomic-blue font-black text-lg transition-all" 
                                       placeholder="MM / YY" required>
                                <i class="bi bi-calendar-event absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-playtomic-blue text-white font-black rounded-2xl transition-all shadow-lg shadow-playtomic-blue/30 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0.5 flex items-center justify-center gap-3 text-lg">
                            Pay {{ number_format($reservation->total_price, 0) }} DH <i class="bi bi-arrow-right font-black"></i>
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
@endsection