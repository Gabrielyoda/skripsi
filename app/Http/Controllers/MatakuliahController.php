<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Matakuliah;
use App\User;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $mtk    = Matakuliah::all();

        return view('mtkadmin')
        ->with('mtk',$mtk)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Matakuliah');
    }

    function tambah(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        return view('tambahmtk')
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Matakuliah');
    }

    function prosestambah(Request $request)
    {
        $kodemtk    = $request->get('kdMtk');
        $namamtk    = $request->get('NmMtk');
        $sks        = $request->get('sks');

        $mtk    = new Matakuliah();
        
        $mtk    -> kd_mtk           = $kodemtk;
        $mtk    -> nama_mtk         = $namamtk;
        $mtk    -> sks_mtk          = $sks;

        if($mtk -> save())
        {
            alert()->html('Berhasil Tambah Data', 'Berhasil Menamkan Data Matakuliah', 'success')->autoClose(10000);
            return redirect('/admin/matakuliah');
        }
    }

    function ubah(Request $request, $id)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $mtk  = Matakuliah::find($id);
        
        return view('ubahmtk')
        ->with('mtk', $mtk)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Matakuliah');
    }
    
    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $kodemtk    = $request->get('kdMtk');
        $namamtk    = $request->get('NmMtk');
        $sks        = $request->get('sks');

        $mtk  = Matakuliah::find($id);
        
        $mtk    -> kd_mtk           = $kodemtk;
        $mtk    -> nama_mtk         = $namamtk;
        $mtk    -> sks_mtk          = $sks;

        if($mtk->save())
        {
            alert()->html('Berhasil Ubah Data', 'Berhasil Mengubah Data Matakuliah', 'success')->autoClose(10000);
            return redirect('/admin/matakuliah');
        }
    }

    function hapus(Request $request, $id)
    {
        $mtk    = Matakuliah::find($id);

        if($mtk -> delete())
        {
            alert()->html('Berhasil Hapus Data', 'Berhasil Menghapus Data Matakuliah', 'success')->autoClose(10000);
            return redirect('/admin/matakuliah');
        }
    }
}