<?php
namespace App\Http\Controllers\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        $rooms = \App\Models\Room::all();
        $totalRooms = $rooms->count();
        $date = $request->input('date', date('Y-m-d'));
        
        // Ambil booking untuk tanggal yang dipilih
        $bookings = \App\Models\Booking::with(['user', 'room'])
            ->whereDate('date', $date)
            ->whereIn('status', ['disetujui', 'menunggu_approval', 'selesai'])
            ->get();
            
        return view('karyawan.kalender.index', compact('totalRooms', 'date', 'bookings', 'rooms'));
    }
}