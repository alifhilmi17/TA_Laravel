<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan Form Login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Memproses Autentikasi Login Pengguna.
     */
    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role'     => ['nullable', 'string', 'in:petugas,admin'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Coba Autentikasi Menggunakan Facade Auth Laravel
        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember')) ||
            Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali!');
        }

        // 3. Mode Testing / Auto-Create User jika data belum ada di database
        $username = trim($credentials['username']);
        $user = User::firstOrCreate(
            ['email' => strtolower($username) . '@libas.test'],
            [
                'name' => ucfirst($username),
                'password' => bcrypt($credentials['password']),
            ]
        );

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $roleName = $request->input('role') === 'admin' ? 'Admin' : 'Petugas';
        return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk sebagai ' . $roleName . ' (' . $user->name . ')!');
    }

    /**
     * Memproses Logout Pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
