<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Lahan;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function index() {
        $data = Pemilik::orderBy('nik_pemilik')->get();
        return view('pages.data-pemilik.index', compact('data'));
    }

    public function create() {
        return view('pages.data-pemilik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|numeric|min_digits:16|unique:pemiliks,nik_pemilik',
            'alamat' => 'required',
        ]); 
        
        $data = Pemilik::create([
            'nama_pemilik' => $request->nama,
            'nik_pemilik' => $request->nik,
            'alamat' => $request->alamat,
        ]);

        if ($data->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menambahkan data pemilik lahan baru : ' . $request->nama,
                'staff_id' => auth()->user()->id,
            ]);
            return redirect()->route('data-pemilik.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function edit($id) {
        $data = Pemilik::findOrFail($id);
        return view('pages.data-pemilik.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|numeric|min_digits:16',
            'alamat' => 'required',
        ]); 

        $data = Pemilik::findOrFail($id);
        $data->update([
            'nama_pemilik' => $request->nama,
            'nik_pemilik' => $request->nik,
            'alamat' => $request->alamat,
        ]);

        if ($data->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' mengupdate informasi data pemilik lahan : ' . $request->nama,
                'staff_id' => auth()->user()->id,
            ]);
            return redirect()->route('data-pemilik.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function show($id) {
        $data = Pemilik::findOrFail($id);
        $data_lahan = Lahan::where('pemilik_id',$id)->orderBy('kode_lahan')->get();
        return view('pages.data-pemilik.show', compact('data', 'data_lahan'));
    }

    public function destroy($id)
    {
        $data = Pemilik::findOrFail($id);
        if ($data->delete()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menghapus informasi data pemilik lahan : ' . $data->nama_pemilik,
                'staff_id' => auth()->user()->id,
            ]);
            return redirect()->route('data-pemilik.index')->with('success', 'Data Terkait Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
