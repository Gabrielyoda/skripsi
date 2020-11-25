@if(Session::get('jabatan') != 'SPV')
    <script>
        window.location = "http://localhost:8000/";
    </script>
@endif
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Pilih</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
</head>
<body>
<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-10 offset-xl-7 offset-lg-6 offset-md-6 offset-sm-4 offset-1">
        <div class="card border-info" style="margin-top:30%;">
            <div class="card-header text-center text-info"><h4>Selamat Datang<br>{{ $nama }}</h4></div>
            <div class="card-body text-secondary">
                <label>Silahkan pilih semester dan tahun ajaran yang diinginkan :</label>
                <form action="{{ Route('tampilwaktu') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="text-muted">Tahun Ajaran :</label>
                        <select class="form-control" name="thnajar" required>
                            @foreach($tahunajaran as $tahunajar)
                                <option value="{{ $tahunajar -> tahunajaran }}" {{ ($datatahunajar == $tahunajar -> tahunajaran) ? 'selected':'' }}>{{ $tahunajar -> tahunajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="text-muted">Semester :</label>
                        <select class="form-control" name="smt" required>
                            @foreach($semester as $semesters)
                                <option value="{{ $semesters -> semester }}" {{ ($datasemester == $semesters -> semester) ? 'selected':'' }}>{{ $semesters -> semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="submit" class="btn btn-outline-primary w-100" value="Tampilkan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
</body>
</html>
