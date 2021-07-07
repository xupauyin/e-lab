@extends('laboran.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">
    @include('laboran.layouts.alert')
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">FORMULIR PEMINJAMAN LABORATORIUM</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('laboran.peminjamanlab.update', $peminjamanlab->peminjamanlab_id) }}">
                    @csrf
                    <div class="form-group row">
                        <label for="namapl" class="col-sm-2 col-form-label">Nama Peminjaman</label>
                        <div class="col-sm-10">
                            <input id="namapl" type="text" class="form-control" name="namapl" value="{{ $peminjamanlab->nama_pl }}" placeholder="Nama Peminjam">
                        
                            @error('namapl')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglreq" class="col-sm-2 col-form-label">Tanggal/Waktu Permintaan</label>
                        <div class="col input-group date">
                            <input type="text" class="form-control @error('tglreq') is-invalid @enderror datepicker1" name="tglreq" value="{{ explode(' ', $peminjamanlab->tgl_req)[0] }}" placeholder="Tanggal/Waktu Permintaan">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        
                            @error('tglreq')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col input-group bootstrap-timepicker timepicker">
                            <input type="text" name="jampinjam" class="form-control input-small @error('jampinjam') is-invalid @enderror timepickerx">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        
                            @error('jampinjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="unitpl" class="col-sm-2 col-form-label">NIM/Lembaga/Unit</label>
                        <div class="col-sm-10">
                            <input id="unitpl" type="text" class="form-control @error('unitpl') is-invalid @enderror" name="unitpl" value="{{ $peminjamanlab->unit_pl }}" placeholder="NIM/Lembaga/Unit">
                        
                            @error('unitpl')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namalab" class="col-sm-2 col-form-label">Nama Lab</label>
                        <div class="col-sm-10">
                            <input id="namalab" type="text" class="form-control @error('namalab') is-invalid @enderror" name="namalab" value="{{ $peminjamanlab->nama_lab }}" placeholder="Nama Lab">
                        
                            @error('namalab')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keppl" class="col-sm-2 col-form-label">Keperluan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('keppl') is-invalid @enderror" name="keppl" id="keppl" rows="4">{{ $peminjamanlab->keperluan_pl }}</textarea>
                        
                            @error('keppl')
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