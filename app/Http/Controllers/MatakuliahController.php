<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Matakuliah;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    function index(Request $request)
    {
        $profil = Admin::find($request->session()->get('nim'));

        $foto  =  $profil -> foto_admin;
        $nama  =  $profil -> nama_admin;

        $mtk    = Matakuliah::all();

        return view('mtkadmin')
        ->with('mtk',$mtk)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Matakuliah');
    }

    function tambah(Request $request)
    {
        $profil = Admin::find($request->session()->get('nim'));

        $foto  = $profil -> foto_admin;
        $nama  = $profil -> nama_admin;

        return view('tambahmtk')
        ->with('nama', $nama)
        ->with('foto', $foto)
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
            return redirect('/admin/matakuliah');
        }
    }

    function ubah(Request $request, $id)
    {
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $mtk  = Matakuliah::find($id);
        
        return view('ubahmtk')
        ->with('mtk', $mtk)
        ->with('nama', $nama)
        ->with('foto', $foto)
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
            return redirect('/admin/matakuliah');
        }
    }

    function hapus(Request $request, $id)
    {
        $mtk    = Matakuliah::find($id);

        if($mtk -> delete())
        {
            return redirect('/admin/matakuliah');
        }
    }
}