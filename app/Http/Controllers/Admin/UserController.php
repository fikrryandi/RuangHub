<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role != 'Semua Role') {
            $query->where('role', strtolower($request->role));
        }

        $users = $query->latest()->paginate(10);
        $totalAdmin    = User::where('role', 'admin')->count();
        $totalApprover = User::where('role', 'approver')->count();
        $totalKaryawan = User::where('role', 'karyawan')->count();

        // Pass department_name to each user for the edit modal
        foreach ($users as $u) {
            $u->department_name = $u->department ? $u->department->name : '';
        }

        return view('admin.user.index', compact('users', 'totalAdmin', 'totalApprover', 'totalKaryawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip'             => 'required|unique:users',
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|min:6',
            'role'            => 'required|in:admin,karyawan',
            'department_name' => 'required|string|max:255',
        ]);

        // Find or create department by name
        $dept = Department::firstOrCreate(
            ['name' => trim($validated['department_name'])]
        );

        $validated['password']      = Hash::make($validated['password']);
        $validated['department_id'] = $dept->id;
        unset($validated['department_name']);

        User::create($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nip'             => 'required|unique:users,nip,' . $user->id,
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'role'            => 'required|in:admin,karyawan',
            'department_name' => 'required|string|max:255',
        ]);

        // Find or create department by name
        $dept = Department::firstOrCreate(
            ['name' => trim($validated['department_name'])]
        );

        $validated['department_id'] = $dept->id;
        unset($validated['department_name']);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }
}