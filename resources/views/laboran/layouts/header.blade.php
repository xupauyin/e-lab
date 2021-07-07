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
    <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('public/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.min.css') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('laboran.home') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/stikom-sm.png') }}" alt="" style="width: 65px;">
                </div>
                <h7> E-LAB <br>STIKOM BALI</h7>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pencatatan
            </div>

            <!-- Nav Item - Pages Pencatatan Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('laboran.maintenance.index') }}">
                    <span>Maintenance Komputer</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('laboran.inventaris.index') }}">
                    <span>Inventaris Laboratorium</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('laboran.jurnal.index') }}">
                    <span>Jurnal Personal Laboran</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('laboran.peminjamanalat.index') }}">
                    <span>Peminjaman Alat</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('laboran.peminjamanlab.index') }}">
                    <span>Peminjaman Laboratorium</span></a>
            </li>

        </ul>