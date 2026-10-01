@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10" x-data="{ showAddModal: false, showEditModal: false, editBooking: {} }">
    <div class="flex justify-end mb-6">
        <button @click="showAddModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Booking
        </button>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10">
                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none">{{ $totalBookings }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-calendar absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10">
                <p class="text-teal-100 text-sm font-medium">Booking Aktif</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none">{{ $activeBookings }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-check absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10">
                <p class="text-purple-100 text-sm font-medium">Menunggu Konfirmasi</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none">{{ $pendingBookings }}</h3>
                </div>
            </div>
            <i class="fa-regular fa-clock absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10">
                <p class="text-orange-100 text-sm font-medium">Selesai</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none">{{ $doneBookings }}</h3>
                </div>
            </div>
            <i class="fa-solid fa-check-double absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>

        <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <i class="fa-solid fa-chevron-right text-white/50"></i>
            </div>
            <div class="z-10">
                <p class="text-pink-100 text-sm font-medium">Dibatalkan</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-bold leading-none">{{ $canceledBookings }}</h3>
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
                    <div class="flex items-center pl-3 pr-2 py-2 bg-white border border-gray-200 rounded-lg w-56">
                        <i class="fa-regular fa-calendar text-blue-500 mr-2 text-sm"></i>
                        <div class="text-xs">
                            <span class="text-gray-400 block">Rentang Tanggal</span>
                            <span class="text-gray-700 font-medium">01 Sep 2026 - 30 Sep 2026</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs ml-auto"></i>
                    </div>
                </div>
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-36 h-11">
                        <option>Semua User</option>
                    </select>
                    <i class="fa-solid fa-users absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-44 h-11">
                        <option>Semua Ruangan</option>
                    </select>
                    <i class="fa-solid fa-door-open absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none pl-9 pr-8 py-3.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-40 h-11">
                        <option>Semua Status</option>
                    </select>
                    <i class="fa-solid fa-layer-group absolute left-3 top-3.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-4 text-gray-400 text-xs"></i>
                </div>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" placeholder="Cari kode booking, nama, ruangan..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64 h-11">
                    <i class="fa-solid fa-search absolute left-3 top-3.5 text-blue-500"></i>
                </div>
                <button class="border border-gray-200 rounded-lg p-2 text-gray-500 hover:bg-gray-50 transition-colors h-11 w-11 flex items-center justify-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><i class="fa-solid fa-filter text-lg"></i></button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white uppercase tracking-wider border-b border-blue-700">
                        <th class="px-5 py-4 w-10 text-center rounded-tl-lg"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                        <th class="px-5 py-4 text-center">No.</th>
                        <th class="px-5 py-4">Kode Booking</th>
                        <th class="px-5 py-4">Nama Pemesan</th>
                        <th class="px-5 py-4">Ruangan</th>
                        <th class="px-5 py-4">Tanggal Booking</th>
                        <th class="px-5 py-4 text-center">Waktu</th>
                        <th class="px-5 py-4 text-center">Durasi</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody id="live-table-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($bookings as $b)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-center"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></td>
                        <td class="px-5 py-3 text-center">{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ $b->code }}</td>
                        <td class="px-5 py-3 flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($b->user->name) }}&background=EBF4FF&color=1D4ED8" class="w-6 h-6 rounded-full">
                            <span class="text-gray-700">{{ $b->user->name }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $b->room->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $b->date->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-center text-gray-600">{{ $b->start_time->format('H:i') }} - {{ $b->end_time->format('H:i') }}</td>
                        <td class="px-5 py-3 text-center text-gray-600">
                            @php
                                $start = \Carbon\Carbon::parse($b->start_time);
                                $end = \Carbon\Carbon::parse($b->end_time);
                                echo $start->diffInHours($end) . ' Jam';
                            @endphp
                        </td>
                        <td class="px-5 py-3 text-center">
                            @php
                                $c = 'gray';
                                if($b->status == 'disetujui' || $b->status == 'selesai') $c = 'teal';
                                else if($b->status == 'menunggu_approval' || $b->status == 'revisi') $c = 'orange';
                                else if($b->status == 'ditolak' || $b->status == 'dibatalkan' || $b->status == 'kadaluarsa') $c = 'red';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-{{ $c }}-50 text-{{ $c }}-600 text-xs font-medium border border-{{ $c }}-100 capitalize"><span class="w-1.5 h-1.5 rounded-full bg-{{ $c }}-500"></span> {{ str_replace('_', ' ', $b->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editBooking = { id: {{ $b->id }}, user_id: '{{ $b->user_id }}', room_id: '{{ $b->room_id }}', date: '{{ $b->date->format('Y-m-d') }}', start_time: '{{ $b->start_time->format('H:i') }}', end_time: '{{ $b->end_time->format('H:i') }}', purpose: '{{ addslashes($b->purpose) }}', notes: '{{ addslashes($b->notes) }}', status: '{{ $b->status }}' }; showEditModal = true;" class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Edit"><i class="fa-solid fa-pen text-[10px]"></i></button>
                                <form action="{{ route('booking.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center" title="Hapus"><i class="fa-solid fa-trash text-[10px]"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-5 py-8 text-center text-gray-500">Tidak ada data booking.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50">
            {{ $bookings->links() }}
        </div>
    </div>

    <!-- Modal Tambah Booking -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.away="showAddModal = false">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-600 text-white">
                <h3 class="font-bold text-lg">Tambah Booking</h3>
                <button @click="showAddModal = false" class="text-white/70 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form action="{{ route('booking.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">User / Pemesan <span class="text-red-500">*</span></label>
                        <select name="user_id" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ruangan <span class="text-red-500">*</span></label>
                        <select name="room_id" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->name }} (Kapasitas: {{ $r->capacity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl font-medium transition-colors shadow-sm shadow-blue-200">Simpan Booking</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Booking -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.away="showEditModal = false">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-600 text-white">
                <h3 class="font-bold text-lg">Edit Booking</h3>
                <button @click="showEditModal = false" class="text-white/70 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form :action="'{{ url('admin/booking') }}/' + editBooking.id" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">User / Pemesan <span class="text-red-500">*</span></label>
                        <select name="user_id" x-model="editBooking.user_id" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ruangan <span class="text-red-500">*</span></label>
                        <select name="room_id" x-model="editBooking.room_id" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->name }} (Kapasitas: {{ $r->capacity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" x-model="editBooking.date" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" x-model="editBooking.start_time" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" x-model="editBooking.end_time" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" x-model="editBooking.purpose" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes" x-model="editBooking.notes" rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" x-model="editBooking.status" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="menunggu_approval">Menunggu Approval</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="revisi">Revisi</option>
                            <option value="dibatalkan">Dibatalkan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl font-medium transition-colors shadow-sm shadow-blue-200">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection