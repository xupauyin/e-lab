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
            <td class="text-center my-1" rowspan="2" width="70%"><span class="text-bold">INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI</span><br><span class="text-header-small">Jl. Raya Puputan Renon No. 86 Renon, Denpasar<br>Telp. (0361) 244445 Fax (0361) 265773</span></td>
            <td class="text-header-small mx-1 remove-border-right" width="12%">No. Dok</td>
            <td class="text-header-small mx-1" width="25%">: FM/05/10/DFI <br> &K/ITBSTIKOM</td>
        </tr>
        <tr class="text-left my-1">
            <td class="text-header-small mx-1 remove-border-right">No. Revisi</td>
            <td class="text-header-small mx-1">: 02</td>
        </tr>
        <tr>
            <td class="text-center text-heading" rowspan="2">FORMULIR PEMINJAMAN LABORATORIUM</td>
            <td class="text-header-small mx-1 remove-border-right">Tgl.<br>Berlaku</td>
            <td class="text-header-small mx-1 ">: 04 Oktober 2019</td>
        </tr>
        <tr>
            <td class="text-header-small mx-1 remove-border-right">Halaman</td>
            <td class="text-header-small mx-1">: 1 dari 1</td>
        </tr>
    </table>
    <br>
    <table class="header text-center">
        <tr>
            <td width="5%"><strong>No</strong></td>
            <td width="15%"><strong>Nama Peminjam</strong></td>
            <td width="20%"><strong>NIM/Lembaga/Unit</strong></td>
            <td width="20%"><strong>Tanggal/Waktu Permintaan</strong></td>
            <td width="15%"><strong>Nama Lab</strong></td>
            <td width="15%"><strong>Keperluan</strong></td>
        </tr>
        @foreach($peminjamanlab as $i)
        <tr>
            <td>{{ $n++ }}</td>
            <td>{{ $i->nama_pl }}</td>
            <td>{{ $i->unit_pl }}</td>
            <td>{{ $i->tgl_req }}</td>
            <td>{{ $i->nama_lab}}</td>
            <td>{{ $i->keperluan_pl }}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table class="no-border">
        <tr>
            <td colspan="3" class="no-border" width="43%">Denpasar, {{date('d F Y')}}</td>
        </tr>
        <tr>
            <td class="no-border" width="43%">Dipinjam Oleh,</td>
            <td class="no-border" width="43%">Mengetahui,</td>
            <td class="no-border" width="43%">Menyetujui,</td>
        </tr>
        <tr>
            <td class="no-border"></td>
            <td class="no-border">Koordinator Lab</td>
            <td class="no-border">Ka. Program Studi</td>
        </tr>
        <tr>
            <td class="no-border"></td>
            <td class="no-border"></td>
            <td class="no-border"></td>
        </tr>
        <tr class="sign-padding">
            <td class="no-border">(.....................................................)</td>
            <td class="no-border">(.....................................................)</td>
            <td class="no-border">(.....................................................)</td>
        </tr>
    </table>
</body>

</html>