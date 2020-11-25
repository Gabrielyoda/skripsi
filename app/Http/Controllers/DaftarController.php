<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Admin;

class DaftarController extends Controller
{
    function index()
    {
        return view('daftaradmin');
    }

    function prosesdaftar(Request $request)
    {
        $this->validate($request, [
            'nim'       => 'required|min:10|max:10',
            'nama'      => 'required|min:3|max:50',
            'password'  => 'required|min:5|max:20',
            'cpassword' => 'required|same:password',
        ],[
            'nim.required'          => 'Kolom NIM harus diisi!',
            'nim.min'               => 'Kolom NIM minimal terdiri dari 10(sepuluh) karakter.',
            'nim.max'               => 'Kolom NIM maksimal terdiri dari 10(sepuluh) karakter.',
            'nama.required'         => 'Kolom Nama harus diisi!',
            'nama.min'              => 'Kolom Nama minimal terdiri dari 3(tiga) karakter.',
            'nama.max'              => 'Kolom Nama maksimal terdiri dari 50(lima puluh) karakter.',
            'password.required'     => 'Kolom Password harus diisi!',
            'password.min'          => 'Kolom Password minimal terdiri dari 5(lima) karakter.',
            'password.max'          => 'Kolom Password maksimal terdiri dari 50(lima puluh) karakter.',
            'cpassword.required'    => 'Kolom Konfirmasi Kata Sandi harus diisi!',
            'cpassword.same'        => 'Kolom Konfirmasi Kata Sandi harus sesuai dengan Kolom Kata Sandi.',
        ]);

        $nim        = $request->get('nim');
        $nama       = $request->get('nama');
        $password   = bcrypt($request->get('password'));

        $ceknim = Admin::find($nim);

        if($ceknim)
        {
            return back()->with('error', 'NIM telah terdaftar.');   
        }
        else
        {
            $admin   = new admin();
            $admin   -> nim_admin           = $nim;
            $admin   -> nama_admin          = $nama;
            $admin   -> password_admin      = $password;
            
            if($admin->save())
            {
                return redirect('/admin/login');
            }
        }
    }
}
