@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Software</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <a class="btn btn-info btn-lg w-100 mb-3 mt-1" href="{{ Route('tambahsoftware') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Software</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($software as $softwares)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>
                                        {{ $softwares -> nama_software }}
                                        @if($softwares -> id_software == 0)
                                            <small><small class="text-danger">*software wajib</small></small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('ubahsoftware', $softwares->id_software ) }}"><i class="fa fa-edit fa-lg"></i> Ubah Data</a>
                                            
                                            @if($softwares -> id_software == 0)
                                                <a class="btn btn-danger text-white disabled" href="#"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                            @else
                                                <a class="btn btn-danger text-white" href="{{ route('hapussoftware', $softwares->id_software ) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                            @endif
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