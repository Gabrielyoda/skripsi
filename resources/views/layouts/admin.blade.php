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
            <a href="{{ Route('home') }}" class="nav-link text-center"><i class="fa fa-calendar fa-lg"></i> Sistem Penjadwalan</a>
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
    $(function() {
        $('#fieldtanggal').datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
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
    });
</script>
@include('sweetalert::alert')
</body>
</html>