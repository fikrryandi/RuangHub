@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-indigo-100 text-sm font-medium">Total Permintaan</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">{{ $bookings->total() }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-calendar-day absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-blue-100 text-sm font-medium">Menunggu Persetujuan</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">{{ $totalPending }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-clock absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-teal-100 text-sm font-medium">Disetujui</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">{{ $totalApproved }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-check absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <div class="z-10 mt-auto">
                <p class="text-orange-100 text-sm font-medium">Ditolak</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none mt-1">{{ $totalRejected }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-ban absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filters -->
        <form method="GET" action="{{ route('approval.index') }}" class="p-5 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between">
            <div class="flex flex-wrap gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="appearance-none pl-9 pr-8 py-3.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-40 h-11">
                        <option>Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <i class="fa-solid fa-layer-group absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
                <div class="relative">
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-11">
                    <i class="fa-regular fa-calendar absolute left-3 top-3.5 text-blue-500"></i>
                </div>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemesan..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64 h-11">
                    <i class="fa-solid fa-search absolute left-3 top-3.5 text-blue-500"></i>
                </div>
                <button type="submit" class="border border-gray-200 rounded-lg px-4 text-gray-500 hover:bg-gray-50 transition-colors h-11 font-medium text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">Cari</button>
                <a href="{{ route('admin.export.approvals', request()->all()) }}" class="bg-green-50 text-green-600 hover:bg-green-100 rounded-lg px-4 transition-colors h-11 font-medium text-sm border border-green-200 flex items-center gap-2">
                    <i class="fa-regular fa-file-excel"></i> Export
                </a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white uppercase tracking-wider border-b border-blue-700">
                        <th class="px-4 py-4 text-center rounded-tl-lg">No.</th>
                        <th class="px-4 py-4">Nama Pemesan</th>
                        <th class="px-4 py-4">Ruangan</th>
                        <th class="px-4 py-4">Tanggal & Waktu</th>
                        <th class="px-4 py-4">Keperluan</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody id="live-table-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($bookings as $a)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center">{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($a->user->name) }}&background=EBF4FF&color=1D4ED8" class="w-6 h-6 rounded-full">
                            <span class="text-gray-700 font-semibold">{{ $a->user->name }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $a->room->name }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            <div class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($a->start_time)->format('d M Y') }}</div>
                            <div>{{ \Carbon\Carbon::parse($a->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($a->end_time)->format('H:i') }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $a->purpose }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $c = $a->status == 'menunggu_approval' ? 'orange' : ($a->status == 'disetujui' ? 'teal' : 'pink');
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-{{ $c }}-50 text-{{ $c }}-600 text-[10px] font-medium border border-{{ $c }}-100 uppercase"><span class="w-1.5 h-1.5 rounded-full bg-{{ $c }}-500"></span> {{ str_replace('_', ' ', $a->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1.5" x-data="{ showDetail: false }">
                                <button @click="showDetail = true" class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Lihat Detail"><i class="fa-solid fa-eye text-xs"></i></button>
                                @if($a->status == 'menunggu_approval')
                                <form action="{{ route('approval.update', $a->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="w-7 h-7 rounded-full bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-colors flex items-center justify-center" title="Approve"><i class="fa-solid fa-check text-xs"></i></button>
                                </form>
                                <form action="{{ route('approval.update', $a->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="w-7 h-7 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center" title="Reject"><i class="fa-solid fa-xmark text-xs"></i></button>
                                </form>
                                @endif

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
                                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Detail Booking</h3>
                                                        <div class="space-y-3">
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Pemohon</span>
                                                                <span class="w-2/3 text-sm text-gray-800 font-semibold">{{ $a->user->name }}</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Ruangan</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ $a->room->name }}</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Waktu</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }} ({{ \Carbon\Carbon::parse($a->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($a->end_time)->format('H:i') }})</span>
                                                            </div>
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Keperluan</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ $a->purpose }}</span>
                                                            </div>
                                                            @if($a->notes)
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Catatan</span>
                                                                <span class="w-2/3 text-sm text-gray-800">{{ $a->notes }}</span>
                                                            </div>
                                                            @endif
                                                            <div class="flex border-b border-gray-100 pb-2">
                                                                <span class="w-1/3 text-sm text-gray-500 font-medium">Status</span>
                                                                <span class="w-2/3 text-sm text-gray-800 capitalize">{{ str_replace('_', ' ', $a->status) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                                <form action="{{ route('booking.destroy', $a->id) }}" method="POST" class="w-full sm:w-auto">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:text-sm">
                                                        <i class="fa-solid fa-trash mr-2"></i> Hapus Riwayat
                                                    </button>
                                                </form>
                                                <button type="button" @click="showDetail = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada permintaan booking.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection