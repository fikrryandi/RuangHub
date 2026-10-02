@extends('layouts.karyawan')

@section('content')
<div class="relative z-10 px-8 pb-10"
     x-data="{
         showUbahData: {{ $errors->hasAny(['name','nip','phone','gender','birth_place','birth_date','address']) ? 'true' : 'false' }},
         showUbahPassword: {{ $errors->hasAny(['current_password','password','password_confirmation']) || session('error_password') ? 'true' : 'false' }},
         showPassword: false
     }">

    {{-- ── Header Banner ──────────────────────────────────────────────── --}}
    <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-400 rounded-2xl p-6 shadow mb-6 flex items-center justify-between relative overflow-hidden">
        <div class="z-10">
            <p class="text-blue-100 text-sm font-medium mb-1">Halo, {{ $user->name }}</p>
            <h1 class="text-3xl font-extrabold text-white mb-1">Profil Saya</h1>
            <p class="text-blue-100 text-sm">Kelola informasi akun dan data pribadi Anda di sini.</p>
        </div>
        <div class="hidden lg:flex items-center gap-4 z-10 mr-48">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-5 py-3 text-white text-sm font-semibold leading-snug text-right">
                Profil Anda selalu<br>terjaga dan aman.
            </div>
        </div>
        {{-- Dekorasi --}}
        <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
            <svg width="260" height="120" viewBox="0 0 260 120" fill="none">
                <circle cx="200" cy="60" r="80" fill="white"/>
                <circle cx="240" cy="20" r="40" fill="white"/>
            </svg>
        </div>
        <div class="absolute right-12 bottom-0 pointer-events-none hidden md:block opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" width="180" height="100" viewBox="0 0 200 110" fill="none">
                <rect x="20" y="30" width="120" height="75" rx="8" fill="white" fill-opacity="0.15" stroke="white" stroke-opacity="0.3" stroke-width="1.5"/>
                <rect x="30" y="40" width="100" height="55" rx="4" fill="white" fill-opacity="0.1"/>
                <rect x="40" y="50" width="60" height="4" rx="2" fill="white" fill-opacity="0.4"/>
                <rect x="40" y="60" width="80" height="3" rx="1.5" fill="white" fill-opacity="0.25"/>
                <rect x="40" y="68" width="70" height="3" rx="1.5" fill="white" fill-opacity="0.25"/>
                <ellipse cx="160" cy="85" rx="22" ry="10" fill="white" fill-opacity="0.15"/>
                <rect x="148" y="40" width="28" height="45" rx="4" fill="white" fill-opacity="0.12" stroke="white" stroke-opacity="0.2"/>
                <circle cx="162" cy="30" r="14" fill="white" fill-opacity="0.2" stroke="white" stroke-opacity="0.3"/>
            </svg>
        </div>
    </div>

    {{-- ── Flash Messages ─────────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    {{-- ── 2-Column Layout ────────────────────────────────────────────── --}}
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ── Kolom Kiri: Kartu Profil ─────────────────────────── --}}
        <div class="lg:w-72 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center sticky top-20">

                {{-- Foto Profil + Upload --}}
                <form action="{{ route('karyawan.profil.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                    @csrf
                    <div class="relative inline-block mb-4">
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-blue-100 mx-auto shadow-md">
                            @if($user->photo)
                                <img src="{{ $user->photo }}" alt="Foto" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-400 text-5xl">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <label for="photoInput"
                               class="absolute bottom-1 right-1 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer shadow-lg transition-colors"
                               title="Ubah foto">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </label>
                        <input type="file" id="photoInput" name="photo" class="hidden" accept="image/jpeg,image/png,image/webp"
                               onchange="document.getElementById('photoForm').submit()">
                    </div>
                </form>

                <h2 class="text-base font-bold text-gray-800 mb-0.5">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mb-3">{{ ucfirst($user->role) }}</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-600 text-xs font-semibold border border-green-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>

                {{-- Daftar Info Singkat --}}
                <div class="mt-6 text-left space-y-4 border-t border-gray-100 pt-5">
                    <div class="flex items-start gap-3">
                        <i class="fa-regular fa-id-card text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">NIP</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $user->nip ?: '–' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-regular fa-envelope text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">Email</p>
                            <p class="text-sm font-semibold text-gray-700 break-all">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-phone text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">No. HP</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $user->phone ?: '–' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-building-user text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">Divisi</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $user->department?->name ?: '–' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-briefcase text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">Jabatan</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $user->position ?: '–' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-blue-400 mt-0.5 w-4 text-center shrink-0"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold">Alamat</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $user->address ?: '–' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Kolom Kanan: Kartu Info ─────────────────────────── --}}
        <div class="flex-1 space-y-5 min-w-0">

            {{-- ── Card 1: Informasi Pribadi ──────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-blue-700 font-bold">
                        <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-gear text-blue-600 text-xs"></i>
                        </div>
                        <span>Informasi Pribadi</span>
                    </div>
                    <button @click="showUbahData = true"
                            class="flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition-all bg-blue-50 hover:bg-blue-100 font-semibold">
                        <i class="fa-solid fa-pen text-[10px]"></i> Ubah Data
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-5">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Nama Lengkap</p>
                        <p class="font-bold text-gray-800">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Email</p>
                        <p class="font-bold text-gray-800 break-all">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">NIP</p>
                        <p class="font-bold text-gray-800">{{ $user->nip ?: '–' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">No. HP</p>
                        <p class="font-bold text-gray-800">{{ $user->phone ?: '–' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Jenis Kelamin</p>
                        <p class="font-bold text-gray-800">
                            {{ $user->gender == 'L' ? 'Laki-laki' : ($user->gender == 'P' ? 'Perempuan' : '–') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Divisi</p>
                        <p class="font-bold text-gray-800">{{ $user->department?->name ?: '–' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-gray-800">
                            @if($user->birth_place || $user->birth_date)
                                {{ $user->birth_place }}{{ ($user->birth_place && $user->birth_date) ? ', ' : '' }}{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d F Y') : '' }}
                            @else
                                –
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Jabatan</p>
                        <p class="font-bold text-gray-800">{{ $user->position ?: '–' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Alamat</p>
                        <p class="font-bold text-gray-800">{{ $user->address ?: '–' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Status Pegawai</p>
                        <p class="font-bold text-gray-800">{{ $user->employment_status ?: '–' }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Card 2: Akun & Keamanan ────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 text-blue-700 font-bold">
                    <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-shield-halved text-blue-600 text-xs"></i>
                    </div>
                    <span>Akun &amp; Keamanan</span>
                </div>
                <div class="p-6">
                    {{-- Flash errors untuk password --}}
                    @if(session('error_password'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-xmark text-red-500"></i> {{ session('error_password') }}
                    </div>
                    @endif
                    @if(session('success_password'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success_password') }}
                    </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-5 mb-5">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Username</p>
                            <p class="font-bold text-gray-800">{{ explode('@', $user->email)[0] }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Password</p>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-gray-800 tracking-widest text-lg leading-none" x-show="!showPassword">••••••••••</p>
                                <p class="font-bold text-gray-800" x-show="showPassword" x-cloak>{{ str_repeat('*', 10) }}</p>
                                <button type="button" @click="showPassword = !showPassword"
                                        class="text-gray-400 hover:text-blue-500 transition-colors ml-1">
                                    <i class="fa-regular text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide font-semibold mb-1">Terakhir Login</p>
                            <p class="font-bold text-gray-800">
                                {{ $user->last_login_at
                                    ? \Carbon\Carbon::parse($user->last_login_at)->translatedFormat('d M Y, H:i') . ' WIB'
                                    : '–' }}
                            </p>
                        </div>
                    </div>

                    <button @click="showUbahPassword = true"
                            class="inline-flex items-center gap-2 text-sm bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold border border-blue-200 hover:border-blue-300 px-4 py-2.5 rounded-xl transition-all">
                        <i class="fa-solid fa-lock text-xs"></i> Ubah Password
                    </button>
                </div>
            </div>

            {{-- ── Card 3: Dokumen Pendukung ───────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 text-blue-700 font-bold">
                    <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fa-regular fa-file-lines text-blue-600 text-xs"></i>
                    </div>
                    <span>Dokumen Pendukung</span>
                </div>
                @php
                    $docTypes = [
                        ['label' => 'KTP',                  'key' => 'ktp'],
                        ['label' => 'NPWP',                 'key' => 'npwp'],
                        ['label' => 'BPJS Kesehatan',       'key' => 'bpjs_kesehatan'],
                        ['label' => 'BPJS Ketenagakerjaan', 'key' => 'bpjs_ketenagakerjaan'],
                    ];
                @endphp
                <div class="divide-y divide-gray-50">
                    @foreach($docTypes as $dt)
                    @php $doc = $user->documents->where('type', $dt['key'])->first(); @endphp
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-blue-50/30 transition-colors cursor-pointer group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                <i class="fa-regular fa-file-lines text-sm"></i>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm">{{ $dt['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($doc && $doc->status === 'terverifikasi')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold border border-green-100">
                                    <i class="fa-solid fa-check text-[8px]"></i> Terverifikasi
                                </span>
                            @elseif($doc)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[10px] font-bold border border-orange-100">
                                    <i class="fa-solid fa-hourglass-half text-[8px]"></i> Menunggu Verifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-50 text-gray-400 text-[10px] font-bold border border-gray-100">
                                    <i class="fa-solid fa-cloud-arrow-up text-[8px]"></i> Belum Upload
                                </span>
                            @endif
                            <i class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-blue-400 transition-colors"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════ --}}
    {{-- Modal: Ubah Data Diri                                               --}}
    {{-- ════════════════════════════════════════════════════════════════════ --}}
    <div x-show="showUbahData"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;"
         @keydown.escape.window="showUbahData = false">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showUbahData = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden">
            {{-- Header Modal --}}
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-pen"></i>
                    <span class="font-bold">Ubah Data Diri</span>
                </div>
                <button @click="showUbahData = false" class="text-white/70 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('karyawan.profil.update') }}" method="POST" class="p-6 space-y-4 overflow-y-auto max-h-[70vh]">
                @csrf
                @if($errors->any() && !$errors->hasAny(['current_password','password','password_confirmation']))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Jenis Kelamin</label>
                        <select name="gender" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors appearance-none">
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Alamat</label>
                        <textarea name="address" rows="2" placeholder="Masukkan alamat lengkap..."
                                  class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors resize-none">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" @click="showUbahData = false"
                            class="px-5 py-2.5 text-sm text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors font-semibold shadow-sm shadow-blue-200 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════ --}}
    {{-- Modal: Ubah Password                                                --}}
    {{-- ════════════════════════════════════════════════════════════════════ --}}
    <div x-show="showUbahPassword"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;"
         @keydown.escape.window="showUbahPassword = false">

        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showUbahPassword = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-lock"></i>
                    <span class="font-bold">Ubah Password</span>
                </div>
                <button @click="showUbahPassword = false" class="text-white/70 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('karyawan.profil.password') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @if($errors->hasAny(['current_password','password','password_confirmation']))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->get('current_password') as $e) <li>{{ $e }}</li> @endforeach
                        @foreach($errors->get('password') as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
                @endif
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Password Saat Ini <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors"
                           placeholder="Masukkan password saat ini">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors"
                           placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors"
                           placeholder="Ulangi password baru">
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" @click="showUbahPassword = false"
                            class="px-5 py-2.5 text-sm text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors font-semibold shadow-sm shadow-blue-200 flex items-center gap-2">
                        <i class="fa-solid fa-key text-xs"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection