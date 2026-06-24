<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $no = 1;
        $data = Staff::orderBy('name')->get();
        
        return view('pages.data-staff.index', compact('no', 'data'));
    }

    public function create()
    {
       
        return view('pages.data-staff.create'); // Arahkan ke view form create
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'no_telepon' => 'required|numeric|min_digits:12',
            'email' => 'required|unique:staff,email',
            'role' => 'required',
            'password' => 'required',
            'profile' => 'required|image',
        ]);        
    
        // Upload profile jika ada
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $imageName = now()->format('YmdHis') . $request->email . '.' . $profile->extension();
            $profile->move(public_path('assets/img/profile/'), $imageName);
        } else {
            $imageName = null;
        }

        // Buat staff baru
        $user = Staff::create([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'role' => $request->role,
            'profile' => $imageName,
            'password' => Hash::make($request->password)
        ]);

        if ($user->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' menambahkan data ' . $request->role . ' baru.',
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('data-staff.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function edit($id)
    {
        // Temukan user berdasarkan ID
        $user = Staff::findOrFail($id);
        return view('pages.data-staff.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'no_telepon' => 'required',
            'email' => 'required',
            'role' => 'required',
            'profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional: untuk validasi profil
        ]);

        // Temukan user berdasarkan ID
        $user = Staff::findOrFail($id);

        // Upload profile jika ada
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $imageName = now()->format('YmdHis') . $request->email . '.' . $profile->extension();
            $profile->move(public_path('assets/img/profile/'), $imageName);

            // Hapus profile lama
            if ($user->profile) {
                $oldProfile = public_path('assets/img/profile/') . $user->profile;
                if (file_exists($oldProfile)) {
                    unlink($oldProfile);
                }
            }
        } else {
            $imageName = $user->profile;
        }

        // Update data user
        $user->update([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'role' => $request->role,
            'profile' => $imageName,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($user->save()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' mengupdate informasi data ' . $request->name,
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('data-staff.index')->with('success', 'Data Berhasil Diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal Mengupdate Data');
        }
    }

    public function destroy($id)
    {
        // Temukan staff berdasarkan ID
        $user = Staff::findOrFail($id);

        if ($user->profile) {
            $fotoPath = public_path('assets/img/profile/' . $user->profile);

            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        if ($user->delete()){
            Activity::create([
                'aktivitas' => auth()->user()->name . ' mengupdate informasi data ' . $user->name,
                'staff_id' => auth()->user->id,
            ]);
            return redirect()->route('data-staff.index')->with('success', 'Data Terkait Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }

}
