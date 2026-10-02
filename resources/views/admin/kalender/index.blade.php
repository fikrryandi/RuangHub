@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <!-- Timetable Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 flex flex-col overflow-hidden">
        <!-- Toolbar: Date picker -->
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-white gap-4 relative z-20">
            <div>
                <h2 class="font-extrabold text-gray-800 text-2xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100 shrink-0">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    Jadwal Pemakaian Ruangan
                </h2>
                <p class="text-sm text-gray-500 mt-1 sm:ml-13">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</p>
            </div>
            
            <form action="{{ route('admin.kalender') }}" method="GET" class="flex items-center p-1.5 border border-gray-200 rounded-xl bg-gray-50 shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                <div class="px-3 text-blue-500">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <input type="date" name="date" value="{{ $date }}"
                       onchange="this.form.submit()"
                       class="text-sm text-gray-700 font-bold border-none focus:ring-0 p-1.5 bg-transparent cursor-pointer outline-none">
                <div class="flex items-center gap-1 border-l border-gray-200 pl-2 ml-2">
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d') }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button type="submit" name="date" value="{{ \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d') }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <a href="{{ route('admin.kalender', ['date' => date('Y-m-d')]) }}"
                   class="ml-2 text-xs bg-blue-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200 whitespace-nowrap">
                    Hari Ini
                </a>
            </form>
        </div>

        @php
            $times = [];
            for ($i = 7; $i <= 18; $i++) {
                $start = sprintf('%02d:00', $i);
                $end   = sprintf('%02d:00', $i + 1);
                $times[] = ['label' => "$start", 'start' => $start, 'end' => $end];
            }
        @endphp

        <!-- Timetable Grid -->
        <div class="flex-1 overflow-x-auto bg-gray-50/30 p-6">
            <div class="min-w-[1200px] bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <!-- Column Headers (Times) -->
                <div class="grid border-b border-gray-200 bg-gray-50"
                     style="grid-template-columns: 220px repeat({{ count($times) }}, minmax(120px, 1fr));">
                    <div class="p-4 flex items-center border-r border-gray-200">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ruangan</span>
                    </div>
                    @foreach($times as $slot)
                    <div class="p-3 text-center border-r border-gray-100 last:border-0 relative">
                        <span class="text-sm font-black text-gray-700">{{ $slot['label'] }}</span>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-blue-300 rounded-full mb-1"></div>
                    </div>
                    @endforeach
                </div>

                <!-- Rows (Rooms) -->
                @foreach($rooms as $index => $r)
                <div class="grid border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors items-stretch group"
                     style="grid-template-columns: 220px repeat({{ count($times) }}, minmax(120px, 1fr));">
                    
                    <!-- Room Info -->
                    <div class="p-4 border-r border-gray-200 bg-white group-hover:bg-gray-50 transition-colors flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-sm shrink-0">
                            <i class="fa-solid fa-door-open text-sm"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-gray-800 truncate">{{ $r->name }}</h4>
                            <p class="text-[10px] text-gray-500 flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-user-group text-[9px]"></i> {{ $r->capacity }} Orang
                            </p>
                        </div>
                    </div>

                    <!-- Time Slots for this room -->
                    @php $skipSlots = 0; @endphp
                    @foreach($times as $index => $slot)
                        @if($skipSlots > 0)
                            @php $skipSlots--; @endphp
                            @continue
                        @endif

                    <div class="p-1.5 border-r border-gray-100 border-dashed last:border-0 relative min-h-[85px]"
                        @php
                            $b = $bookings->first(function ($booking) use ($r, $slot, $index) {
                                if ($booking->room_id != $r->id) return false;
                                $bStart = \Carbon\Carbon::parse($booking->start_time)->format('H:i');
                                $bEnd   = \Carbon\Carbon::parse($booking->end_time)->format('H:i');
                                
                                if ($bStart >= $slot['start'] && $bStart < $slot['end']) return true;
                                if ($index == 0 && $bStart < $slot['start'] && $bEnd > $slot['start']) return true;
                                
                                return false;
                            });
                            
                            $span = 1;
                            if ($b) {
                                $bEndHour = \Carbon\Carbon::parse($b->end_time)->hour;
                                $bEndMinute = \Carbon\Carbon::parse($b->end_time)->minute;
                                
                                $endSlotHour = $bEndHour + ($bEndMinute > 0 ? 1 : 0);
                                $slotHour = (int) substr($slot['start'], 0, 2);
                                $span = max(1, $endSlotHour - $slotHour);
                                
                                $remainingSlots = count($times) - $index;
                                if ($span > $remainingSlots) $span = $remainingSlots;
                                
                                $skipSlots = $span - 1;
                            }
                        @endphp
                        @if($span > 1) style="grid-column: span {{ $span }};" @endif
                    >

                        @if($b)
                            @php
                                $bg = $b->status == 'disetujui' ? 'bg-teal-50 border-teal-200' : ($b->status == 'menunggu_approval' ? 'bg-amber-50 border-amber-200' : 'bg-blue-50 border-blue-200');
                                $iconBg = $b->status == 'disetujui' ? 'bg-teal-500' : ($b->status == 'menunggu_approval' ? 'bg-amber-500' : 'bg-blue-500');
                                $textDark = $b->status == 'disetujui' ? 'text-teal-800' : ($b->status == 'menunggu_approval' ? 'text-amber-800' : 'text-blue-800');
                                $textLight = $b->status == 'disetujui' ? 'text-teal-600' : ($b->status == 'menunggu_approval' ? 'text-amber-600' : 'text-blue-600');
                                $icon = $b->status == 'disetujui' ? 'fa-check-circle' : 'fa-clock';
                            @endphp
                            <div class="h-full w-full rounded-xl p-2 {{ $bg }} border cursor-pointer hover:-translate-y-0.5 transition-transform duration-200 flex flex-col justify-center relative overflow-hidden shadow-sm"
                                 title="{{ $b->purpose }} ({{ $b->user?->name ?? 'User Dihapus' }})">
                                 
                                <div class="relative z-10 flex flex-col gap-1 h-full">
                                    <div class="flex items-center gap-1.5 mb-0.5">
                                        <div class="w-4 h-4 rounded-full {{ $iconBg }} text-white flex items-center justify-center text-[8px] shrink-0">
                                            <i class="fa-solid {{ $icon }}"></i>
                                        </div>
                                        <span class="text-[9px] font-bold {{ $textLight }} truncate">
                                            {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                                        </span>
                                    </div>
                                    <h5 class="text-[11px] font-extrabold {{ $textDark }} leading-tight line-clamp-2" style="word-break: break-word;">
                                        {{ $b->purpose }}
                                    </h5>
                                    <p class="text-[9px] font-medium opacity-75 truncate mt-auto">
                                        {{ $b->user?->name ?? 'User Dihapus' }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- Empty slot -->
                            <div class="h-full w-full rounded-xl border border-transparent flex items-center justify-center opacity-0 hover:opacity-100 transition-all">
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <!-- Legend & Actions -->
        <div class="p-6 border-t border-gray-100 bg-white flex justify-between items-center gap-4">
            <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-gray-600">
                <span class="text-gray-400 uppercase tracking-wider text-[10px] mr-2">Status:</span>
                <span class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-teal-100 border border-teal-200 flex items-center justify-center text-teal-500 text-[8px]"><i class="fa-solid fa-check"></i></span> 
                    Disetujui
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-500 text-[8px]"><i class="fa-solid fa-clock"></i></span> 
                    Menunggu Approval
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-500 text-[8px]"><i class="fa-solid fa-check-double"></i></span> 
                    Selesai
                </span>
            </div>
        </div>
    </div>
</div>
@endsection