<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
use App\Admin;
use App\User;

class DosenController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $dosen  = Dosen::all();

        return view('dosenadmin')
        ->with('dosen', $dosen)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;
        
        return view('tambahdosen')
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function prosestambah(Request $request)
    {
        $username    = $request->get('usernameDosen');
        $nama   = $request->get('namaDosen');
        $password   = bcrypt($request->get('passwordDosen'));

        $dosen    = new dosen();
        
        if(!empty($username))
        {
            $dosen    -> username_dosen       = $username;
        }
        $dosen    -> nama_dosen       = $nama;
        $dosen    -> password_dosen       = $password;

        if($dosen->save())
        {
            alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Dosen', 'success')->autoClose(10000);
            return redirect('/admin/dosen');
        }
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $dosen  = Dosen::find($id);

        return view('ubahdosen')
        ->with('dosen', $dosen)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $username   = $request->get('usernameDosen');
        $nama       = $request->get('namaDosen');
        $password   = bcrypt($request->get('passwordDosen'));

        $dosen    = Dosen::find($id);
        
        if(!empty($username))
        {
            $dosen    -> username_dosen        = $username;
        }
        $dosen    -> nama_dosen       = $nama;
        $dosen    -> password_dosen       = $password;

        if($dosen->save())
        {
            alert()->html('Berhasil Ubah Data', 'Berhasil Mengubah Data Dosen', 'success')->autoClose(10000);
            return redirect('/admin/dosen');
        }
    }

    function hapus(Request $request, $id)
    {
        $dosen    = Dosen::find($id);

        if($dosen -> delete())
        {
            alert()->html('Data Berhasil Dihapus', 'Berhasil Menghapus Data Dosen', 'success')->autoClose(10000);
            return redirect('/admin/dosen');
        }
    }
}
