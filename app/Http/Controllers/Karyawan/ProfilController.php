<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['department', 'documents']);
        return view('karyawan.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'        => 'required|string|max:255',
            'nip'         => ['nullable', 'string', Rule::unique('users', 'nip')->ignore($user->id)],
            'phone'       => 'nullable|string|max:25',
            'gender'      => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date'  => 'nullable|date',
            'address'     => 'nullable|string|max:500',
        ]);

        $user->update($request->only([
            'name', 'nip', 'phone', 'gender', 'birth_place', 'birth_date', 'address',
        ]));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->with('error_password', 'Password saat ini tidak sesuai.')
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update(['password' => $request->password]);

        return back()->with('success_password', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $path]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}