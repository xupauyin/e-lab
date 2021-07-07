<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Model\Jurnal;
use App\Model\Laboratorium;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;

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

            if (isset($_GET['printttd'])) {
                return $this->laporan_pdf_ttd($keyword_date_start, $keyword_date_end);
            }

            if (isset($_GET['print'])) {
                return $this->laporan_pdf($keyword_date_start, $keyword_date_end);
            }

            $data = [
                'jurnal' => Jurnal::where('lab_id', auth()->user()->lab_id)->withTrashed()
                    ->where('created_at', '>=', $keyword_date_start)
                    ->where('created_at', '<=', $keyword_date_end)
                    ->orderBy('status_verifikasi', 'ASC')
                    ->orderBy('deleted_at', 'ASC')
                    ->get(),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'per_page' => 0,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        } else {
            $data = [
                'jurnal' => Jurnal::where('lab_id', auth()->user()->lab_id)
                    ->orderBy('status_verifikasi', 'ASC')
                    ->orderBy('deleted_at', 'ASC')
                    ->withTrashed()->paginate(5),
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('laboran.jurnal_tabel', $data);
    }

    public function input()
    {
        return view('laboran.jurnal_input');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uraian' => 'required|string',
            'waktujurnal' => 'required|string',
            'catatan' => 'required|string',
        ], [
            'uraian.required' => 'Uraian kegiatan wajib diisi',
            'uraian.string' => 'Uraian kegiatan harus dalam bentuk teks',

            'waktujurnal.required' => 'Waktu jurnal wajib diisi',
            'waktujurnal.string' => 'Waktu jurnal harus dalam bentuk teks',

            'catatan.required' => 'Catatan pihak terkait wajib diisi',
            'catatan.string' => 'Catatan pihak terkait harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jurnal = Jurnal::create([
            'uraian_kgt' => $request->uraian,
            'waktu_jurnal' => $request->waktujurnal,
            'ctt_pihak' => $request->catatan,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($jurnal) {
            session()->flash('info', 'Data berhasil disimpan');

            userlog('SUCCESS', 'Data jurnal berhasil disimpan');

            return redirect()->route('laboran.jurnal.index');
        } else {
            session()->flash('danger', 'Data gagal disimpan');

            userlog('FAIL', 'Data jurnal gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = [
            'jurnal' => Jurnal::withTrashed()->find($id)
        ];
        return view('laboran.jurnal_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'uraian' => 'required|string',
            'waktujurnal' => 'required|string',
            'catatan' => 'required|string',
        ], [
            'uraian.required' => 'Uraian kegiatan wajib diisi',
            'uraian.string' => 'Uraian kegiatan harus dalam bentuk teks',

            'waktujurnal.required' => 'Waktu jurnal wajib diisi',
            'waktujurnal.string' => 'Waktu jurnal harus dalam bentuk teks',

            'catatan.required' => 'Catatan pihak terkait wajib diisi',
            'catatan.string' => 'Catatan pihak terkait harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jurnal = [
            'uraian_kgt' => $request->uraian,
            'waktu_jurnal' => $request->waktujurnal,
            'ctt_pihak' => $request->catatan,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ];

        $query = Jurnal::find($id)->update($jurnal);

        if ($query) {
            session()->flash('info', 'Data berhasil di ubah');

            userlog('SUCCESS', 'Data jurnal berhasil di ubah');

            return redirect()->route('laboran.jurnal.index');
        } else {
            session()->flash('danger', 'Data  gagal di ubah');

            userlog('FAIL', 'Data jurnal gagal di ubah');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function laporan_pdf_ttd($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_laboran = User::where('role', 'laboran')->where('lab_id', $id_laboratorium)->first();
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $data_kaprodi = User::where('role', 'administrator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'jurnal' => Jurnal::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
            ->where('created_at', '>=', $date_start)
            ->where('created_at', '<=', $date_end)->get(),
            'nama_laboran' => $data_laboran->name,
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'ttd_laboran' => $data_laboran->sign,
            'ttd_koordinator' => $data_koordinator->sign,
            'ttd_kaprodi' => $data_kaprodi->sign,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_jurnal_ttd', $data);
        $filename = 'jurnal_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'potrait')->download($filename);
    }

    public function laporan_pdf($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_laboran = User::where('role', 'laboran')->where('lab_id', $id_laboratorium)->first();
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $data_kaprodi = User::where('role', 'administrator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'jurnal' => Jurnal::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
            ->where('created_at', '>=', $date_start)
            ->where('created_at', '<=', $date_end)->get(),
            'nama_laboran' => $data_laboran->name,
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_jurnal', $data);
        $filename = 'jurnal_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'potrait')->download($filename);
    }
}
