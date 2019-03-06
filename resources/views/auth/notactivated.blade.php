@extends('layout.index')

@section('pageTitle', 'Thank you for register !')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Your account has not yet been activated!</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home')}} </a></li>
					<li>Your account has not yet been activated!</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		 <div class="row green" style="padding-top:70px; padding-bottom:30px; border-bottom:solid 1px #ccc;">
			<div class="main col-sm-12" style="text-align:center; font-weight:bold;">
				<h3 style="color: #4D4F56;">Please activate your account before proceeding.</h3><br/>
				<h3 style="color: #4D4F56;">An e-mail has been sent to you with the activation code. Follow the link inside the e-mail to activate your account.</h3><br/>
				<h3 style="color: #4D4F56;">If you didn't receive the e-mail with the activation code, please click <a href="{{ url('/'.'resend_code') }}">here</a>.</h3>
	          	<br/>
	          	<!-- <h1 style="color: #4D4F56;"> <i class="fa fa-lg fa-spinner fa-spin"></i></h1> -->
	          	<script type="text/javascript">/*
	          		window.setTimeout(function(){
	          			window.location.href="{{ url('/') }}";
		          	}, 3000);*/
	          	</script>
			</div>
		</div>
	</div>
</div>
@endsection
