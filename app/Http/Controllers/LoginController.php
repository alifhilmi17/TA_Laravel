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

        // 2. Cari User di Database Lokal (Berdasarkan Username atau Email)
        $loginInput = $credentials['username'];
        $user = User::where('name', $loginInput)->orWhere('email', $loginInput)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->onlyInput('username', 'role');
        }

        // 3. Verifikasi Password melalui Firebase
        try {
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
            $auth = $factory->createAuth();

            $auth->signInWithEmailAndPassword($user->email, $credentials['password']);

            // Jika Firebase berhasil, buat sesi login lokal di Laravel
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            $roleName = $request->input('role') === 'admin' ? 'Admin' : 'Petugas';
            return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk sebagai ' . $roleName . ' (' . $user->name . ')!');
            
        } catch (\Kreait\Firebase\Exception\AuthException $e) {
            return back()->withErrors([
                'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->onlyInput('username', 'role');
        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => 'Gagal terhubung ke server Firebase: ' . $e->getMessage(),
            ])->onlyInput('username', 'role');
        }
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
