@extends('admin.layout.index')

@section('pageTitle', 'View Profile')

@section('styles')
<style type="text/css">
.panel.panel-profile > .panel-heading {
    text-transform: uppercase;
}
.bg-blue {
    background-color: #1c7ebb;
    color: #fff;
}
.panel-heading {
    border-radius: 2px 2px 0 0;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.panel-profile .profile {
    border-radius: 50%;
    box-shadow: 0 0 0 5px #2b9adf, 0 0 10px 0 rgba(0, 0, 0, 0.2);
    margin: 5px 15px 5px 5px;
}
.bg-white a {
    color: #2e3e4e;
}
.panel-profile .profile img {
    border-radius: 50%;
    background-color: #fff;
}
img.img80_80 {
    height: 80px;
    width: 80px;
}
h3 { margin-top: 20px; }
.list-group-item.border_none {
    border: none;
}
.panel-profile .list-group.w_border {
    border: 1px solid #e8e8e8;
}
.panel-profile .list-group {
    font-size: 14px;
}
.list-group {
    border-radius: 2px;
}
ul.panel { border: none; }
 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 

</style>
@endsection

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">View Profile</h3>
			</div>
			
			<div class="x_panel">
				<div class="row">
					<div class="col-md-12  col-sm-12 ptp10">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
					</div>
					<div class="clearfix"></div>
					
					<div class="col-md-6 col-sm-12 ptp10">
						<div class="panel panel-profile">
            				<div class="panel-heading bg-blue clearfix">
								<a class="pull-left profile">
									<img class="img-circle img80_80" src="{{ asset('public/admin/images/user_default.png') }}" width="80" alt="">
								</a>
								<h3 class="ng-binding"><?php echo $objUser->fname.' '.$objUser->lname;?></h3>
								<p>
									<?php 
									if($objUser->userType==1)
									{
										echo 'Landlord';
									}
									else
									{
										echo 'House Seeker';
									}
									?>
								</p>
							</div>
							<form role="form" method="post" action="{{ url('admin/users/updateprofile') }}">
								{{ csrf_field() }}
								<input type="hidden" name="txtId" id="txtId" value="<?php echo $id;?>" />
								<ul class="list-group w_border">
									<li class="list-group-item border_none">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
											<input class="form-control" id="email_id" name="email_id" value="<?php echo $objUser->email;?>" type="text">
										</div>
										<span id="errorMsg_email_id" style="color: #FF0000;display:none;">Email already exists. Please enter different.</span>
									</li>
									<li class="list-group-item border_none">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-phone" style="margin-left: 3px;"></i></span>
											<input class="form-control" id="userPhone" name="userPhone" value="<?php echo $objUser->phone?>" type="text"> 
										</div>
									</li>
									<li class="list-group-item border_none text-right">
										<span id="personalDetailsDiv">
											<input class="btn btn-primary btn-sm" style="font-weight: bold;" value="Save" name="btnSaveProfile" id="btnSaveProfile" type="submit">
		            						<input class="btn btn-danger btn-sm" style="font-weight: bold;" value="Cancel" type="button" onclick="location.href='{{ url('admin/users/index') }}'">
	            						</span>
									</li>
								</ul>
							</form>
            			</div>
					</div>
					
					<div class="col-md-6 col-sm-12 ptp10">
            			<div class="panel panel-default">
            				<div class="panel-heading">
            					<strong>
									<i class="fa fa-lock"></i>&nbsp;
									Reset Password
								</strong>
            				</div>
            				<form role="form" name="frmChangePassword" id="frmChangePassword" action="{{ url('admin/users/change_password') }}" method="post">
            					{{ csrf_field() }}
								<input type="hidden" name="txtPwdId" id="txtPwdId" value="<?php echo $id;?>" />
								
								<ul class="list-group">
									<li class="list-group-item border_none">
										<input class="form-control" name="new_password" id="new_password" placeholder="New Password" type="password">
										<span id="errorMsg_new_password"></span>
									</li>
									<li class="list-group-item border_none">
										<input class="form-control" name="new_confirm_password" id="new_confirm_password" placeholder="Confirm Password" type="password">
										<span id="errorMsg_new_confirm_password"></span>
									</li>
									<li class="list-group-item border_none text-right">
										<span id="passwordResetBtnDiv">
											<input class="btn btn-primary btn-sm" style="font-weight: bold;" value="Save" name="btnChangePassword" id="btnChangePassword" type="submit">
		            						<input class="btn btn-danger btn-sm" style="font-weight: bold;" value="Cancel" type="button" onclick="location.href='{{ url('admin/users/index') }}'">
		            					</span>
		            					<span id="passwordWaiterDiv" style="display: none;">
	            							<img src="https://www.findbo.dk/dashboard/images/loader.gif" style="width: 16px; margin-right: 20px; margin-top: 5px; margin-bottom: 10px;" alt="Wait">
	            						</span>
									</li>
								</ul>
							</form>
            			</div>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div class="col-md-12  col-sm-12 ptp10">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<li role="presentation" class="active">
									<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Settings</a>
								</li>
								<li role="presentation" class="">
									<a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Seek Ad</a>
								</li>
								<li role="presentation" class="">
									<a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Seek Packages</a>
								</li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
									<br>
									<form class="form-horizontal form-label-left" name="frmRentalPeriod" id="frmRentalPeriod" action="{{ url('admin/rental_period/store') }}" method="post" enctype="multipart/form-data">
										{{ csrf_field() }}
										
										<div class="item form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">IP Address</label>
											<div class="col-md-4 col-sm-6 col-xs-12" style="padding-top: 7px;">
												<?php echo $objUser->ip_address;?>
											</div>
										</div>
										
										<div class="item form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Account Activation Status </label>
											<div class="col-md-4 col-sm-6 col-xs-12" style="padding-top: 7px;">
												<?php 
												if($objUser->token==1)
												{
													echo 'Activated';
												}
												else
												{
													echo 'Not Activated <a href="javascript:void(0);" id="activate">(Click here to Activate)</a>';
												}
												?>
											</div>
										</div>
										
										<div class="item form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Auto Renew Packages </label>
											<div class="col-md-4 col-sm-6 col-xs-12">
												<label class="switch">
													<?php 
													$isAutoRenew = "";
													if($objUser->auto_renew_seek_package==1)
													{
														$isAutoRenew = " checked=\"checked\"";
													}
													?>
													<input type="checkbox" name="chkAutoRenewPackage" id="chkAutoRenewPackage" value="1" <?php echo $isAutoRenew;?> />
													<span class="slider round"></span>
												</label> 
											</div>
										</div>
										
										<div class="item form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Property Hunting Emails </label>
											<div class="col-md-4 col-sm-6 col-xs-12">
												<label class="switch">
													<?php 
													$isPropertyHunting = "";
													if($objUser->hunting_email_unsubscribe==1)
													{
														$isPropertyHunting = " checked=\"checked\"";
													}
													?>
													<input type="checkbox" name="chkPropertyHunting" id="chkPropertyHunting" value="1" <?php echo $isPropertyHunting;?> />
													<span class="slider round"></span>
												</label> 
											</div>
										</div>
										
										<div class="item form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Ban User </label>
											<div class="col-md-4 col-sm-6 col-xs-12">
												<label class="switch">
													<?php
													$isBan = ""; 
													if($objUser->isBan=='true')
													{
														$isBan = " checked=\"checked\"";
													}
													?>
													<input type="checkbox" name="chkBanUser" id="chkBanUser" value="1" <?php echo $isBan;?> />
													<span class="slider round"></span>
												</label> 
											</div>
										</div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
									
								</div>
								<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Dashboard End -->
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/admin/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {

	$("#chkAutoRenewPackage").click(function(){
		//alert("===>"+$(this).val());
		var isChecked = 0;
		if($(this).is(":checked"))
		{
			isChecked = 1;
		}

		$.ajax({
			url: '<?php echo url('admin/users/updatePackageStatus');?>',
			data: '_token={{ csrf_token() }}&id=<?php echo $id?>&isChecked='+isChecked,
			type: 'POST',
			success: function(){
				alert("Package updated successfully");
				return false;
				//window.location.href='<?php echo url("admin/users/view_profile?id=".$id);?>'
			},
			error: function(){
			}
		});
	});

	$("#chkPropertyHunting").click(function(){
		//alert("===>"+$(this).val());
		var isChecked = 0;
		if($(this).is(":checked"))
		{
			isChecked = 1;
		}

		$.ajax({
			url: '<?php echo url('admin/users/updatePropertyHunting');?>',
			data: '_token={{ csrf_token() }}&id=<?php echo $id?>&isChecked='+isChecked,
			type: 'POST',
			success: function(){
				alert("Property hunting updated successfully");
				return false;
				//window.location.href='<?php echo url("admin/users/view_profile?id=".$id);?>'
			},
			error: function(){
			}
		});
	});

	$("#chkBanUser").click(function(){
		var isChecked = 0;
		if($(this).is(":checked"))
		{
			isChecked = 1;
		}

		$.ajax({
			url: '<?php echo url('admin/users/updateBanUser');?>',
			data: '_token={{ csrf_token() }}&id=<?php echo $id?>&isChecked='+isChecked,
			type: 'POST',
			success: function(){
				alert("Ban status updated successfully");
				return false;
				//window.location.href='<?php echo url("admin/users/view_profile?id=".$id);?>'
			},
			error: function(){
			}
		});
	});


	$("#email_id").blur(function(){
		var getVal = $(this).val();

		$.ajax({
			url: '<?php echo url('admin/users/checkmail');?>',
			data: '_token={{csrf_token()}}&email='+getVal+'&id=<?php echo $id;?>',
			type: 'POST',
			success: function(res){
				$("#errorMsg_email_id").hide();
				$("#btnSaveProfile").removeAttr('disabled');
				if(res==1)
				{
					$("#errorMsg_email_id").show();
					$("#btnSaveProfile").attr('disabled', 'disabled');
				}
			},
			error: function(){
			}
		});
	});

	$("#frmChangePassword").validate({
		rules: {
			"new_password": {
				required: true,
				minlength: 8,
				maxlength: 16
			},
			"new_confirm_password": {
				required: true,
				equalTo: "#new_password",
				minlength: 8,
				maxlength: 16
			} 
		},
		messages: {
			"new_password": {
				required: "Please enter new password.",
				minlength: "Password should be greater than and equal to 8 characters.",
				maxlength: "Password should be less than and equal to 16 characters."
			},
			"new_confirm_password": {
				required: "Please enter new confirm password.",
				equalTo: "Password and confirm password must be same.",
				minlength: "Confiirm password should be greater than and equal to 8 characters.",
				maxlength: "Confirm password should be less than and equal to 16 characters."
			}
		}
	});
	
});
</script>
@endsection