@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Tambah Data Lab</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosestambahlab') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="text-muted">Nama Lab :</label>
                            <input type="text" name="namaLab" class="form-control" placeholder='Lab. Kom 01' required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Spesifikasi :</label>
                            <input type="text" name="spesifikasi" class="form-control" placeholder='PHP,Java,Mobile' required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Kapasitas Maksimum :</label>
                            <input type="number" name="kapasitasLab" class="form-control" required>
                        </div>
                        <div class="text-center">
                        <div class="btn-group">
                            <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-save fa-lg"></i> Simpan</button>
                            <a href="{{ Route('lab') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection