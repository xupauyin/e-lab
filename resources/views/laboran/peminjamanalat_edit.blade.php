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
                <form action="{{ route('laboran.peminjamanalat.update', $peminjamanalat->peminjamanalat_id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="peminjam" class="col-sm-2 col-form-label">Nama Peminjam</label>
                        <div class="col-sm-10">
                            <input id="peminjam" type="text" class="form-control @error('peminjam') is-invalid @enderror" name="peminjam" value="{{ $peminjamanalat->peminjam }}" autocomplete="peminjam" autofocus readonly>
                        
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
                            <input id="lmbpeminjam" type="text" class="form-control @error('lmbpeminjam') is-invalid @enderror" name="lmbpeminjam" value="{{ $peminjamanalat->lmb_peminjam }}" autocomplete="lmbpeminjam" autofocus readonly>
                        
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
                            <input id="namaalat" type="text" class="form-control @error('namaalat') is-invalid @enderror" name="namaalat" value="{{ $peminjamanalat->nama_alat }}" autocomplete="namaalat" autofocus readonly>
                        
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
                            <input id="kodealat" type="text" class="form-control @error('kodealat') is-invalid @enderror" name="kodealat" value="{{ $peminjamanalat->kode_alat }}" autocomplete="kodealat" autofocus readonly>
                        
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
                            <input id="jumlah" type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ $peminjamanalat->jumlah }}" autocomplete="jumlah" autofocus autocomplete="jumlah" autofocus readonly>
                        
                            @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lama" class="col-sm-2 col-form-label">Lama Peminjaman</label>
                        <div class="col-sm-10">
                            <input id="lama" type="text" class="form-control @error('lama') is-invalid @enderror" name="lama" value="{{ $peminjamanalat->lama }}" autocomplete="lama" autofocus readonly>
                        
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
                            <select class="form-control @error('konpjm') is-invalid @enderror" name="konpjm" id="konpjm" disabled>
                                <option value="Baik" @if($peminjamanalat->kondisi_pjm == 'Baik') selected @endif>Baik</option>
                                <option value="Rusak" @if($peminjamanalat->kondisi_pjm == 'Rusak') selected @endif>Rusak</option>
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
                            <input id="pengembali" type="text" class="form-control @error('pengembali') is-invalid @enderror" name="pengembali" value="{{ $peminjamanalat->pengembali }}" autocomplete="pengembali" autofocus>
                        
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
                            <input type="text" class="form-control datepicker1 @error('tglkem') is-invalid @enderror" name="tglkem" value="{{ $peminjamanalat->tgl_kembali}}" autocomplete="tglkem" autofocus>
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
                            <select class="form-control @error('konblk') is-invalid @enderror" name="konblk" id="konblk">
                                <option value="Baik" @if($peminjamanalat->kondisi_blk == 'Baik') selected @endif>Baik</option>
                                <option value="Rusak" @if($peminjamanalat->kondisi_blk == 'Rusak') selected @endif>Rusak</option>
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