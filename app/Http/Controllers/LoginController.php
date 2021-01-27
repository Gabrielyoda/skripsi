<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use App\Admin;
use App\User;

class LoginController extends Controller
{
    function index()
    {
        return view('loginadmin');
    }

    function proseslogin(Request $request)
    {
        $this->validate($request, [
            'nim'       => 'required',
            'password'  => 'required'
        ],[
            'nim.required'      => 'Kolom NIM harus diisi!',
            'password.required' => 'Kolom Kata Sandi harus diisi!',
        ]);

        $nim        = $request->get('nim');
        $password   = $request->get('password');
        
        $ceknim = User::where('nim','=',$nim)->first();
        if($ceknim)
        {
            $getpassword = User::select("password")->where('nim','=',$nim)->first();

            if(Hash::check($password,$getpassword->password))
            {

                $getdata = User::select('nama','id_user')->where('nim','=',$nim)->first();
                $id_user=$getdata['id_user'];
                $request->session() -> put('nim', $id_user);

                $record_user = User::find($request->session()->get('nim'));
                $jabatan = $record_user['jabatan'];
                $request->session() -> put('jabatan', $jabatan);

                if($jabatan == 'SPV') {
                    return redirect('/admin/pilih');    

                }
                else {
                    // Jabatan != SPV
                    return redirect('/homeuser');
                }
            }
            else
            {      
                return back()->with('error', 'NIM atau Kata Sandi salah');
            }
        }
        else
        {
            return back()->with('error', 'Sudahkan Anda terdaftar?');
        }
    }
}
