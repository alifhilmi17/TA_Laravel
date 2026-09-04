<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk Notifikasi/Pengingat Restock.
 * 
 * Class ini bertanggung jawab untuk menampilkan peringatan
 * ketika stok pakan atau kebutuhan lainnya sudah menipis.
 */
class RestockReminderController extends Controller
{
    /**
     * Menampilkan halaman pengingat restock barang.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('restockpakan');
    }
}
