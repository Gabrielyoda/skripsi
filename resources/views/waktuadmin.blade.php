@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Waktu Ajar</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-center">
                        <button class="btn btn-info btn-lg w-100 mb-3 mt-1" data-toggle="modal" data-target="#modalTahun"><i class="fa fa-plus fa-lg"></i> Tambah Data Tahun Ajaran</a>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalTahun" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tahun Ajaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ Route('tambahtahun') }}" method="post">
                                {{ csrf_field() }}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="text-muted">Tahun Ajaran :</label>
                                            <select class="form-control" name="thnajar" required>
                                            @for($i=0 ; $i<=3 ;$i++)
                                                <option value="{{ $tahun1=date('Y')+($i-2) }}/{{ $tahun2=date('Y')+($i-1) }}">{{ $tahun1 }}/{{ $tahun2 }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tahun Ajaran</th>
									<th>Status</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($thajar as $thajars)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>{{ $thajars -> tahunajaran }}</td>
                                    <td>
                                        @if($thajars -> status_tahunajaran == 1)
                                            {{ "Aktif" }}
                                        @else
                                            {{ "Tidak Aktif" }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                    @if($thajars -> status_tahunajaran == 1)
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white disabled" href="#"><i class="fa fa-edit fa-lg"></i> Aktifkan Data</a>
                                            <a class="btn btn-danger text-white disabled" href="#"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('aktifkantahun', $thajars->id_tahunajaran) }}"><i class="fa fa-edit fa-lg"></i> Aktifkan Data</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapustahun', $thajars->id_tahunajaran) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                        </div>
                                    @endif
                                    </td>
                                </tr>
                                @php    
                                    $nomor++;
                                @endphp
                                @endforeach
							</tbody>
						</table>
					</div>
                    <br><hr><br>
                    <div class="text-center">
                        <button class="btn btn-info btn-lg w-100 mb-3 mt-1" data-toggle="modal" data-target="#modalSemester"><i class="fa fa-plus fa-lg"></i> Tambah Data Semester Ajaran</a>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalSemester" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Semester Ajaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ Route('tambahsemester') }}" method="post">
                                {{ csrf_field() }}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="text-muted">Semester :</label>
                                            <select class="form-control" name="semester" required>
                                                <option value="Gasal">Gasal</option>
                                                <option value="Genap">Genap</option>
                                                <option value="Antara">Antara</option>
                                                <option value="Pendek">Pendek</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
									<th>Semester</th>
									<th>Status</th>
                                    <th class="text-center">Pilihan</th>
								</tr>
							</thead>
							<tbody>
                                @php    
                                    $nomor = 1;
                                @endphp
                                @foreach ($smt as $smts)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td>{{ $smts -> semester }}</td>
                                    <td>
                                        @if($smts -> status_semester == 1)
                                            {{ "Aktif" }}
                                        @else
                                            {{ "Tidak Aktif" }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                    @if($smts -> status_semester == 1)
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white disabled" href="#"><i class="fa fa-edit fa-lg"></i> Aktifkan Data</a>
                                            <a class="btn btn-danger text-white disabled" href="#"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <a class="btn btn-warning text-white" href="{{ route('aktifkansemester', $smts->id_semester) }}"><i class="fa fa-edit fa-lg"></i> Aktifkan Data</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapussemester', $smts->id_semester) }}"><i class="fa fa-trash fa-lg"></i> Hapus Data</a>
                                        </div>
                                    @endif
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