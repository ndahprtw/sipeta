@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Edit Titik Lokasi Lahan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/data-lahan">Data Lahan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data-lahan.show', $data->id) }}">Detail Data Lahan {{ $data->kode_lahan }}</a></li>
            <li class="breadcrumb-item active">Edit Titik Lokasi Lahan</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="col-12">
        <div class="card">
            <div class="card-body pt-3">

                <form id="formTitik">
                    @csrf
                   <div class="alert alert-info mb-3">
    <b>Luas :</b>
    <span id="luasMeter">{{ $data->luas ?? 0 }} m²</span>
    <br>
    <small>
        ≈ <span id="luasHektar">
            {{ $data->luas ? number_format($data->luas / 10000, 4) : 0 }}
        </span> Ha
    </small>
</div>

<input type="hidden" id="luasLahan" value="{{ $data->luas }}">

<div id="map" style="height:700px;"></div>

<div class="mt-3 d-flex justify-content-between">

    <a href="{{ route('data-lahan.show',$data->id) }}"
       class="btn btn-secondary">
        Kembali
    </a>

    <div>
        <button
            type="button"
            id="btnReset"
            class="btn btn-danger">
            Gambar Ulang
        </button>

        <button
            type="button"
            id="btnSimpan"
            class="btn btn-success">
            Simpan Perubahan
        </button>
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
let markerLama = [];
let polygonBaru = null;
let polygonLama = null;
let modeEdit = false;

// ===================================
// DATA TITIK LAMA
// ===================================

const titikLama = @json($data->titikLahans);

if (titikLama.length > 0) {

    const coordinates = titikLama.map(item => [
        parseFloat(item.latitude),
        parseFloat(item.longitude)
    ]);

    polygonLama = L.polygon(coordinates, {
        color: 'blue',
        fillColor: 'blue',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map);

    titikLama.forEach(function(item){

        const marker = L.marker([
            parseFloat(item.latitude),
            parseFloat(item.longitude)
        ]).addTo(map);

        markerLama.push(marker);

    });

    map.fitBounds(polygonLama.getBounds());

}

// ===================================
// HITUNG LUAS
// ===================================

function hitungLuas(coordinates){

    const polygonCoords = coordinates.map(coord => [
        coord[1],
        coord[0]
    ]);

    polygonCoords.push(polygonCoords[0]);

    const polygon = turf.polygon([
        polygonCoords
    ]);

    const area = turf.area(polygon);

    $('#luasMeter').text(
        area.toFixed(2) + ' m²'
    );

    $('#luasHektar').text(
        (area / 10000).toFixed(4)
    );

    $('#luasLahan').val(
        area.toFixed(2)
    );

}

// ===================================
// GAMBAR POLYGON BARU
// ===================================

function gambarPolygon(){

    if (polygonBaru) {
        map.removeLayer(polygonBaru);
    }

    if (titikBaru.length >= 3) {

        const coordinates = titikBaru.map(item => [
            item.latitude,
            item.longitude
        ]);

        polygonBaru = L.polygon(coordinates, {
            color: 'red',
            fillColor: 'red',
            fillOpacity: 0.5,
            weight: 2
        }).addTo(map);

        hitungLuas(coordinates);

    }

}

// ===================================
// TAMBAH TITIK BARU
// ===================================

map.on('click', function(e){

    if (!modeEdit) {
        return;
    }

    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    titikBaru.push({
        latitude: lat,
        longitude: lng
    });

    const marker = L.marker([lat, lng])
        .addTo(map);

    markers.push(marker);

    gambarPolygon();

});

// ===================================
// GAMBAR ULANG
// ===================================

$('#btnReset').click(function(){

    if(!confirm('Mulai menggambar ulang polygon?')){
        return;
    }

    modeEdit = true;

    // hapus polygon lama
    if (polygonLama) {
        map.removeLayer(polygonLama);
    }

    // hapus marker lama
    markerLama.forEach(function(marker){
        map.removeLayer(marker);
    });

    markerLama = [];

    // hapus marker baru
    markers.forEach(function(marker){
        map.removeLayer(marker);
    });

    markers = [];

    // hapus polygon baru
    if (polygonBaru) {
        map.removeLayer(polygonBaru);
        polygonBaru = null;
    }

    titikBaru = [];

    $('#luasMeter').text('0 m²');
    $('#luasHektar').text('0');
    $('#luasLahan').val('');

    alert('Silakan klik peta untuk membuat polygon baru');

});

// ===================================
// SIMPAN
// ===================================

$('#btnSimpan').click(function(){

    if(!confirm('Simpan perubahan polygon?')){
        return;
    }

    if(titikBaru.length < 3){

        alert('Minimal 3 titik');

        return;

    }

    $.ajax({

        url: "{{ route('titik-lahan.update', $data->id) }}",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            _method: "PUT",
            luas: $('#luasLahan').val(),
            titik: titikBaru
        },

        success: function(){

            alert('Polygon berhasil diperbarui');

            window.location.href =
                "{{ route('data-lahan.show', $data->id) }}";

        },

        error: function(xhr){

            console.log(xhr);

            alert('Terjadi kesalahan');

        }

    });

});

</script>

@endsection