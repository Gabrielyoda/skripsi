<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\TahunAjaran;
use App\Semester;

class UsersController extends Controller
{
    //ini untuk mengubah waktu
    function index(Request $request)
    {
        $users          = User::find($request->session()->get('nim'));
        $tahunajaran    = TahunAjaran::orderBy('tahunajaran', 'ASC')->get();
        $semester       = Semester::orderBy('semester', 'ASC')->get();
        
        if($request->session()->get('semester') && $request->session()->get('tahunajaran') != null)
        {
            $nama   = $users -> nama;
            
            return view('opsiadmin')
            ->with('tahunajaran',$tahunajaran)
            ->with('semester',$semester)
            ->with('nama',$nama)
            ->with('datasemester', $request->session()->get('semester'))
            ->with('datatahunajar', $request->session()->get('tahunajaran'));
        }
        else
        {
            $nama   = $users -> nama;

            return view('opsiadmin')
            ->with('tahunajaran',$tahunajaran)
            ->with('semester',$semester)
            ->with('nama',$nama)
            ->with('datasemester', null)
            ->with('datatahunajar', null);
        }
    }

    //ini untuk setelah login
    function tampil(Request $request)
    {
        $request->session() -> put('semester', $request->get('smt'));
        $request->session() -> put('tahunajaran', $request->get('thnajar'));

        return redirect ('/admin/home');
    }
    
    //ini untuk dashboard
    function home(Request $request)
    {
        $users  = User::find($request->session()->get('nim'));

        $nama   = $users -> nama;
        

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->get();

        return view('homeadmin')
        ->with('join',$join)
        ->with('nama',$nama)
        ->with('semester',$request->session()->get('semester'))
        ->with('tahunajaran',$request->session()->get('tahunajaran'))
        ->with('title', 'Dashboard');
    }

    //tampil semua user
    function tampilusers(Request $request)
    {
        $users = User::find($request->session()->get('nim'));

        $nama = $users -> nama;

        $user  = User::all();

        return view('usersadmin')
        ->with('user', $user)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Users');
    }

    //halaman users
    function tambah(Request $request)
    { 
        $users = User::find($request->session()->get('nim'));

        $nama = $users -> nama;
        

        return view('tambahusers')
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Users');
    }

    //ini untuk tambah ke db
    function prosestambah(Request $request)
    {
        $nim    = $request->get('nim');
        $nama   = $request->get('nama');
        $telepon   = $request->get('telepon');
        $email   = $request->get('email');
        $jabatan   = $request->get('jabatan');
        $password   = bcrypt($request->get('password'));

        $ceknim = User::find($nim);

        if($ceknim)
        {
            return back()->with('error', 'NIM telah terdaftar.');   
        }
        else{
            $users    = new User();
            $users    -> nim       = $nim;
            $users    -> nama      = $nama;
            $users    -> telepon   = $telepon;
            $users    -> email     = $email;
            $users    -> jabatan   = $jabatan;
            $users    -> password   = $password;
    
            if($users->save())
            {
                alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Users', 'success')->autoClose(10000);
                return redirect('/admin/users');
            }
        }
        
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $Users  = User::find($id);

        return view('ubahusers')
        ->with('users', $Users)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Users');
    }

    function prosesubah(Request $request)
    {
        $oldnim     = $request->get('oldnim');
        $nim        = $request->get('nim');
        $nama       = $request->get('nama');
        $jabatan    = $request->get('jabatan');
        $telepon    = $request->get('telepon');
        $email      = $request->get('email');
        $password   = bcrypt($request->get('password'));

        $users  =  User::find($oldnim);
        $users  -> nim       = $nim;
        $users  -> nama      = $nama;
        $users  -> jabatan   = $jabatan;
        $users  -> telepon   = $telepon;
        $users  -> email     = $email;
        $users   -> password   = $password;
        
        if($users->save())
            {
                alert()->html('Berhasil Update Data', 'Berhasil Update Data Users', 'success')->autoClose(10000);
                return redirect('/admin/users');
            }
    }

    function hapus(Request $request, $id)
    {
        $users    = User::find($id);

        if($users -> delete())
        {
            alert()->html('Data Berhasil Dihapus', 'Berhasil Menghapus Data Users', 'success')->autoClose(10000);
            return redirect('/admin/users');
        }
    }

    function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/admin/login');
    }
}
