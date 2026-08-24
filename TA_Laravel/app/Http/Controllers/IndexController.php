<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Menampilkan Halaman Utama / Landing Page (LIBAS).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('index');
    }
}
