@extends('koordinator.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">


        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">FORM PEMINJAMAN ALAT</h6>
            </div>
            <div class="card-body">
                @include('koordinator.layouts.alert')
                @csrf
                <div class="table-responsive">
                    <form action="{{ route('koordinator.peminjamanalat.index') }}" method="get">
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
                                <a href="{{ route('koordinator.peminjamanalat.index') }}" type="reset" class="btn btn-danger btn-small mx-2"><i class="fa fa-sync"></i> Reset</a>
                                @if($cari == '1')
                                <a href="{{ route('koordinator.peminjamanalat.grafik') }}" class="btn btn-primary btn-small mx-2"><i class="far fa-chart-bar"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th width="15%">Tanggal</th>
                                <th scope="col">Nama Peminjam</th>
                                <th scope="col">NIM/Lembaga</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Lama Peminjaman</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Nama Pengembali</th>
                                <th scope="col">Hari/Tanggal Kembali</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Verifikasi</th>
                                <th scope="col">Ajukan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamanalat as $i => $item)
                            <?php
                            $tgl = explode('-', explode(' ', $item->created_at)[0]);
                            $tgl = $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
                            $tgl_kembali = explode('-', explode(' ', $item->tgl_kembali)[0]);
                            $tgl_kembali = $tgl_kembali[2] . '-' . $tgl_kembali[1] . '-' . $tgl_kembali[0];
                            ?>
                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $tgl }}</td>
                                <td>{{ $item->peminjam }}</td>
                                <td>{{ $item->lmb_peminjam }}</td>
                                <td>{{ $item->nama_alat }}</td>
                                <td>{{ $item->kode_alat }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->lama }}</td>
                                <td>{{ $item->kondisi_pjm }}</td>
                                <td>{{ $item->pengembali }}</td>
                                <td>{{ $tgl_kembali }}</td>
                                <td>{{ $item->kondisi_blk }}</td>
                                <td> {{ $item->status_verifikasi}}</td>
                                <td>
                                    <!-- BELUM DIVERIFIKASI, MENUNGGU VERIFIKASI, SUDAH DIVERIFIKASI  -->
                                    <div class="form-check text-center">
                                        @if($item->status_verifikasi == 'MENUNGGU VERIFIKASI' && $item->deleted_at == NULL)
                                        <input class="form-check-input checkbox_verifikasi_peminjamanalat" type="checkbox" value="{{ $item->peminjamanalat_id }}">
                                        @else
                                        <input class="form-check-input checkbox_verifikasi_peminjamanalat" type="checkbox" value="{{ $item->peminjamanalat_id }}" disabled="true" checked>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->deleted_at == NULL ? 'Aktif' : 'Non-Aktif' }}</td>
                                <td>
                                    <div class="col-md-6">
                                        <a href="#" id="{{ $item->peminjamanalat_id }}" data-toggle="modal" data-target="#exampleModal" class="btn {{ $item->deleted_at != NULL ? 'btn-success' : 'btn-danger' }} btn-status-peminjamanalat">{{ $item->deleted_at != NULL ? 'Aktif' : 'Non-Aktif' }}</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right mb-4">
                        <button class="btn btn-primary btn-small" id="btn_verifikasi_peminjamanalat"><i class="fa fa-check"></i>&nbsp;&nbsp;Lakukan Verifikasi Data yang Dipilih</button>
                    </div>
                    @if($per_page != 0)
                    {{ $peminjamanalat->links() }}
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
                <button type="button" class="btn btn-danger btn-status-peminjamanalat-modal">Ubah</button>
            </div>
        </div>
    </div>
</div>
@endsection