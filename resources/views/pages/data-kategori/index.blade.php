@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Data Kategori Lahan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Data Kategori Lahan</li>
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
                                Total : {{ $data->count() }} data
                            </h5>
                            <!-- Modal Tambah data-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="bi bi-plus-square"></i> Data Baru
                            </button>
                            <div class="modal fade" id="addModal" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Tambah Data Kategori Lahan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('kategori-lahan.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="kategori">Kategori Lahan</label>
                                                    <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror shadow-none" placeholder="Masukkan kategori" value="{{ old('kategori') }}">
                                                    @error('kategori') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="warna">Warna</label>
                                                    <input type="text" name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror shadow-none" value="{{ old('warna') }}">
                                                    @error('warna') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror shadow-none" id="" cols="3" rows="2"> {{ old('deskripsi') }} </textarea>
                                                    @error('deskripsi') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Tambah -->
                        </div>

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kategori Lahan</th>
                                        <th>Warna</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $item->nama_kategori }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $item->warna }}; color: white;">
                                                {{ $item->warna }}
                                            </span>
                                        </td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            <!-- Modal Edit data-->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabitem="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                               <div class="modal-dialog">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="ModalLabel">Edit Data Kategori Lahan</h5>
                                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                       </div>
                                                       <form action="{{ route('kategori-lahan.update', $item->id) }}" method="POST">
                                                           @csrf
                                                           @method('put')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="kategori">Kategori Lahan</label>
                                                                    <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror shadow-none" placeholder="Masukkan kategori" value="{{ old('kategori', $item->nama_kategori) }}">
                                                                    @error('kategori') 
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div> 
                                                                    @enderror
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                    <label for="warna">Warna</label>
                                                                    <input type="text" name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror shadow-none" value="{{ old('warna', $item->warna) }}">
                                                                    @error('warna') 
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div> 
                                                                    @enderror
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                    <label for="deskripsi">Deskripsi</label>
                                                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror shadow-none" id="" cols="3" rows="2"> {{ old('deskripsi', $item->deskripsi) }} </textarea>
                                                                    @error('deskripsi') 
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div> 
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                   </div>
                                               </div>
                                           </div>
                                           <!-- End Modal Edit -->

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
                                                           Apakah Anda yakin ingin menghapus data dari <strong>{{ $item->nama_kategori }}</strong>?
                                                       </div>
                                                       <div class="modal-footer">
                                                           <form action="{{ route('kategori-lahan.destroy', $item->id) }}" method="POST">
                                                               @csrf
                                                               @method('DELETE')
                                                               <button type="submit" class="btn btn-danger">Hapus</button>
                                                           </form>
                                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <!-- End Modal Hapus -->
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
