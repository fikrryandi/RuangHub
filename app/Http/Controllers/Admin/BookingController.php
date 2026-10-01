<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Booking::with(['user', 'room']);
        
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('room', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $bookings = $query->latest()->paginate(10);
        $totalBookings = \App\Models\Booking::count();
        $activeBookings = \App\Models\Booking::whereIn('status', ['disetujui', 'selesai'])->count();
        $pendingBookings = \App\Models\Booking::where('status', 'menunggu_approval')->count();
        $doneBookings = \App\Models\Booking::where('status', 'selesai')->count();
        $canceledBookings = \App\Models\Booking::where('status', 'dibatalkan')->count();
        $rooms = \App\Models\Room::where('status', 'aktif')->get();
        $users = \App\Models\User::all();

        return view('admin.booking.index', compact('bookings', 'totalBookings', 'activeBookings', 'pendingBookings', 'doneBookings', 'canceledBookings', 'rooms', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        // Cek bentrok jadwal (overlap)
        $start_h = $validated['start_time'];
        $end_h   = $validated['end_time'];

        $isOverlapping = \App\Models\Booking::where('room_id', $validated['room_id'])
            ->whereDate('date', $validated['date'])
            ->whereIn('status', ['menunggu_approval', 'disetujui'])
            ->where(function ($q) use ($start_h, $end_h) {
                $q->whereRaw("time(start_time) < time(?)", [$end_h])
                  ->whereRaw("time(end_time) > time(?)", [$start_h]);
            })->exists();

        if ($isOverlapping) {
            $existingBookings = \App\Models\Booking::where('room_id', $validated['room_id'])
                ->whereDate('date', $validated['date'])
                ->whereIn('status', ['menunggu_approval', 'disetujui'])
                ->orderBy('start_time')->get();
            $duration = \Carbon\Carbon::parse($start_h)->diffInMinutes(\Carbon\Carbon::parse($end_h));
            $work_start = \Carbon\Carbon::parse('08:00');
            $work_end   = \Carbon\Carbon::parse('22:00');
            $current = $work_start->copy();
            $recoms  = [];
            foreach ($existingBookings as $eb) {
                $b_s = \Carbon\Carbon::parse($eb->start_time);
                $b_e = \Carbon\Carbon::parse($eb->end_time);
                if ($current < $b_s && $current->diffInMinutes($b_s) >= $duration) {
                    $recoms[] = $current->format('H:i') . ' – ' . $current->copy()->addMinutes($duration)->format('H:i');
                }
                if ($current < $b_e) $current = $b_e->copy();
            }
            if ($current < $work_end && $current->diffInMinutes($work_end) >= $duration) {
                $recoms[] = $current->format('H:i') . ' – ' . $current->copy()->addMinutes($duration)->format('H:i');
            }
            $recom_text = !empty($recoms)
                ? 'Jam kosong tersedia: ' . implode(', ', array_slice($recoms, 0, 3))
                : 'Tidak ada jam kosong tersisa hari ini.';
            return back()->withInput()->with('error', '⚠ Ruangan sudah dibooking pada jam tersebut. ' . $recom_text);
        }

        $validated['code'] = 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $validated['status'] = 'disetujui'; // Admin booking usually pre-approved
        $validated['approved_by'] = auth()->id();
        $validated['approved_at'] = now();

        \App\Models\Booking::create($validated);
        
        return redirect()->route('booking.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function update(Request $request, \App\Models\Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required'
        ]);
        
        // Cek bentrok jadwal (overlap)
        // If status is going to be approved or pending, check for overlap
        if (in_array($validated['status'], ['menunggu_approval', 'disetujui'])) {
            $start_h = $validated['start_time'];
            $end_h   = $validated['end_time'];

            $isOverlapping = \App\Models\Booking::where('room_id', $validated['room_id'])
                ->whereDate('date', $validated['date'])
                ->whereIn('status', ['menunggu_approval', 'disetujui'])
                ->where('id', '!=', $booking->id)
                ->where(function ($q) use ($start_h, $end_h) {
                    $q->whereRaw("time(start_time) < time(?)", [$end_h])
                      ->whereRaw("time(end_time) > time(?)", [$start_h]);
                })->exists();

            if ($isOverlapping) {
                // Rekomendasi jam kosong
                $existingBookings = \App\Models\Booking::where('room_id', $validated['room_id'])
                    ->whereDate('date', $validated['date'])
                    ->whereIn('status', ['menunggu_approval', 'disetujui'])
                    ->where('id', '!=', $booking->id)
                    ->orderBy('start_time')->get();
                $duration = \Carbon\Carbon::parse($start_h)->diffInMinutes(\Carbon\Carbon::parse($end_h));
                $work_start = \Carbon\Carbon::parse('08:00');
                $work_end   = \Carbon\Carbon::parse('22:00');
                $current = $work_start->copy();
                $recoms  = [];
                foreach ($existingBookings as $eb) {
                    $b_s = \Carbon\Carbon::parse($eb->start_time);
                    $b_e = \Carbon\Carbon::parse($eb->end_time);
                    if ($current < $b_s && $current->diffInMinutes($b_s) >= $duration) {
                        $recoms[] = $current->format('H:i') . ' – ' . $current->copy()->addMinutes($duration)->format('H:i');
                    }
                    if ($current < $b_e) $current = $b_e->copy();
                }
                if ($current < $work_end && $current->diffInMinutes($work_end) >= $duration) {
                    $recoms[] = $current->format('H:i') . ' – ' . $current->copy()->addMinutes($duration)->format('H:i');
                }
                $recom_text = !empty($recoms)
                    ? 'Jam kosong tersedia: ' . implode(', ', array_slice($recoms, 0, 3))
                    : 'Tidak ada jam kosong tersisa hari ini.';
                return back()->withInput()->with('error', '⚠ Ruangan sudah dibooking pada jam tersebut. ' . $recom_text);
            }
        }

        $booking->update($validated);
        
        return redirect()->route('booking.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(\App\Models\Booking $booking)
    {
        $booking->delete();
        return redirect()->route('booking.index')->with('success', 'Booking berhasil dihapus.');
    }
}