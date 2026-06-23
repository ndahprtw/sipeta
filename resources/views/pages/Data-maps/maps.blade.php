@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Maps</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Maps</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="col-12">
        <div class="card">
            <div class="card-body pt-3">

                <div id="map" style="width:100%; height:750px;"></div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const map = L.map('map').setView([-7.030741623246851, 112.75356117827202], 18);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    $(document).ready(function () {

        $.getJSON('/data-titik', function (data) {

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