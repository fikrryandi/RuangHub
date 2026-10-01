@extends('layouts.karyawan')

@section('content')
<div class="relative z-10 px-8 pb-10">
    <!-- Toolbar -->
    <div class="flex items-center justify-end mb-6">
        <a href="{{ route('karyawan.booking.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm shadow-blue-200 flex items-center gap-2 text-sm transition-colors">
            <i class="fa-solid fa-plus"></i> Booking Baru
        </a>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 3500)"
         x-show="show"
         x-transition.opacity.duration.300ms
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm"
         style="display: none;">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 flex flex-col items-center text-center"
             x-show="show"
             x-transition:enter="transition ease-out duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
             x-transition:enter-start="opacity-0 scale-50 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             @click.stop>
            
            <div class="relative w-24 h-24 mb-6">
                <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-40"></div>
                <div class="relative w-full h-full bg-green-50 rounded-full flex items-center justify-center border-4 border-green-200 shadow-inner">
                    <i class="fa-solid fa-check text-5xl text-green-500 drop-shadow-sm"></i>
                </div>
            </div>
            
            <h2 class="text-2xl font-black text-gray-800 mb-2">Berhasil Terkirim!</h2>
            <p class="text-sm text-gray-500">{!! session('success') !!}</p>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-xmark text-red-500"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Stat Summary -->
    @php
        $allBookings = \App\Models\Booking::where('user_id', auth()->id())->get();
        $totalAll     = $allBookings->count();
        $totalWaiting = $allBookings->where('status', 'menunggu_approval')->count();
        $totalDone    = $allBookings->whereIn('status', ['disetujui', 'selesai'])->count();
        $totalRejected= $allBookings->whereIn('status', ['ditolak', 'dibatalkan'])->count();
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Total</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ $totalAll }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Menunggu</p>
                <p class="text-2xl font-extrabold text-orange-600">{{ $totalWaiting }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-teal-50 text-teal-500 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Disetujui</p>
                <p class="text-2xl font-extrabold text-teal-600">{{ $totalDone }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase">Ditolak</p>
                <p class="text-2xl font-extrabold text-red-600">{{ $totalRejected }}</p>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header bar -->
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
            <div class="font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-list text-blue-500"></i> Riwayat Booking
            </div>
            <span class="text-xs text-gray-400">{{ $bookings->total() }} data ditemukan</span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white uppercase tracking-wider">
                        <th class="px-4 py-4 text-center rounded-tl-none w-12">No.</th>
                        <th class="px-4 py-4 w-32">Kode</th>
                        <th class="px-4 py-4">Ruangan</th>
                        <th class="px-4 py-4">Tanggal &amp; Waktu</th>
                        <th class="px-4 py-4">Keperluan</th>
                        <th class="px-4 py-4 text-center w-36">Status</th>
                        <th class="px-4 py-4 text-center rounded-none w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody id="live-table-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($bookings as $b)
                    @php
                        // Warna & label status
                        $statusConfig = match($b->status) {
                            'menunggu_approval' => ['c' => 'orange', 'icon' => 'fa-hourglass-half',  'label' => 'Menunggu Approval'],
                            'disetujui'         => ['c' => 'teal',   'icon' => 'fa-circle-check',    'label' => 'Disetujui ✓'],
                            'selesai'           => ['c' => 'teal',   'icon' => 'fa-circle-check',    'label' => 'Selesai ✓'],
                            'ditolak'           => ['c' => 'red',    'icon' => 'fa-circle-xmark',    'label' => 'Ditolak'],
                            'dibatalkan'        => ['c' => 'gray',   'icon' => 'fa-circle-minus',    'label' => 'Dibatalkan'],
                            'revisi'            => ['c' => 'blue',   'icon' => 'fa-rotate-right',    'label' => 'Perlu Revisi'],
                            'kadaluarsa'        => ['c' => 'gray',   'icon' => 'fa-clock-rotate-left','label' => 'Kadaluarsa'],
                            default             => ['c' => 'gray',   'icon' => 'fa-circle-dot',      'label' => ucfirst($b->status)],
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors" x-data="{ showDetail: false, showSelesai: false, showBatal: false }">
                        <td class="px-4 py-4 text-center text-gray-500">
                            {{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded-lg border border-blue-100">
                                {{ $b->code ?? '–' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800 text-xs">{{ $b->room->name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $b->room->capacity }} orang</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-700 text-xs">
                                {{ \Carbon\Carbon::parse($b->date)->translatedFormat('d M Y') }}
                            </div>
                            <div class="text-[10px] text-gray-400">
                                {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-600 max-w-[180px]">
                            <div class="truncate">{{ $b->purpose }}</div>
                            @if($b->notes)
                            <div class="text-[10px] text-gray-400 truncate">{{ $b->notes }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-{{ $statusConfig['c'] }}-50 text-{{ $statusConfig['c'] }}-600 text-[10px] font-semibold border border-{{ $statusConfig['c'] }}-100 whitespace-nowrap">
                                <i class="fa-solid {{ $statusConfig['icon'] }} text-[8px]"></i>
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Detail --}}
                                <button @click="showDetail = true"
                                        class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center"
                                        title="Lihat Detail">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>

                                {{-- Tombol Selesai (hanya untuk booking disetujui) --}}
                                @if($b->status == 'disetujui')
                                <button @click="showSelesai = true"
                                        class="w-7 h-7 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-600 hover:text-white transition-colors flex items-center justify-center animate-pulse"
                                        title="Tandai Selesai Digunakan">
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                </button>
                                @endif

                                {{-- Batalkan (hanya jika menunggu_approval) --}}
                                @if($b->status == 'menunggu_approval')
                                <button @click="showBatal = true"
                                        class="w-7 h-7 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center"
                                        title="Batalkan Booking">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                                @endif
                            </div>

                            {{-- Modal Konfirmasi Selesai --}}
                            @if($b->status == 'disetujui')
                            <div x-show="showSelesai"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                 style="display:none;">
                                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showSelesai = false"></div>
                                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden z-10" @click.stop>
                                    <div class="h-1.5 bg-gradient-to-r from-teal-500 to-green-500"></div>
                                    <div class="p-7 text-center">
                                        <div class="relative w-20 h-20 mx-auto mb-4">
                                            <div class="absolute inset-0 bg-teal-100 rounded-full animate-ping opacity-30"></div>
                                            <div class="relative w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center border-2 border-teal-200">
                                                <i class="fa-solid fa-circle-check text-3xl text-teal-500"></i>
                                            </div>
                                        </div>
                                        <h3 class="text-lg font-extrabold text-gray-800 mb-2">Selesai Menggunakan Ruangan?</h3>
                                        <p class="text-xs text-gray-500 mb-4">Konfirmasi bahwa ruangan <strong class="text-teal-700">{{ $b->room->name }}</strong> sudah selesai digunakan dan siap untuk dipakai kembali.</p>
                                        <div class="flex gap-3">
                                            <button @click="showSelesai = false"
                                                    class="flex-1 py-2.5 border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                                Belum
                                            </button>
                                            <form action="{{ route('karyawan.booking-saya.selesai', $b->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full py-2.5 bg-gradient-to-r from-teal-600 to-green-500 hover:from-teal-700 hover:to-green-600 text-white rounded-xl text-sm font-bold transition-all shadow-sm shadow-teal-200">
                                                    <i class="fa-solid fa-check mr-1"></i> Ya, Selesai!
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Modal Konfirmasi Batalkan --}}
                            @if($b->status == 'menunggu_approval')
                            <div x-show="showBatal"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                 style="display:none;">
                                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showBatal = false"></div>
                                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden z-10" @click.stop>
                                    <div class="h-1.5 bg-gradient-to-r from-red-500 to-pink-500"></div>
                                    <div class="p-7 text-center">
                                        <div class="relative w-20 h-20 mx-auto mb-4">
                                            <div class="absolute inset-0 bg-red-100 rounded-full animate-ping opacity-30"></div>
                                            <div class="relative w-20 h-20 bg-red-50 rounded-full flex items-center justify-center border-2 border-red-200">
                                                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                                            </div>
                                        </div>
                                        <h3 class="text-lg font-extrabold text-gray-800 mb-2">Batalkan Booking?</h3>
                                        <p class="text-xs text-gray-500 mb-4">Booking <strong class="text-red-700">{{ $b->code }}</strong> akan dibatalkan dan tidak bisa dikembalikan.</p>
                                        <div class="flex gap-3">
                                            <button @click="showBatal = false"
                                                    class="flex-1 py-2.5 border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                                Tidak
                                            </button>
                                            <form action="{{ route('karyawan.booking-saya.destroy', $b->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full py-2.5 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white rounded-xl text-sm font-bold transition-all shadow-sm shadow-red-200">
                                                    <i class="fa-solid fa-xmark mr-1"></i> Ya, Batalkan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                            {{-- Modal Detail --}}
                            <div x-show="showDetail"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                 style="display:none;">
                                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDetail = false"></div>
                                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden z-10"
                                     @click.stop>
                                    {{-- Header --}}
                                    <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-5 py-4 flex items-center justify-between text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-calendar-check"></i>
                                            <span class="font-bold text-sm">Detail Booking</span>
                                        </div>
                                        <button @click="showDetail = false" class="text-white/70 hover:text-white transition-colors">
                                            <i class="fa-solid fa-xmark text-lg"></i>
                                        </button>
                                    </div>
                                    {{-- Body --}}
                                    <div class="p-5 space-y-3">
                                        <div class="bg-{{ $statusConfig['c'] }}-50 border border-{{ $statusConfig['c'] }}-100 rounded-xl p-3 flex items-center gap-2">
                                            <i class="fa-solid {{ $statusConfig['icon'] }} text-{{ $statusConfig['c'] }}-500"></i>
                                            <span class="text-sm font-bold text-{{ $statusConfig['c'] }}-700">{{ $statusConfig['label'] }}</span>
                                        </div>
                                        <div class="divide-y divide-gray-50 text-sm">
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Kode</span>
                                                <span class="w-2/3 font-bold text-blue-700">{{ $b->code ?? '–' }}</span>
                                            </div>
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Ruangan</span>
                                                <span class="w-2/3 font-semibold text-gray-800">{{ $b->room->name }}</span>
                                            </div>
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Tanggal</span>
                                                <span class="w-2/3 font-semibold text-gray-800">{{ \Carbon\Carbon::parse($b->date)->translatedFormat('d F Y') }}</span>
                                            </div>
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Waktu</span>
                                                <span class="w-2/3 font-semibold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }}
                                                    –
                                                    {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                                                </span>
                                            </div>
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Keperluan</span>
                                                <span class="w-2/3 font-semibold text-gray-800">{{ $b->purpose }}</span>
                                            </div>
                                            @if($b->notes)
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Catatan</span>
                                                <span class="w-2/3 text-gray-700">{{ $b->notes }}</span>
                                            </div>
                                            @endif
                                            @if($b->rejection_reason)
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Alasan Tolak</span>
                                                <span class="w-2/3 text-red-600">{{ $b->rejection_reason }}</span>
                                            </div>
                                            @endif
                                            <div class="flex py-2.5">
                                                <span class="w-1/3 text-gray-500 font-medium">Diajukan</span>
                                                <span class="w-2/3 text-gray-600 text-xs">{{ $b->created_at->translatedFormat('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-5">
                                        <button @click="showDetail = false"
                                                class="w-full py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-regular fa-calendar-xmark text-5xl text-blue-100"></i>
                                <p class="text-sm font-medium text-gray-500">Belum ada booking yang dibuat</p>
                                <a href="{{ route('karyawan.booking.index') }}"
                                   class="mt-2 bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Buat Booking Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/30">
            <span class="text-xs text-gray-500">
                Menampilkan {{ $bookings->firstItem() }} – {{ $bookings->lastItem() }}
                dari {{ $bookings->total() }} data
            </span>
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection