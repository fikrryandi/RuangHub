@extends('layouts.admin')

@section('content')
<style>
@keyframes modalIn {
    0%   { opacity: 0; transform: scale(.94) translateY(10px); }
    100% { opacity: 1; transform: scale(1)   translateY(0); }
}
@keyframes shakeX {
    0%,100%{transform:translateX(0)} 20%,60%{transform:translateX(-6px)} 40%,80%{transform:translateX(6px)}
}
.modal-enter { animation: modalIn .25s cubic-bezier(.22,.61,.36,1) forwards; }
.shake       { animation: shakeX .4s ease; }
</style>

<div class="relative z-10 px-8 pb-10"
     x-data="{
         showAdd:    false,
         showEdit:   false,
         showDelete: false,
         showSuccess: false,
         successMsg: '',
         editRoom:   {},
         deleteRoom: {},

         openEdit(room) {
             this.editRoom   = {...room};
             this.showEdit   = true;
         },
         openDelete(room) {
             this.deleteRoom = {...room};
             this.showDelete = true;
         },
         flashSuccess(msg) {
             this.successMsg  = msg;
             this.showSuccess = true;
             setTimeout(() => this.showSuccess = false, 4000);
         }
     }">

    {{-- ── Flash ──────────────────────────────────────────────────── --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition
         class="mb-5 flex items-center gap-3 bg-teal-50 border border-teal-200 text-teal-700 px-4 py-3 rounded-2xl text-sm shadow-sm">
        <i class="fa-solid fa-circle-check text-teal-500 text-base"></i>
        <span class="flex-1 font-medium">{{ session('success') }}</span>
        <button @click="show = false" class="text-teal-400 hover:text-teal-600 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    {{-- ── Stat Cards ──────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <p class="text-indigo-100 text-xs font-medium">Total Ruangan</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalAktif + $totalMaintenance + $totalNonaktif }}</h3>
            <i class="fa-solid fa-layer-group absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <p class="text-blue-100 text-xs font-medium">Ruangan Aktif</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalAktif }}</h3>
            <i class="fa-solid fa-door-open absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                <i class="fa-solid fa-wrench"></i>
            </div>
            <p class="text-teal-100 text-xs font-medium">Dalam Maintenance</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalMaintenance }}</h3>
            <i class="fa-solid fa-wrench absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                <i class="fa-solid fa-ban"></i>
            </div>
            <p class="text-orange-100 text-xs font-medium">Tidak Aktif</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalNonaktif }}</h3>
            <i class="fa-solid fa-ban absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-3">
                <i class="fa-solid fa-users"></i>
            </div>
            <p class="text-purple-100 text-xs font-medium">Total Kapasitas</p>
            <h3 class="text-3xl font-bold mt-1">{{ $rooms->sum('capacity') }}</h3>
            <i class="fa-solid fa-users absolute -bottom-4 -right-4 text-7xl text-white opacity-10"></i>
        </div>
    </div>

    {{-- ── Table ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Toolbar --}}
        <form method="GET" action="{{ route('ruangan.index') }}"
              class="p-5 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between bg-gray-50/30">
            <div class="flex flex-wrap gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()"
                            class="appearance-none pl-9 pr-8 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 w-40">
                        <option value="">Semua Status</option>
                        <option value="aktif"       {{ request('status') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="nonaktif"    {{ request('status') == 'nonaktif'    ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <i class="fa-solid fa-layer-group absolute left-3 top-3 text-blue-500 text-xs"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                </div>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama / kode..."
                           class="pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 w-56">
                    <i class="fa-solid fa-search absolute left-3 top-3 text-blue-500 text-xs"></i>
                </div>
                <button type="submit" class="px-4 py-2.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl text-sm font-semibold transition-colors">
                    Cari
                </button>
            </div>
            <div class="flex gap-2 items-center">
                <a href="{{ route('admin.export.rooms') }}" class="bg-green-50 text-green-600 hover:bg-green-100 rounded-xl px-4 py-2.5 font-semibold text-sm border border-green-200 flex items-center gap-2 transition-colors">
                    <i class="fa-regular fa-file-excel"></i> Export
                </a>
                <button type="button" @click="showAdd = true"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Ruangan
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white uppercase tracking-wider">
                        <th class="px-5 py-4 w-12 text-center">No.</th>
                        <th class="px-5 py-4">Kode</th>
                        <th class="px-5 py-4">Nama Ruangan</th>
                        <th class="px-5 py-4 text-center">Kapasitas</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($rooms as $r)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-5 py-4 text-center text-gray-400 text-xs">
                            {{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded-lg border border-blue-100">{{ $r->code }}</span>
                        </td>
                        <td class="px-5 py-4 font-bold text-gray-800">{{ $r->name }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="flex items-center justify-center gap-1.5 text-sm text-gray-700">
                                <i class="fa-solid fa-users text-blue-400 text-xs"></i>{{ $r->capacity }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @php $sc = $r->status == 'aktif' ? 'teal' : ($r->status == 'maintenance' ? 'orange' : 'gray'); @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-{{ $sc }}-50 text-{{ $sc }}-600 text-[10px] font-bold border border-{{ $sc }}-100 uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $sc }}-500"></span>{{ $r->status }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit --}}
                                <button type="button"
                                        @click="openEdit({ id: {{ $r->id }}, code: '{{ $r->code }}', name: '{{ addslashes($r->name) }}', capacity: '{{ $r->capacity }}', status: '{{ $r->status }}', location: '{{ addslashes($r->location ?? '') }}', description: '{{ addslashes($r->description ?? '') }}' })"
                                        class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:-translate-y-0.5"
                                        title="Edit Ruangan">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                {{-- Delete --}}
                                <button type="button"
                                        @click="openDelete({ id: {{ $r->id }}, code: '{{ $r->code }}', name: '{{ addslashes($r->name) }}' })"
                                        class="w-8 h-8 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:-translate-y-0.5"
                                        title="Hapus Ruangan">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i class="fa-solid fa-building text-4xl text-gray-200 block mb-3"></i>
                            <p class="text-gray-500 text-sm">Tidak ada data ruangan ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rooms->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/30">
            {{ $rooms->links() }}
        </div>
        @endif
    </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- MODAL: Tambah Ruangan                                        --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    <div x-show="showAdd"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showAdd = false"></div>
        <div class="modal-enter relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden z-10" @click.stop>
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center justify-between text-white relative overflow-hidden">
                <div class="flex items-center gap-3 z-10">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-plus text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Tambah Ruangan Baru</h3>
                        <p class="text-[10px] text-blue-100">Isi semua field yang diperlukan</p>
                    </div>
                </div>
                <button @click="showAdd = false" class="z-10 text-white/70 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
                <i class="fa-solid fa-building absolute -right-4 -bottom-4 text-6xl text-white/10 pointer-events-none"></i>
            </div>
            {{-- Form --}}
            <form action="{{ route('ruangan.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kode Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="code" required placeholder="RM-001"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" min="1" required placeholder="10"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Meeting Room A"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Lokasi</label>
                        <input type="text" name="location" placeholder="Contoh: Lantai 2"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="status" required
                                    class="w-full appearance-none px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                                <option value="aktif">Aktif</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showAdd = false"
                            class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm shadow-blue-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- MODAL: Edit Ruangan                                          --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    <div x-show="showEdit"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showEdit = false"></div>
        <div class="modal-enter relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden z-10" @click.stop>
            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-700 to-indigo-500 px-6 py-4 flex items-center justify-between text-white relative overflow-hidden">
                <div class="flex items-center gap-3 z-10">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-pen text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Edit Ruangan</h3>
                        <p class="text-[10px] text-indigo-100" x-text="editRoom.name"></p>
                    </div>
                </div>
                <button @click="showEdit = false" class="z-10 text-white/70 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
                <i class="fa-solid fa-pen-to-square absolute -right-4 -bottom-4 text-6xl text-white/10 pointer-events-none"></i>
            </div>
            {{-- Form --}}
            <form :action="'{{ url('admin/ruangan') }}/' + editRoom.id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kode Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="code" x-model="editRoom.code" required
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" x-model="editRoom.capacity" min="1" required
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="editRoom.name" required
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Lokasi</label>
                        <input type="text" name="location" x-model="editRoom.location"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="status" x-model="editRoom.status" required
                                    class="w-full appearance-none px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors outline-none">
                                <option value="aktif">Aktif</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showEdit = false"
                            class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm shadow-indigo-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- MODAL: Konfirmasi Hapus                                       --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    <div x-show="showDelete"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showDelete = false"></div>
        <div class="modal-enter relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden z-10" @click.stop>
            {{-- Top danger bar --}}
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-pink-500"></div>
            {{-- Body --}}
            <div class="p-7 text-center">
                {{-- Animated danger icon --}}
                <div class="relative w-20 h-20 mx-auto mb-5">
                    <div class="absolute inset-0 bg-red-100 rounded-full animate-ping opacity-40"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-red-100 to-red-50 rounded-full flex items-center justify-center border-2 border-red-200">
                        <i class="fa-solid fa-trash-can text-3xl text-red-500"></i>
                    </div>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Ruangan?</h3>
                <p class="text-sm text-gray-500 mb-1">Anda akan menghapus ruangan:</p>
                <div class="inline-flex items-center gap-2 bg-red-50 border border-red-100 rounded-xl px-4 py-2 mb-5">
                    <i class="fa-solid fa-building text-red-400"></i>
                    <span class="font-bold text-red-700 text-sm" x-text="deleteRoom.name + ' (' + deleteRoom.code + ')'"></span>
                </div>
                <p class="text-xs text-red-500 bg-red-50 border border-red-100 rounded-xl px-4 py-2.5 mb-6">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>. Semua data terkait ruangan akan ikut terhapus.
                </p>
                <div class="flex gap-3">
                    <button @click="showDelete = false"
                            class="flex-1 py-3 border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Batal
                    </button>
                    <form :action="'{{ url('admin/ruangan') }}/' + deleteRoom.id" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white rounded-xl text-sm font-bold transition-all shadow-md shadow-red-200 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-trash-can"></i> Ya, Hapus Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection