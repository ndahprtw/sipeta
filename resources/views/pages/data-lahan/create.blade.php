@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Tambah Data Lahan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/data-lahan">Data Lahan</a></li>
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
                        <form action="{{ route('data-lahan.store') }}" method="POST">
                            @csrf

                            <div class="row">
    
                                <div class="col-md-12 mb-3">
                                    <label for="nama_lahan">Nama Lahan</label>
                                    <input type="text" name="nama_lahan" class="form-control @error('nama_lahan') is-invalid @enderror" value="{{ old('nama_lahan') }}">
                                    @error('nama_lahan') <div class="invalid-feedback"> 
                                        {{ $message }} </div>
                                    @enderror
                                </div>
    
                                <div class="col-md-12 mb-3">
                                    <label for="kategori">Kategori Lahan</label>
                                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"{{ old('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }} </option>
                                        @endforeach
                                    </select>
                                    @error('kategori') <div class="invalid-feedback"> 
                                        {{ $message }} </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label for="pemilik">Pemilik</label>
                                    <select class="form-select select2 @error('pemilik') is-invalid @enderror" name="pemilik" id="pemilik">
                                        <option value="">Pilih Pemilik</option>
                                        @foreach ($pemilik as $p)
                                            <option value="{{ $p->id }}" {{ old('pemilik') == $p->id ? 'selected' : '' }}> {{ $p->nama_pemilik }} | {{ $p->nik_pemilik }} </option>
                                        @endforeach
                                    </select>
                                    @error('pemilik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
    
                                <div class="col-md-12 mb-3">
                                    <label for="penanggung_jawab_id">Penanggung Jawab</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                                    <input type="hidden" name="penanggung_jawab_id" id="penanggung_jawab_id" value="{{ auth()->user()->id }}">
                                    @error('penanggung_jawab_id') <div class="invalid-feedback"> 
                                        {{ $message }} </div>
                                    @enderror
                                </div>
    
                                {{-- <div class="col-md-12 mb-3">
                                    <label for="luas">Luas Tanah (m²)</label>
                                    <input type="number" name="luas" class="form-control @error('luas') is-invalid @enderror" value="{{ old('luas') }}">
                                    @error('luas') <div class="invalid-feedback"> 
                                        {{ $message }} </div>
                                    @enderror
                                </div> --}}
    
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi') <div class="invalid-feedback"> 
                                        {{ $message }} </div>
                                    @enderror
                                </div>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('data-lahan.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('#pemilik').select2({
            placeholder: 'Cari Pemilik...',
            theme: 'bootstrap-5',
            width: '100%'
        });
    </script>
@endsection