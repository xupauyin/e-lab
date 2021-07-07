@extends('laboran.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">
        @include('laboran.layouts.alert')
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">JURNAL PERSONAL LABORAN</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('laboran.jurnal.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="uraian" class="col-sm-2 col-form-label">Uraian Kegiatan</label>
                        <div class="col-sm-10">
                            <textarea id="uraian" class="form-control @error('uraian') is-invalid @enderror" name="uraian" rows="4" value="{{ old('uraian') }}" autocomplete="uraian" autofocus></textarea>

                            @error('uraian')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="waktujurnal" class="col-sm-2 col-form-label">Waktu</label>
                        <div class="col-sm-10 input-group date">
                            <input type="text" class="form-control input-small timepickerx @error('waktujurnal') is-invalid @enderror" name="waktujurnal">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                            @error('waktujurnal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="catatan" class="col-sm-2 col-form-label">Catatan Pihak Terkait</label>
                        <div class="col-sm-10">
                            <textarea id="catatan" class="form-control @error('catatan') is-invalid @enderror" name="catatan" rows="5" value="{{ old('catatan') }}" autocomplete="catatan" autofocus></textarea>

                            @error('catatan')
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