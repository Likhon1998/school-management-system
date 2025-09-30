<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:50'],
        'last_name' => ['required', 'string', 'max:50'],
        'phone' => ['required', 'string', 'max:15'],
        'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
        'username' => ['required', 'string', 'max:50', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:admin,principal,teacher,student,parent,accountant'],
        'gender' => ['required', 'in:male,female,other'],
        'address' => ['required', 'string'],
        'date_of_birth' => ['required', 'date'],
        'national_id' => ['required', 'string'],
        'photo' => ['nullable', 'image', 'max:2048'],
    ]);

    // Create user
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'status' => 'active',
    ]);

    // Save profile
    $user->profile()->create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'phone' => $request->phone,
        'gender' => $request->gender,
        'address' => $request->address,
        'date_of_birth' => $request->date_of_birth,
        'national_id' => $request->national_id,
        'photo' => $request->hasFile('photo') ? $request->file('photo')->store('profiles', 'public') : null,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect()->route('dashboard');
}

}
