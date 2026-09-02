<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk manajemen Stok Pakan.
 * 
 * Class ini bertanggung jawab untuk melacak ketersediaan 
 * pakan ayam di gudang.
 */
class StokPakanController extends Controller
{
    /**
     * Menampilkan halaman inventaris stok pakan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('stokpakan');
    }
}
