<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
{
    // Jika sudah login DAN session masih valid
    if (Auth::check() && session('expire_time') && time() <= session('expire_time')) {
        return $this->redirectByRole(Auth::user()->role);
    }

    // Jika ada remember cookie tapi session expired, logout dulu
    if (Auth::check() && !session('expire_time')) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    $rememberedEmail = Cookie::get('remember_email', '');
    return view('auth.login', compact('rememberedEmail'));
}

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember_me');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        // Set session sama seperti project PHP lama
        session([
            'login_time'    => time(),
            'expire_time'   => time() + 60, // 
            'last_activity' => time(),
        ]);

        $response = $this->redirectByRole(Auth::user()->role);

        // Cookie Remember Me — simpan email 30 hari
        if ($remember) {
            $cookieEmail = Cookie::make(
                'remember_email',
                $request->email,
                1,
                '/',
                null,
                false,
                true
            );
            return $response->withCookie($cookieEmail);
        } else {
            return $response->withCookie(Cookie::forget('remember_email'));
        }
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        session([
            'login_time'    => time(),
            'expire_time'   => time() + (60 * 60),
            'last_activity' => time(),
        ]);

        return $this->redirectByRole($user->role)
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->nama . '.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Cookie remember_email tetap disimpan saat logout
        // agar email tetap terisi di form login berikutnya
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(string $role): RedirectResponse
    {
        return match($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'owner'    => redirect()->route('owner.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default    => redirect()->route('login'),
        };
    }
}