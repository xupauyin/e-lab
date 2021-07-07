<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Model\PeminjamanAlat;
use Illuminate\Http\Request;

class PeminjamanAlatController extends Controller
{
    protected $peminjamanalat;

    public function __construct()
    {
        $this->peminjamanalat = new PeminjamanAlat();
    }

    public function index(Request $request)
    {
        if (!empty($request->date_start) && !empty($request->date_end)) {
            $data_date_start = explode('/', $request->date_start);
            $keyword_date_start = $data_date_start[2] . '-' . $data_date_start[1] . '-' . $data_date_start[0];
            $keyword_date_start = date('Y-m-d 00:00:00', strtotime($keyword_date_start));

            $data_date_end = explode('/', $request->date_end);
            $keyword_date_end = $data_date_end[2] . '-' . $data_date_end[1] . '-' . $data_date_end[0];
            $keyword_date_end = date('Y-m-d 23:59:59', strtotime($keyword_date_end));

            session()->put('date_start', $keyword_date_start);
            session()->put('date_end', $keyword_date_end);


            $data = [
                'peminjamanalat' => PeminjamanAlat::where('lab_id', auth()->user()->lab_id)->withTrashed()
                ->where('created_at', '>=', $keyword_date_start)
                ->where('created_at', '<=', $keyword_date_end)
                ->orderBy('status_verifikasi', 'ASC')
                ->orderBy('deleted_at', 'ASC')
                ->get(),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'per_page' => 0,
            ];
        } else {
            session()->put('date_start', '');

            $data = [
                'peminjamanalat' => PeminjamanAlat::where('lab_id', auth()->user()->lab_id)
                ->orderBy('status_verifikasi', 'ASC')
                ->orderBy('deleted_at', 'ASC')
                ->withTrashed()->paginate(5),
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
            ];
        }

        return view('administrator.peminjamanalat_tabel', $data);
    }

    public function destroy($id)
    {
        $query = PeminjamanAlat::withTrashed()->find($id);

        if ($query->deleted_at == NULL) {
            $query->delete();
        } else {
            $query->update(["deleted_at" => NULL]);
        }
        return response()->json(['status' => 'success']);
    }
}
