<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Model\Jurnal;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    protected $jurnal;

    public function __construct()
    {
        $this->jurnal = new Jurnal();
    }

    public function index(Request $request)
    {
        if (!empty($request->date_start) && !empty($request->date_end)) {
            $data_date_start = explode('-', $request->date_start);
            $keyword_date_start = $data_date_start[2] . '-' . $data_date_start[1] . '-' . $data_date_start[0];
            $keyword_date_start = date('Y-m-d 00:00:00', strtotime($keyword_date_start));

            $data_date_end = explode('-', $request->date_end);
            $keyword_date_end = $data_date_end[2] . '-' . $data_date_end[1] . '-' . $data_date_end[0];
            $keyword_date_end = date('Y-m-d 23:59:59', strtotime($keyword_date_end));

            session()->put('date_start', $keyword_date_start);
            session()->put('date_end', $keyword_date_end);

            $data = [
                'jurnal' => Jurnal::where('lab_id', auth()->user()->lab_id)->withTrashed()
                    ->where('created_at', '>=', $keyword_date_start)
                    ->where('created_at', '<=', $keyword_date_end)
                    ->get(),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'per_page' => 0,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        } else {
            $a =  Jurnal::where('lab_id', auth()->user()->lab_id)->withTrashed()
                ->whereIn('status_verifikasi', ['BELUM DIVERIFIKASI', 'SUDAH DIVERIFIKASI'])
                ->orderBy('status_verifikasi', 'ASC')
                ->orderBy('deleted_at', 'ASC');

            $b = Jurnal::where('lab_id', auth()->user()->lab_id)->withTrashed()
                ->whereIn('status_verifikasi', ['MENUNGGU VERIFIKASI'])
                ->union($a)->paginate(5);

            $data = [
                'jurnal' => $b,
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('koordinator.jurnal_tabel', $data);
    }

    public function destroy($id)
    {
        $query = Jurnal::withTrashed()->find($id);

        if ($query->deleted_at == NULL) {
            $query->delete();
        } else {
            $query->update(["deleted_at" => NULL]);
        }
        return response()->json(['status' => 'success']);
    }
}
