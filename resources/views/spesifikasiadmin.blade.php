@extends('layouts.admin')
@section('content')

@php
    $flag = 0;
@endphp

<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="card mb-5">
            <div class="card-block">
                <h3 class="card-title">Spesifikasi Lab</h3>
                <h6 class="card-subtitle mb-1 text-muted">Laboratorium Komputer ICT Terpadu</h6>
                <hr>
                <div class="canvas-wrapper">
                    <ul class="nav"  role="tablist">
                        @foreach($lab as $labs)
                            <li class="nav-item mb-3">
                                <a class="tablab {{ ( $labs->id_lab == 0 ) ? 'active': '' }}" href="#{{ $labs->id_lab }}" role="tab" data-toggle="tab">{{ $labs->nama_lab }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="container tab-content my-3">
                        @foreach($lab as $labs)
                            <div role="tabpanel" class="tab-pane {{ ( $labs->id_lab == 0 ) ? 'active': '' }}" id="{{ $labs->id_lab }}">
                                <form action="{{ Route('prosessimpanspesifikasi') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row"> 
                                        @foreach($software as $softwares)
                                            <div class="col-md-3">  
                                                @foreach($spek as $spesifikasi)
                                                    @if($labs->id_lab == $spesifikasi->id_lab && $softwares->id_software == $spesifikasi->id_software)
                                                        @php
                                                            $flag = 1;
                                                            break;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $flag = 0;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if($flag == 0)
                                                    <input type="checkbox" name="software[]" value="{{ $labs->id_lab }}-{{  $softwares->id_software }}" id="{{ $labs->id_lab }}-{{  $softwares->id_software }}"><label for="{{ $labs->id_lab }}-{{  $softwares->id_software }}">&nbsp;{{  $softwares->nama_software }}</label>
                                                @else
                                                    @if($softwares->id_software == 0)
                                                        <input type="checkbox" checked disabled><label>&nbsp;{{  $softwares->nama_software }}</label>
                                                        <input type="hidden" name="lab" value="{{ $labs->id_lab }}" readonly>
                                                    @else 
                                                        <input type="checkbox" name="software[]" value="{{ $labs->id_lab }}-{{  $softwares->id_software }}" id="{{ $labs->id_lab }}-{{  $softwares->id_software }}" checked><label for="{{ $labs->id_lab }}-{{  $softwares->id_software }}">&nbsp;{{  $softwares->nama_software }}</label>
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="col-md-12 mt-4 text-center">
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save fa-lg"></i> Simpan Perubahan Spesifikasi {{ $labs->nama_lab }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection