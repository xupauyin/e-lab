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
                    <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR USER</h6>
                </div>
                <div class="card-body">

                    @include('administrator.layouts.alert')
                    @csrf

                    <div class="table-responsive">
                        <div class="float-right mb-2">
                            <a href="{{ route('administrator.new_user') }}" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Tambah User</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Nama Lab</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $i => $u)
                                <tr>
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ ucwords($u->role) }}</td>
                                    <td>{{ $u->laboratorium['nama_laboratorium'] }}
                                    <td>{{ $u->deleted_at == NULL ? 'Aktif' : 'Non-Aktif' }}</td>
                                    <td class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('administrator.edit_user', $u->id) }}" class="btn btn-primary btn-small @if($u->deleted_at != NULL) disabled @endif">Edit</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="#" id="{{ $u->id }}" data-toggle="modal" data-target="#exampleModal" class="btn {{ $u->deleted_at != NULL ? 'btn-success' : 'btn-danger' }} btn-status-user">{{ $u->deleted_at != NULL ? 'Aktif' : 'Non-Aktif' }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    Apakah anda ingin mengubah status user yang dipilih ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger btn-status-user-modal">Ubah</button>
                </div>
            </div>n
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection