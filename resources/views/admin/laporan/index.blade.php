@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <div class="flex justify-end items-center gap-3 mb-6">
        <div class="flex items-center pl-4 pr-3 py-2 bg-white border border-gray-100 shadow-sm rounded-xl w-60">
            <i class="fa-regular fa-calendar text-blue-500 mr-3 text-lg"></i>
            <div class="text-xs">
                <span class="text-gray-400 block font-medium">Periode Laporan</span>
                <span class="text-gray-700 font-bold">01 Sep 2026 - 30 Sep 2026</span>
            </div>
            <i class="fa-solid fa-chevron-down text-gray-400 text-xs ml-auto"></i>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
            <i class="fa-solid fa-download"></i> Unduh Laporan
        </button>
    </div>


    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">125</h3>
                    <p class="text-[10px] text-blue-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 12% dari periode sebelumnya</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-teal-100 text-sm font-medium">Total Pengguna</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">48</h3>
                    <p class="text-[10px] text-teal-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 8% dari periode sebelumnya</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-purple-100 text-sm font-medium">Ruangan Digunakan</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">18</h3>
                    <p class="text-[10px] text-purple-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 15% dari periode sebelumnya</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-orange-100 text-sm font-medium">Rata-rata Durasi</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">2 <span class="text-xl font-normal">jam</span></h3>
                    <p class="text-[10px] text-orange-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 10% dari sebelumnya</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-check"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-pink-100 text-sm font-medium">Tingkat Kehadiran</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">96%</h3>
                    <p class="text-[10px] text-pink-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 4% dari periode sebelumnya</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Grafik Penggunaan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-chart-pie text-blue-500"></i>
                <h3 class="font-bold text-gray-800 text-sm">Grafik Penggunaan Ruangan</h3>
            </div>
            <p class="text-xs text-gray-500 mb-4">Persentase penggunaan ruangan berdasarkan jenis.</p>
            <div class="relative flex-1 flex items-center justify-center">
                <div class="w-40 h-40 relative">
                    <canvas id="penggunaanChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-sm text-gray-500">Total</span>
                        <span class="text-xl font-bold text-gray-800">125</span>
                        <span class="text-xs text-gray-500">Booking</span>
                    </div>
                </div>
                <div class="ml-6 space-y-2 text-[10px]">
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span><span class="text-gray-600">Ruang Meeting A</span></div><span class="font-bold">28%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span><span class="text-gray-600">Ruang Meeting B</span></div><span class="font-bold">22%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span><span class="text-gray-600">Ruang Training</span></div><span class="font-bold">18%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span><span class="text-gray-600">Ruang Workshop</span></div><span class="font-bold">16%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span><span class="text-gray-600">Ruang Lainnya</span></div><span class="font-bold">16%</span></div>
                </div>
            </div>
        </div>

        <!-- Tren Booking -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-chart-line text-blue-500"></i>
                <h3 class="font-bold text-gray-800 text-sm">Tren Booking per Minggu</h3>
            </div>
            <p class="text-xs text-gray-500 mb-4">Jumlah booking dalam 4 minggu terakhir.</p>
            <div class="relative flex-1 w-full mt-2 h-40">
                <canvas id="trenChart"></canvas>
            </div>
        </div>

        <!-- Status Booking -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-file-contract text-blue-500"></i>
                <h3 class="font-bold text-gray-800 text-sm">Status Booking</h3>
            </div>
            <p class="text-xs text-gray-500 mb-4">Persentase status booking ruang.</p>
            <div class="relative flex-1 flex items-center justify-center">
                <div class="w-40 h-40 relative">
                    <canvas id="statusBarChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-xl font-bold text-gray-800">125</span>
                        <span class="text-xs text-gray-500">Booking</span>
                    </div>
                </div>
                <div class="ml-6 space-y-2 text-[10px]">
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span><span class="text-gray-600">Check-in</span></div><span class="font-bold">72%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span><span class="text-gray-600">Menunggu</span></div><span class="font-bold">12%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span><span class="text-gray-600">Dibatalkan</span></div><span class="font-bold">8%</span></div>
                    <div class="flex items-center justify-between gap-4"><div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span><span class="text-gray-600">Selesai</span></div><span class="font-bold">8%</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filters -->
        <form action="{{ route('admin.laporan') }}" method="GET" class="p-5 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between">
            <div class="flex flex-wrap gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="appearance-none pl-9 pr-8 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-44">
                        <option>Semua Status</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="menunggu_approval" {{ request('status') == 'menunggu_approval' ? 'selected' : '' }}>Menunggu</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <i class="fa-solid fa-list absolute left-3 top-2.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    <span class="absolute -top-2 left-2 bg-white px-1 text-[10px] text-gray-400">Status</span>
                </div>
                <div class="relative">
                    <select name="room" onchange="this.form.submit()" class="appearance-none pl-9 pr-8 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-44">
                        <option>Semua Ruangan</option>
                        @foreach($rooms as $rm)
                        <option value="{{ $rm->name }}" {{ request('room') == $rm->name ? 'selected' : '' }}>{{ $rm->name }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-building absolute left-3 top-2.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    <span class="absolute -top-2 left-2 bg-white px-1 text-[10px] text-gray-400">Ruangan</span>
                </div>
                <div class="relative">
                    <select name="month" onchange="this.form.submit()" class="appearance-none pl-9 pr-8 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-40">
                        <option>Semua Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                    <i class="fa-regular fa-calendar absolute left-3 top-2.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    <span class="absolute -top-2 left-2 bg-white px-1 text-[10px] text-gray-400">Bulan</span>
                </div>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kode..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                    <i class="fa-solid fa-search absolute left-3 top-2.5 text-blue-500"></i>
                </div>
                <button type="submit" class="border border-gray-200 rounded-lg p-2 text-gray-500 hover:bg-gray-50 transition-colors w-10 flex items-center justify-center"><i class="fa-solid fa-filter text-lg"></i></button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white uppercase tracking-wider border-b border-blue-700">
                        <th class="px-4 py-4 w-10 text-center rounded-tl-lg"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                        <th class="px-4 py-4 text-center">No.</th>
                        <th class="px-4 py-4">Kode Booking</th>
                        <th class="px-4 py-4">Tanggal & Waktu</th>
                        <th class="px-4 py-4">Ruangan</th>
                        <th class="px-4 py-4">Pengguna</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($bookings as $b)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></td>
                        <td class="px-4 py-3 text-center">{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                        <td class="px-4 py-3 text-gray-800 font-bold text-xs">{{ $b->code }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($b->date)->format('d M Y') }}<br>{{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $b->room?->name ?? 'Ruangan Dihapus' }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $b->user?->name ?? 'User Dihapus' }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $c = 'gray';
                                $icon = 'fa-circle-dot';
                                if($b->status == 'disetujui' || $b->status == 'selesai') { $c = 'teal'; $icon = 'fa-circle-check'; }
                                else if($b->status == 'menunggu_approval' || $b->status == 'revisi') { $c = 'orange'; $icon = 'fa-hourglass-half'; }
                                else if($b->status == 'ditolak' || $b->status == 'dibatalkan' || $b->status == 'kadaluarsa') { $c = 'red'; $icon = 'fa-circle-xmark'; }
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-{{ $c }}-50 text-{{ $c }}-600 text-[10px] font-medium border border-{{ $c }}-100 capitalize">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $c }}-500"></span> {{ str_replace('_', ' ', $b->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1.5" x-data="{ showDetail: false }">
                                <button @click="showDetail = true" type="button" class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Lihat"><i class="fa-solid fa-eye text-[10px]"></i></button>
                                
                                <!-- Modal Detail -->
                                <div x-show="showDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="showDetail" @click="showDetail = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                        </div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showDetail" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                                                <button @click="showDetail = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                                    <i class="fa-solid fa-xmark text-xl"></i>
                                                </button>
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Detail Laporan Booking</h3>
                                                        <div class="space-y-3">
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Pemohon</span>
                                                                <span class="w-2/3 text-sm text-gray-800 font-semibold">{{ $b->user?->name ?? 'User Dihapus' }}</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Ruangan</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ $b->room?->name ?? 'Ruangan Dihapus' }}</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Waktu</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ \Carbon\Carbon::parse($b->date)->format('d M Y') }} ({{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }})</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Keperluan</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ $b->purpose }}</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Status</span>
                                                                <span class="w-2/3 text-sm text-gray-800 capitalize">{{ str_replace('_', ' ', $b->status) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                                <button type="button" @click="showDetail = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                                                    Tutup
                                                </button>
                                                <form action="{{ route('booking.destroy', $b->id) }}" method="POST" class="mt-3 sm:mt-0 w-full sm:w-auto" onsubmit="return confirm('Anda yakin ingin menghapus laporan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm">
                                                        <i class="fa-solid fa-trash mr-2 mt-1"></i> Hapus Laporan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Tidak ada data laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-center bg-gray-50/50">
            {{ $bookings->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Doughnut 1: Penggunaan Ruangan
        new Chart(document.getElementById('penggunaanChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Ruang Meeting A', 'Ruang Meeting B', 'Ruang Training', 'Ruang Workshop', 'Ruang Lainnya'],
                datasets: [{
                    data: [28, 22, 18, 16, 16],
                    backgroundColor: ['#3B82F6', '#14B8A6', '#FB923C', '#A855F7', '#EC4899'],
                    borderWidth: 0, cutout: '75%'
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });

        // Line Chart: Tren
        new Chart(document.getElementById('trenChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['1 Sep\n(1-7)', '8 Sep\n(8-14)', '15 Sep\n(15-21)', '22 Sep\n(22-30)'],
                datasets: [{
                    data: [18, 26, 32, 28],
                    borderColor: '#3B82F6', backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2, fill: true, tension: 0.4,
                    pointBackgroundColor: '#3B82F6', pointBorderColor: '#fff', pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 40, grid: { borderDash: [4, 4] } },
                    x: { grid: { display: false }, ticks: { font: {size: 10} } }
                }
            }
        });

        // Doughnut 2: Status
        new Chart(document.getElementById('statusBarChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Check-in', 'Menunggu', 'Dibatalkan', 'Selesai'],
                datasets: [{
                    data: [72, 12, 8, 8],
                    backgroundColor: ['#22C55E', '#FB923C', '#F87171', '#3B82F6'],
                    borderWidth: 0, cutout: '75%'
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    });
</script>
@endsection