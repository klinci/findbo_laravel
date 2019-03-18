@extends('layout.index')

@section('pageTitle', __('messages.title_forgot_password'))

@section('meta_tags')
<meta name="keywords" content=""> 
<meta name="description" content="{{ __('messages.title_forgot_password') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">{{  __('messages.title_forgot_password') }}</h1>
                
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ __('messages.lbl_home')}} </a></li>
                    <li>{{  __('messages.title_forgot_password') }}</li>
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
                            <h1 class="center">{{ __('messages.lbl_create_new_account') }}</h1>
                            <br>
                            <form action="{{ route('submit_forgotpwd') }}" method="post" class="" name="frmForgotPwd" id="frmForgotPwd">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ __('messages.enteremailaddress') }}</label>
                                    <input type="text" name="email" id="resetEmail" class="form-control"  value="" />
                                </div>
                                
                                <button type="submit" name="btnForgotPwd" id="btnForgotPwd" class="btn btn-fullcolor">{{ __('messages.lbl_send_mail_to_reset_pwd') }}</button>
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
    $("#frmForgotPwd").validate({
        rules: {
            "resetEmail": {
                required: true,
                email: true
            }
        },
        messages: {
            "resetEmail": {
                required: "Please enter email address.",
                email: "Please enter valid email address."
            }
        }
    });
});
</script>
@endsection
