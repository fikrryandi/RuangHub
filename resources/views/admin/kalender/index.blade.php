@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <!-- Timetable -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-5 border-b border-gray-100 flex flex-wrap gap-4 justify-between items-center bg-gray-50/50">
            <div>
                <h2 class="font-bold text-gray-800 text-lg flex items-center gap-2"><i class="fa-regular fa-calendar text-blue-600"></i> Jadwal Pemakaian Ruangan</h2>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</p>
            </div>
            
            <!-- Legend (Keterangan Warna) -->
            <div class="flex flex-wrap items-center gap-3 text-xs">
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-orange-200 border border-orange-300"></div><span class="text-gray-600 font-medium">Menunggu Approval</span></div>
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-teal-200 border border-teal-300"></div><span class="text-gray-600 font-medium">Disetujui</span></div>
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-blue-200 border border-blue-300"></div><span class="text-gray-600 font-medium">Selesai</span></div>
            </div>

            <form action="{{ route('admin.kalender') }}" method="GET" class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg bg-white shadow-sm">
                <i class="fa-regular fa-calendar text-blue-500 mr-2 text-sm"></i>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="text-sm text-gray-700 font-medium border-none focus:ring-0 p-0 cursor-pointer bg-transparent">
                <div class="flex gap-1 border-l border-gray-200 pl-2 ml-3">
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d') }}" class="p-1 text-gray-400 hover:text-blue-600 transition-colors"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d') }}" class="p-1 text-gray-400 hover:text-blue-600 transition-colors"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                </div>
            </form>
        </div>
        <div class="flex-1 overflow-x-auto p-5">
            <div class="min-w-[800px]">
                <!-- Header -->
                <div class="grid border-b border-gray-100 pb-3 mb-3" style="grid-template-columns: 100px repeat({{ count($rooms) }}, minmax(180px, 1fr));">
                    <div class="text-xs font-semibold text-blue-600 px-2">Waktu</div>
                    @foreach($rooms as $r)
                    <div class="text-xs font-semibold text-center text-gray-600 px-2">{{ $r->name }}<br><span class="font-normal text-gray-400">({{ $r->capacity }} orang)</span></div>
                    @endforeach
                </div>
                
                <!-- Rows -->
                @php
                $times = [];
                for($i=7; $i<=18; $i++) {
                    $start = sprintf('%02d:00', $i);
                    $end = sprintf('%02d:00', $i+1);
                    $times[] = "$start - $end";
                }
                @endphp

                @foreach($times as $t)
                @php
                    [$startHour, $endHour] = explode(' - ', $t);
                @endphp
                <div class="grid border-b border-gray-50 py-2 relative items-stretch" style="grid-template-columns: 100px repeat({{ count($rooms) }}, minmax(180px, 1fr));">
                    <div class="text-xs text-gray-500 flex items-center px-2">{{ $t }}</div>
                    @foreach($rooms as $r)
                        <div class="px-2 h-full">
                            @php
                                $b = $bookings->first(function($booking) use ($r, $startHour, $endHour) {
                                    if($booking->room_id != $r->id) return false;
                                    $bStart = \Carbon\Carbon::parse($booking->start_time)->format('H:i');
                                    $bEnd = \Carbon\Carbon::parse($booking->end_time)->format('H:i');
                                    return ($bStart < $endHour && $bEnd > $startHour);
                                });
                            @endphp
                            @if($b)
                                @php
                                    $bg = $b->status == 'disetujui' ? 'bg-teal-50 border-teal-100' : ($b->status == 'menunggu_approval' ? 'bg-orange-50 border-orange-100' : 'bg-blue-50 border-blue-100');
                                    $iconBg = $b->status == 'disetujui' ? 'bg-teal-500' : ($b->status == 'menunggu_approval' ? 'bg-orange-500' : 'bg-blue-500');
                                    $textDark = $b->status == 'disetujui' ? 'text-teal-700' : ($b->status == 'menunggu_approval' ? 'text-orange-700' : 'text-blue-700');
                                    $textLight = $b->status == 'disetujui' ? 'text-teal-600' : ($b->status == 'menunggu_approval' ? 'text-orange-600' : 'text-blue-600');
                                    $icon = $b->status == 'disetujui' ? 'fa-check' : 'fa-hourglass-half';
                                @endphp
                                <div class="{{ $bg }} border rounded-lg p-2 h-full w-full relative cursor-pointer hover:shadow-md transition-shadow" title="{{ $b->purpose }}">
                                    <div class="flex items-start gap-2">
                                        <div class="{{ $iconBg }} text-white rounded p-1 flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                                            <i class="fa-solid {{ $icon }}"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <h5 class="text-xs font-bold {{ $textDark }} leading-tight truncate">{{ $b->purpose }}</h5>
                                            <p class="text-[9px] text-gray-500 truncate">{{ $b->user->name }}</p>
                                            <div class="flex items-center gap-1 mt-1 text-[9px] {{ $textLight }}">
                                                <i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-200 text-xs py-4">-</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection