@extends('layout.index')

@section('pageTitle', __('messages.resettitle'))

@section('meta_tags')
<meta name="keywords" content=""> 
<meta name="description" content="{{ __('messages.resettitle') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{  __('messages.resettitle') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home')}} </a></li>
					<li>{{  __('messages.resettitle') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->
		

<div class="content">
	<div class="container">
		<div class="row">
			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-md-10 col-md-offset-1 mainpbt">
				<div class="row">
				
					@if(session()->has('message.level'))
						<div class="col-md-12">
							<div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						</div>
					@endif
				
					<div class="col-md-6 col-md-offset-3 col-sm-12 ">
						<div class="form-col">
							<h1 class="center">{{ __('messages.resettitle') }}</h1>
							<br>
							<form action="{{ url('submit_resetpwd') }}" method="post" class="" name="frmResetPwd" id="frmResetPwd">
								{{ csrf_field() }}

								<input type="hidden" name="token" value="{{ $token }}">

								<div class="form-group">
									<label>E-mail</label>
		                        	<input type="email" name="email" id="email" class="form-control"  value="" />
		                        </div>

								<div class="form-group">
									<label>{{ __('messages.New_password') }}</label>
		                        	<input type="password" name="password" id="password" class="form-control"  value="" />
		                        </div>
		                        
		                        <div class="form-group">
									<label>{{ __('messages.confirm_password') }}</label>
		                        	<input type="password" name="password_confirmation" id="password_confirmation" class="form-control"  value="" />
		                        </div>
								
								<button type="submit" name="btnResetPwd" id="btnResetPwd" class="btn btn-fullcolor">{{ __('messages.save') }}</button>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#frmResetPwd").validate({
		rules: {
			"new_password": {
				required: true
			},
			"confirm_password": {
				required: true,
				equal_to: "#new_password"
			}
		},
		messages: {
			"new_password": {
				required: "Please enter new password."
			},
			"confirm_password": {
				required: "Please enter confirm password.",
				equal_to: "Password and confirm password must be same."
			}
		}
	});
});
</script>
@endsection
