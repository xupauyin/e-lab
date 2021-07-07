<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Model\Inventaris;
use App\Model\Laboratorium;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;

class InventarisController extends Controller
{
    protected $inventaris;

    public function __construct()
    {
        $this->inventaris = new Inventaris();
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

            if (isset($_GET['grafik'])) {
                return redirect()->route('koordinator.inventaris.grafik');
            }

            $data = [
                'inventaris' => Inventaris::where('lab_id', auth()->user()->lab_id)->withTrashed()
                    ->where('created_at', '>=', $keyword_date_start)
                    ->where('created_at', '<=', $keyword_date_end)
                    ->get(),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'per_page' => 0,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        } else {
            // BELUM DIVERIFIKASI, MENUNGGU VERIFIKASI, SUDAH DIVERIFIKASI

            $a =  Inventaris::where('lab_id', auth()->user()->lab_id)->withTrashed()
                ->whereIn('status_verifikasi', ['BELUM DIVERIFIKASI', 'SUDAH DIVERIFIKASI'])
                ->orderBy('status_verifikasi', 'ASC')
                ->orderBy('deleted_at', 'ASC');

            $b = Inventaris::where('lab_id', auth()->user()->lab_id)->withTrashed()
                ->whereIn('status_verifikasi', ['MENUNGGU VERIFIKASI'])
                ->union($a)->paginate(5);

            $data = [
                'inventaris' => $b,
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('koordinator.inventaris_tabel', $data);
    }

    public function grafik()
    {
        return view('koordinator.inventaris_grafik');
    }

    public function generateqr($id)
    {
        $filename = 'inventaris_' . $id . '_' . date('dmY') . '.png';

        $qr = new QrCode('http://192.168.1.7/e-lab/qrlink/' . $id);

        $qr->setWriterByName('png');
        $qr->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());

        header('Content-Type:', $qr->getContentType());
        header('Content-Disposition:attachment; filename', $filename);
        header('Content-Transfer-Encoding: binary');

        echo $qr->writeString();

        ob_flush();
        ob_clean();

        exit;
    }

    public function qrlink($id)
    {
        response('data')->cookie('data', $id, 10);
    }

    public function destroy($id)
    {
        $query = Inventaris::withTrashed()->find($id);

        if ($query->deleted_at == NULL) {
            $query->delete();
        } else {
            $query->update(["deleted_at" => NULL]);
        }
        return response()->json(['status' => 'success']);
    }
}
