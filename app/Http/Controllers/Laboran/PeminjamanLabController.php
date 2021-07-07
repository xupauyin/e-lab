<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Model\Laboratorium;
use App\Model\PeminjamanAlat;
use App\Model\PeminjamanLab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use Symfony\Component\HttpFoundation\RequestStack;

class PeminjamanLabController extends Controller
{
    protected $peminjamanlab;

    public function __construct()
    {
        $this->peminjamanlab = new PeminjamanLab();
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
                'peminjamanlab' => PeminjamanLab::where('lab_id', auth()->user()->lab_id)->withTrashed()
                    ->where('created_at', '>=', $keyword_date_start)
                    ->where('created_at', '<=', $keyword_date_end)
                    ->get(),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'per_page' => 0,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        } else {
            $data = [
                'peminjamanlab' => PeminjamanLab::where('lab_id', auth()->user()->lab_id)
                    ->orderBy('status_verifikasi', 'ASC')
                    ->orderBy('deleted_at', 'ASC')
                    ->withTrashed()->paginate(5),
                'date_start' => '',
                'date_end' => '',
                'per_page' => 5,
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('laboran.peminjamanlab_tabel', $data);
    }

    public function input()
    {
        return view('laboran.peminjamanlab_input');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namapl' => 'required|string|max:100',
            'unitpl' => 'required|string|max:100',
            'jampinjam' => 'required|string',
            'namalab' => 'required|string|max:100',
            'keppl' => 'required|string',
            'tglreq' => 'required|date',
        ], [
            'namapl.required' => 'Nama peminjam wajib diisi',
            'namapl.string' => 'Nama peminjam harus dalam bentuk teks',
            'namapl.max' => 'Nama peminjam maksimal 100 karakter',

            'unitpl.required' => 'Lembaga peminjam wajib diisi',
            'unitpl.string' => 'Lembaga peminjam harus dalam bentuk teks',
            'unitpl.max' => 'Lembaga peminjam maksimal 100 karakter',

            'jampinjam.required' => 'Jam peminjaman wajib diisi',
            'jampinjam.string' => 'Jam peminjaman harus dalam bentuk teks',

            'namalab.required' => 'Nama laboratorium wajib diisi',
            'namalab.string' => 'Nama laboratorium harus dalam bentuk teks',
            'namalab.max' => 'Nama laboratorium maksimal 100 karakter',

            'keppl.required' => 'Keperluan peminjaman wajib diisi',
            'keppl.string' => 'Keperluan peminjaman harus dalam bentuk teks',

            'tglreq.required' => 'Tanggal peminjaman wajib diisi',
            'tglreq.date' => 'Tanggal peminjaman harus dalam bentuk tanggal',
        ]);

        if ($validator->fails()) {
            session()->flash('danger', '');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tanggal = explode(' ', $request->input('tglreq'));

        $peminjamanlab = PeminjamanLab::create([
            'nama_pl' => $request->namapl,
            'unit_pl' => $request->unitpl,
            'tgl_req' => $tanggal[0] . ' ' . $request->jampinjam,
            'nama_lab' => $request->namalab,
            'keperluan_pl' => $request->keppl,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($peminjamanlab) {
            session()->flash('info', 'Data berhasil disimpan');

            userlog('SUCCESS', 'Data peminjaman lab berhasil disimpan');

            return redirect()->route('laboran.peminjamanlab.index');
        } else {
            session()->flash('danger', 'Data gagal disimpan');

            userlog('SUCCESS', 'Data peminjaman lab gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = [
            'peminjamanlab' => PeminjamanLab::withTrashed()->find($id)
        ];
        return view('laboran.peminjamanlab_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $tanggal = explode(' ', $request->input('tglreq'));

        $validator = Validator::make($request->all(), [
            'namapl' => 'required|string|max:100',
            'unitpl' => 'required|string|max:100',
            'tglreq' => 'required|date',
            'jampinjam' => 'required|string',
            'namalab' => 'required|string|max:100',
            'keppl' => 'required|string',
        ], [
            'namapl.required' => 'Nama peminjam wajib diisi',
            'namapl.string' => 'Nama peminjam harus dalam bentuk teks',
            'namapl.max' => 'Nama peminjam maksimal 100 karakter',

            'unitpl.required' => 'Lembaga peminjam wajib diisi',
            'unitpl.string' => 'Lembaga peminjam harus dalam bentuk teks',
            'unitpl.max' => 'Lembaga peminjam maksimal 100 karakter',

            'tglreq.required' => 'Tanggal request wajib diisi',
            'tglreq.date' => 'Tanggal request harus dalam bentuk tanggal',

            'jampinjam.required' => 'Jam peminjaman wajib diisi',
            'jampinjam.string' => 'Jam peminjaman harus dalam bentuk jam',

            'namalab.required' => 'Nama laboratorium wajib diisi',
            'namalab.string' => 'Nama laboratorium harus dalam bentuk teks',
            'namalab.max' => 'Nama laboratorium maksimal 100 karakter',

            'keppl.required' => 'Keperluan peminjaman wajib diisi',
            'keppl.string' => 'Keperluan peminjaman harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $peminjamanlab = [
            'nama_pl' => $request->namapl,
            'unit_pl' => $request->unitpl,
            'tgl_req' => $tanggal[0] . ' ' . $request->jampinjam,
            'nama_lab' => $request->namalab,
            'keperluan_pl' => $request->keppl,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ];

        $query = PeminjamanLab::find($id)->update($peminjamanlab);

        if ($query) {
            session()->flash('info', 'Data berhasil di ubah');

            userlog('SUCCESS', 'Data peminjaman lab berhasil di ubah');

            return redirect()->route('laboran.peminjamanlab.index');
        } else {
            session()->flash('danger', 'Data  gagal di ubah');

            userlog('SUCCESS', 'Data peminjaman lab gagal di ubah');

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
            'peminjamanlab' => PeminjamanLab::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
                ->where('created_at', '>=', $date_start)
                ->where('created_at', '<=', $date_end)->get(),
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'ttd_koordinator' => $data_koordinator->sign,
            'ttd_kaprodi' => $data_kaprodi->sign,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_peminjamanlab_ttd', $data);
        $filename = 'peminjamanlab_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'potrait')->download($filename);
    }

    public function laporan_pdf($date_start, $date_end)
    {
        $id_laboratorium = auth()->user()->lab_id;
        $data_koordinator = User::where('role', 'koordinator')->where('lab_id', $id_laboratorium)->first();
        $data_kaprodi = User::where('role', 'administrator')->where('lab_id', $id_laboratorium)->first();
        $laboratorium = Laboratorium::find($id_laboratorium)->first()->nama_laboratorium;

        $data = [
            'peminjamanlab' => PeminjamanLab::where('status_verifikasi', 'SUDAH DIVERIFIKASI')
                ->where('created_at', '>=', $date_start)
                ->where('created_at', '<=', $date_end)->get(),
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_peminjamanlab', $data);
        $filename = 'peminjamanlab_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'potrait')->download($filename);
    }
}
