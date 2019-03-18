@extends('layout.index')

@section('pageTitle', __('messages.title_my_profile'))

@section('meta_tags')
<meta name="keywords" content="{{ __('messages.meta_keyword_myprofile') }}"> 
<meta name="description" content="{{ __('messages.meta_desc_myprofile') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ Auth::user()->fname}}'s {{ __('messages.lbl_profile') }} {{ __('messages.lbl_edit') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="index.php">{{ __('messages.lbl_home') }} </a></li>
					<li>{{ __('messages.editprofile') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
			<div class="main col-sm-12 mainpbt">
				<div class="profileBox login">
					<div class="profileTitle">
						<div> <h1 class="center">{{ __('messages.contactsettings') }} </h1></div>
					</div>
					
					@if(session()->has('message.level'))
						<div class="col-md-12">
							<div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!} dasdasd
						    </div>
						</div>
					@endif
					
					<div class="profileBody">
						<form action="{{ url('updateprofile') }}" method="post" name="frmUpdateProfile" id="frmUpdateProfile">
							{{ csrf_field() }}
							<div class="row">
				                <div class="col-sm-3 col-sm-offset-2 text-right">
				                	<p class="profileLabel">  {{ __('messages.firstname') }}</p>
				                </div>
				                <div class="col-sm-5">
				                    <p class="profileInput"> <input class="form-control" type="text" value="{{ $objUser->fname }}" name="fname" id="fname"> </p>
				                </div>
			              	</div>
			              	
			              	<div class="row">
				                <div class="col-sm-3 col-sm-offset-2 text-right">
				                 <p class="profileLabel">  {{ __('messages.lastname') }}</p>
				                </div>
				                <div class="col-sm-5">
				                    <p class="profileInput"> <input class="form-control" type="text" value="{{ $objUser->lname }}" name="lname" id="lname"> </p>
				                </div>
			              	</div>
			              	
			              	<div class="row">
				                <div class="col-sm-3 col-sm-offset-2 text-right">
				                 <p class="profileLabel">  {{ __('messages.phoneNr') }}</p>
				                </div>
				                <div class="col-sm-5">
				                    <p class="profileInput"> <input class="form-control" type="text" value="{{ $objUser->phone }}" name="phone" id="phone"> </p>
				                </div>
			              	</div>
			              	
			              	<div class="row">
				                <div class="col-sm-4 col-sm-offset-1 text-right">
				                	<p class="profileLabel">  {{ __('messages.emailAddress') }}</p>
				                </div>
				                <div class="col-sm-5">
				                    <p class="profileInput"> <input class="form-control" type="text" value="{{ $objUser->email }}" name="email" readonly="readonly" > </p>
				                </div>
			              	</div>
			              	
			              	<div class="row">
			              		<div class="col-sm-4 col-sm-offset-1 text-right">
			              		</div>
			              		<div class="col-sm-5">
			              			<input type="submit" class="btn btn-fullcolor pull-right" style="font-weight: bold;width: 100px;" name="personalInfoSubmit" value="{{ __('messages.save') }}" />
			              		</div>
			              	</div>
						</form>
					</div>
				</div>
				
				<div class="profileBox login">
					<div class="profileTitle">
						<div> <h1 class="center">{{ __('messages.change_password') }} </h1></div>
					</div>
					
					<div class="profileBody">
						<form action="{{ url('updatepassword') }}" method="post" name="frmPassword" id="frmPassword">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-sm-3 col-sm-offset-2 text-right">
				                    <p class="profileLabel">  {{ __('messages.old_password') }} </p>
								</div>
								<div class="col-sm-5">
									<p class="profileInput"> <input class="form-control" type="password" name="old_password" id="old_password"> </p>
								</div>
								<div class="col-sm-7 col-sm-offset-5"></div>
							</div>
							
							<div class="row">
			                    <div class="col-sm-3 col-sm-offset-2 text-right">
			                    	<p class="profileLabel"> {{ __('messages.New_password') }} </p>
			                    </div>
			                    <div class="col-sm-5">
			                        <p class="profileInput"> <input class="form-control" type="password" name="new_password" id="new_password"> </p>
			                    </div>
		                  	</div>
		                  	
		                  	<div class="row">
			                    <div class="col-sm-3 col-sm-offset-2 text-right">
			                    	<p class="profileLabel">{{ __('messages.confirm_password') }}</p>
			                    </div>
			                    <div class="col-sm-5">
			                        <p class="profileInput"> <input class="form-control" type="password" name="confirmpassword" id="confirmpassword"> </p>
			                        <div class="profileInput" style="float:right"> <input type="submit" class="btn btn-fullcolor" name="passSubmit" value="{{ __('messages.change_password') }}" style="font-weight:bold;"> </div>
			                    </div>
			                </div>
							
						</form>
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
	$("#frmUpdateProfile").validate({
		rules: {
			"fname": {
				required: true
			},
			"lname": {
				required: true
			},
			"phone": {
				required: true
			}
		},
		messages: {
			"fname": {
				required: "Please enter first name."
			},
			"lname": {
				required: "Please enter last name."
			},
			"phone": {
				required: "@lang('messages.number_phone_required_message')"
			}
		}
	});

	$("#frmPassword").validate({
		rules: {
			"old_password": {
				required: true
			},
			"new_password": {
				required: true,
				minlength: 8,
				maxlength: 16
			},
			"confirmpassword": {
				required: true,
				equalTo: "#new_password",
				minlength: 8,
				maxlength: 16
			}
		},
		messages: {
			"old_password": {
				required: "Venlingst indtast din gamle adgangskode"
			},
			"new_password": {
				required: "Venlingst indtast dine nye adgangskode",
				minlength: "Password min length must be greater than or equal to 8 character.",
				maxlength: "Password max length must be less than or equal to 16 character."
			},
			"confirmpassword": {
				required: "Please enter confirm password.",
				equalTo: "Password and confirm password must be same.",
				minlength: "Confirm password min length must be greater than or equal to 8 character.",
				maxlength: "Confirm password max length must be less than or equal to 16 character."
			}
		}
	});
	
});
</script>
@endsection
