<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /* ===== Login ===== */
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            if (!Auth::user()->approved_at) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your account is pending admin approval.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ])->onlyInput('email');
    }

    /* ===== Register ===== */
    public function registerForm()
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email'), // Model-based unique validation
            ],
            'department_id' => [
                'required',
                Rule::exists(Department::class, 'dept_id'), // Model-based exists validation
            ],
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id'],
            'password' => Hash::make($validated['password']),
            'approved_at' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Account created successfully.');
    }

    /* ===== Logout ===== */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
