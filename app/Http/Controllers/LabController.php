<?php

namespace App\Http\Controllers;
use App\Lab;
use App\Admin;
use App\User;

use Illuminate\Http\Request;

class LabController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $lab  = Lab::all();

        return view('labadmin')
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        return view('tambahlab')
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function prosestambah(Request $request)
    {
        $nama       = $request->get('namaLab');
        $kapasitas  = $request->get('kapasitasLab');

        $lab    = new lab();
        
        $lab    -> nama_lab         = $nama;
        $lab    -> kapasitas_lab    = $kapasitas;

        if($lab->save())
        {
            alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Lab', 'success')->autoClose(10000);
            return redirect('/admin/lab');
        }
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $lab  = Lab::find($id);

        return view('ubahlab')
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $nama       = $request->get('namaLab');
        $kapasitas  = $request->get('kapasitasLab');

        $lab    = Lab::find($id);
        
        $lab    -> nama_lab         = $nama;
        $lab    -> kapasitas_lab    = $kapasitas;

        if($lab->save())
        {
            alert()->html('Berhasil Ubah Data', 'Berhasil Mengubah Data Lab', 'success')->autoClose(10000);
            return redirect('/admin/lab');
        }
    }

    function hapus(Request $request, $id)
    {
        $lab    = Lab::find($id);

        if($lab -> delete())
        {
            alert()->html('Berhasil Hapus Data', 'Berhasil Menghapus Data Jadwal', 'success')->autoClose(10000);
            return redirect('/admin/lab');
        }
    }
}
