@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Data Karyawan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Data Karyawan</li>
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
                        <div class="d-flex align-items-center justify-content-between m-3">
                            <h5 class="card-title">
                                Total : 
                                {{-- {{ $data->where('role', 'Super Admin')->count() }}  Super Admin |  --}}
                                {{ $data->where('role', 'Admin')->count() }}  Admin | 
                                {{ $data->where('role', 'Petugas')->count() }}  Petugas
                            </h5>
                            <a href="{{ route('data-staff.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-square"></i> Data Baru
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>No Telepon</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Profile</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            <u>
                                                <i class="bi bi-whatsapp"></i> <a href="https://wa.me/{{ $data->no_telepon }}" target="_blank">{{ $data->no_telepon }}</a>
                                            </u>
                                        </td>
                                        <td>{{ $data->email }}</td>
                                        <td>
                                            @if($data->role == 'Admin')
                                                <span class="badge rounded-pill bg-primary">{{ $data->role }}</span>
                                            @elseif($data->role == 'Petugas')
                                                <span class="badge rounded-pill bg-warning">{{ $data->role }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->profile)
                                                <img src="{{ asset('assets/img/profile/' . $data->profile) }}" alt="profile" width="50">
                                            @else
                                                Tidak Ada Profile
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('data-staff.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                     <!-- Modal Hapus data staff-->
                                     <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}">Hapus Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus data dari <strong>{{ $data->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('data-staff.destroy', $data->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Hapus Perusahaan -->
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
