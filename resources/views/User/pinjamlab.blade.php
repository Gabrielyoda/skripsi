@extends('layouts.user')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 m-3">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title text-center">Tambah Peminjaman Lab</h3>
                <hr>
                <div class="canvas-wrapper px-4">
                    <form action="{{ Route('prosestambahpinjamlabuser') }}" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="text-muted">Nama Lengkap :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-user-o"></i></div>
                                </div>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Nama / Judul Kegiatan :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-file-text-o"></i></div>
                                </div>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Keterangan Pinjam :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-sticky-note-o"></i></div>
                                </div>
                                <textarea class="form-control" name="keterangan" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Surat Peminjaman Laboratorium Komputer :</label>
                            <input type="file" name="surat" accept="image/*,.doc,.docx,.pdf" class="form-control-file" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="text-muted" for="fieldtanggal">Tanggal Penggunaan Lab :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fieldtanggal"><i class="fa fa-calendar-check-o"></i></label>
                                </div>
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
                            <label class="text-muted" for="tampilModalLabTersedia">Ruang Lab yang digunakan :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="tampilModalLabTersedia"><i class="fa fa-building-o"></i></label>
                                </div>
                                <input type="text" name="ruangLab" class="form-control text-dark" id="tampilModalLabTersedia" data-toggle="modal" data-target="#modalLabTersedia" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">E-Mail yang dapat dihubungi :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Butuh Asisten Pengawas?</label>
                            &nbsp; &nbsp;<input type="radio" name="asisten" id="ya" value="ya"><label for="ya">&nbsp;Ya</label> 
                            &nbsp; &nbsp;<input type="radio" name="asisten" id="tidak" value="tidak" checked><label for="tidak">&nbsp;Tidak</label>
                            
                            <div id="asisten_jaga">
                            </div>
                        </div>
                        <br><hr><br>
                        <div class="text-center">
                            <input type="hidden" name="lab" id="lab" readonly required>
                            <div class="btn-group">
                                <a href="{{ Route('jadwaluser') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                                <button type="submit" name="simpan" class="btn btn-info pt-3 pb-3 pl-5 pr-5">Simpan <i class="fa fa-save fa-lg"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lab Tersedia -->
<div class="modal fade" id="modalLabTersedia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Pilih Ruang Lab</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@endsection