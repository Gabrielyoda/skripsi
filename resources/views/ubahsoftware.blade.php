@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Software</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahsoftware') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $software -> id_software }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Nama Software :</label>
                            <input type="text" name="namaSW" class="form-control" value="{{ $software -> nama_software }}" required>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-edit fa-lg"></i> Ubah</button>
                                <a href="{{ Route('software') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection