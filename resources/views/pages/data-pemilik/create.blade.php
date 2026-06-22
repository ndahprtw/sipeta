@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Tambah Data Pemilik</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/data-pemilik">Data Pemilik</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        
                        <form action="{{ route('data-pemilik.store') }}" method="POST">
                            @csrf
                            <div class="form-group p-2">
                                <label for="nama">Nama Pemilik</label>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror shadow-none" placeholder="Masukkan nama pemilik" value="{{ old('nama') }}">
                                @error('nama') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="nik">NIK Pemilik</label>
                                <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror shadow-none" value="{{ old('nik') }}">
                                @error('nik') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="form-group p-2">
                                <label for="alamat">Alamat Pemilik</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror shadow-none" id="" cols="30" rows="10"> {{ old('alamat') }} </textarea>
                                @error('alamat') 
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        
                            <div class="m-2 mt-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('data-pemilik.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>   

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
