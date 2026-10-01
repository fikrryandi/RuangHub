<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;

class ExportController extends Controller
{
    public function exportUsers()
    {
        $users = User::with('department')->get();
        return response(view('admin.exports.users', compact('users')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Data_User_RuangHub.xls"');
    }

    public function exportRooms()
    {
        $rooms = Room::all();
        return response(view('admin.exports.rooms', compact('rooms')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Data_Ruangan_RuangHub.xls"');
    }

    public function exportApprovals(Request $request)
    {
        $query = Booking::with(['user', 'room']);
        if ($request->has('status') && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['menunggu_approval', 'disetujui', 'ditolak']);
        }
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        return response(view('admin.exports.approvals', compact('bookings')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Data_Approval_RuangHub.xls"');
    }
}
