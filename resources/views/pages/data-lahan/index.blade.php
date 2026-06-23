@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Data Lahan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Data Lahan</li>
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
                        @if (auth()->user()->role == 'Petugas')
                            <div class="d-flex align-items-center justify-content-between m-3">
                                <p class="fw-bold">{{ $data->count() }} Data lahan belum diverifikasi</p>
                                <a href="{{ route('data-lahan.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-square"></i> Data Baru
                                </a>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Lahan</th>
                                        <th>Nama Lahan</th>
                                        <th>Pemilik</th>
                                        <th>Kategori</th>
                                        <th>Luas</th>
                                        <th>Status Lahan</th>
                                        @if (auth()->user()->role == 'Admin')
                                            <th>Status Verifikasi</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $item->kode_lahan }}</td>
                                            <td>{{ $item->nama_lahan }}</td>
                                            <td>{{ $item->pemilik->nama_pemilik }}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $item->kategori->warna }}; color: white;">
                                                    {{ $item->kategori->nama_kategori }}
                                                </span>
                                            </td>
                                            <td>{{ $item->luas ? $item->luas . ' m²' : '-' }}</td>
                                            <td>
                                                @if ($item->status_lahan == 'tersedia')
                                                    <p class="text-success">{{ $item->status_lahan }}</p>
                                                @elseif ($item->status_lahan == 'dalam proses')
                                                    <p class="text-primary">{{ $item->status_lahan }}</p>
                                                @elseif ($item->status_lahan == 'dijual')
                                                    <p class="text-secondary">{{ $item->status_lahan }}</p>
                                                @endif
                                            </td>
                                            @if (auth()->user()->role == 'Admin')
                                                <td>
                                                    @if ($item->status_verifikasi == 'menunggu')
                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasi-status-modal{{ $item->id }}">
                                                        verifikasi
                                                    </button>
                                                    <div class="modal fade" id="verifikasi-status-modal{{ $item->id }}" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ModalLabel">Verifikasi Lahan {{ $item->kode_lahan }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('data-lahan.update', $item->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div class="modal-body text-center">
                                                                        <input type="hidden" name="verifikasi" value="disetujui">
                                                                        Apakah Anda yakin ingin menyetujui data lahan <br> <strong>{{ $item->kode_lahan }}</strong>?
                                                                        <br><br>
                                                                        Data lahan yang telah disetujui akan ditampilkan pada peta publik SIPETA dan dapat dilihat oleh masyarakat.
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-success">Yakin</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                        <p class="text-success">selesai</p>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <a href="{{ route('data-lahan.show', $item->id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-folder-fill"></i>
                                                </a>

                                                @if (auth()->user()->role == 'Petugas')    
                                                    <a href="{{ route('data-lahan.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>

                                                    <!-- Modal Hapus data-->
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabitem="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Hapus Data</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus data dari <strong>{{ $item->kode_lahan }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('data-lahan.destroy', $item->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <a href="{{ route('riwayat-pemilik.show', $item->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>

                                                @if ($item->status_verifikasi == 'menunggu')
                                                    <button title="Laporan hanya dapat diunduh setelah data disetujui" class="btn btn-sm btn-secondary"><i class="bi bi-download"></i></button>
                                                @else
                                                    <a href="/unduh-data/{{ $item->id }}" target="_blank" class="btn btn-sm btn-danger"> <i class="bi bi-download"></i> </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
