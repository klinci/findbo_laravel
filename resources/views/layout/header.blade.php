		<!-- BEGIN HEADER -->
<header id="header">
	<div id="nav-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- <a href="{{ url('/') }}" class="nav-logo"><img src="{{ asset('public/images/logo.png') }}" alt="lejligheder til leje i københavn" /></a> -->
					<!-- BEGIN MAIN MENU -->
					<nav class="navbar">
						<a href="{{ route('home') }}" class="nav-logo"><img src="{{ asset('public/images/logo.png') }}" alt="lejligheder til leje i københavn" /></a>
						<button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>
						<ul class="nav navbar-nav">
							@if(Auth::check())
								{{-- <li><a href="{{ url('/') }}">{{ __('messages.lbl_home') }}</a></li>
								<li><a href="{{ url('property') }}">{{ __('messages.lbl_for_rent') }}</a></li>
								<li><a href="{{ url('blog') }}">Blog</a></li>
								<li><a href="{{ url('contact') }}">{{ __('messages.contactus') }}</a></li> --}}
							@else
								<li>
									<a href="{{ route('login') }}">
										<strong>
											{{ __('messages.lbl_register') }}/{{ __('messages.signin') }}
										</strong>
									</a>
								</li>
								<li>
									<a href="{{ route('property.create') }}"><strong>{{ __('messages.lbl_post_requirements') }}</strong></a>
								</li>
							@endif
						</ul>

						<ul class="nav navbar-nav" style="float: right;">
							@if (Auth::check())
								<li class="dropdown">
									<a href="#" id="" data-toggle="dropdown" data-hover="dropdown">Velkommen, <b>{{ Auth::user()->fname}} {{ Auth::user()->lname}}</b><span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-menu-right acc_dropdown" role="menu" aria-labelledby="dropdownMenu1">
										<li>
											<a href="{{ route('myprofile') }}"><span class="glyphicon glyphicon-cog"></span> &nbsp;{{ __('messages.my_profile') }}</a>
										</li>
										<li>
											<a href="{{ Auth::user()->userType == 1 ?
														 route('property.create') : route('home_seeker.create') }}">
														 <span class="glyphicon glyphicon-plus"></span> &nbsp; {{ __('messages.post_ad') }}</a>
										</li>
										@if(Auth::user()->userType == '1' || Auth::user()->isAdmin == 'admin')
										<li>
											<a href="{{ route('myads') }}"><span class="glyphicon glyphicon-home"></span> &nbsp;{{ __('messages.my_search_ad') }}</a>
										</li>
										@endif
										<li>
											<a href="{{ route('favorites') }}"><span class="glyphicon glyphicon-heart"></span> &nbsp;Favoritter</a>
										</li>
										<li>
											<a href="{{ route('message_inbox') }}"><span class="glyphicon glyphicon-envelope"></span> &nbsp;Beskeder</a>
										</li>
		                				<li>
		                					<a href="{{ route('packages') }}"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;{{ __('messages.buy_packages') }}</a>
		                				</li>
		                				<li><hr style="margin: 5px 0;"></li>
										<li>
											<a href="{{ route('logoutfront') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out"></span> &nbsp;Log ud</a>
											<form id="logout-form" action="{{ route('logoutfront') }}" method="POST" style="display: none;">
												{{ csrf_field() }}
											</form>
										</li>
									</ul>
								</li>
							@endif
						</ul>
					</nav>
					<!-- END MAIN MENU -->
				</div>
			</div>
		</div>
	</div>
	<script>
		var base_url = 'https://hrd.findbolive.web/';
	</script>
	<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="{{ asset('public/js/common.js') }}"></script>
	<script src="{{ asset('public/js/jquery-cookie-master/src/jquery.cookie.js') }}"></script>
</header>
<!-- END HEADER -->
