@extends('layouts.home')
@section('content')
    @php
        $jam= array('07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50');
        $lab= array('Lab. Kom 01','Lab. Kom 02','Lab. Kom 04','Lab. Kom 05','Lab. Kom 06','Lab. Kom 07','Lab. Kom 08','Lab. Kom 09','Lab. Kom 10','Lab. Kom 11','Lab. Kom 12','Lab. Kom 14');
    @endphp
    <div class="table-responsive p-3">
        <table class="table table-bordered tabelUser text-center">
            <tr>
                <th class="align-middle border-user p-1 pt-3 pulsingItem" id="inputtanggal">
                    <label id="hari">{{ $hari_ini }}</label><br>
                    <label id="tanggal">{{ $tanggal_ini }}</label><br>
                    <input id="inputfieldtanggal" type="text" value="{{ $tanggal_ini }}"/>
                </th>
                @for($j = 0 ; $j < count($lab) ; $j++)
                <th rowspan="2" class="align-middle lebarlabuser">{{ $lab[$j] }}</th>
                @endfor
            </tr>
            <tr></tr>
            @php
                $m = 0;
                $n = 0;
            @endphp

            <tbody class="isiJadwal border-0">
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
                        <!-- Cocokin dengan database [$Join]  -->
                        @foreach($join as $joins)
                            @php
                                $jamMasukDB     = substr($joins -> jam_ajar, 0, -8);
                                $jamKeluarDB    = substr($joins -> jam_ajar, -5);
                            @endphp
                            @if($jamMasukDB == $jamMasukArray && $joins -> nama_lab == $lab[$k])
                                <th rowspan="{{ $joins -> sks_mtk }}" class="align-middle">
                                    <p class="isitabel m-0"><strong>{{ $joins -> nama_mtk }}</strong></p>
                                    <p class="isitabel mx-0 my-2">{{ $joins -> kelompok }}</p>
                                    <p class="isitabel m-0">{{ $joins -> nama }}</p>
                                </th>
                                @php
                                    $m++;
                                @endphp
                            @else
                                @if($jamKeluarDB == $jamKeluarArray && $joins -> nama_lab == $lab[$k])
                                    @php
                                        $n++;
                                    @endphp
                                @else
                                    @if($jamMasukArray >= $jamMasukDB && $jamKeluarArray <= $jamKeluarDB && $joins -> nama_lab == $lab[$k])
                                        @php
                                            $n++;
                                        @endphp
                                    @endif
                                @endif
                            @endif
                        @endforeach
                        <!-- Tutup foreach join -->

                        <!-- Cocokin dengan database [$JoinKP]  -->
                        @foreach($joinKP as $joinKPs)
                            @php
                                $jamMasukDB     = substr($joinKPs -> jam_pengganti, 0, -8);
                                $jamKeluarDB    = substr($joinKPs -> jam_pengganti, -5);
                            @endphp
                            @if($jamMasukDB == $jamMasukArray && $joinKPs -> nama_lab == $lab[$k])
                                <th rowspan="{{ $joinKPs -> sks_mtk }}" class="align-middle">
                                    <p class="isitabel m-0"><strong>{{ $joinKPs -> nama_mtk }}</strong></p>
                                    <p class="isitabel mx-0 my-2">{{ $joinKPs -> kelompok }}</p>
                                    <p class="isitabel m-0">{{ $joinKPs -> nama }}</p>
                                </th>
                                @php
                                    $m++;
                                @endphp
                            @else
                                @if($jamKeluarDB == $jamKeluarArray && $joinKPs -> nama_lab == $lab[$k])
                                    @php
                                        $n++;
                                    @endphp
                                @else
                                    @if($jamMasukArray >= $jamMasukDB && $jamKeluarArray <= $jamKeluarDB && $joinKPs -> nama_lab == $lab[$k])
                                        @php
                                            $n++;
                                        @endphp
                                    @endif
                                @endif
                            @endif
                        @endforeach
                        <!-- Tutup foreach joinKP -->

                        <!-- Cocokin dengan database [$joinPinjam]  -->
                        @for($i = 0 ; $i < count($joinPinjam) ; $i++)
                            @if($joinPinjam[$i]['jamAwal'] == $jamMasukArray && $joinPinjam[$i]['nama_lab'] == $lab[$k])
                                <th rowspan="{{ $joinPinjam[$i]['lamaPinjam'] }}" class="align-middle">
                                    <p class="isitabel m-0"><strong>{{ $joinPinjam[$i]['judul_pinjam'] }}</strong></p>
                                    <p class="isitabel mx-0 my-2"><small>({{ $joinPinjam[$i]['jamAwalAsli'] }} - {{ $joinPinjam[$i]['jamAkhirAsli'] }})</small></p>
                                    <p class="isitabel m-0">{{ $joinPinjam[$i]['nama_pinjam'] }}</p>
                                </th>
                                @php
                                    $m++;
                                @endphp
                            @else
                                @if($joinPinjam[$i]['jamAkhir'] == $jamKeluarArray && $joinPinjam[$i]['nama_lab'] == $lab[$k])
                                    @php
                                        $n++;
                                    @endphp
                                @else
                                    @if($jamMasukArray >= $joinPinjam[$i]['jamAwal'] && $jamKeluarArray <= $joinPinjam[$i]['jamAkhir'] && $joinPinjam[$i]['nama_lab'] == $lab[$k])
                                        @php
                                            $n++;
                                        @endphp
                                    @endif
                                @endif
                            @endif
                        @endfor
                        <!-- Tutup foreach joinPinjam -->

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
                </tr>
            @endfor
            <!-- Tutup 'for' untuk array Jam -->
            </tbody>
        </table>
    </div>
@endsection