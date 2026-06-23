<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriLahan;
use App\Models\Lahan;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index() {
        $kategori = KategoriLahan::all();
        return view('pages.maps', compact('kategori'));
    }

    public function view_maps() {
        return view('pages.data-maps.maps');
    }

    public function json() {
        $titik_lokasi = Lahan::with(['pemilik', 'kategori', 'titikLahans'])->where('status_verifikasi', 'disetujui')->get();
        return response()->json($titik_lokasi);
    }

    public function json_pemilik_lahan($id) {
        $titik_lokasi = Lahan::with(['pemilik', 'kategori', 'titikLahans'])->where('pemilik_id', $id)->get();
        return response()->json($titik_lokasi);
    }
}
