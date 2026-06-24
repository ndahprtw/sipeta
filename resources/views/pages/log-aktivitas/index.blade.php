@extends('layouts.main')

@section('content')
    <div class="pagetitle">
    <h1>Log Activitas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Log Activitas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">

                        <form action="" method="GET" class="row text-end mb-3">
                            <div class="col-md-6">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6">
                                <a href="/log-aktivitas" class="btn btn-secondary"> Reset </a>
                            </div>
                        </form>

                        @if ($data->count() > 0)
                            <div class="table-responsive">
                                <table class="table" id="pegawai">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Log Aktivitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->created_at->format('H:i') }}</td>
                                            <td>{{ $item->aktivitas }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-danger text-center my-5">Belum ada aktivitas yang dilakukan.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
