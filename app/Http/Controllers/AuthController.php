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

        $remember = $request->boolean('remember_me');

        if (Auth::attempt($request->only('email','password'), $remember)) {
            $request->session()->regenerate();
            session(['login_time' => time(), 'user_role' => Auth::user()->role]);

            $response = redirect(match(Auth::user()->role) {
                'admin'    => route('admin.dashboard'),
                'owner'    => route('owner.dashboard'),
                default    => route('customer.dashboard'),
            });

            if ($remember) {
                $token = base64_encode(Auth::user()->email.'|'.hash('sha256', Auth::user()->password));
                $response = $response
                    ->withCookie(cookie('remember_token', $token, 60*24*30))
                    ->withCookie(cookie('remember_email', Auth::user()->email, 60*24*30));
            } else {
                $response = $response
                    ->withCookie(cookie()->forget('remember_token'))
                    ->withCookie(cookie()->forget('remember_email'));
            }
            return $response;
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegister() { return view('auth.register'); }

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
        return redirect()->route('login')->with('success','Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login')
            ->withCookie(cookie()->forget('remember_token'))
            ->withCookie(cookie()->forget('remember_email'));
    }
}