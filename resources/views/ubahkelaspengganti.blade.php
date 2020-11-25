@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Jadwal Kuliah Pengganti</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahkelaspengganti') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $kp -> id_kp }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Matakuliah :</label>
                            <select class="form-control" name="namaMatkul" id="namaMatkul" required>
                                @foreach ($matkul as $matkuls)
                                    <option value="{{ $matkuls -> id_mtk }}" {{ ( $matkuls -> id_mtk == $kp-> id_mtk ) ? 'selected': '' }}>{{ $matkuls -> kd_mtk }} - {{ $matkuls -> nama_mtk }} - {{ $matkuls -> sks_mtk." SKS" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Dosen Pengajar :</label>
                            <select class="form-control" name="namaDosen" id="namaDosen" required>
                                <option value="{{ $kp -> id_dosen }}">{{ $kp -> nip_dosen }} - {{ $kp -> nama_dosen }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Kelompok :</label>
                            <select class="form-control" name="kelompok" id="kelompok" required>
                                <option value="{{ $kp -> kelompok }}">{{ $kp -> kelompok }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama Lab :</label>
                            <select class="form-control" name="namaLab" required>
                                @foreach ($lab as $labs)
                                    <option value="{{ $labs -> id_lab }}" {{ ( $labs -> id_lab == $kp-> id_lab ) ? 'selected': '' }}>{{ $labs -> nama_lab }} - {{ $labs -> kapasitas_lab." Mahasiswa" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Tanggal Kelas Pengganti :</label>
                            <input type="text" name="tanggalKP" class="form-control" id="fieldtanggal" value="{{ $tanggal }}" required>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Jam Ajar :</label>
                            <div id="isiotomatis">
                                @php
                                    if(is_array($jamAjar))
                                    {     
                                @endphp
                                        <select class="form-control" name="jamAjar" id="jamAjar" required>
                                            
                                                @foreach ($jamAjar as $jamAjars)
                                                    <option value="{{ $jamAjars }}"{{ ($jamAjars == $kp -> jam_pengganti) ? 'selected' : '' }}>{{ $jamAjars }}</option>
                                                @endforeach
                                        </select>
                                @php
                                    }
                                @endphp
                            </div>
                            <div id="isimanual">
                                @php
                                    if(!is_array($jamAjar))
                                    {   
                                @endphp
                                        <input type="text" name="jamAjar" value="{{ $kp -> jam_pengganti }}" class="form-control" placeholder="Jam Masuk - Jam Keluar     contoh: 12:30 - 16:05" required>
                                @php
                                    }
                                @endphp
                            </div>
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