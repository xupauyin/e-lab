@extends('laboran.layouts.main')

@section('content')

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-12 mb-4">

        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">GRAFIK PENGECEKAN KOMPUTER</h6>
            </div>
            <div class="card-body text-center">
                <?php 
                    $date_start = explode(' ', session('date_start'))[0];
                    $date_start = explode('-', $date_start);
                    $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

                    $date_end = explode(' ', session('date_end'))[0];
                    $date_end = explode('-', $date_end);
                    $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];
                ?>
                <p>Tanggal {{ $date_start }} sampai {{ $date_end }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="canvas_maintenance1" style="max-height:400px"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="canvas_maintenance2" style="max-height:400px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection