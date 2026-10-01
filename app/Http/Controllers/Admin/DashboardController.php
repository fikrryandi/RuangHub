<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = \App\Models\Room::count();
        $totalBookings = \App\Models\Booking::count();
        $totalUsers = \App\Models\User::count();
        
        $pendingBookings = \App\Models\Booking::where('status', 'menunggu_approval')->count();
        $activeBookings = \App\Models\Booking::whereIn('status', ['disetujui'])->count();

        $rooms = \App\Models\Room::take(6)->get();
        $recentBookings = \App\Models\Booking::with(['user', 'room'])->latest()->take(5)->get();
        
        // Chart Data - Pie Chart (Status)
        $chartStatus = [
            'terkonfirmasi' => \App\Models\Booking::where('status', 'disetujui')->count(),
            'menunggu' => $pendingBookings,
            'ditolak' => \App\Models\Booking::where('status', 'ditolak')->count(),
            'selesai' => \App\Models\Booking::where('status', 'selesai')->count(),
            'dibatalkan' => \App\Models\Booking::where('status', 'dibatalkan')->count(),
        ];

        // Chart Data - Line Chart (Last 7 Days)
        $chartLineDates = [];
        $chartLineTotal = [];
        $chartLineDisetujui = [];
        $chartLineDitolak = [];
        $chartLineDibatalkan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $chartLineDates[] = $date->format('d M');
            
            $chartLineTotal[] = \App\Models\Booking::whereDate('created_at', $date)->count();
            $chartLineDisetujui[] = \App\Models\Booking::whereDate('created_at', $date)->where('status', 'disetujui')->count();
            $chartLineDitolak[] = \App\Models\Booking::whereDate('created_at', $date)->where('status', 'ditolak')->count();
            $chartLineDibatalkan[] = \App\Models\Booking::whereDate('created_at', $date)->where('status', 'dibatalkan')->count();
        }

        return view('admin.dashboard', compact(
            'totalRooms', 'totalBookings', 'totalUsers', 'pendingBookings', 'activeBookings', 
            'rooms', 'recentBookings', 
            'chartStatus', 'chartLineDates', 'chartLineTotal', 'chartLineDisetujui', 'chartLineDitolak', 'chartLineDibatalkan'
        ));
    }
}