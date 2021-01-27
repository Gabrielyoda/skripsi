@if(Session::get('jabatan') != 'SPV')
    <script>
        window.location = "http://localhost:8000/";
    </script>
@endif
<!DOCTYPE html>
<html>
<head>
    <title>Admin - {{ $title }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.css') }}">
</head>
<body>
<div class="container-fluid" id="wrapper">
	<div class="row">
		<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2 pt-2">
            <a href="{{ Route('home') }}" class="nav-link text-center"><i class="fa fa-calendar fa-lg"></i> Sistem Peminjaman Lab</a>
			<hr>
			<a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i class="fa fa-bars"></i></a>
            <ul class="nav nav-pills flex-column sidebar-nav">
                <li class="nav-item"><a class="nav-link {{ ($title=='Dashboard') ? 'active':'' }}" href="{{ Route('home') }}"><h6><i class="fa fa-tasks fa-lg"></i> Dashboard</h6></a></li>
                <div class="label-sidebar">
                    <li class="nav-item"><a class="nav-link {{ ($title=='Data Waktu') ? 'active':'' }}" href="{{ Route('waktu') }}"><h6><i class="fa fa-circle-o fa-lg"></i> Waktu</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Users') ? 'active':'' }}" href="{{ Route('users') }}"><h6><i class="fa fa-user fa-lg"></i> Users</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Data Matakuliah') ? 'active':'' }}" href="{{ Route('mtk') }}"><h6><i class="fa fa-home fa-lg"></i> Matakuliah</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Dosen') ? 'active':'' }}" href="{{ Route('dosen') }}"><h6><i class="fa fa-users fa-lg"></i> Dosen</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Data Lab') ? 'active':'' }}" href="{{ Route('lab') }}"><h6><i class="fa fa-home fa-lg"></i> Ruang Lab.kom</h6></a></li>
                    <!-- <li class="nav-item"><a class="nav-link {{ ($title=='Software') ? 'active':'' }}" href="{{ Route('software') }}"><h6><i class="fa fa-flag fa-lg"></i> Software</h6></a></li> -->
                </div>
                <div class="label-sidebar">
                    <!-- <li class="nav-item"><a class="nav-link {{ ($title=='Spesifikasi Lab') ? 'active':'' }}" href="{{ Route('spek') }}"><h6><i class="fa fa-gear fa-lg"></i> Spesifikasi Lab</h6></a></li> -->
                    <li class="nav-item"><a class="nav-link {{ ($title=='Jadwal') ? 'active':'' }}" href="{{ Route('jadwal') }}"><h6><i class="fa fa-calendar-o fa-lg"></i> Jadwal</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Kelas Pengganti') ? 'active':'' }}" href="{{ Route('kelaspengganti') }}"><h6><i class="fa fa-calendar fa-lg"></i> Kuliah Pengganti</h6></a></li>
                    <li class="nav-item"><a class="nav-link {{ ($title=='Pinjam Lab') ? 'active':'' }}" href="{{ Route('pinjamlab') }}"><h6><i class="fa fa-calendar fa-lg"></i> Peminjaman Lab</h6></a></li>
                </div>
            </ul>
		</nav>

		<main class="col-xs-12 col-sm-8 col-lg-9 col-xl-10 pt-3 pl-4 ml-auto">
            <header class="page-header row justify-center">
                <div class="col-md-6 col-lg-8" >
                    <h5 class="float-left text-center text-muted">Sistem Penjadwalan - {{ $semester }} {{ $tahunajaran }} <a href="{{ Route('ubahwaktu') }}" class="btn btn-primary">Ubah</a></h5>
                </div>
                <div class="dropdown user-dropdown col-md-6 col-lg-4 text-center text-md-right"><a class="btn btn-stripped dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('img/admin-user.png') }}" alt="Foto Profil" class="profile-photo" width="50" height="auto">
                    <div class="username mt-1">
                        <h5 class="mb-1">{{ $nama }}</h5>
                        <h6 class="text-muted">Administrator</h6>
                    </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="margin-right: 1.5rem;" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ Route ('profil') }}"><i class="fa fa-user-circle mr-1"></i> Profil</a>
                        <a class="dropdown-item" href="{{ Route('logout') }}"><i class="fa fa-power-off mr-1"></i> Keluar</a>
                    </div>
                </div>
                <div class="clear"></div>
            </header>
			@yield('content')
		</main>
	</div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

<script>
     $('#inputfieldtanggal').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
        });

        $('#inputtanggal').click(function() {
            $('#inputfieldtanggal').datepicker('show');
        });

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
        $('#fieldtanggal').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
            startDate: '+d',
        });
    });

    $(document).ready(function(){

        $("#namaMatkulJadwal").change(function(){
            var idjadwal    = $(this).val();
            
            if(idjadwal) {
                $.ajax({
                    url: "./../../../admin/jadwal/sks",
                    type: "POST",
                    data : {"idjadwal":idjadwal, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data != 0){
                            var i = 0;
                            var panjangarray = data.length;

                            if($("#jamAjar").length == 0) {
                                $('#isimanual').empty();
                                $('#isiotomatis').append('<select class="form-control" name="jamAjar" id="jamAjar" required></select>');
                            }

                            $('#jamAjar').empty();
                            for(i = 0 ; i < panjangarray ; i++)
                            {
                                $('select[name="jamAjar"]').append('<option value="'+data[i]+'">'+data[i]+'</option>');
                            }
                        }
                        else{
                            if($("#jamAjar").length) {
                                $('#isiotomatis').empty();
                                $('#isimanual').append('<input type="text" name="jamAjar" class="form-control" placeholder="Jam Masuk - Jam Keluar     contoh: 12:30 - 16:05" required>');
                            }
                        }
                    }
                });
            }
            else
            {
                $('#jamAjar').empty();
            }
        });
        
        $("#namaMatkulKP").change(function(){
            var idjadwal    = $(this).val();
            
            if(idjadwal) {
                $.ajax({
                    url: "./../../../admin/jadwal/sks",
                    type: "POST",
                    data : {"idjadwal":idjadwal, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data != 0){
                            var i = 0;
                            var panjangarray = data.length;

                            if($("#jamAjar").length == 0) {
                                $('#isimanual').empty();
                                $('#isiotomatis').append('<select class="form-control" name="jamAjar" id="jamAjar" required></select>');
                            }

                            $('#jamAjar').empty();
                            for(i = 0 ; i < panjangarray ; i++)
                            {
                                $('select[name="jamAjar"]').append('<option value="'+data[i]+'">'+data[i]+'</option>');
                            }
                        }
                        else{
                            if($("#jamAjar").length) {
                                $('#isiotomatis').empty();
                                $('#isimanual').append('<input type="text" name="jamAjar" class="form-control" placeholder="Jam Masuk - Jam Keluar     contoh: 12:30 - 16:05" required>');
                            }
                        }
                    }
                });
            }
            else
            {
                $('#jamAjar').empty();
            }
        });

        $("#namaMatkulKP").change(function(){
            var idmtk    = $(this).val();
            
            if(idmtk) {
                $.ajax({
                    url: "./../../../kuliahpengganti/dosen",
                    type: "POST",
                    data : {"idmtk":idmtk, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data['dosen'] != 0){
                            var i = 0;
                            var panjangarray = data['dosen'].length;

                            $('#kelompok').empty();
                            $('#namaDosenKP').empty();
                            
                            $('select[name="kelompok"]').append('<option value="" disabled selected>-- Pilih Kelompok --</option>');
                            $('select[name="namaDosen"]').append('<option value="" disabled selected>-- Pilih Dosen Pengajar --</option>');
                            for(i = 0 ; i < panjangarray ; i++)
                            {
                                $('select[name="namaDosen"]').append('<option value="'+data['dosen'][i].id_user+'">'+data['dosen'][i].nama+'</option>');
                            }
                        }
                        else{
                            $('#kelompok').empty();
                            $('#namaDosenKP').empty();

                            $('select[name="kelompok"]').append('<option value="" disabled selected>-- Pilih Kelompok --</option>');
                            $('select[name="namaDosen"]').append('<option value="" disabled selected>Data Tidak Ditemukan</option>');
                        }
                    }
                });
            }
        });

        $("#namaDosenKP").change(function(){
            var idmtk       = $("#namaMatkulKP").val();
            var iddosen     = $(this).val();
            
            
            if(idmtk && iddosen) {
                $.ajax({
                    url: "./../../../kuliahpengganti/kelompok",
                    type: "POST",
                    data : {"iddosen":iddosen, "idmtk":idmtk, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
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

   

   

    // $(document).ready(function(){

    //     $('#sidebar').mCustomScrollbar({
    //         theme: "minimal"
    //     });

    //     $('#dismiss, .overlay').on('click', function () {
    //         $('#sidebar').removeClass('active');
    //         $('.overlay').removeClass('active');
    //     });

    //     $('#sidebarCollapse').on('click', function () {
    //         $('#sidebar').addClass('active');
    //         $('.overlay').addClass('active');
    //         $('.collapse.in').toggleClass('in');
    //         $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    //     });
    $(".tabelUser").fadeIn(300);

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
                    url: "./../../../home/waktu",
                    type: "POST",
                    data: {"waktu":waktu, "hari":hari, "_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    beforeSend:function() {
                        $(".tabelUser").fadeOut(300);
                        $('.isiJadwal').empty();
                    },
                    success:function(data) {
                        console.log(data);
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
                                                                    '<p class="isitabel m-0">'+row['nama']+'</p>'+
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
                                                                    '<p class="isitabel m-0">'+row['nama']+'</p>'+
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

        

        $("#fieldtanggal").change(function(){
            var tanggalKP    = $(this).val();
            
            
            if(tanggalKP) {
                $.ajax({
                    url: "./../../../kuliahpengganti/jamajar",
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