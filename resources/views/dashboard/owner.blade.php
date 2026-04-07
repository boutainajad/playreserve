@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')

<div class="mb-8">
    <div class="flex items-center justify-between bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-[#0B1526] mb-1 tracking-tight">Manage your club</h1>
            <p class="text-[15px] font-medium text-gray-500">You are currently managing <span class="font-bold text-playtomic-blue">{{ $club->name }}</span></p>
        </div>
        <div class="w-14 h-14 bg-playtomic-blue/10 rounded-full flex items-center justify-center">
            <i class="bi bi-shop text-3xl text-playtomic-blue"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up">
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-blue-50 group-hover:bg-playtomic-blue group-hover:text-white rounded-2xl flex items-center justify-center text-playtomic-blue text-2xl transition-all duration-300">
            <i class="bi bi-wallet2"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Revenue</p>
            <h4 class="text-2xl font-black text-[#0B1526]">{{ number_format($totalRevenue, 0) }} <span class="text-sm">DH</span></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-playtomic-lime/10 group-hover:bg-playtomic-lime group-hover:text-black rounded-2xl flex items-center justify-center text-playtomic-lime text-2xl transition-all duration-300">
            <i class="bi bi-calendar2-check"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Bookings</p>
            <h4 class="text-2xl font-black text-[#0B1526]">{{ $activeBookings }}</h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-orange-50 group-hover:bg-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center text-orange-500 text-2xl transition-all duration-300">
            <i class="bi bi-grid-3x3-gap"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">My Courts</p>
            <h4 class="text-2xl font-black text-[#0B1526]">{{ $terrains->count() }}</h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-purple-50 group-hover:bg-purple-600 group-hover:text-white rounded-2xl flex items-center justify-center text-purple-600 text-2xl transition-all duration-300">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Users</p>
            <h4 class="text-2xl font-black text-[#0B1526]">{{ $reservations->pluck('user_id')->unique()->count() }}</h4>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-grid-3x3-gap-fill text-playtomic-blue"></i> My Courts
        </h3>
        <button onclick="document.getElementById('addTerrainModal').classList.remove('hidden')" class="px-5 py-2.5 bg-playtomic-blue hover:bg-blue-700 text-white font-bold rounded-full text-[13px] transition-colors shadow-md shadow-playtomic-blue/20 flex items-center gap-2 cursor-pointer">
            <i class="bi bi-plus-lg"></i> Add Court
        </button>
    </div>
    
    <div class="p-6">
        @if($terrains->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($terrains as $terrain)
                    <div class="bg-white border border-gray-100 rounded-[32px] p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative group shadow-sm">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h5 class="font-black text-[#0B1526] text-xl mb-1">{{ $terrain->name }}</h5>
                                <div class="text-[11px] font-black text-playtomic-blue uppercase tracking-widest flex items-center gap-1.5">
                                    @if($terrain->sport_type == 'football') ⚽
                                    @elseif($terrain->sport_type == 'basketball') 🏀
                                    @elseif($terrain->sport_type == 'volleyball') 🏐
                                    @elseif($terrain->sport_type == 'tennis') 🎾
                                    @elseif($terrain->sport_type == 'padel') 🎯
                                    @else 🎯 @endif
                                    {{ $terrain->sport_type }}
                                </div>
                            </div>
                            @if($terrain->is_available)
                                <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide border border-green-100">Active</span>
                            @else
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide border border-red-100">Inactive</span>
                            @endif
                        </div>
                        
                        <div class="mb-8 p-5 bg-[#F9FAFC] rounded-24">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-[#0B1526]">{{ number_format($terrain->price_per_hour, 0) }}</span>
                                <span class="text-sm font-bold text-gray-400">DH / HOUR</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto space-y-4">
                            <div class="flex items-center justify-between text-sm font-medium text-gray-500 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                                <span class="flex items-center gap-2"><i class="bi bi-calendar3"></i> Slots</span>
                                <span class="font-black text-[#0B1526]">{{ $terrain->creneaux->count() }}</span>
                            </div>
                            
                            <button onclick="openSlotModal('{{ $terrain->id }}', '{{ $terrain->name }}')" class="w-full py-4 bg-white hover:bg-playtomic-blue hover:text-white border-2 border-gray-100 hover:border-playtomic-blue rounded-24 text-[14px] font-black text-[#0B1526] transition-all flex items-center justify-center gap-2 shadow-sm">
                                <i class="bi bi-gear-fill"></i> MANAGE SLOTS
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-grid-3x3-gap-fill text-3xl text-gray-300"></i>
                </div>
                <h4 class="text-[#0B1526] font-bold text-lg mb-2">No courts configured</h4>
                <p class="text-gray-500 text-sm mb-6">You haven't added any courts to your club yet.</p>
            </div>
        @endif
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-12">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-journal-check text-playtomic-blue"></i> Recent Bookings
        </h3>
    </div>
    <div class="p-0 overflow-x-auto">
        @if($reservations->count() > 0)
            <div class="overflow-hidden bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] uppercase font-black text-gray-400 tracking-widest">
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Member</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Terrain</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Date & Time</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100 text-right">Amount</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reservations as $res)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-playtomic-blue text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ strtoupper(substr($res->user->name, 0, 1)) }}
                                        </div>
                                        <div class="font-bold text-[#0B1526] text-[15px]">{{ $res->user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-semibold text-gray-500 text-[14px]">
                                    {{ $res->terrain->name }}
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-black text-[#0B1526]">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</div>
                                    <div class="text-[12px] font-bold text-playtomic-blue mt-0.5">{{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}</div>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-[#0B1526] text-base">
                                    {{ number_format($res->total_price, 0) }} <span class="text-[11px] text-gray-400">DH</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        @if($res->status == 'confirmed')
                                            <span class="px-3 py-1.5 bg-green-50 text-green-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-green-100">CONFIRMED</span>
                                        @elseif($res->status == 'pending')
                                            <span class="px-3 py-1.5 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-orange-100">PENDING</span>
                                        @else
                                            <span class="px-3 py-1.5 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-red-100 uppercase">{{ $res->status }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center text-gray-400 font-medium italic">
                No recent bookings to display.
            </div>
        @endif
    </div>
</div>

<div id="slotModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-xl shadow-2xl overflow-hidden animate-fadeInUp">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
            <div>
                <h3 class="text-[#0B1526] font-black text-2xl mb-1">Manage Slots</h3>
                <p id="modalTerrainName" class="text-sm font-bold text-playtomic-blue uppercase tracking-wider"></p>
            </div>
            <button onclick="document.getElementById('slotModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8">
            <form id="bulkSlotForm" action="" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-3">Select Days</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <label class="cursor-pointer group">
                                <input type="checkbox" name="days[]" value="{{ $day }}" checked class="peer hidden">
                                <div class="px-4 py-2 bg-gray-100 peer-checked:bg-playtomic-blue peer-checked:text-white rounded-full text-[13px] font-bold transition-all group-hover:scale-105 active:scale-95">
                                    {{ substr($day, 0, 3) }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Opening Time</label>
                        <input type="time" name="start_time" value="08:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Closing Time</label>
                        <input type="time" name="end_time" value="22:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Slot Duration (Minutes)</label>
                    <select name="duration" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none">
                        <option value="60">60 Minutes (1h)</option>
                        <option value="30">30 Minutes</option>
                        <option value="45">45 Minutes</option>
                        <option value="90">90 Minutes (1h30)</option>
                        <option value="120">120 Minutes (2h)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                    Generate Weekly Slots
                </button>
            </form>
        </div>
    </div>
</div>

<div id="addTerrainModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden animate-fadeInUp">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
            <h3 class="text-[#0B1526] font-black text-2xl">Add Court</h3>
            <button onclick="document.getElementById('addTerrainModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8">
            <form action="{{ route('owner.terrains.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Court Name</label>
                    <input type="text" name="name" required placeholder="e.g. Central Court" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>
                
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Sport Type</label>
                    <div class="relative">
                        <select name="sport_type" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none cursor-pointer">
                            <option value="football">⚽ Football</option>
                            <option value="basketball">🏀 Basketball</option>
                            <option value="tennis">🎾 Tennis</option>
                            <option value="volleyball">🏐 Volleyball</option>
                            <option value="handball">🤾 Handball</option>
                            <option value="piscine">🏊 Swimming</option>
                            <option value="padel">🎯 Padel</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Price per Hour (DH)</label>
                    <input type="number" name="price_per_hour" step="0.01" min="0" required placeholder="0" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold text-xl">
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="LED lighting, synthetic grass..." class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium"></textarea>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30">
                    Add Court
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openSlotModal(id, name) {
        const modal = document.getElementById('slotModal');
        const form = document.getElementById('bulkSlotForm');
        const nameDisplay = document.getElementById('modalTerrainName');
        
        nameDisplay.innerText = name;
        form.action = `/owner/terrains/${id}/creneaux`;
        modal.classList.remove('hidden');
    }
</script>
@endpush

@endsection