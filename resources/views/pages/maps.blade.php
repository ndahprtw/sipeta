<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETA - Sistem Informasi Pemetaan Tanah</title>

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>

        html,
        body{
            margin:0;
            padding:0;
            width:100%;
            height:100%;
            overflow:hidden;
        }

        #map{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100dvh;
            z-index:1;
        }

        .filter-box{
            position:fixed;
            top:15px;
            left:15px;
            z-index:9999;

            width:280px;

            background:#fff;
            padding:15px;
            border-radius:12px;

            box-shadow:0 0 15px rgba(0,0,0,.15);
        }

        .login-box{
            position:fixed;
            top:15px;
            right:15px;
            z-index:9999;
        }

        .legend-box{
            position:fixed;
            bottom:15px;
            right:15px;
            z-index:9999;

            background:#fff;
            padding:15px;
            border-radius:12px;

            box-shadow:0 0 15px rgba(0,0,0,.15);
        }

        .status-dot{
            width:12px;
            height:12px;
            border-radius:50%;
            display:inline-block;
            margin-right:5px;
        }

        @media(max-width:768px){

            .filter-box{
                width:220px;
                font-size:12px;
            }

            .legend-box{
                font-size:11px;
                padding:10px;
            }

            .login-box .btn{
                font-size:12px;
            }

        }

    </style>
</head>
<body>

    {{-- FILTER --}}
    <div class="filter-box">

        <div class="text-center">
            <h6 class="fw-bold">
                SIPETA
            </h6>
            <p class="mb-3">Sistem Informasi Pemetaan Tanah</p>
        </div>

        <hr>
        <div class="mb-2">
            <label>Kategori</label>

            <select
                id="filterKategori"
                class="form-select form-select-sm">

                <option value="">
                    Semua Kategori
                </option>

                @foreach($kategori as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach

            </select>
        </div>

        <div>
            <label>Status Lahan</label>

            <select
                id="filterStatus"
                class="form-select form-select-sm">

                <option value="">
                    Semua Status
                </option>

                <option value="tersedia">
                    Tersedia
                </option>

                <option value="dalam proses">
                    Dalam Proses
                </option>

                <option value="dijual">
                    Dijual
                </option>

            </select>
        </div>

    </div>

    {{-- LOGIN --}}
    <div class="login-box">

        <a href="/login"
            class="btn btn-primary shadow">

            Login

        </a>

    </div>

    {{-- LEGENDA --}}
    <div class="legend-box">

        <strong>Legenda</strong>

        <div>
            <span
                class="status-dot"
                style="background:#198754"></span>

            Tersedia
        </div>

        <div>
            <span
                class="status-dot"
                style="background:#ffc107"></span>

            Dalam Proses
        </div>

        <div>
            <span
                class="status-dot"
                style="background:#dc3545"></span>

            dijual
        </div>

    </div>

    {{-- MAP --}}
    <div id="map"></div>

<script src="{{ asset('assets/js/maps.js') }}"></script>

</body>
</html>