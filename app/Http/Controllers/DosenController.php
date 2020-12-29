<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dosen;
use App\Admin;
use App\User;

class DosenController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $dosen   = User::all();
        $dosen   = DB::table('users')
                    ->select('id_user','nama','email')
                    ->where('jabatan','=', 'Dosen')
                    ->get();

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
       
        $nama        = $request->get('namaDosen');
        $email    = $request->get('emailDosen');
        $password    = bcrypt($request->get('passwordDosen'));
        $jabatan     = "Dosen";
        

        
        $cek        = User::where('email','=',$email)->first();
                      
                       

        if($cek)
        {
            alert()->html('Gagal Tambah data', 'Email telah terdaftar.', 'error')->autoClose(10000);
            return back()->with('error', 'nim telah terdaftar.');   
        }
        else{
            $dosen    = new User();
            $dosen    -> email      = $email;
            $dosen    -> nama       = $nama;
            $dosen    -> jabatan    = $jabatan;
            $dosen    -> password   = $password;
    
            if($dosen->save())
            {
                alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Dosen', 'success')->autoClose(10000);
                return redirect('/admin/dosen');
            }
        }
        
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $dosen  = User::find($id);

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
        $email   = $request->get('emailDosen');
        $nama       = $request->get('namaDosen');
        $password   = bcrypt($request->get('passwordDosen'));

        $dosen    = User::find($id);
        
        $dosen    -> email        = $email;
        $dosen    -> nama         = $nama;
        $dosen    -> password     = $password;

        if($dosen->save())
        {
            alert()->html('Berhasil Ubah Data', 'Berhasil Mengubah Data Dosen', 'success')->autoClose(10000);
            return redirect('/admin/dosen');
        }
    }

    function hapus(Request $request, $id)
    {
        $dosen    = User::find($id);

        if($dosen -> delete())
        {
            alert()->html('Data Berhasil Dihapus', 'Berhasil Menghapus Data Dosen', 'success')->autoClose(10000);
            return redirect('/admin/dosen');
        }
    }
}
