<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name', 'FindBO') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- Bootstrap -->
	<link href="{{ asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/bootstrap-theme.css') }}" rel="stylesheet">
	<!-- Custom -->
	<link href="{{ asset('public/admin/css/fonts/fonts.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/main.css') }}" rel="stylesheet">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="{{ asset('public/admin/js/html5shiv.js') }}"></script>
	<script src="{{ asset('public/admin/js/respond.min.js') }}"></script>
	<![endif]-->
	
	 <!-- Scripts -->
    <script type="text/javascript">
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
	<header style="background-color: #FFFFFF;">
		<div class="container-fluid">
			<div class="col-lg-12 clearfix">
				<div class="row">
					<div class="col-sm-12 col-md-12 text-center">
						<a class="login-logo"><img src="{{ asset('public/admin/images/logo.png') }}" alt="{{ config('app.name', 'FindBO') }}" class="img-responsive"> </a>
					</div>
				</div>
			</div>
		</div>
	</header>

    @yield('content')
    
	<!-- Scripts -->
    <script src="{{ asset('public/admin/js/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ asset('public/admin/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('public/admin/js/popover.js') }}"></script>
	<script src="{{ asset('public/admin/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('public/admin/js/common.js') }}"></script>
    @yield('scripts');
</body>
</html>
