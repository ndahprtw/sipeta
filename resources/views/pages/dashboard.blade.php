@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <h2 class="fw-bold text-primary mb-1"> Selamat Datang 👋 </h2>
                            <p class="text-muted mb-4"> SIPETA - Sistem Informasi Pemetaan Tanah </p>
                            @if (auth()->user()->profile != null) 
                                <img src="{{ asset('assets/img/profile/' . auth()->user()->profile) }}" alt="profile image" class="rounded-circle border border-3 shadow-sm mb-3" width="140" height="140" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/img/profile/default-profile.jpeg') }}" alt="profile image" class="rounded-circle border border-3 shadow-sm mb-3" width="140" height="140" style="object-fit: cover;">
                            @endif
                            <h4 class="fw-bold mb-1"> {{ auth()->user()->name }} </h4>
                            <span class="badge bg-primary px-3 py-2"> {{ auth()->user()->role }} </span>
                            <hr class="my-4">
                            <p class="text-muted mb-0"> Kelola data lahan, pemilik, titik koordinat, dan informasi pemetaan tanah secara terintegrasi melalui SIPETA. </p>
                            <a href="/maps">Preview Pemetaan Tanah</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Petugas</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="ps-3"> <h6>{{ $total_petugas }}</h6> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pemilik</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="ps-3"> <h6>{{ $total_pemilik }}</h6> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Lahan</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-database-fill"></i>
                                </div>
                                <div class="ps-3"> <h6>{{ $total_lahan }}</h6> </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">

            <div class="col-md-8">
                <div class="row">
                    {{-- kategori lahan --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">Kategori Lahan</h5>
        
                            <!-- Bar Chart -->
                            <canvas id="barChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#barChart'), {
                                    type: 'bar',
                                    data: {
                                    labels: @json($kategoriLabel),
                                    datasets: [{
                                        label: 'Bar Chart',
                                        data: @json($kategoriData),
                                        backgroundColor: @json($kategoriWarna),
                                        borderColor: @json($kategoriWarna),
                                        borderWidth: 1
                                    }]
                                    },
                                    options: {
                                    scales: {
                                        y: {
                                        beginAtZero: true
                                        }
                                    }
                                    }
                                });
                                });
                            </script>
                            <!-- End Bar CHart -->
        
                            </div>
                        </div>
                    </div>
        
                    {{-- status lahan --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">Status Lahan</h5>
        
                            <!-- Pie Chart -->
                            <canvas id="pieChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#pieChart'), {
                                    type: 'pie',
                                    data: {
                                    labels: @json($statusLahanLabel),
                                    datasets: [{
                                        label: 'Total',
                                        data: @json($statusLahanData),
                                        backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)'
                                        ],
                                        hoverOffset: 4
                                    }]
                                    }
                                });
                                });
                            </script>
                            <!-- End Pie CHart -->
        
                            </div>
                        </div>
                    </div>
        
                    {{-- status verifikasi --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">Status Verifikasi</h5>
        
                            <!-- Doughnut Chart -->
                            <canvas id="doughnutChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#doughnutChart'), {
                                    type: 'doughnut',
                                    data: {
                                    labels: @json($statusVerifikasiLabel),
                                    datasets: [{
                                        label: 'Total',
                                        data: @json($statusVerifikasiData),
                                        backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)'
                                        ],
                                        hoverOffset: 4
                                    }]
                                    }
                                });
                                });
                            </script>
                            <!-- End Doughnut CHart -->
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                    <h5 class="card-title">Aktivitas Terbaru <span>| {{ now()->format('Y-m-d') }}</span></h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                            <div class="activite-label">32 min</div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                            </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                            <div class="activite-label">56 min</div>
                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                            <div class="activity-content">
                                Voluptatem blanditiis blanditiis eveniet
                            </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                            <div class="activite-label">2 hrs</div>
                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                            <div class="activity-content">
                                Voluptates corrupti molestias voluptatem
                            </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                            <div class="activite-label">1 day</div>
                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                            <div class="activity-content">
                                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                            </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                            <div class="activite-label">2 days</div>
                            <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                            <div class="activity-content">
                                Est sit eum reiciendis exercitationem
                            </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                            <div class="activite-label">4 weeks</div>
                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                            <div class="activity-content">
                                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                            </div>
                            </div><!-- End activity item-->

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
