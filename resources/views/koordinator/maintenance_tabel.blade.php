@extends('koordinator.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">


        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">FORM PENGECEKAN KOMPUTER LABORATORIUM</h6>
            </div>
            <div class="card-body">
                @include('koordinator.layouts.alert')
                @csrf
                <div class="table-responsive">
                    <form action="{{ route('koordinator.maintenance.index') }}" method="get">
                        <div class="row justify-content-center">
                            <div class="input-group date col-md-9 text-center">
                                <label for="">Filter Periode : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group date col-md-2 my-2">
                                <input type="text" name="date_start" value="{{ $date_start }}" class="form-control datepicker-start" data-date-end-date="0d" placeholder="Tanggal Mulai" readonly required>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>

                            <div class="input-group date col-md-2 my-2">
                                <input type="text" name="date_end" value="{{ $date_end }}" class="form-control datepicker-end" data-date-end-date="0d" placeholder="Tanggal Akhir" readonly required>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>

                            <div class="input-group date col-md-4 my-2">
                                <button type="submit" class="btn btn-primary btn-small" name="cari"><i class="fa fa-search"></i> Cari </button>
                                <a href="{{ route('koordinator.maintenance.index') }}" type="reset" class="btn btn-danger btn-small mx-2"><i class="fa fa-sync"></i> Reset</a>
                                @if($cari == '1')
                                <a href="{{ route('koordinator.maintenance.grafik') }}" class="btn btn-primary btn-small mx-2"><i class="far fa-chart-bar"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Nama PC</th>
                                <th width="15%">Spesifikasi H/W</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Penanganan</th>
                                <th width="15%">Spesifikasi S/W</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Penanganan</th>
                                <th scope="col">Verifikasi</th>
                                <th scope="col">Ajukan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenance as $i => $item)
                            <?php 
                                $tgl = explode('-', explode(' ', $item->created_at)[0]);
                                $tgl = $tgl[2].'-'.$tgl[1].'-'. $tgl[0];
                            ?>
                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $tgl }}</td>
                                <td>{{ $item->nama_kom }}</td>
                                <td>{{ $item->spesifikasi_hard }}</td>
                                <td>{{ $item->kondisi_hard }}</td>
                                <td>{{ $item->penanganan_hard }}</td>
                                <td>{{ $item->spesifikasi_soft }}</td>
                                <td>{{ $item->kondisi_soft }}</td>
                                <td>{{ $item->penanganan_soft }}</td>
                                <td>{{ $item->status_verifikasi }}</td>
                                <td>
                                    <!-- BELUM DIVERIFIKASI, MENUNGGU VERIFIKASI, SUDAH DIVERIFIKASI  -->
                                    <div class="form-check text-center">
                                        @if($item->status_verifikasi == 'MENUNGGU VERIFIKASI' && $item->deleted_at == NULL)
                                        <input class="form-check-input checkbox_verifikasi_maintenance" type="checkbox" value="{{ $item->maintenance_id }}">
                                        @else
                                        <input class="form-check-input checkbox_verifikasi_maintenance" type="checkbox" value="{{ $item->maintenance_id }}" disabled="true" checked>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->deleted_at == NULL ? 'Aktif' : 'Non-Aktif' }}</td>
                                <td>
                                    <div class="col-md-6">
                                        <a href="#" id="{{ $item->maintenance_id }}" data-toggle="modal" data-target="#exampleModal" class="btn {{ $item->deleted_at != NULL ? 'btn-success' : 'btn-danger' }} btn-status-maintenance">{{ $item->deleted_at != NULL ? 'Aktif' : 'Non-Aktif' }}</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right mb-4">
                        <button class="btn btn-primary btn-small" id="btn_verifikasi_maintenance"><i class="fa fa-check"></i>&nbsp;&nbsp;Lakukan Verifikasi Data yang Dipilih</button>
                    </div>
                    @if($per_page != 0)
                    {{ $maintenance->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda ingin mengubah status data yang dipilih ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger btn-status-maintenance-modal">Ubah</button>
            </div>
        </div>
    </div>
</div>
@endsection