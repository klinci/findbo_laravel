@extends('layout.index')

@section('pageTitle', __('messages.title_login_register'))

@section('meta_tags')
<meta name="keywords" content="">
<meta name="description" content="{{ __('messages.title_login_register') }}">
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{  __('messages.signinto_yacconunt') }}</h1>

				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home')}} </a></li>
					<li>{{  __('messages.signinto_yacconunt') }}</li>
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

					@foreach($errors->all() as $error)
						<div class="alert alert-danger">{{ $error }}</div>
					@endforeach

					<div class="col-md-6 col-sm-12 ">
						<div class="form-cols form-col">
							<h1 class="center">{{ __('messages.lbl_create_new_account') }}</h1>
							<br>
							<form action="{{ url('register') }}" method="post" class="" name="frmRegister" id="frmRegister">
								{{ csrf_field() }}
								<input type="hidden" name="previous_page" value="{{ URL::previous() }}" />
								<div class="form-group">
									<label class="control-label">{{ __('messages.selectUserType') }}</label>
									<select class="regSelect" id="usertype" name="usertype">
										<option value="">{{ __('messages.selectUserType') }}</option>
			                            <option value="2">{{ __('messages.houseHunter') }}</option>
			                            <option value="1">{{ __('messages.landlord') }}</option>
									</select>
								</div>

								<div class="form-group">
									<label>{{ __('messages.firstname') }}</label>
		                        	<input type="text" name="fname" id="Name" class="form-control"  value="" /><span id="NameFeed"></span>
		                        </div>

								<div class="form-group">
									<label>{{ __('messages.lastname') }}</label>
									<input type="text" name="lname" id="LastName" class="form-control" value="" /><span id="LastNameFeed"></span>
								</div>

								<div class="form-group">
									<label>{{ __('messages.email') }}</label>
									<input type="email" name="email" id="Email" class="form-control" value="" onblur="return CheckEmailRegistered(this.value);" onkeydown="RemoveEmailMessage();" />
									<span id="email_message"></span>
								</div>

								<div class="form-group">
									<label>{{ __('messages.password') }}</label>
									<input type="password" name="password" id="Password" class="form-control" />
								</div>

								<div class="form-group">
									<label>{{ __('messages.confirm_password') }}</label>
									<input type="password" name="password_confirmation" id="ConfirmPassword" class="form-control" />
								</div>

								<div class="checkbox">
									<label for="contact">
										<input type="checkbox" name="contact" id="contact" />
										{{ __('messages.acceptOur') }} <a href="{{ url('terms_condition') }}">{{ __('messages.termsAndConditions') }}</a>.
									</label>
								</div>

								<button type="submit" name="btnRegister" id="btnRegister" class="btn btn-fullcolor">{{ __('messages.createAccount') }}</button>
							</form>
						</div>
					</div>

					<div class=" col-md-6 col-sm-12">
						<div class="form-col">
							<h1 class="center">{{  __('messages.signinto_yacconunt') }}</h1>
							<br>
								<div class="col-sm-12">
								 <form class="" method="POST" action="{{ url('loginsubmit') }}" name="frmLogin" id="frmLogin">
								 	{{ csrf_field() }}
								 	<input type="hidden" name="previous_page" value="{{ URL::previous() }}" />
								 	<div class="form-group">
										<label>{{  __('messages.username') }}</label>
										<input type="email" name="email" id="email" class="form-control" />
									</div>

									<div class="form-group">
										<label>{{  __('messages.password') }}</label>
										<input type="password" name="password" id="pass" class="form-control" />
									</div>

									<div class="checkbox" style="background-color:transparent; margin: 0;">
										<label>
											<input type="checkbox" name="remember" /> <span style="display:block;">{{  __('messages.remembermodal') }}</span>
										</label>
									</div>

									<div class="form-group">
										<input type="submit" name="submit" value="{{  strtoupper(__('messages.signin')) }}" class="btn btn-primary loginBtn col-sm-12" style="background-color: #28a9e2; color:#FFFFFF; font-weight: bold;" />
									</div>
									<br><br>
									<div class="row">
										<div class="col-sm-12 text-left">
											<a class="forgotPass" href="{{ url('forgot_password') }}"> {{  __('messages.forgotmodal') }} </a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-12" style="margin: 5px 0px;">
											<div id="buttons">
												<div id="fb-root" style="float:left; width:1px;"></div>
												<script>
													window.fbAsyncInit = function() {
																					FB.init({
																						appId: '959420850739921',
																						cookie: true,
																						xfbml: true,
																						oauth: true
																					});
																				};

													(function() {
													var e = document.createElement('script'); e.async = true;
													e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
													document.getElementById('fb-root').appendChild(e);
													}());

													function fblogin()
													{
														$.cookie('btn_invoked_login', $("#btnInvokedLogin").val(), { path: '/' });
														$.cookie('rd_url', $("#loginRedirectURL").val(), { path: '/' });

														FB.login(function(response){
														if (response.authResponse) {
														window.location='modules/facebook_login/facebook/validatefb.php';
														}
														},{scope: 'email'});
													}
												</script>
												<!--
												<a href="#" style="font-size: 14px; font-weight: bold;" class="btn btn-primary btn-block btn-social btn-facebook" onClick="fblogin();">
													<i class="fa fa-facebook"></i> {{  __('messages.signinFacebook') }}</a>
												-->
												<a href="{{url('/redirect')}}" style="font-size: 14px; font-weight: bold;" class="btn btn-primary btn-block btn-social btn-facebook"><i class="fa fa-facebook"></i> {{  __('messages.signinFacebook') }}</a>
											</div>
										</div>
									</div>

								 </form>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/js/jquery.validate.js') }}"></script>
<script>
$(document).ready(function(){
	$("#frmLogin").validate({
		rules: {
			"email": {
				required: true,
				email: true
			},
			"password": {
				required: true
			}
		},
		messages: {
			"email": {
				required: "Please enter email address.",
				email: "Please enter valid email address."
			},
			"password": {
				required: "Please enter password."
			}
		}
	});

	$("#frmRegister").validate({
		rules: {
			"usertype": {
				required: true
			},
			"fname": {
				required: true
			},
			"lname": {
				required: true
			},
			"email": {
				required: true,
				email: true
			},
			"password": {
				required: true
			},
			"contact": {
				required: true
			}
		},
		messages: {
			"usertype": {
				required: "Please enter user type."
			},
			"fname": {
				required: "Please enter first name."
			},
			"lname": {
				required: "Please enter last name."
			},
			"email": {
				required: "Please enter email.",
				email: "Please enter valid email."
			},
			"password": {
				required: "Please enter password."
			},
			"contact": {
				required: "Please confirm with terms & conditions."
			}
		}
	});

	$("#btnRegister").click(function(){
		if(!$("#contact").is(":checked"))
		{
			alert("Please confirm with terms & conditions.");
			return false;
		}
	});
});

function CheckEmailRegistered(email)
{
	$.ajax({
		type: "POST",
		url: "{{ url('check_email_registered') }}",
		data: {
						"_token": "{{ csrf_token() }}",
						"email" : email
					},
		cache: false,
		success: function(data){
			 if(data.success == '0')
			 {
				 	$('#email_message').html('<label for="Email" generated="true" class="error" style="display: inline-block;">' + data.message + '</label>');
			 }
			 else if(data.success == '1')
			 {
				 	$('#email_message').html('<label for="Email" generated="true" class="text-success" style="display: inline-block;">' + data.message + '</label>');
			 }
			 else
			 {
				 	$('#email_message').html('');
			 }
		}
	});
}

function RemoveEmailMessage()
{
		$('#email_message').html('');
}
</script>
@endsection
