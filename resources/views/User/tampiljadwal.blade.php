@extends('layouts.home')
@section('content')
    <div class="row text-center text-white">

        <div class="col-md-12">
            <h1 class="pt-2 pb-0 border-0">Jadwal Praktikum<br>Laboratorium Komputer ICT Terpadu</h1>
            <h3 class="pb-3">{{ $hari_ini }}, {{ $tanggal_ini }}</h3>
        </div>
        
        @if(count($join) != 0)
        <div class="col-md-12 mb-2">
            <div class="row border gradient-header">
                <div class="col-md-4 py-3">
                    <h3 class="border-0 animasi tabel-header">Nama Mata Kuliah</h3>
                </div>
                <div class="col-md-3 offset-md-1 py-3">
                    <h3 class="border-0 animasi tabel-header">Nama Dosen</h3>
                </div>
                <div class="col-md-2 offset-md-2 py-3">
                    <h3 class="border-0 animasi tabel-header">Waktu</h3>
                </div>
                
                <div class="col-md-1 offset-md-3" style="position: absolute; top: 17px; left: 28px;">
                    <h3 class="border-0 animasi tabel-header pl-5">Kelompok</h3>
                </div>
                <div class="col-md-2 offset-md-4" style="position: absolute; top: 17px; right: 220px;">
                    <h3 class="border-0 animasi tabel-header">Ruang Lab</h3>
                </div>
            </div>
        </div>
        @endif
        
        @php
            $i = 0;
        @endphp

        <ul class="slidetampil">
            @if(count($join) == 0)
                <li class="bg-biru-ganjil col-md-10 offset-md-1 mt-5">
                    <div class="col-md-12 animated shake">
                        <h2 class="p-5 text-white border-0">Oops, tidak ada jadwal untuk ditampilkan.</h2>
                        <p class="mb-5">Silahkan bertanya kepada asisten, jika ada pertanyaan perihal jadwal.</p>
                    </div>
                </li>
            @else
                @if(count($join) <= 4)
                    <li>
                        @for($i= 0; $i< count($join); $i++)
                            @if($i % 2 == 0)
                                <div class="col-md-12 bg-biru-ganjil mb-1 animated slideInLeft {{ $i }}">
                                    <div class="row border">
                                        <div class="col-md-4 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                        </div>
                                        <div class="col-md-1 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                        </div>
                                        <div class="col-md-3 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                        </div>
                                        <div class="col-md-2 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                        </div>
                                        <div class="col-md-2 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                    <div class="row border">
                                        <div class="col-md-4 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                        </div>
                                        <div class="col-md-1 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                        </div>
                                        <div class="col-md-3 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                        </div>
                                        <div class="col-md-2 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                        </div>
                                        <div class="col-md-2 p-2">
                                            <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </li>
                @else
                    @if(count($join) <= 8)
                        <li>
                            @for($i= 0; $i<= 3; $i++)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 bg-biru-ganjil mb-1 animated mb-1 slideInLeft {{ $i }}">
                                        <div class="row border" style="vertical-align: middle;">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </li>
                        
                        <li>
                            @for($i= 4; $i< count($join); $i++)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 bg-biru-ganjil mb-1 animated slideInLeft {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </li>
                    @else
                        <li>
                            @for($i= 0; $i<= 3; $i++)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 bg-biru-ganjil mb-1 animated mb-1 slideInLeft {{ $i }}">
                                        <div class="row border" style="vertical-align: middle;">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </li>
                        
                        <li>
                            @for($i= 4; $i<= 7; $i++)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 bg-biru-ganjil mb-1 animated slideInLeft {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </li>
                        <li>
                            @for($i= 8; $i< count($join); $i++)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 bg-biru-ganjil mb-1 animated slideInLeft {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 bg-biru-genap mb-1 animated slideInRight {{ $i }}">
                                        <div class="row border">
                                            <div class="col-md-4 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_mtk }}</h3>
                                            </div>
                                            <div class="col-md-1 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> kelompok }}</h3>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama }}</h3>
                                            </div>
                                             <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> nama_lab }}</h3>
                                            </div>
                                            <div class="col-md-2 p-2">
                                                <h3 class="tabel-body">{{ $join[$i] -> jam_ajar }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </li>
                    @endif

                @endif
                
            @endif
        </ul>
    </div>
    <div class="copyright text-white">
        <p><span id="clock"></span> WIB &nbsp; &nbsp; &nbsp; Laboratorium Komputer ICT Terpadu</p>
    </div>
@endsection