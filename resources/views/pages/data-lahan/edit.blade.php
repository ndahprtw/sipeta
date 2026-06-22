@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Lahan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data-lahan.index') }}">Data Lahan</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form action="{{ route('data-lahan.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label>Nama Lahan</label>
                                <input type="text" name="nama_lahan" class="form-control @error('nama_lahan') is-invalid @enderror" value="{{ old('nama_lahan', $data->nama_lahan) }}">
                                @error('nama_lahan') 
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Kategori Lahan</label>
                                <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kategori_id', $data->kategori_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Pemilik</label>
                                <input type="text" class="form-control" value="{{ $data->pemilik->nama_pemilik }} | {{ $data->pemilik->nik_pemilik }}" disabled>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Penanggung Jawab</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                <input type="hidden" name="penanggung_jawab_id" value="{{ old('penanggung_jawab_id', $data->penanggung_jawab_id) }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('data-lahan.index') }}" class="btn btn-secondary"> Kembali</a>
                                <button type="submit" class="btn btn-primary"> Update </button>
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
$(document).ready(function() {
    $('#pemilik').select2({
        placeholder: 'Cari Pemilik...',
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>
@endsection