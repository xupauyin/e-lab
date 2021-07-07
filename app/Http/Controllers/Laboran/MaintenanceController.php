<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Http\Middleware\KoordinatorMiddleware;
use App\Model\Inventaris;
use App\Model\Laboratorium;
use App\Model\Maintenance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;

class MaintenanceController extends Controller
{
    protected $maintenance;

    public function __construct()
    {
        $this->maintenance = new Maintenance();
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

            if (isset($_GET['grafik'])) {
                return redirect()->route('laboran.maintenance.grafik')->withInput();
            }

            $data = [
                'maintenance' => Maintenance::where('lab_id', auth()->user()->lab_id)->withTrashed()
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
            session()->put('date_start', '');

            $data = [
                'maintenance' => Maintenance::where('lab_id', auth()->user()->lab_id)
                ->orderBy('status_verifikasi', 'ASC')
                ->orderBy('deleted_at', 'ASC')
                ->withTrashed()->paginate(5),
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('laboran.maintenance_tabel', $data);
    }

    public function grafik(){
        return view('laboran.maintenance_grafik');
    }

    public function inputqr($id)
    {
        $data = [
            'inventaris' => Inventaris::withTrashed()->find($id)
        ];
    
        return view('laboran.maintenance_inputqr', $data);
    }

    public function input()
    {
        return view('laboran.maintenance_input');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namakom' => 'required|string|max:20',
            'spekhard' => 'required|string',
            'kondisihard' => 'required|string|max:20',
            'penhard' => 'required|string',
            'speksoft' => 'required|string',
            'kondisisoft' => 'required|string|max:20',
            'pensoft' => 'required|string',
        ], [
            'namakom.required' => 'Nama komputer wajib diisi',
            'name.string' => 'Nama komputer harus dalam bentuk teks',
            'name.max' => 'Nama komputer maksimal 20 karakter',

            'spekhard.required' => 'Spesifikasi hardware wajib diisi',
            'spekhard.string' => 'Spesifikasi hardware harus dalam bentuk teks',

            'kondisihard.required' => 'Kondisi hardware wajib diisi',
            'kondisihard.string' => 'Kondisi hardware harus dalam bentuk teks',
            'kondisihard.max' => 'Kondisi hardware maksimal 20 karakter',

            'penhard.required' => 'Penanganan hardware wajib diisi',
            'penhard.string' => 'Penanganan hardware harus dalam bentuk teks',

            'speksoft.required' => 'Spesifikasi software wajib diisi',
            'speksoft.string' => 'Spesifikasi software harus dalam bentuk teks',

            'kondisisoft.required' => 'Kondisi software wajib diisi',
            'kondisisoft.string' => 'Kondisi software harus dalam bentuk teks',
            'kondisisoft.max' => 'Kondisi software maksimal 20 karakter',

            'pensoft.required' => 'Penanganan software wajib diisi',
            'pensoft.string' => 'Penanganan software harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $maintenance = Maintenance::create([
            'nama_kom' => $request->namakom,
            'spesifikasi_hard' => $request->spekhard,
            'kondisi_hard' => $request->kondisihard,
            'penanganan_hard' => $request->penhard,
            'spesifikasi_soft' => $request->speksoft,
            'kondisi_soft' => $request->kondisisoft,
            'penanganan_soft' => $request->pensoft,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($maintenance) {
            session()->flash('info', 'Data berhasil disimpan');

            userlog('SUCCESS', 'Data maintenance berhasil disimpan');

            return redirect()->route('laboran.maintenance.index');
        } else {
            session()->flash('danger', 'Data gagal disimpan');

            userlog('FAIL', 'Data maintenance gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = [
            'maintenance' => Maintenance::withTrashed()->find($id)
        ];
        return view('laboran.maintenance_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namakom' => 'required|string|max:20',
            'spekhard' => 'required|string',
            'kondisihard' => 'required|string|max:20',
            'penhard' => 'required|string',
            'speksoft' => 'required|string',
            'kondisisoft' => 'required|string|max:20',
            'pensoft' => 'required|string',
        ], [
            'namakom.required' => 'Nama komputer wajib diisi',
            'name.string' => 'Nama komputer harus dalam bentuk teks',
            'name.max' => 'Nama komputer maksimal 20 karakter',

            'spekhard.required' => 'Spesifikasi hardware wajib diisi',
            'spekhard.string' => 'Spesifikasi hardware harus dalam bentuk teks',

            'kondisihard.required' => 'Kondisi hardware wajib diisi',
            'kondisihard.string' => 'Kondisi hardware harus dalam bentuk teks',
            'kondisihard.max' => 'Kondisi hardware maksimal 20 karakter',

            'penhard.required' => 'Penanganan hardware wajib diisi',
            'penhard.string' => 'Penanganan hardware harus dalam bentuk teks',

            'speksoft.required' => 'Spesifikasi software wajib diisi',
            'speksoft.string' => 'Spesifikasi software harus dalam bentuk teks',

            'kondisisoft.required' => 'Kondisi software wajib diisi',
            'kondisisoft.string' => 'Kondisi software harus dalam bentuk teks',
            'kondisisoft.max' => 'Kondisi software maksimal 20 karakter',

            'pensoft.required' => 'Penanganan software wajib diisi',
            'pensoft.string' => 'Penanganan software harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $maintenance = [
            'nama_kom' => $request->namakom,
            'spesifikasi_hard' => $request->spekhard,
            'kondisi_hard' => $request->kondisihard,
            'penanganan_hard' => $request->penhard,
            'spesifikasi_soft' => $request->speksoft,
            'kondisi_soft' => $request->kondisisoft,
            'penanganan_soft' => $request->pensoft,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ];

        $query = Maintenance::find($id)->update($maintenance);

        if ($query) {
            session()->flash('info', 'Data berhasil di ubah');

            userlog('SUCCESS', 'Data maintenance berhasil di ubah');

            return redirect()->route('laboran.maintenance.index');
        } else {
            session()->flash('danger', 'Data  gagal di ubah');

            userlog('FAIL', 'Data maintenance gagal di ubah');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function laporan_pdf_ttd($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_laboran = User::where('role', 'laboran')->where('lab_id', $id_laboratorium)->first();
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'maintenance' => Maintenance::select('*')->selectRaw('WEEKDAY(created_at) AS minggu, MONTHNAME(created_at) AS bulan')
            ->where('status_verifikasi', 'SUDAH DIVERIFIKASI')
            ->where('created_at', '>=', $date_start)
            ->where('created_at', '<=', $date_end)->get(),
            'nama_laboran' => $data_laboran->name,
            'nama_koordinator' => $data_koordinator->name,
            'ttd_laboran' => $data_laboran->sign,
            'ttd_koordinator' => $data_koordinator->sign,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_maintenance_ttd', $data);
        $filename = 'maintenance_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'landscape')->download($filename);
    }

    public function laporan_pdf($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_laboran = User::where('role', 'laboran')->where('lab_id', $id_laboratorium)->first();
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'maintenance' => Maintenance::select('*')->selectRaw('WEEKDAY(created_at) AS minggu, MONTHNAME(created_at) AS bulan')
            ->where('status_verifikasi', 'SUDAH DIVERIFIKASI')
            ->where('created_at', '>=', $date_start)
            ->where('created_at', '<=', $date_end)->get(),
            'nama_laboran' => $data_laboran->name,
            'nama_koordinator' => $data_koordinator->name,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_maintenance', $data);
        $filename = 'maintenance_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'landscape')->download($filename);
    }
}
