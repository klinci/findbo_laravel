<!-- BEGIN FOOTER -->
<footer id="footer">
	<div id="footer-top" class="container">
		<div class="footer-newsletter row">
			<div class="col-md-3 col-sm-3 hidden-xs newsltrlogo">
				<img src="{{ asset('public/images/logo.png') }}" alt="Findbo" style="width: 170px;height:50px;">
				<span class="txns">Newsletter</span>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12 newsltrtxtbx" style="margin-top: 18px;">
				<form action="{{ route('newsletter.post') }}" method="POST" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate> <!-- //findbo.us9.list-manage.com/subscribe/post-json?u=8c47f955c01c91de718703c52&amp;id=a99afcc9c5&c=? -->
					{{ csrf_field() }}
					<div class="form-group has-success has-feedback">
						<label class="control-label lblweeklynws">
							{{-- Subscribe to our weekly newsletters --}}
							@lang('messages.newsletter_label')
						</label>
						<input type="email" class="form-control newsltrtxt" id="newsletter_email" name="EMAIL" aria-describedby="inputSuccess2Status">
						<!-- <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span> -->
						<svg id="mc-embedded-subscribe" class="form-control-feedback newsicon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="20px" height="20px" viewBox="0 0 535.5 535.5" style="enable-background:new 0 0 535.5 535.5;" xml:space="preserve">
							<g>
								<g id="send">
									<polygon points="0,497.25 535.5,267.75 0,38.25 0,216.75 382.5,267.75 0,318.75"/>
								</g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							<g>
							</g>
							</svg>
						<span id="inputSuccess2Status" class="sr-only">(success)</span>
					</div>
				</form>

				<script>
				function register($form)
				{
					$.ajax({
							type		: "POST",
							url			: $form.attr('action'),
							data		: $form.serialize(),
							cache		: false,
							async 		: false,
							dataType	: 'json',
							contentType	: "application/json; charset=utf-8",
							error		: function(err) { alert("{{  __('messages.registration_msg_1') }}"); },
							success	: function(data) {
								if(data.result != "success")
								{
									var subscribe_msg = '';
									subscribe_msg += '<div class="alert alert-danger alert-dismissable" style="margin-top: 10px">';
									subscribe_msg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">'+'&times;'+'</button>';
									subscribe_msg += '{{  __('messages.error_msg_1') }} ';
									subscribe_msg += '</div>';

									$("#subscribe_msg_box").html(subscribe_msg);
								} else {
									var subscribe_msg = '';

									subscribe_msg += '<div class="alert alert-success alert-dismissable" style="margin-top: 10px">';
									subscribe_msg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">'+'&times;'+'</button>';
									subscribe_msg += '<strong>{{  __('messages.thankyou') }} </strong>';
									subscribe_msg += '{{  __('messages.successfully_subscribed_msg') }} ';
									subscribe_msg += '</div>';

									$("#subscribe_msg_box").html(subscribe_msg);
									$("#newsletter_email").val();
								};
							}
					});
				}
				</script>
			</div>
		</div>

		<div class="row" style="margin-top: 45px;">
			<div class="col-md-2 col-md-offset-3 col-sm-3 col-xs-12">
				<h3 class="footertitle">About</h3>
				<ul class="lists">
					<li>
						<a href="{{ route('terms_condition') }}">
							{{ __('messages.title_terms_condition') }}
						</a>
					</li>
					<li><a href="{{ route('about') }}">Om Findbo.dk</a></li>
					<li><a href="{{ route('faq') }}">FAQ</a></li>
					<li><a href="{{ route('home.how_it_works') }}">Hvordan virker det</a></li>
				</ul>
			</div>
			<div class="col-md-2 col-sm-3 col-xs-12">
				<h3 class="footertitle">Tenant</h3>
				<ul class="lists">
					<li><a href="{{ route('home.properties') }}">
						{{-- Search Properties --}}
						@lang('messages.search_properties_caption')
					</a></li>
					@if(Auth::check())
						@php
							$_url = route('property.create')
						@endphp
					@else
						@php
							$_url = route('login')
						@endphp
					@endif
					<li>
						<a href="{{ $_url }}">
							@lang('messages.create_tenant_caption')
						</a>
					</li>
					<li><a href="{{ route('blog') }}">Blog</a></li>
					<li><a href="{{ route('home.contact') }}">{{ __('messages.contactus') }}</a></li>
				</ul>
			</div>
			<!-- <div class="col-md-2 col-sm-3 col-xs-12">
				<h3 class="footertitle">Landlord</h3>
				<ul class="lists">
					<li>Rent a house</li>
					<li>Find a tenant</li>
				</ul>
			</div> -->
			<div class="col-md-2 col-sm-3 col-xs-12">
				<h3 class="footertitle">Social</h3>
				<ul class="social-networks">
					<li>
						<a href="https://www.facebook.com/findboDK" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24px" height="24px"><path d="M448 56.7v398.5c0 13.7-11.1 24.7-24.7 24.7H309.1V306.5h58.2l8.7-67.6h-67v-43.2c0-19.6 5.4-32.9 33.5-32.9h35.8v-60.5c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9h-58.4v67.6h58.4V480H24.7C11.1 480 0 468.9 0 455.3V56.7C0 43.1 11.1 32 24.7 32h398.5c13.7 0 24.8 11.1 24.8 24.7z"/></svg>
						</a>
					</li>
					<li>
						<a href="http://twitter.com/findbo" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24px" height="24px"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
						</a>
					</li>
					<li>
						<a href="https://plus.google.com/101516420872251738489/posts" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" width="24px" height="24px"><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
						</a>
					</li>
					<li>
						<a href="http://www.pinterest.com/findboDK/" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" width="24px" height="24px"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- BEGIN COPYRIGHT -->
	<div id="copyright">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					{{  __('messages.copyright') }}
				</div>
			</div>
		</div>
	</div>
	<!-- END COPYRIGHT -->

</footer>
