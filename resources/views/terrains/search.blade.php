@extends('layouts.app')

@section('title', 'Search Terrains')

@section('content')

<div class="mb-12 bg-white border border-gray-200 rounded-[32px] p-8 md:p-10 shadow-sm border-b-8 border-b-playtomic-blue">
    <div class="max-w-2xl">
        <h1 class="text-4xl font-black text-[#0B1526] tracking-tight mb-4">Find your court</h1>
        <p class="text-gray-500 text-[17px] font-medium mb-8">Recherchez par sport, ville, date et heure pour trouver les terrains disponibles.</p>
    </div>

    <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <input type="text" name="city" value="{{ request('city') }}" placeholder="Ville (ex: Casablanca)" 
                   class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold transition-all">
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-award-fill"></i>
            </div>
            <select name="sport_type" class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none transition-all cursor-pointer">
                <option value="">Tous les sports</option>
                <option value="football" {{ request('sport_type') == 'football' ? 'selected' : '' }}>⚽ Football</option>
                <option value="basketball" {{ request('sport_type') == 'basketball' ? 'selected' : '' }}>🏀 Basketball</option>
                <option value="padel" {{ request('sport_type') == 'padel' ? 'selected' : '' }}>🎾 Padel</option>
                <option value="tennis" {{ request('sport_type') == 'tennis' ? 'selected' : '' }}>🎾 Tennis</option>
            </select>
            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue">
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-calendar-event-fill"></i>
            </div>
            <input type="date" name="date" value="{{ request('date') }}" min="{{ date('Y-m-d') }}"
                   class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold transition-all">
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-clock-fill"></i>
            </div>
            <input type="time" name="time" value="{{ request('time') }}" step="1800"
                   class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold transition-all">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                Chercher
            </button>
            @if(request()->anyFilled(['city', 'sport_type', 'date', 'time']))
                <a href="{{ route('search') }}" class="w-14 bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 font-bold rounded-2xl flex items-center justify-center transition-all">
                    <i class="bi bi-arrow-counterclockwise text-xl"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($terrains as $terrain)
        <div class="bg-white border border-gray-200 rounded-[32px] overflow-hidden flex flex-col group relative shadow-sm hover:shadow-xl hover:translate-y-[-4px] transition-all duration-500">
            <div class="h-48 bg-playtomic-blue/5 relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                @if($terrain->image)
                    <img src="{{ Storage::url($terrain->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <i class="bi bi-record-circle text-playtomic-blue/10 text-7xl absolute animate-pulse"></i>
                @endif
                
                <div class="absolute bottom-4 left-6 flex flex-wrap gap-2 z-10">
                    <span class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider text-playtomic-blue shadow-sm border border-playtomic-blue/20 flex items-center gap-1.5">
                        <i class="bi bi-dribbble"></i> {{ $terrain->sport_type }}
                    </span>
                </div>
                
                <div class="absolute top-4 right-6 bg-playtomic-lime text-black px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm z-10">
                    {{ $terrain->club->city ?? 'Ville' }}
                </div>
            </div>

            <div class="p-8 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-2xl font-black text-[#0B1526] leading-tight mb-1">{{ $terrain->name }}</h3>
                        <p class="text-playtomic-blue font-bold text-[13px] uppercase tracking-wide">
                            <i class="bi bi-shop mr-1"></i> {{ $terrain->club->name ?? 'Club' }}
                        </p>
                    </div>
                </div>
                
                <p class="text-[15px] text-gray-500 leading-relaxed font-medium mb-6 line-clamp-2">
                    {{ $terrain->description ?? 'Aucune description disponible.' }}
                </p>
                
                <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-wider">Prix</span>
                        <span class="text-lg font-black text-[#0B1526]">
                             {{ number_format($terrain->price_per_hour, 0) }} <span class="text-xs">DH/h</span>
                        </span>
                    </div>
                    
                    @php
                        $bookUrl = route('reservations.create', $terrain->id);
                        if(request()->filled('date')) {
                            $bookUrl .= '?date=' . request('date');
                        }
                    @endphp
                    <a href="{{ $bookUrl }}" class="px-6 py-3.5 bg-playtomic-blue text-white font-black rounded-2xl text-[14px] hover:bg-blue-700 transition-all shadow-md shadow-playtomic-blue/10 flex items-center gap-2 group-hover:gap-3">
                        Book Now <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white border border-gray-100 rounded-[40px] text-center shadow-sm">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class="bi bi-search text-4xl text-gray-300"></i>
            </div>
            <h4 class="text-2xl font-black text-[#0B1526] mb-2">Aucun terrain disponible</h4>
            <p class="text-gray-500 font-medium max-w-sm">Désolé, nous n'avons trouvé aucun terrain libre pour ces critères.</p>
            <a href="{{ route('search') }}" class="mt-8 text-playtomic-blue font-black underline underline-offset-8">Réinitialiser les filtres</a>
        </div>
    @endforelse
</div>
@endsection
