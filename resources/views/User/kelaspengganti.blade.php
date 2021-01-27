@extends('layouts.user')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 m-3">
        <div class="card">
            <div class="card-block">
                <h3 class="card-title text-center">Tambah Kuliah Pengganti</h3>
                <hr>
                <div class="canvas-wrapper px-4">
                    <form id='formkp' method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="text-muted">Mata Kuliah :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fa fa-book"></i></label>
                                </div>
                                <select class="form-control" name="namaMatkul" id="namaMatkul" required>
                                    <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                    @foreach ($matkul as $matkuls)
                                        <option value="{{ $matkuls -> id_mtk }}">{{ $matkuls -> kd_mtk }} - {{ $matkuls -> nama_mtk }} - {{ $matkuls -> sks_mtk." SKS" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="token" id="token" value="{{$token}}" readonly >
                        <input type="hidden" name="sks" id="jumlahSks" readonly >
                        <div class="form-group">
                            <label class="text-muted">Dosen Pengajar :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fa fa-user-circle-o"></i></label>
                                </div>
                                <select class="form-control" name="namaDosen" id="namaDosen" required>
                                    <option value="" disabled selected>-- Pilih Dosen Pengajar --</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="text-muted">Kelompok :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fa fa-users"></i></label>
                                </div>
                                <select class="form-control" name="kelompok" id="kelompok" required>
                                    <option value="" disabled selected>-- Pilih Kelompok --</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="text-muted" for="fieldtanggal">Tanggal Kuliah Pengganti :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fieldtanggal"><i class="fa fa-calendar-check-o"></i></label>
                                </div>
                                <input type="text" name="tanggalKP" id="fieldtanggal" class="form-control text-dark" readonly required>
                            </div>
                        </div>
                        <div class="text-center mb-2">
                            <button type="button" id="tampilModalJamAjar" class="btn btn-primary" data-toggle="modal" data-target="#modalJamAjar">-- Pilih Jam Ajar & Lab --</button>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Jam Ajar (Mulai - Selesai):</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fa fa-clock-o"></i></label>
                                </div>
                                <input type="text" name="jamAjar" id="fieldjam" class="form-control text-dark" readonly required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="text-muted">Ruang Lab :</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fa fa-building-o"></i></label>
                                </div>
                                <input type="hidden" name="idLab" id="fieldlab2" class="form-control text-dark" readonly required>
                                <input type="text" name="ruangLab" id="fieldlab" class="form-control text-dark" readonly required>
                            </div>
                        </div>
                        <br><hr><br>
                        <div class="text-center">
                            <div class="btn-group">
                                <a href="{{ Route('jadwaluser') }}" class="btn btn-secondary pt-3 pb-3 pr-5 pl-5"  style="color:black"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
                                <button type="submit" name="simpan" id="kelaspengganti" class="btn btn-info pt-3 pb-3 pl-5 pr-5">Simpan <i class="fa fa-save fa-lg"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Jam Ajar -->
<div class="modal fade" id="modalJamAjar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Pilih Jam Ajar dan Ruang Lab</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <table class="table table-bordered tabelUser text-center">
                    <tr class="isiHeaderJadwal"></tr>
                    <tbody class="isiJadwal border-0"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection