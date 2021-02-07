@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Data Permintaan Peminjaman Lab</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-left">
                        <a class="btn btn-info btn-lg w-20 mb-3 mt-1" href="{{ Route('tambahpinjamlab') }}"><i class="fa fa-plus fa-lg"></i> Tambah Data</a>
                        <a class="btn btn-primary btn-lg w-20 mb-3 mt-1" href="{{ Route('history') }}"><i class="fa fa-eye fa-lg"></i> History Peminjaman Data</a>

                    </div>
                    <div class="table-responsive-lg">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>No.</th>
                                    <th>Nama Acara</th>
                                    <th>Nama Peminjam</th>
									<th>Tanggal</th>
                                    <th>Jam</th>
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
                                    <td>{{ $joins -> judul_pinjam }}</td>
                                    <td> {{ $joins -> nama_pinjam }}</td>
                                    <td>{{ $joins -> tanggal_pinjam }}</td>
                                    <td>{{ $joins -> jam_pinjam }}</td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-primary text-white" href="{{ route('viewpinjamlab', $joins -> id_pinjam ) }}"><i class="fa fa-eye fa-lg"></i> Lihat Data</a>
                                            <!-- <a class="btn btn-warning text-white" href="{{ route('ubahpinjamlab', $joins -> id_pinjam ) }}"><i class="fa fa-check fa-lg"></i> Setujui</a>
                                            <a class="btn btn-danger text-white" href="{{ route('hapuspinjamlab', $joins -> id_pinjam ) }}"><i class="fa fa-times fa-lg"></i>Tolak</a> -->
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