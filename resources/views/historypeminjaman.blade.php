@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">History Peminjaman Lab</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <div class="text-left">
                        
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
                                    <th>Lab</th>
                                    <th>Status</th>
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
                                    <td>{{ $joins -> nama_lab }}</td>
                                    @if($joins -> status != 2)
                                    <td>Disetujui</td>
                                    @else
                                    <td>Ditolak</td>
                                    @endif
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