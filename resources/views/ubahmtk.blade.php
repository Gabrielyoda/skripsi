@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Matakuliah</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahmtk') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $mtk -> id_mtk }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Kode Matakuliah :</label>
                            <input type="text" name="kdMtk" class="form-control" value="{{ $mtk -> kd_mtk }}" required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama Matakuliah :</label>
                            <input type="text" name="NmMtk" class="form-control" value="{{ $mtk -> nama_mtk }}" required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">SKS :</label>
                            <input type="number" name="sks" class="form-control" value="{{ $mtk -> sks_mtk }}" required>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-save fa-lg"></i> Simpan</button>
                                <a href="{{ Route('mtk') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection