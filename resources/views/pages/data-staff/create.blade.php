@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Staff</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('data-staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form action="{{ route('data-staff.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group p-2">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror shadow-none" placeholder="Masukkan nama" value="{{ old('name') }}">
                                @error('name') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="no_telepon">No Telepon / WhatsApp</label>
                                <input type="text" name="no_telepon" id="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror shadow-none" placeholder="Format: 62xxxxxxxxxxx" value="{{ old('no_telepon') }}">
                                @error('no_telepon') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror shadow-none" placeholder="Masukkan email" value="{{ old('email') }}">
                                @error('email') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror shadow-none">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Petugas" {{ old('role') == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                                </select>
                                @error('role') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror shadow-none" placeholder="Masukkan password">
                                @error('password') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="profile">Profile (3x3)</label>
                                <input type="file" name="profile" id="profile" class="form-control @error('profile') is-invalid @enderror shadow-none">
                                @error('profile') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="m-2 mt-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('data-staff.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection