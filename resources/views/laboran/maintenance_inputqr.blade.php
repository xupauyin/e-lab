@extends('laboran.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">
        @include('laboran.layouts.alert')
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">FORM PENGECEKAN KOMPUTER LABORATORIUM</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('laboran.maintenance.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="namakom" class="col-sm-2 col-form-label">Nama Komputer</label>
                        <div class="col-sm-10">
                            <input id="namakom" type="text" class="form-control @error('namakom') is-invalid @enderror" name="namakom" value="{{ $inventaris->nama_brg }}" autocomplete="namakom" autofocus>

                            @error('namakom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spekhard" class="col-sm-2 col-form-label">Spesifikasi Komputer Hardware</label>
                        <div class="col-sm-10">
                            <textarea id="spekhard" class="form-control @error('spekhard') is-invalid @enderror" name="spekhard" rows="4" value="{{ old('spekhard') }}" autocomplete="spekhard" autofocus></textarea>

                            @error('spekhard')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kondisihard" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('kondisihard') is-invalid @enderror" name="kondisihard" id="kondisihard">
                                <option value="-" selected>-</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>

                            @error('kondisihard')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="penhard" class="col-sm-2 col-form-label">Penanganan</label>
                        <div class="col-sm-10">
                            <textarea id="penhard" class="form-control @error('penhard') is-invalid @enderror" name="penhard" rows="4" value="{{ old('penhard') }}" autocomplete="penhard" autofocus></textarea>

                            @error('penhard')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="speksoft" class="col-sm-2 col-form-label">Spesifikasi Komputer Software</label>
                        <div class="col-sm-10">
                            <textarea id="speksoft" class="form-control @error('speksoft') is-invalid @enderror" name="speksoft" rows="4" value="{{ old('speksoft') }}" autocomplete="speksoft" autofocus></textarea>

                            @error('speksoft')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kondisisoft" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <select id="kondisisoft" class="form-control @error('kondisisoft') is-invalid @enderror" name="kondisisoft">
                                <option value="-" selected>-</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>

                            @error('kondisisoft')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pensoft" class="col-sm-2 col-form-label">Penanganan</label>
                        <div class="col-sm-10">
                            <textarea id="pensoft" class="form-control @error('pensoft') is-invalid @enderror" name="pensoft" rows="4" value="{{ old('pensoft') }}" autocomplete="pensoft" autofocus></textarea>

                            @error('pensoft')
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
@endsection