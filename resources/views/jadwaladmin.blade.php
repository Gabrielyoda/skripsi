@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Jadwal</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <a class="btn btn-info btn-lg w-100 mb-3 mt-1" href="{{ Route('tambahjadwal') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
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
                                    <td>{{ $joins -> nip_dosen }} - {{ $joins -> nama_dosen }}</td>
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
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection