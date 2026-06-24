<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\FotoLahan;
use App\Models\Lahan;
use Illuminate\Http\Request;

class FotoLahanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required',
            'keterangan' => 'required',
        ]);        
    
        $lahan = Lahan::findOrFail($request->lahan_id);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $imageName = now()->format('YmdHis') . '.' . $foto->extension();
            $foto->move(public_path('assets/img/lahan/'.$lahan->kode_lahan.'/'), $imageName);
        } else {
            $imageName = null;
        }

        // Buat staff baru
        $data = FotoLahan::create([
            'lahan_id' => $request->lahan_id,
            'foto' => $imageName,
            'keterangan' => $request->keterangan,
        ]);

        $lahan = Lahan::findOrfail($request->lahan_id);

        if ($data->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menambahkan foto untuk lahan : ' . $lahan->kode_lahan,
            ]);
            return redirect()->route('data-lahan.show', $request->lahan_id)->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function destroy($id)
    {
        $data = FotoLahan::findOrFail($id);
        $lahan = Lahan::where('id', $data->lahan_id)->first();
        if ($data->foto) {
            $fotoPath = public_path('assets/img/lahan/' . $lahan->kode_lahan . '/' . $data->foto);

            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        if ($data->delete()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menghapus foto untuk lahan : ' . $lahan->kode_lahan,
            ]);
            return redirect()->route('data-lahan.show', $data->lahan_id)->with('success', 'Foto Terkait Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
