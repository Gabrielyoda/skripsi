@extends('layouts.admin')
@section('content')

@php
    $hari= array('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
    $jam= array('07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50');
    $lab= array('Lab. Kom 01','Lab. Kom 02','Lab. Kom 04','Lab. Kom 05','Lab. Kom 06','Lab. Kom 07','Lab. Kom 08','Lab. Kom 09','Lab. Kom 10','Lab. Kom 11','Lab. Kom 12','Lab. Kom 14');
@endphp
<ul class="nav"  role="tablist">
    @for($i = 0 ; $i < 7 ; $i++)
        <li class="nav-item mb-3">
            <a class="tabhari {{ ( $i == 0 ) ? 'active': '' }}" href="#{{ $hari[$i] }}" role="tab" data-toggle="tab">{{ $hari[$i] }}</a>
        </li>
    @endfor
</ul>
<div class="tab-content">
    @for($i = 0 ; $i < count($hari) ; $i++)
        <div role="tabpanel" class="tab-pane {{ ( $i == 0 ) ? 'active': '' }}" id="{{ $hari[$i] }}">
            <div class="table-responsive">
                <table class="table table-bordered mt-2 tabel text-center">
                    <tr>
                        <th class="thatas">
                            Lab
                            <div class="garis"></div>
                        </th>
                        @for($j = 0 ; $j < count($lab) ; $j++)
                            <th rowspan="2" class="align-middle">{{ $lab[$j] }}</th>
                        @endfor
                    </tr>
                    <tr>
                        <th class="thbawah">Jam</th>
                    </tr>
                    @php
                        $m = 0;
                        $n = 0;
                    @endphp
                    <!-- Buat jam untuk matakuliah per satu sks dengan array  -->
                    @for($j = 0 ; $j < count($jam) ; $j++)
                        @php
                            $jamMasukArray  = substr($jam[$j], 0, -8);
                            $jamKeluarArray = substr($jam[$j], -5);
                        @endphp
                        <tr>
                            <th class="align-middle">{{ $jam[$j] }}</th>

                            <!-- Buat 12 Lab dengan array  -->
                            @for($k = 0 ; $k < count($lab) ; $k++)

                                <!-- Cocokin dengan $join -->
                                @foreach($join as $joins)
                                    @php
                                        $jamMasukDB     = substr($joins -> jam_ajar, 0, -8);
                                        $jamKeluarDB    = substr($joins -> jam_ajar, -5);
                                    @endphp

                                    @if($jamMasukDB == $jamMasukArray && $joins -> nama_lab == $lab[$k] && $joins -> hari == $hari[$i])
                                        <th rowspan="{{ $joins -> sks_mtk }}" class="align-middle">
                                            <p class="isitabel m-0"><strong>{{ $joins -> nama_mtk }}</strong></p>
                                            <p class="isitabel mx-0 my-2">{{ $joins -> kelompok }}</p>
                                            <p class="isitabel m-0">{{ $joins -> nama_dosen }}</p>
                                            @if(!empty($joins -> tanggal_pengganti))
                                                <p class="isitabel m-0 text-info">{{ "(".$joins -> tanggal_pengganti.")" }}</p>
                                            @endif
                                        </th>
                                        @php
                                            $m++;
                                        @endphp
                                    @else
                                        @if($jamKeluarDB == $jamKeluarArray && $joins -> nama_lab == $lab[$k] && $joins -> hari == $hari[$i])
                                            @php
                                                $n++;
                                            @endphp
                                        @else
                                            @if($jamMasukArray >= $jamMasukDB && $jamKeluarArray <= $jamKeluarDB && $joins -> nama_lab == $lab[$k] && $joins -> hari == $hari[$i])
                                                @php
                                                    $n++;
                                                 @endphp
                                            @endif
                                        @endif
                                    @endif

                                @endforeach
                                <!-- Tutup foreach join -->
                                
                                @php
                                    if($n > 0) {
                                        $m++;
                                        $n--;
                                    }

                                    if($m == 0) {
                                        echo '<th></th>';
                                    }
                                    else {
                                        $m--;
                                    }
                                @endphp

                            @endfor
                            <!-- Tutup 'for' untuk array Lab -->
                            
                    @endfor
                    <!-- Tutup 'for' untuk array Jam -->
                </table>
            </div>
        </div>
    @endfor
</div>
@endsection