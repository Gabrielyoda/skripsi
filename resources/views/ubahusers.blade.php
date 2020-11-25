@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Users</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahusers') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="oldnim" value="{{ $users -> nim }}" hidden>
                        
                        <div class="form-group">
                            <label class="text-muted">NIM :</label>
                            <input type="text" name="nim" class="form-control" value="{{ $users -> nim }}">
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama :</label>
                            <input type="text" name="nama" class="form-control" value="{{ $users -> nama }}" required>
                        </div>

                        <div class="form-group">
                            <label class="text-muted">Telepon :</label>
                            <input type="number" name="telepon" class="form-control" value="{{ $users -> telepon }}" required>
                        </div>

                        <div class="form-group">
                            <label class="text-muted">Email :</label>
                            <input type="email" name="email" class="form-control" value="{{ $users -> email }}" required>
                        </div>

                        <div class="form-group">
                            <label class="text-muted">Jabatan :</label>
                                <select class="form-control" name="jabatan"  required>
                                    <option value="SPV">SPV</option>
                                    <option value="Asisten">Asisten</option>
                                </select>
                        </div>

                        <div class="form-group">
                            <label class="text-muted">Password :</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-edit fa-lg"></i> Ubah</button>
                                <a href="{{ Route('users') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection