<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Model\Inventaris;
use App\Model\Jurnal;
use App\Model\Maintenance;
use App\Model\PeminjamanAlat;
use App\Model\PeminjamanLab;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function verifikasi_inventaris(Request $request)
    {
        foreach ($request->id as $id) {
            Inventaris::where('inventaris_id', $id)->update(['status_verifikasi' => 'MENUNGGU VERIFIKASI']);
        }

        userlog('SUCCESS', 'Ajukan verifikasi invetaris berhasil !');

        return response()->json(['status' => 'ok']);
    }
    
    public function verifikasi_jurnal(Request $request)
    {
        foreach ($request->id as $id) {
            Jurnal::where('jurnal_id', $id)->update(['status_verifikasi' => 'MENUNGGU VERIFIKASI']);
        }

        userlog('SUCCESS', 'Ajukan verifikasi jurnal berhasil !');

        return response()->json(['status' => 'ok']);
    }

    public function verifikasi_maintenance(Request $request)
    {
        foreach ($request->id as $id) {
            Maintenance::where('maintenance_id', $id)->update(['status_verifikasi' => 'MENUNGGU VERIFIKASI']);
        }

        userlog('SUCCESS', 'Ajukan verifikasi maintenance berhasil !');

        return response()->json(['status' => 'ok']);
    }

    public function verifikasi_peminjamanalat(Request $request)
    {
        foreach ($request->id as $id) {
            PeminjamanAlat::where('peminjamanalat_id', $id)->update(['status_verifikasi' => 'MENUNGGU VERIFIKASI']);
        }

        userlog('SUCCESS', 'Ajukan verifikasi peminjaman alat berhasil !');

        return response()->json(['status' => 'ok']);
    }

    public function verifikasi_peminjamanlab(Request $request)
    {
        foreach ($request->id as $id) {
            PeminjamanLab::where('peminjamanlab_id', $id)->update(['status_verifikasi' => 'MENUNGGU VERIFIKASI']);
        }

        userlog('SUCCESS', 'Ajukan verifikasi peminjaman lab berhasil !');

        return response()->json(['status' => 'ok']);
    }

    public function data_inventaris()
    {
        $keyword_date_start = session('date_start');
        $keyword_date_end = session('date_end');

        $data = Inventaris::selectRaw('COUNT(kondisi_brg) as total, kondisi_brg as nama')->groupBy(['kondisi_brg'])->where('lab_id', auth()->user()->lab_id)->whereBetween('created_at', [$keyword_date_start, $keyword_date_end])->get();

        $temp = [];

        foreach ($data as $d) {
            $temp[$d->nama] = $d->total;
        }

        return response()->json($temp);
    }

    public function data_maintenance()
    {
        $keyword_date_start = session('date_start');        
        $keyword_date_end = session('date_end');

        $data1 = Maintenance::selectRaw('COUNT(kondisi_hard) as total, kondisi_hard as nama')->groupBy(['kondisi_hard'])->where('lab_id', auth()->user()->lab_id)->whereBetween('created_at', [$keyword_date_start, $keyword_date_end])->get();
        $data2 = Maintenance::selectRaw('COUNT(kondisi_soft) as total, kondisi_soft as nama')->groupBy(['kondisi_soft'])->where('lab_id', auth()->user()->lab_id)->whereBetween('created_at', [$keyword_date_start, $keyword_date_end])->get();

        $temp = [];

        foreach ($data1 as $d) {
            $temp[0][$d->nama] = $d->total;
        }

        foreach ($data2 as $d) {
            $temp[1][$d->nama] = $d->total;
        }

        return response()->json($temp);
    }
    
    public function data_maintenance_search(Request $request)
    {
        if(isset($request->date_start)) {
            $data_date_start = explode('/', $request->date_start);
            $keyword_date_start = $data_date_start[2] . '-' . $data_date_start[0] . '-' . $data_date_start[1];
            $keyword_date_start = date('Y-m-d 00:00:00', strtotime($keyword_date_start));    
        } 

        if(isset($request->date_end)) {
            $data_date_end = explode('/', $request->date_end);
            $keyword_date_end = $data_date_end[2] . '-' . $data_date_end[0] . '-' . $data_date_end[1];
            $keyword_date_end = date('Y-m-d 23:59:59', strtotime($keyword_date_end));    
        } 

        $data1 = Maintenance::selectRaw('COUNT(kondisi_hard) as total, kondisi_hard as nama')
        ->groupBy(['kondisi_hard'])
        ->where('created_at', '>=', $keyword_date_start)
        ->where('created_at', '<=', $keyword_date_end)
        ->where('lab_id', auth()->user()->lab_id)->get();

        $data2 = Maintenance::selectRaw('COUNT(kondisi_soft) as total, kondisi_soft as nama')
        ->groupBy(['kondisi_soft'])
        ->where('lab_id', auth()->user()->lab_id)
        ->where('created_at', '>=', $keyword_date_start)
        ->where('created_at', '<=', $keyword_date_end)->get();

        $temp = [];

        foreach ($data1 as $d) {
            $temp[0][$d->nama] = $d->total;
        }

        foreach ($data2 as $d) {
            $temp[1][$d->nama] = $d->total;
        }

        return response()->json($temp);
    }

    public function data_peminjamanalat()
    {
        $keyword_date_start = session('date_start');
        $keyword_date_end = session('date_end');

        $data1 = PeminjamanAlat::selectRaw('COUNT(kondisi_pjm) as total, kondisi_pjm as nama')->groupBy(['kondisi_pjm'])->where('lab_id', auth()->user()->lab_id)->whereBetween('created_at', [$keyword_date_start, $keyword_date_end])->get();
        $data2 = PeminjamanAlat::selectRaw('COUNT(kondisi_blk) as total, kondisi_blk as nama')->groupBy(['kondisi_blk'])->where('lab_id', auth()->user()->lab_id)->whereBetween('created_at', [$keyword_date_start, $keyword_date_end])->get();

        $temp = [];

        foreach ($data1 as $d) {
            $temp[0][$d->nama] = $d->total;
        }

        foreach ($data2 as $d) {
            $temp[1][$d->nama] = $d->total;
        }

        return response()->json($temp);
    }
}
