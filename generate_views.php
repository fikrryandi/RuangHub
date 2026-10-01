<?php
$dirs = [
    __DIR__ . '/resources/views/layouts',
    __DIR__ . '/resources/views/components',
    __DIR__ . '/resources/views/admin/dashboard',
    __DIR__ . '/resources/views/admin/ruangan',
    __DIR__ . '/resources/views/admin/user',
    __DIR__ . '/resources/views/admin/booking',
    __DIR__ . '/resources/views/admin/approval',
    __DIR__ . '/resources/views/admin/kalender',
    __DIR__ . '/resources/views/admin/laporan',
    __DIR__ . '/resources/views/admin/pengaturan',
    __DIR__ . '/resources/views/karyawan/dashboard',
    __DIR__ . '/resources/views/karyawan/booking',
    __DIR__ . '/resources/views/karyawan/kalender',
    __DIR__ . '/resources/views/karyawan/booking-saya',
    __DIR__ . '/resources/views/karyawan/profil',
];
foreach($dirs as $dir) if(!is_dir($dir)) mkdir($dir, 0777, true);

// Layout Admin
$adminLayout = <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - RuangHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7FB] font-sans antialiased text-gray-900">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Header -->
            @include('components.header')

            <!-- Main Content -->
            <main class="w-full grow p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
EOD;
file_put_contents(__DIR__ . '/resources/views/layouts/admin.blade.php', $adminLayout);

// Layout Karyawan
$karyawanLayout = str_replace('sidebar-admin', 'sidebar-karyawan', str_replace('Admin - ', 'Karyawan - ', $adminLayout));
file_put_contents(__DIR__ . '/resources/views/layouts/karyawan.blade.php', $karyawanLayout);

// Header
$header = <<<EOD
<header class="sticky top-0 bg-white border-b border-gray-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            <div class="flex items-center">
                <button class="text-gray-500 hover:text-gray-600 lg:hidden" @click="sidebarOpen = !sidebarOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden sm:block ml-4 text-sm font-semibold text-gray-700">RuangHub</div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm font-medium text-gray-500">{{ now()->format('d M Y, H:i') }}</div>
                <div class="relative">
                    <button class="flex items-center text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                    </button>
                </div>
                <div class="relative group">
                    <button class="flex items-center focus:outline-none">
                        <img class="w-8 h-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1976D2&color=fff" alt="User Avatar">
                        <span class="ml-2 text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 w-48 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
EOD;
file_put_contents(__DIR__ . '/resources/views/components/header.blade.php', $header);

// Sidebar Admin
$sidebarAdmin = <<<EOD
<div class="flex flex-col w-64 bg-blue-900 border-r border-gray-200 transition-all duration-300" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full absolute'">
    <div class="flex items-center justify-center h-16 bg-blue-950 border-b border-blue-800">
        <span class="text-white font-bold text-xl uppercase tracking-wider">RuangHub</span>
    </div>
    <div class="overflow-y-auto overflow-x-hidden flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5">
                <div class="flex flex-row items-center h-8">
                    <div class="text-sm font-light tracking-wide text-blue-300 uppercase">Menu</div>
                </div>
            </li>
            <li><a href="{{ route('admin.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Dashboard</span></a></li>
            <li><a href="{{ route('ruangan.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Data Ruangan</span></a></li>
            <li><a href="{{ route('user.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Data User</span></a></li>
            <li><a href="{{ route('booking.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Data Booking</span></a></li>
            <li><a href="{{ route('approval.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Approval</span></a></li>
            <li><a href="{{ route('admin.kalender') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Kalender</span></a></li>
            <li><a href="{{ route('admin.laporan') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Laporan</span></a></li>
            <li><a href="{{ route('admin.pengaturan') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Pengaturan</span></a></li>
        </ul>
    </div>
</div>
EOD;
file_put_contents(__DIR__ . '/resources/views/components/sidebar-admin.blade.php', $sidebarAdmin);

// Sidebar Karyawan
$sidebarKaryawan = <<<EOD
<div class="flex flex-col w-64 bg-blue-900 border-r border-gray-200 transition-all duration-300" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full absolute'">
    <div class="flex items-center justify-center h-16 bg-blue-950 border-b border-blue-800">
        <span class="text-white font-bold text-xl uppercase tracking-wider">RuangHub</span>
    </div>
    <div class="overflow-y-auto overflow-x-hidden flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5">
                <div class="flex flex-row items-center h-8">
                    <div class="text-sm font-light tracking-wide text-blue-300 uppercase">Karyawan Menu</div>
                </div>
            </li>
            <li><a href="{{ route('karyawan.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Dashboard</span></a></li>
            <li><a href="{{ route('booking.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Booking Ruangan</span></a></li>
            <li><a href="{{ route('karyawan.kalender') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Kalender</span></a></li>
            <li><a href="{{ route('booking-saya.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Booking Saya</span></a></li>
            <li><a href="{{ route('profil.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 border-transparent hover:border-blue-400 pr-6 pl-4"><span class="ml-2 text-sm tracking-wide truncate">Profil</span></a></li>
        </ul>
    </div>
</div>
EOD;
file_put_contents(__DIR__ . '/resources/views/components/sidebar-karyawan.blade.php', $sidebarKaryawan);

// View Admin Dashboard
$dashboardAdmin = <<<EOD
@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Dashboard Admin</h1>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-blue-700">Buat Laporan</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <div><div class="text-sm font-medium text-gray-500">Total Ruangan</div><div class="text-2xl font-bold text-gray-800">7</div></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div><div class="text-sm font-medium text-gray-500">Booking Aktif</div><div class="text-2xl font-bold text-gray-800">12</div></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div><div class="text-sm font-medium text-gray-500">Menunggu Approval</div><div class="text-2xl font-bold text-gray-800">4</div></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div><div class="text-sm font-medium text-gray-500">Total Pengguna</div><div class="text-2xl font-bold text-gray-800">19</div></div>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Grafik Booking</h2>
    <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg text-gray-400 border border-dashed border-gray-300">
        Chart.js Integration Placeholder
    </div>
</div>
@endsection
EOD;
file_put_contents(__DIR__ . '/resources/views/admin/dashboard.blade.php', $dashboardAdmin);

// View Karyawan Dashboard
$dashboardKaryawan = str_replace('Admin', 'Karyawan', $dashboardAdmin);
file_put_contents(__DIR__ . '/resources/views/karyawan/dashboard.blade.php', $dashboardKaryawan);

// Fallback index files
foreach($dirs as $dir) {
    if (strpos($dir, 'components') === false && strpos($dir, 'layouts') === false && strpos($dir, 'dashboard') === false) {
        $name = ucfirst(basename($dir));
        $content = "@extends('layouts.admin')\n@section('content')\n<h1 class='text-2xl font-semibold mb-4'>Halaman $name</h1>\n<p class='text-gray-500'>Struktur awal $name berhasil digenerate.</p>\n@endsection";
        if (strpos($dir, 'karyawan') !== false) {
             $content = str_replace('layouts.admin', 'layouts.karyawan', $content);
        }
        file_put_contents($dir . '/index.blade.php', $content);
    }
}
echo "Views Generated\n";
