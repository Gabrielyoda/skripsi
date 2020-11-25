<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spesifikasi;
use App\Software;
use App\Lab;
use App\Admin;

class SpesifikasiController extends Controller
{
    function index(Request $request)
    {
        $admin  = Admin::find($request->session()->get('nim'));

        $nama   = $admin -> nama_admin;
        $foto   = $admin -> foto_admin;

        $lab        = Lab::all();
        $software   = Software::all();
        $spek       = Spesifikasi::all();

        return view('spesifikasiadmin')
        ->with('lab', $lab)
        ->with('software', $software)
        ->with('spek', $spek)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Spesifikasi Lab');
    }

    function prosessimpan(Request $request)
    {
        $getSoftware   = $request->get('software');

        if($getSoftware != null) {
            for($i = 0 ; $i < count($getSoftware) ; $i++) {

                $spesifikasi    = new Spesifikasi();

                $pisah  = explode("-",$getSoftware[$i]);

                $spesifikasi    -> id_lab       = $pisah[0];
                $spesifikasi    -> id_software  = $pisah[1];

                if($i == 0) {
                    $hapusDataLama  = Spesifikasi::where('id_lab',$pisah[0])->where('id_software', '!=', 0)->delete();
                }

                $spesifikasi->save();
            }

            return redirect('/admin/spesifikasi');
        }
        else {
            if(!empty($request->get('lab')) || $request->get('lab') == 0) {

                $lab =  $request->get('lab');
                $hapusDataLama  = Spesifikasi::where('id_lab',$lab)->where('id_software', '!=', 0)->delete();

                return redirect('/admin/spesifikasi');
            }
            else {
                return redirect('/admin/spesifikasi');
            }
        }
    }
}
