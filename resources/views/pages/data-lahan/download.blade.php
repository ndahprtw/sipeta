<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Lahan</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">
    <style>
        body {
            padding: 30px;
            font-size: 14px;
        }

        .kop {
            border-bottom: 3px solid black;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
        }

        .judul {
            font-weight: bold;
            margin-bottom: 0;
        }

        .subjudul {
            margin-bottom: 0;
        }

        .table-detail td {
            padding: 8px 0;
            vertical-align: top;
        }

        .label {
            width: 220px;
            font-weight: 600;
        }

        .ttd {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 70px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="kop">
        <div class="row align-items-center">
            <div class="col-2 text-center">
                <img src="{{ asset('assets/img/logo.png') }}" class="logo">
            </div>

            <div class="col-10 text-center">
                <h2 class="judul">SIPETA</h2>
                <h5 class="subjudul">Sistem Informasi Pemetaan Tanah</h5>
                <small>Laporan Detail Data Lahan</small>
            </div>
        </div>
    </div>

    {{-- Judul --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold">LAPORAN DATA LAHAN</h4>
    </div>

    {{-- Isi --}}
    <div class="card border-dark">
        <div class="card-body">

            <table class="table table-borderless table-detail">
                <tr>
                    <td class="label">Kode Lahan</td>
                    <td width="10">:</td>
                    <td>{{ $data->kode_lahan }}</td>
                </tr>

                <tr>
                    <td class="label">Nama Lahan</td>
                    <td>:</td>
                    <td>{{ $data->nama_lahan }}</td>
                </tr>

                <tr>
                    <td class="label">Nama Pemilik</td>
                    <td>:</td>
                    <td>{{ $data->pemilik->nama_pemilik ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">NIK Pemilik</td>
                    <td>:</td>
                    <td>{{ $data->pemilik->nik_pemilik ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Kategori Lahan</td>
                    <td>:</td>
                    <td>{{ $data->kategori->nama_kategori ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Luas Lahan</td>
                    <td>:</td>
                    <td>
                        {{ $data->luas ? number_format($data->luas, 2) . ' m²' : '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">Status Lahan</td>
                    <td>:</td>
                    <td>{{ ucfirst($data->status_lahan) }}</td>
                </tr>

                <tr>
                    <td class="label">Status Verifikasi</td>
                    <td>:</td>
                    <td>{{ ucfirst($data->status_verifikasi) }}</td>
                </tr>

                <tr>
                    <td class="label">Deskripsi</td>
                    <td>:</td>
                    <td>{{ $data->deskripsi ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    
    <div class="row my-3">
        {{-- foto lahan --}}
        <div class="col-8">
            <div class="card border-dark">
                <div class="card-body">
                    <p class="my-3 fw-bold">Foto Lahan</p>

                    <div class="row">
                        @forelse($data->fotoLahans as $foto)
                            <div class="col-md-6 mb-3">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/lahan/' . $data->kode_lahan . '/' . $foto->foto) }}" class="img-fluid rounded border" style="height:250px; width:100%; object-fit:cover;" alt="Foto Lahan">
                                    <p class="mt-2 mb-0">
                                        {{ $foto->keterangan }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-danger text-center">
                                    Foto pada lahan terkait belum ditambahkan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <div class="card border-dark">
                        <div class="card-body">
                            <p class="my-3 fw-bold text-center"> Titik Koordinat :  </p>
                            @if ($data->titikLahans->count() > 0)
                                <ul>
                                    @foreach ($data->titikLahans as $titik)
                                        <li>[ {{ $titik->latitude }}, {{ $titik->longitude }} ]</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center">
                                    <p class="text-danger text-center">Titik koordinat belum ditentukan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card border-dark">
                        <div class="card-body">
                            <p class="my-3 fw-bold text-center"> Riwayat Kepemilikan  </p>
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
            </div>
        </div>
    </div>

    {{-- TTD --}}
    <div class="ttd">
        <p>Bangkalan, {{ now()->translatedFormat('d F Y') }}</p>

        <p>Penanggung Jawab</p>

        <br><br><br><br>

        <strong>{{ $data->petugas->name }}</strong>
    </div>

</body>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</html>