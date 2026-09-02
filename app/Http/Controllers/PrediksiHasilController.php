<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk fitur Prediksi Hasil.
 * 
 * Class ini bertanggung jawab untuk memproses algoritma 
 * atau menampilkan estimasi panen / hasil produksi ayam.
 */
class PrediksiHasilController extends Controller
{
    /**
     * Menampilkan halaman prediksi hasil produksi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('prediksihasil');
    }
}
