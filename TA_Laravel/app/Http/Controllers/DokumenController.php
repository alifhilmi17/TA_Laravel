<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk manajemen Dokumen.
 * 
 * Class ini bertanggung jawab untuk mengelola arsip
 * atau laporan-laporan penting terkait peternakan.
 */
class DokumenController extends Controller
{
    /**
     * Menampilkan halaman kelola dokumen/laporan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dokumen');
    }
}
