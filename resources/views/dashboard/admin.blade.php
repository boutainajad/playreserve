@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 animate-fade-in-up">
    <div class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col shadow-sm hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-playtomic-blue flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
            <i class="bi bi-buildings"></i>
        </div>
        <div class="text-[#0B1526] font-black text-4xl mb-1 tracking-tight">{{ count($clubs) }}</div>
        <div class="text-[12px] font-black text-gray-400 uppercase tracking-widest">Total Clubs</div>
    </div>
    
    <div class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col shadow-sm hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 rounded-2xl bg-playtomic-lime/10 text-playtomic-lime flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
            <i class="bi bi-people"></i>
        </div>
        <div class="text-[#0B1526] font-black text-4xl mb-1 tracking-tight">{{ count($users) }}</div>
        <div class="text-[12px] font-black text-gray-400 uppercase tracking-widest">Active Users</div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col shadow-sm hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
            <i class="bi bi-calendar2-range"></i>
        </div>
        <div class="text-[#0B1526] font-black text-4xl mb-1 tracking-tight">{{ count($reservations) }}</div>
        <div class="text-[12px] font-black text-gray-400 uppercase tracking-widest">Total Matches</div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-buildings text-playtomic-blue"></i> Club Directory
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-100">
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Club Name</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">City</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Owner</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($clubs as $club)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 text-[14px] font-bold text-[#0B1526]">{{ $club->id }}</td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-[#0B1526]">{{ $club->name }}</div>
                    </td>
                    <td class="py-4 px-6 text-[14px] font-semibold text-gray-500">{{ $club->city }}</td>
                    <td class="py-4 px-6">
                        @if($club->owner)
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-playtomic-blue/10 text-playtomic-blue flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr($club->owner->name, 0, 1)) }}
                                </div>
                                <span class="text-[14px] font-semibold text-[#0B1526]">{{ $club->owner->name }}</span>
                            </div>
                        @else
                            <span class="text-[13px] font-semibold text-gray-400 italic">No Owner</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        @if($club->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wide bg-[#e6f4ea] text-[#137333]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#137333]"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wide bg-[#fce8e6] text-[#c5221f]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#c5221f]"></span> Inactive
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-3">
                            <i class="bi bi-buildings text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-[#0B1526] font-bold text-lg">No clubs found</h4>
                        <p class="text-gray-500 text-sm mt-1">There are currently no clubs registered in the system.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection