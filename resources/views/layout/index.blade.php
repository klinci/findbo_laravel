<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="da"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<!-- Page Title -->
	<Title>@yield('pageTitle') | {{ config('app.name', 'FindBO') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	@yield('meta_tags')

	<!-- Mobile Meta Tag -->


	<!-- Fav and touch icons -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/fav_touch_icons/favicon.ico') }}" />

	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link href="https://fonts.googleapis.com/css?family=Raleway:300,500,900%7COpen+Sans:400,700,400italic" rel="stylesheet" type="text/css" />
	<link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/css/jquery-ui.css') }}" rel="stylesheet" />
	<link href="{{ asset('public/js/autocomplete/jquery.autocomplete.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ asset('public/js/modernizr-2.8.1.min.js') }}"></script>

	<style>
	.ui-menu-item {
		color: #333;
		padding: 8px 6px;
	}
	.ui-menu-item:hover {
		background-color: #ddd;
	}
	#ui-id-14:hover {
		background-color: transparent !important;
		border: 0;
		color: #333;
	}
	</style>
	@yield('styles')
</head>
<body>
	<!-- BEGIN WRAPPER -->
	<div id="wrapper">
		@include('layout.header')

		@yield('content')

		@include('layout.footer')

	</div>

	<!-- Libs -->
	<script src="{{ asset('public/js/jquery-ui.js') }}"></script>
	<script src="{{ asset('public/js/autocomplete/jquery.autocomplete.js') }}"></script>
	<script src="{{ asset('public/js/jquery.prettyPhoto.js') }}"></script>
	<script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('public/js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('public/js/infobox.min.js') }}"></script>
	<script src="{{ asset('public/js/bootstrap-checkbox.js') }}"></script>

	<!-- Template Scripts -->
	<script src="{{ asset('public/js/variables.js') }}"></script>
	<script src="{{ asset('public/js/scripts.js') }}"></script>

	@yield('scripts')

	<script>
		$(document).ready(function()
		{
			$("#mc-embedded-subscribe").click(function(){

				if($("#newsletter_email").val()!="")
				{
					$("#mc-embedded-subscribe-form").submit();
					/*
					var $form = $("#mc-embedded-subscribe-form");
					register($form);
					*/
				}
				else
				{
					alert("Please enter email.");
					return false;
				}
			});
		});
	</script>
</body>
</html>
