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

	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window,document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	 fbq('init', '1012727565781898');
	fbq('track', 'PageView');
	</script>
	<noscript>
	 <img height="1" width="1"
	src="https://www.facebook.com/tr?id=1012727565781898&ev=PageView
	&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->

	<?php if(isset($_SESSION['runFBRegistrationPixelCode']) && ($_SESSION['runFBRegistrationPixelCode'] == true)) { ?>

	<!-- Facebook Conversion Code for Registrering - Eser Arslan 1 -->
	<script type="text/javascript">
		(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', '6026908496074', {'value':'0.00','currency':'DKK'}]);
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6026908496074&amp;cd[value]=0.00&amp;cd[currency]=DKK&amp;noscript=1" /></noscript>
	<?php unset($_SESSION['runFBRegistrationPixelCode']); } ?>

	<?php if(isset($_SESSION['runFBConversionPixedCode']) && ($_SESSION['runFBConversionPixedCode'] == true)) { ?>
	<!-- Facebook Conversion Code for Betalinger -->
	<script type="text/javascript">
		(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', '6026141317074', {'value':'<?php echo $_SESSION['FBConversionPixedAmount']; ?>','currency':'DKK'}]);
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6026141317074&amp;cd[value]=<?php echo $_SESSION['FBConversionPixedAmount']; ?>&amp;cd[currency]=DKK&amp;noscript=1" /></noscript>
	<?php
		unset($_SESSION['runFBConversionPixedCode']);
		unset($_SESSION['FBConversionPixedAmount']);
		}
	?>

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
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-54365304-1', 'auto');
	  ga('send', 'pageview');
	</script>
</body>
</html>
