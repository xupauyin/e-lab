<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Model\Laboratorium;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $data = [
            'user' => User::with('laboratorium')->withTrashed()->get()
        ];

        // dd($data['user']);

        return view('administrator.user_select', $data);
    }

    public function user_create()
    {
        $data = [
            'laboratorium' => Laboratorium::get()
        ];

        return view('administrator.user_create', $data);
    }

    public function user_edit($id)
    {
        $cek = User::find($id);

        if ($cek == NULL) {
            return redirect()->back();
        }

        $data = [
            'user' => User::withTrashed()->find($id),
            'laboratorium' => Laboratorium::get()
        ];

        return view('administrator.user_edit', $data);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'laboratorium' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus dalam bentuk teks',
            'name.max' => 'Nama maksimal 191 karakter',

            'email.required' => 'E-mail wajib diisi',
            'email.string' => 'E-mail harus dalam bentuk teks',
            'email.email' => 'E-mail harus dalam format email (contoh: user@example.com)',
            'email.max' => 'E-mail maksimal 191 karakter',

            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus dalam bentuk teks',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password harus sama dengan password konfirmasi',

            'role.required' => 'Tipe user wajib diisi',
            'role.string' => 'Tipe user harus dalam bentuk teks',

            'laboratorium.required' => 'Laboratorium user wajib diisi',
            'laboratorium.string' => 'Laboratorium user harus dalam bentuk teks',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'lab_id' => intval($request->laboratorium),
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            session()->flash('info', 'User berhasil disimpan');

            userlog('SUCCESS', 'Data user berhasil disimpan');

            return redirect()->route('administrator.user.index');
        } else {
            session()->flash('danger', 'User gagal disimpan');

            userlog('FAIL', 'Data user gagal disimpan');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function user_update(Request $request, $id)
    {
        if (empty($request->password) || $request->password == "") {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191',
                'role' => 'required|string',
                'laboratorium' => 'required|string',
            ], [
                'name.required' => 'Nama wajib diisi',
                'name.string' => 'Nama harus dalam bentuk teks',
                'name.max' => 'Nama maksimal 191 karakter',

                'email.required' => 'E-mail wajib diisi',
                'email.string' => 'E-mail harus dalam bentuk teks',
                'email.email' => 'E-mail harus dalam format email (contoh: user@example.com)',
                'email.max' => 'E-mail maksimal 191 karakter',

                'role.required' => 'Tipe user wajib diisi',
                'role.string' => 'Tipe user harus dalam bentuk teks',

                'laboratorium.required' => 'Laboratorium user wajib diisi',
                'laboratorium.string' => 'Laboratorium user harus dalam bentuk teks',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string',
                'laboratorium' => 'required|string',
            ], [
                'name.required' => 'Nama wajib diisi',
                'name.string' => 'Nama harus dalam bentuk teks',
                'name.max' => 'Nama maksimal 255 karakter',

                'email.required' => 'E-mail wajib diisi',
                'email.string' => 'E-mail harus dalam bentuk teks',
                'email.email' => 'E-mail harus dalam format email (contoh: user@example.com)',
                'email.max' => 'E-mail maksimal 255 karakter',

                'password.required' => 'Password wajib diisi',
                'password.string' => 'Password harus dalam bentuk teks',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Password harus sama dengan password konfirmasi',

                'role.required' => 'Tipe user wajib diisi',
                'role.string' => 'Tipe user harus dalam bentuk teks',

                'laboratorium.required' => 'Laboratorium user wajib diisi',
                'laboratorium.string' => 'Laboratorium user harus dalam bentuk teks',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (empty($request->password) || $request->password == "") {
            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'lab_id' => intval($request->laboratorium),
            ];
        } else {
            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'lab_id' => intval($request->laboratorium),
                'password' => Hash::make($request->password),
            ];
        }

        $query = User::find($id)->update($user);

        if ($query) {
            session()->flash('info', 'User berhasil diubah');

            userlog('SUCCESS', 'Data user berhasil diubah');

            return redirect()->route('administrator.user.index');
        } else {
            session()->flash('danger', 'User gagal diupdate');

            userlog('FAIL', 'Data user gagal diubah');

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $query = User::withTrashed()->find($id);

        if ($query->deleted_at == NULL) {
            $query->delete();
        } else {
            $query->update(["deleted_at" => NULL]);
        }
        return response()->json(['status' => 'success']);
    }
}
