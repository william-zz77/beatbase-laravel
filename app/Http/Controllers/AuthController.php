<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

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

            // Simpan info session tambahan
            session([
                'user_nama'  => Auth::user()->nama,
                'user_role'  => Auth::user()->role,
                'login_time' => time(),
            ]);

            $role = Auth::user()->role;

            // Handle cookie remember me
            if ($remember) {
                $token = base64_encode(Auth::user()->email . '|' . hash('sha256', Auth::user()->password));
                Cookie::queue('remember_token', $token, 60 * 24 * 30); // 30 hari
                Cookie::queue('remember_email', Auth::user()->email, 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('remember_token'));
                Cookie::queue(Cookie::forget('remember_email'));
            }

            return match($role) {
                'admin'    => redirect()->route('admin.dashboard'),
                'owner'    => redirect()->route('owner.dashboard'),
                'customer' => redirect()->route('customer.dashboard'),
                default    => redirect()->route('login'),
            };
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

        // Hapus cookies remember me
        Cookie::queue(Cookie::forget('remember_token'));
        Cookie::queue(Cookie::forget('remember_email'));

        return redirect()->route('login');
    }
}