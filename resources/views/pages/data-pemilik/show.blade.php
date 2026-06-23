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
                                                @if ($item->titikLahans->count() > 0)
                                                    <ul>
                                                        @foreach ($item->titikLahans as $titik)
                                                            <li>[ {{ $titik->latitude }}, {{ $titik->longitude }} ]</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-danger text-center">Titik koordinat belum ditentukan</p>
                                                @endif
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

            $.getJSON('/titik-lahan-pemilik/{{ $data->id }}', function (data) {

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