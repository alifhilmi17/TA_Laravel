<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Data Ayam.
 * 
 * Class ini bertanggung jawab untuk menampilkan dan 
 * memanajemen data populasi ayam di peternakan.
 */
class DataAyamController extends Controller
{
    /**
     * Menampilkan halaman data ayam.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('data-ayam');
    }
}
