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
                        <div class="d-flex align-items-center justify-content-end m-3">
                            <a href="{{ route('data-lahan.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-square"></i> Data Baru
                            </a>
                        </div>

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
                                            <td>{{ $item->luas }} m<sup>2</sup></td>
                                            <td>{{ $item->status_lahan }} </td>
                                            <td>
                                                <a href="{{ route('data-lahan.show', $item->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-folder-fill"></i>
                                                </a>

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
