@extends('layouts.admin')
@section('content')

{{-- notifikasi form validasi --}}
		@if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			<strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif
 
		{{-- notifikasi sukses --}}
		@if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button> 
			<strong>{{ $sukses }}</strong>
		</div>
		@endif

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Jadwal</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <a class="btn btn-info btn-lg w-300 mb-3 mt-1" href="{{ Route('tambahjadwal') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
                        <a class="btn btn-info btn-lg w-300 mb-3 mt-1 text-white" data-toggle="modal" data-target="#exampleModalFile"><i class="fa fa-edit fa-lg"></i>Import</a>
                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
                                    <th>Matakuliah</th>
                                    <th>Dosen</th>
									<th>Kelompok</th>
                                    <th>Ruang Lab</th>
                                    <th>Hari</th>
                                    <th>Jam Ajar</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($join as $joins)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>{{ $joins -> kd_mtk }} - {{ $joins -> nama_mtk }}</td>
                                    <td>{{ $joins -> nama }}</td>
                                    <td>{{ $joins -> kelompok }}</td>
                                    <td>{{ $joins -> nama_lab }}</td>
                                    <td>{{ $joins -> hari }}</td>
                                    <td>{{ $joins -> jam_ajar }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('ubahjadwal', $joins -> id_jadwal ) }}"><i class="fa fa-edit fa-lg"></i> Ubah Data</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapusjadwal', $joins -> id_jadwal ) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                        </div>
                                    </td>
                                </tr>
                                @php    
                                    $nomor++;
                                @endphp
                                @endforeach
							</tbody>
						</table>

                        <div class="modal fade " id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ Route('import') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Import Data Jadwal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                        <label>Pilih file excel</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="file" name="file" required="required">
                                        </div>
                                        
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" value="simpan">Import Data</button>
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
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

@endsection