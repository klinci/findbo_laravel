@extends('layout.index')

@section('pageTitle', __('messages.lbl_new_property_seeker'))

@section('meta_tags')
	<meta name="keywords" content="">
	<meta name="description" content="{{ __('messages.meta_desc_home_seeker') }}">
	<meta property="og:title" content="{{ $objHomeSeeker->title }}" />
	<meta
		property="og:url"
		content="{{ route('home_seeker.show', $objHomeSeeker->id) }}">
	<meta property="og:image" content="{{ asset($objHomeSeeker->thumbnail) }}" />
	<meta property="og:description" content="{{ $objHomeSeeker->description }}"/>
@endsection

@section('content')

@if(Auth::check() && Auth::user()->userType == '2' && Auth::user()->is_paid_member == '0')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Your account has not yet been paid!</h1>

				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">{{ __('messages.lbl_home')}} </a></li>
					<li>Your account has not yet been paid!</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		 <div class="row green" style="padding-top:70px; padding-bottom:30px; border-bottom:solid 1px #ccc;">
			<div class="main col-sm-12" style="text-align:center; font-weight:bold;">
				<h3 style="color: #4D4F56;">Please buy a package first before proceeding by click <a href="{{ route('packages') }}">here</a>.</h3><br/>
	          	<!-- <h1 style="color: #4D4F56;"> <i class="fa fa-lg fa-spinner fa-spin"></i></h1> -->
	          	<script type="text/javascript">/*
	          		window.setTimeout(function(){
	          			window.location.href="{{ url('/') }}";
		          	}, 3000);*/
	          	</script>
			</div>
		</div>
	</div>
</div>
@else
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1 class="page-title">{{ __('messages.lbl_new_property_seeker') }}</h1>

				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.lbl_new_property_seeker') }}</li>
				</ul>
			</div>

			<div class="col-sm-6">
				<div class="row pull-right">

						@php
							$activeInactiveAction = '0';
							if((!empty($l_user_id)) && ($l_user_id == $objHomeSeeker->user2) && (!empty($active_pack_id))) {
								if($objHomeSeeker->is_active == '0') {
									$activeInactiveAction = '1';
								}
							}
						@endphp
						{{-- <a
							class="btn btn-default"
								href="{{ route('home_seeker_activate', [
									$objHomeSeeker->id,
									$activeInactiveAction
								]) }}">
							@if($activeInactiveAction == '0')
								Hide requirement
							@else
								Show requirement
							@endif
						</a> --}}
						@if(Auth::check() && Auth::user()->id == $objHomeSeeker->userFk)
							<a class="btn btn-default remove-btn" href="{{ route('home_seeker.edit', $objHomeSeeker->id) }}">
								<i class="fa fa-edit"></i>
								{{ __('messages.lbl_edit') }}
							</a>
						@endif

						<?php /*
					} */
					?>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row howw">
			<div class="min col-sm-12 mainpbt">
				<div class="row">
					<div class="main col-sm-8" style="padding-top: 0px;">
						<h1 class="property-title"  style="margin-bottom: 15px;margin-top: 0px;">{{ $objHomeSeeker->title }} <small>{{ $objHomeSeeker->loc }}</small></h1>

						<div class="agent-detail clearfix" style="margin-top: 15px;">
							<div class="image col-md-5">
								@if(!empty($thumbnail) && file_exists($thumbnail))
									<img src="{{ asset($thumbnail) }}" alt="" />
								@else
									<!-- <img src="{{ asset('public/images/blank_profile.jpg') }}" alt="" /> -->
									<img src="{{ asset('public/images/prof_img.jpg') }}" alt="" />
								@endif
							</div>

							<div class="info col-md-7">
								<header style="margin-bottom:0px;">
									<h2>{{ $objHomeSeeker->name }}</h2>
								</header>

								<table class="table table-striped">
									<tr>
										<td class="seektr">{{ __('messages.lbl_civil_status') }}</td>
										<td><strong>{{ __('messages.lbl_'.$objHomeSeeker->civilStatus) }}</strong></td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.postAreas') }}</td>
										<td><strong>{{ $objHomeSeeker->loc }}</strong></td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.lbl_min_rooms') }}</td>
										<td><strong>{{ $objHomeSeeker->minRooms }}</strong></td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.lbl_min_area') }}</td>
										<td><strong>{{ $objHomeSeeker->minArea }}</strong> m2</td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.lbl_max_rent') }}</td>
										<td><strong>{{ $objHomeSeeker->maxRent }}</strong> DKK</td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.lbl_property_type') }}</td>
										<td><strong>{{ __('messages.lbl_'.$objHomeSeeker->type) }}</strong></td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.rentalperiod') }}</td>
										<td><strong>
											@if($objHomeSeeker->rentalPeriod=='unlimited')
												{{ __('messages.lbl_unlimited') }}
											@elseif($objHomeSeeker->rentalPeriod=='More than 12 months')
												{{ __('messages.lbl_more_than_12_months') }}
											@elseif($objHomeSeeker->rentalPeriod=='Less than 12 months')
												{{ __('messages.lbl_less_than_12_months') }}
											@endif
										</strong></td>
									</tr>

									<tr>
										<td class="seektr">{{ __('messages.lbl_date') }}</td>
										<td><strong>{{ $objHomeSeeker->date }}</strong></td>
									</tr>

								</table>
							</div>
						</div>

						<div class="share-wraper col-sm-12">
							<h5 style="margin-right: 0px;">{{ __('messages.lbl_share_this_property') }}:</h5>
							@php
								$currentLink = route('home_seeker.show', $objHomeSeeker->id);
								$full_path_img_src = 'https://'.$_SERVER['HTTP_HOST'].'/'.$thumbnail;
							@endphp

							<ul class="social-networks">

								<li>
									<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u={{ $currentLink }}">
										<i class="fa fa-facebook"></i>
									</a>
								</li>

								<li><a target="_blank" href="https://twitter.com/intent/tweet?text={{ $currentLink }}"><i class="fa fa-twitter"></i></a></li>
								<li><a target="_blank" href="https://plus.google.com/share?url={{ $currentLink }}"><i class="fa fa-google"></i></a></li>
								<li><a target="_blank" href="http://pinterest.com/pin/create/button/?url={{ $currentLink }}&description={{ $objHomeSeeker->description }}&media={{ $full_path_img_src }}"><i class="fa fa-pinterest"></i></a></li>
							</ul>

							<a class="print-button" href="javascript:window.print();" style="padding-left: 10px;">
								<i class="fa fa-print"></i>
							</a>

						</div>

						<p class="center">
							{{ $objHomeSeeker->description }}
						</p>

						@if((!empty($l_user_id) && ($l_user_id != $objHomeSeeker->user2) && (!empty($is_paid_member))) || ($isAdmin == 0))
							<h1 class="section-title" id="contact-agent">{{ __('messages.lbl_seeker_detail_msg_1') }}</h1>
							<form action="{{ route('home_seeker_contact') }}" method="post" class="form-style">
								{{ csrf_field() }}
								<div class="col-sm-12">
									<select name="propertyid" required class="form-control">
										<option value="">{{ __('messages.lbl_seeker_detail_msg_2') }}</option>
										@if(!empty($objHomeSeekerProperty) && count($objHomeSeekerProperty)<1)
											<option value="">{{ __('messages.lbl_seeker_detail_msg_3') }}</option>
										@else
											@foreach($objHomeSeekerProperty as $prop)
												@if($prop->headline_dk != "")
													<option value="{{ $prop->id }}">{{ $prop->headline_dk }} </option>
												@else
													<option value="{{ $prop->id }}">{{ $prop->headline_eng }} </option>
												@endif
											@endforeach
										@endif
									</select>
									<textarea name="text" placeholder="{{ __('messages.msg') }}" class="form-control required"></textarea>
									<input type="hidden" value="{{ $l_user_id }}" name="userid">
						            <input type="hidden" value="{{ $objHomeSeeker->user2 }}" name="user2">
						            <input type="hidden" value="{{ $objHomeSeeker->title }}" name="title">
						            <input type="hidden" value="{{ $objHomeSeeker->email }}" name="modalEmail">
						            <input type="hidden" value="{{ $objHomeSeeker->id }}" name="redirect">
								</div>
								<div class="center">
									<button type="submit" class="btn btn-default-color" name="messageSubmit"><i class="fa fa-envelope"></i> {{ __('messages.sendmsg') }}</button>
								</div>
							</form>
						@elseif(empty($l_user_id))
							<div class="contact-landlord" style="margin-top: 60px;">
								<a data-id="contactLandlordBtn" data-rd="{{ route('home_seeker.show', $objHomeSeeker->id) }}" href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-fullcolor contact-landlord">
									<i class="fa fa-lock"></i> {{ __('messages.postSeeker') }}
								</a>
							</div>
						@elseif(!empty($l_user_id) && ($l_user_id != $objHomeSeeker->user2) && (empty($is_paid_member)))
							<div class="contact-landlord" style="margin-top: 60px;">
								<input type="hidden" name="{{ $l_user_id }}" value="dd" />
								<a href="{{ route('packages') }}" class="btn btn-fullcolor contact-landlord">
									<i class="fa fa-lock"></i> {{ __('messages.postSeeker') }}
								</a>
							</div>
						@endif
					</div>

					<div class="sidebar gray col-sm-4" style="margin-bottom: 20px;">
						<h2 class="section-title">{{ __('messages.lbl_house_seekers_smae_area') }}</h2>
						<ul class="latest-news">
							@if(!empty($arrOfProperty) && count($arrOfProperty) > 0)
								@foreach($arrOfProperty as $row)
									<li class="col-md-12">
										<div class="image">
											<a href="{{ route('home_seeker.show', $row->id) }}"></a>
											@if(!empty($row->thumbnail) && ($row->thumbnail!="images/propertyimages/genericThumb.jpg") && file_exists($row->thumbnail))
												<img src="{{ $row->thumbnail }}" alt="" style="margin-bottom: 0px;" />
											@else
												<img src="{{ asset('public/images/prof_img.jpg') }}" style="margin-bottom: 0px;" alt="" />
											@endif
										</div>

										<ul class="top-info">
											<li><i class="fa fa-map-marker"></i> {{ $row->loc }}</li>
										</ul>

										<h3>
											<span style="width: 67%; display: block; float: right;">
												<a href="{{ route('home_seeker.show', $row->id) }}"></a>{{ ($row->title!="")?$row->title:$row->name }}</a>
											</span>
										</h3>
										<span style="clear: both;"></span>
									</li>
								@endforeach
							@endif
						</ul>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endif
<script type="text/javascript">
function printpage()
{
    window.print();
}
</script>
@endsection
