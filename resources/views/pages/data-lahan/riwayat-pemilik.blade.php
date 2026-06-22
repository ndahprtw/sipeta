@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Riwayat Kepemilikan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/data-lahan">Data Lahan</a></li>
                <li class="breadcrumb-item active">Riwayat Kepemilikan</li>
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
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <p class="fw-bold">Kode Lahan : {{ $lahan->kode_lahan }}</p>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                Ubah Kepemilikan
                            </button>
                            <div class="modal fade" id="addModal" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Ubah Kepemilkan Lahan {{ $lahan->kode_lahan }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('riwayat-pemilik.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="lahan_id" value="{{ $lahan->id }}">
                                                <div class="mb-3">
                                                    <label for="tanggal_peralihan">Tanggal Peralihan</label>
                                                    <input type="date" name="tanggal_peralihan" id="tanggal_peralihan" class="form-control @error('tanggal_peralihan') is-invalid @enderror shadow-none" value="{{ old('tanggal_peralihan',  now()->format('Y-m-d')) }}">
                                                    @error('tanggal_peralihan') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="pemilik_lama">Pemilik Lama</label>
                                                    <input type="text" class="form-control" value="{{ $lahan->pemilik->nama_pemilik }}" disabled>
                                                    <input type="hidden" name="pemilik_lama" id="pemilik_lama" value="{{ $lahan->pemilik->id }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="pemilik_baru">Pemilik Baru</label>
                                                    <select class="form-select select2 @error('pemilik_baru') is-invalid @enderror" name="pemilik_baru" id="pemilik_baru">
                                                        <option value="">Pilih Pemilik</option>
                                                        @foreach ($pemilik as $p)
                                                            <option value="{{ $p->id }}" {{ old('pemilik_baru') == $p->id ? 'selected' : '' }}> {{ $p->nama_pemilik }} | {{ $p->nik_pemilik }} </option>
                                                        @endforeach
                                                    </select>
                                                    @error('pemilik_baru')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror shadow-none" id="" cols="3" rows="4"> {{ old('keterangan') }} </textarea>
                                                    @error('keterangan') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Peralihan</th>
                                        <th>Pemilik Lama</th>
                                        <th>Pemilik Baru</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $item->tanggal_peralihan }}</td>
                                            <td>{{ $item->pemilikLama->nama_pemilik }}</td>
                                            <td>{{ $item->pemilikBaru->nama_pemilik }}</td>
                                            <td>{{ $item->keterangan }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="my-3 d-flex justify-content-center align-items-center">
                            <a href="{{ route('data-lahan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    
@endsection
@section('scripts')
    <script>
        $('#pemilik_baru').select2({
            dropdownParent: $('#addModal'),
            theme: 'bootstrap-5',
            placeholder: 'Cari Pemilik...',
            width: '100%'
        });
    </script>
@endsection
