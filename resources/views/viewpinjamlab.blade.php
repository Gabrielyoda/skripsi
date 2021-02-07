@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title">View Data Peminjaman Lab</h3>
                <hr>
                <div class="canvas-wrapper">
                    <form action="{{ Route('prosessetujupinjamlab') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $pinjam -> id_pinjam }}" hidden>
                        <div class="form-group">
                            <label class="text-muted">Nama Lengkap :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="nama" class="form-control" value="{{ $pinjam -> nama_pinjam}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama / Judul Kegiatan :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="judul" class="form-control" value="{{ $pinjam -> judul_pinjam}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Keterangan Pinjam :</label>
                            <div class="input-group mb-2">
                                <textarea class="form-control" name="keterangan" rows="3" readonly>{{ $pinjam -> keterangan_pinjam}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted" for="fieldtanggal">Tanggal Penggunaan Lab :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="tanggal"  value="{{ $pinjam->tanggal_pinjam }}" class="form-control text-dark" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted" for="fieldtanggal">Jam Penggunaan Lab :</label>
                            <div class="input-group mb-2">
                                <input type="text" name="tanggal"  value="{{ $pinjam->jam_pinjam }}" class="form-control text-dark" readonly readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">E-Mail yang dapat dihubungi :</label>
                            <div class="input-group mb-2">
                                <input type="email" name="email" class="form-control" value="{{ $pinjam -> email_pinjam}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">No Telepon :</label>
                            <div class="input-group mb-2">
                                <input type="number" name="nohp" class="form-control" value="{{ $pinjam -> nohp}}" readonly>
                                <input type="hidden" name="id_user" id="id_user" value="{{$id_user}}" readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Ruang lab yang digunakan :</label>
                            <select class="form-control" name="lab" required>
                                @foreach ($lab as $labs)
                                    <option value="{{$labs}}">{{$labs}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-muted">Pesan Kepada Peminjam :</label>
                            <div class="input-group mb-2">
                                <textarea class="form-control" name="comment" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5"><i class="fa fa-save fa-lg"></i> Setuju</button>
                                <button type="button" name="tolak" class="btn btn-danger pt-3 pb-3 pl-5 pr-5"  data-toggle="modal" data-target="#exampleModalTolak"><i class="fa fa-times fa-lg"></i> Tolak</button>
                                 <!-- <a href="{{ Route('pinjamlab') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a> -->
                            </div>
                        </div>
                    </form>

                    <div class="modal fade " id="exampleModalTolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ Route('tolakpinjamlab') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Menolak Peminjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label class="text-muted">Pesan Kepada Peminjam :</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <textarea class="form-control" name="comment" rows="3" required></textarea>
                                        </div>
                                        <!-- NIM YANG LAMA -->
                                        <input type="hidden" value="{{ $pinjam -> id_pinjam }}" name="id">
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" value="simpan">Tolak Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection