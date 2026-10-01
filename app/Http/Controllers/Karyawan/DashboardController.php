<?php
namespace App\Http\Controllers\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalRooms = \App\Models\Room::count();
        $myBookings = \App\Models\Booking::where('user_id', $user->id)->count();
        $pendingBookings = \App\Models\Booking::where('user_id', $user->id)->where('status', 'menunggu_approval')->count();
        $approvedBookings = \App\Models\Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $usedBookings = \App\Models\Booking::where('user_id', $user->id)->where('status', 'selesai')->count();
        $rejectedBookings = \App\Models\Booking::where('user_id', $user->id)->whereIn('status', ['ditolak', 'dibatalkan'])->count();

        // Data for components
        $recentBookings = \App\Models\Booking::with('room')->where('user_id', $user->id)->latest()->take(4)->get();
        $popularRooms = \App\Models\Room::withCount('bookings')->orderBy('bookings_count', 'desc')->take(3)->get();
        $notifications = \App\Models\Notification::where('user_id', $user->id)->latest()->take(4)->get();
        
        return view('karyawan.dashboard', compact(
            'totalRooms', 'myBookings', 'pendingBookings', 'approvedBookings', 'usedBookings', 'rejectedBookings',
            'recentBookings', 'popularRooms', 'notifications'
        ));
    }
}