@extends('administrator.layouts.main')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR LABORATORIUM</h6>
                </div>
                <div class="card-body">

                    @include('administrator.layouts.alert')
                    @csrf

                    <div class="table-responsive">
                        <div class="float-right mb-2">
                            <a href="{{ route('administrator.new_lab') }}" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Tambah Lab</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Lab</th>
                                    <th scope="col">Prodi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lab as $i => $l)
                                <tr>
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $l->nama_laboratorium }}</td>
                                    <td>{{ $l->prodi }}</td>
                                    <td>{{ $l->deleted_at == NULL ? 'Aktif' : 'Non-Aktif' }}</td>
                                    <td class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('administrator.edit_lab', $l->laboratorium_id) }}" class="btn btn-primary btn-small @if($l->deleted_at != NULL) disabled @endif">Edit</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="" id="{{ $l->laboratorium_id }}" data-toggle="modal" data-target="#exampleModal" data-target="#exampleModal" class="btn {{ $l->deleted_at != NULL ? 'btn-success' : 'btn-danger' }} btn-status-lab">{{ $l->deleted_at != NULL ? 'Aktif' : 'Non-Aktif' }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $lab->links() }}
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
                    Apakah anda ingin mengubah status lab yang dipilih ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger btn-status-lab-modal">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection