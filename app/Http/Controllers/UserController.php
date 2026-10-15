<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.daftaruser', compact('users'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftaruser(Request $request)
{
    $query = User::query();

    // Hanya filter berdasarkan nama
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $users = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('daftaruser', compact('users'));
}


    public function add()
    {
        return view('users.add');
    }

    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function settings()
    {
        return view('settings', ['user' => Auth::user()]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'birthdate' => $user->birthdate ? $user->birthdate->format('d-m-Y') : null
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'department' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'department', 'job_title']));

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->update(['profile_photo' => $path]);
        }

        return redirect()->route('profile')->with('success', 'Profile photo updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile')->with('success', 'Password updated successfully.');
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|integer|in:0,1',
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ];

    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    // Logging update data
    \Log::info('User update data:', $updateData);

    $user->update($updateData);

    return redirect()->route('daftaruser')->with('success', 'User updated successfully.');
}

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('daftaruser')->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        return redirect()->route('daftaruser')->with('success', 'User deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer|in:0,1',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('daftaruser')->with('success', 'User created successfully.');
    }

            

}