<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingSayaController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['room'])
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->paginate(10);

        return view('karyawan.booking-saya.index', compact('bookings'));
    }

    /**
     * Karyawan menandai booking selesai dipakai.
     * Booking harus milik user yg login & statusnya 'disetujui'.
     */
    public function selesai(Booking $booking)
    {
        // Pastikan booking milik user yg login
        if ($booking->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // Hanya booking berstatus 'disetujui' yang bisa diselesaikan
        if ($booking->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Hanya booking yang sudah disetujui yang dapat ditandai selesai.');
        }

        $booking->update(['status' => 'selesai']);
        $booking->load('room');

        // Notifikasi ke admin bahwa ruangan selesai dipakai
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type'    => 'informasi',
                'title'   => 'Ruangan Selesai Digunakan',
                'message' => auth()->user()->name
                    . ' telah menyelesaikan pemakaian ruangan '
                    . $booking->room->name
                    . ' (Booking #' . $booking->code . ').',
                'link'    => route('booking.show', $booking->id),
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih! Ruangan <strong>' . $booking->room->name . '</strong> telah ditandai selesai digunakan.');
    }

    /**
     * Karyawan membatalkan booking (hanya saat masih menunggu_approval).
     */
    public function destroy(Booking $booking_saya)
    {
        if ($booking_saya->user_id !== auth()->id() || $booking_saya->status !== 'menunggu_approval') {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan booking ini.');
        }

        $booking_saya->update(['status' => 'dibatalkan']);
        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }
}