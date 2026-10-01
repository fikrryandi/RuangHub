<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $rooms = \App\Models\Room::where('status', 'aktif')->get();
        $currentTime = now()->format('H:i');

        foreach ($rooms as $room) {
            $isOccupied = \App\Models\Booking::where('room_id', $room->id)
                ->whereDate('date', today())
                ->whereIn('status', ['menunggu_approval', 'disetujui'])
                ->where(function($q) use ($currentTime) {
                    $q->whereRaw("time(start_time) <= time(?)", [$currentTime])
                      ->whereRaw("time(end_time) > time(?)", [$currentTime]);
                })->exists();
            $room->is_occupied = $isOccupied;
        }

        return view('karyawan.booking.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'purpose'    => 'required|string|max:255',
            'notes'      => 'nullable|string|max:500',
        ]);

        // Cek bentrok jadwal (overlap) — gunakan cast TIME agar akurat di SQLite & MySQL
        $start_h = $validated['start_time']; // format H:i dari validasi
        $end_h   = $validated['end_time'];

        $isOverlapping = \App\Models\Booking::where('room_id', $validated['room_id'])
            ->whereDate('date', $validated['date'])
            ->whereIn('status', ['menunggu_approval', 'disetujui'])
            ->where(function ($q) use ($start_h, $end_h) {
                // Ada overlap jika: start_time < end_request DAN end_time > start_request
                $q->whereRaw("time(start_time) < time(?)", [$end_h])
                  ->whereRaw("time(end_time) > time(?)", [$start_h]);
            })->exists();

        if ($isOverlapping) {
            // Cari jam kosong yang tersedia
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
                    $end_slot = $current->copy()->addMinutes($duration);
                    $recoms[] = $current->format('H:i') . ' – ' . $end_slot->format('H:i');
                }
                if ($current < $b_e) $current = $b_e->copy();
            }
            if ($current < $work_end && $current->diffInMinutes($work_end) >= $duration) {
                $recoms[] = $current->format('H:i') . ' – ' . $current->copy()->addMinutes($duration)->format('H:i');
            }
            $recom_text = !empty($recoms)
                ? 'Jam kosong tersedia: ' . implode(', ', array_slice($recoms, 0, 3))
                : 'Tidak ada jam kosong tersisa hari ini.';

            return back()->withInput()->with('error',
                '⚠ Ruangan sudah dibooking pada jam ' . $start_h . '–' . $end_h . '. ' . $recom_text
            );
        }


        // ── Generate kode booking unik (BK-YYYYMMDD-XXX) ────────────
        $dateStr   = \Carbon\Carbon::parse($validated['date'])->format('Ymd');
        $todayCount = \App\Models\Booking::whereDate('created_at', now())->count() + 1;
        do {
            $code = 'BK-' . $dateStr . '-' . str_pad($todayCount, 3, '0', STR_PAD_LEFT);
            $todayCount++;
        } while (\App\Models\Booking::where('code', $code)->exists());

        $validated['code']    = $code;
        $validated['user_id'] = auth()->id();
        $validated['status']  = 'menunggu_approval';

        $booking = \App\Models\Booking::create($validated);
        $booking->load('room');

        // ── Kirim notifikasi ke semua admin ─────────────────────────
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type'    => 'booking',
                'title'   => 'Booking Ruangan Baru',
                'message' => auth()->user()->name
                    . ' mengajukan booking ruangan '
                    . $booking->room->name
                    . ' pada '
                    . \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y')
                    . ' pukul '
                    . \Carbon\Carbon::parse($booking->start_time)->format('H:i')
                    . ' – '
                    . \Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                'link'    => route('booking.show', $booking->id),
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('karyawan.booking-saya.index')
            ->with('success', 'Booking <strong>' . $code . '</strong> berhasil dibuat dan sedang menunggu approval admin.');
    }
}