@extends('layouts.karyawan')

@section('content')
<div class="relative z-10 px-6 pb-10">

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Welcome Banner (vivid gradient + illustration)                    --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="relative rounded-3xl overflow-hidden mb-6 shadow-lg"
         style="background: linear-gradient(135deg, #1E40AF 0%, #2563EB 50%, #60A5FA 100%); min-height: 160px;">
        {{-- decorative circles --}}
        <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-10"
             style="background: radial-gradient(circle, #fff 0%, transparent 70%); transform: translate(30%, -30%);"></div>
        <div class="absolute bottom-0 left-1/3 w-48 h-48 rounded-full opacity-5"
             style="background: radial-gradient(circle, #fff 0%, transparent 70%); transform: translateY(40%);"></div>

        <div class="relative z-10 p-7 flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">👋</span>
                    <span class="text-blue-200 text-sm font-medium">Selamat Datang,</span>
                </div>
                <h1 class="text-4xl font-black text-white mb-2 leading-tight">{{ auth()->user()->name }}</h1>
                <p class="text-blue-200 text-sm max-w-sm leading-relaxed">
                    Kelola pemesanan ruang meeting, ruang kerja, dan fasilitas lainnya<br>dengan mudah dan cepat.
                </p>
            </div>

            {{-- Hari yang baik card --}}
            <div class="hidden md:flex items-center gap-4">
                {{-- Illustration placeholder --}}
                <div class="opacity-80">
                    <svg width="140" height="100" viewBox="0 0 140 100" fill="none">
                        <rect x="20" y="35" width="80" height="55" rx="6" fill="white" fill-opacity="0.15" stroke="white" stroke-opacity="0.4" stroke-width="1.5"/>
                        <rect x="28" y="43" width="64" height="39" rx="3" fill="white" fill-opacity="0.08"/>
                        <rect x="36" y="52" width="38" height="3" rx="1.5" fill="white" fill-opacity="0.5"/>
                        <rect x="36" y="60" width="50" height="2" rx="1" fill="white" fill-opacity="0.3"/>
                        <rect x="36" y="67" width="44" height="2" rx="1" fill="white" fill-opacity="0.3"/>
                        <rect x="36" y="74" width="30" height="2" rx="1" fill="white" fill-opacity="0.2"/>
                        <rect x="90" y="55" width="25" height="35" rx="3" fill="white" fill-opacity="0.12" stroke="white" stroke-opacity="0.25"/>
                        <circle cx="103" cy="45" r="12" fill="white" fill-opacity="0.18" stroke="white" stroke-opacity="0.3" stroke-width="1"/>
                        <ellipse cx="102" cy="93" rx="18" ry="6" fill="white" fill-opacity="0.1"/>
                        {{-- Plant --}}
                        <ellipse cx="55" cy="95" rx="12" ry="5" fill="white" fill-opacity="0.1"/>
                        <rect x="53" y="75" width="4" height="22" rx="2" fill="white" fill-opacity="0.2"/>
                        <ellipse cx="52" cy="76" rx="8" ry="11" fill="white" fill-opacity="0.15" transform="rotate(-15 52 76)"/>
                        <ellipse cx="62" cy="75" rx="7" ry="10" fill="white" fill-opacity="0.12" transform="rotate(15 62 75)"/>
                        {{-- Coffee mug --}}
                        <rect x="28" y="80" width="18" height="14" rx="3" fill="white" fill-opacity="0.18" stroke="white" stroke-opacity="0.3" stroke-width="1"/>
                        <path d="M46 85 Q52 85 52 89 Q52 93 46 93" stroke="white" stroke-opacity="0.4" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-4 text-white text-center min-w-36">
                    <i class="fa-regular fa-calendar-check text-2xl mb-1.5 block text-blue-200"></i>
                    <p class="font-bold text-sm">Hari yang baik</p>
                    <p class="text-[10px] text-blue-200">untuk produktivitas bersama!</p>
                    <span class="text-xl mt-1 block">☀️</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Stat Cards (colorful, with trend label)                           --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        {{-- Total Booking --}}
        <div class="rounded-2xl p-5 text-white relative overflow-hidden shadow-lg"
             style="background: linear-gradient(135deg, #2563EB, #3B82F6);">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-xl"></i>
                </div>
                <i class="fa-regular fa-calendar-check text-white/20 text-4xl absolute -right-2 top-0"></i>
            </div>
            <div class="relative z-10">
                <p class="text-blue-100 text-xs font-medium mb-1">Total Booking Saya</p>
                <h3 class="text-4xl font-black leading-none mb-1.5">{{ $myBookings }}</h3>
                <p class="text-blue-200 text-[10px] font-medium">📅 Semua booking</p>
            </div>
        </div>

        {{-- Booking Terkonfirmasi --}}
        <div class="rounded-2xl p-5 text-white relative overflow-hidden shadow-lg"
             style="background: linear-gradient(135deg, #059669, #10B981);">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-green-100 text-xs font-medium mb-1">Booking Terkonfirmasi</p>
                <h3 class="text-4xl font-black leading-none mb-1.5">{{ $approvedBookings }}</h3>
                <p class="text-green-200 text-[10px] font-medium">✅ Disetujui</p>
            </div>
            <i class="fa-solid fa-circle-check absolute -right-3 -bottom-3 text-7xl text-white/10"></i>
        </div>

        {{-- Menunggu Approval --}}
        <div class="rounded-2xl p-5 text-white relative overflow-hidden shadow-lg"
             style="background: linear-gradient(135deg, #D97706, #F59E0B);">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-regular fa-clock text-xl"></i>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-amber-100 text-xs font-medium mb-1">Menunggu Approval</p>
                <h3 class="text-4xl font-black leading-none mb-1.5">{{ $pendingBookings }}</h3>
                <p class="text-amber-200 text-[10px] font-medium">⏳ Menunggu admin</p>
            </div>
            <i class="fa-solid fa-hourglass-half absolute -right-3 -bottom-3 text-7xl text-white/10"></i>
        </div>

        {{-- Total Ruangan --}}
        <div class="rounded-2xl p-5 text-white relative overflow-hidden shadow-lg"
             style="background: linear-gradient(135deg, #7C3AED, #8B5CF6);">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-door-open text-xl"></i>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-purple-100 text-xs font-medium mb-1">Total Ruangan</p>
                <h3 class="text-4xl font-black leading-none mb-1.5">{{ $totalRooms }}</h3>
                <p class="text-purple-200 text-[10px] font-medium">🏢 Tersedia</p>
            </div>
            <i class="fa-solid fa-building absolute -right-3 -bottom-3 text-7xl text-white/10"></i>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Main Content Grid (3 columns)                                     --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ── Left Column ─────────────────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Buat Booking Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 relative overflow-hidden">
                <div class="flex items-center gap-3 mb-3 relative z-10">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-sm shadow-blue-200">
                        <i class="fa-solid fa-calendar-plus text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-sm">Buat Booking Ruangan</h2>
                </div>
                <p class="text-xs text-gray-500 mb-4 relative z-10">Pesan ruangan untuk kebutuhan meeting, kerja tim, atau keperluan lainnya.</p>

                {{-- Illustration --}}
                <div class="absolute right-3 top-3 opacity-70">
                    <svg width="80" height="60" viewBox="0 0 80 60" fill="none">
                        <rect x="5" y="10" width="50" height="38" rx="5" fill="#EFF6FF" stroke="#DBEAFE" stroke-width="1.5"/>
                        <rect x="13" y="18" width="34" height="3" rx="1.5" fill="#93C5FD"/>
                        <rect x="13" y="25" width="26" height="2" rx="1" fill="#BFDBFE"/>
                        <rect x="13" y="30" width="30" height="2" rx="1" fill="#BFDBFE"/>
                        <circle cx="58" cy="45" r="14" fill="#22C55E" fill-opacity="0.2" stroke="#22C55E" stroke-width="1.5"/>
                        <path d="M53 45l3 3 7-7" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <a href="{{ route('karyawan.booking.index') }}"
                   class="relative z-10 flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm shadow-blue-200">
                    <i class="fa-solid fa-plus"></i> Buat Booking
                    <i class="fa-solid fa-arrow-right text-xs opacity-70"></i>
                </a>
            </div>

            {{-- Kalender Mini --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-calendar-days text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm">Kalender Ruangan</h3>
                </div>
                <p class="text-[10px] text-gray-500 mb-4 ml-10">Lihat ketersediaan ruangan dalam satu bulan.</p>

                @php
                    $now = \Carbon\Carbon::now();
                    $monthStart = $now->copy()->startOfMonth();
                    $monthEnd   = $now->copy()->endOfMonth();
                    $firstDow   = ($monthStart->dayOfWeek + 6) % 7; // Mon=0
                    $daysInMonth = $monthEnd->day;
                @endphp

                <div class="flex justify-between items-center mb-3">
                    <button class="text-gray-400 hover:text-blue-600 p-1 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <h3 class="font-bold text-gray-700 text-xs">{{ $now->translatedFormat('F Y') }}</h3>
                    <button class="text-gray-400 hover:text-blue-600 p-1 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <div class="grid grid-cols-7 gap-0.5 text-center text-[10px] mb-2 font-semibold">
                    @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $d)
                    <div class="text-gray-400 py-1">{{ $d }}</div>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-0.5 text-center text-xs">
                    @for($i = 0; $i < $firstDow; $i++)
                        <div></div>
                    @endfor
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $isToday = $day == $now->day;
                            $classes = $isToday
                                ? 'h-6 w-6 mx-auto flex items-center justify-center rounded-full bg-blue-600 text-white font-bold shadow-sm text-[10px]'
                                : 'h-6 w-6 mx-auto flex items-center justify-center rounded-full text-gray-600 hover:bg-blue-50 cursor-pointer transition-colors text-[10px]';
                        @endphp
                        <div class="{{ $classes }}">{{ $day }}</div>
                    @endfor
                </div>
                <div class="flex items-center justify-center gap-4 mt-4 text-[9px] text-gray-500">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-blue-600 inline-block"></span> Hari ini
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Ada booking
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Middle Column ────────────────────────────────────────────── --}}
        <div class="space-y-5">
            {{-- Status Booking Saya --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-clipboard-list text-xs"></i>
                        </div>
                        Status Booking Saya
                    </h3>
                    <a href="{{ route('karyawan.booking-saya.index') }}" class="text-[10px] text-blue-600 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                <div class="space-y-2">
                    @php
                        $statusItems = [
                            ['label'=>'Menunggu Approval','count'=>$pendingBookings,'icon'=>'fa-clock','bg'=>'bg-orange-50','text'=>'text-orange-500','dot'=>'bg-orange-400'],
                            ['label'=>'Terkonfirmasi',    'count'=>$approvedBookings,'icon'=>'fa-circle-check','bg'=>'bg-green-50','text'=>'text-green-500','dot'=>'bg-green-500'],
                            ['label'=>'Selesai',          'count'=>$usedBookings,   'icon'=>'fa-check-double','bg'=>'bg-blue-50','text'=>'text-blue-500','dot'=>'bg-blue-500'],
                            ['label'=>'Ditolak/Dibatalkan','count'=>$rejectedBookings,'icon'=>'fa-xmark','bg'=>'bg-pink-50','text'=>'text-pink-500','dot'=>'bg-pink-500'],
                        ];
                    @endphp
                    @foreach($statusItems as $item)
                    <div class="flex items-center justify-between p-2.5 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $item['bg'] }} {{ $item['text'] }} flex items-center justify-center shrink-0">
                                <i class="fa-regular {{ $item['icon'] }} text-xs"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">{{ $item['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-gray-800">{{ $item['count'] }}</span>
                            <i class="fa-solid fa-chevron-right text-[9px] text-gray-300"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Ruangan Populer --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <div class="w-8 h-8 bg-yellow-50 text-yellow-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-star text-xs"></i>
                        </div>
                        Ruangan Populer
                    </h3>
                    <a href="{{ route('karyawan.booking.index') }}" class="text-[10px] text-blue-600 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @forelse($popularRooms as $room)
                    @php
                        $bgColors = ['bg-blue-500','bg-teal-500','bg-purple-500','bg-orange-500'];
                        $icons    = ['fa-door-open','fa-people-group','fa-chalkboard','fa-desktop'];
                        $idx = $room->id % 4;
                    @endphp
                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 hover:border-blue-200 transition-all">
                        <div class="w-10 h-10 rounded-xl {{ $bgColors[$idx] }} flex items-center justify-center mb-2">
                            <i class="fa-solid {{ $icons[$idx] }} text-white text-sm"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-800 leading-tight mb-0.5">{{ $room->name }}</h4>
                        <p class="text-[9px] text-gray-500 mb-2">Kapasitas {{ $room->capacity }} orang</p>
                        <a href="{{ route('karyawan.booking.index') }}"
                           class="block text-center bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white text-[10px] font-bold px-2 py-1 rounded-lg transition-all">
                            Booking
                        </a>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-4">
                        <i class="fa-solid fa-building text-2xl text-gray-200 mb-1 block"></i>
                        <p class="text-xs text-gray-400">Belum ada ruangan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Right Column ─────────────────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Notifikasi Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-bell text-xs"></i>
                        </div>
                        Notifikasi Terbaru
                    </h3>
                    <a href="{{ route('karyawan.notifikasi') }}" class="text-[10px] text-blue-600 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($notifications as $notif)
                    @php
                        $isApproved = str_contains(strtolower($notif->message), 'disetujui') || str_contains(strtolower($notif->message), 'konfirmasi');
                        $isRejected = str_contains(strtolower($notif->message), 'ditolak');
                        $nBg   = $isApproved ? 'bg-green-50'  : ($isRejected ? 'bg-pink-50'   : 'bg-blue-50');
                        $nText = $isApproved ? 'text-green-500': ($isRejected ? 'text-pink-500' : 'text-blue-500');
                        $nIcon = $isApproved ? 'fa-check'      : ($isRejected ? 'fa-xmark'     : 'fa-bell');
                    @endphp
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="w-8 h-8 rounded-full {{ $nBg }} {{ $nText }} flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid {{ $nIcon }} text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="text-xs font-bold text-gray-800 leading-tight">{{ $notif->title ?? 'Notifikasi' }}</h4>
                                <span class="text-[9px] text-gray-400 whitespace-nowrap shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">{{ Str::limit($notif->message, 70) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <i class="fa-solid fa-bell-slash text-3xl text-gray-200 mb-2 block"></i>
                        <p class="text-xs text-gray-400">Belum ada notifikasi.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Booking Terakhir --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal-50 text-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                        </div>
                        Booking Terakhir
                    </h3>
                    <a href="{{ route('karyawan.booking-saya.index') }}" class="text-[10px] text-blue-600 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentBookings as $rb)
                    @php
                        $rbColors = [
                            'menunggu_approval' => ['bg'=>'bg-orange-50','text'=>'text-orange-600','border'=>'border-orange-100','dot'=>'bg-orange-400','label'=>'Menunggu Approval'],
                            'disetujui'         => ['bg'=>'bg-green-50', 'text'=>'text-green-600', 'border'=>'border-green-100', 'dot'=>'bg-green-500', 'label'=>'Terkonfirmasi'],
                            'selesai'           => ['bg'=>'bg-blue-50',  'text'=>'text-blue-600',  'border'=>'border-blue-100',  'dot'=>'bg-blue-500',  'label'=>'Selesai'],
                            'ditolak'           => ['bg'=>'bg-pink-50',  'text'=>'text-pink-600',  'border'=>'border-pink-100',  'dot'=>'bg-pink-500',  'label'=>'Ditolak'],
                            'dibatalkan'        => ['bg'=>'bg-gray-50',  'text'=>'text-gray-500',  'border'=>'border-gray-100',  'dot'=>'bg-gray-400',  'label'=>'Dibatalkan'],
                        ];
                        $rbC = $rbColors[$rb->status] ?? $rbColors['menunggu_approval'];
                        $roomBgs = ['bg-blue-500','bg-teal-500','bg-purple-500','bg-orange-500','bg-pink-500','bg-indigo-500'];
                        $roomIcons = ['fa-door-open','fa-people-group','fa-chalkboard','fa-desktop','fa-briefcase','fa-building'];
                        $colorIdx = ($rb->room_id ?? 0) % 6;
                    @endphp
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl {{ $roomBgs[$colorIdx] }} flex items-center justify-center shrink-0">
                                <i class="fa-solid {{ $roomIcons[$colorIdx] }} text-white text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800">{{ $rb->room->name ?? 'Ruangan Dihapus' }}</h4>
                                <p class="text-[9px] text-gray-500 mt-0.5">
                                    {{ \Carbon\Carbon::parse($rb->date)->format('d M Y') }}
                                    • {{ \Carbon\Carbon::parse($rb->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($rb->end_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full {{ $rbC['bg'] }} {{ $rbC['text'] }} text-[9px] font-semibold border {{ $rbC['border'] }} flex items-center gap-1 whitespace-nowrap">
                            <span class="w-1 h-1 rounded-full {{ $rbC['dot'] }}"></span>
                            {{ $rbC['label'] }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <i class="fa-solid fa-calendar-xmark text-3xl text-gray-200 mb-2 block"></i>
                        <p class="text-xs text-gray-400">Belum ada riwayat booking.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection