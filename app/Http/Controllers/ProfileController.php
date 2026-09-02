<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk pengaturan Profil Pengguna.
 * 
 * Class ini bertanggung jawab untuk halaman edit profil 
 * dan manajemen akun petugas/pengguna.
 */
class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('edit-profile');
    }
}
