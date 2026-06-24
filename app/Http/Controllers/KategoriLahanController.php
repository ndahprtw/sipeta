<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\KategoriLahan;
use Illuminate\Http\Request;

class KategoriLahanController extends Controller
{
    public function index() {
        $data = KategoriLahan::orderBy('nama_kategori')->get();
        return view('pages.data-kategori.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'warna' => 'required|unique:kategori_lahans,warna',
            'deskripsi' => 'required',
        ]); 
        
        $data = KategoriLahan::create([
            'nama_kategori' => $request->kategori,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($data->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menambahkan kategori lahan baru : ' . $request->kategori,
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('kategori-lahan.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'warna' => 'required',
            'deskripsi' => 'required',
        ]); 
        
        $data = KategoriLahan::findOrFail($id);
        $data->update([
            'nama_kategori' => $request->kategori,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($data->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' mengupdate kategori lahan : ' . $request->kategori,
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('kategori-lahan.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function destroy($id)
    {
        $data = KategoriLahan::findOrFail($id);
        if ($data->delete()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menghapus kategori lahan : ' . $data->nama_kategori,
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('kategori-lahan.index')->with('success', 'Data Terkait Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
