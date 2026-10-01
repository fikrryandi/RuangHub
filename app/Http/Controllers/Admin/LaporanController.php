<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Booking::with(['user', 'room']);

        if ($request->filled('month') && $request->month != 'Semua Bulan') {
            $monthMap = [
                'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
            ];
            if (isset($monthMap[$request->month])) {
                $query->whereMonth('date', $monthMap[$request->month]);
            }
        }

        if ($request->filled('room') && $request->room != 'Semua Ruangan') {
            $roomName = $request->room;
            $query->whereHas('room', function($q) use ($roomName) {
                $q->where('name', $roomName);
            });
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', strtolower($request->status));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhere('code', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest('date')->paginate(10);
        $rooms = \App\Models\Room::all();

        return view('admin.laporan.index', compact('bookings', 'rooms'));
    }
}