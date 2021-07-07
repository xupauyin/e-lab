<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        table {
            width: 100%;
        }

        .header,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-family: Arial;
        }

        .text-center {
            text-align: center;
        }

        .text-heading {
            font-size: 20px;
            font-weight: bold;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-header-small {
            font-size: 14px;
            line-height: 20px;
        }

        .mt-1 {
            padding-top: 2px;
        }

        .mb-1 {
            padding-bottom: 2px;
        }

        .my-1 {
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .mx-1 {
            padding-left: 2px;
            padding-right: 2px;
        }

        .no-border {
            border: none !important;
        }

        .sign-padding {
            line-height: 20px;
        }

        .img-logo {
            max-width: 120px;
            width: 120px;
        }

        .table-small {
            width: 40% !important;
        }

        .remove-border-right {
            border-right: 0px hidden black;
        }

        .remove-border-bottom {
            border-bottom-style: hidden;
        }
        
        table {
        border-left: 1px solid #000;
        border-right: 0;
        border-top: 1px solid #000;
        border-bottom: 0;
        border-collapse: collapse;
    }

    table td,
    table th {
        border-left: 0;
        border-right: 1px solid #000;
        border-top: 0;
        border-bottom: 1px solid #000;
    }
    </style>
</head>

<body>
    <table class="header my-1">
        <tr>
            <td class="text-center" rowspan="4" width="15%"><img class="img-logo" src="{{ asset('img/logo-form.png') }}" alt=""></td>
            <td class="text-center my-1" rowspan="2" width="70%"><span class="text-bold">INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI</span><br><span class="text-header-small">Jl. Raya Puputan Renon No. 86 Renon, Denpasar<br>Telp. (0361) 244445 Fax (0361) 265773</span></td>
            <td class="text-header-small mx-1 remove-border-right" width="12%">No. Dok</td>
            <td class="text-header-small mx-1" width="25%">: FM/06/10/DFI <br>&nbsp; &K/ITBSTIKOM</td>
        </tr>
        <tr class="text-left my-1">
            <td class="text-header-small mx-1 remove-border-right">No. Revisi</td>
            <td class="text-header-small mx-1">: 03</td>
        </tr>
        <tr>
            <td class="text-center text-heading" rowspan="2">FORMULIR PEMINJAMAN ALAT</td>
            <td class="text-header-small mx-1 remove-border-right">Tgl.<br>Berlaku</td>
            <td class="text-header-small mx-1 ">: 04 Oktober 2019</td>
        </tr>
        <tr>
            <td class="text-header-small mx-1 remove-border-right">Halaman</td>
            <td class="text-header-small mx-1">: 1 dari 1</td>
        </tr>
    </table>
    <br>
    <table class="no-border table-small">
        <tr>
            <td class="no-border" style="width:20%;">Hari/Tanggal</td>
            <td class="no-border" >:</td>
            <td class="no-border" style="width:50%">{{$peminjamanalat[0]->hari}}/{{ \Carbon\Carbon::now()->locale('id_ID')->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="no-border">Nama Peminjam</td>
            <td class="no-border">:</td>
            <td class="no-border">{{ $peminjamanalat->first()->peminjam }}</td>
        </tr>
        <tr>
            <td class="no-border">NIM/Lembaga</td>
            <td class="no-border">:</td>
            <td class="no-border">{{ $peminjamanalat->first()->lmb_peminjam }}</td>
        </tr>
    </table>
    <br>
    <table class="header text-center">
        <tr>
            <td rowspan="2" width="5%"><strong>No</strong></td>
            <td rowspan="2" width="15%"><strong>Nama Barang</strong></td>
            <td rowspan="2" width="20%"><strong>Kode Barang</strong></td>
            <td rowspan="2" width="10%"><strong>Jumlah</strong></td>
            <td rowspan="2" width="15%"><strong>Lama Peminjaman</strong></td>
            <td colspan="2"><strong>Kondisi</strong></td>
            <td rowspan="2" width="15%"><strong>TTD Peminjam</strong></td>
        </tr>
        <tr>
            <td width="10%">Baik</td>
            <td width="10%">Rusak</td>
        </tr>
        @foreach($peminjamanalat->all() as $i)
            <tr>
                <td>{{ $n++ }}</td>
                <td>{{ $i->nama_alat }}</td>
                <td>{{ $i->kode_alat }}</td>
                <td>{{ $i->jumlah }}</td>
                <td>{{ $i->lama }}</td>
                <td>@if($i->kondisi_pjm == 'Baik') {{ 'V' }} @endif</td>
                <td>@if($i->kondisi_pjm == 'Rusak') {{ 'V' }} @endif</td>
                <td></td>
            </tr>
        @endforeach
    </table>
    <br>
    <table class="header text-center">
        <tr>
            <td rowspan="2" width="20%"><strong>Nama Pengembali</strong></td>
            <td rowspan="2" width="25%"><strong>Hari/Tanggal Kembali</strong></td>
            <td colspan="2"><strong>Kondisi</strong></td>
            <td rowspan="2" width="15%"><strong>TTD Pengembalian</strong></td>
        </tr>
        <tr>
            <td width="10%">Baik</td>
            <td width="10%">Rusak</td>
        </tr>
        @foreach($peminjamanalat->all() as $i)
        <tr>
            <td>{{ $i->pengembali }}</td>
            <td>{{ $i->tgl_kembali }}</td>
            <td>@if($i->kondisi_blk == 'Baik') {{ 'V' }} @endif</td>
            <td>@if($i->kondisi_blk == 'Rusak') {{ 'V' }} @endif</td>
            <td></td>
        </tr>
        @endforeach
    </table>
    <br>
    <table class="no-border">
        <tr>
            <td colspan="3" class="no-border" width="43%">Denpasar, {{ date('d F Y')}}</td>
        </tr>
        <tr>
            <td class="no-border" width="43%">Dilaporkan Oleh,</td>
            <td class="no-border" width="43%">Mengetahui,</td>
            <td class="no-border" width="43%">Menyetujui,</td>
        </tr>
        <tr>
            <td class="no-border">Laboran</td>
            <td class="no-border">Koordinator Lab</td>
            <td class="no-border">Ka. Program Studi</td>
        </tr>
        <tr>
            <td class="no-border">@if($ttd_laboran != '')
                <img src="{{ $ttd_laboran }}" style="max-width:180px;padding-top:8px;">
                @endif
            </td>
            <td class="no-border">@if($ttd_koordinator != '')
                <img src="{{ $ttd_koordinator }}" style="max-width:180px;padding-top:8px;">
                @endif
            </td>
            <td class="no-border">@if($ttd_kaprodi != '')
                <img src="{{ $ttd_kaprodi }}" style="max-width:180px;padding-top:8px;">
                @endif
            </td>
        </tr>
        <tr class="sign-padding">
            <td class="no-border">({{ isset($nama_laboran) && $nama_laboran != '' ? $nama_laboran : '' }})</td>
            <td class="no-border">({{ isset($nama_koordinator) && $nama_koordinator != '' ? $nama_koordinator : '' }})</td>
            <td class="no-border">({{ isset($nama_kaprodi) && $nama_kaprodi != '' ? $nama_kaprodi : '' }})</td>
        </tr>
    </table>
</body>

</html>