@php
$currentRoute = Route::currentRouteName();
@endphp
<div class="flex flex-col shrink-0 bg-gradient-to-b from-[#2563EB] to-[#1D4ED8] text-white border-r border-blue-600 relative z-40 overflow-hidden shadow-xl whitespace-nowrap"
     :class="[
         sidebarOpen ? 'w-72 translate-x-0' : 'w-0 -translate-x-full opacity-0',
         sidebarReady ? 'transition-all duration-300' : ''
     ]">

    <!-- Top Header -->
    <div class="flex items-center px-6 h-20 pt-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                <i class="fa-regular fa-calendar-check text-blue-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-bold text-xl leading-tight">RuangHub</h1>
                <p class="text-xs text-blue-200">Room Booking System</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="overflow-y-auto overflow-x-hidden flex-grow mt-6 px-4 scrollbar-hide pb-32" @click.stop>
        <ul class="flex flex-col space-y-1">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $currentRoute == 'admin.dashboard' ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ruangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ Str::startsWith($currentRoute, 'ruangan.') ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-solid fa-door-open w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Data Ruangan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ Str::startsWith($currentRoute, 'user.') ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-regular fa-user w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Data User</span>
                </a>
            </li>
            <li>
                <a href="{{ route('booking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ Str::startsWith($currentRoute, 'booking.') ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-regular fa-calendar-alt w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Data Booking</span>
                </a>
            </li>
            <li>
                <a href="{{ route('approval.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ Str::startsWith($currentRoute, 'approval.') ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-solid fa-check-circle w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Approval</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kalender') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $currentRoute == 'admin.kalender' ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-regular fa-calendar w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Kalender Ruangan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $currentRoute == 'admin.laporan' ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-solid fa-chart-simple w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Laporan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $currentRoute == 'admin.profil.index' ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-regular fa-user w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Profil Saya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $currentRoute == 'admin.pengaturan' ? 'bg-white/20 font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span class="text-sm tracking-wide">Pengaturan Sistem</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Bottom Illustration & Text -->
    <div class="absolute bottom-0 w-full">
        <!-- SVG wave/gradient overlay representing the design -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full absolute bottom-0 z-0 opacity-50"><path fill="#ffffff" fill-opacity="0.2" d="M0,192L48,181.3C96,171,192,149,288,144C384,139,480,149,576,170.7C672,192,768,224,864,229.3C960,235,1056,213,1152,192C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
        <div class="relative z-10 px-6 pb-6 pt-10">
            <h3 class="font-bold text-sm mb-1 text-white">Ruang yang tepat</h3>
            <p class="text-xs text-blue-200">untuk Produktivitas Bersama</p>
            <div class="w-8 h-1 bg-white/40 mt-3 rounded-full"></div>
            <div class="w-4 h-1 bg-white/20 mt-1 rounded-full"></div>
        </div>
    </div>
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>