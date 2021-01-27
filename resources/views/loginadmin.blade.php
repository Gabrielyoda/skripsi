<!DOCTYPE html>
<html>
<head>
    <title>Admin - Login</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" />
    
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/vendor/chartist/css/chartist-custom.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
</head>
<body>
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="{{ asset('template/img/logolab.png')}}" alt="Klorofil Logo"></div>
								<p class="lead">Login User</p>
							</div>

                            @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{{ $message }}</p>
                                </div>
                            @endif

							<form class="form-auth-small" action="{{ Route('prosesloginadmin') }}" method="post">
                            {{ csrf_field() }}
								<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email"  name="email" placeholder="Email" class="form-control" required>
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
								</div>
								<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control"  name="password" placeholder="Password" required>
                                    <small class="text-danger">{{ $errors->first('password') }}</small> 
								</div>
								
                                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                
                                <div class="bottom">
									<span class="helper-text"></i> <a href="{{ Route('jadwalall') }}">Kembali</a></span>
								</div>
								
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Sistem Penjadwalan dan Peminjaman Ruang Lab</h1>
							<p>Lab ICT Budiluhur</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
    </div>
    
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<script>
Toggle Show Password
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    }
    else {
        input.attr("type", "password");
    }
});
</script>
</body>
</html>
