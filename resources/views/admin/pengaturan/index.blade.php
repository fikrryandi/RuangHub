@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <div class="flex justify-end mb-6">
        <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="bg-blue-100 p-2.5 rounded-xl text-blue-600">
                <i class="fa-solid fa-gear text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Versi Sistem</p>
                <h3 class="text-xl font-bold text-gray-800 leading-none my-1">v1.0.0</h3>
                <p class="text-[10px] text-teal-600 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Sistem berjalan normal</p>
            </div>
        </div>
    </div>


    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1 space-y-6 w-full">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Informasi Perusahaan -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-building"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Informasi Perusahaan</h2>
                                <p class="text-xs text-gray-500">Kelola informasi dasar perusahaan.</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1 space-y-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Nama Perusahaan</label>
                                        <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'RuangHub' }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Alamat</label>
                                        <input type="text" name="company_address" value="{{ $settings['company_address'] ?? 'Jl. Melati No. 12, Jakarta Selatan' }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1.5">Email</label>
                                            <input type="email" name="company_email" value="{{ $settings['company_email'] ?? 'info@ruanghub.com' }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1.5">No. Telepon</label>
                                            <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '021-12345678' }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors">
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-40 flex flex-col items-center justify-start pt-6">
                                    <div class="w-32 h-32 bg-blue-50 border-2 border-dashed border-blue-200 rounded-2xl flex items-center justify-center text-blue-500 mb-3 overflow-hidden relative">
                                        @if(isset($settings['company_logo']))
                                            <img id="logoPreview" src="{{ asset('storage/' . $settings['company_logo']) }}" class="w-full h-full object-cover">
                                        @else
                                            <img id="logoPreview" class="w-full h-full object-cover hidden">
                                            <i id="logoIcon" class="fa-solid fa-building text-5xl"></i>
                                        @endif
                                    </div>
                                    <input type="file" name="company_logo" id="company_logo" accept="image/*" class="hidden" onchange="previewImage(event)">
                                    <button type="button" onclick="document.getElementById('company_logo').click()" class="text-blue-600 bg-white border border-blue-200 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-semibold transition-colors flex items-center gap-2">
                                        <i class="fa-regular fa-image"></i> Ubah Logo
                                    </button>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Integrasi Kalender -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-regular fa-calendar"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Integrasi Kalender</h2>
                                <p class="text-xs text-gray-500">Sinkronisasi dengan kalender eksternal.</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-lg flex items-center justify-center text-red-500 text-xl"><i class="fa-brands fa-google"></i></div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Google Calendar</h4>
                                        <p class="text-xs text-gray-500">Sinkronisasi jadwal ke Google Calendar.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="google-toggle" checked class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-blue-500 appearance-none cursor-pointer translate-x-5 transition-transform duration-200"/>
                                    <label for="google-toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-blue-500 cursor-pointer"></label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-lg flex items-center justify-center text-blue-600 text-xl"><i class="fa-brands fa-windows"></i></div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Microsoft Outlook</h4>
                                        <p class="text-xs text-gray-500">Sinkronisasi jadwal ke Outlook Calendar.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="outlook-toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer transition-transform duration-200"/>
                                    <label for="outlook-toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backup & Restore -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-database"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Backup & Restore</h2>
                                <p class="text-xs text-gray-500">Kelola data dan cadangan sistem.</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                            <div class="flex items-center gap-4 mb-4 sm:mb-0">
                                <div class="w-10 h-10 bg-white shadow-sm border border-gray-200 rounded-lg flex items-center justify-center text-blue-500"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-gray-800 text-sm">Jadwal Backup Otomatis</h4>
                                        <span class="bg-green-50 text-green-600 text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 border border-green-100"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Setiap hari pukul 02:00 WIB</p>
                                </div>
                            </div>
                            <button class="text-blue-600 bg-white border border-blue-200 hover:bg-blue-50 px-4 py-2 rounded-lg text-xs font-semibold transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Jalankan Backup Sekarang
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Pengaturan Umum -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-gear"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Pengaturan Umum</h2>
                                <p class="text-[11px] text-gray-500">Atur konfigurasi dasar aplikasi.</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex gap-3">
                                    <i class="fa-solid fa-gear text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Mode Maintenance</h4>
                                        <p class="text-[10px] text-gray-500">Nonaktifkan semua fitur untuk keperluan maintenance.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-8 align-middle select-none transition duration-200 ease-in flex-shrink-0">
                                    <input type="checkbox" id="maint-toggle" class="toggle-checkbox absolute block w-4 h-4 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer transition-transform duration-200"/>
                                    <label for="maint-toggle" class="toggle-label block overflow-hidden h-4 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex gap-3">
                                    <i class="fa-regular fa-clock text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Jam Kerja</h4>
                                        <p class="text-[10px] text-gray-500">Atur jam operasional pemesanan ruangan.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-8 align-middle select-none transition duration-200 ease-in flex-shrink-0">
                                    <input type="checkbox" id="jam-toggle" checked class="toggle-checkbox absolute block w-4 h-4 rounded-full bg-white border-4 border-blue-500 appearance-none cursor-pointer translate-x-4 transition-transform duration-200"/>
                                    <label for="jam-toggle" class="toggle-label block overflow-hidden h-4 rounded-full bg-blue-500 cursor-pointer"></label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50 cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                                <div class="flex gap-3">
                                    <i class="fa-solid fa-globe text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Zona Waktu</h4>
                                        <p class="text-[10px] text-gray-500">Waktu sistem menggunakan zona WIB (GMT+7).</p>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                            </div>
                            <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                                <div class="flex gap-3">
                                    <i class="fa-solid fa-language text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Bahasa Aplikasi</h4>
                                        <p class="text-[10px] text-gray-500">Gunakan bahasa Indonesia sebagai bahasa utama.</p>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Notifikasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-bell"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Pengaturan Notifikasi</h2>
                                <p class="text-[11px] text-gray-500">Atur preferensi notifikasi sistem.</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex gap-3">
                                    <i class="fa-regular fa-envelope text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Notifikasi Email</h4>
                                        <p class="text-[10px] text-gray-500">Terima notifikasi melalui email.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-8 align-middle select-none transition duration-200 ease-in flex-shrink-0">
                                    <input type="checkbox" id="email-toggle" checked class="toggle-checkbox absolute block w-4 h-4 rounded-full bg-white border-4 border-blue-500 appearance-none cursor-pointer translate-x-4 transition-transform duration-200"/>
                                    <label for="email-toggle" class="toggle-label block overflow-hidden h-4 rounded-full bg-blue-500 cursor-pointer"></label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex gap-3">
                                    <i class="fa-regular fa-bell text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Notifikasi Aplikasi</h4>
                                        <p class="text-[10px] text-gray-500">Terima notifikasi di dalam aplikasi.</p>
                                    </div>
                                </div>
                                <div class="relative inline-block w-8 align-middle select-none transition duration-200 ease-in flex-shrink-0">
                                    <input type="checkbox" id="app-notif-toggle" checked class="toggle-checkbox absolute block w-4 h-4 rounded-full bg-white border-4 border-blue-500 appearance-none cursor-pointer translate-x-4 transition-transform duration-200"/>
                                    <label for="app-notif-toggle" class="toggle-label block overflow-hidden h-4 rounded-full bg-blue-500 cursor-pointer"></label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                                <div class="flex gap-3">
                                    <i class="fa-regular fa-clock text-blue-500 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-[13px]">Notifikasi Reminder</h4>
                                        <p class="text-[10px] text-gray-500">Peringatan sebelum jadwal dimulai (15 menit).</p>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Ubah Kata Sandi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-lock"></i></div>
                            <div>
                                <h2 class="font-bold text-gray-800 text-sm">Ubah Kata Sandi</h2>
                                <p class="text-[11px] text-gray-500">Pastikan keamanan akun Anda.</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Toggle Switch styling override */
.toggle-checkbox:checked {
  right: 0;
  border-color: #3B82F6;
}
.toggle-checkbox:checked + .toggle-label {
  background-color: #3B82F6;
}
.toggle-checkbox {
    right: 0;
    transition: all 0.3s;
}
</style>

<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logoPreview');
            const icon = document.getElementById('logoIcon');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(icon) icon.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection