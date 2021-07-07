<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Laboratorium;
use Illuminate\Support\Facades\Validator;

class LaboratoriumController extends Controller
{
    protected $lab;

    public function __construct()
    {
        $this->lab = new Laboratorium();
    }

    public function index()
    {
        $data = [
            'lab' => Laboratorium::withTrashed()->paginate(5)
        ];

        return view('administrator.lab_select', $data);
    }

    public function lab_create()
    {
        return view('administrator.lab_create');
    }

    public function lab_edit($id)
    {
        $data = [
            'lab' => Laboratorium::withTrashed()->find($id)
        ];

        return view('administrator.lab_edit', $data);
    }

    public function lab_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'labnama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
        ], [
            'labnama.required' => 'Nama laboratorium wajib diisi',
            'name.string' => 'Nama laboratorium harus dalam bentuk teks',
            'name.max' => 'Nama laboratorium maksimal 255 karakter',

            'prodi.required' => 'Prodi wajib diisi',
            'prodi.string' => 'Prodi harus dalam bentuk teks',
            'prodi.max' => 'Prodi maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lab = Laboratorium::create([
            'nama_laboratorium' => $request->labnama,
            'prodi' => $request->prodi,
        ]);

        if ($lab) {
            session()->flash('info', 'Laboratorium berhasil disimpan');

            userlog('SUCCESS', 'Data laboratorium berhasil disimpan');

            return redirect()->route('administrator.lab.index');
        } else {
            session()->flash('danger', 'Laboratorium gagal disimpan');

            userlog('FAIL', 'Data laboratorium gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function lab_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'labnama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
        ], [
            'labnama.required' => 'Nama laboratorium wajib diisi',
            'name.string' => 'Nama laboratorium harus dalam bentuk teks',
            'name.max' => 'Nama laboratorium maksimal 255 karakter',

            'prodi.required' => 'Prodi wajib diisi',
            'prodi.string' => 'Prodi harus dalam bentuk teks',
            'prodi.max' => 'Prodi maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lab = [
            'nama_laboratorium' => $request->labnama,
            'prodi' => $request->prodi,
        ];

        $query = Laboratorium::find($id)->update($lab);

        if ($query) {
            session()->flash('info', 'Laboratorium berhasil diubah');

            userlog('SUCCESS', 'Data laboratorium berhasil diubah');

            return redirect()->route('administrator.lab.index');
        } else {
            session()->flash('danger', 'Laboratorium gagal di update');

            userlog('FAIL', 'Data laboratorium gagal diubah');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $query = Laboratorium::withTrashed()->find($id);

        if ($query->deleted_at == NULL) {
            $query->delete();
        } else {
            $query->update(["deleted_at" => NULL]);
        }
        return response()->json(['status' => 'success']);
    }
}
