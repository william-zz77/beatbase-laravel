<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        $rememberedEmail = request()->cookie('remember_email') ?? '';
        return view('auth.login', compact('rememberedEmail'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember_me');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            session([
                'user_nama'  => Auth::user()->nama,
                'user_role'  => Auth::user()->role,
                'login_time' => time(),
            ]);

            $role = Auth::user()->role;

            $redirectTo = match($role) {
                'admin'    => route('admin.dashboard'),
                'owner'    => route('owner.dashboard'),
                'customer' => route('customer.dashboard'),
                default    => route('login'),
            };

            $response = redirect($redirectTo);

            if ($remember) {
                $token = base64_encode(Auth::user()->email . '|' . hash('sha256', Auth::user()->password));
                $response = $response->withCookie(cookie('remember_token', $token, 60 * 24 * 30));
                $response = $response->withCookie(cookie('remember_email', Auth::user()->email, 60 * 24 * 30));
            } else {
                $response = $response->withCookie(cookie()->forget('remember_token'));
                $response = $response->withCookie(cookie()->forget('remember_email'));
            }

            return $response;
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|min:3|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:customer,owner',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $response = redirect()->route('login');
        $response = $response->withCookie(cookie()->forget('remember_token'));
        $response = $response->withCookie(cookie()->forget('remember_email'));

        return $response;
    }
}