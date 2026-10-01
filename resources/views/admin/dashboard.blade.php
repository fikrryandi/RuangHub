@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <!-- Card 1 -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <p class="text-blue-100 text-sm font-medium">Total Ruangan</p>
                <h3 class="text-3xl font-bold mt-1 mb-2">{{ $totalRooms }}</h3>
                <p class="text-xs text-blue-100 flex items-center gap-1"><i class="fa-solid fa-arrow-up text-xs"></i> Aktif</p>
            </div>
            <i class="fa-solid fa-door-open absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <!-- Card 2 -->
        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-purple-100 text-sm font-medium">Total User</p>
                <h3 class="text-3xl font-bold mt-1 mb-2">{{ $totalUsers }}</h3>
                <p class="text-xs text-purple-100 flex items-center gap-1"><i class="fa-solid fa-arrow-up text-xs"></i> Terdaftar</p>
            </div>
            <i class="fa-solid fa-users absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <!-- Card 3 -->
        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <p class="text-teal-100 text-sm font-medium">Total Booking</p>
                <h3 class="text-3xl font-bold mt-1 mb-2">{{ $totalBookings }}</h3>
                <p class="text-xs text-teal-100 flex items-center gap-1"><i class="fa-solid fa-arrow-up text-xs"></i> Total pengajuan</p>
            </div>
            <i class="fa-regular fa-calendar-check absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <!-- Card 4 -->
        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <p class="text-orange-100 text-sm font-medium">Pending Approval</p>
                <h3 class="text-3xl font-bold mt-1 mb-2">{{ $pendingBookings }}</h3>
                <p class="text-xs text-orange-100 flex items-center gap-1"><i class="fa-solid fa-arrow-down text-xs"></i> 3% dari kemarin</p>
            </div>
            <i class="fa-solid fa-clock absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <!-- Card 5 -->
        <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <p class="text-pink-100 text-sm font-medium">Sedang Digunakan</p>
                <h3 class="text-3xl font-bold mt-1 mb-2">{{ $activeBookings }}</h3>
                <p class="text-xs text-pink-100 flex items-center gap-1"><i class="fa-solid fa-arrow-up text-xs"></i> 1 dari kemarin</p>
            </div>
            <i class="fa-solid fa-tv absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Line Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-lg">Statistik Booking Ruangan</h2>
                </div>
                <select class="border-gray-200 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2">
                    <option>7 Hari Terakhir</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="bookingChart"></canvas>
            </div>
            <div class="flex items-center justify-center gap-6 mt-4">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span class="text-xs text-gray-500">Total Booking</span></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-teal-500"></span><span class="text-xs text-gray-500">Disetujui</span></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-400"></span><span class="text-xs text-gray-500">Ditolak</span></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-400"></span><span class="text-xs text-gray-500">Dibatalkan</span></div>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-lg">Status Booking</h2>
                </div>
                <button class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
            <div class="relative h-48 w-full flex justify-center mb-4">
                <canvas id="statusChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</span>
                    <span class="text-xs text-gray-500">Total Booking</span>
                </div>
            </div>
            @php
                $t = $totalBookings ?: 1; // prevent division by zero
                $pTer = number_format(($chartStatus['terkonfirmasi'] / $t) * 100, 1, ',', '');
                $pMen = number_format(($chartStatus['menunggu'] / $t) * 100, 1, ',', '');
                $pTlk = number_format(($chartStatus['ditolak'] / $t) * 100, 1, ',', '');
                $pSel = number_format(($chartStatus['selesai'] / $t) * 100, 1, ',', '');
                $pBtl = number_format(($chartStatus['dibatalkan'] / $t) * 100, 1, ',', '');
            @endphp
            <div class="space-y-3 mt-4">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-teal-500"></span><span class="text-gray-600">Terkonfirmasi</span></div>
                    <div class="flex gap-4"><span class="font-bold text-gray-800">{{ $chartStatus['terkonfirmasi'] }}</span><span class="text-gray-400 w-8 text-right">{{ $pTer }}%</span></div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span class="text-gray-600">Menunggu Approval</span></div>
                    <div class="flex gap-4"><span class="font-bold text-gray-800">{{ $chartStatus['menunggu'] }}</span><span class="text-gray-400 w-8 text-right">{{ $pMen }}%</span></div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-400"></span><span class="text-gray-600">Ditolak</span></div>
                    <div class="flex gap-4"><span class="font-bold text-gray-800">{{ $chartStatus['ditolak'] }}</span><span class="text-gray-400 w-8 text-right">{{ $pTlk }}%</span></div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-purple-500"></span><span class="text-gray-600">Selesai</span></div>
                    <div class="flex gap-4"><span class="font-bold text-gray-800">{{ $chartStatus['selesai'] }}</span><span class="text-gray-400 w-8 text-right">{{ $pSel }}%</span></div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-400"></span><span class="text-gray-600">Dibatalkan</span></div>
                    <div class="flex gap-4"><span class="font-bold text-gray-800">{{ $chartStatus['dibatalkan'] }}</span><span class="text-gray-400 w-8 text-right">{{ $pBtl }}%</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monitoring Ruangan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-lg">Monitoring Ruangan</h2>
                </div>
                <a href="{{ route('ruangan.index') }}" class="text-blue-500 text-sm font-medium hover:underline flex items-center gap-1">Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i></a>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                @foreach($rooms as $r)
                @php
                    $color = $r->status == 'aktif' ? 'blue' : ($r->status == 'maintenance' ? 'orange' : 'gray');
                    $displayStatus = $r->status == 'aktif' ? 'Tersedia' : ($r->status == 'maintenance' ? 'Maintenance' : 'Nonaktif');
                @endphp
                <div onclick="window.location='{{ route('ruangan.index') }}'" class="border border-gray-100 rounded-xl p-3 flex gap-3 items-center hover:shadow-md transition-shadow cursor-pointer bg-white">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg text-blue-600 flex items-center justify-center flex-shrink-0 text-xl">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm">{{ $r->name }}</h4>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mb-1">
                            <i class="fa-solid fa-users text-[10px]"></i> {{ $r->capacity }} Orang
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-{{ $color }}-50 text-{{ $color }}-600 text-[10px] font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                            {{ $displayStatus }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Booking Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-lg">Booking Terbaru</h2>
                </div>
                <a href="{{ route('booking.index') }}" class="text-blue-500 text-sm font-medium hover:underline flex items-center gap-1">Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i></a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">No. Booking</th>
                            <th class="pb-3 font-medium">Ruangan</th>
                            <th class="pb-3 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 font-medium">Pemohon</th>
                            <th class="pb-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($recentBookings as $b)
                        @php
                            $color = 'gray';
                            if($b->status == 'disetujui' || $b->status == 'selesai') $color = 'teal';
                            else if($b->status == 'menunggu_approval' || $b->status == 'revisi') $color = 'orange';
                            else if($b->status == 'ditolak' || $b->status == 'dibatalkan' || $b->status == 'kadaluarsa') $color = 'red';
                        @endphp
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 cursor-pointer" onclick="window.location='{{ route('booking.index') }}'">
                            <td class="py-3 text-gray-600">{{ $b->code }}</td>
                            <td class="py-3 text-gray-800 font-medium">{{ $b->room->name ?? '-' }}</td>
                            <td class="py-3 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($b->date)->format('d M Y') }}<br>{{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}</td>
                            <td class="py-3 text-gray-600">{{ $b->user->name ?? '-' }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-{{ $color }}-50 text-{{ $color }}-600 text-xs font-medium capitalize">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                    {{ str_replace('_', ' ', $b->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart setup
        const ctxLine = document.getElementById('bookingChart').getContext('2d');
        const gradientBlue = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradientBlue.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_reverse($chartLineDates)) !!},
                datasets: [
                    {
                        label: 'Total Booking',
                        data: {!! json_encode(array_reverse($chartLineTotal)) !!},
                        borderColor: '#3B82F6',
                        backgroundColor: gradientBlue,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Disetujui',
                        data: {!! json_encode(array_reverse($chartLineDisetujui)) !!},
                        borderColor: '#14B8A6',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#14B8A6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Ditolak',
                        data: {!! json_encode(array_reverse($chartLineDitolak)) !!},
                        borderColor: '#F87171',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#F87171',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Dibatalkan',
                        data: {!! json_encode(array_reverse($chartLineDibatalkan)) !!},
                        borderColor: '#FB923C',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#FB923C',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 4,
                        usePointStyle: true,
                        titleFont: { size: 13, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { size: 12, family: "'Plus Jakarta Sans', sans-serif" }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Doughnut Chart setup
        const ctxDoughnut = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Terkonfirmasi', 'Menunggu Approval', 'Ditolak', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [{{ $chartStatus['terkonfirmasi'] }}, {{ $chartStatus['menunggu'] }}, {{ $chartStatus['ditolak'] }}, {{ $chartStatus['selesai'] }}, {{ $chartStatus['dibatalkan'] }}],
                    backgroundColor: ['#14B8A6', '#3B82F6', '#F87171', '#A855F7', '#FB923C'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false }, 
                    tooltip: { 
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 4,
                        usePointStyle: true,
                        titleFont: { size: 13, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { size: 12, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }
                    } 
                }
            }
        });
    });
</script>
@endsection