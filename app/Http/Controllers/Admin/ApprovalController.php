<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('purpose', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', strtolower($request->status));
        }

        $bookings = $query->latest()->paginate(10);
        $totalPending = Booking::where('status', 'menunggu_approval')->count();
        $totalApproved = Booking::where('status', 'disetujui')->count();
        $totalRejected = Booking::where('status', 'ditolak')->count();

        return view('admin.approval.index', compact('bookings', 'totalPending', 'totalApproved', 'totalRejected'));
    }

    public function update(Request $request, Booking $approval)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'approver_notes' => 'nullable|string'
        ]);

        $approval->update([
            'status'           => $request->status,
            'approved_by'      => Auth::id(),
            'approved_at'      => now(),
            'rejection_reason' => $request->approver_notes
        ]);

        // ── Kirim notifikasi ke pemilik booking (karyawan) ──────────
        $isApproved = $request->status == 'disetujui';
        \App\Models\Notification::create([
            'user_id' => $approval->user_id,
            'type'    => 'approval',
            'title'   => $isApproved ? 'Booking Disetujui ✓' : 'Booking Ditolak',
            'message' => 'Booking ruangan ' . $approval->room->name
                . ' pada ' . \Carbon\Carbon::parse($approval->date)->translatedFormat('d F Y')
                . ' pukul ' . \Carbon\Carbon::parse($approval->start_time)->format('H:i')
                . ' – ' . \Carbon\Carbon::parse($approval->end_time)->format('H:i')
                . ($isApproved ? ' telah DISETUJUI oleh admin.' : ' telah DITOLAK oleh admin.'
                    . ($request->approver_notes ? ' Alasan: ' . $request->approver_notes : '')),
            'link'    => route('karyawan.booking-saya.index'),
            'is_read' => false,
        ]);

        $msg = $isApproved ? 'Booking berhasil disetujui.' : 'Booking berhasil ditolak.';
        return redirect()->back()->with('success', $msg);
    }
}