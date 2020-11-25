@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Tambah Data Jadwal Kuliah Pengganti</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosestambahkelaspengganti') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="text-muted">Matakuliah :</label>
                            <select class="form-control" name="namaMatkul" id="namaMatkulKP" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach ($matkul as $matkuls)
                                    <option value="{{ $matkuls -> id_mtk }}">{{ $matkuls -> kd_mtk }} - {{ $matkuls -> nama_mtk }} - {{ $matkuls -> sks_mtk." SKS" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Dosen Pengajar :</label>
                            <select class="form-control" name="namaDosen" id="namaDosenKP" required>
                                <option value="" disabled selected>-- Pilih Dosen Pengajar --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Kelompok :</label>
                            <select class="form-control" name="kelompok" id="kelompok" required>
                                <option value="" disabled selected>-- Pilih Kelompok --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama Lab :</label>
                            <select class="form-control" name="namaLab" required>
                                @foreach ($lab as $labs)
                                    <option value="{{ $labs -> id_lab }}">{{ $labs -> nama_lab }} - {{ $labs -> kapasitas_lab." Mahasiswa" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Tanggal Kelas Pengganti :</label>
                            <input type="text" name="tanggalKP" class="form-control" id="fieldtanggal" required>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Jam Ajar :</label>
                            <div id="isiotomatis">
                                <select class="form-control" name="jamAjar" id="jamAjar" required>
                                    <option value="0">-- Pilih Jam Ajar --</option>
                                </select>
                            </div>
                            <div id="isimanual"></div>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-save fa-lg"></i> Simpan</button>
                                <a href="{{ Route('kelaspengganti') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection