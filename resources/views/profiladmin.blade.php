@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-7 col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Profil</h3>
                <button class="btn btn-subtle card-title-btn-container" type="button" data-toggle="modal" data-target="#exampleModalProfil"><i class="fa fa-gear fa-lg"></i></button>

                <!-- Modal Profil -->
                <div class="modal fade " id="exampleModalProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ Route('ubahprofil') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Ubah Profil</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label class="mt-2">NIM</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="text" class="form-control" value="{{ $profil-> nim }}" name="nim" required>
                                        </div>
                                        <!-- NIM YANG LAMA -->
                                        <input type="hidden" value="{{ $profil-> id_user }}" name="oldnim">

                                        <div class="col-md-3 form-group">
                                            <label>Nama Lengkap</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="text" class="form-control" value="{{ $profil-> nama }}" name="nama" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="mt-2">Jabatan</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="text" class="form-control" value="{{ $profil-> jabatan }}" name="jabatan" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="mt-2">No. Telepon</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="number" class="form-control" value="{{ $profil-> telepon }}" name="telp" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="mt-2">Email</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="email" class="form-control" value="{{ $profil-> email }}" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" value="simpan">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="canvas-wrapper">
                    <table cellpadding="10">
                        <tr>
                            <td><label>Nomor Induk Mahasiswa (NIM)</label></td>
                            <td><label>:</label></td>
                            <td><label>{{ $profil-> nim }}</label></td>
                        </tr>
                        <tr>
                            <td><label>Nama Lengkap</label></td>
                            <td><label>:</label></td>
                            <td><label>{{ $profil-> nama }}</label></td>
                        </tr>
                        <tr>
                            <td><label>Jabatan</label></td>
                            <td><label>:</label></td>
                            <td><label>{{ $profil-> jabatan }}</label></td>
                        </tr>
                        <tr>
                            <td><label>Nomor Telepon</label></td>
                            <td><label>:</label></td>
                            <td><label>{{ $profil-> telepon }}</label></td>
                        </tr>
                        <tr>
                            <td><label>Email</label></td>
                            <td><label>:</label></td>
                            <td><label>{{ $profil-> email }}</label></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection