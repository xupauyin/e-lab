<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Model\Laboratorium;
use App\Model\PeminjamanAlat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use Symfony\Component\HttpFoundation\RequestStack;

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
                return redirect()->route('laboran.peminjamanalat.grafik');
            }

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
                'cari' => isset($_GET['cari']) ? '1' : '0',
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
                'cari' => isset($_GET['cari']) ? '1' : '0',
            ];
        }

        return view('laboran.peminjamanalat_tabel', $data);
    }

    public function grafik()
    {
        return view('laboran.peminjamanalat_grafik');
    }

    public function input()
    {
        return view('laboran.peminjamanalat_input');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjam' => 'required|string|max:100',
            'lmbpeminjam' => 'required|string|max:100',
            'namaalat' => 'required|string|max:50',
            'kodealat' => 'required|string|max:20',
            'jumlah' => 'required|string|max:11',
            'lama' => 'required|string|max:20',
            'satuan' => 'required|string|max:8',
            'konpjm' => 'required|string|max:5',
        ], [
            'peminjam.required' => 'Nama peminjam wajib diisi',
            'peminjam.string' => 'Nama peminjam harus dalam bentuk teks',
            'peminjam.max' => 'Nama peminjam maksimal 100 karakter',

            'lmbpeminjam.required' => 'Lembaga peminjam wajib diisi',
            'lmbpeminjam.string' => 'Lembaga peminjam harus dalam bentuk teks',
            'lmbpeminjam.max' => 'Lembaga peminjam maksimal 100 karakter',

            'namaalat.required' => 'Nama alat wajib diisi',
            'namaalat.string' => 'Nama alat harus dalam bentuk teks',
            'namaalat.max' => 'Nama alat maksimal 50 karakter',

            'kodealat.required' => 'Kode alat wajib diisi',
            'kodealat.string' => 'Kode alat harus dalam bentuk teks',
            'kodealat.max' => 'Kode alat maksimal 20 karakter',

            'jumlah.required' => 'Jumlah alat wajib diisi',
            'jumlah.string' => 'Jumlah alat harus dalam bentuk teks',
            'jumlah.max' => 'Jumlah alat maksimal 11 karakter',

            'lama.required' => 'Lama peminjaman wajib diisi',
            'lama.string' => 'Lama peminjaman harus dalam bentuk teks',
            'lama.max' => 'Lama peminjaman maksimal 20 karakter',

            'satuan.required' => 'Satuan peminjaman wajib diisi',
            'satuan.string' => 'Satuan peminjaman harus dalam bentuk teks',
            'satuan.max' => 'Satuan peminjaman maksimal 8 karakter',

            'konpjm.required' => 'Kondisi pinjaman wajib diisi',
            'konpjm.string' => 'Kondisi pinjaman harus dalam bentuk teks',
            'konpjm.max' => 'Kondisi pinjaman maksimal 5 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lama = $request->lama . ' ' . $request->satuan;

        $peminjamanalat = PeminjamanAlat::create([
            'peminjam' => $request->peminjam,
            'lmb_peminjam' => $request->lmbpeminjam,
            'nama_alat' => $request->namaalat,
            'kode_alat' => $request->kodealat,
            'jumlah' => $request->jumlah,
            'lama' => $lama,
            'kondisi_pjm' => $request->konpjm,
            'pengembali' => null,
            'tgl_kembali' => null,
            'kondisi_blk' => null,
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($peminjamanalat) {
            session()->flash('info', 'Data berhasil disimpan');

            userlog('SUCCESS', 'Data peminjaman alat berhasil disimpan');

            return redirect()->route('laboran.peminjamanalat.index');
        } else {
            session()->flash('danger', 'Data gagal disimpan');

            userlog('FAIL', 'Data peminjaman alat gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = [
            'peminjamanalat' => PeminjamanAlat::withTrashed()->find($id)
        ];
        return view('laboran.peminjamanalat_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pengembali' => 'required|string|max:100',
            'tglkem' => 'required|date',
            'konblk' => 'required|string|max:5',
        ], [
            'pengembali.required' => 'Nama pengembali wajib diisi',
            'pengembali.string' => 'Nama pengembali harus dalam bentuk teks',
            'pengembali.max' => 'Nama pengembali maksimal 100 karakter',

            'tglkem.required' => 'Tanggal pengembalian wajib diisi',
            'tglkem.date' => 'Tanggal pengembalian harus dalam bentuk tanggal',

            'konblk.required' => 'Kondisi kembali wajib diisi',
            'konblk.string' => 'Kondisi kembali harus dalam bentuk teks',
            'konblk.max' => 'Kondisi kembali maksimal 5 karakter',
        ]);

        $peminjamanalat = [
            'pengembali' => $request->input('pengembali'),
            'tgl_kembali' => $request->input('tglkem'),
            'kondisi_blk' => $request->input('konblk'),
            'lab_id' => Auth::user()->lab_id,
            'user_id' => Auth::user()->id,
        ];

        $query = PeminjamanAlat::find($id)->update($peminjamanalat);

        if ($query) {
            session()->flash('info', 'Data berhasil di ubah');

            userlog('SUCCESS', 'Data peminjaman alat berhasil di ubah');

            return redirect()->route('laboran.peminjamanalat.index');
        } else {
            session()->flash('danger', 'Data  gagal di ubah');

            userlog('FAIL', 'Data peminjaman alat gagal di ubah');

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
            'peminjamanalat' => PeminjamanAlat::select('*')->selectRaw('DAYNAME(created_at) AS hari')
                ->where('status_verifikasi', 'SUDAH DIVERIFIKASI')
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

        $pdf = PDF::loadView('pdf.laporan_peminjamanalat_ttd', $data);
        $filename = 'peminjamanalat_' . date('dmy') . '.pdf';

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
            'peminjamanalat' => PeminjamanAlat::select('*')->selectRaw('DAYNAME(created_at) AS hari')
                ->where('status_verifikasi', 'SUDAH DIVERIFIKASI')
                ->where('created_at', '>=', $date_start)
                ->where('created_at', '<=', $date_end)->get(),
            'nama_laboran' => $data_laboran->name,
            'nama_koordinator' => $data_koordinator->name,
            'nama_kaprodi' => $data_kaprodi->name,
            'nama_laboratorium' => $laboratorium,
            'n' => 1
        ];

        $pdf = PDF::loadView('pdf.laporan_peminjamanalat', $data);
        $filename = 'peminjamanalat_' . date('dmy') . '.pdf';

        return $pdf->setPaper('f4', 'potrait')->download($filename);
    }
}
