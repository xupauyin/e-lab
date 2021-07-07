@extends('koordinator.layouts.main')

@section('page')
Grafik Laporan
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">@yield('page')</h1>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-12 mb-4">
            <!-- Content Column -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">GRAFIK PEMINJAMAN ALAT</h6>
                </div>
                <div class="card-body text-center">
                    <?php
                    $date_start = explode(' ', session('date_start'))[0];
                    $date_start = explode('-', $date_start);
                    $date_start = $date_start[2] . '-' . $date_start[1] . '-' . $date_start[0];

                    $date_end = explode(' ', session('date_end'))[0];
                    $date_end = explode('-', $date_end);
                    $date_end = $date_end[2] . '-' . $date_end[1] . '-' . $date_end[0];
                    ?>
                    <p>Tanggal {{ $date_start }} sampai {{ $date_end }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="canvas_peminjamanalat1" style="max-height:400px"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="canvas_peminjamanalat2" style="max-height:400px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @endsection