<?php

namespace App\Http\Controllers;

use App\Models\PerangkatFtth;

class CatalogController extends Controller
{
    public function index() {
        $perangkat = PerangkatFtth::all();
        return view('katalog.index', compact('perangkat'));
    }
}
