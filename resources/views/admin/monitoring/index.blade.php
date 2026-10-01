@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <div class="flex justify-end items-center gap-3 mb-6">
        <div class="flex items-center pl-4 pr-3 py-2 bg-white border border-gray-100 shadow-sm rounded-xl w-60">
            <i class="fa-regular fa-calendar text-blue-500 mr-3 text-lg"></i>
            <div class="text-xs">
                <span class="text-gray-400 block font-medium">Tanggal</span>
                <span class="text-gray-700 font-bold">01 Sep 2026 - 30 Sep 2026</span>
            </div>
            <i class="fa-solid fa-chevron-down text-gray-400 text-xs ml-auto"></i>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
            <i class="fa-solid fa-download"></i> Export Data
        </button>
    </div>


    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-check-to-slot"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-blue-100 text-sm font-medium">Total Check-in</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">86</h3>
                    <p class="text-[10px] text-blue-100"><i class="fa-solid fa-arrow-up text-[10px]"></i> 12% dari periode sebelumnya</p>
                </div>
            </div>
            <i class="fa-solid fa-qrcode absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-teal-100 text-sm font-medium">Tepat Waktu</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">72</h3>
                    <p class="text-[10px] text-teal-100">83% dari total</p>
                </div>
            </div>
            <i class="fa-solid fa-user-check absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-orange-100 text-sm font-medium">Terlambat</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">9</h3>
                    <p class="text-[10px] text-orange-100">10% dari total</p>
                </div>
            </div>
            <i class="fa-solid fa-clock-rotate-left absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-pink-100 text-sm font-medium">Tidak Check-in</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">5</h3>
                    <p class="text-[10px] text-pink-100">6% dari total</p>
                </div>
            </div>
            <i class="fa-solid fa-ban absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filters -->
        <div class="p-5 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between">
            <div class="flex flex-wrap gap-3">
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-44">
                        <option>Semua Ruangan</option>
                    </select>
                    <i class="fa-solid fa-door-open absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-44">
                        <option>Semua Departemen</option>
                    </select>
                    <i class="fa-solid fa-sitemap absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-40">
                        <option>Semua Status</option>
                    </select>
                    <i class="fa-solid fa-globe absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" placeholder="Cari nama, NIK, kode booking..." class="pl-9 pr-4 py-3 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                    <i class="fa-solid fa-search absolute left-3 top-4 text-blue-500"></i>
                </div>
                <button class="border border-gray-200 rounded-lg p-2 text-gray-500 hover:bg-gray-50 transition-colors w-11 flex items-center justify-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><i class="fa-solid fa-filter text-lg"></i></button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 border-b border-gray-100">
                        <th class="px-4 py-4 w-10 text-center"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                        <th class="px-4 py-4 text-center">No.</th>
                        <th class="px-4 py-4">Tanggal & Waktu</th>
                        <th class="px-4 py-4">Nama Pemesan</th>
                        <th class="px-4 py-4 text-center">NIK</th>
                        <th class="px-4 py-4">Departemen</th>
                        <th class="px-4 py-4">Ruangan</th>
                        <th class="px-4 py-4">Kode Booking</th>
                        <th class="px-4 py-4 text-center">Status Check-in</th>
                        <th class="px-4 py-4 text-center">Waktu Check-in</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @php
                    $checks = [
                        ['no'=>1, 'datetime'=>"01 Sep 2026\n09:45", 'name'=>'Andi Pratama', 'nik'=>'202401001', 'dept'=>'Produksi', 'room'=>'Ruang Meeting A', 'code'=>'BK-202609001', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'09:47', 'c_dept'=>'blue'],
                        ['no'=>2, 'datetime'=>"01 Sep 2026\n10:20", 'name'=>'Siti Rahma', 'nik'=>'202401002', 'dept'=>'PPIC', 'room'=>'Ruang Meeting B', 'code'=>'BK-202609002', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'10:22', 'c_dept'=>'purple'],
                        ['no'=>3, 'datetime'=>"01 Sep 2026\n13:10", 'name'=>'Budi Santoso', 'nik'=>'202401003', 'dept'=>'Maintenance', 'room'=>'Ruang Training', 'code'=>'BK-202609003', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'13:12', 'c_dept'=>'orange'],
                        ['no'=>4, 'datetime'=>"01 Sep 2026\n14:00", 'name'=>'Rina Wulandari', 'nik'=>'202401004', 'dept'=>'HRD', 'room'=>'Ruang Meeting A', 'code'=>'BK-202609004', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'14:03', 'c_dept'=>'pink'],
                        ['no'=>5, 'datetime'=>"01 Sep 2026\n15:30", 'name'=>'Agus Setiawan', 'nik'=>'202401005', 'dept'=>'Finance', 'room'=>'Ruang Meeting C', 'code'=>'BK-202609005', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'15:32', 'c_dept'=>'teal'],
                        ['no'=>6, 'datetime'=>"01 Sep 2026\n16:15", 'name'=>'Dewi Lestari', 'nik'=>'202401006', 'dept'=>'IT', 'room'=>'Ruang Training', 'code'=>'BK-202609006', 'status'=>'Terlambat', 'sc'=>'orange', 'waktu'=>'16:28', 'c_dept'=>'blue'],
                        ['no'=>7, 'datetime'=>"01 Sep 2026\n08:50", 'name'=>'Fajar Nugroho', 'nik'=>'202401007', 'dept'=>'Marketing', 'room'=>'Ruang Meeting B', 'code'=>'BK-202609007', 'status'=>'Tidak Check-in', 'sc'=>'gray', 'waktu'=>'-', 'c_dept'=>'yellow'],
                        ['no'=>8, 'datetime'=>"01 Sep 2026\n11:05", 'name'=>'Arif Hidayat', 'nik'=>'202201008', 'dept'=>'Purchasing', 'room'=>'Ruang Workshop', 'code'=>'BK-202609008', 'status'=>'Check-in', 'sc'=>'teal', 'waktu'=>'11:08', 'c_dept'=>'purple'],
                    ];
                    @endphp

                    @foreach($checks as $c)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></td>
                        <td class="px-4 py-3 text-center">{{ $c['no'] }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-pre-line">{{ $c['datetime'] }}</td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=EBF4FF&color=1D4ED8" class="w-7 h-7 rounded-full border border-gray-200">
                            <span class="text-gray-800 font-semibold">{{ $c['name'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs text-center">{{ $c['nik'] }}</td>
                        <td class="px-4 py-3 text-xs">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-{{ $c['c_dept'] }}-50 text-{{ $c['c_dept'] }}-600 text-[10px] font-medium border border-{{ $c['c_dept'] }}-100"><i class="fa-solid fa-star text-[8px]"></i> {{ $c['dept'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $c['room'] }}</td>
                        <td class="px-4 py-3 text-blue-500 text-xs font-medium">{{ $c['code'] }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-{{ $c['sc'] }}-50 text-{{ $c['sc'] }}-600 text-[10px] font-medium border border-{{ $c['sc'] }}-100">
                                @if($c['sc'] != 'gray')
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $c['sc'] }}-500"></span>
                                @endif
                                {{ $c['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-600 text-xs">{{ $c['waktu'] }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Lihat"><i class="fa-solid fa-eye text-[10px]"></i></button>
                                <button class="w-7 h-7 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-200 transition-colors flex items-center justify-center"><i class="fa-solid fa-ellipsis-horizontal text-[10px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
            <span class="text-sm text-gray-500">Menampilkan 1 - 8 dari 8 data</span>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-white hover:text-gray-600 bg-white"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-600 text-white font-medium text-sm shadow-sm shadow-blue-200">1</button>
                <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-white hover:text-gray-600 bg-white"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection
