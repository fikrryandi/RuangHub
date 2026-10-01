@extends('layouts.karyawan')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <!-- Timetable Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <!-- Toolbar: Date picker -->
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-wrap gap-3">
            <div>
                <h2 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-blue-600"></i>
                    Jadwal Pemakaian Ruangan
                </h2>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</p>
            </div>
            <form action="{{ route('karyawan.kalender') }}" method="GET" class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg bg-white shadow-sm">
                <i class="fa-regular fa-calendar text-blue-500 mr-2 text-sm"></i>
                <input type="date" name="date" value="{{ $date }}"
                       onchange="this.form.submit()"
                       class="text-sm text-gray-700 font-medium border-none focus:ring-0 p-0 cursor-pointer bg-transparent">
                <div class="flex gap-1 border-l border-gray-200 pl-2 ml-3">
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d') }}"
                            class="p-1 text-gray-400 hover:text-blue-600 transition-colors">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d') }}"
                            class="p-1 text-gray-400 hover:text-blue-600 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <a href="{{ route('karyawan.kalender', ['date' => date('Y-m-d')]) }}"
                   class="ml-3 text-[10px] bg-blue-600 text-white px-2 py-1 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                    Hari Ini
                </a>
            </form>
        </div>

        <!-- Timetable Grid -->
        <div class="flex-1 overflow-x-auto p-5">
            <div class="min-w-[800px]">
                <!-- Column Headers (Rooms) -->
                <div class="grid border-b border-gray-100 pb-3 mb-3"
                     style="grid-template-columns: 100px repeat({{ count($rooms) }}, minmax(170px, 1fr));">
                    <div class="text-xs font-semibold text-blue-600 px-2">Waktu</div>
                    @foreach($rooms as $r)
                    <div class="text-xs font-semibold text-center text-gray-700 px-2">
                        {{ $r->name }}
                        <br>
                        <span class="font-normal text-gray-400">({{ $r->capacity }} orang)</span>
                    </div>
                    @endforeach
                </div>

                <!-- Time Rows -->
                @php
                    $times = [];
                    for ($i = 7; $i <= 18; $i++) {
                        $start = sprintf('%02d:00', $i);
                        $end   = sprintf('%02d:00', $i + 1);
                        $times[] = ['label' => "$start – $end", 'start' => $start, 'end' => $end];
                    }
                @endphp

                @foreach($times as $slot)
                <div class="grid border-b border-gray-50 py-2 items-stretch"
                     style="grid-template-columns: 100px repeat({{ count($rooms) }}, minmax(170px, 1fr));">
                    <!-- Waktu -->
                    <div class="text-xs text-gray-500 flex items-center px-2 font-medium">
                        {{ $slot['label'] }}
                    </div>

                    @foreach($rooms as $r)
                    <div class="px-2 h-full">
                        @php
                            $b = $bookings->first(function ($booking) use ($r, $slot) {
                                if ($booking->room_id != $r->id) return false;
                                $bStart = \Carbon\Carbon::parse($booking->start_time)->format('H:i');
                                $bEnd   = \Carbon\Carbon::parse($booking->end_time)->format('H:i');
                                return ($bStart < $slot['end'] && $bEnd > $slot['start']);
                            });
                        @endphp

                        @if($b)
                        @php
                            $bg = $b->status == 'disetujui' ? 'bg-teal-50 border-teal-100' : ($b->status == 'menunggu_approval' ? 'bg-orange-50 border-orange-100' : 'bg-blue-50 border-blue-100');
                            $iconBg = $b->status == 'disetujui' ? 'bg-teal-500' : ($b->status == 'menunggu_approval' ? 'bg-orange-500' : 'bg-blue-500');
                            $textDark = $b->status == 'disetujui' ? 'text-teal-700' : ($b->status == 'menunggu_approval' ? 'text-orange-700' : 'text-blue-700');
                            $textLight = $b->status == 'disetujui' ? 'text-teal-600' : ($b->status == 'menunggu_approval' ? 'text-orange-600' : 'text-blue-600');
                            $ringClass = ($b->user_id == auth()->id()) ? ($b->status == 'disetujui' ? 'ring-1 ring-teal-400 border-teal-300' : ($b->status == 'menunggu_approval' ? 'ring-1 ring-orange-400 border-orange-300' : 'ring-1 ring-blue-400 border-blue-300')) : '';
                            $icon = $b->status == 'disetujui' ? 'fa-check' : 'fa-hourglass-half';
                            // Highlight own bookings
                            $isOwn = ($b->user_id == auth()->id());
                        @endphp
                        <div class="{{ $bg }} {{ $ringClass }} border rounded-lg p-2 h-full relative cursor-pointer hover:shadow-md transition-shadow"
                             title="{{ $b->purpose }} ({{ $b->user?->name ?? 'User Dihapus' }})">
                            <div class="flex items-start gap-2">
                                <div class="{{ $iconBg }} text-white rounded p-1 flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                                    <i class="fa-solid {{ $icon }}"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h5 class="text-xs font-bold {{ $textDark }} leading-tight truncate">
                                        {{ $b->purpose }}
                                        @if($isOwn)<span class="text-[8px] font-normal opacity-70">(Anda)</span>@endif
                                    </h5>
                                    <p class="text-[9px] text-gray-500 truncate">{{ $b->user?->name ?? 'User Dihapus' }}</p>
                                    <div class="flex items-center gap-1 mt-1 text-[9px] {{ $textLight }}">
                                        <i class="fa-solid fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} –
                                        {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="h-full w-full flex items-center justify-center text-gray-200 text-xs py-4">–</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/30 flex flex-wrap items-center gap-4 text-[10px] text-gray-500 font-medium">
            <span class="font-semibold text-gray-600">Keterangan:</span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded bg-teal-400"></span> Disetujui
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded bg-orange-400"></span> Menunggu Approval
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded bg-blue-400"></span> Lainnya
            </span>
            <span class="flex items-center gap-1.5 ml-4 text-blue-600">
                <span class="w-3 h-3 rounded border-2 border-blue-400 ring-1 ring-blue-300"></span> Booking Anda
            </span>
            <a href="{{ route('karyawan.booking.index') }}"
               class="ml-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg text-[10px] flex items-center gap-1.5 transition-colors shadow-sm shadow-blue-200">
                <i class="fa-regular fa-calendar-plus"></i> Booking Ruangan
            </a>
        </div>
    </div>
</div>
@endsection