<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk menangani fitur Input Produksi.
 * 
 * Class ini bertanggung jawab untuk menampilkan halaman form 
 * dan memproses data terkait produksi (misalnya telur ayam).
 */
class InputProduksiController extends Controller
{
    /**
     * Menampilkan halaman utama untuk form input produksi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('input-produksi');
    }
}
