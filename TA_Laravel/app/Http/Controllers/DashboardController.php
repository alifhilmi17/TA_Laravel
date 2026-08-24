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

        // Data Ringkasan Statistik Peternakan
        $stats = [
            'total_telur_today' => 1250,
            'telur_cacat'       => 12,
            'total_ayam_aktif'  => 1500,
            'ayam_sakit'        => 3,
            'mortalitas_today'  => 1,
            'stok_pakan_kg'     => 450,
            'pendapatan_bulan'  => 18500000,
            'pengeluaran_bulan' => 9200000,
            'status_afkir'      => 25,
            'total_batch'       => 4,
        ];

        return view('dashboard', compact('user', 'stats'));
    }
}
