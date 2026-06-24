<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\KategoriLahan;
use App\Models\Lahan;
use App\Models\Pemilik;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function dashboard()
    {
        $total_petugas = Staff::where('role', 'Petugas')->count();
        $total_pemilik = Pemilik::count();
        $total_lahan = Lahan::count();
        if (auth()->user()->role == 'Admin') {
            $log_aktivitas = Activity::whereDate('created_at', now())->latest()->get();
        } elseif (auth()->user()->role == 'Petugas') {
            $log_aktivitas = Activity::whereDate('created_at', now())
                    ->where('staff_id', auth()->user()->id)
                    ->latest()
                    ->get();
        }
        

        // kategori lahan
        $kategoriChart = KategoriLahan::withCount('lahans')->get();
        $kategoriLabel = $kategoriChart->pluck('nama_kategori');
        $kategoriData = $kategoriChart->pluck('lahans_count');
        $kategoriWarna = $kategoriChart->pluck('warna');

        // status lahan
        $statusLahan = Lahan::select(
            'status_lahan',
            DB::raw('count(*) as total')
        )
        ->groupBy('status_lahan')
        ->get();
        $statusLahanLabel = $statusLahan->pluck('status_lahan');
        $statusLahanData = $statusLahan->pluck('total');

        // status verifikasi
        $statusVerifikasi = Lahan::select(
            'status_verifikasi',
            DB::raw('count(*) as total')
        )
        ->groupBy('status_verifikasi')
        ->get();
        $statusVerifikasiLabel = $statusVerifikasi->pluck('status_verifikasi');
        $statusVerifikasiData = $statusVerifikasi->pluck('total');

        return view('pages.dashboard', compact(
            'total_petugas', 'total_pemilik', 'total_lahan', 'log_aktivitas',
            'kategoriLabel', 'kategoriData', 'kategoriWarna',
            'statusLahanLabel', 'statusLahanData',
            'statusVerifikasiLabel', 'statusVerifikasiData'
        ));
    }

    public function login(Request $request) {
        // dd($request);
        $request->validate([
            'email' => 'required',
            'password'=> 'required' 
         ], [
            'email.required' => 'Kolom Email tidak boleh kosong.',
            'password.required' => 'Kolom Password tidak boleh kosong.',
        ]);


         if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            if ($user->role === 'Petugas' || $user->role === 'Admin') {
                Activity::create([
                    'aktivitas' => auth()->user()->name . ' login ke sistem SIPETA',
                    'staff_id' => auth()->user()->id,
                ]);
                return redirect('/dashboard');
            } else {
                return redirect('/login')->with('wrong', 'Role tidak Ditemukan !');
            }
        } else {
            return redirect('/login')->with('wrong', 'Email dan password tidak tersedia');
        }
    }

    public function logout() {
        if (Auth::check()) {
            $role = Auth::user()->role;
    
           if ($role === 'Petugas' || $role === 'Admin') {
                Activity::create([
                    'aktivitas' => auth()->user()->name . ' logout dari sistem SIPETA',
                    'staff_id' => auth()->user()->id,
                ]);
                Auth::logout();
            }
        } 
        return redirect('/login');
    }
}
