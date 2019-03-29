@extends('layout.index')

@section('pageTitle', __('messages.title_welcome'))

@section('meta_tags')
<meta name="keywords" content="{{ __('messages.meta_keyword_home_page') }}">
<meta name="description" content="{{ __('messages.meta_desc_home_page') }}">
@endsection

@section('content')
<style type="text/css">
.chzn-container-single .chzn-single {
	border: 0px;
	background-color: #82b83a !important;
	border-radius: 3px;
	color: #fff;
}
.chzn-container {
	background-color: #82b83a !important;
	border: 0px;
	height: 40px;
	color: #FFF !important;
}
</style>

<!-- BEGIN HOME SEARCH SECTION -->
<section id="home-search-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12" data-animation-direction="from-top" data-animation-delay="50">
				<h2 class="slider-title">{{  __('messages.lbl_find_home') }}</h2>
				<div class="slider-subtitle">{{  __('messages.lbl_with') }} <strong>Findbo</strong> {{  __('messages.lbl_located_denmark') }}</div>
			</div>

			<form id="homePageSearchForm" action="{{ route('home.properties') }}" method="post">
				{{ csrf_field() }}
				<div id="home-search-buttons" class="col-sm-6 col-sm-offset-3" data-animation-direction="from-bottom" data-animation-delay="50">
					<input type="hidden" name="code" id="code" value="" />
					<input type="hidden" id="searchActionHdn" name="action" value="rent" />
					{{-- <div class="input-group">
						<input type="text" class="form-control input-sm" value="" placeholder="{{ __('messages.msg_homepage_2') }}" />
						<span class="input-group-btn" style="width:0px;"></span>
						<input type="text" class="form-control input-sm" value="test2" />
						<span class="input-group-btn" style="width:0px;"></span>
						<input type="text" class="form-control input-sm" value="test2" />
						<span class="input-group-btn" style="width:0px;"></span>
						<button class="btn btn-default" type="submit" name="submitKeyword"><i class="fa fa-search"></i>{{ __('messages.search') }}</button>
					</div>  --}}
					<div class="input-group br">
						<input class="form-control search" name="keywords" placeholder="{{ __('messages.msg_homepage_2') }}" id="home_search" type="text">
						<span class="input-group-btn" style="width:0px;"></span>
						{{-- <select id="search_maxprice" name="maxPrice" class="form-control search">
							<option value="">{{ __('messages.lbl_max_price') }}</option>
							@foreach($priceRange as $key=>$value)
								<option value="{{ $value }}">DKK {{ number_format($value,0,',','.') }}</option>
							@endforeach
						</select>
						<span class="input-group-btn" style="width:0px;"></span>
						<select id="search_minrooms" name="minRooms" class="form-control search">
							<option value="">{{ __('messages.lbl_search_min_rooms') }}</option>
							<option value="1">1 {{ __('messages.lbl_room') }}</option>
							<option value="2">2 {{ __('messages.lbl_rooms') }}</option>
							<option value="3">3 {{ __('messages.lbl_rooms') }}</option>
							<option value="4">4 {{ __('messages.lbl_rooms') }}</option>
							<option value="5">5 {{ __('messages.lbl_rooms') }}</option>
						</select> --}}
						<span class="input-group-btn">
							<div class="btn-group dropup">
								<button class="btn btn-success searchbtn" type="submit" name="submitKeyword"><i class="fa fa-search"></i></button>
			            	</div>
		        		</span>
		    		</div>
					{{-- <div class="input-group">
						<input type="text" placeholder="{{ __('messages.msg_homepage_2') }}" name="keywords" id="home_search" class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit" name="submitKeyword"><i class="fa fa-search"></i>{{ __('messages.search') }}</button>
						</span>
					</div> --}}
				</div>
			</form>
		</div>
	</div>
</section>

<!-- END HOME SEARCH SECTION -->

<div class="content">
	<div class="container">
		<div class="row">

			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-12">
				<h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">
					{{-- Selected cities in Danmark --}}
					@lang('messages.wellcome_danmark_caption')
				</h1>

				<div class="row">
					<div class="col-md-6 col-sm-6 img1">
						<div class="ctinfo">
							<div class="cth3">Aalborg</div>
							<div class="cthtotal">
								{{-- {{ $aalborgCount }} @lang('messages.rental_properties_caption') --}}
								{{ $aalborgCount }} @lang('messages.rental_properties_caption')
							</div>
							<div class="cthbtn">
								<form action="{{ route('home.properties') }}" method="POST" id="aalborg-form">
									{{ csrf_field() }}
									{{-- <input type="hidden" name="zip[11]" value="11">
									<input type="hidden" name="zip[23]" value="23">
									<input type="hidden" name="zip[24]" value="24">
									<input type="hidden" name="zip[25]" value="25">
									<button>@lang('messages.find_house_caption')</button> --}}
									<input type="hidden" name="keywords" value="Aalborg">
								</form>
								<button onclick="$('#aalborg-form').submit()">
									{{-- @lang('messages.find_house_caption') --}}
									@lang('messages.find_house_caption')
								</button>
							</div>
						</div>
						<img src="{{ asset('public/images/Aalborg.jpg') }}" class="img-responsive" />
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="col-md-6 col-sm-6 img2">
							<div class="ctinfo">
								<div class="cth3">København</div>
								<div class="cthtotal">{{ $copenhagenCount }} @lang('messages.rental_properties_caption') </div>
								<div class="cthbtn">
									<form action="{{ route('home.properties') }}" method="POST" id="copenhagen-form">
										{{ csrf_field() }}
										<input type="hidden" name="keywords" value="København">
										{{-- <input type="hidden" name="zip[1794]" value="1794">
										<input type="hidden" name="zip[201]" value="201">
										<input type="hidden" name="zip[203]" value="203">
										<input type="hidden" name="zip[202]" value="202">
										<input type="hidden" name="zip[204]" value="204">
										<input type="hidden" name="zip[8]" value="8"> --}}
									</form>
									<button onclick="$('#copenhagen-form').submit()">@lang('messages.find_house_caption')</button>
								</div>
							</div>
							<img src="{{ asset('public/images/Copenhagen.jpeg') }}" class="img-responsive" />
						</div>
						<div class="col-md-6 col-sm-6 img3">
							<div class="ctinfo">
								<div class="cth3">Aarhus </div>
								<div class="cthtotal">
									{{ $aarhusCount }} @lang('messages.rental_properties_caption')
								</div>
								<div class="cthbtn">
									<form action="{{ route('home.properties') }}" method="POST" id="aarhus-form">
										{{ csrf_field() }}
										<input type="hidden" name="keywords" value="Aarhus">
										{{-- <input type="hidden" name="zip[20]" value="20">
										<input type="hidden" name="zip[544]" value="544">
										<input type="hidden" name="zip[545]" value="545"> --}}
									</form>
									<button onclick="$('#aarhus-form').submit()">@lang('messages.find_house_caption')</button>
								</div>
							</div>
							<img src="{{ asset('public/images/Aarhus.gif') }}" class="img-responsive" />
						</div>
						<div class="col-md-12 col-sm-12 img4">
							<div class="ctinfo">
								<div class="cth3">Odense </div>
								<div class="cthtotal">{{ $odenseCount }} @lang('messages.rental_properties_caption') </div>
								<div class="cthbtn">
									<form action="{{ route('home.properties') }}" method="POST" id="odense-form">
										{{ csrf_field() }}
										<input type="hidden" name="keywords" value="Odense">
										{{-- <input type="hidden" name="zip[128]" value="128">
										<input type="hidden" name="zip[132]" value="132">
										<input type="hidden" name="zip[136]" value="136">
										<input type="hidden" name="zip[130]" value="130">
										<input type="hidden" name="zip[133]" value="133">
										<input type="hidden" name="zip[135]" value="135">
										<input type="hidden" name="zip[134]" value="134">
										<input type="hidden" name="zip[131]" value="131">
										<input type="hidden" name="zip[129]" value="129"> --}}
									</form>
									<button onclick="$('#odense-form').submit()">@lang('messages.find_house_caption')</button>
								</div>
							</div>
							<img src="{{ asset('public/images/Odense.jpg') }}" class="img-responsive" />
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-12">
				<h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">{{  __('messages.lbl_features') }}</h1>

				<div class="feature col-sm-4 findbofts" data-animation-direction="from-bottom" data-animation-delay="250">
					<!-- <i class="fa fa-home"></i> -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="80px" height="80px">
					<g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M48.8,97c-12.9,0-25-5-34.1-14.1c-18.8-18.8-18.8-49.4,0-68.3C23.7,5.5,35.9,0.5,48.8,0.5
								c12.9,0,25,5,34.1,14.1c18.8,18.8,18.8,49.4,0,68.3C73.8,92,61.6,97,48.8,97z M48.8,4.5c-11.8,0-22.9,4.6-31.3,13
								c-17.3,17.3-17.3,45.3,0,62.6c8.4,8.4,19.5,13,31.3,13c11.8,0,22.9-4.6,31.3-13c17.3-17.3,17.3-45.3,0-62.6
								C71.7,9.1,60.6,4.5,48.8,4.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M48.8,85.8c-9.9,0-19.2-3.9-26.2-10.8c-7-7-10.8-16.3-10.8-26.2s3.9-19.2,10.8-26.2
								c7-7,16.3-10.8,26.2-10.8c9.9,0,19.2,3.9,26.2,10.8c7,7,10.8,16.3,10.8,26.2S81.9,68,74.9,75C67.9,81.9,58.6,85.8,48.8,85.8z
								M48.8,13.7c-9.4,0-18.2,3.6-24.8,10.3c-6.6,6.6-10.3,15.4-10.3,24.8c0,9.4,3.6,18.2,10.3,24.8s15.4,10.3,24.8,10.3
								c9.4,0,18.2-3.6,24.8-10.3s10.3-15.4,10.3-24.8c0-9.4-3.6-18.2-10.3-24.8C66.9,17.4,58.1,13.7,48.8,13.7z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M20.4,47.3c-0.3,0-0.6-0.1-0.8-0.4c-0.3-0.4-0.2-1.1,0.2-1.4l28.4-20.8c0.4-0.3,0.8-0.3,1.2,0l28.4,20.8
								c0.4,0.3,0.5,1,0.2,1.4c-0.3,0.4-1,0.5-1.4,0.2L48.8,26.8L21,47.1C20.8,47.2,20.6,47.3,20.4,47.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M69.2,70h-41c-0.6,0-1-0.4-1-1V40.5c0-0.3,0.2-0.6,0.4-0.8l20.5-15c0.4-0.3,0.8-0.3,1.2,0l20.5,15
								c0.3,0.2,0.4,0.5,0.4,0.8V69C70.2,69.6,69.8,70,69.2,70z M29.3,68h39V41L48.8,26.8L29.3,41V68z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M114.1,127.5C114.1,127.5,114.1,127.5,114.1,127.5c-3.6,0-7-1.4-9.5-3.9L71,90c-0.4-0.4-0.6-1-0.6-1.7
								c0.1-0.6,0.4-1.2,1-1.5c3.2-1.9,6.1-4.2,8.7-6.8c2.6-2.6,4.9-5.5,6.8-8.7c0.3-0.5,0.9-0.9,1.5-1c0.6-0.1,1.2,0.1,1.7,0.6
								l33.6,33.6c5.2,5.2,5.2,13.7,0,19C121,126.1,117.7,127.5,114.1,127.5z M75.6,88.9l31.8,31.8c1.8,1.8,4.1,2.8,6.7,2.8h0
								c2.5,0,4.9-1,6.7-2.8c1.8-1.8,2.8-4.1,2.8-6.7c0-2.5-1-4.9-2.8-6.7L88.9,75.6c-1.8,2.6-3.8,5.1-6,7.3
								C80.6,85.1,78.2,87.1,75.6,88.9z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M48.8,46c-3.1,0-5.6-2.5-5.6-5.6c0-3.1,2.5-5.6,5.6-5.6c3.1,0,5.6,2.5,5.6,5.6C54.3,43.5,51.8,46,48.8,46z
								M48.8,36.9c-2,0-3.6,1.6-3.6,3.6c0,2,1.6,3.6,3.6,3.6c2,0,3.6-1.6,3.6-3.6C52.3,38.5,50.7,36.9,48.8,36.9z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M54.5,70H43c-0.6,0-1-0.4-1-1V56.8c0-3.7,3-6.7,6.7-6.7c3.7,0,6.7,3,6.7,6.7V69C55.5,69.6,55,70,54.5,70z
								M44,68h9.5V56.8c0-2.6-2.1-4.7-4.7-4.7c-2.6,0-4.7,2.1-4.7,4.7V68z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M113.6,117.9c-2,0-4.2-1.1-6-2.8c-1.4-1.4-2.3-3-2.7-4.6c-0.4-1.8,0-3.3,1-4.4c0.8-0.8,1.8-1.2,3.1-1.2
								c2,0,4.2,1.1,6,2.8c1.4,1.4,2.3,3,2.7,4.6c0.4,1.8,0,3.3-1,4.4C115.9,117.5,114.9,117.9,113.6,117.9z M109.1,106.9
								c-0.5,0-1.2,0.1-1.7,0.6c-0.7,0.7-0.6,1.9-0.5,2.6c0.3,1.3,1,2.5,2.1,3.7c1.4,1.4,3.1,2.2,4.6,2.2c0.5,0,1.2-0.1,1.7-0.6
								c0.7-0.7,0.6-1.9,0.5-2.6c-0.3-1.3-1-2.5-2.1-3.7C112.3,107.7,110.5,106.9,109.1,106.9z"/>
						</g>
					</g>
					</svg>
					<h3 class="featuretitle1">{{  __('messages.lbl_for_rent_or_sale') }}</h3>
					<p class="featuredesc1" style="height:150px;">
						{{ __('messages.feature_rent_or_sale') }}
					</p>
					<a href="{{ route('home.how_it_works') }}" class="btn btn-default-color newbtn">{{  __('messages.lbl_read_more') }}</a>
				</div>
				<div class="feature col-sm-4 findbofts" data-animation-direction="from-bottom" data-animation-delay="450">
					<!-- <i class="fa fa-bullhorn"></i> -->
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="80px" height="80px">
					<g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M109.4,110.8c-11.7,0-18.1-27.5-18.1-53.4S97.7,4,109.4,4s18.1,27.5,18.1,53.4S121.2,110.8,109.4,110.8z
								M109.4,8c-6.6,0-14.1,20.3-14.1,49.4c0,29.1,7.4,49.4,14.1,49.4s14.1-20.3,14.1-49.4C123.5,28.3,116.1,8,109.4,8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M104.8,108.6c-0.3,0-0.6-0.1-0.9-0.2l-52.3-28c-3.5-1.9-7.4-2.8-11.3-2.8H16.9c-0.5,0-0.9,0-1.5-0.1
								c-0.3,0-0.7,0.1-1.1,0.1c-3.5,0-6.9-2-9.4-5.6c-1.8-2.2-3-4.8-3.4-7.7c-0.6-2.5-1-5.2-1-7.9c0-2.7,0.3-5.4,1-7.9
								c0.4-2.8,1.6-5.5,3.4-7.7c2.5-3.6,5.9-5.6,9.4-5.6c0.4,0,0.8,0,1.1,0.1c0.5,0,1-0.1,1.5-0.1h23.7c3.7,0,7.5-0.9,10.8-2.6
								l52.6-26.4c0.9-0.4,2-0.2,2.5,0.6s0.5,1.9-0.2,2.6c-6.4,6.1-10.8,25.8-10.8,47.8s4.4,41.7,10.8,47.8c0.7,0.7,0.8,1.8,0.2,2.6
								C106,108.3,105.4,108.6,104.8,108.6z M15.4,73.5c0.1,0,0.1,0,0.2,0c0.5,0,0.9,0.1,1.3,0.1h23.3c4.6,0,9.2,1.1,13.2,3.3l45.4,24.2
								c-4.6-9.7-7.4-25.8-7.4-43.8c0-18.1,2.9-34.4,7.5-44.1l-45.8,23c-3.9,2-8.3,3-12.6,3H16.9c-0.4,0-0.8,0-1.3,0.1
								c-0.2,0-0.3,0-0.5,0c-0.3,0-0.6-0.1-0.8-0.1c-2.2,0-4.4,1.4-6.2,4c0,0.1-0.1,0.1-0.1,0.1c-1.4,1.7-2.3,3.7-2.6,5.8
								c0,0.1,0,0.2,0,0.2c-0.6,2.2-0.9,4.6-0.9,7c0,2.4,0.3,4.8,0.9,7c0,0.1,0,0.1,0,0.2c0.3,2.2,1.2,4.2,2.6,5.8c0,0,0.1,0.1,0.1,0.1
								c1.8,2.5,4,4,6.2,4c0.2,0,0.4,0,0.8-0.1C15.2,73.5,15.3,73.5,15.4,73.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M47.5,77.4c-4.8,0-7.5-10.7-7.5-20.8s2.6-20.8,7.5-20.8c0.6,0,1,0.4,1,1s-0.4,1-1,1
								c-2.3,0-5.5,7.2-5.5,18.8s3.2,18.8,5.5,18.8c0.6,0,1,0.4,1,1S48,77.4,47.5,77.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M96.2,72.5c-0.7,0-1.5-0.1-2.4-0.2c-0.5-0.1-0.8-0.4-0.8-0.9c-0.4-4.6-0.6-9.3-0.6-14s0.2-9.4,0.6-14
								c0-0.5,0.4-0.8,0.8-0.9c0.9-0.1,1.6-0.2,2.4-0.2c8.3,0,15.1,6.8,15.1,15.1S104.5,72.5,96.2,72.5z M94.9,70.4
								c0.5,0,0.9,0.1,1.3,0.1c7.2,0,13.1-5.9,13.1-13.1s-5.9-13.1-13.1-13.1c-0.4,0-0.8,0-1.3,0.1c-0.3,4.3-0.5,8.6-0.5,13
								S94.6,66.1,94.9,70.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M33.5,116H20c-1.1,0-2-0.9-2-2V75.6c0-1.1,0.9-2,2-2h13.6c1.1,0,2,0.9,2,2V114
								C35.5,115.2,34.6,116,33.5,116z M22,112h9.6V77.6H22V112z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M38.4,124H15.1c-1.1,0-2-0.9-2-2v-8c0-1.1,0.9-2,2-2h23.3c1.1,0,2,0.9,2,2v8C40.4,123.2,39.5,124,38.4,124
								z M17.1,120h19.3v-4H17.1V120z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M41.2,103.6h-7.7c-1.1,0-2-0.9-2-2V90.1c0-1.1,0.9-2,2-2h7.7c1.1,0,2,0.9,2,2v11.5
								C43.2,102.7,42.3,103.6,41.2,103.6z M35.5,99.6h3.7v-7.5h-3.7V99.6z"/>
						</g>
						<g>
							<path class="Layer_2" fill="none" stroke="#303C42" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
								M46.7,37.4"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M41,51.3H3.3c-0.6,0-1-0.4-1-1s0.4-1,1-1H41c0.6,0,1,0.4,1,1S41.6,51.3,41,51.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M41,65.5H3.3c-0.6,0-1-0.4-1-1s0.4-1,1-1H41c0.6,0,1,0.4,1,1S41.6,65.5,41,65.5z"/>
						</g>
					</g>
					</svg>
					<h3 class="featuretitle1">{{  __('messages.lbl_real_ads') }}</h3>
					<p class="featuredesc1" style="height:150px;">
						{{ __('messages.feature_real_ads')}}
					</p>
					<a href="{{ route('home.properties') }}" class="btn btn-default-color newbtn">{{  __('messages.lbl_read_more') }}</a>
				</div>
				<div class="feature col-sm-4 findbofts" data-animation-direction="from-bottom" data-animation-delay="650">
					<!-- <i class="fa fa-map-marker"></i> -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="80px" height="80px">
					<g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M124.9,127.5H3.1c-0.6,0-1.2-0.3-1.6-0.8c-0.4-0.5-0.5-1.2-0.3-1.8l18.9-60.3c0.3-0.8,1-1.4,1.9-1.4h27.7
								c0.7,0,1.4,0.4,1.7,1c5,8.4,10.1,15.8,12.6,19.4c2.5-3.6,7.6-11,12.6-19.4c0.4-0.6,1-1,1.7-1H106c0.9,0,1.6,0.6,1.9,1.4l18.9,60.3
								c0.2,0.6,0.1,1.3-0.3,1.8C126.2,127.2,125.6,127.5,124.9,127.5z M5.8,123.5h116.4l-17.7-56.3H79.4c-6.9,11.4-13.7,20.9-13.8,21
								c-0.4,0.5-1,0.8-1.6,0.8s-1.2-0.3-1.6-0.8c-0.1-0.1-6.9-9.6-13.8-21H23.4L5.8,123.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M60.1,82.4H16.9c-0.6,0-1-0.4-1-1s0.4-1,1-1h43.2c0.6,0,1,0.4,1,1S60.7,82.4,60.1,82.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M111.1,82.4H67.9c-0.6,0-1-0.4-1-1s0.4-1,1-1h43.2c0.6,0,1,0.4,1,1S111.6,82.4,111.1,82.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M116.7,100.1H86.8c-0.6,0-1-0.4-1-1s0.4-1,1-1h29.9c0.6,0,1,0.4,1,1S117.2,100.1,116.7,100.1z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M86.8,110.6c-0.6,0-1-0.4-1-1V93.3c0-0.6,0.4-1,1-1s1,0.4,1,1v16.3C87.8,110.2,87.3,110.6,86.8,110.6z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M64,126.5c-0.6,0-1-0.4-1-1v-25.4H11.3c-0.6,0-1-0.4-1-1s0.4-1,1-1H64c0.6,0,1,0.4,1,1v26.4
								C65,126.1,64.6,126.5,64,126.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M64,89c-0.6,0-1.2-0.3-1.6-0.8c-1.2-1.7-29.1-40.6-29.1-57C33.3,14.3,47.1,0.5,64,0.5
								c16.9,0,30.7,13.8,30.7,30.7c0,16.3-27.9,55.3-29.1,57C65.2,88.7,64.6,89,64,89z M64,4.5c-14.7,0-26.7,12-26.7,26.7
								C37.3,44.1,58,74.9,64,83.5c6-8.7,26.7-39.4,26.7-52.3C90.7,16.5,78.7,4.5,64,4.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M64,49.1c-9.8,0-17.8-8-17.8-17.8s8-17.8,17.8-17.8s17.8,8,17.8,17.8S73.8,49.1,64,49.1z M64,15.4
								c-8.7,0-15.8,7.1-15.8,15.8S55.3,47.1,64,47.1c8.7,0,15.8-7.1,15.8-15.8S72.7,15.4,64,15.4z"/>
						</g>
					</g>
					</svg>
					<h3 class="featuretitle1">{{  __('messages.lbl_map_vision') }}</h3>
					<p class="featuredesc1" style="height:150px;">
						{{ __('messages.feature_map_vision') }}
					</p>
					<a href="{{ route('home.map') }}" class="btn btn-default-color newbtn">{{  __('messages.lbl_read_more') }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT WRAPPER -->


@if(!empty($newHomeSeeker) && count($newHomeSeeker)>0)
	<!-- BEGIN SEEKER SLIDER WRAPPER-->
	<div data-stellar-background-ratio="0.5" style="padding: 0 0 60px 0;background-color: rgb(245, 246, 255);">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">{{  __('messages.lbl_new_property_seeker') }}</h1>
				</div>
				<div class="col-sm-12 col-md-10 col-md-offset-2">
					@foreach($newHomeSeeker as $homeSeeker)

						<?php
						$seek_prop_id		= $homeSeeker->id;
						$seek_prop_headline	= $homeSeeker->title;

						$seotitle = preg_replace('~[^\\pL0-9_]+~u', '-', $seek_prop_headline);
						$seotitle = trim($seotitle, "-");
						$seotitle = iconv("utf-8", "us-ascii//TRANSLIT", $seotitle);
						$seotitle = strtolower($seotitle);
						$seotitle = preg_replace('~[^-a-z0-9_]+~', '', $seotitle);
						?>
						<div class="homeseekerscls">
							<a href="{{ route('home_seeker.show', $seek_prop_id) }}" class="info">
								@if(file_exists($homeSeeker->thumbnail_large) && !empty($homeSeeker->thumbnail_large))
									<img src="{{  asset($homeSeeker->thumbnail_large) }}" alt="..." width="150" height="150" />
								@else
									<img src="{{ asset('public/images/seeker.png') }}" alt="..." width="150" height="150" />
								@endif
							</a>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endif

<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-12 col-md-offset-2	col-sm-offset-1"> <!-- main -->

				<div class="feature col-md-4 col-sm-5 findbofts" data-animation-direction="from-bottom" data-animation-delay="250">
					<!-- <i class="fa fa-home"></i> -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="100px" height="100px">
					<g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M8.8,64.6c-0.6,0-1.2-0.3-1.6-0.8l-6.3-8.6c-0.3-0.4-0.4-1-0.4-1.5c0.1-0.5,0.4-1,0.8-1.3l61.5-45
								c0.7-0.5,1.7-0.5,2.4,0l61.5,45c0.4,0.3,0.7,0.8,0.8,1.3c0.1,0.5,0,1.1-0.4,1.5l-6.3,8.6c-0.7,0.9-1.9,1.1-2.8,0.4L64,24.7
								L10,64.2C9.6,64.5,9.2,64.6,8.8,64.6z M64,20.2c0.4,0,0.8,0.1,1.2,0.4l53.6,39.2l3.9-5.4L64,11.5L5.3,54.5l3.9,5.4l53.6-39.2
								C63.2,20.3,63.6,20.2,64,20.2z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M108.5,120.5H19.5c-1.1,0-2-0.9-2-2V54.7c0-0.6,0.3-1.2,0.8-1.6l44.5-32.6c0.7-0.5,1.7-0.5,2.4,0
								l44.5,32.6c0.5,0.4,0.8,1,0.8,1.6v44.4c0,0.8-0.5,1.5-1.2,1.8c-0.7,0.3-1.6,0.1-2.2-0.4l-0.7-0.7l-5,5l8.6,8.6
								c0.4,0.4,0.6,0.9,0.6,1.4v3.7C110.5,119.6,109.6,120.5,108.5,120.5z M21.5,116.5h85.1v-0.8l-9.4-9.4c-0.8-0.8-0.8-2,0-2.8l7.9-7.9
								c0.4-0.4,1-0.6,1.6-0.6V55.7L64,24.6L21.5,55.7V116.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M57.4,119.5h-25c-0.6,0-1-0.4-1-1v-30c0-7.4,6-13.5,13.5-13.5c7.4,0,13.5,6,13.5,13.5v30
								C58.4,119,57.9,119.5,57.4,119.5z M33.4,117.5h23v-29c0-6.3-5.1-11.5-11.5-11.5s-11.5,5.1-11.5,11.5V117.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M27.2,38c-0.3,0-0.6-0.1-0.9-0.2c-0.7-0.3-1.1-1-1.1-1.8V8.4c0-1.1,0.9-2,2-2h13.4c1.1,0,2,0.9,2,2v17.7
								c0,0.6-0.3,1.2-0.8,1.6l-13.4,9.8C28,37.9,27.6,38,27.2,38z M29.2,10.4V32l9.4-6.9V10.4H29.2z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M115.6,121.6c-2,0-3.9-0.8-5.3-2.2l-13.2-13.2c-0.8-0.8-0.8-2,0-2.8l7.9-7.9c0.8-0.8,2-0.8,2.8,0
								l13.2,13.2c2.9,2.9,2.9,7.7,0,10.7C119.5,120.8,117.6,121.6,115.6,121.6z M101.4,104.8l11.7,11.7c1.3,1.3,3.7,1.3,5,0
								c1.4-1.4,1.4-3.6,0-5l-11.7-11.7L101.4,104.8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M87,103.1c-4.7,0-9.2-1.8-12.5-5.2c-3.3-3.3-5.2-7.8-5.2-12.5c0-4.7,1.8-9.2,5.2-12.5
								c3.3-3.3,7.8-5.2,12.5-5.2s9.2,1.8,12.5,5.2c6.9,6.9,6.9,18.1,0,25C96.2,101.3,91.7,103.1,87,103.1z M87,69.7
								c-4.2,0-8.1,1.6-11.1,4.6c-3,3-4.6,6.9-4.6,11.1c0,4.2,1.6,8.1,4.6,11.1c3,3,6.9,4.6,11.1,4.6s8.1-1.6,11.1-4.6
								c6.1-6.1,6.1-16.1,0-22.2C95.1,71.4,91.2,69.7,87,69.7z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M82.7,93.1c-0.3,0-0.5-0.1-0.7-0.3c-4.1-4.1-4.1-10.7,0-14.7c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4
								c-3.3,3.3-3.3,8.6,0,11.9c0.4,0.4,0.4,1,0,1.4C83.2,93,82.9,93.1,82.7,93.1z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M100.6,103.7c-0.3,0-0.5-0.1-0.7-0.3l-3.8-3.8c-0.2-0.2-0.3-0.5-0.3-0.8s0.2-0.6,0.4-0.7
								c0.7-0.5,1.3-1,1.9-1.6c0.5-0.5,1-1.1,1.6-1.9c0.2-0.2,0.4-0.4,0.7-0.4c0.3,0,0.6,0.1,0.8,0.3l3.8,3.8c0.4,0.4,0.4,1,0,1.4
								l-3.6,3.6C101.1,103.6,100.9,103.7,100.6,103.7z M98.3,99l2.3,2.3l2.2-2.2l-2.3-2.3c-0.4,0.4-0.7,0.8-1.1,1.2
								C99.2,98.3,98.8,98.6,98.3,99z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M64,59.8c-6,0-10.9-4.9-10.9-10.9S58,38,64,38s10.9,4.9,10.9,10.9S70,59.8,64,59.8z M64,40
								c-4.9,0-8.9,4-8.9,8.9s4,8.9,8.9,8.9s8.9-4,8.9-8.9S68.9,40,64,40z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M46.9,10.4H20.9c-1.1,0-2-0.9-2-2s0.9-2,2-2h25.9c1.1,0,2,0.9,2,2S48,10.4,46.9,10.4z"/>
						</g>
					</g>
					</svg>
					<h3 class="lookingh3">@lang('messages.looking_new_home_label')</h3>
					<p class="lookingp" style="height:110px;">
						@lang('messages.looking_new_home_description')
					</p>
					@if(!Auth::check())
						<a href="{{ route('login') }}" class="btn btn-default-color newbtn">
							@lang('messages.find_house_caption')
						</a>
					@else
						<a href="{{ route('home.properties') }}" class="btn btn-default-color newbtn">@lang('messages.find_house_caption')</a>
					@endif
				</div>
				<div class="feature col-md-4 col-sm-5 findbofts" data-animation-direction="from-bottom" data-animation-delay="450">
					<!-- <i class="fa fa-bullhorn"></i> -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="100px" height="100px">
					<g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M102,65.5c-0.4,0-0.8-0.1-1.2-0.4L54.9,31.5L9,65.1c-0.9,0.7-2.1,0.5-2.8-0.4l-5.4-7.3
								c-0.3-0.4-0.4-1-0.4-1.5c0.1-0.5,0.4-1,0.8-1.3l52.4-38.4c0.7-0.5,1.7-0.5,2.4,0l52.4,38.4c0.4,0.3,0.7,0.8,0.8,1.3
								c0.1,0.5,0,1.1-0.4,1.5l-5.4,7.3C103.2,65.2,102.6,65.5,102,65.5z M54.9,27.1c0.4,0,0.8,0.1,1.2,0.4l45.5,33.3l3-4.1L54.9,20.3
								L5.3,56.6l3,4.1l45.5-33.3C54.1,27.2,54.5,27.1,54.9,27.1z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M75.1,109.8H17c-1.1,0-2-0.9-2-2v-51c0-0.6,0.3-1.2,0.8-1.6l38-27.8c0.7-0.5,1.7-0.5,2.4,0l38,27.8
								c0.5,0.4,0.8,1,0.8,1.6v17.7c0,1.1-0.9,2-2,2h-15c-0.5,0-0.9,0.4-0.9,0.9v30.5C77.1,108.9,76.2,109.8,75.1,109.8z M19,105.8h54.1
								V77.3c0-2.7,2.2-4.9,4.9-4.9h13V57.8l-36-26.3L19,57.8V105.8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M23.5,42.8c-0.3,0-0.6-0.1-0.9-0.2c-0.7-0.3-1.1-1-1.1-1.8V21.3c0-1.1,0.9-2,2-2H35c1.1,0,2,0.9,2,2v11.1
								c0,0.6-0.3,1.2-0.8,1.6l-11.5,8.4C24.4,42.7,23.9,42.8,23.5,42.8z M25.5,23.3v13.6l7.5-5.5v-8.1H25.5z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M54.9,61.3c-5.2,0-9.5-4.2-9.5-9.5s4.2-9.5,9.5-9.5c5.2,0,9.5,4.2,9.5,9.5S60.1,61.3,54.9,61.3z
								M54.9,44.3c-4.1,0-7.5,3.3-7.5,7.5s3.3,7.5,7.5,7.5s7.5-3.3,7.5-7.5S59,44.3,54.9,44.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M37.2,23.3H21.3c-1.1,0-2-0.9-2-2v-8.5c0-1.1,0.9-2,2-2h15.9c1.1,0,2,0.9,2,2v8.5
								C39.2,22.4,38.3,23.3,37.2,23.3z M23.3,19.3h11.9v-4.5H23.3V19.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M65.6,108.8H44.3c-0.6,0-1-0.4-1-1V85.1c0-6.4,5.2-11.6,11.6-11.6s11.6,5.2,11.6,11.6v22.7
								C66.6,108.3,66.1,108.8,65.6,108.8z M45.3,106.8h19.3V85.1c0-5.3-4.3-9.6-9.6-9.6s-9.6,4.3-9.6,9.6V106.8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M122.6,117.2H78c-2.7,0-4.9-2.2-4.9-4.9v-35c0-2.7,2.2-4.9,4.9-4.9h44.7c2.7,0,4.9,2.2,4.9,4.9v35
								C127.5,115,125.3,117.2,122.6,117.2z M78,76.4c-0.5,0-0.9,0.4-0.9,0.9v35c0,0.5,0.4,0.9,0.9,0.9h44.7c0.5,0,0.9-0.4,0.9-0.9v-35
								c0-0.5-0.4-0.9-0.9-0.9H78z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M86.2,84.7c-1.2,0-2.2,0.4-3,1.2c-0.8,0.8-1.2,1.8-1.2,3s0.4,2.2,1.2,3c0.8,0.8,1.8,1.2,3,1.2
								c1.2,0,2.2-0.4,3-1.2c0.8-0.8,1.2-1.8,1.2-3s-0.4-2.2-1.2-3C88.4,85.1,87.4,84.7,86.2,84.7L86.2,84.7z M86.2,91.4
								c-0.7,0-1.2-0.3-1.7-0.8c-0.5-0.5-0.7-1.1-0.7-1.8c0-0.7,0.2-1.3,0.7-1.8c0.5-0.5,1-0.8,1.7-0.8c0.7,0,1.2,0.3,1.7,0.8
								c0.5,0.5,0.7,1.1,0.7,1.8c0,0.7-0.2,1.3-0.7,1.8C87.5,91.2,86.9,91.4,86.2,91.4L86.2,91.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M86.2,84.7c-1.2,0-2.2,0.4-3,1.2c-0.8,0.8-1.2,1.8-1.2,3c0,1.2,0.4,2.2,1.2,3c0.8,0.8,1.8,1.2,3,1.2
								c1.2,0,2.2-0.4,3-1.2c0.8-0.8,1.2-1.8,1.2-3c0-1.2-0.4-2.2-1.2-3C88.4,85.1,87.4,84.7,86.2,84.7L86.2,84.7z M86.2,91.4
								c-0.7,0-1.2-0.3-1.7-0.8c-0.5-0.5-0.7-1.1-0.7-1.8c0-0.7,0.2-1.3,0.7-1.8c0.5-0.5,1-0.8,1.7-0.8c0.7,0,1.2,0.3,1.7,0.8
								c0.5,0.5,0.7,1.1,0.7,1.8c0,0.7-0.2,1.3-0.7,1.8C87.5,91.2,86.9,91.4,86.2,91.4L86.2,91.4z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M94.8,84.9H92v8h1.8v-2.2h1.1c1.2,0,2.1-0.2,2.7-0.7c0.6-0.5,0.9-1.2,0.9-2.2s-0.3-1.7-0.8-2.2
								C97,85.1,96.1,84.9,94.8,84.9L94.8,84.9z M93.8,89.1v-2.7h1c0.6,0,1,0.1,1.3,0.3c0.3,0.2,0.4,0.5,0.4,1c0,0.5-0.1,0.8-0.3,1.1
								C96,89,95.6,89.1,95,89.1H93.8L93.8,89.1z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M94.8,84.9H92v8h1.8v-2.2h1.1c1.2,0,2.1-0.2,2.7-0.7c0.6-0.5,0.9-1.2,0.9-2.2c0-1-0.3-1.7-0.8-2.2
								C97,85.1,96.1,84.9,94.8,84.9L94.8,84.9z M93.8,89.1v-2.7h1c0.6,0,1,0.1,1.3,0.3c0.3,0.2,0.4,0.5,0.4,1s-0.1,0.8-0.3,1.1
								C96,89,95.6,89.1,95,89.1H93.8L93.8,89.1z"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="105.6,84.9 99.8,84.9 99.8,92.9 105.7,92.9 105.7,91.3 101.6,91.3 101.6,89.7 105.2,89.7
								105.2,88.1 101.6,88.1 101.6,86.5 105.6,86.5 105.6,84.9 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="105.6,84.9 99.8,84.9 99.8,92.9 105.7,92.9 105.7,91.3 101.6,91.3 101.6,89.7 105.2,89.7
								105.2,88.1 101.6,88.1 101.6,86.5 105.6,86.5 105.6,84.9 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="114.7,84.9 112.9,84.9 112.9,90.1 109,84.9 107.3,84.9 107.3,92.9 109.1,92.9 109.1,87.9
								112.9,92.9 114.7,92.9 114.7,84.9 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="114.7,84.9 112.9,84.9 112.9,90.1 109,84.9 107.3,84.9 107.3,92.9 109.1,92.9 109.1,87.9
								112.9,92.9 114.7,92.9 114.7,84.9 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="87,96.8 85.2,96.8 85.2,100.1 82,100.1 82,96.8 80.2,96.8 80.2,104.8 82,104.8 82,101.7
								85.2,101.7 85.2,104.8 87,104.8 87,96.8 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="87,96.8 85.2,96.8 85.2,100.1 82,100.1 82,96.8 80.2,96.8 80.2,104.8 82,104.8 82,101.7
								85.2,101.7 85.2,104.8 87,104.8 87,96.8 		"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M92.7,96.6c-1.2,0-2.2,0.4-3,1.2c-0.8,0.8-1.2,1.8-1.2,3c0,1.2,0.4,2.2,1.2,3c0.8,0.8,1.8,1.2,3,1.2
								c1.2,0,2.2-0.4,3-1.2c0.8-0.8,1.2-1.8,1.2-3c0-1.2-0.4-2.2-1.2-3C94.9,97,93.9,96.6,92.7,96.6L92.7,96.6z M92.7,103.3
								c-0.7,0-1.2-0.3-1.7-0.8c-0.5-0.5-0.7-1.1-0.7-1.8c0-0.7,0.2-1.3,0.7-1.8c0.5-0.5,1-0.8,1.7-0.8s1.2,0.3,1.7,0.8
								c0.5,0.5,0.7,1.1,0.7,1.8c0,0.7-0.2,1.3-0.7,1.8C94,103.1,93.4,103.3,92.7,103.3L92.7,103.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M92.7,96.6c-1.2,0-2.2,0.4-3,1.2c-0.8,0.8-1.2,1.8-1.2,3c0,1.2,0.4,2.2,1.2,3c0.8,0.8,1.8,1.2,3,1.2
								c1.2,0,2.2-0.4,3-1.2c0.8-0.8,1.2-1.8,1.2-3c0-1.2-0.4-2.2-1.2-3C94.9,97,93.9,96.6,92.7,96.6L92.7,96.6z M92.7,103.3
								c-0.7,0-1.2-0.3-1.7-0.8c-0.5-0.5-0.7-1.1-0.7-1.8c0-0.7,0.2-1.3,0.7-1.8c0.5-0.5,1-0.8,1.7-0.8s1.2,0.3,1.7,0.8
								c0.5,0.5,0.7,1.1,0.7,1.8c0,0.7-0.2,1.3-0.7,1.8C94,103.1,93.4,103.3,92.7,103.3L92.7,103.3z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M105.3,96.8h-1.8v4.4c0,0.6-0.1,1.2-0.4,1.5c-0.3,0.4-0.7,0.6-1.2,0.6c-0.5,0-0.9-0.2-1.2-0.6
								c-0.3-0.4-0.4-0.9-0.4-1.5v-4.4h-1.8v4.5c0,1.2,0.3,2.1,1,2.7c0.6,0.6,1.5,0.9,2.5,0.9c1,0,1.8-0.3,2.5-0.9c0.6-0.6,1-1.5,1-2.7
								V96.8L105.3,96.8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M105.3,96.8h-1.8v4.4c0,0.6-0.1,1.2-0.4,1.5c-0.3,0.4-0.7,0.6-1.2,0.6c-0.5,0-0.9-0.2-1.2-0.6
								c-0.3-0.4-0.4-0.9-0.4-1.5v-4.4h-1.8v4.5c0,1.2,0.3,2.1,1,2.7c0.6,0.6,1.5,0.9,2.5,0.9c1,0,1.8-0.3,2.5-0.9c0.6-0.6,1-1.5,1-2.7
								V96.8L105.3,96.8z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M109.8,96.6c-0.8,0-1.5,0.2-2.1,0.6c-0.5,0.4-0.8,1-0.8,1.8c0,0.8,0.2,1.3,0.7,1.7
								c0.4,0.4,1.1,0.6,2.1,0.9c0.6,0.1,1,0.3,1.2,0.4c0.2,0.1,0.3,0.3,0.3,0.6c0,0.2-0.1,0.4-0.3,0.6c-0.2,0.1-0.4,0.2-0.8,0.2
								c-0.7,0-1.5-0.4-2.4-1.1l-1.1,1.3c1,0.9,2.2,1.4,3.4,1.4c0.9,0,1.6-0.2,2.1-0.7c0.5-0.4,0.8-1,0.8-1.8c0-0.7-0.2-1.3-0.6-1.6
								c-0.4-0.4-1-0.7-1.8-0.8c-0.8-0.2-1.3-0.4-1.5-0.5c-0.2-0.1-0.3-0.3-0.3-0.6s0.1-0.4,0.3-0.6c0.2-0.1,0.4-0.2,0.7-0.2
								c0.7,0,1.5,0.3,2.2,0.8l0.9-1.3c-0.4-0.3-0.9-0.6-1.4-0.8C110.8,96.7,110.3,96.6,109.8,96.6L109.8,96.6z"/>
						</g>
						<g>
							<path class="Layer_2" fill="#303C42" d="M109.8,96.6c-0.8,0-1.5,0.2-2.1,0.6s-0.8,1-0.8,1.8c0,0.8,0.2,1.3,0.7,1.7c0.4,0.4,1.1,0.6,2.1,0.9
								c0.6,0.1,1,0.3,1.2,0.4c0.2,0.1,0.3,0.3,0.3,0.6s-0.1,0.4-0.3,0.6c-0.2,0.1-0.4,0.2-0.8,0.2c-0.7,0-1.5-0.4-2.4-1.1l-1.1,1.3
								c1,0.9,2.2,1.4,3.4,1.4c0.9,0,1.6-0.2,2.1-0.7c0.5-0.4,0.8-1,0.8-1.8c0-0.7-0.2-1.3-0.6-1.6c-0.4-0.4-1-0.7-1.8-0.8
								c-0.8-0.2-1.3-0.4-1.5-0.5c-0.2-0.1-0.3-0.3-0.3-0.6c0-0.2,0.1-0.4,0.3-0.6c0.2-0.1,0.4-0.2,0.7-0.2c0.7,0,1.5,0.3,2.2,0.8
								l0.9-1.3c-0.4-0.3-0.9-0.6-1.4-0.8C110.8,96.7,110.3,96.6,109.8,96.6L109.8,96.6z"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="120.3,96.8 114.5,96.8 114.5,104.8 120.4,104.8 120.4,103.2 116.3,103.2 116.3,101.6 119.9,101.6
								119.9,100 116.3,100 116.3,98.4 120.3,98.4 120.3,96.8 		"/>
						</g>
						<g>
							<polygon class="Layer_2" fill="#303C42" points="120.3,96.8 114.5,96.8 114.5,104.8 120.4,104.8 120.4,103.2 116.3,103.2 116.3,101.6 119.9,101.6
								119.9,100 116.3,100 116.3,98.4 120.3,98.4 120.3,96.8 		"/>
						</g>
					</g>
					</svg>
					<h3 class="lookingh3">@lang('messages.have_a_properties_label')</h3>
					<p class="lookingp" style="height:110px;">
						@lang('messages.have_a_properties_description')
					</p>
					@if(!Auth::check())
						<a href="{{ route('login') }}" class="btn btn-default-color newbtn">
							@lang('messages.have_a_properties_label_button')
						</a>
					@else
						<a href="{{ route('home.properties') }}" class="btn btn-default-color newbtn">
							@lang('messages.have_a_properties_label_button')
						</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT WRAPPER -->
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
	  _create: function() {
		this._super();
		this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
	  },
	  _renderMenu: function( ul, items ) {
		var that = this,
		  currentCategory = "";
		$.each( items, function( index, item ) {
		  var li;
		  if ( item.category != currentCategory ) {
			ul.append( "<li class='ui-autocomplete-category' style='font-weight: bold;border-bottom: 1px solid #333;padding: 5px;'>" + item.category + "</li>" );
			currentCategory = item.category;
		  }
		  li = that._renderItemData( ul, item );
		  if ( item.category ) {
			li.attr( "aria-label", item.category + " : " + item.label );
		  }
		});
	  }
	});
  $( "#home_search" ).catcomplete({
		delay: 0,
		source: "{{ route('home.auto_search') }}",
		select: function (event, ui) {
			//alert(ui.item.searchBy);
			$("#code").val(ui.item.code);
			$(this).val(ui.item.label);
			$('#homePageSearchForm').submit();
		}
	});
});
</script>
@endsection
