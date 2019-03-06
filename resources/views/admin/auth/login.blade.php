@extends('admin.layout.auth')

@section('pageTitle', 'Admin Login')

@section('content')
<div id="wrapper" class="container-fluid">
		<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 clearfix loginBx">
			<h3 class="blueclr text-center">Admin Login</h3>
			<div class="login-box">
				<div class="col-md-12" style="margin-top: 5px;"><!--  mtp15 -->
					<div class="gray-bg">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
						<form class="" role="form" method="POST" action="{{ url('/admin/login') }}" name="frmLogin" id="frmLogin">
							{{csrf_field()}}
							<div class="form-group">
								<label for="exampleInputEmail1">Email</label> 
								<input type="text" class="form-control" placeholder="" name="email" id="email" value="{{ old('email') }}" />
								 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label> 
								<input type="password" class="form-control" placeholder="" name="password" id="password" value="zg%!';|~w`+jq" />
								@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
							</div>
							
							<div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
	                        </div>
	                        
	                        <div class="form-group forgot_btn">
								<button type="submit" class="btn pull-right btnblue" name="btnLogin" id="btnLogin">LOGIN</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
<script type="text/javascript">
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
				required: "Please enter email.",
				email: "Please enter valid email."
			},
			"password": {
				required: "Please enter password."
			}
		}
	});
});
</script>
@endsection