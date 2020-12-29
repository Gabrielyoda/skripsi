@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Asisten</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <a class="btn btn-info btn-lg w-100 mb-3 mt-1" href="{{ Route('tambahusers') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
                                    <th>Nim</th>
									<th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($user as $users)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>{{ $users -> nim }}</td>
                                    <td>{{ $users -> nama }}</td>
                                    <td>{{ $users -> telepon }}</td>
                                    <td>{{ $users -> email }}</td>
                                    <td>{{ $users -> jabatan }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('ubahusers', $users->id_user ) }}"><i class="fa fa-edit fa-lg"></i> Ubah Data</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapususers', $users->id_user ) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
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