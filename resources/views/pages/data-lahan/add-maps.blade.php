@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Tambah Titik Lokasi Lahan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/data-lahan">Data Lahan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data-lahan.show', $data->id) }}">Detail Data Lahan {{ $data->kode_lahan }}</a></li>
            <li class="breadcrumb-item active">Tambah Titik Lokasi Lahan</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="col-12">
        <div class="card">
            <div class="card-body pt-3">

                <form id="formTitik">
                    @csrf
                    <input type="hidden" id="lahan_id" name="lahan_id" value="{{ $data->id }}">
                    <input type="hidden" name="luas" id="luasLahan" value="">
                    <div class="alert alert-info mb-3">
                        <b>Luas Sementara :</b>
                        <span id="luasMeter">0 m²</span>
                        <br>
                        <small>
                            ≈ <span id="luasHektar">0 Ha</span>
                        </small>
                    </div>
                    <div id="map" style="width:100%; height:650px;"></div>
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('data-lahan.show', $data->id) }}" class="btn btn-secondary"> Kembali </a>
                        <div> 
                            <button type="button" id="btnReset" class="btn btn-danger"> Reset </button>
                            <button type="button" id="btnSimpan" class="btn btn-success"> Simpan </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

<script>
const map = L.map('map').setView(
    [-7.030741623246851, 112.75356117827202],
    18
);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }
).addTo(map);

let titikBaru = [];
let markers = [];
let polygonBaru = null;

// ==========================
// LOAD POLYGON LAMA
// ==========================

$(document).ready(function () {

    $.getJSON('/data-titik', function (data) {

        let group = L.featureGroup().addTo(map);

        data.forEach(function (item) {

            // jangan tampilkan lahan yang sedang diedit
            if(item.id == {{ $data->id }}) {
                return;
            }

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

            const polygon = L.polygon(
                coordinates,
                {
                    color: warna,
                    fillColor: warna,
                    fillOpacity: 0.5,
                    weight: 2
                }
            ).addTo(map);

            group.addLayer(polygon);

            polygon.bindPopup(`
                <b>${item.kode_lahan}</b><br>
                ${item.nama_lahan}
            `);

        });

        if(group.getLayers().length > 0){
            map.fitBounds(group.getBounds());
        }

    });

});

// ==========================
// HITUNG LUAS
// ==========================

function hitungLuas(coordinates){

    // Turf butuh polygon tertutup
    const polygonCoords = coordinates.map(coord => [
        coord[1], // longitude
        coord[0]  // latitude
    ]);

    polygonCoords.push(polygonCoords[0]);

    const polygon = turf.polygon([
        polygonCoords
    ]);

    const area = turf.area(polygon);

    $('#luasMeter').text(
        area.toFixed(2) + ' m²'
    );

    $('#luasLahan').val(
        area.toFixed(2)
    );

    $('#luasHektar').text(
        (area / 10000).toFixed(4) + ' Ha'
    );

}

// ==========================
// GAMBAR POLYGON MERAH
// ==========================

function gambarPolygonBaru(){

    if(polygonBaru){
        map.removeLayer(polygonBaru);
    }

    if(titikBaru.length >= 3){

        const coordinates = titikBaru.map(function(item){
            return [
                item.latitude,
                item.longitude
            ];
        });

        polygonBaru = L.polygon(
            coordinates,
            {
                color:'red',
                fillColor:'red',
                fillOpacity:0.4,
                weight:3
            }
        ).addTo(map);

        hitungLuas(coordinates);

    }

}

// ==========================
// TAMBAH TITIK
// ==========================

map.on('click', function(e){

    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    titikBaru.push({
        latitude: lat,
        longitude: lng
    });

    const marker = L.marker(
        [lat,lng]
    ).addTo(map);

    marker.bindPopup(
        'Titik ' + titikBaru.length
    );

    markers.push(marker);

    gambarPolygonBaru();

});

// ==========================
// RESET
// ==========================

$('#btnReset').click(function(){

    markers.forEach(function(marker){
        map.removeLayer(marker);
    });

    markers = [];
    titikBaru = [];

    if(polygonBaru){
        map.removeLayer(polygonBaru);
        polygonBaru = null;
    }

    $('#luasMeter').text('0 m²');
    $('#luasHektar').text('0 Ha');

});

// ==========================
// SIMPAN
// ==========================

$('#btnSimpan').click(function(){

    if(titikBaru.length < 3){

        alert(
            'Minimal 3 titik untuk membentuk polygon'
        );

        return;
    }

    $.ajax({

        url: "{{ route('titik-lahan.store') }}",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            lahan_id: {{ $data->id }},
            luas: $('#luasLahan').val(),
            titik: titikBaru
        },

        success: function(){

            alert(
                'Titik berhasil disimpan'
            );

            location.href =
                "{{ route('data-lahan.show',$data->id) }}";

        },

        error: function(xhr){

            console.log(xhr);

            alert(
                'Gagal menyimpan titik'
            );

        }

    });

});

</script>

@endsection