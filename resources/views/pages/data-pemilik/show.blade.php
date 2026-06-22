@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Data Pemilik</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Data Pemilik</li>
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

                        <div class="table-responsive">
                            <table class="table text-center" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>nama</th>
                                        <th>Alamat</th>
                                        <th>Lahan Yang Dimiliki</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data->nik_pemilik }}</td>
                                        <td>{{ $data->nama_pemilik }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>
                                            @if ($data->lahans->count() > 0)
                                                {{ $data->lahans->count() }} lahan
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center my-3">
                            <a href="{{ route('data-pemilik.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        {{-- <div class="d-flex align-items-center justify-content-end m-3">
                            <a href="{{ route('data-pemilik.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-square"></i> Data Baru
                            </a>
                        </div> --}}

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>Kode Lahan</th>
                                        <th>Nama Lahan</th>
                                        <th>Koordinat</th>
                                        <th>Kategori</th>
                                        <th>Luas</th>
                                        <th>Status Verifikasi</th>
                                        <th>Status Lahan</th>
                                        <th>Deskripsi</th>
                                        <th>Penanggung Jawab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_lahan as $item)
                                        <tr>
                                            <td>{{ $item->kode_lahan }}</td>
                                            <td>{{ $item->nama_lahan }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($item->titikLahans as $titik)
                                                        <li>{{ [$titik->latitude, $titik->longitude] }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $item->kategori->warna }}; color: white;">
                                                    {{ $item->kategori->nama_kategori }}
                                                </span>
                                            </td>
                                            <td>{{ $item->luas }} m<sup>2</sup></td>
                                            <td>{{ $item->status_verifikasi }} </td>
                                            <td>{{ $item->status_lahan }} </td>
                                            <td>{{ $item->deskripsi }} </td>
                                            <td>{{ $item->petugas->name }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <p class="my-3 fw-bold"> Preview :  </p>
                        <div id="map" style="width: 100%; height: 750px;"></div>

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
    </section>
@endsection
