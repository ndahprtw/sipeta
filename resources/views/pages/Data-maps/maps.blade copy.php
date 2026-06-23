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
    </div><!-- End Page Title -->

    <section class="section profile">

        <div class="col-12">
            <div class="card">
                <div class="card-body pt-3">

                    <div class="table-responsive">
                        <div id="map" style="width: 100%; height: 750px;"></div>
                    </div>

                    <script>
                        const map = L.map('map').setView([-6.0106218,106.0316497], 18);
                    
                        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);
                    
                        $(document).ready(function () {
                            // Ambil data dari server
                            $.getJSON('/data-titik', function (data) {
                                data.forEach(function (item) {
                                    // Ambil koordinat untuk membentuk poligon
                                const coordinates = item.detail_lokasi.map(coord => [
                                        coord.latitude,
                                        coord.longitude
                                    ]);
                                    console.log(item.detail_lokasi);
                    
                                    // Buat poligon dan tambahkan ke peta
                                    const polygon = L.polygon(coordinates, { color: 'blue' }).addTo(map);
                    
                                    // Isi popup dengan data dari item
                                    const popupContent = `
                                        <b>Lokasi Bidang:</b> ${item.lokasi_bidang}<br>
                                        <b>Blok:</b> ${item.blok}<br>
                                        <b>Bidang:</b> ${item.bidang}<br>
                                        <b>Pemilik:</b> ${item.nama_pemilik}<br>
                                        <b>Luas Lahan:</b> ${item.luas_lahan} m²<br>
                                        <b>Atas Hak:</b> ${item.atas_hak}<br>
                                        <b>Tanggal Transaksi:</b> ${item.tanggal_transaksi}<br>
                                    `;
                    
                                    // Tambahkan popup ke poligon
                                    polygon.bindPopup(popupContent);
                    
                                    // Event klik untuk membuka popup
                                    polygon.on('click', function () {
                                        this.openPopup();
                                    });
                                });
                            });
                        });
                    </script>
                    

                </div>
            </div>
        </div>

    </section>
@endsection
