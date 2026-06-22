@extends('layouts.main')

@section('content')

    <style>
    .carousel-control-prev,
    .carousel-control-next {
        pointer-events: none;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        pointer-events: auto;
    }
    </style>

    <div class="pagetitle">
    <h1>Detail Data Lahan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/data-lahan">Data Lahan</a></li>
                <li class="breadcrumb-item active">Detail Data Lahan</li>
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pt-3">

                        <p class="my-3 fw-bold"> Detail Data :  </p>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="30%"><strong>Kode Lahan</strong></td>
                                    <td>{{ $data->kode_lahan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lahan</strong></td>
                                    <td>{{ $data->nama_lahan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Pemilik</strong></td>
                                    <td>{{ $data->pemilik->nama_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIK Pemilik</strong></td>
                                    <td>{{ $data->pemilik->nik_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat Pemilik</strong></td>
                                    <td>{{ $data->pemilik->alamat }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori</strong></td>
                                    <td>
                                        <span class="badge"
                                            style="background-color: {{ $data->kategori->warna }}; color: white;">
                                            {{ $data->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Luas Lahan</strong></td>
                                    <td>{{ number_format($data->luas, 0, ',', '.') }} m<sup>2</sup></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Lahan</strong></td>
                                    <td>{{ ucfirst($data->status_lahan) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status Verifikasi</strong></td>
                                    <td>{{ ucfirst($data->status_verifikasi) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat Oleh</strong></td>
                                    <td>{{ $data->petugas->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Dibuat</strong></td>
                                    <td>{{ $data->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi</strong></td>
                                    <td>{{ $data->deskripsi ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">

                <div class="row">

                    {{-- foto lahan --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pt-3">
                                <div class="d-flex align-items-center justify-content-between mx-3">
                                    <p class="my-3 fw-bold">{{ $data->fotoLahans->count() }} Foto Lahan</p>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahFotoLahan"> <i class="bi bi-images"></i> </button>
                                    <div class="modal fade" id="tambahFotoLahan" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">Tambah Foto Lahan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('foto-lahan.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="lahan_id" value="{{ $data->id }}">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Foto Lahan</label>
                                                            <input type="file" class="form-control @error('foto') is-invalid @enderror shadow-none" name="foto" id="" accept="image/*">
                                                            @error('foto') 
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div> 
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Keterangan</label>
                                                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror shadow-none" name="keterangan" id="" accept="image/*">
                                                            @error('keterangan') 
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div> 
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Tambah</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($data->fotoLahans->count() > 0)
                                    <div id="carouselFotoLahan" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($data->fotoLahans as $foto)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('assets/img/lahan/'. $data->kode_lahan . '/' . $foto->foto) }}" class="d-block w-100 rounded" style="height:300px; object-fit:cover;" alt="Foto Lahan">
                                                    <div class="d-flex align-items-center justify-content-between mx-3">
                                                        <p class="my-2">{{ $foto->keterangan }}</p>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFotoLahan{{ $foto->id }}"> <i class="bi bi-trash-fill"></i> </button>
                                                        <div class="modal fade" id="deleteFotoLahan{{ $foto->id }}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="ModalLabel">Konfirmasi Hapus Data</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menghapus foto untuk <strong>{{ $foto->keterangan }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="{{ route('foto-lahan.destroy', $foto->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotoLahan" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselFotoLahan" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button> --}}
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4">
                                        Belum ada foto pada lahan terkait.
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pt-3">
                                <p class="my-3 fw-bold"> Titik Koordinat :  </p>
                                <ul>
                                    @foreach ($data->titikLahans as $titik)
                                        <li>[ {{ $titik->latitude }}, {{ $titik->longitude }} ]</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body pt-3">
                                <p class="my-3 fw-bold"> Preview :  </p>
                                <div id="map" style="width: 100%; height: 500px;"></div>
        
                                <script>
                                    const map = L.map('map').setView([-7.030741623246851, 112.75356117827202], 18);
                                
                                    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                                    }).addTo(map);
                                
                                    
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
