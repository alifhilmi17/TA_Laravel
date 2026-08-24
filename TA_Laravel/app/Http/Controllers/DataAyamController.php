<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataAyamController extends Controller
{
    public function index()
    {
        return view('data-ayam');
    }
}