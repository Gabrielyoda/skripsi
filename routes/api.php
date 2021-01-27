<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::get('jadwal/lab', 'Api\ApiJadwalController@Lab');

Route::get('pinjam', 'Api\ApiPinjamController@pinjam');
Route::get('jadwal/matkul', 'Api\ApiJadwalController@matkul');
Route::get('jadwal/matkuldosen', 'Api\ApiJadwalController@carimatkul');
Route::get('jadwal/dosen', 'Api\ApiJadwalController@caridosen');
Route::get('jadwal/kelompok', 'Api\ApiJadwalController@carikelompok');
Route::get('jadwal/jam', 'Api\ApiJadwalController@cek_jam');


Route::group(['middleware' => 'auth.jwt'], function () {
Route::get('logout', 'Api\AuthController@logout');
Route::get('user', 'Api\AuthController@getAuthUser');

//jadwal

Route::get('jadwal/hari-ini', 'Api\ApiJadwalController@jadwal');
Route::get('jadwal/jam-sekarang', 'Api\ApiJadwalController@jadwalJam');

Route::post('jadwal/tambahkp', 'Api\ApiJadwalController@tambahkp')->name('test12345');
Route::post('jadwal/tambahkpweb', 'Api\ApiJadwalController@tambahkpweb');
Route::post('pinjam/tambah', 'Api\ApiPinjamController@prosestambah');
Route::post('pinjam/tambahweb', 'Api\ApiPinjamController@prosestambahweb');
Route::get('pinjam/lihat', 'Api\ApiPinjamController@lihatpeminjaman');

Route::resource('posts', 'Api\PostController');
});

Route::group(['middleware' => ['web']], function () {
    
});