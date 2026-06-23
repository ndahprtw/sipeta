<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon" class="rounded-circle">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon" class="rounded-circle">

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <title>Login Sistem</title>

    <style>
        body{
    background:#f4f6f9;
}

.branding-content{
    max-width:600px;
    padding:40px;
    color: white;
}

.branding-content h1{
    font-size:60px;
    font-weight:700;
}

.branding-content h4{
    margin-bottom:20px;
}

.branding-content p{
    font-size:18px;
    line-height:1.8;
}

.logo-brand{
    width:120px;
}

.feature-list{
    margin-top:30px;
}

.feature-list div{
    margin-bottom:10px;
    font-size:18px;
}

.login-section{
    display:flex;
    justify-content:center;
    align-items:center;
}

.wrapper{
    width:100%;
    max-width:420px;
    background:white;
    padding:30px;
    border-radius:20px;
}

.btn-login{
    width:100%;
    background:#198754;
    color:white;
}

.btn-login:hover{
    background:#157347;
    color:white;
}
    </style>
</head>
<body>

<div class="container-fluid vh-100">
    <div class="row h-100">

        <!-- Branding -->
        <div class="col-lg-7 d-none d-lg-flex branding-section"
     style="
        background:
        linear-gradient(
            rgba(0,0,0,.65),
            rgba(0,0,0,.65)
        ),
        url('{{ asset('assets/img/maps-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
     ">

            <div class="branding-content">

                <img src="{{ asset('assets/img/logo.png') }}"
                    class="logo-brand mb-4">

                <h1>SIPETA</h1>

                <h4>Sistem Informasi Pemetaan Tanah</h4>

                <p>
                    Platform digital untuk pengelolaan data lahan,
                    pemetaan lokasi tanah, monitoring kepemilikan,
                    dan visualisasi bidang tanah berbasis peta interaktif.
                </p>

                <div class="feature-list">

                    <div>
                        🗺️ Pemetaan Polygon Lahan
                    </div>

                    <div>
                        📍 Manajemen Titik Koordinat
                    </div>

                    <div>
                        👨‍🌾 Data Pemilik Tanah
                    </div>

                    <div>
                        📑 Riwayat Kepemilikan
                    </div>

                    <div>
                        📊 Monitoring Luas Lahan
                    </div>

                </div>

            </div>

        </div>

        <!-- Login -->
        <div class="col-lg-5 col-12 login-section">

            <div class="wrapper shadow">

                <div class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}">
                </div>

                <div class="text-center mt-3">
                    <h3>Login SIPETA</h3>
                    <small>
                        Login untuk mengelola data lahan
                    </small>
                </div>

                @if(session('wrong'))
                    <div class="alert alert-danger mt-3">
                        {{ session('wrong') }}
                    </div>
                @endif

                <form class="p-3 mt-3" method="POST" action="/login">
                    @csrf

                    <div class="form-field d-flex align-items-center">
                        <span class="far fa-user"></span>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email">
                    </div>

                    <div class="form-field d-flex align-items-center">
                        <span class="fas fa-key"></span>
                        <input
                            type="password"
                            name="password"
                            placeholder="Password">
                    </div>

                    <button
                        type="submit"
                        class="btn btn-login mt-3">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

</body>
</html>