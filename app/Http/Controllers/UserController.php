<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::with('profile')->paginate(10);
        return view('users.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,principal,teacher,student,parent,accountant',
            'status' => 'required|in:active,inactive',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'nullable|max:15',
            'address' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'national_id' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Create user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Handle photo upload
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('public/profiles', $photoName);
        }

        // Create profile
        UserProfile::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'national_id' => $request->national_id,
            'photo' => $photoName,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show edit form
    public function edit(User $user)
    {
        $user->load('profile');
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id.'|max:50',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,principal,teacher,student,parent,accountant',
            'status' => 'required|in:active,inactive',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'nullable|max:15',
            'address' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'national_id' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user info
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([]);
        }

        // Handle profile photo
        $photoName = $user->profile->photo ?? null;
        if ($request->hasFile('photo')) {
            if ($photoName && Storage::disk('public')->exists('profiles/'.$photoName)) {
                Storage::disk('public')->delete('profiles/'.$photoName);
            }
            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('public/profiles', $photoName);
        }

        // Update or create profile
        $user->profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'national_id' => $request->national_id,
            'photo' => $photoName,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user safely
    public function destroy(User $user)
    {
        if ($user->profile) {
            if ($user->profile->photo && Storage::disk('public')->exists('profiles/'.$user->profile->photo)) {
                Storage::disk('public')->delete('profiles/'.$user->profile->photo);
            }
            $user->profile->delete();
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Show single user
    public function show(User $user)
    {
        $user->load('profile');
        return view('users.show', compact('user'));
    }
}
