<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/homeall');
});

// ADMIN
Route::group(['prefix'=>'/admin'], function() {
    Route::get('/daftar', 'DaftarController@index')->name('daftaradmin');
    Route::post('/daftar/prosesdaftaradmin', 'DaftarController@prosesdaftar')->name('prosesdaftaradmin');
    Route::get('/login', 'LoginController@index')->name('loginadmin');
    Route::post('/login/prosesloginadmin', 'LoginController@proseslogin')->name('prosesloginadmin');

    // Route::get('/pilih', 'AdminController@index')->name('ubahwaktu');
    // Route::post('/pilih/prosespilih', 'AdminController@tampil')->name('tampilwaktu');
    // Route::get('/logout', 'AdminController@logout')->name('logout');
    // Route::get('/home', 'AdminController@home')->name('home');

    Route::get('/pilih', 'UsersController@index')->name('ubahwaktu');
    Route::post('/pilih/prosespilih', 'UsersController@tampil')->name('tampilwaktu');
    Route::get('/logout', 'UsersController@logout')->name('logout');
    Route::get('/home', 'UsersController@home')->name('home');
    
    Route::get('/profil', 'ProfilAdminController@index')->name('profil');
    Route::post('/profil/prosesubahprofil', 'ProfilAdminController@ubahprofil')->name('ubahprofil');
   
    Route::get('/users', 'UsersController@tampilusers')->name('users');
    Route::get('/users/tambah', 'UsersController@tambah')->name('tambahusers');
    Route::post('/users/prosestambah', 'UsersController@prosestambah')->name('prosestambahusers');
    Route::get('/users/ubah/{nim}', 'UsersController@ubah')->name('ubahusers');
    Route::post('/users/prosesubah', 'UsersController@prosesubah')->name('prosesubahusers');
    Route::get('/users/hapus/{nim}', 'UsersController@hapus')->name('hapususers');
    

    Route::get('/waktu', 'WaktuController@index')->name('waktu');

    Route::post('/tahunajaran/tambahtahun', 'WaktuController@tambahtahun')->name('tambahtahun');
    Route::get('/tahunajaran/hapustahun/{id_tahunajaran}', 'WaktuController@hapustahun')->name('hapustahun');
    Route::get('/tahunajaran/aktiftahun/{id_tahunajaran}', 'WaktuController@aktifkantahun')->name('aktifkantahun');
    
    Route::post('/semester/tambahsemester', 'WaktuController@tambahsemester')->name('tambahsemester');
    Route::get('/semester/hapussemester/{id_semester}', 'WaktuController@hapussemester')->name('hapussemester');
    Route::get('/semester/aktifsemester/{id_semester}', 'WaktuController@aktifkansemester')->name('aktifkansemester');
    
    Route::get('/matakuliah', 'MatakuliahController@index')->name('mtk');
    Route::get('/matakuliah/tambah', 'MatakuliahController@tambah')->name('tambahmtk');
    Route::post('/matakuliah/prosestambah', 'MatakuliahController@prosestambah')->name('prosestambahmtk');
    Route::get('/matakuliah/ubah/{id_mtk}', 'MatakuliahController@ubah')->name('ubahmtk');
    Route::post('/matakuliah/prosesubah', 'MatakuliahController@prosesubah')->name('prosesubahmtk');
    Route::get('/matakuliah/hapus/{id_mtk}', 'MatakuliahController@hapus')->name('hapusmtk');

    Route::get('/lab', 'LabController@index')->name('lab');
    Route::get('/lab/tambah', 'LabController@tambah')->name('tambahlab');
    Route::post('/lab/prosestambah', 'LabController@prosestambah')->name('prosestambahlab');
    Route::get('/lab/ubah/{id_lab}', 'LabController@ubah')->name('ubahlab');
    Route::post('/lab/prosesubah', 'LabController@prosesubah')->name('prosesubahlab');
    Route::get('/lab/hapus/{id_lab}', 'LabController@hapus')->name('hapuslab');

    Route::get('/software', 'SoftwareController@index')->name('software');
    Route::get('/software/tambah', 'SoftwareController@tambah')->name('tambahsoftware');
    Route::post('/software/prosestambah', 'SoftwareController@prosestambah')->name('prosestambahsoftware');
    Route::get('/software/ubah/{id_software}', 'SoftwareController@ubah')->name('ubahsoftware');
    Route::post('/software/prosesubah', 'SoftwareController@prosesubah')->name('prosesubahsoftware');
    Route::get('/software/hapus/{id_software}', 'SoftwareController@hapus')->name('hapussoftware');

    Route::get('/dosen', 'DosenController@index')->name('dosen');
    Route::get('/dosen/tambah', 'DosenController@tambah')->name('tambahdosen');
    Route::post('/dosen/prosestambah', 'DosenController@prosestambah')->name('prosestambahdosen');
    Route::get('/dosen/ubah/{id_dosen}', 'DosenController@ubah')->name('ubahdosen');
    Route::post('/dosen/prosesubah', 'DosenController@prosesubah')->name('prosesubahdosen');
    Route::get('/dosen/hapus/{id_dosen}', 'DosenController@hapus')->name('hapusdosen');


    Route::get('/jadwal', 'JadwalController@index')->name('jadwal');
    Route::get('/jadwal/tambah', 'JadwalController@tambah')->name('tambahjadwal');
    Route::post('/jadwal/prosestambah', 'JadwalController@prosestambah')->name('prosestambahjadwal');
    Route::get('/jadwal/ubah/{id_jadwal}', 'JadwalController@ubah')->name('ubahjadwal');
    Route::post('/jadwal/prosesubah', 'JadwalController@prosesubah')->name('prosesubahjadwal');
    Route::get('/jadwal/hapus/{id_jadwal}', 'JadwalController@hapus')->name('hapusjadwal');
    
    
    Route::post('/jadwal/sks', 'JadwalController@ceksks');

    Route::get('/kelaspengganti', 'PenggantiController@index')->name('kelaspengganti');
    Route::get('/kelaspengganti/tambah', 'PenggantiController@tambah')->name('tambahkelaspengganti');
    Route::post('/kelaspengganti/prosestambah', 'PenggantiController@prosestambah')->name('prosestambahkelaspengganti');
    Route::get('/kelaspengganti/ubah/{id_jadwal}', 'PenggantiController@ubah')->name('ubahkelaspengganti');
    Route::post('/kelaspengganti/prosesubah', 'PenggantiController@prosesubah')->name('prosesubahkelaspengganti');
    Route::get('/kelaspengganti/hapus/{id_jadwal}', 'PenggantiController@hapus')->name('hapuskelaspengganti');

    Route::get('/pinjamlab', 'PinjamLabController@index')->name('pinjamlab');
    Route::get('/pinjamlab/tambah', 'PinjamLabController@tambah')->name('tambahpinjamlab');
    Route::post('/pinjamlab/prosestambah', 'PinjamLabController@prosestambah')->name('prosestambahpinjamlab');
    Route::get('/pinjamlab/ubah/{id_pinjam}', 'PinjamLabController@ubah')->name('ubahpinjamlab');
    Route::post('/pinjamlab/prosesubah', 'PinjamLabController@prosesubah')->name('prosesubahpinjamlab');
    Route::get('/pinjamlab/hapus/{id_pinjam}', 'PinjamLabController@hapus')->name('hapuspinjamlab');

    Route::get('/spesifikasi', 'SpesifikasiController@index')->name('spek');
    Route::post('/spesifikasi/prosessimpan', 'SpesifikasiController@prosessimpan')->name('prosessimpanspesifikasi');
});

// USER
Route::get('/homeuser', 'User\JadwalUserController@index2')->name('jadwaluser');
Route::get('/homeall', 'User\JadwalUserController@index')->name('jadwalall');
Route::post('/home/waktu', 'User\JadwalUserController@gantiwaktu');

Route::get('/kuliahpengganti', 'User\JadwalUserController@kelaspengganti')->name('kpuser');
Route::post('/kuliahpengganti/prosestambah', 'User\JadwalUserController@prosestambah')->name('prosestambahkpuser');

Route::get('/peminjamanlab', 'User\PinjamLabUserController@index')->name('pinjamlabuser');
Route::post('/peminjamanlab/prosestambah', 'User\PinjamLabUserController@prosestambah')->name('prosestambahpinjamlabuser');

Route::get('/tampiljadwal', 'User\TampilJadwalController@index')->name('tampiljadwal');

// AJAX
Route::post('/kuliahpengganti/dosen', 'User\JadwalUserController@caridosen');
Route::post('/kuliahpengganti/kelompok', 'User\JadwalUserController@carikelompok');
Route::post('/kuliahpengganti/jamajar', 'User\JadwalUserController@carijamajar');

Route::post('/software/getData', 'User\PinjamLabUserController@getDataSoftware');

Route::post('/lab/getData', 'User\PinjamLabUserController@getDataLab');

Route::post('/spesifikasi/getData', 'User\PinjamLabUserController@getDataSpesifikasi');