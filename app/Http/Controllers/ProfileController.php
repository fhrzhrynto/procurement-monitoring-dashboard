<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->profile_photo) {
            Storage::delete('public/' . $user->profile_photo);
        }

        // Simpan foto baru
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Simpan path foto ke database
        $user->update(['profile_photo' => $path]);

        return response()->json(['profile_photo' => asset('storage/' . $path)]);
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'department' => 'nullable|string|max:255',
        'job_title' => 'nullable|string|max:255',
    ]);

    // Update data pengguna
    $user->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'department' => $request->department,
        'job_title' => $request->job_title,
    ]);

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}

}
