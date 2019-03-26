@extends('layout.index')

@section('pageTitle', (!empty($objProperty->headline_dk))?$objProperty->headline_dk:$objProperty->headline_eng )

@php

	if($objProperty->description_dk != "") {
		$description = $objProperty->description_dk;
	} else {
		$description = $objProperty->description_eng;
	}

	$meta_desc = substr($description, 0, 150).'...';
	$meta_desc = str_replace("'",'"',$meta_desc);
	$meta_desc = str_replace(chr(13).chr(10),chr(13),$meta_desc);
	$meta_desc = str_replace(chr(13),'',$meta_desc);
	$meta_desc = str_replace(['<br/>','<div>','</div>','<br />','<br>'],'',$meta_desc);
	$meta_desc = nl2br($meta_desc);
	$meta_desc = strip_tags($meta_desc);
	$meta_desc = str_replace('"',"'",$meta_desc);
	$meta_desc = addslashes($meta_desc);

	$location1 = $objProperty->location1;
	$location2 = $objProperty->location2;

	// if($location1 == "" && $location2 == "") {
	// 	if($objProperty->address!="") {
	// 		$mapUrl = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($objProperty->address).'&key=AIzaSyAYUsbSwwhQVXhVTb-75P0TeJmxuggQ8lE';
	// 		$res = file_get_contents($mapUrl);
	// 		$resDecode = json_decode($res, true);
	// 		if($resDecode["status"]=="OK") {
	// 			$result = $resDecode["results"][0]["geometry"]["location"];
	// 			$location1 = $result["lat"];
	// 			$location2 = $result["lng"];
	// 		}
	// 	}
	// }

	$seek_package_id_user_property = 0;
	$getUser = \App\User::select([
		'seek_package_id'
	])->where('id', $objProperty->user_id)->first();

	if($getUser) {
		$seek_package_id_user_property = $getUser->seek_package_id;
	}

@endphp

@section('meta_tags')
	<meta name="keywords" content="{{ $objProperty->headline_dk }}">
	<meta name="description" content="{{ $meta_desc }}">
	@if(!empty($objGallery) && count($objGallery) > 0)
		@foreach($objGallery as $gallery)
			@if(@file_get_contents(asset($gallery->path), 0, NULL, 0, 1))
				<meta property="og:image" content="{{ asset($gallery->path) }}">
			@else
				@if(@file_get_contents(asset('public/'.$gallery->path), 0, NULL, 0, 1))
					<meta property="og:image" content="{{ asset('public/'.$gallery->path) }}">
				@else
					<meta property="og:image" content="{{ asset('public/images/ikke_navngivet_thumb.png') }}">
				@endif
			@endif
		@endforeach
	@else
		<meta
			property="og:image"
			content="{{ asset('images/ikke_navngivet_main.png') }}" />
	@endif
	<meta property="og:url" content="{{ route('property_detail.show.withId', [
		$objProperty->id,
		($objProperty->headline_dk == '' ) ? str_slug($objProperty->headline_eng) : str_slug($objProperty->headline_dk)
	]) }}">
	<meta property="og:title" content="{{ ($objProperty->headline_dk!='') ? $objProperty->headline_dk:$objProperty->headline_eng }}" />
@endsection

@section('content')

	<!-- BEGIN PAGE TITLE/BREADCRUMB -->
	<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h1 class="page-title">{{ __('messages.propertydettails') }}</h1>

					<ul class="breadcrumb">
						<li><a href="{{ route('home') }}">{{ __('messages.lbl_home') }}</a></li>
						<li>
							<a href="{{ route('home.properties') }}">
								@if($objProperty->action == "rent")
									{{ __('messages.lbl_rent_properties') }}
								@elseif($objProperty->action == "buy")
									{{ __('messages.lbl_sale_properties') }}
								@endif
							</a>
						</li>
						<li><a href="javascript:void(0);">{{ __('messages.propertydettails') }}</a></li>
					</ul>
				</div>
				<div class="col-sm-6">
					<div class="row pull-right">
						@php
							if(Auth::user()) {
								$isAdmin = Auth::user()->isAdmin;
							} else {
								$isAdmin = '';
							}
						@endphp
						@if(Auth::check() && Auth::id() == $objProperty->user_id || $isAdmin == 'admin')
							<form action="{{ route('property.delete') }}" method="POST" style="display: inline;" onsubmit="javascript:return confirm('are sure to remove this property?');">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $objProperty->id }}>" name="forDelete">
								<button type="submit" name="delete" class="btn btn-default remove-btn">
									<i class="fa fa-trash-o"></i>
									{{ __('messages.lbl_remove') }}
								</button>
							</form>

							<a class="btn btn-default remove-btn" href="{{ route('property_edit', $objProperty->id) }}">
								<i class="fa fa-edit"></i>
								{{ __('messages.lbl_edit') }}
							</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE TITLE/BREADCRUMB -->
	{{-- content --}}
	<div class="content">
		{{-- container --}}
		<div class="container">
			{{-- row --}}
			<div class="row">
				<div class="main col-sm-8" style="padding-top: 0;">

					<h1 class="property-title" style="margin-bottom: 15px;">
						@if(empty($objProperty->headline_dk))
							{{ $objProperty->headline_eng }}
						@else
							{{ $objProperty->headline_dk }}
						@endif
						<small>{{ (!empty($objProperty->city_name))?$objProperty->city_name:'' }}</small>
					</h1>

					@if(session()->has('message.level'))
						<div class="col-md-12">
							<div class="alert alert-{{ session('message.level') }}">
						    {!! session('message.content') !!}
						    </div>
						</div>
					@endif

					<div class="property-topinfo" style="margin-top: 15px;">
						<ul class="amenities">
							<li><i class="icon-apartment"></i>{{ (!empty($objProperty->type))?__('messages.lbl_'.strtolower($objProperty->type)):"" }}</li>
							<li><i class="icon-area"></i> {{ $objProperty->size }} m2</li>
							<li><i class="icon-bedrooms"></i> {{ $objProperty->rooms }}</li>
							<li><i class="fa fa-clock-o"></i> {{ date('j M, Y',strtotime($objProperty->date_published)) }}</li>
						</ul>
						<div id="property-id">
							@if($objProperty->prop_site_name=='prodomus')
								{{ __('messages.caseId') }}: #{{ $objProperty->housenum }}
							@elseif($objProperty->prop_site_name=='housingdenmark')
								{{ __('messages.caseId') }}: #{{ $objProperty->housenum }}
							@else
								{{ __('messages.caseId') }}: #{{ $objProperty->id }}
							@endif
						</div>
					</div>

					<div id="property-detail-wrapper" class="style1">
						<div class="price {{ ($objProperty->is_available == '0')? 'red':'' }}">
							@if($objProperty->is_available == '1')
								<i class="fa fa-home"></i>
								@if($objProperty->action == 'rent')
									{{ __('messages.lbl_for_rent') }}
								@else
									{{ __('messages.lbl_for_sale') }}
								@endif
							@elseif ($objProperty->is_available == '0')
								<i class="fa fa-ban"></i>
								@if($objProperty->action == 'rent')
									{{ __('messages.lbl_rented') }}
								@else
									{{ __('messages.lbl_sold') }}
								@endif
							@endif
							{{-- <span>{{ number_format($objProperty->price_usd,0,',','.') }} kr {{ ($objProperty->action == 'rent')?'/md':'' }}</span> --}}
							<span>{{ number_format($objProperty->price_usd/1000,3).' kr' }}  {{ ($objProperty->action == 'rent')?'/md':'' }}</span>
						</div>

						<div id="property-detail-large" class="owl-carousel">
							@php $isExists = 0; @endphp;
							@if(count($objGallery) > 0)
								@foreach($objGallery as $gallery)
									@if(@file_get_contents(asset($gallery->path), 0, NULL, 0, 1))
										<div class="item">
											<img
												src="{{ asset($gallery->path) }}"
												alt="Bolig billeder - Finbo - {{ $objProperty->headline_dk }}" style="width:800px;height:452px;">
										</div>
									@else
										@if(@file_get_contents(asset('public/'.$gallery->path), 0, NULL, 0, 1))
											<div class="item">
												<img
													src="{{ asset('public/'.$gallery->path) }}"
													alt="Bolig billeder - Finbo - {{ $objProperty->headline_dk }}" style="width:800px;height:452px;">
											</div>
										@else
											<div class="item">
												<img
													src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
													alt="Bolig billeder - Finbo - {{ $objProperty->headline_dk }}" style="width:800px;height:452px;">
											</div>
										@endif
									@endif
								@endforeach
							@else
								<div class="item">
									<img
										src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
										alt="Bolig billeder - Finbo - {{ $objProperty->headline_dk }}" style="width:800px;height:452px;">
								</div>
							@endif

						</div>

						<div id="property-detail-thumbs" class="owl-carousel">
							@if(!empty($objGallery) && count($objGallery) > 0)
								@foreach($objGallery as $gallery)
									@if(@file_get_contents(asset($gallery->path), 0, NULL, 0, 1))
										<div class="item">
											<img
												src="{{ asset($gallery->path) }}"
												alt="Findbo - {{ $objProperty->headline_dk }}" >
										</div>
									@else
										@if(@file_get_contents(asset('public/'.$gallery->path), 0, NULL, 0, 1))
											<div class="item">
												<img
													src="{{ asset('public/'.$gallery->path) }}"
													alt="Findbo - {{ $objProperty->headline_dk }}" >
											</div>
										@else
											<div class="item">
												<img
													src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
													alt="{{ $objProperty->headline_dk }}"
													style="width:263px;height:230px;">
											</div>
										@endif
									@endif
								@endforeach
							@endif
						</div>
					</div>

					<p id="short_desc_handler">
						@if(!empty($objProperty->description_dk))
							<?php $description = $objProperty->description_dk ?>
						@else
							<?php $description = $objProperty->description_eng ?>
						@endif

						<?php
						$short_desc_limit = 300;
						if(strlen($description) > $short_desc_limit)
						{
							$short_desc = substr($description, 0, $short_desc_limit);
							echo nl2br($short_desc).'...';
							?>
							<span class="text-right" style="display: block;"><a href="javascript:void(0);" onclick="javascript:show_long_desc();">
								<b>{{ __('messages.lbl_read_more') }}</b> <i class="fa fa-chevron-down"></i></a>
							</span>
							<?php
						}
						else
						{
							echo $description;
						}
						?>
					</p>

					<p id="long_desc_handler" style="display: none;">
						<?php echo nl2br($description); ?>
						<span class="text-right" style="display: block;"><a href="javascript:void(0);" onclick="javascript:show_short_desc();">
							<b>{{ __('messages.lbl_less') }}</b> <i class="fa fa-chevron-up"></i></a>
						</span>
					</p>
					<p>&nbsp;</p>

					@if(Auth::check() && $active_pack_id==0 || Auth::user()->package_expiry_date <= date('Y-m-d H:i:s'))
						<div class="contact-landlord">
							<a href="{{ route('package.show', $objProperty->id) }}" class="btn btn-fullcolor contact-landlord">
								<i class="fa fa-lock"></i> {{ __('messages.postLandlord') }}
							</a>
						</div>
					@endif

					@if(!Auth::check())
						<div class="contact-landlord">
							<a data-id="contactLandlordBtn" href="{{ route('login') }}" class="btn btn-fullcolor contact-landlord">
								<i class="fa fa-lock"></i> {{ __('messages.postLandlord') }}
							</a>
						</div>
					@endif

					<h1 class="section-title">{{ __('messages.lbl_property_features') }}</h1>

					@if($objProperty->rooms > 0)
						<ul class="property-features col-sm-6">
							<li><i class="icon-rooms"></i> {{ $objProperty->rooms.' '.__('messages.postrooms') }}</li>
						</ul>
					@endif

					@if($objProperty->size > 0)
						<ul class="property-features col-sm-6">
							<li><i class="icon-area"></i> {{ $objProperty->size }} m2</li>
						</ul>
					@endif

					<?php
					$main_rentDeposit = stripslashes(stripslashes($objProperty->rentDeposit));
					$main_rentDeposit = str_replace('DKK','',$main_rentDeposit);
					$main_rentDeposit = trim($main_rentDeposit);
					if(empty($main_rentDeposit))
						$rentDeposit = '';
					else
						$rentDeposit = $main_rentDeposit;
					?>

					@if($objProperty->action=='rent')
						@if(!empty($rentDeposit))
							<ul class="property-features col-sm-6">
								<li><i class="icon2 icon2-money-banknote tipso" title="{{ __('messages.postDeposit') }}"></i> {{ number_format($rentDeposit/1000,3).' kr.' }}</li>
							</ul>
						@endif
					@endif

					@if((!empty($objProperty->expenses) && $objProperty->expenses > 0) && $objProperty->expenses!="-")
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-flash tipso" title="{{ __('messages.lbl_consumption_and_energy') }}"></i> {{ $objProperty->expenses.' Kr. | ' }}</li>
						</ul>
					@else
						@if((!empty($objProperty->energy) && $objProperty->energy > 0) && $objProperty->energy!="-")
							<ul class="property-features col-sm-6">
								<li><i class="icon2 icon2-flash tipso" title="{{ __('messages.lbl_consumption_and_energy') }}"></i> {{ $objProperty->energy }}</li>
							</ul>
						@endif
					@endif

					@if($objProperty->action=='rent')
						@if(!empty($rentalperiod))
							@if($rentalperiod=='ubegr�nset' || $rentalperiod=='Snarest muligt' || $rentalperiod=='snarest')
							@elseif(strtotime($rentalperiod)>0)
								<!-- // do nothing  -->
							@else
								<ul class="property-features col-sm-6">
									<li><i class="fa fa-clock-o tipso" title="{{ __('messages.lengthofstay') }}"></i> {{ __('messages.rental_period_'.$rentalperiod) }}</li>
								</ul>
							@endif
						@endif
					@endif

					@if($objProperty->action=='buy')
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-crop tipso" title="{{ __('messages.groundArea') }}"></i> {{ $groundarea }} m2</li>
						</ul>
					@endif

					@if($objProperty->action=='buy' && !empty($objProperty->payment))
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-credit-card tipso" title="{{ __('messages.payout') }}"></i> {{ $objProperty->payment.' '.__('messages.pricekvm') }}</li>
						</ul>
					@endif

					@if($objProperty->action=='buy' && !empty($objProperty->gross))
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-money tipso" title="{{ __('messages.gross') }}"></i> {{ $objProperty->gross }}</li>
						</ul>
					@endif

					@if($objProperty->action=='buy' && !empty($objProperty->net))
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-money tipso" title="{{ __('messages.net') }}"></i> {{ $objProperty->net }}</li>
						</ul>
					@endif

					@if($objProperty->action=='buy' && !empty($objProperty->year))
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-calendar tipso" title="{{ __('messages.builtyear') }}"></i> {{ $objProperty->year }}</li>
						</ul>
					@endif

					@if($objProperty=='rent')
						@if($objProperty->pets_allowed == 1 || $objProperty->pets_allowed == 2)
							<ul class="property-features col-sm-6">
								@if($objProperty->pets_allowed==1)
									<li>
										<i class="icon-pets"></i> {{ __('messages.postpetss').' '.__('messages.postallowed') }}
										@if(!empty($objProperty->pets_comment))
											<span style="font-size: 18px;" class="fa fa-info-circle tipso" title="{{ $objProperty->pets_comment }}"></span>
										@endif
									</li>
								@elseif($objProperty->pets_allowed==2)
									<li>
										<i class="icon-pets"></i> {{ __('messages.postpetss').' '.__('messages.postNotallowed') }}
										@if(!empty($objProperty->pets_comment))
											<span style="font-size: 18px;" class="fa fa-info-circle tipso" title="{{ $objProperty->pets_comment }}"></span>
										@endif
									</li>
								@endif
							</ul>
						@endif
					@endif

					@if($objProperty->furnished==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon-01"></i> {{ __('messages.lbl_furnished') }} </li>
						</ul>
					@endif

					@if($objProperty->garage==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon-garage"></i> {{ __('messages.lbl_with').' '.strtolower(__('messages.garage')) }} </li>
						</ul>
					@endif

					@if($objProperty->balcony==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-balcony"></i> {{ __('messages.lbl_with').' '.strtolower(__('messages.postBalcony')) }} </li>
						</ul>
					@endif

					@if($objProperty->entry_phone==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-touch-screen-phone1"></i> {{ __('messages.lbl_with').' '.strtolower(__('messages.lbl_entryphone')) }} </li>
						</ul>
					@endif

					@if($objProperty->lift==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-elevator"></i> {{ __('messages.lbl_with').' '.strtolower(__('messages.postlift')) }} </li>
						</ul>
					@endif

					@if($objProperty->garden==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon-garden"></i> {{ __('messages.lbl_with').' '.strtolower(__('messages.postGarden')) }} </li>
						</ul>
					@endif

					@if($objProperty->youthHousing==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-youth"></i> {{ __('messages.youthFriendly') }} </li>
						</ul>
					@endif

					@if($objProperty->seniorFriendly==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-elderly"></i> {{ __('messages.seniorFriendly') }} </li>
						</ul>
					@endif

					@if($objProperty->handicapFriendly==1)
						<ul class="property-features col-sm-6">
							<li><i class="icon2 icon2-handicap"></i> {{ __('messages.handicapFriendly') }} </li>
						</ul>
					@endif

					@if($objProperty->shareFriendly==1)
						<ul class="property-features col-sm-6">
							<li><i class="fa fa-group"></i> {{ __('messages.shareFriendly') }} </li>
						</ul>
					@endif

					@if($objProperty->basement==1)
						<ul class="property-features col-sm-6">
							<li><i><img style="margin-bottom: 15px;" src="{{ asset('public/images/down_stair.png') }}"></i> {{ __('messages.lbl_basement') }}</i> </li>
						</ul>
					@endif

					@if(!empty($objProperty->vacant))
						<ul class="property-features col-sm-6">
							<li>
								<i class="fa fa-check-circle-o tipso" title="{{ __('messages.postVacant') }}"></i>
								@if(strtolower($objProperty->vacant)=='immediately')
									{{ __('messages.immediately') }}
								@elseif(strtolower($objProperty->vacant)=='appointment')
									{{ __('messages.postAppoinment') }}
								@elseif(strtolower($objProperty->vacant)=='date' && strtotime($objProperty->vacant)>0)
									{{ date('j M, Y',strtotime($objProperty->vacant)) }}
								@endif
							</li>
						</ul>
					@endif

					@if(!empty($objProperty->openHouseDate) && strtotime($objProperty->openHouseDate)>0)
						<ul class="property-features col-sm-6">
							<li>
								<i class="fa fa-unlock-alt tipso" title="{{ __('messages.postOpenHouse') }}"></i>
								{{ date("j M, Y", strtotime($objProperty->openHouseDate)).' ('.$objProperty->openHouseStartTime.' - '.$objProperty->openHouseEndTime.') ' }}
							</li>
						</ul>
					@endif

					@if(Auth::user())
						@if(Auth::check() && Auth::user()->seek_package_id != 0 || Auth::user()->isAdmin == 'admin' && Auth::user()->userType == 1)
							<h1 class="section-title">{{ __('messages.lbl_property_location') }}</h1>
							<div id="property_location" class="map col-sm-12"></div>
						@endif
					@endif

					<div class="share-wraper col-sm-12" style="margin-top:10px;">
						<h5 style="margin-right: 0px;">{{ __('messages.lbl_share_this_property') }}:</h5>

						@php
							$currentLink = route('property_detail.show.withId', [
								$objProperty->id,
								($objProperty->headline_dk == '' ) ? str_slug($objProperty->headline_eng) : str_slug($objProperty->headline_dk)
							]);

							if($objProperty->thumbnail != "") {
								if(@file_get_contents(asset($objProperty->thumbnail), 0, NULL, 0, 1)) {
									$full_path_img_src = asset($objProperty->thumbnail);
								} else {
									if(@file_get_contents(asset('public/'.$objProperty->thumbnail), 0, NULL, 0, 1)) {
										$full_path_img_src = asset('public/'.$objProperty->thumbnail);
									} else {
										$full_path_img_src = asset('public/images/ikke_navngivet_thumb.png');
									}
								}
							} else {
								$full_path_img_src = asset('public/images/ikke_navngivet_thumb.png');
							}

							$pin_desc = str_replace('"',"'",$description);
						@endphp

						<ul class="social-networks">
							<li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $currentLink; ?>"><i class="fa fa-facebook"></i></a></li>
							<li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $currentLink; ?>"><i class="fa fa-twitter"></i></a></li>
							<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $currentLink; ?>"><i class="fa fa-google"></i></a></li>
							<li><a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $currentLink; ?>&description=<?php echo $pin_desc; ?>&media=<?php echo $full_path_img_src; ?>"><i class="fa fa-pinterest"></i></a></li>
						</ul>

						@if(Auth::check())
							@if(!empty($objWishlist) && count($objWishlist)>0)
								<?php
									$disRemoveWishlistBtn = '';
									$disAddWishlistBtn = 'display: none;';
								?>
							@else
								<?php
									$disRemoveWishlistBtn = 'display: none;';
									$disAddWishlistBtn = '';
								?>
							@endif
							<a id="removeFromWishlistBtn" class="btn btn-default-color favorite-btn" onclick="javascript:return showHint({{ $objProperty->id }}, {{ Auth::user()->id }});" style="<?php echo $disRemoveWishlistBtn;?>">
								<i class="fa fa-heart"></i>
								{{ __('messages.lbl_remove_from_favorite') }}
							</a>
							<a id="addToWishlistBtn" class="btn btn-default-color favorite-btn" onclick="javascript:return showHint({{ $objProperty->id }}, {{ Auth::user()->id }});" style="<?php echo $disAddWishlistBtn;?>">
								<i class="fa fa-heart"></i>
								{{ __('messages.lbl_add_to_favorite') }}
							</a>
						@endif

						<?php /*@if(Auth::check() && (Auth::user()->id==$objProperty->user_id))
							<a id="propActivateBtn" class="btn btn-default-color favorite-btn" onclick="javascript:return is_prop_available({{ $objProperty->id }},1);" style="{{ (!empty($objProperty->is_available))?'display:none':'' }}">
								<i class="fa fa-check"></i>
								{{ ($objProperty->action=='rent')?__('messages.lbl_prop_activate_rent'):__('messages.lbl_prop_activate_sale') }}
							</a>

							<a id="propDeactivateBtn" class="btn btn-default-color favorite-btn" onclick="javascript:return is_prop_available({{ $objProperty->id }},0);" style="{{ (empty($objProperty->is_available))?'display:none':'' }}">
								<i class="fa fa-ban"></i>
								{{ ($objProperty->action=='rent')?__('messages.lbl_prop_deactivate_rent'):__('messages.lbl_prop_deactivate_sale') }}
							</a>
						@endif*/ ?>

						<a class="print-button" href="javascript:window.print();" style="padding-left: 10px;">
							<i class="fa fa-print"></i>
						</a>

						<a href="#" id="reportBtn" class="btn btn-default-color favorite-btn" data-toggle="modal" data-target="#reportModal" onclick="javascript:showReportForm();" style="float: right; margin-top: 2px;margin-right: 10px;">
							<i class="fa fa-exclamation-circle"></i>
							{{ __('messages.lbl_report') }}
						</a>
					</div>

					@if((Auth::check()) && (!empty($active_pack_id)) && (Auth::user()->id != $objProperty->user_id) && (Auth::user()->package_expiry_date >= date('Y-m-d H:i:s')) || ($isAdmin === 'admin'))
						<h1 class="section-title">{{ __('messages.lbl_contact') }}</h1>
						<div class="row">
							<div class="col-md-12">
								<div class="property-agent-info">
									<div class="agent-detail col-md-5">
										<div class="info">
											<header>
												<h2>
													<small>
														{{ (!empty($objProperty->city_name)) ? $objProperty->city_name: '' }}
													</small>
												</h2>
											</header>
											<ul class="contact-us">

												@if($active_pack_id != 0)

													@if(!empty($objProperty->email) && $objProperty->email != 'info@findbo.dk' && strpos($objProperty->email, 'privat.udlejer') == true)
														<li>
															<i class="fa fa-envelope"></i>
															<a href="mailto:{{ $objProperty->email }}">
																{{ $objProperty->email }}
															</a>
														</li>
													@else
														<!-- <li class="text-muted">
															<i class="fa fa-envelope"></i> Email is empty.
														</li> -->
													@endif

													@if(!empty($objProperty->phonenum1))
														<li>
															<i class="fa fa-phone"></i>
															{{ $objProperty->phonenum1 }} </li>
													@elseif(!empty($objProperty->phonenum2))
														<li>
															<i class="fa fa-phone"></i>
															{{ $objProperty->phonenum2 }}
														</li>
													@else
														<li>
															<i class="fa fa-phone"></i>
															Phone is empty.
														</li>
													@endif

												@endif
											</ul>
										</div>
									</div>

									@if(!empty($objProperty->email) && $objProperty->email != 'info@findbo.dk')
										{{-- <form id="propMessage" action="bolig-detaljer.php" method="POST" class="form-style col-md-7" style="padding:40px 10px;"> --}}
										<form id="propMessage" action="javascript:void(0)" method="POST" class="form-style col-md-7" style="padding:40px 10px;">

											<div class="col-sm-12">
												<textarea name="txtMessage" rows="9" placeholder="{{ __('messages.msg') }}" class="form-control required" style="resize:none;"></textarea>
											</div>
											<div class="center">
												<input type="hidden" value="{{ Auth::user()->id }}" name="userid">
												<input type="hidden" value="{{ $objProperty->user_id}}" name="user2">
												<input type="hidden" value="{{ $objProperty->id }}" name="propertyid">
												<input type="hidden" value="{{ (!empty($objProperty->headline_dk))?$objProperty->headline_dk:$objProperty->headline_eng }}" name="title">
												<input type="hidden" value="{{ $objProperty->email }}" name="modalEmail">
												<input type="hidden" name="messageSubmit" value="Send message" />
												<button type="button" onclick="javascript:submitPropertyMessage();" name="msgSubmitBtn" class="btn btn-default-color "><i class="fa fa-envelope"></i> {{ __('messages.sendmsg') }}</button>
											</div>

										</form>
									@endif

									<script type="text/javascript">
										function submitPropertyMessage() {
											$('#propMessage').submit();
										}
									</script>

								</div>
							</div>
						</div>
					@endif


					<!-- START REPORT MODAL BLOCKS -->
					<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">{{ __('messages.close') }}</span></button>
									<h3 class="modal-title modalHeaderTitle text-center" id="myModalLabel">{{ __('messages.prop_report_msg_1') }}</h3>
								</div>

								<div class="modal-body">
									<form id="reportForm" action="{{ route('send_report_email') }}" method="post">
										{{ csrf_field() }}
										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">{{ __('messages.prop_report_msg_2') }} :</div>
											<div class="col-sm-7">
												<p>
													<input type="email" name="reporter_email" id="reporter_email" required class="form-control formModal" />
													<span style="display: none;" class="reporterMsg" id="errorMsg_reporter_email">{{ __('messages.prop_report_msg_2').' '.__('messages.lbl_is_required') }}</span>
												</p>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">{{ __('messages.lbl_name') }} :</div>
											<div class="col-sm-7">
												<p>
													<input type="text" name="reporter_name" id="reporter_name" required class="form-control formModal" />
													<span style="display: none;" class="reporterMsg" id="errorMsg_reporter_name">{{ __('messages.lbl_name').' '.__('messages.lbl_is_required') }}</span>
												</p>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">{{ __('messages.prop_report_msg_3') }} :</div>
											<div class="col-sm-7">
												<p>
													<select name="reporter_reason" id="reporter_reason" required class="form-control formModal">
											            <option value="{{ __('messages.prop_report_reason_1') }}">{{ __('messages.prop_report_reason_1') }}</option>
											            <option value="{{ __('messages.prop_report_reason_2') }}">{{ __('messages.prop_report_reason_2') }}</option>
											            <option value="{{ __('messages.prop_report_reason_3') }}">{{ __('messages.prop_report_reason_3') }}</option>
											            <option value="{{ __('messages.prop_report_reason_4') }}">{{ __('messages.prop_report_reason_4') }}</option>
										            </select>
												</p>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">&nbsp;</div>
											<div class="col-sm-7">
												<p>
													<textarea style="resize: none;" placeholder="{{ __('messages.prop_report_msg_4') }}" name="reporter_reason_desc" id="reporter_reason_desc" required class="form-control formModal"></textarea>
													<span style="display: none;" class="reporterMsg" id="errorMsg_reporter_reason_desc">{{ __('messages.prop_report_msg_4') }}</span>
												</p>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">&nbsp;</div>
											<div class="col-sm-7" style="margin: 5px 0px;">
												<input type="hidden" name="prop_id" value="{{ $objProperty->id }}" />
												<button type="button" id="reportSubmitBtn" onclick="javascript:submitReport();" class="btn btn-primary loginBtn col-sm-6" style="background-color: #28a9e2; color:#FFFFFF; font-weight: bold;">{{ __('messages.prop_report_msg_5') }}</button>
												<div class="col-sm-6"><div id="reportSubmitBtnWaiter" class="center" style="display:none;"><img src="{{ asset('pulblic/images/loader.gif') }}" style="width:21px; margin:0px 3px;" alt="Wait..." /></div></div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4 text-right" style="margin-top: 10px;">&nbsp;</div>
											<div class="col-sm-7" style="margin: 5px 0px;">&nbsp;</div>
										</div>
									</form>
									<div style="clear:both"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- START REPORT MODAL BLOCKS -->
				</div>


				<div class="sidebar gray col-sm-4" style="margin-top: 20px; margin-bottom: 20px;">
					<h2 class="section-title">{{ __('messages.lbl_similar_properties') }}</h2>
					<div id="similar-properties" class="grid-style1 clearfix">
						<div class="row">
							@if(!empty($relatedProperty) && count($relatedProperty)>0)
								@foreach($relatedProperty as $rp)
									<div class="item col-md-10 it-sid">
										<div class="image" style="border: 1px solid #e4e4e4;">
											<a href="{{ route('property_detail.show.withId', [
											$rp->id,
											($rp->headline_dk == '' ) ? str_slug($rp->headline_eng) : str_slug($rp->headline_dk)
											]) }}">
												<h3>{{ (!empty($rp->headline_dk)) ? $rp->headline_dk:$rp->headline_eng }}</h3>
												<span class="location">{{ (!empty($rp->city_name))?$rp->city_name:'' }}</span>
											</a>
											@if($rp->thumbnail != "")
												@if(@file_get_contents(asset($rp->thumbnail), 0, NULL, 0, 1))
													<img
														src="{{ asset($rp->thumbnail) }}"
														alt="Findbo - {{ $rp->headline_dk }}"
														width="230" height="237">
												@else
													@if(@file_get_contents(asset('public/'.$rp->thumbnail), 0, NULL, 0, 1))
													<img
														src="{{ asset('public/'.$rp->thumbnail) }}"
														alt="Findbo - {{ $rp->headline_dk }}"
														width="230" height="237">
													@else
														<img
															src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
															alt="{{ $rp->headline_dk }}"
															width="230" height="237">
													@endif
												@endif
											@else
												<img src="{{ asset('public/images/ikke_navngivet_thumb.png') }}" alt="Findbo - {{ $rp->headline_dk }}" width="230" height="237" />
											@endif
										</div>
										<div class="price">
											<i class="fa fa-home"></i>{{ ($rp->action=='rent')?__('messages.lbl_for_rent'):__('messages.lbl_for_sale') }}
											<span>{{ number_format($rp->price_usd,0,',','.') }} kr {{ ($rp->action=='rent')?'/md':'' }}</span>
											<!-- <span>{{ number_format($rp->price_usd/1000,3).' kr' }}  {{ ($rp->action=='rent')?'/md':'' }}</span> -->
										</div>
										<ul class="amenities">
											@if(!empty($rp->size))
												<li><i class="icon-area"></i> {{ $rp->size }} m2</li>
											@endif
											<li><i class="icon-bedrooms"></i> {{ $rp->rooms }}</li>
										</ul>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>

			</div>
			{{-- ./row --}}
		</div>
		{{-- /container --}}
	</div>
	{{-- ./content --}}
@endsection

@section('scripts')
	<script src="{{ asset('public/js/tipso/src/tipso.js') }}"></script>
		@php
			$map_desc = substr($description, 0, 30);
			$map_desc = str_replace("'",'"',$map_desc);
			$map_desc = str_replace(chr(13).chr(10),chr(13),$map_desc);
			$map_desc = str_replace(chr(13),'',$map_desc);
			$map_desc = nl2br($map_desc);
			$map_desc = addslashes($map_desc); // stripcslashes($map_desc);

			if($objProperty->thumbnail!="") {
				$thumbnail = asset($objProperty->thumbnail);
			} else {
				$thumbnail = asset('images/ikke_navngivet_thumb.png');
			}
		@endphp
	<script src="{{ asset('public/js/markerclusterer.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		function showReportForm() {
			$('.reporterMsg').removeClass('errorMsg').hide();
		}

		function submitReport() {
			$('.reporterMsg').removeClass('errorMsg').hide();
			var isValid = true;

			var reporter_email = $.trim($('#reporter_email').val());
			if(reporter_email == '') {
				$('#errorMsg_reporter_email').addClass('errorMsg').show();
				isValid = false;
			}

			var reporter_name = $.trim($('#reporter_name').val());
			if(reporter_name == '') {
				$('#errorMsg_reporter_name').addClass('errorMsg').show();
				isValid = false;
			}

			var reporter_reason_desc = $.trim($('#reporter_reason_desc').val());
			if(reporter_reason_desc == '') {
				$('#errorMsg_reporter_reason_desc').addClass('errorMsg').show();
				isValid = false;
			}

			if(!isValid) {
				return false;
			}

			$("#reportSubmitBtn").hide();
			$("#reportSubmitBtnWaiter").show();

			$.ajax({
				type : "POST",
				url	 : $('#reportForm').attr('action'),
				data : $('#reportForm').serialize(),
				global: false,
				cache: false,
				async: false,
				dataType : 'json',
				success : function(data) {
					if(data.status == "success") {
						$("#reportSubmitBtnWaiter").hide();
						$("#reportSubmitBtn").show();

						$("#reportModal").removeClass("fade").modal("hide");
					} else {
						$("#reportSubmitBtnWaiter").hide();
						$("#reportSubmitBtn").show();
					};
				}
			});
		}

		function showHint(str, str1) {
			$.ajax({
				type : "POST",
				url	 : "{{ route('add_remove_wishlist') }}",
				headers : {
					'X-CSRF-TOKEN' : "{{ csrf_token() }}",
				},
				data : "q="+str+"&i="+str1,
				global: false,
				cache: false,
				async: false,
		    success : function(data) {
					if(data == "added") {
		  			$("#addToWishlistBtn").hide();
		  			$("#removeFromWishlistBtn").show();
					} else {
						$("#removeFromWishlistBtn").hide();
						$("#addToWishlistBtn").show();
					}
				}
			});
		}

		function is_prop_available(str,str1) {
		  var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		    if (xmlhttp.readyState==4 && xmlhttp.status==200){
		      if(xmlhttp.responseText == 'deactivated') {
		    	  $("#propDeactivateBtn").hide();
			      $("#propActivateBtn").show();
		      } else if(xmlhttp.responseText == 'activated') {
		    	  $("#propActivateBtn").hide();
		    	  $("#propDeactivateBtn").show();
		      }
		    }
		  }
		  xmlhttp.open("GET","isPropertyAvailable.php?q="+str+"&i="+str1,true);
		  xmlhttp.send();
		}

		function show_long_desc() {
		  $("#short_desc_handler").hide();
		  $("#long_desc_handler").show();
		}

		function show_short_desc() {
			$("#long_desc_handler").hide();
			$("#short_desc_handler").show();
		}

		function closePackageNotification() {
			$("#packageNotificationDiv").hide('slow');
		}

		function getMap(latitude,longtitude) {
			var currentProperty = [{	"id": 0,
				"title" : "{{ (!empty($objProperty->headline_dk)) ? $objProperty->headline_dk:$objProperty->headline_eng }}",
				"latitude":latitude,
				"longitude":longtitude,
				"image" : "{{ $thumbnail }}",
				"description" : "{{ $map_desc.'...' }}",
				"link":"{{ route('property_detail.show.withId', [
					$objProperty->id,
					($objProperty->headline_dk == '' ) ? str_slug($objProperty->headline_eng) : str_slug($objProperty->headline_dk)
				]) }}",
				"map_marker_icon":"{{ asset('public/images/markers/green-marker-residential.png') }}"
			}];
			return Cozy.propertiesMap(currentProperty, 'property_location', 0);
		}

		(function($) {
			"use strict";

			$(document).ready(function() {

				$('#mc-embedded-subscribe-form').submit(function (event) {
					if ( event ) event.preventDefault();
			    var $form = $(this);
			    if ( $form.length > 0 ) { register($form); }
				});

				$('.tipso').tipso();

				@if(Auth::user())
					@if(Auth::check() && Auth::user()->seek_package_id != 0 || Auth::user()->isAdmin == 'admin' && Auth::user()->userType == 1)
						@if(!is_null($location1) && !empty($location1) && !is_null($location2) && !empty($location2))
							getMap({{ $location1 }},{{ $location2 }});
						@else
							jQuery.ajax({
								url : "{{ route('get-latitude-longtitude') }}?address={{ urlencode($objProperty->address) }}",
								method : "GET",
								dataType : "json",
								success : function(res) {
									if(res.status == 'OK') {
										console.log(res);
										var latitude = res['results'][0].geometry.location.lat;
										var longtitude = res['results'][0].geometry.location.lng;
										getMap(latitude,longtitude);
									}
								}
							});
						@endif
					@endif
				@endif

			});

		}) (jQuery);
	</script>

@endsection
