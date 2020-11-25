<!DOCTYPE html>
<html>
<head>
    <title>Sistem Penjadwalan</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
</head>
<body class="background" onload="displayTime(); setInterval('displayTime()', 1000); setInterval('refresh()', 900000);">
    <nav id="sidebar">
        <div id="dismiss">
            &times;
        </div>

        <div class="sidebar-header">
            <h4>Penjadwalan<br>Lab ICT Terpadu</h4>
        </div>

        <ul class="components nav flex-column sidebar-nav">
            <!-- <li>
                <a href="#">About</a>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a href="#">Page 3</a>
                    </li>
                </ul>
            </li> -->
            <li class="nav-item">
                <a href="{{ Route('jadwalall') }}" class="nav-link {{ ($title=='Jadwal') ? 'active':'' }}"><i class="fa fa-calendar"></i> &nbsp;Jadwal</a>
            </li>
            <!-- <li class="nav-item">
                <a href="{{ Route('kpuser') }}" class="nav-link {{ ($title=='KP') ? 'active':'' }}"><i class="fa fa-calendar-check-o"></i> &nbsp;Kuliah Pegganti</a>
            </li>
            <li class="nav-item">
                <a href="{{ Route('pinjamlabuser') }}" class="nav-link {{ ($title=='PinjamLab') ? 'active':'' }}"><i class="fa fa-calendar-plus-o"></i> &nbsp;Peminjaman Lab</a>
            </li> -->
            <li>
                <a href="{{ Route('tampiljadwal') }}" target="_blank" class="nav-link {{ ($title=='Tampil') ? 'active':'' }}"><i class="fa fa-window-restore"></i> &nbsp;Tampil Jadwal</a>
            </li>
            <br>
            <li class="text-center">
                <a href="{{ Route('loginadmin') }}" class="nav-link border rounded mx-4">Masuk Asisten</a>
            </li>
        </ul>
    </nav>

    <div id="content">
        @if($title == 'Tampil')
            <video autoplay muted loop id="myVideo">
                <source src="{{ asset('video/ICT_BG2.mp4') }}" type="video/mp4">
            </video>
        @else
            <div class="actSidebar text-white" id="sidebarCollapse">
                <span>MENU</span>
            </div>
                    
            <div class="jam text-white">
                <i class="fa fa-clock-o fa-lg"></i> <span id="clock"></span>
            </div>
        @endif

        <div class="container-fluid {{ ($title == 'Tampil') ? 'px-5' : '' }}">
            @yield('content')
        </div>
    </div>
    
    <div class="overlay"></div>

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/responsiveslides.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

<script>

    function displayTime(){
		var time = new Date();
		var sh = time.getHours() + "";
		var sm = time.getMinutes() + "";
		var ss = time.getSeconds() + "";
		document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
	}

    function refresh() {
        location.reload();
    }

    function pilihJamAjar(jam, lab) {
        var i = 0;
        
        if($('#jumlahSks').val() == 1) 
        {
            var sks1 = ['07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50'];

            for(i=0; i<sks1.length; i++)
            {
                if(jam.substring(0, 5) == sks1[i].substring(0, 5))
                {
                    $('#fieldjam').val(sks1[i]);
                }
            }
        }
        else
        {  
            if($('#jumlahSks').val() == 2)
            {
                var sks2 = ['07:10 - 08:50', '08:00 - 09:40', '08:55 - 10:35', '09:45 - 11:30', '10:40 - 12:25', '11:35 - 13:20', '12:30 - 14:15', '13:25 - 15:10', '14:20 - 16:05', '15:15 - 17:00', '16:10 - 17:55', '17:05 - 18:50'];

                for(i=0; i<sks2.length; i++)
                {
                    if(jam.substring(0, 5) == sks2[i].substring(0, 5))
                    {
                        $('#fieldjam').val(sks2[i]);
                    }
                }
            }
            else
            {
                if($('#jumlahSks').val() == 3)
                {
                    var sks3 = ['07:10 - 09:40', '08:00 - 10:35', '08:55 - 11:30', '09:45 - 12:25', '10:40 - 13:20', '11:35 - 14:15', '12:30 - 15:10', '13:25 - 16:05', '14:20 - 17:00', '15:15 - 17:55', '16:10 - 18:50'];
                    
                    for(i=0; i< sks3.length; i++)
                    {
                        if(jam.substring(0, 5) == sks3[i].substring(0, 5))
                        {
                            $('#fieldjam').val(sks3[i]);
                        }
                    }
                }
                else
                {
                    $('#fieldjam').val(jam);
                }
            }
        }

        $('#fieldlab').val(lab);
        
        $('#modalJamAjar').modal('toggle');
    }

    $(function() {

        $(".slidetampil").responsiveSlides({
            speed: 0,
            timeout: 6500,
            before: function() {
                $('.animasi').removeClass('animated flash');
                
                for(tampiljadwal=0; tampiljadwal<=11; tampiljadwal++)
                {
                    $('.'+tampiljadwal+'').hide();
                }
            },
            after: function() {
                $('.animasi').addClass('animated flash');

                for(tampiljadwal=0; tampiljadwal<=11; tampiljadwal++)
                {
                    $('.'+tampiljadwal+'').fadeIn(1000);
                    $('.'+tampiljadwal+'').show();
                }
            }
        });

        $(".tabelUser").fadeIn(300);

        $('#inputfieldtanggal').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
        });

        $('#inputtanggal').click(function() {
            $('#inputfieldtanggal').datepicker('show');
        });
        
        $('#fieldtanggal').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
            startDate: '+1d',
        });

        $('#fieldtanggalPinjam').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
        });
    });

    $(document).ready(function(){

        $('#sidebar').mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        $('#inputfieldtanggal').change(function(){
            
            var waktu       = $(this).val();
            
            var namahari    = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var carihari    = new Date(waktu).getDay();

            var hari        = namahari[carihari];

            $('#hari').text(hari);
            $('#tanggal').text(waktu);

            var tanggalterakhir =  $('#tanggal').text();

            if(waktu) {
                $.ajax({
                    url: "./home/waktu",
                    type: "POST",
                    data: {"waktu":waktu, "hari":hari, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    beforeSend:function() {
                        $(".tabelUser").fadeOut(300);
                        $('.isiJadwal').empty();
                    },
                    success:function(data) {
                        $('.isiJadwal').empty();
                        var jam = ['07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50'];
                        var lab = ['Lab. Kom 01','Lab. Kom 02','Lab. Kom 04','Lab. Kom 05','Lab. Kom 06','Lab. Kom 07','Lab. Kom 08','Lab. Kom 09','Lab. Kom 10','Lab. Kom 11','Lab. Kom 12','Lab. Kom 14'];
                        var i = 0;
                        var j = 0;
                        var k = 0;
                        var m = 0;
                        var n = 0;

                        if(data != 0) {
                            
                            for(i = 0 ; i < jam.length ; i++)
                            {
                                var jamMasukArray  = jam[i].substring(0, 5);
                                var jamKeluarArray = jam[i].substring(8,13);
                                $('.isiJadwal').append( '<tr id="'+i+'">'+
                                                            '<th class="align-middle">'+jam[i]+'</th>');
                                
                                for(j = 0 ; j < lab.length ; j++)
                                {
                                    // UNTUK CETAK DATA KULIAH REGULER
                                    for(k = 0 ; k < data['join'].length ; k++) 
                                    {
                                        var row = data['join'][k];
                                        var jamMasukDB  = row['jam_ajar'].substring(0, 5);
                                        var jamKeluarDB = row['jam_ajar'].substring(8,13);

                                        if(jamMasukDB == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['sks_mtk']+'" class="align-middle">'+
                                                                    '<p class="isitabel m-0"><strong>'+row['nama_mtk']+'</strong></p>'+
                                                                    '<p class="isitabel mx-0 my-2">'+row['kelompok']+'</p>'+
                                                                    '<p class="isitabel m-0">'+row['nama_dosen']+'</p>'+
                                                                '</th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(jamKeluarDB == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= jamMasukDB && jamKeluarArray <= jamKeluarDB && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    // UNTUK CETAK DATA KULIAH PENGGANTI
                                    for(k = 0 ; k < data['joinKP'].length ; k++) 
                                    {
                                        var row = data['joinKP'][k];
                                        var jamMasukDB  = row['jam_pengganti'].substring(0, 5);
                                        var jamKeluarDB = row['jam_pengganti'].substring(8,13);

                                        if(jamMasukDB == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['sks_mtk']+'" class="align-middle">'+
                                                                    '<p class="isitabel m-0"><strong>'+row['nama_mtk']+'</strong></p>'+
                                                                    '<p class="isitabel mx-0 my-2">'+row['kelompok']+'</p>'+
                                                                    '<p class="isitabel m-0">'+row['nama_dosen']+'</p>'+
                                                                '</th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(jamKeluarDB == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= jamMasukDB && jamKeluarArray <= jamKeluarDB && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    // UNTUK CETAK DATA PEMINJAMAN LAB
                                    for(k = 0 ; k < data['joinPinjam'].length ; k++)
                                    {
                                        var row = data['joinPinjam'][k];

                                        if(row['jamAwal'] == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['lamaPinjam']+'" class="align-middle">'+
                                                                    '<p class="isitabel m-0"><strong>'+row['judul_pinjam']+'</strong></p>'+
                                                                    '<p class="isitabel mx-0 my-2"><small>('+row['jamAwalAsli']+' - '+row['jamAkhirAsli']+')</small></p>'+
                                                                    '<p class="isitabel m-0">'+row['nama_pinjam']+'</p>'+
                                                                '</th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(row['jamAkhir'] == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= row['jamAwal'] && jamKeluarArray <= row['jamAkhir'] && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    if(n > 0) {
                                        m++;
                                        n--;
                                    }
                                    if(m == 0) {
                                        $('#'+i+'').append('<th></th>');
                                    }
                                    else {
                                        m--;
                                    }
                                }
                                $('.isiJadwal').append( '</tr>');
                                $(".tabelUser").fadeIn(300);
                            }
                        }
                        else {

                            for(i = 0 ; i < jam.length ; i++)
                            {
                                $('.isiJadwal').append( '<tr id="'+i+'">'+
                                                            '<th class="align-middle">'+jam[i]+'</th>');
                                
                                for(j = 0 ; j < lab.length ; j++)
                                {
                                    $('#'+i+'').append('<th></th>');
                                }
                                $('.isiJadwal').append( '</tr>');
                            }
                        }
                    }
                });
            }
            else
            {
                $('#inputfieldtanggal').val(tanggalterakhir);
                $('#tanggal').text(tanggalterakhir);
            }
        });

        $("#namaMatkul").change(function(){
            var idmtk    = $(this).val();
            
            if(idmtk) {
                $.ajax({
                    url: "./kuliahpengganti/dosen",
                    type: "POST",
                    data : {"idmtk":idmtk, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    beforeSend:function() {
                        $('#jumlahSks').empty();
                        $('#kelompok').empty();
                        $('#namaDosen').empty();

                        $('select[name="kelompok"]').append('<option>Tunggu Sejenak</option>');
                        $('select[name="namaDosen"]').append('<option>Tunggu Sejenak</option>');
                    },
                    success:function(data) {
                        if(data['dosen'] != 0){
                            var i = 0;
                            var panjangarray = data['dosen'].length;

                            $('#kelompok').empty();
                            $('#namaDosen').empty();
                            
                            $('select[name="kelompok"]').append('<option value="" disabled selected>-- Pilih Kelompok --</option>');
                            $('select[name="namaDosen"]').append('<option value="" disabled selected>-- Pilih Dosen Pengajar --</option>');
                            for(i = 0 ; i < panjangarray ; i++)
                            {
                                $('select[name="namaDosen"]').append('<option value="'+data['dosen'][i].id_dosen+'">'+data['dosen'][i].nip_dosen+' - '+data['dosen'][i].nama_dosen+'</option>');
                            }
                        }
                        else{
                            $('#kelompok').empty();
                            $('#namaDosen').empty();

                            $('select[name="kelompok"]').append('<option value="" disabled selected>-- Pilih Kelompok --</option>');
                            $('select[name="namaDosen"]').append('<option value="" disabled selected>Data Tidak Ditemukan</option>');
                        }
                        $('#jumlahSks').val(data['sks'].sks_mtk);
                    }
                });
            }
        });

        $("#namaDosen").change(function(){
            var idmtk       = $("#namaMatkul").val();
            var iddosen     = $(this).val();
            
            if(idmtk && iddosen) {
                $.ajax({
                    url: "./kuliahpengganti/kelompok",
                    type: "POST",
                    data : {"iddosen":iddosen, "idmtk":idmtk, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    beforeSend:function() {
                        $('#kelompok').empty();
                        $('select[name="kelompok"]').append('<option selected>Tunggu Sejenak</option>');
                    },
                    success:function(data) {
                        if(data != 0){
                            var i = 0;
                            var panjangarray = data.length;
                            
                            $('#kelompok').empty();
                            
                            $('select[name="kelompok"]').append('<option value="" disabled selected>-- Pilih Kelompok --</option>');
                            for(i = 0 ; i < panjangarray ; i++)
                            {
                                $('select[name="kelompok"]').append('<option value="'+data[i].kelompok+'">'+data[i].kelompok+'</option>');
                            }
                        }
                        else{
                            $('#kelompok').empty();

                            $('select[name="kelompok"]').append('<option value="" disabled selected>Data Tidak Ditemukan</option>');
                        }
                    }
                });
            }
        });

        $("#fieldtanggal").change(function(){
            var tanggalKP    = $(this).val();
            
            if(tanggalKP) {
                $.ajax({
                    url: "./kuliahpengganti/jamajar",
                    type: "POST",
                    data : {"tanggalKP":tanggalKP, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    beforeSend:function() {
                        $('#fieldjam').val("");
                        $('#fieldlab').val("");
                        $('#tampilModalLabTersedia').val("");
                    },
                    success:function(data) {
                        var jam = ['07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50'];
                        var lab = ['Lab. Kom 01','Lab. Kom 02','Lab. Kom 04','Lab. Kom 05','Lab. Kom 06','Lab. Kom 07','Lab. Kom 08','Lab. Kom 09','Lab. Kom 10','Lab. Kom 11','Lab. Kom 12','Lab. Kom 14'];
                        var i = 0;
                        var j = 0;
                        var k = 0;
                        var m = 0;
                        var n = 0;
                        
                        if(data != 0) {
                            $('.modal-body').find('h4').remove();
                            $('.isiHeaderJadwal').empty();
                            $('.isiJadwal').empty();

                            $('.isiHeaderJadwal').append('<th class="align-middle border-user p-1">'+
                                                            '<strong>'+tanggalKP+'</strong>'+
                                                        '</th>');

                            for(i = 0 ; i < lab.length ; i++)
                            {
                                $('.isiHeaderJadwal').append('<th rowspan="2" class="align-middle lebarlabuser">'+lab[i]+'</th>');
                            }

                            for(i = 0 ; i < jam.length ; i++)
                            {
                                var jamMasukArray  = jam[i].substring(0, 5);
                                var jamKeluarArray = jam[i].substring(8,13);
                                $('.isiJadwal').append( '<tr id="'+i+'">'+
                                                            '<th class="align-middle">'+jam[i]+'</th>');
                                
                                for(j = 0 ; j < lab.length ; j++)
                                {
                                    // UNTUK CETAK DATA KULIAH REGULER
                                    for(k = 0 ; k < data['join'].length ; k++) 
                                    {
                                        var row = data['join'][k];
                                        var jamMasukDB  = row['jam_ajar'].substring(0, 5);
                                        var jamKeluarDB = row['jam_ajar'].substring(8,13);

                                        if(jamMasukDB == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['sks_mtk']+'" class="bg-dark"></th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(jamKeluarDB == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= jamMasukDB && jamKeluarArray <= jamKeluarDB && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    // UNTUK CETAK DATA KULIAH PENGGANTI
                                    for(k = 0 ; k < data['joinKP'].length ; k++) 
                                    {
                                        var row = data['joinKP'][k];
                                        var jamMasukDB  = row['jam_pengganti'].substring(0, 5);
                                        var jamKeluarDB = row['jam_pengganti'].substring(8,13);

                                        if(jamMasukDB == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['sks_mtk']+'" class="bg-dark"></th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(jamKeluarDB == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= jamMasukDB && jamKeluarArray <= jamKeluarDB && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    // UNTUK CETAK DATA PEMINJAMAN LAB
                                    for(k = 0 ; k < data['joinPinjam'].length ; k++)
                                    {
                                        var row = data['joinPinjam'][k];

                                        if(row['jamAwal'] == jamMasukArray && row['nama_lab'] == lab[j])
                                        {
                                            $('#'+i+'').append( '<th rowspan="'+row['lamaPinjam']+'" class="bg-dark"></th>');
                                            m++;
                                        }
                                        else
                                        {
                                            if(row['jamAkhir'] == jamKeluarArray && row['nama_lab'] == lab[j])
                                            {
                                                n++;
                                            }
                                            else
                                            {
                                                if(jamMasukArray >= row['jamAwal'] && jamKeluarArray <= row['jamAkhir'] && row['nama_lab'] == lab[j])
                                                {
                                                    n++;
                                                }
                                            }
                                        }
                                    }

                                    if(n > 0) {
                                        m++;
                                        n--;
                                    }
                                    if(m == 0) {
                                        $('#'+i+'').append('<th class="pilihJamAjar" value="'+jam[i]+'" onclick="pilihJamAjar(\''+jam[i]+'\',\''+lab[j]+'\')"></th>');
                                    }
                                    else {
                                        m--;
                                    }
                                }
                                $('.isiJadwal').append( '</tr>');
                            }
                        }
                        else {
                            $('.isiHeaderJadwal').empty();
                            $('.isiJadwal').empty();

                            $('.isiHeaderJadwal').append('<th class="align-middle border-user p-1 pt-3">'+
                                                            '<strong>'+tanggalKP+'</strong>'+
                                                        '</th>');

                            for(i = 0 ; i < lab.length ; i++)
                            {
                                $('.isiHeaderJadwal').append('<th rowspan="2" class="align-middle lebarlabuser">'+lab[i]+'</th>');
                            }

                            for(i = 0 ; i < jam.length ; i++)
                            {
                                $('.isiJadwal').append( '<tr id="'+i+'">'+
                                                            '<th class="align-middle">'+jam[i]+'</th>');
                                
                                for(j = 0 ; j < lab.length ; j++)
                                {
                                    $('#'+i+'').append('<th class="pilihJamAjar" onclick="pilihJamAjar(\''+jam[i]+'\',\''+lab[j]+'\')"></th>');
                                }
                                $('.isiJadwal').append( '</tr>');
                            }
                        }
                    }
                });
            }
        });

        $('#jamMulai').change(function(){
            
            var jam    = parseInt($(this).val().substring(0, 2)) + parseInt(2);

            if(jam < 10) {
                jam = "0"+jam;
            }

            $('#jamSelesai').empty();

            while(jam <= 18) {
                $('#jamSelesai').append('<option value="'+jam+':00">'+jam+':00</option>');
                jam++;
            }
        });
    });
    
    $('#tampilModalJamAjar').on('click', function () {
        var tanggal = $('#fieldtanggal').val();

        if(tanggal == "")
        {
            $('.isiHeaderJadwal').empty();
            $('.isiJadwal').empty();
            $('.modal-body').find('h4').remove();
            $('.modal-body').append('<h4 class="pb-4 m-0 text-center">-- Silahkan pilih <strong>Tanggal Kuliah Pengganti</strong> terlebih dahulu --</h4>');
        }
    });

    $('#tampilModalLabTersedia').on('click', function () {
        var tanggal         = $('#fieldtanggal').val();
        var jamAwal         = $('#jamMulai').val();
        var jamAkhir        = $('#jamSelesai').val();
        var tanggalPinjam   = $('#fieldtanggal').val();
        
        if(tanggal == "" || jamAkhir == null)
        {
            $('.modal-body').empty();
            $('.modal-body').append('<h4 class="pb-3 m-0 text-center">-- Silahkan pilih <strong>Tanggal Pinjam</strong> dan <strong>Jam Pinjam</strong> terlebih dahulu --</h4>');
        }
        else {
            var content = "";
            $('.modal-body').empty();
            
            $.ajax({
                url: "./software/getData",
                type: "POST",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    if(data != 0) {
                        var i;
                        var j;
                        content += `<div class="container">
                                        <form id="softwareLab">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Silakan berikan tanda check(<i class="fa fa-check-square"></i>) pada software yang hendak digunakan</h5>
                                                </div>`;

                        for(i = 0 ; i < data['software'].length ; i++) {

                            j = data['software'][i];
                            
                            content +=          `<div class="col-md-3">
                                                    <input type="checkbox" name="software" value="`+j['id_software']+`" id="`+j['id_software']+`"><label for="`+j['id_software']+`">&nbsp;`+j['nama_software']+`</label>
                                                </div>`;
                        }

                        content += `            <div class="col-md-12">
                                                    <small class="text-info">Jika tidak menemukan software yang hendak digunakan atau memerlukan spesifikasi khusus, silakan cantumkan pada kolom '<strong>Keterangan Pinjam</strong>'.</small>
                                                </div>
                                                <div class="col-md-12 text-center mt-3">
                                                    <input type='hidden' name='tanggalPinjam' value='`+tanggalPinjam+`' readonly required>
                                                    <input type='hidden' name='jamAwal' value='`+jamAwal+`' readonly required>
                                                    <input type='hidden' name='jamAkhir' value='`+jamAkhir+`' readonly required>
                                                    <button type="submit" class="btn btn-success">Selesai <i class="fa fa-check-circle fa-lg"></i>
                                                </div>
                                            </div>
                                        </form>
                                    </div>`;

                        $('.modal-body').html(content);
                    }
                }
            });
        }
    });

    $.fn.serializeObject = function(){
    
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $(document).on('submit', '#softwareLab', function(e){
        var content         = "";
        var softwareLab     = $(this);
        var form_data       = JSON.stringify(softwareLab.serializeObject());
        var data            = JSON.parse(form_data);

        if(data.software == undefined) {
            data.software = 0;
        }

        $('.modal-body').empty();

        $.ajax({
            url: "./spesifikasi/getData",
            type: "POST",
            data : {"tanggalPinjam":data.tanggalPinjam, "jamAwal":data.jamAwal, "jamAkhir":data.jamAkhir, "software[]":data.software, "_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data) {

                if(data != 0) {
                    var flag    = [];
                    var row     = data['lab'];
                    var row2    = data['listlab'];
                    
                    for(i=0;i<row2.length;i++) {
                        for(j=0;j<row.length;j++) {
                            if(row[j]['id_lab'] == row2[i]['id_lab']) {
                                flag[i] = 1;
                                j = row.length;
                            }
                            else {
                                flag[i] = 0;
                            }
                        }
                    }
                    
                    content +=  `   <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Labkom Unit 7 Lantai 4</h5>
                                                <table class="table table-bordered text-center">
                                                    <tbody>
                                                        <tr>`;
                                                            if(flag[0] == 1) {
                                                                content += `<td width="16.5%" rowspan="2" class="pilihJamAjar" onclick="detailLab(`+row2[0]['id_lab']+`)"><br><strong>`+row2[0]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[0]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="16.5%" rowspan="2" class="bg-light text-muted notAllowed"><br><strong>`+row2[0]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[0]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            if(flag[1] == 1) {
                                                                content += `<td width="14.5%" height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[1]['id_lab']+`)"><strong>`+row2[1]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[1]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="14.5%" height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[1]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[1]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                    
                                                content += `<td width="14.5%" height="150px" class="bg-light text-muted p-5 notAllowed"><strong>Ruang Asisten</strong></td>
                                                            <td width="9%" style="border-top-color: white !important; border-bottom-color: white !important;"></td>`;
                                                            
                                                            if(flag[2] == 1) {
                                                                content += `<td width="14.5%" height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[2]['id_lab']+`)"><strong>`+row2[2]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[2]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="14.5%" height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[2]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[2]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            if(flag[3] == 1) {
                                                                content += `<td width="14.5%" height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[3]['id_lab']+`)"><strong>`+row2[3]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[3]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="14.5%" height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[3]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[3]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }

                                                content += `<td width="16.5%" rowspan="2" class="bg-light text-muted p-5 notAllowed"><br><strong>Ruang Staff</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                        </tr>
                                                        <tr>`;
                                                        
                                                            if(flag[9] == 1) {
                                                                content += `<td width="16.5%" rowspan="2" class="pilihJamAjar" onclick="detailLab(`+row2[9]['id_lab']+`)"><br><strong>`+row2[9]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[9]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="16.5%" rowspan="2" class="bg-light text-muted notAllowed"><br><strong>`+row2[9]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[9]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                content += `<td style="border-top-color: white !important; border-right-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-bottom-color: white !important; border-left-color: white !important;"></td>
                                                            <td style="border-top-color: white !important; border-right-color: white !important; border-left-color: white !important;"></td>
                                                            <td></td>`;
                                                            if(flag[4] == 1) {
                                                                content += `<td width="16.5%" rowspan="2" class="pilihJamAjar" onclick="detailLab(`+row2[4]['id_lab']+`)"><br><strong>`+row2[4]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[4]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td width="16.5%" rowspan="2" class="bg-light text-muted notAllowed"><br><strong>`+row2[4]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[4]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                            content += `</tr>
                                                        <tr>`;
                                                            if(flag[8] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[8]['id_lab']+`)"><strong>`+row2[8]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[8]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[8]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[8]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            if(flag[7] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[7]['id_lab']+`)"><strong>`+row2[7]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[7]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[7]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[7]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                            content += `    <td style="border-top-color: white !important; border-bottom-color: white !important;"></td>`;
                                                            if(flag[6] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[6]['id_lab']+`)"><strong>`+row2[6]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[6]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[6]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[6]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            if(flag[5] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[5]['id_lab']+`)"><strong>`+row2[5]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[5]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[5]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[5]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                            content += `</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <h5>Labkom Unit 7 Lantai 2</h5>
                                                <table class="table table-bordered text-center w-50">
                                                    <tbody>
                                                        <tr>`;
                                                        
                                                            if(flag[10] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[10]['id_lab']+`)"><strong>`+row2[10]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[10]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[10]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[10]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                            content += `</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <h5>Labkom Unit 6 Lantai 1</h5>
                                                <table class="table table-bordered text-center w-50">
                                                    <tbody>
                                                        <tr>`;
                                                            if(flag[11] == 1) {
                                                                content += `<td height="150px" class="pilihJamAjar" onclick="detailLab(`+row2[11]['id_lab']+`)"><strong>`+row2[11]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[11]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                                            else {
                                                                content += `<td height="150px" class="bg-light text-muted notAllowed"><strong>`+row2[11]['nama_lab']+`</strong><hr>Daya tampung: <strong>`+row2[11]['kapasitas_lab']+`</strong> Orang</td>`;
                                                            }
                                            content += `</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>`;

                    $('.modal-body').html(content);
                }
            }
        });

        e.preventDefault();
    });

    function detailLab(id) {

        $.ajax({
            url: "./lab/getData",
            type: "POST",
            data : {"id":id, "_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data) {
                if(data != 0) {

                    $('#tampilModalLabTersedia').val(data['ruangLab']['nama_lab']);
                    $('#lab').val(data['ruangLab']['id_lab']);

                    $('#modalLabTersedia').modal('toggle');
                }
            }
        })
    }

    $('input[name="asisten"]').on('click', function () {
        var butuh_asisten = $('input[name="asisten"]:checked').val();

        if(butuh_asisten == "ya") {
            $('#asisten_jaga').html('<div class="input-group mb-2">'
                                        +'<div class="input-group-prepend">'
                                            +'<label class="input-group-text"><i class="fa fa-user-circle"></i></label>'
                                        +'</div>'
                                        +'<select name="asisten_jaga" class="form-control">'
                                            +'<option value="1" selected>1 Asisten</option>'
                                            +'<option value="2">2 Asisten</option>'
                                            +'<option value="3">3 Asisten</option>'
                                            +'<option value="4">4 Asisten</option>'
                                        +'</select>'
                                    +'</div>');
        }
        else {
            $('#asisten_jaga').html('');
        }
    });
    
    $(document).on({
        mouseenter: function () {
            $(this).addClass("pilihJamAjarHover");
        },
        mouseleave: function () {
            $(this).removeClass("pilihJamAjarHover");
        }
    }, '.pilihJamAjar');
</script>
@include('sweetalert::alert')
</body>
</html>