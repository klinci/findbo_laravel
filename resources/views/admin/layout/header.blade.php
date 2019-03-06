<header>
	<div class="container-fluid">
		<div class="col-lg-12 clearfix">
			<a style="left: 55px;" href="#" class="btn-slide open"> <i class="fa fa-bars"></i></a>
			<div class="text-center mainheadtitle">FindBO</div>
			<div class="user-box">
				<ul class=" toprightnav">
					<li class="">
						<a aria-expanded="false" data-toggle="dropdown" class="user-profile dropdown-toggle" href="javascript:;"> 
							<span class="welcome">Welcome,</span> <span class="name">{{ Auth::user()->name }}</span>
							<span class=" fa fa-angle-down"></span>
						</a>
						<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
							<!-- <li><a href="my_profile.php"> Profile</a></li>
							<li><a href="reset_password.php"> Reset Password</a></li> -->
							<li>
								<a href="{{ url('/admin/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Logout</a>
									<form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>