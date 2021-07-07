@extends('laboran.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">
        @include('laboran.layouts.alert')
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR INVENTARIS LABORATORIUM</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('laboran.inventaris.update', $inventaris->inventaris_id) }}">
                    @csrf
                    <div class="form-group row">
                        <label for="sarpras" class="col-sm-2 col-form-label">Kode Sarpras</label>
                        <div class="col-sm-10">
                            <input id="sarpras" type="text" class="form-control  @error('sarpras') is-invalid @enderror" name="sarpras" value="{{ $inventaris->kode_sarpras }}" autocomplete="sarpras" autofocus>

                            @error('sarpras')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="barang" class="col-sm-2 col-form-label">Kode Barang</label>
                        <div class="col-sm-10">
                            <input id="barang" type="text" class="form-control @error('barang') is-invalid @enderror" name="barang" value="{{ $inventaris->kode_brg }}" autocomplete="barang" autofocus>

                            @error('barang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $inventaris->nama_brg }}" autocomplete="nama" autofocus>

                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spesifikasi" class="col-sm-2 col-form-label">Spesifikasi</label>
                        <div class="col-sm-10">
                            <textarea id="spesifikasi" class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" rows="4" autocomplete="spesifikasi" autofocus>{{ $inventaris->spesifikasi_brg }}</textarea>
                        
                            @error('spesifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun Pembelian</label>
                        <div class="col-sm-10">
                            <input id="tahun" type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ $inventaris->tahun_beli }}" autocomplete="tahun" autofocus>
                        
                            @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kondisi" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" id="kondisi">
                                <option value="Baik" @if($inventaris->kondisi_brg == 'Baik') selected @endif>Baik</option>
                                <option value="Rusak" @if($inventaris->kondisi_brg == 'Rusak') selected @endif>Rusak</option>
                                <option value="Perlu Perbaikan" @if($inventaris->kondisi_brg == 'Perlu Perbaikan') selected @endif>Perlu Perbaikan</option>
                            </select>

                            @error('kondisi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="5" autocomplete="keterangan" autofocus>{{ $inventaris->keterangan }}</textarea>
                        
                            @error('keterangan')
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