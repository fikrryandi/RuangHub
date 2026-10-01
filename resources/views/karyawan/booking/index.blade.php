@extends('layouts.karyawan')

@section('content')
{{-- CSS animasi --}}
<style>
@keyframes scaleIn {
    0%   { transform: scale(0); opacity: 0; }
    60%  { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
}
@keyframes drawCheck {
    0%   { stroke-dashoffset: 80; opacity: 0; }
    40%  { opacity: 1; }
    100% { stroke-dashoffset: 0; opacity: 1; }
}
.anim-circle { animation: scaleIn 0.5s cubic-bezier(.22,.61,.36,1) forwards; }
.anim-check  { stroke-dasharray: 80; stroke-dashoffset: 80; animation: drawCheck 0.6s ease-out 0.4s forwards; }
</style>

<div class="relative z-10 px-8 pb-10"
     x-data="{
         showForm:    {{ (old('room_id') || session('error')) ? 'true' : 'false' }},
         selectedRoom: '{{ old('room_id', '') }}',
         selectedRoomName: '',

         openForm(id, name) {
             this.selectedRoom     = String(id);
             this.selectedRoomName = name;
             this.showForm         = true;
             this.showSuccess      = false;
         },
         openEmpty() {
             this.selectedRoom     = '';
             this.selectedRoomName = '';
             this.showForm         = true;
         }
     }">

    {{-- ── Toolbar ─────────────────────────────────────────────────── --}}
    <div class="flex items-center justify-end mb-6">
        <button @click="openEmpty()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm shadow-blue-200 flex items-center gap-2 text-sm transition-colors">
            <i class="fa-solid fa-plus"></i> Tambah Booking
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- ── Filter Tabs + List Ruangan ────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Filter bar --}}
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-gray-50/30 flex-wrap gap-3">
            <div class="flex items-center gap-2 overflow-x-auto">
                <span class="px-4 py-1.5 rounded-full bg-blue-600 text-white text-xs font-semibold">Semua Ruangan</span>
                <span class="flex items-center gap-1.5 text-[10px] text-gray-500 font-medium ml-4">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Tersedia
                </span>
                <span class="flex items-center gap-1.5 text-[10px] text-gray-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span> Terisi
                </span>
            </div>
            <span class="text-[10px] text-gray-400">Klik ruangan untuk langsung booking</span>
        </div>

        {{-- Room list --}}
        <div class="divide-y divide-gray-100">
            @forelse($rooms as $r)
            <div class="p-5 hover:bg-blue-50/30 transition-all duration-150 flex items-center justify-between cursor-pointer group"
                 @click="openForm({{ $r->id }}, '{{ addslashes($r->name) }}')">
                <div class="flex gap-4 items-center w-full">
                    <div class="w-20 h-16 rounded-xl bg-blue-50 overflow-hidden shrink-0 flex items-center justify-center text-blue-300 text-3xl border border-blue-100 group-hover:border-blue-300 transition-colors">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-blue-700 transition-colors">{{ $r->name }}</h3>
                        <div class="flex flex-wrap items-center gap-4 text-[10px] text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-users text-blue-400"></i>
                                Kapasitas {{ $r->capacity }} orang
                            </span>
                            @if($r->facilities)
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-tv text-blue-400"></i>
                                {{ is_array($r->facilities) ? implode(', ', $r->facilities) : $r->facilities }}
                            </span>
                            @endif
                            @if($r->location)
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-blue-400"></i>
                                {{ $r->location }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        @if($r->is_occupied)
                        <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-600 text-[10px] font-semibold border border-pink-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span> Terisi
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-semibold border border-green-100 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        @endif
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm shadow-blue-200">
                                <i class="fa-solid fa-calendar-plus text-[9px]"></i> Booking
                            </span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <i class="fa-solid fa-building text-4xl text-gray-200 mb-3 block"></i>
                <p class="text-gray-500 text-sm">Belum ada ruangan yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════ --}}
    {{-- MODAL: Form Booking (Centered, max-height, tidak overflow)       --}}
    {{-- ════════════════════════════════════════════════════════════════ --}}
    <div x-show="showForm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         style="display:none;">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
             @click="if(!showSuccess){ showForm = false; }"></div>

        {{-- Modal Card --}}
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col z-10 overflow-hidden"
             style="max-height: min(90vh, 700px);"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             @click.stop>

            {{-- ── Modal Header ─────────────────────────────── --}}
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-5 py-4 flex items-start gap-3 relative overflow-hidden shrink-0">
                <div class="bg-white/20 p-2 rounded-xl shrink-0 z-10">
                    <i class="fa-regular fa-calendar-plus text-xl text-white"></i>
                </div>
                <div class="z-10 flex-1">
                    <h3 class="font-bold text-white text-sm mb-0.5">Form Booking Ruangan</h3>
                    <p class="text-[10px] text-blue-100">Lengkapi data berikut untuk melakukan pemesanan ruangan.</p>
                </div>
                <button @click="showForm = false" class="z-10 text-white/70 hover:text-white transition-colors p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
                <i class="fa-solid fa-calendar-check absolute -bottom-3 -right-3 text-5xl text-white/10 pointer-events-none"></i>
            </div>

            {{-- ── Form Body ─────────────────────────────────── --}}
            <div class="flex-1 overflow-y-auto">
                <form action="{{ route('karyawan.booking.store') }}"
                      method="POST"
                      class="p-5 space-y-4">
                    @csrf
                    
                    @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>
                        <div>{!! session('error') !!}</div>
                    </div>
                    @endif

                    {{-- Ruangan --}}
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                            <i class="fa-solid fa-building"></i> Ruangan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="room_id" required
                                    x-model="selectedRoom"
                                    class="w-full appearance-none px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $rm)
                                <option value="{{ $rm->id }}">{{ $rm->name }} ({{ $rm->capacity }} orang)</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                        <p class="text-[10px] text-blue-500 mt-1 flex items-center gap-1" x-show="selectedRoomName">
                            <i class="fa-solid fa-circle-check"></i>
                            <span x-text="selectedRoomName + ' dipilih'"></span>
                        </p>
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                            <i class="fa-regular fa-calendar"></i> Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" required
                               min="{{ date('Y-m-d') }}" value="{{ old('date', date('Y-m-d')) }}"
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                    </div>

                    {{-- Jam --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                                <i class="fa-regular fa-clock"></i> Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" required value="{{ old('start_time') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                                <i class="fa-regular fa-clock"></i> Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time" required value="{{ old('end_time') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                        </div>
                    </div>

                    {{-- Keperluan --}}
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                            <i class="fa-solid fa-list-check"></i> Keperluan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="purpose" required value="{{ old('purpose') }}"
                               placeholder="Contoh: Meeting Internal, Training, Presentasi..."
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors placeholder-gray-400">
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-blue-800 mb-1.5">
                            <i class="fa-regular fa-comment-dots"></i> Catatan
                            <span class="text-[9px] text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="notes" rows="2"
                                  placeholder="Tambahkan catatan jika diperlukan..."
                                  class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors placeholder-gray-400 resize-none">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Info alur --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-[10px] text-blue-600 leading-relaxed flex items-start gap-2">
                        <i class="fa-solid fa-circle-info mt-0.5 shrink-0"></i>
                        <span>Booking akan dikirim ke admin untuk di-<strong>approve</strong>. Pantau status di menu <strong>Booking Saya</strong>.</span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white py-3 rounded-xl text-sm font-bold transition-all shadow-sm shadow-blue-200 flex items-center justify-center gap-2">
                        <i class="fa-regular fa-paper-plane"></i> Kirim Permintaan Booking
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection