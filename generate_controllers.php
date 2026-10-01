<?php
$dirs = [
    __DIR__ . '/app/Services',
    __DIR__ . '/app/Http/Controllers/Admin',
    __DIR__ . '/app/Http/Controllers/Karyawan',
    __DIR__ . '/app/Http/Middleware',
];
foreach($dirs as $dir) if(!is_dir($dir)) mkdir($dir, 0777, true);

// Middleware
$checkRole = <<<EOD
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request \$request, Closure \$next, ...\$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        \$user = Auth::user();

        if (in_array('approver', \$roles) && in_array('karyawan', \$roles)) {
             if (\$user->role == 'approver' || \$user->role == 'karyawan') return \$next(\$request);
        }

        if (!in_array(\$user->role, \$roles)) {
            abort(403, 'Akses ditolak.');
        }

        return \$next(\$request);
    }
}
EOD;
file_put_contents(__DIR__ . '/app/Http/Middleware/CheckRole.php', $checkRole);

// Routes web.php
$webRoutes = <<<EOD
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

    // Notifikasi
    // Route::get('/notifications', [NotifikasiController::class, 'index']);
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::resource('ruangan', RuanganController::class);
    Route::resource('user', UserController::class);
    Route::resource('booking', AdminBooking::class);
    Route::resource('approval', ApprovalController::class);
    Route::get('/kalender', [AdminKalender::class, 'index'])->name('admin.kalender');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
});

Route::prefix('karyawan')->middleware(['auth', 'role:karyawan,approver'])->group(function () {
    Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('karyawan.dashboard');
    Route::resource('booking', KaryawanBooking::class);
    Route::get('/kalender', [KaryawanKalender::class, 'index'])->name('karyawan.kalender');
    Route::resource('booking-saya', BookingSayaController::class);
    Route::resource('profil', ProfilController::class);
});

require __DIR__.'/auth.php';
EOD;
file_put_contents(__DIR__ . '/routes/web.php', $webRoutes);

// Helper function to write simple controllers
function makeController($path, $namespace, $className, $viewPath = null) {
    $content = <<<EOD
<?php
namespace $namespace;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class $className extends Controller
{
    public function index()
    {
        return view('$viewPath');
    }
}
EOD;
    file_put_contents($path, $content);
}

// Generate Admin Controllers
$adminCtrls = ['DashboardController' => 'admin.dashboard', 'RuanganController' => 'admin.ruangan.index', 'UserController' => 'admin.user.index', 'BookingController' => 'admin.booking.index', 'ApprovalController' => 'admin.approval.index', 'KalenderController' => 'admin.kalender.index', 'LaporanController' => 'admin.laporan.index', 'PengaturanController' => 'admin.pengaturan.index'];
foreach($adminCtrls as $ctrl => $view) {
    makeController(__DIR__ . '/app/Http/Controllers/Admin/' . $ctrl . '.php', 'App\Http\Controllers\Admin', $ctrl, $view);
}

// Generate Karyawan Controllers
$karyawanCtrls = ['DashboardController' => 'karyawan.dashboard', 'BookingController' => 'karyawan.booking.index', 'KalenderController' => 'karyawan.kalender.index', 'BookingSayaController' => 'karyawan.booking-saya.index', 'ProfilController' => 'karyawan.profil.index'];
foreach($karyawanCtrls as $ctrl => $view) {
    makeController(__DIR__ . '/app/Http/Controllers/Karyawan/' . $ctrl . '.php', 'App\Http\Controllers\Karyawan', $ctrl, $view);
}

echo "Controllers and Routes Generated\n";
