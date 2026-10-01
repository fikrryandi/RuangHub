<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();
        
        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', strtolower($request->status));
        }

        $rooms = $query->latest()->paginate(10);
        $totalAktif = Room::where('status', 'aktif')->count();
        $totalMaintenance = Room::where('status', 'maintenance')->count();
        $totalNonaktif = Room::where('status', 'nonaktif')->count();
        
        return view('admin.ruangan.index', compact('rooms', 'totalAktif', 'totalMaintenance', 'totalNonaktif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:rooms',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:aktif,maintenance,nonaktif',
        ]);
        
        // default facilities for now
        $validated['facilities'] = ['Proyektor', 'AC', 'WiFi'];

        Room::create($validated);
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan');
    }
    
    public function update(Request $request, Room $ruangan)
    {
        $validated = $request->validate([
            'code' => 'required|unique:rooms,code,' . $ruangan->id,
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:aktif,maintenance,nonaktif',
        ]);
        
        $ruangan->update($validated);
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui');
    }
    
    public function destroy(Room $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus');
    }
}