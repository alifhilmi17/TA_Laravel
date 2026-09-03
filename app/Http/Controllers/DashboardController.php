<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Dasbor Utama.
     */
    public function index()
    {
        $user = Auth::user();

        // Data statistik kini dimuat secara dinamis via JavaScript (Firestore) di sisi klien.

        return view('dashboard', compact('user'));
    }
}
