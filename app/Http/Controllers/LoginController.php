<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use App\Admin;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    function index()
    {
        return view('loginadmin');
    }

    function proseslogin(Request $request)
    {
        $this->validate($request, [
            'email'       => 'required',
            'password'  => 'required'
        ],[
            'email.required'      => 'Kolom email harus diisi!',
            'password.required' => 'Kolom Kata Sandi harus diisi!',
        ]);

        $email        = $request->get('email');
        $password   = $request->get('password');
        $credentials = $request->only('email', 'password');

        $jwt_token = null;
 
        // if (!$jwt_token = JWTAuth::attempt($credentials)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid email or Password',
        //     ], 401);
        // }
        
        $cekemail = User::where('email','=',$email)->first();
        if($cekemail)
        {
            $getpassword = User::select("password")->where('email','=',$email)->first();

            if(Hash::check($password,$getpassword->password))
            {

                $getdata = User::select('nama','id_user')->where('email','=',$email)->first();
                $id_user=$getdata['id_user'];
                $request->session() -> put('nim', $id_user);

                $record_user = User::find($request->session()->get('nim'));
                $jabatan = $record_user['jabatan'];
                $request->session() -> put('jabatan', $jabatan);

               

                if($jabatan == 'SPV') {
                    alert()->html('Login Berhasil', 'Berhasil Melakukan login ', 'success')->autoClose(10000);
                    return redirect('/admin/pilih');    

                }
                else {
                    // Jabatan != SPV
                    //alert()->html('Login Berhasil', 'Berhasil Melakukan login ', 'success')->autoClose(10000);
                    
                    $credentials = $request->only('email', 'password');
                    $request->session() -> put('token', $jwt_token);
                    Cache::forever('toke', $jwt_token);
                    Cache::forever('id_user', $id_user);
                    Cache::forever('jabatan', $jabatan);
                    return redirect('/homeuser');
                }
            }
            else
            {      
                return back()->with('error', 'Email atau Kata Sandi salah');
            }
        }
        else
        {
            return back()->with('error', 'Sudahkan Anda terdaftar?');
        }
    }
}
