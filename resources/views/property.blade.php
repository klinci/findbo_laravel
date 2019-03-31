@extends('layout.index')

@section('pageTitle', __('messages.title_property_list'))

@section('meta_tags')
	<meta name="keywords" content="">
	<meta name="description" content="{{ __('messages.meta_desc_property_page') }}">
@endsection

@php
	$timeout = stream_context_create([
    'http' => [
			'timeout' => 2
    ]
	]);
	// $timeout = null;
@endphp

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.searchresults') }}</h1>

				<ul class="breadcrumb">
					<li><a href="index.php">{{ __('messages.lbl_home') }}</a></li>
					<li>
						<a href="{{ route('home.properties') }}">
							@if($action=='rent')
								<span id="tlt_rent">{{ __('messages.tlt_rent_properties')}}</span>
							@else
								<span id="tlt_sale">{{ __('messages.tlt_sale_properties') }}</span>
							@endif
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
			<form action="{{ route('home.properties') }}" method="post" id="sidebarForm">
				{{ csrf_field() }}
				<input type="hidden" name="page" id="page" value="{{ $page }}" />
				<input type="hidden" name="sortorder" id="sortorder" value="{{ $sortOrder }}" />

				<div class="main col-sm-8" style="padding-top: 0;">
					<div id="listing-header" class="clearfix" style="margin-top: 55px;">

						<div class="form-control-small">
							<select id="cmb_sort_by" name="sortby" data-placeholder="Sort">
								<option {{ ($sortBy=='date')?' selected="selected"':''}} value="date">{{ __('messages.lbl_sort_by_date') }}</option>
								<option {{ ($sortBy=='size')?' selected="selected"':''}} value="size">{{ __('messages.lbl_sort_by_area') }}</option>
								<option {{ ($sortBy=='price')?' selected="selected"':''}} value="price">{{ __('messages.lbl_sort_by_price') }}</option>
							</select>
						</div>

						<div class="sort">
							<ul>
								<li class="{{ ($sortOrder == 'desc')?'active':'' }}" onclick="javascript:changeSortOrder('desc');">
									<i data-toggle="tooltip" data-placement="top" title="{{ __('messages.lbl_sort_descending') }}" class="fa fa-chevron-down"></i>
								</li>
								<li class="{{ ($sortOrder == 'asc')?'active':'' }}" onclick="javascript:changeSortOrder('asc');">
									<i data-toggle="tooltip" data-placement="top" title="{{ __('messages.lbl_sort_ascending') }}" class="fa fa-chevron-up"></i>
								</li>
							</ul>
						</div>

						<div class="form-control-small" style="margin-left: 10px;">
							<div class="input-group">
								<input type="text" class="form-control" name="txtPrice" id="txtPrice" style="margin-bottom: 0px !important;" placeholder="Søg efter pris" value="{{ $price }}" />
								<span class="input-group-addon" onclick="search()">
									<i class="fa fa-search"></i>
								</span>
							</div>
						</div>

						<div class="view-mode">
							<a href="{{ route('home.map') }}" class="btn btn-fullcolor">
								{{ __('messages.lbl_view_map') }}
							</a>
						</div>

					</div>
					<div id="property-listing" class="list-style clearfix">
						<div class="row">
							@if(!empty($result) && count($result)>0)
								@foreach($result as $proData)
									<div class="item col-md-4">
										<div class="image" style="border: 1px solid #e4e4e4;">
											<a href="{{ route('property_detail.show.withId', [
												$proData->id,
												($proData->headline_dk == '' ) ? str_slug($proData->headline_eng) : str_slug($proData->headline_dk)
												]) }}">
												<span class="btn btn-default">
													<i class="fa fa-file-o"></i> @lang('messages.lbl_details')
												</span>
											</a>
											@if($proData->thumbnail != "")

												@if(@file_get_contents(asset($proData->thumbnail), 0, $timeout))
													<img
														src="{{ asset($proData->thumbnail) }}"
														alt="{{ $proData->headline_dk }}"
														style="width:263px;height:230px;">
												@else
													@if(@file_get_contents(asset('public/'.$proData->thumbnail), 0, $timeout))
													<img
														src="{{ asset('public/'.$proData->thumbnail) }}"
														alt="{{ $proData->headline_dk }}"
														style="width:263px;height:230px;">
													@else
														<img
															src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
															alt="{{ $proData->headline_dk }}"
															style="width:263px;height:230px;">
													@endif
												@endif

											@else
												<img
													src="{{ asset('public/images/ikke_navngivet_thumb.png') }}"
													alt="{{ $proData->headline_dk }}"
													style="width:263px;height:230px;">
											@endif
										</div>

										<div class="price {{ ($proData->is_available == '0')?'red':'' }}">
											@if($proData->is_available == '1')
												<i class="fa fa-home"></i>{{ ($proData->action == 'rent')?__('messages.lbl_for_rent'):__('messages.lbl_for_sale') }}
											@elseif($proData->is_available == '0')
												<i class="fa fa-ban"></i>{{ ($proData->action == 'rent')?__('messages.lbl_rented'):__('messages.lbl_sold') }}
											@endif
											{{-- <span>{{ number_format($proData->price_usd,0,',','.') }} kr {{ ($proData->action=='rent')?'/md':''}}</span> --}}
											<span>{{ number_format($proData->price_usd/1000,3) }} kr {{ ($proData->action=='rent')?'/md':''}}</span>
										</div>

										<div class="info">
											<h3>
												<a href="{{ route('property_detail.show.withId', [
													$proData->id,
													($proData->headline_dk == '' ) ? str_slug($proData->headline_eng) : str_slug($proData->headline_dk)
													]) }}">
													{{ ($proData->headline_dk == '' ) ? $proData->headline_eng : $proData->headline_dk }}
												</a>
												<small>{{ ($proData->city_name!='')?$proData->city_name:'' }}</small>
											</h3>

											<p>
												<?php
												if(empty($proData->description_dk))
												{
													$description = $proData->description_eng;
												}
												else
												{
													$description = $proData->description_dk;
												}
												$words = explode(" ",$description);
												echo implode(" ",array_splice($words,0,27));
												?>
											</p>

											<ul class="amenities">
												@if($proData->size!="")
													<li><i class="icon-area"></i> {{ $proData->size }} m2</li>
												@endif
												<li><i class="icon-bedrooms"></i> {{ $proData->rooms }}</li>
											</ul>
										</div>

									</div>
								@endforeach
							@else
								<div class="item col-md-4"><div class="text-center">{{ __('messages.noResults') }}</div></div>
							@endif
						</div>
					</div>

						@if(!empty($result) && count($result)>0)
							@if(!empty($pagination) && count($pagination)>0)
								<div class="pagination">
									@if(empty($pagination['previous']))
										<ul id='previous'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-left'></i></a></li></ul>
									@else
										<ul id='previous'><li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['previous'] }}"><i class='fa fa-chevron-left'></i></a></li></ul>
									@endif

									<ul>
										@if(array_key_exists('firstpage',$pagination))
											<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['firstpage']['page'] }}">{{ $pagination['firstpage']['page'] }}</a></li>
										@endif

										@if(array_key_exists('secondpage',$pagination))
											<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['secondpage']['page'] }}">{{ $pagination['secondpage']['page'] }}</a></li>
										@endif

										@if(array_key_exists('first_dot',$pagination))
											<li class='dot'>..</li>
										@endif

										@foreach($pagination["page"] as $page)
											@if(empty($page['url']))
												<li class='active'><a href='javascript:void(0);'>{{ $page['page'] }}</a></li>
											@else
												<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $page['page'] }}">{{ $page['page'] }}</a></li>
											@endif
										@endforeach

										@if(array_key_exists('last_dot',$pagination))
											<li class='dot'>..</li>
										@endif

										@if(array_key_exists('lpm1', $pagination))
											<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['lpm1']['page'] }}">{{ $pagination['lpm1']['page'] }}</a></li>
										@endif

										@if(array_key_exists('lastpage', $pagination))
											<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['lastpage']['page'] }}">{{ $pagination['lastpage']['page'] }}</a></li>
										@endif
									</ul>


									@if(empty($pagination['next']))
										<ul id='next'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-right'></i></a></li></ul>
									@else
										<ul id='next'><li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['next'] }}"><i class='fa fa-chevron-right'></i></a></li></ul>
									@endif

								</div>
							@endif
						@endif

					</div>

				<!-- search bar -->
				<div class="sidebar gray col-sm-4">
					<h2 class="section-title">{{ __('messages.psearchtitle') }}</h2>


					<div class="form-group">
						<div class="col-sm-12">
							<input type="hidden" name="code" id="code" value="{{ $code }}" />
							<input type="text" id="txtKeywords" name="keywords" class="form-control" value="{{ ($keyword != 'all' )?$keyword:'' }}" placeholder="{{ __('messages.msg_homepage_2') }}">

							<!--

							<div id="showArea" class="chzn-container chzn-container-single chzn-container-single-nosearch">
								<a class="chzn-single" tabindex="-1" href="javascript:void(0)">
									<span>{{ __('messages.interestedarea') }}</span>
									<div><b></b></div>
								</a>

								<?php /*<div class="chzn-drop area" style="left: 0px; position: relative; z-index: 1009;display: none;">
									<ul class="chzn-results dd_ul">
										@if(!empty($objAreas) && count($objAreas)>0)
											@foreach($objAreas as $area)
												<li class="dd_li">
										            <label>
										              <input type="checkbox" class="chkForArea" value="{{ $area->id }}" name="area[{{ $area->id }}]" {{ (array_key_exists($area->id, $arrOfArea))?" checked='checked'":"" }}>{{ $area->name}}
										            </label>
									            </li>
											@endforeach
										@endif
									</ul>
								</div>*/ ?>

								<div class="chzn-drop area" style="left: 0px; position: relative; z-index: 1009;display: none;">
									<ul class="chzn-results dd_ul">
										@if(!empty($objZipcode) && count($objZipcode)>0)
											@foreach($objZipcode as $zipcode)
												@if($zipcode->city_name != "")
													<li class="dd_li">
											            <label>
											              <input type="checkbox" class="" value="{{ $zipcode->id }}" name="zip[{{ $zipcode->id }}]" {{ (array_key_exists($zipcode->id, $arrOfZip))?" checked='checked'":"" }}>{{ $zipcode->city_name}}
											            </label>
										            </li>
										         @endif
											@endforeach
										@endif
									</ul>
								</div>

							</div>

							-->

							<div id="showType" class="chzn-container chzn-container-single chzn-container-single-nosearch">
								<a class="chzn-single" tabindex="-1" href="javascript:void(0)">
									<span>{{ __('messages.propertyType') }}</span>
									<div><b></b></div>
								</a>
								<div class="chzn-drop type" style="left: 0px; position: relative; z-index: 1009; display:none;">
									<ul class="chzn-results dd_ul">
										@if(!empty($objPropertiesType) && count($objPropertiesType)>0)
											@foreach($objPropertiesType as $propertyType)
												@if(Lang::has('messages.title_'.strtolower($propertyType->type)))
													<li class="dd_li">
											            <label>
											              <input type="checkbox" value="{{ $propertyType->type }}" name="type[{{ $propertyType->type }}]" {{ (array_key_exists($propertyType->type,$arrOfType))?" checked='checked'":"" }}>{{ __('messages.title_'.strtolower($propertyType->type)) }}
											            </label>
										            </li>
										         @endif
											@endforeach
										@endif
									</ul>
								</div>
							</div>

						</div>

						<div class="col-md-6">
							<select id="search_minprice" name="minPrice" class="chosen_no_search_bar" data-placeholder="Min. Price">
								<option value="">{{ __('messages.lbl_min_price') }}</option>
								@foreach($priceRange as $key=>$value)
									<option value="{{ $value }}" {{ ($minprice==$value)?"selected='selected'":"" }}>DKK {{ number_format($value,0,',','.') }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<select id="search_maxprice" name="maxPrice" class="chosen_no_search_bar" data-placeholder="Max. Price">
								<option value="">{{ __('messages.lbl_max_price') }}</option>
								@foreach($priceRange as $key=>$value)
									<option value="{{ $value }}" {{ ($maxprice==$value)?"selected='selected'":"" }}>DKK {{ number_format($value,0,',','.') }}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-6">
							<select id="search_minarea" name="minArea" class="chosen_no_search_bar" data-placeholder="Min. Area">
								<option value="">{{ __('messages.lbl_min_size') }}</option>
								@foreach($areaRange as $key=>$value)
									<option value="{{ $value }}" {{ ($minarea==$value)?"selected='selected'":"" }}>{{ $value}} m2</option>
								@endforeach
						</select>
						</div>
						<div class="col-md-6">
							<select id="search_maxarea" name="maxArea" class="chosen_no_search_bar" data-placeholder="Max. Area">
								<option value="">{{ __('messages.lbl_max_size') }}</option>
								@foreach($areaRange as $key=>$value)
									<option value="{{ $value }}" {{ ($maxarea==$value)?"selected='selected'":"" }}>{{ $value }} m2</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-6">
							<select id="search_minrooms" name="minRooms" class="chosen_no_search_bar" data-placeholder="Min. Rooms">
								<option value="">{{ __('messages.lbl_search_min_rooms') }}</option>
								<option value="1" {{ ($minrooms==1)?"selected='selected'":"" }}>1 {{ __('messages.lbl_room') }}</option>
								<option value="2" {{ ($minrooms==2)?"selected='selected'":"" }}>2 {{ __('messages.lbl_rooms') }}</option>
								<option value="3" {{ ($minrooms==3)?"selected='selected'":"" }}>3 {{ __('messages.lbl_rooms') }}</option>
								<option value="4" {{ ($minrooms==4)?"selected='selected'":"" }}>4 {{ __('messages.lbl_rooms') }}</option>
								<option value="5" {{ ($minrooms==5)?"selected='selected'":"" }}>5 {{ __('messages.lbl_rooms') }}</option>
							</select>
						</div>

						<div class="col-md-6">
							<select id="search_maxrooms" name="maxRooms" class="chosen_no_search_bar" data-placeholder="Max. Rooms">
								<option value="">{{ __('messages.lbl_search_max_rooms') }}</option>
								<option value="1" {{ ($getMaxRooms==1)?"selected='selected'":"" }}>1 {{ __('messages.lbl_room') }}</option>
								<option value="2" {{ ($getMaxRooms==2)?"selected='selected'":"" }}>2 {{ __('messages.lbl_rooms') }}</option>
								<option value="3" {{ ($getMaxRooms==3)?"selected='selected'":"" }}>3 {{ __('messages.lbl_rooms') }}</option>
								<option value="4" {{ ($getMaxRooms==4)?"selected='selected'":"" }}>4 {{ __('messages.lbl_rooms') }}</option>
								<option value="5" {{ ($getMaxRooms==5)?"selected='selected'":"" }}>5 {{ __('messages.lbl_rooms') }}</option>
							</select>
						</div>

						<div class="col-sm-12">
							<div id="showRental" class="chzn-container chzn-container-single chzn-container-single-nosearch">
								<a class="chzn-single" tabindex="-1" href="javascript:void(0);">
									<span>{{ __('messages.rentalperiod') }}</span>
									<div><b></b></div>
								</a>

								<div class="chzn-drop rental" style="left: 0px; position: relative; z-index: 1009;display:none;">
									<ul class="chzn-results dd_ul">
										@foreach($objRentalPeriod as $rentalPeriod)
											<li class="dd_li">
									            <label>
									              <input type="checkbox" value="{{ $rentalPeriod->id }}" name="rental[{{ $rentalPeriod->id }}]" {{ (array_key_exists($rentalPeriod->id,$arrOfRental))?"checked='checked'":"" }}> {{ __('messages.rental_period_'.$rentalPeriod->id) }}
									            </label>
								            </li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>

						<div class="col-sm-12">
							<div id="showOther" class="chzn-container chzn-container-single chzn-container-single-nosearch">
								<a class="chzn-single" tabindex="-1" href="javascript:void(0);">
									<span>{{ __('messages.otheroptions') }}</span>
									<div><b></b></div>
								</a>
								<div id="showOtherList" class="chzn-drop other" style="left: 0px; position: relative; z-index: 1009; display: none;">
									<ul class="chzn-results dd_ul">
										<li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="pets" {{ ($pets==1)?"checked='checked'":"" }}> {{ __('messages.pets') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="furnished" {{ ($furnished==1)?"checked='checked'":"" }}> {{ __('messages.furnished') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="businesscontract" {{ ($businessContract==1)?"checked='checked'":"" }}> {{ __('messages.businessContract') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="garage" {{ ($garage==1)?"checked='checked'":"" }}> {{ __('messages.garage') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="balcony" {{ ($balcony==1)?"checked='checked'":"" }}> {{ __('messages.balconyOnly') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="lift" {{ ($lift==1)?"checked='checked'":"" }}> {{ __('messages.liftOnly') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="garden" {{ ($garden==1)?"checked='checked'":"" }}> {{ __('messages.gardenOnly') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="senior" {{ ($senior==1)?"checked='checked'":"" }}> {{ __('messages.seniorFriendly') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="youth" {{ ($youth==1)?"checked='checked'":"" }}> {{ __('messages.youthFriendly') }}
								            </label>
							            </li>

							            <li class="dd_li">
								            <label>
								              <input type="checkbox" value="1" name="handicap" {{ ($handicap==1)?"checked='checked'":"" }}> {{ __('messages.handicapFriendly') }}
								            </label>
							            </li>
									</ul>
								</div>
							</div>
						</div>

						<p>&nbsp;</p>
						<p class="center">
							<input type="submit" id="refineSubmitBtn" name="refineSubmit" class="btn btn-default-color newbtndsg"  value="{{ __('messages.search') }}" />
						</p>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{

	//-------------------------------------
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
	    $( "#txtKeywords" ).catcomplete({
			delay: 0,
			source: "{{ route('home.auto_search') }}",
			select: function (event, ui) {
				//alert(ui.item.searchBy);
				$("#code").val(ui.item.code);
				$(this).val(ui.item.label);
			}
		});
	//-------------------------------------


	$('#mc-embedded-subscribe-form').submit(function (event)
	{   if ( event ) event.preventDefault();
	    var $form = $(this);
	    if ( $form.length > 0 ) { register($form); }
    });

	/*$("#txtKeywords").autocomplete({
        url: 'auto_suggest_keywords.php',
        //extraParams : {'action': $("#proAction").val()},
        useCache: false,
        filterResults: false
    });*/

	$("#showArea").click(function() {
		$(".area").toggle();
	});

	/*$(".chkForArea").click(function() {
		$("#txtKeywords").val("{{ __('messages.lbl_all_properties') }}");
	});*/

	$("#showType").click(function() {
		$(".type").toggle();
	});

	$("#showRental").click(function() {
		$(".rental").toggle();
	});

	$("#showOther").click(function() {
		$(".other").toggle();
	});

	$('#cmb_sort_by').on('change', function(evt, params) {
		var sby = $('#cmb_sort_by').val();
		$('#sortby').val(sby);
		sidebarProcess();
	});

	$(".chosen_no_search_bar").chosen({
		disable_search:true
	});

	$("#cmb_sort_by").change(function(){
		$("#sidebarForm").submit();
	});

	$(".pagination1").click(function(){
		var getPage = $(this).attr('data-page');
		$("#page").val(getPage);
		$("#sidebarForm").submit();
	});

});

function sidebarProcess()
{
	$("#refineSubmitBtn").trigger('click');
}

/*function changeSortBy()
{
	var sby = $('#cmb_sort_by').val();
	$('#sortby').val(sby);
	sidebarProcess();
}*/

function changeSortOrder(order)
{
	$('#sortorder').val(order);
	$("#sidebarForm").submit();
}

function search()
{
	$("#sidebarForm").submit();
}
</script>
@endsection
