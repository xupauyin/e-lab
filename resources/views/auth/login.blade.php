<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Laboratorium Teknologi Informasi</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

</head>

<body>
    <div class="card login container text-center shadow-lg py-5 px-5">
        <!-- Nested Row within Card Body -->
        <div class="text-center">
            <img src="{{ asset('img/stikom-sm.png') }}" alt="">
            <h4 class="h4 text-gray-900 mb-2 py-2">Selamat Datang!</h4>
            <h4 class="h4 text-gray-900 mb-3 py-3">E-LAB ITB STIKOM BALI</h4>
        </div>
        <form method="post" action="{{ route('login') }}" class="user">
            @csrf
            <div class="form-group">
                <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Masukkan email ">
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
            </div>
            @if(session()->has('failed'))
            <div class="alert alert-danger mb-5" role="alert">
                {{ session()->get('failed')}}
            </div>
            @endif
            <input type="submit" value="LOGIN" class="btn btn-primary btn-user btn-block">
        </form>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>