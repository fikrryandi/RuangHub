@extends('layouts.karyawan')

@section('content')
<div class="relative z-10 px-8 pb-10">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 shadow-sm border border-blue-200 mb-6 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
        <div class="z-10 flex items-center gap-4 flex-1">
            <div class="bg-blue-600 text-white p-3 rounded-xl shadow-sm shadow-blue-200">
                <i class="fa-solid fa-bell text-3xl"></i>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-bold mb-1 tracking-wide">Halo, {{ auth()->user()->name }}</p>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Notifikasi</h1>
                <p class="text-sm text-gray-600">Berikut adalah notifikasi terbaru terkait aktivitas dan informasi dari sistem.</p>
            </div>
        </div>
        <div class="z-10 mt-4 md:mt-0 relative mr-12 hidden md:block">
            <div class="bg-white/80 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/50 shadow-sm text-xs font-bold text-blue-600">
                Tetap terhubung<br>dengan informasi terbaru!
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 flex items-center justify-end pr-6 opacity-50 pointer-events-none">
            <i class="fa-solid fa-mobile-screen-button text-9xl text-blue-300"></i>
        </div>
    </div>

    <!-- Notification List Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Tabs & Actions -->
        <div class="p-4 border-b border-gray-100 flex flex-wrap gap-4 items-center justify-between bg-gray-50/30">
            <div class="flex items-center gap-2">
                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-sm shadow-blue-200 transition-colors">
                    Semua <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px]">{{ $notifications->total() }}</span>
                </button>
                <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <i class="fa-regular fa-calendar-check text-blue-500"></i> Booking
                </button>
                <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-gear text-teal-500"></i> Sistem
                </button>
            </div>
            <span class="text-xs text-teal-600 font-medium bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-100">
                <i class="fa-solid fa-check-double text-xs"></i> Semua ditandai telah dibaca
            </span>
        </div>

        <!-- List -->
        <div class="divide-y divide-gray-50">
            @forelse($notifications as $n)
            @php
                $typeConfig = match($n->type) {
                    'booking'  => ['color' => 'blue',   'icon' => 'fa-calendar-check'],
                    'approval' => ['color' => 'purple', 'icon' => 'fa-check-double'],
                    'sistem'   => ['color' => 'teal',   'icon' => 'fa-gear'],
                    default    => ['color' => 'orange', 'icon' => 'fa-circle-info'],
                };
            @endphp
            <div class="p-5 flex items-center justify-between hover:bg-gray-50 transition-colors cursor-pointer group
                        {{ !$n->is_read ? 'bg-blue-50/20' : '' }}"
                 @if($n->link) onclick="window.location='{{ $n->link }}'" @endif>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-{{ $typeConfig['color'] }}-50 text-{{ $typeConfig['color'] }}-500 flex items-center justify-center shrink-0 border border-{{ $typeConfig['color'] }}-100 group-hover:scale-110 transition-transform">
                        <i class="fa-solid {{ $typeConfig['icon'] }} text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-800 mb-1">{{ $n->title }}</h4>
                        <p class="text-xs text-gray-500 max-w-3xl leading-relaxed">{{ $n->message }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 shrink-0 ml-4">
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-medium">{{ $n->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $n->created_at->format('H:i') }}</p>
                    </div>
                    @if(!$n->is_read)
                        <div class="w-2.5 h-2.5 bg-blue-600 rounded-full shrink-0"></div>
                    @else
                        <div class="w-2.5 h-2.5 shrink-0"></div>
                    @endif
                    <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors text-sm"></i>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="flex flex-col items-center gap-3 text-gray-400">
                    <i class="fa-regular fa-bell-slash text-5xl text-blue-200"></i>
                    <p class="text-sm font-medium">Belum ada notifikasi</p>
                    <p class="text-xs text-gray-400">Notifikasi terkait booking dan aktivitas akan muncul di sini.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="p-4 border-t border-gray-100 flex items-center justify-center bg-gray-50/50">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
