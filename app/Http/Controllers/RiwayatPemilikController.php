<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Lahan;
use App\Models\Pemilik;
use App\Models\RiwayatPemilik;
use Illuminate\Http\Request;

class RiwayatPemilikController extends Controller
{
    public function show($id) {
        $pemilik = Pemilik::orderBy('nik_pemilik')->get();
        $lahan = Lahan::findOrFail($id);
        $data = RiwayatPemilik::where('lahan_id',$id)->get();
        return view('pages.data-lahan.riwayat-pemilik', compact('pemilik', 'lahan', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemilik_baru' => 'required',
            'tanggal_peralihan' => 'required',
            'keterangan' => 'required',
        ]); 
        
        $data = RiwayatPemilik::create([
            'lahan_id' => $request->lahan_id,
            'pemilik_lama_id' => $request->pemilik_lama,
            'pemilik_baru_id' => $request->pemilik_baru,
            'tanggal_peralihan' => $request->tanggal_peralihan,
            'keterangan' => $request->keterangan,
        ]);

        if ($data->save()){
            $lahan = Lahan::findOrFail($request->lahan_id);
            $lahan->update([
                'pemilik_id' => $request->pemilik_baru,
            ]);
            $lahan->save();
            Activity::create([
                'aktivitas' => auth()->user()->name . ' mengubah riwayat kepemilikan lahan : ' . $lahan->kode_lahan,
                'staff_id' => auth()->user()->id,
            ]);
            return redirect()->route('riwayat-pemilik.show', $request->lahan_id)->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }
}
