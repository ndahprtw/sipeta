<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriLahan;
use App\Models\Lahan;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class LahanController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'Admin') {
            $data = Lahan::orderBy('kode_lahan')->get();
        } elseif (auth()->user()->role == 'Petugas') {
            $data = Lahan::orderBy('kode_lahan')->where('status_verifikasi', 'menunggu')->get();
        }
        return view('pages.data-lahan.index', compact('data'));
    }

    public function create() {
        $kategori = KategoriLahan::orderBy('nama_kategori')->get();
        $pemilik = Pemilik::orderBy('nik_pemilik')->get();
        return view('pages.data-lahan.create', compact('kategori', 'pemilik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan' => 'required',
            'kategori' => 'required',
            'pemilik' => 'required',
            'deskripsi' => 'required',
        ]); 

        $lastId = Lahan::count() + 1;
        $kode_lahan = 'LHN-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        
        $data = Lahan::create([
            'kode_lahan' => $kode_lahan,
            'nama_lahan' => $request->nama_lahan,
            'kategori_id' => $request->kategori,
            'pemilik_id' => $request->pemilik,
            'status_verifikasi' => 'menunggu',
            'status_lahan' => 'tersedia',
            'deskripsi' => $request->deskripsi,
            'penanggung_jawab_id' => $request->penanggung_jawab_id,
        ]);

        if ($data->save()){
            return redirect()->route('data-lahan.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function edit($id) {
        $data = Lahan::findOrFail($id);
        $kategori = KategoriLahan::orderBy('nama_kategori')->get();
        $pemilik = Pemilik::orderBy('nik_pemilik')->get();
        return view('pages.data-lahan.edit', compact('data', 'kategori', 'pemilik'));
    }

    public function update(Request $request, $id)
    {
        $data = Lahan::findOrFail($id);
        if ($request->has('verifikasi')) {
            $data->update([
                'status_verifikasi' => 'disetujui',
            ]);

            if ($data->save()){
                return redirect()->route('data-lahan.index')->with('success', 'Data lahan telah disetujui dan akan ditampilkan pada peta publik SIPETA.');
            } else {
                return redirect()->back()->with('error', 'Gagal Menambahkan Data');
            }

        } else {
            $request->validate([
                'nama_lahan' => 'required',
                'kategori' => 'required',
                'deskripsi' => 'required',
            ]); 
            
            $data->update([
                'nama_lahan' => $request->nama_lahan,
                'kategori_id' => $request->kategori,
                'deskripsi' => $request->deskripsi,
            ]);

            if ($data->save()){
                return redirect()->route('data-lahan.index')->with('success', 'Data Berhasil Ditambahkan');
            } else {
                return redirect()->back()->with('error', 'Gagal Menambahkan Data');
            }
        }

    }

    public function show($id) {
        $data = Lahan::findOrFail($id);
        return view('pages.data-lahan.show', compact('data'));
    }

    public function unduh($id) {
        $data = Lahan::findOrFail($id);
        return view('pages.data-lahan.download', compact('data'));
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
