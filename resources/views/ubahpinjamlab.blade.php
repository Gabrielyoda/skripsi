@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">Ubah Data Peminjaman Lab</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosesubahpinjamlab') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $pinjam -> id_pinjam }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Nama Lengkap :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="nama" class="form-control" value="{{ $pinjam -> nama_pinjam}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama / Judul Kegiatan :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="judul" class="form-control" value="{{ $pinjam -> judul_pinjam}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Keterangan Pinjam :</label>
                            <div class="input-group mb-2">
                                <textarea class="form-control" name="keterangan" rows="3" required>{{ $pinjam -> keterangan_pinjam}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted" for="fieldtanggal">Tanggal Penggunaan Lab :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="tanggal" id="fieldtanggal" class="form-control text-dark" readonly required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Jam Pinjam (Mulai):</label>
                                    
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="fa fa-clock-o"></i></label>
                                        </div>
                                        <select name="jamMulai" class="form-control" id="jamMulai">
                                            <option value="" selected disabled>-- Pilih Jam Mulai --</option>
                                            <option value="07:00">07:00</option>
                                            <option value="08:00">08:00</option>
                                            <option value="09:00">09:00</option>
                                            <option value="10:00">10:00</option>
                                            <option value="11:00">11:00</option>
                                            <option value="12:00">12:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="14:00">14:00</option>
                                            <option value="15:00">15:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Jam Pinjam (Selesai):</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="fa fa-clock-o"></i></label>
                                        </div>
                                        <select name="jamSelesai" class="form-control" id="jamSelesai">
                                            <option value="" selected disabled>-- Pilih Jam Selesai --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">E-Mail yang dapat dihubungi :</label>
                            <div class="input-group mb-2">
                                <input type="email" name="email" class="form-control" value="{{ $pinjam -> email_pinjam}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Ruang lab yang digunakan :</label>
                            <select class="form-control" name="lab" required>
                                @foreach ($lab as $labs)
                                    <option value="{{ $labs -> id_lab }}">{{ $labs -> nama_lab }} - {{ $labs -> kapasitas_lab." Mahasiswa" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-save fa-lg"></i> Simpan</button>
                                <a href="{{ Route('pinjamlab') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection