<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use Illuminate\Http\Request;

class LahanController extends Controller
{
    public function index() {
        $data = Lahan::orderBy('kode_lahan')->get();
        return view('pages.data-lahan.index', compact('data'));
    }

    public function create() {
        return view('pages.data-lahan.create');
    }

    public function edit($id) {
        $data = Lahan::findOrFail($id);
        return view('pages.data-lahan.edit', compact('data'));
    }

    public function show($id) {
        $data = Lahan::findOrFail($id);
        return view('pages.data-lahan.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = Lahan::findOrFail($id);
        if ($data->delete()){
            return redirect()->route('data-pemilik.index')->with('success', 'Data Terkait Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
