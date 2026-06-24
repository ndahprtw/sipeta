<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Lahan;
use App\Models\TitikLahan;
use Illuminate\Http\Request;

class TitikLahanController extends Controller
{
    public function show($id) {
        $data = Lahan::findOrFail($id);
        return view('pages.data-lahan.add-maps', compact('data'));
    }

    public function store(Request $request)
    {
        foreach ($request->titik as $item) {
            TitikLahan::create([
                'lahan_id' => $request->lahan_id,
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
            ]);
        }

        $lahan = Lahan::findOrFail($request->lahan_id);
        $lahan->update([
            'luas' => $request->luas,
        ]);

        Activity::create([
            'aktivitas' => auth()->user()->name . ' menambahkan lokasi untuk lahan : ' . $lahan->kode_lahan,
            'staff_id' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function edit($id)
    {
        $data = Lahan::with('titikLahans')->findOrFail($id);
        return view( 'pages.data-lahan.edit-maps', compact('data'));
    }

    public function update(Request $request, $id)
    {
        TitikLahan::where('lahan_id', $id)->delete();
        foreach ($request->titik as $item) {
            TitikLahan::create([
                'lahan_id' => $id,
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
            ]);
        }
        $lahan = Lahan::findOrFail($id);
        $lahan->update([
            'luas' => $request->luas
        ]);

        Activity::create([
            'aktivitas' => auth()->user()->name . ' mengupdate lokasi untuk lahan : ' . $lahan->kode_lahan,
            'staff_id' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        $lahan = Lahan::findOrFail($id);
        TitikLahan::where('lahan_id', $lahan->id)->delete();
        $lahan->update([
            'luas' => null
        ]);

        Activity::create([
            'aktivitas' => auth()->user()->name . ' menghapus lokasi untuk lahan : ' . $lahan->kode_lahan,
            'staff_id' => auth()->user()->id,
        ]);

        return redirect()->route('data-lahan.show', $lahan->id)->with('success', 'Titik lokasi lahan berhasil dihapus');
    }
}
