<!DOCTYPE html>
<html>
<head>
    <title>Daftar Admin</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />

    <style>
        .box
        {
            margin-top:5%;
            padding:25px;
            border:1px solid black;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-lg-4 col-sm-6 col-8 offset-lg-4 offset-sm-3 offset-2 box">
        <h2>Daftar Admin</h2>
                
        @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p>{{ $message }}</p>
        </div>
        @endif
      
        <form action="{{ Route('prosesdaftaradmin') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('nim') ? 'has-error' : '' }}">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control">
                <small class="text-danger">{{ $errors->first('nim') }}</small>
            </div>
            <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control">
                <small class="text-danger">{{ $errors->first('nama') }}</small>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label>Kata Sandi</label>
                <input type="password" name="password" class="form-control">
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <div class="form-group {{ $errors->has('cpassword') ? 'has-error' : '' }}">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="cpassword" class="form-control">
                <small class="text-danger">{{ $errors->first('cpassword') }}</small>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Daftar">
                <a href="{{ Route('loginadmin') }}" class="btn btn-secondary">Masuk</a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
</body>
</html>