@extends('laboran.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">
        @include('laboran.layouts.alert')
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">FORM PEMINJAMAN ALAT</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('laboran.peminjamanalat.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="peminjam" class="col-sm-2 col-form-label">Nama Peminjam</label>
                        <div class="col-sm-10">
                            <input id="peminjam" type="text" class="form-control @error('peminjam') is-invalid @enderror" name="peminjam" value="{{ old('peminjam') }}" autocomplete="peminjam" autofocus>
                        
                            @error('peminjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lmbpeminjam" class="col-sm-2 col-form-label">NIM/Lembaga</label>
                        <div class="col-sm-10">
                            <input id="lmbpeminjam" type="text" class="form-control @error('lmbpeminjam') is-invalid @enderror" name="lmbpeminjam" value="{{ old('lmbpeminjam') }}" autocomplete="lmbpeminjam" autofocus>
                        
                            @error('lmbpeminjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namaalat" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('namaalat') is-invalid @enderror" name="namaalat" id="namaalat" value="{{ old('namaalat') }}" autocomplete="namaalat" autofocus>
                        
                            @error('namaalat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodealat" class="col-sm-2 col-form-label">Kode Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('kodealat') is-invalid @enderror" name="kodealat" id="kodealat" value="{{ old('kodealat') }}" autocomplete="kodealat" autofocus>
                    
                            @error('kodealat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" autocomplete="jumlah" autofocus>
                        
                            @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lama" class="col-sm-2 col-form-label">Lama Peminjaman</label>
                        <div class="col input-group date">
                            <input type="text" class="form-control @error('lama') is-invalid @enderror" name="lama" id="lama" value="{{ old('lama') }}" autocomplete="lama" autofocus>

                            @error('lama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col input-group date">
                            <select class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan">
                                <option value="Hari" selected>Hari</option>
                                <option value="Bulan">Bulan</option>
                                <option value="Semester">Semester</option>
                            </select>

                            @error('lama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="konpjm" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('konpjm') is-invalid @enderror" name="konpjm" id="konpjm">
                                <option value="Baik" selected>Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        
                            @error('konpjm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pengembali" class="col-sm-2 col-form-label">Nama Pengembali</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pengembali') is-invalid @enderror" name="pengembali" id="pengembali" value="{{ old('pengembali') }}" autocomplete="pengembali" autofocus readonly>
                        
                            @error('pengembali')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglkem" class="col-sm-2 col-form-label">Hari/Tanggal Kembali</label>
                        <div class="col-sm-10 input-group date">
                            <input type="text" class="form-control datepicker1 @error('tglkem') is-invalid @enderror" name="tglkem" value="{{ old('tglkem') }}" autocomplete="tglkem" autofocus readonly>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        
                            @error('tglkem')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="konblk" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('konblk') is-invalid @enderror" name="konblk" id="konblk" disabled>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        
                            @error('konblk')
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