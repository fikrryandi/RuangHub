<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController as AdminBooking;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\KalenderController as AdminKalender;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\AdminProfilController;

use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\BookingController as KaryawanBooking;
use App\Http\Controllers\Karyawan\BookingSayaController;
use App\Http\Controllers\Karyawan\KalenderController as KaryawanKalender;
use App\Http\Controllers\Karyawan\ProfilController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
        return redirect('/karyawan/dashboard');
    })->name('dashboard');
});

// ─── Admin Routes ────────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::resource('ruangan', RuanganController::class);
    Route::resource('user', UserController::class);
    Route::resource('booking', AdminBooking::class);
    Route::resource('approval', ApprovalController::class);
    Route::get('/kalender', [AdminKalender::class, 'index'])->name('admin.kalender');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

    // Export Routes
    Route::get('/export/users', [ExportController::class, 'exportUsers'])->name('admin.export.users');
    Route::get('/export/rooms', [ExportController::class, 'exportRooms'])->name('admin.export.rooms');
    Route::get('/export/approvals', [ExportController::class, 'exportApprovals'])->name('admin.export.approvals');

    // Notifikasi dengan data real dari DB
    Route::get('/notifikasi', function () {
        $notifications = \App\Models\Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);
        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
            ->where('is_read', false)->count();
        return view('admin.notifikasi.index', compact('notifications', 'unreadCount'));
    })->name('admin.notifikasi');

    Route::post('/notifikasi/read-all', function () {
        \App\Models\Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('admin.notifikasi.read-all');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('admin.pengaturan.update');

    // Profil Admin
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('admin.profil.index');
    Route::post('/profil/update', [AdminProfilController::class, 'update'])->name('admin.profil.update');
    Route::post('/profil/password', [AdminProfilController::class, 'updatePassword'])->name('admin.profil.password');
    Route::post('/profil/photo', [AdminProfilController::class, 'updatePhoto'])->name('admin.profil.photo');
});

// ─── Karyawan Routes ─────────────────────────────────────────────────────────
Route::prefix('karyawan')->name('karyawan.')->middleware(['auth', 'role:karyawan,approver'])->group(function () {
    Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('dashboard');

    // Booking Ruangan (create & store only)
    Route::resource('booking', KaryawanBooking::class)->only(['index', 'store']);

    // Kalender Ruangan
    Route::get('/kalender', [KaryawanKalender::class, 'index'])->name('kalender');

    // Booking Saya
    Route::resource('booking-saya', BookingSayaController::class)->only(['index', 'destroy']);
    Route::post('/booking-saya/{booking}/selesai', [BookingSayaController::class, 'selesai'])->name('booking-saya.selesai');


    // Notifikasi karyawan dengan data real
    Route::get('/notifikasi', function () {
        $notifications = \App\Models\Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);
        \App\Models\Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return view('karyawan.notifikasi.index', compact('notifications'));
    })->name('notifikasi');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/photo', [ProfilController::class, 'updatePhoto'])->name('profil.photo');
});

require __DIR__.'/auth.php';