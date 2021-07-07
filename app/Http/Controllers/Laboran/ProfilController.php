<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;

        $data = [
            'profil' => User::find($id)
        ];

        return view('laboran.profil', $data);
    }

    public function update(Request $request)
    {
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'confirmed',
            'sign' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus dalam bentuk teks',
            'name.max' => 'Nama maksimal 255 karakter',

            'email.required' => 'E-Mail wajib diisi',
            'email.string' => 'E-Mail harus dalam bentuk teks',
            'email.email' => 'E-Mail harus dalam format email (contoh: user@example.com)',
            'email.max' => 'E-Mail maksimal 255 karakter',
            'password.confirmed' => 'Password harus sama dengan password konfirmasi',

            'sign.required' => 'Tanda tangan wajib diisi',
        ]);

        if ($validator->fails()) {
            session()->flash('danger', '');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (isset($request->password)) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'sign' => $request->sign,
                'password' => bcrypt($request->password)
            ];
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'sign' => $request->sign,
            ];
        }

        User::where('id', $id)->update($data);

        session()->flash('info', 'Profil berhasil diupdate');

        return redirect()->back();
    }
}
