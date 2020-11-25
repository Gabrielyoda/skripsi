@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Matakuliah</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <a class="btn btn-info btn-lg w-100 mb-3 mt-1" href="{{ Route('tambahmtk') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
                    </div>
                    <div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
									<th>Kode Matakuliah</th>
									<th>Nama Matakuliah</th>
                                    <th>SKS</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($mtk as $matkul)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>{{ $matkul -> kd_mtk }}</td>
                                    <td>{{ $matkul -> nama_mtk }}</td>
                                    <td>{{ $matkul -> sks_mtk }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('ubahmtk', $matkul->id_mtk ) }}"><i class="fa fa-edit fa-lg"></i> Ubah Data</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapusmtk', $matkul->id_mtk ) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
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