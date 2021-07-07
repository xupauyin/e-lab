<?php

namespace App\Http\Controllers\Laboran;

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


            if (isset($_GET['printttd'])) {
                return $this->laporan_pdf_ttd($keyword_date_start, $keyword_date_end);
            }

            if (isset($_GET['print'])) {
                return $this->laporan_pdf($keyword_date_start, $keyword_date_end);
            }

            if (isset($_GET['grafik'])) {
                return redirect()->route('laboran.inventaris.grafik');
            }

            $data = [
                'inventaris' => Inventaris::where('lab_id', auth()->user()->lab_id)->withTrashed()
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
                'inventaris' => Inventaris::where('lab_id', auth()->user()->lab_id)
                    ->orderBy('status_verifikasi', 'ASC')
                    ->orderBy('deleted_at', 'ASC')
                    ->withTrashed()->paginate(5),
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('laboran.inventaris_tabel', $data);
    }

    public function grafik()
    {
        return view('laboran.inventaris_grafik');
    }

    public function input()
    {
        return view('laboran.inventaris_input');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sarpras' => 'required|string|max:100|min:1',
            'barang' => 'required|string|max:100|min:2',
            'nama' => 'required|string|max:100|min:2',
            'spesifikasi' => 'required|string',
            'tahun' => 'required|string|size:4',
            'kondisi' => 'required|string|max:20|min:4',
            'keterangan' => 'string'
        ], [
            'sarpras.required' => 'Kode sarpras wajib diisi',
            'sarpras.string' => 'Kode sarpras harus dalam bentuk teks',
            'sarpras.max' => 'Kode sarpras maksimal 100 karakter',
            'sarpras.min' => 'Kode sarpras minimal 1 karakter',

            'barang.required' => 'Kode barang wajib diisi',
            'barang.string' => 'Kode barang harus dalam bentuk teks',
            'barang.max' => 'Kode barang maksimal 100 karakter',
            'barang.min' => 'Kode barang minimal 2 karakter',

            'nama.required' => 'Nama barang wajib diisi',
            'nama.string' => 'Nama barang harus dalam bentuk teks',
            'nama.max' => 'Nama barang maksimal 100 karakter',
            'nama.min' => 'Nama barang minimal 2 karakter',

            'spesifikasi.required' => 'Spesifikasi barang wajib diisi',
            'spesifikasi.string' => 'Spesifikasi barang harus dalam bentuk teks',

            'tahun.required' => 'Tahun pembelian wajib diisi',
            'tahun.string' => 'Tahun pembelian harus dalam bentuk teks',
            'tahun.size' => 'Tahun pembelian wajib 4 karakter',

            'kondisi.required' => 'Kondisi barang wajib diisi',
            'kondisi.string' => 'Kondisi barang harus dalam bentuk teks',
            'kondisi.max' => 'Kondisi barang maksimal 20 karakter',
            'kondisi.min' => 'Kondisi barang minimal 4 karakter',

            'keterangan.string' => 'Keterangan harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inventaris = Inventaris::create([
            'kode_sarpras' => $request->sarpras,
            'kode_brg' => $request->barang,
            'nama_brg' => $request->nama,
            'spesifikasi_brg' => $request->spesifikasi,
            'tahun_beli' => $request->tahun,
            'kondisi_brg' => $request->kondisi,
            'keterangan' => $request->keterangan,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($inventaris) {
            session()->flash('info', 'Data berhasil disimpan');

            userlog('SUCCESS', 'Data inventaris berhasil disimpan');

            return redirect()->route('laboran.inventaris.index');
        } else {
            session()->flash('danger', 'Data gagal disimpan');

            userlog('FAIL', 'Data inventaris gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = [
            'inventaris' => Inventaris::withTrashed()->find($id)
        ];
        return view('laboran.inventaris_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sarpras' => 'required|string|max:100|min:1',
            'barang' => 'required|string|max:100|min:2',
            'nama' => 'required|string|max:100|min:2',
            'spesifikasi' => 'required|string',
            'tahun' => 'required|string|size:4',
            'kondisi' => 'required|string|max:20|min:4',
            'keterangan' => 'string'
        ], [
            'sarpras.required' => 'Kode sarpras wajib diisi',
            'sarpras.string' => 'Kode sarpras harus dalam bentuk teks',
            'sarpras.max' => 'Kode sarpras maksimal 100 karakter',
            'sarpras.min' => 'Kode sarpras minimal 1 karakter',

            'barang.required' => 'Kode barang wajib diisi',
            'barang.string' => 'Kode barang harus dalam bentuk teks',
            'barang.max' => 'Kode barang maksimal 100 karakter',
            'barang.min' => 'Kode barang minimal 2 karakter',

            'nama.required' => 'Nama barang wajib diisi',
            'nama.string' => 'Nama barang harus dalam bentuk teks',
            'nama.max' => 'Nama barang maksimal 100 karakter',
            'nama.min' => 'Nama barang minimal 2 karakter',

            'spesifikasi.required' => 'Spesifikasi barang wajib diisi',
            'spesifikasi.string' => 'Spesifikasi barang harus dalam bentuk teks',

            'tahun.required' => 'Tahun pembelian wajib diisi',
            'tahun.string' => 'Tahun pembelian harus dalam bentuk teks',
            'tahun.size' => 'Tahun pembelian wajib 4 karakter',

            'kondisi.required' => 'Kondisi barang wajib diisi',
            'kondisi.string' => 'Kondisi barang harus dalam bentuk teks',
            'kondisi.max' => 'Kondisi barang maksimal 20 karakter',
            'kondisi.min' => 'Kondisi barang minimal 4 karakter',

            'keterangan.string' => 'Keterangan harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inventaris = [
            'kode_sarpras' => $request->sarpras,
            'kode_brg' => $request->barang,
            'nama_brg' => $request->nama,
            'spesifikasi_brg' => $request->spesifikasi,
            'tahun_beli' => $request->tahun,
            'kondisi_brg' => $request->kondisi,
            'keterangan' => $request->keterangan,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ];

        $query = Inventaris::find($id)->update($inventaris);

        if ($query) {
            session()->flash('info', 'Data berhasil di update');

            userlog('SUCCESS', 'Data inventaris berhasil diubah');

            return redirect()->route('laboran.inventaris.index');
        } else {
            session()->flash('danger', 'Data  gagal di update');

            userlog('FAIL', 'Data inventaris gagal diubah');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function laporan_pdf_ttd($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $data_kaprodi = User::where('role', 'administrator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'inventaris' => Inventaris::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
                ->where('created_at', '>=', $date_start)
                ->where('created_at', '<=', $date_end)->get(),
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'ttd_koordinator' => $data_koordinator->sign,
            'ttd_kaprodi' => $data_kaprodi->sign,
            'nama_laboratorium' => $laboratorium,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_inventaris_ttd', $data);
        $filename = 'inventaris_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'landscape')->download($filename);
    }

    public function laporan_pdf($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $data_kaprodi = User::where('role', 'administrator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'inventaris' => Inventaris::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
                ->where('created_at', '>=', $date_start)
                ->where('created_at', '<=', $date_end)->get(),
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'nama_laboratorium' => $laboratorium,
            'date_start' => $date_start,
            'date_end' =>  $date_end,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_inventaris', $data);
        $filename = 'inventaris_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'landscape')->download($filename);
    }
}
