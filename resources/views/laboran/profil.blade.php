@extends('laboran.layouts.main')

@section('page')
Profil
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">@yield('page')</h1>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">PROFIL LABORAN</h6>
                </div>
                <div class="card-body">

                    @include('laboran.layouts.alert')

                    <form action="{{ route('laboran.profil.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-md-10">
                                <input id="nama" type="text" class="form-control" name="name" value="{{ $profil->name }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="barang" class="col-sm-2 col-form-label">E-Mail</label>
                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $profil->email }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password*</label>
                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="konfirmasi_password" class="col-sm-2 col-form-label">Konfirmasi Password*</label>
                            <div class="col-md-10">
                                <input id="konfirmasi_password" type="password" class="form-control" name="password_confirmation" value="{{ old('konfirmasi_password') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanda_tangan" class="col-sm-2 col-form-label">Tanda Tangan</label>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas></canvas>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" onclick="save_sign()" class="btn btn-primary btn-block">Simpan</button>
                                        <button type="button" onclick="clear_sign()" class="btn btn-danger btn-block">Reset tanda tangan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        <input type="hidden" name="sign" id="sign" value="{{ $profil->sign }}">

                        <div class="form-group row">
                            <div class="col-md-10">
                                <p class="text-danger">*Isi hanya apabila ingin mengganti password</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection