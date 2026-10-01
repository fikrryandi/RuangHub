@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10"
     x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        editUser: {},
        deleteUser: {},
        openEdit(user) { this.editUser = user; this.showEditModal = true; },
        openDelete(user) { this.deleteUser = user; this.showDeleteModal = true; }
     }">

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-end mb-6">
        <button @click="showAddModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah User
        </button>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10"><div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center"><i class="fa-solid fa-users"></i></div><i class="fa-solid fa-chevron-right text-white/50"></i></div>
            <div class="z-10"><p class="text-blue-100 text-sm font-medium">Total User</p><h3 class="text-3xl font-bold leading-none">{{ $users->total() }}</h3></div>
            <i class="fa-solid fa-users absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-teal-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10"><div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center"><i class="fa-solid fa-user"></i></div><i class="fa-solid fa-chevron-right text-white/50"></i></div>
            <div class="z-10"><p class="text-teal-100 text-sm font-medium">Karyawan</p><h3 class="text-3xl font-bold leading-none">{{ $totalKaryawan }}</h3></div>
            <i class="fa-solid fa-user absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10"><div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center"><i class="fa-solid fa-shield-halved"></i></div><i class="fa-solid fa-chevron-right text-white/50"></i></div>
            <div class="z-10"><p class="text-purple-100 text-sm font-medium">Approver</p><h3 class="text-3xl font-bold leading-none">{{ $totalApprover }}</h3></div>
            <i class="fa-solid fa-shield-halved absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex justify-between items-start z-10"><div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center"><i class="fa-solid fa-gear"></i></div><i class="fa-solid fa-chevron-right text-white/50"></i></div>
            <div class="z-10"><p class="text-orange-100 text-sm font-medium">Admin</p><h3 class="text-3xl font-bold leading-none">{{ $totalAdmin }}</h3></div>
            <i class="fa-solid fa-gear absolute -bottom-4 -right-2 text-7xl text-white opacity-10"></i>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filters -->
        <form method="GET" action="{{ route('user.index') }}" class="p-5 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between">
            <div class="flex flex-wrap gap-3">
                <div class="relative">
                    <select name="role" onchange="this.form.submit()" class="appearance-none pl-9 pr-8 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-40">
                        <option>Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="approver" {{ request('role') == 'approver' ? 'selected' : '' }}>Approver</option>
                        <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                    <i class="fa-solid fa-user-shield absolute left-3 top-2.5 text-blue-500"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, email..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                    <i class="fa-solid fa-search absolute left-3 top-2.5 text-blue-500"></i>
                </div>
                <button type="submit" class="border border-gray-200 rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-blue-500 font-medium text-sm">Cari</button>
                <a href="{{ route('admin.export.users') }}" class="bg-green-50 text-green-600 hover:bg-green-100 rounded-lg px-4 py-2 transition-colors font-medium text-sm border border-green-200 flex items-center gap-2">
                    <i class="fa-regular fa-file-excel"></i> Export
                </a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-xs font-semibold text-white border-b border-blue-700">
                        <th class="px-5 py-4 w-10 text-center rounded-tl-lg">No.</th>
                        <th class="px-5 py-4 text-center">Foto</th>
                        <th class="px-5 py-4">Nama</th>
                        <th class="px-5 py-4">NIP</th>
                        <th class="px-5 py-4">Departemen</th>
                        <th class="px-5 py-4 text-center">Role</th>
                        <th class="px-5 py-4">Email</th>
                        <th class="px-5 py-4 text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody id="live-table-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($users as $u)
                    @php
                        $dept_colors = ['blue', 'purple', 'orange', 'pink', 'teal', 'yellow'];
                        $d_color = $dept_colors[$u->department_id % 6];
                        $deptBg = ['blue'=>'bg-blue-50 text-blue-600 border-blue-100','purple'=>'bg-purple-50 text-purple-600 border-purple-100','orange'=>'bg-orange-50 text-orange-600 border-orange-100','pink'=>'bg-pink-50 text-pink-600 border-pink-100','teal'=>'bg-teal-50 text-teal-600 border-teal-100','yellow'=>'bg-yellow-50 text-yellow-600 border-yellow-100'][$d_color];
                        $roleBg = $u->role == 'admin' ? 'bg-orange-50 text-orange-600 border-orange-100' : ($u->role == 'approver' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-blue-50 text-blue-600 border-blue-100');
                        $userData = json_encode($u->only(['id','name','nip','email','role','department_id']));
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td class="px-5 py-3 flex justify-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=EBF4FF&color=1D4ED8" class="w-8 h-8 rounded-full border border-gray-200">
                        </td>
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ $u->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $u->nip }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full {{ $deptBg }} text-xs font-medium border">
                                <i class="fa-solid fa-star text-[8px]"></i> {{ $u->department->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-md {{ $roleBg }} text-xs font-medium border capitalize">{{ $u->role }}</span>
                        </td>
                        <td class="px-5 py-3 text-blue-500 hover:underline">{{ $u->email }}</td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    @click="openEdit({{ \Illuminate\Support\Js::from(array_merge($u->only(['id','name','nip','email','role']), ['department_name' => $u->department?->name ?? ''])) }})"
                                    class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Edit">
                                    <i class="fa-solid fa-pen text-[10px]"></i>
                                </button>
                                <button type="button"
                                    @click="openDelete({{ \Illuminate\Support\Js::from(['id' => $u->id, 'name' => $u->name]) }})"
                                    class="w-7 h-7 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center" title="Hapus">
                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-8 text-center text-gray-500">Tidak ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- ==================== MODAL TAMBAH USER ==================== -->
    <div x-show="showAddModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
         style="display:none;">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden mx-4" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-600 text-white">
                <h3 class="font-bold text-lg">Tambah User Baru</h3>
                <button @click="showAddModal = false" class="text-white/70 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form action="{{ route('user.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="karyawan">Karyawan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                        <input type="text" name="department_name" required placeholder="Contoh: IT, HRD, Marketing..."
                               class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none placeholder-gray-300">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl font-medium transition-colors shadow-sm shadow-blue-200">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL EDIT USER ==================== -->
    <div x-show="showEditModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
         style="display:none;">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden mx-4" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-600 text-white">
                <h3 class="font-bold text-lg">Edit User: <span x-text="editUser.name" class="font-normal"></span></h3>
                <button @click="showEditModal = false" class="text-white/70 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form :action="'{{ url('admin/user') }}/' + editUser.id" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" :value="editUser.nip" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" :value="editUser.name" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" :value="editUser.email" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin diubah)</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                x-init="$watch('editUser', (val) => { if(val.role) $el.value = val.role; })">
                            <option value="karyawan">Karyawan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                        <input type="text" name="department_name" required placeholder="Contoh: IT, HRD, Marketing..."
                               :value="editUser.department_name ?? ''"
                               class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none placeholder-gray-300">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl font-medium transition-colors shadow-sm shadow-blue-200">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL HAPUS USER ==================== -->
    <div x-show="showDeleteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
         style="display:none;">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden mx-4" @click.stop>
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus User?</h3>
                <p class="text-gray-500 text-sm mb-1">Anda akan menghapus user:</p>
                <p class="text-gray-800 font-semibold mb-4" x-text="deleteUser.name"></p>
                <p class="text-red-500 text-xs mb-6">⚠ Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait user ini.</p>
                <div class="flex gap-3 justify-center">
                    <button @click="showDeleteModal = false" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors">
                        Batalkan
                    </button>
                    <form :action="'{{ url('admin/user') }}/' + deleteUser.id" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-trash text-sm"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection