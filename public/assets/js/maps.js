
const map = L.map('map').setView(
    [-7.030741623246851,112.75356117827202],
    18
);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom:19,
        attribution:'&copy; OpenStreetMap'
    }
).addTo(map);

let polygons = [];

$.getJSON('/data-titik', function(data){

    let group = L.featureGroup().addTo(map);

    data.forEach(function(item){

        if(
            !item.titik_lahans ||
            item.titik_lahans.length < 3
        ){
            return;
        }

        const coordinates =
            item.titik_lahans.map(function(titik){

                return [
                    parseFloat(titik.latitude),
                    parseFloat(titik.longitude)
                ];

            });

        let warna = '#0d6efd';

        if(item.status_lahan == 'tersedia'){
            warna = '#198754';
        }

        if(item.status_lahan == 'dalam proses'){
            warna = '#ffc107';
        }

        if(item.status_lahan == 'dijual'){
            warna = '#dc3545';
        }

        const polygon = L.polygon(
            coordinates,
            {
                color:warna,
                fillColor:warna,
                fillOpacity:0.5,
                weight:2
            }
        ).addTo(map);

        polygons.push({

            polygon:polygon,

            kategori:
                item.kategori
                ? item.kategori.id
                : null,

            status:
                item.status_lahan

        });

        group.addLayer(polygon);

        polygon.bindPopup(`
            <h6>${item.nama_lahan}</h6>

            <hr>

            <b>Pemilik :</b>
            ${
                item.pemilik
                ? item.pemilik.nama_pemilik
                : '-'
            }
            <br>

            <b>Kategori :</b>
            ${
                item.kategori
                ? item.kategori.nama_kategori
                : '-'
            }
            <br>

            <b>Luas :</b>
            ${
                item.luas
                ? item.luas + ' m²'
                : '-'
            }
            <br>

            <b>Status :</b>
            ${item.status_lahan}
            <br>

            <b>Deskripsi :</b>
            ${item.deskripsi ?? '-'}
        `);

    });

    if(group.getLayers().length){
        map.fitBounds(
            group.getBounds()
        );
    }

});

function filterPolygon(){

    const kategori =
        $('#filterKategori').val();

    const status =
        $('#filterStatus').val();

    polygons.forEach(function(item){

        let tampil = true;

        if(
            kategori &&
            item.kategori != kategori
        ){
            tampil = false;
        }

        if(
            status &&
            item.status != status
        ){
            tampil = false;
        }

        if(tampil){

            if(
                !map.hasLayer(
                    item.polygon
                )
            ){
                item.polygon.addTo(map);
            }

        }else{

            if(
                map.hasLayer(
                    item.polygon
                )
            ){
                map.removeLayer(
                    item.polygon
                );
            }

        }

    });

}

$('#filterKategori').change(
    filterPolygon
);

$('#filterStatus').change(
    filterPolygon
);