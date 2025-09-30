<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login'); // your login blade
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'login' => ['required', 'string'], // email or username
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Determine if input is email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt login
        if (!Auth::attempt([$field => $login, 'password' => $password], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard')); // adjust your dashboard route
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
