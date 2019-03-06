<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">{{  __('messages.close') }}</span></button>
				<h3 class="modal-title modalHeaderTitle text-center" id="myModalLabel">{{  __('messages.signinto_yacconunt') }}</h3>
			</div>

			<div class="modal-body">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
				<form action="#" method="post">
					<div class="row">
						<div class="col-sm-12">
							<p>
								<input type="email" name="email" id="email" class="form-control formModal" placeholder="{{  __('messages.username') }}">
								<div id="out"></div>
							</p>
						</div>
					</div>
				
					<div class="row">
						<div class="col-sm-12">
							<p>
								<input type="password" name="password" id="pass" class="form-control formModal" placeholder="{{  __('messages.password') }}" >
								<input type="hidden" id="loginRedirectURL" name="loginRedirectURL" value="" />
								<input type="hidden" id="btnInvokedLogin" name="btnInvokedLogin" value="" />
							</p>
						</div>
					</div>
				
					<div class="row">
						<div class="col-sm-12 rememberMe">
							<div class="checkbox" style="background-color:transparent; margin: 0; padding: 2px 14px 2px 36px;">
								<label>
									<input type="checkbox" name="checkbox_name" /> <span style="display:block; margin-top: 4px">{{  __('messages.remembermodal') }}</span>
								</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12" style="margin: 5px 0px;">
								<input type="submit" name="submit" value="{{  strtoupper(__('messages.signin')) }}" class="btn btn-primary loginBtn col-sm-12" style="background-color: #28a9e2; color:#FFFFFF; font-weight: bold;" />
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center">
								<a class="forgotPass" href="" data-toggle="modal" data-target="#forgotPasswordModal" onclick="javascript:forgotPassword();" > {{  __('messages.forgotmodal') }} </a>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12" style="margin: 5px 0px;">
							<div id="buttons">
								<div id="fb-root" style="float:left; width:1px;"></div>
								<script type="text/javascript">
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
								<a href="#" style="font-size: 14px; font-weight: bold;" class="btn btn-primary btn-block btn-social btn-facebook" onClick="fblogin();">
									<i class="fa fa-facebook"></i> {{  __('messages.signinFacebook') }}</a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="hrOr"></div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center">
<!--							<a class="registerBtn" href="registrer.php">Registrer en ny konto</a>-->
							<span>{{  __('messages.not_a_member') }}</span>
							<span><a class="registerBtn" href="#">{{  __('messages.sign_up_now') }}</a></span>
						</div>
					</div>

					
				</form>
				</div>
				<div class="col-sm-2"></div>
				<div style="clear:both"></div>
			</div>
		</div>
	</div>
</div>
