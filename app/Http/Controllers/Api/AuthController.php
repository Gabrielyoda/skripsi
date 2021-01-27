<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterFormRequest;
use App\Aes256\Prosesaes;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use App\Http\Controllers\Controller;
 
class AuthController extends Controller
{
     public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:255|unique:users',
            'nama' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $users = new User();
        $users->nama = $request->nama;
        $users->nim = $request->nim;
        $users->password = bcrypt($request->password);
        $users->save();
        $users = User::first();
        $token = JWTAuth::fromUser($users);

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $input = $request->only('email', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Nim or Password',
            ], 401);
        }

        //untuk get 1 record pake first
        // $user = User::where('nim', $request->input('nim'))->first();
        $user = User::select('id_user', 'nama','telepon','email','jabatan')->where('email', $request->input('email'))->first();

        

        
        return response()->json([
            'success' => true,
            'message' => "Berhasil Login",
            'data' => 
            [
                "id_user" => $user->id_user,
                "nama" => $user->nama,
                "telepon" => $user->telepon,
                "email" => $user->email,
                "jabatan" => $user->jabatan,
                'token' => $jwt_token
                              
             ],
        ]);
    }
 
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
 
    public function getAuthUser(Request $request)
    {
        $admins = JWTAuth::authenticate($request->token);
 
        return response()->json(['admins' => $admins]);
    }

    function dekripsi($plaintext){
        $inputText = $plaintext;
        $inputKey = "abcdefghijuklmno0123456789012345";
        $blockSize = 256;
        $aes = new Prosesaes($inputText, $inputKey, $blockSize);
        $aes->setData($inputText);
        $dec=$aes->decrypt();

        return $dec;
    }

    
}