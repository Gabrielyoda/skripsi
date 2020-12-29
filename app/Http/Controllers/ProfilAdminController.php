<?php

namespace App\Http\Controllers;
use App\Admin;
use App\User;

use Illuminate\Http\Request;

class ProfilAdminController extends Controller
{
    function index(Request $request)
    {
        $profil = User::find($request->session()->get('nim'));
       

        $nama  =  $profil -> nama;

        return view('profiladmin')
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('profil', $profil)
        ->with('title', 'Profil');
    }

    function ubahprofil(Request $request)
    {
        $oldnim     = $request->get('oldnim');
        $nim        = $request->get('nim');
        $nama       = $request->get('nama');
        $jabatan    = $request->get('jabatan');
        $telepon    = $request->get('telp');
        $email      = $request->get('email');
        
        $admin  =  User::find($oldnim);
        $admin  -> nim       = $nim;
        $admin  -> nama      = $nama;
        $admin  -> jabatan   = $jabatan;
        $admin  -> telepon   = $telepon;
        $admin  -> email     = $email;
            
        if($admin->save())
        {
            alert()->html('Berhasil Update Data', 'Berhasil Memperbarui Data Profile', 'success')->autoClose(10000);
            $request->session() -> put('nim', $oldnim);
            return redirect('/admin/profil');
        }
    }

    
}
