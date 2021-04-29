@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Lab</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahlab') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $lab -> id_lab }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Nama Lab :</label>
                            <select class="form-control" name="namaLab" required>
                                @for($i = 1 ; $i <= 14 ; $i++)
                                    @if($i < 10)
                                        <option value="{{ 'Lab. Kom 0'.$i }}" {{ ('Lab. Kom 0'.$i == $lab -> nama_lab ) ? 'selected': '' }}>Lab. Kom {{ "0".$i }}</option>
                                    @else
                                        <option value="{{ 'Lab. Kom '.$i }}" {{ ('Lab. Kom 0'.$i == $lab -> nama_lab ) ? 'selected': '' }}>Lab. Kom {{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Spesifikasi :</label>
                            <input type="text" name="spesifikasi" class="form-control" value="{{ $lab -> spesifikasi}}" required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Kapasitas Maksimum :</label>
                            <input type="number" name="kapasitasLab" class="form-control" value="{{ $lab -> kapasitas_lab }}" required>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-edit fa-lg"></i> Ubah</button>
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