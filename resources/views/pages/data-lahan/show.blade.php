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
                    <div class="card-body">
                        <div class="mb-2 mt-4 d-flex justify-content-between align-items-center">
                            <a href="{{ route('data-lahan.index') }}" class="btn btn-outline-secondary">Kembali ke Halaman Data Lahan</a>
                            @if ($data->status_verifikasi == 'menunggu')
                                <button title="Laporan hanya dapat diunduh setelah data disetujui" class="btn btn-secondary"><i class="bi bi-download"></i></button>
                            @else
                                <a href="/unduh-data/{{ $data->id }}" target="_blank" class="btn btn-danger"> <i class="bi bi-download"></i> </a>
                            @endif
                        </div>
                    </div>
                </div>

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

                {{-- riwayat pemilik--}}
                <div class="card">
                    <div class="card-body pt-3">
                        <p class="my-3 fw-bold"> Riwayat Pemilik :  </p>
                        @if ($data->riwayatPemiliks->count() > 0)
                            <ol>
                                @foreach ($data->riwayatPemiliks as $rp)
                                    <li>
                                        <b>Tanggal Peralihan : </b>{{ $rp->tanggal_peralihan}} <br>
                                        Pemilik Lama : {{ $rp->pemilikLama->nama_pemilik }} <br>
                                        Pemilik Baru : {{ $rp->pemilikBaru->nama_pemilik }} <br>
                                        Keterangan : -
                                    </li> <br>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-danger text-center">Belum ada riwayat peralihan</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">

                <div class="row">

                    {{-- foto lahan --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pt-3">
                                @if (auth()->user()->role == 'Petugas')
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
                                @elseif (auth()->user()->role == 'Admin')
                                    <p class="my-3 fw-bold">{{ $data->fotoLahans->count() }} Foto Lahan</p>
                                @endif

                                @if($data->fotoLahans->count() > 0)
                                    <div id="carouselFotoLahan" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($data->fotoLahans as $foto)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('assets/img/lahan/'. $data->kode_lahan . '/' . $foto->foto) }}" class="d-block w-100 rounded" style="height:300px; object-fit:cover;" alt="Foto Lahan">
                                                    
                                                    @if (auth()->user()->role == 'Petugas')
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
                                                    @elseif (auth()->user()->role == 'Admin')
                                                        <p class="text-center my-2">{{ $foto->keterangan }}</p>
                                                    @endif
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
                                    <p class="text-danger text-center">Belum ada foto pada lahan terkait.</p>
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- titik koordinat --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pt-3">
                                <p class="my-3 fw-bold"> Titik Koordinat :  </p>
                                @if ($data->titikLahans->count() > 0)
                                    <ul>
                                        @foreach ($data->titikLahans as $titik)
                                            <li>[ {{ $titik->latitude }}, {{ $titik->longitude }} ]</li>
                                        @endforeach
                                    </ul>
                                    @if (auth()->user()->role == 'Petugas')
                                        <div class="d-flex justify-content-between align-items-center">
                                            {{-- edit lokasi --}}
                                            <a href="{{ route('titik-lahan.edit', $data->id) }}" class="btn btn-primary"> <i class="bi bi-pencil-square"></i> Edit Koordinat </a>
                                            
                                            {{-- hapus lokasi --}}
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
                                                <i class="bi bi-trash-fill"></i> Hapus Koordinat
                                            </button>
                                            <div class="modal fade" id="deleteModal{{ $data->id }}" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalLabel">Hapus Koordinat {{ $data->kode_lahan }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body my-3">
                                                            Apakah Anda yakin ingin menghapus titik koordinat terkait?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('titik-lahan.destroy', $data->id) }}" method="POST">
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
                                    @endif
                                @else
                                    <div class="text-center">
                                        <p class="text-danger text-center">Titik koordinat belum ditentukan.</p>
                                        @if (auth()->user()->role == 'Petugas')
                                            <a href="{{ route('titik-lahan.show', $data->id) }}" class="btn btn-primary"> <i class="bi bi-plus-square"></i> Tambah Lokasi Lahan</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- preview --}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body pt-3">
                                @if ($data->titikLahans->count() > 0)
                                    <p class="my-3 fw-bold"> Preview :  </p>
                                    <div id="map" style="width: 100%; height: 500px;"></div>
                                @else
                                    <p class="text-danger my-5 text-center">Preview lokasi lahan akan muncul setelah menentukan titik koordinat.</p>
                                @endif 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('scripts')
    <script>
        const map = L.map('map').setView([-7.030741623246851, 112.75356117827202], 16);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        $(document).ready(function () {

            $.getJSON('/koordinat-lahan/{{ $data->id }}', function (data) {

                let group = L.featureGroup().addTo(map);

                data.forEach(function (item) {

                    // Skip jika belum punya minimal 3 titik
                    if (!item.titik_lahans || item.titik_lahans.length < 3) {
                        return;
                    }

                    const coordinates = item.titik_lahans.map(function (titik) {
                        return [
                            parseFloat(titik.latitude),
                            parseFloat(titik.longitude)
                        ];
                    });

                    const warna = item.kategori
                        ? item.kategori.warna
                        : '#3388ff';

                    const polygon = L.polygon(coordinates, {
                        color: warna,
                        fillColor: warna,
                        fillOpacity: 0.5,
                        weight: 2
                    }).addTo(map);

                    group.addLayer(polygon);

                    const popupContent = `
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><b>Kode</b></td>
                                <td>${item.kode_lahan}</td>
                            </tr>
                            <tr>
                                <td><b>Nama</b></td>
                                <td>${item.nama_lahan}</td>
                            </tr>
                            <tr>
                                <td><b>Pemilik</b></td>
                                <td>${item.pemilik ? item.pemilik.nama_pemilik : '-'}</td>
                            </tr>
                            <tr>
                                <td><b>Kategori</b></td>
                                <td>${item.kategori ? item.kategori.nama_kategori : '-'}</td>
                            </tr>
                            <tr>
                                <td><b>Luas</b></td>
                                <td>${item.luas ? item.luas + ' m²' : '-'}</td>
                            </tr>
                            <tr>
                                <td><b>Status</b></td>
                                <td>${item.status_lahan}</td>
                            </tr>
                            <tr>
                                <td><b>Deskripsi</b></td>
                                <td>${item.deskripsi ?? '-'}</td>
                            </tr>
                        </table>
                    `;

                    polygon.bindPopup(popupContent);

                    polygon.on('click', function () {
                        this.openPopup();
                    });

                });

                // Zoom otomatis ke seluruh polygon
                if (group.getLayers().length > 0) {
                    map.fitBounds(group.getBounds());
                }

            }).fail(function(xhr) {
                console.error('Gagal mengambil data:', xhr.responseText);
            });

        });
    </script>
@endsection