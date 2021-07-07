@extends('administrator.layouts.main')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">@yield('page')</h1>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
        @include('administrator.layouts.alert')
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">INPUT LABORATORIUM</h6>
                </div>
                <div class="card-body">
                
                    <form method="POST" action="{{ route('administrator.save_lab') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="labnama" class="col-sm-2 col-form-label">Nama Laboratorium</label>
                            <div class="col-md-10">
                                <input id="labnama" type="text" class="form-control @error('labnama') is-invalid @enderror" name="labnama" value="{{ old('labnama') }}"  autocomplete="labnama" autofocus>
                                
                                @error('labnama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>

                            <div class="col-md-10">
                                <select class="form-control @error('prodi') is-invalid @enderror" name="prodi" id="prodi">
                                    <option value="S1-Teknologi Informasi">S1-Teknologi Informasi</option>
                                    <option value="S1-Sistem Informasi">S1-Sistem Informasi</option>
                                    <option value="S1-Sistem Komputer">S1-Sistem Komputer</option>
                                    <option value="S1-Bisnis Digital">S1-Bisnis Digital</option>
                                    <option value="D3-Manajemen Informatika">D3-Manajemen Informatikas</option>
                                </select>

                                @error('laboratorium')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection