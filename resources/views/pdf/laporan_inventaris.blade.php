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
            font-size: 22px;
            font-weight: bold;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-header-small {
            font-size: 14px;
            line-height: 22px;
        }

        .mt-1 {
            padding-top: 4px;
        }

        .mb-1 {
            padding-bottom: 4px;
        }

        .my-1 {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .mx-1 {
            padding-left: 4px;
            padding-right: 4px;
        }

        .no-border {
            border: none !important;
        }

        .sign-padding {
            line-height: 120px;
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
            <td class="text-center my-1" rowspan="2" width="60%"><span class="text-bold">INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI</span><br><span class="text-header-small">Jl. Raya Puputan Renon No. 86 Renon, Denpasar<br>Telp. (0361) 244445 Fax (0361) 265773</span></td>
            <td class="text-header-small mx-1 remove-border-right" width="15%">No. Dokumen</td>
            <td class="text-header-small mx-1" width="25%">: FM/03/10/DFI&K/ITBSTIKOM</td>
        </tr>
        <tr class="text-left my-1">
            <td class="text-header-small mx-1 remove-border-right">No. Revisi</td>
            <td class="text-header-small mx-1">: 07</td>
        </tr>
        <tr>
            <td class="text-center text-heading" rowspan="2">DAFTAR INVENTARIS LABORATORIUM</td>
            <td class="text-header-small mx-1 remove-border-right">Tgl. Berlaku</td>
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
            <td class="no-border" style="width:200%;">Periode Pengecekan Inventaris</td>
            <td class="no-border">:</td>
            <td class="no-border" style="width:180%;">.................................</td>
        </tr>
        <tr>
            <td class="no-border">Nama Laboratorium</td>
            <td class="no-border">:</td>
            <td class="no-border">{{ $nama_laboratorium }}</td>
        </tr>
    </table>
    <br>
    <table class="header text-center">
        <tr>
            <td rowspan="2" width="5%"><strong>No</strong></td>
            <td rowspan="2" width="10%"><strong>Kode Sarpras</strong></td>
            <td rowspan="2" width="20%"><strong>Kode Barang</strong></td>
            <td rowspan="2" width="15%"><strong>Nama Barang</strong></td>
            <td rowspan="2" width="20%"><strong>Spesifikasi</strong></td>
            <td rowspan="2" width="10%"><strong>Tahun Pembelian</strong></td>
            <td colspan="3"><strong>Kondisi</strong></td>
            <td rowspan="2" width="20%"><strong>Keterangan Perbaikan</strong></td>
        </tr>
        <tr>
            <td width="10%">Baik</td>
            <td width="10%">Rusak</td>
            <td width="15%">Perlu Perbaikan</td>
        </tr>
        @foreach($inventaris as $i)
        <tr>
            <td>{{ $n++ }}</td>
            <td>{{ $i->kode_sarpras }}</td>
            <td>{{ $i->kode_brg }}</td>
            <td>{{ $i->nama_brg }}</td>
            <td>{{ $i->spesifikasi_brg }}</td>
            <td>{{ $i->tahun_beli }}</td>
            <td>@if($i->kondisi_brg == 'Baik') {{ 'V' }} @endif</td>
            <td>@if($i->kondisi_brg == 'Rusak') {{ 'V' }} @endif</td>
            <td>@if($i->kondisi_brg == 'Perlu Perbaikan') {{ 'V' }} @endif</td>
            <td>{{ $i->keterangan }}</td>
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
            <td class="no-border">Koordinator Laboratorium</td>
            <td class="no-border">Ka. Program Studi</td>
            <td class="no-border">Dekan Fakultas Informatika & Komputer</td>
        </tr>
        <tr>
            <td class="no-border"></td>
            <td class="no-border"></td>
            <td class="no-border"></td>
        </tr>
        <tr class="sign-padding">
            <td class="no-border">(............................................)</td>
            <td class="no-border">(............................................)</td>
            <td class="no-border">(............................................)</td>
        </tr>
    </table>
</body>

</html>