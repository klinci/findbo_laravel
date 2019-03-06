<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('pageTitle') | {{ config('app.name', 'FindBO') }}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- Fav and touch icons -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/images/favicon.ico') }}" />
	
	<!-- Bootstrap -->
	<link href="{{ asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/bootstrap-theme.css') }}" rel="stylesheet">
	
	<!-- Custom -->
	<link href="{{ asset('public/admin/css/fonts/fonts.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/font-awesome.css') }}" rel="stylesheet">
	
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/> -->
	
	<!-- <link href="{{ asset('public/admin/css/datatables/css/demo_table.css') }}" rel="stylesheet"> -->
	<link href="{{ asset('public/admin/css/datatables/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('public/admin/css/main.css') }}" rel="stylesheet">
	
	<link href="{{ asset('public/admin/css/datatable_1_10/datatables.css') }}" rel="stylesheet">
	
	<!----Header-css---->
	<link href="{{ asset('public/admin/css/sidemenu.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/admin/css/jquery.navgoco.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('public/admin/css/jquery.mCustomScrollbar.css') }}">
	
	@yield('styles')
	
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
	<div id="wrapper">
		@include('admin.layout.left')
		<section id="content">
			@include('admin.layout.header')
			@yield('content')
		</section>
	</div>
	<script src="{{ asset('public/admin/js/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ asset('public/admin/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('public/admin/js/main.js') }}"></script>
	<script src="{{ asset('public/admin/js/sidemenu.js') }}"></script>
	<script src="{{ asset('public/admin/js/jquery.navgoco.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	@yield('scripts');
</body>
</html>