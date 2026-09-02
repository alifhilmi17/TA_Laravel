<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk memantau Kesehatan Ayam.
 * 
 * Class ini bertanggung jawab untuk menampilkan halaman
 * pengecekan dan rekam medis kesehatan ayam.
 */
class KesehatanAyamController extends Controller
{
    /**
     * Menampilkan halaman kesehatan ayam.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('kesehatanayam');
    }
}
