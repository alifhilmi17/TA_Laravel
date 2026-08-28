<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Keuangan.
 * 
 * Class ini bertanggung jawab untuk pencatatan transaksi
 * masuk dan keluar (cash flow) dari peternakan.
 */
class KeuanganController extends Controller
{
    /**
     * Menampilkan halaman pencatatan keuangan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('keuangan');
    }
}
