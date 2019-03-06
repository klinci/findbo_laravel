@extends('layout.index')

@section('pageTitle', __('messages.title_map_vising'))

@section('content')

<?php 
$arrayLatitude = array();
$arrayLongitude = array();
$thumbArray = array();
$nameArray = array();
$descArray = array();
$idArray = array();
$priceArray = array();
$sizeArray = array();
$isRentArray = array();
$typeArray = array();
$roomsArray = array();
$addressArray = array();
$cityArray = array();

if(!empty($result) && count($result)>0)
{
	foreach($result as $row)
	{
		if((!empty($row->headline_dk) || !empty($row->headline_eng)) && (!empty($row->location1)) && (!empty($row->location2)))
		{
			$latitude		= $row->location1;
			$longitude		= $row->location2;
			
			if(file_exists($row->thumbnail) && $row->thumbnail!="")
			{
				$thumbnail		= url(strip_tags($row->thumbnail));
			}
			else
			{
				$thumbnail = asset('public/images/ikke_navngivet_thumb.png');
			}
			
			
			if(empty($row->headline_dk))
				$name			= $row->headline_eng;
			else
				$name			= $row->headline_dk;
			
			
			if(empty($row->description_dk))
				$description = $row->description_eng;
			else
				$description = $row->description_dk;
			
			$words = explode(" ",$description);
			$description = implode(" ",array_splice($words,0,12));
			
			//$description = limit_words($description, 12);
			$description = "$description...";
			
			$idjs			= $row->id;
			$price			= $row->price;
			$size			= $row->size;
			$isRent			= $row->action;
			$propertyType	= $row->type;
			$rooms			= $row->rooms;
			$address			= $row->address;
			$city_name		= $row->city_name;
			
			array_push($arrayLatitude, $latitude);
			array_push($arrayLongitude, $longitude);
			array_push($thumbArray, $thumbnail);
			array_push($nameArray, $name);
			array_push($descArray, $description);
			array_push($idArray, $idjs);
			array_push($priceArray, $price);
			array_push($sizeArray, $size);
			array_push($isRentArray, $isRent);
			array_push($typeArray, $propertyType);
			array_push($roomsArray, $rooms);
			array_push($addressArray, $address);
			array_push($cityArray, $city_name);
			
		}
	}
}

$nameString		= implode("###", $nameArray);
$thumbString		= implode(",", $thumbArray);
$descString		= implode("###", $descArray);
$idString			= implode(",", $idArray);
$priceString		= implode("###", $priceArray);
$sizeString		= implode(",", $sizeArray);
$rateString		= implode(",", $isRentArray);
$typeString		= implode(",", $typeArray);
$roomsString		= implode(",", $roomsArray);
$addressString	= implode("###", $addressArray);
$cityString		= implode("###", $cityArray);
	
$propadd=__('messages.addresstooltip');
$proptype=__('messages.propertytype');
$proprooms=__('messages.roomsnrtooltip');
$propdeposit=__('messages.deposittooltip');
$propenergy=__('messages.energytooltip');
$proprental=__('messages.rentalperiod');
$propbrutto=__('messages.bruttotooltip');
$postrooms=__('messages.postrooms');
$postmonths=__('messages.months');
?>


<div id="home-map">
	<div id="properties_map"></div>
	<div id="map-property-filter">
			<div class="container">
				<div class="row">
				
					<div class="col-sm-12" style="margin-bottom: 80px;">
						<i id="filter-close" class="fa fa-minus"></i>
						<form action="{{ url('map') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="code" id="code" value="{{ $code }}" />
							<div class="form-group">
								<div class="form-control-large">
									<input type="text" id="txtKeywords" name="keywords" class="form-control" value="{{ ($keyword != 'all' )?$keyword:'' }}" placeholder="{{ __('messages.msg_homepage_2') }}">
								</div>
								
								<div class="form-control-small">
									<select id="search_prop_type" name="type[]" class="chosen_no_search_bar" data-placeholder="Min. Rooms">
										<option value="">{{ __('messages.propertyType') }}</option>
										@if(!empty($objPropertiesType) && count($objPropertiesType)>0)
											@foreach($objPropertiesType as $propertyType)
												@if(Lang::has('messages.title_'.strtolower($propertyType->type)))
													<option value="{{ $propertyType->type }}">{{ __('messages.title_'.strtolower($propertyType->type)) }}</option>
												@endif
											@endforeach
										@endif
									</select>
									
								</div>
								
								<div class="form-control-small">
									<select id="search_minrooms" name="minRooms" class="chosen_no_search_bar" data-placeholder="Min. Rooms">
										<option value="">{{ __('messages.lbl_search_min_rooms') }}</option>
										<option value="1" {{ ($minrooms==1)?"selected='selected'":"" }}>1 {{ __('messages.lbl_room') }}</option>
										<option value="2" {{ ($minrooms==2)?"selected='selected'":"" }}>2 {{ __('messages.lbl_rooms') }}</option>
										<option value="3" {{ ($minrooms==3)?"selected='selected'":"" }}>3 {{ __('messages.lbl_rooms') }}</option>
										<option value="4" {{ ($minrooms==4)?"selected='selected'":"" }}>4 {{ __('messages.lbl_rooms') }}</option>
										<option value="5" {{ ($minrooms==5)?"selected='selected'":"" }}>5 {{ __('messages.lbl_rooms') }}</option>
									</select>
								</div>
								
								<div class="form-control-small">
									<select id="search_maxrooms" name="maxRooms" class="chosen_no_search_bar" data-placeholder="Max. Rooms">
										<option value="">{{ __('messages.lbl_search_max_rooms') }}</option>
										<option value="1" {{ ($getMaxRooms==1)?"selected='selected'":"" }}>1 {{ __('messages.lbl_room') }}</option>
										<option value="2" {{ ($getMaxRooms==2)?"selected='selected'":"" }}>2 {{ __('messages.lbl_rooms') }}</option>
										<option value="3" {{ ($getMaxRooms==3)?"selected='selected'":"" }}>3 {{ __('messages.lbl_rooms') }}</option>
										<option value="4" {{ ($getMaxRooms==4)?"selected='selected'":"" }}>4 {{ __('messages.lbl_rooms') }}</option>
										<option value="5" {{ ($getMaxRooms==5)?"selected='selected'":"" }}>5 {{ __('messages.lbl_rooms') }}</option>
									</select>
								</div>
								
								<div class="form-control-small">
									<select id="search_minarea" name="minArea" class="chosen_no_search_bar" data-placeholder="Min. Area">
										<option value="">{{ __('messages.lbl_min_size') }}</option>
										@foreach($areaRange as $key=>$value)
											<option value="{{ $value }}" {{ ($minarea==$value)?"selected='selected'":"" }}>{{ $value}} m2</option>
										@endforeach
									</select>
								</div>
								
								<div class="form-control-small">
									<select id="search_maxarea" name="maxArea" class="chosen_no_search_bar" data-placeholder="Max. Area">
										<option value="">{{ __('messages.lbl_max_size') }}</option>
										@foreach($areaRange as $key=>$value)
											<option value="{{ $value }}" {{ ($maxarea==$value)?"selected='selected'":"" }}>{{ $value }} m2</option>
										@endforeach
									</select>
								</div>
								
								<div class="form-control-small">
									<select id="search_minprice" name="minPrice" class="chosen_no_search_bar" data-placeholder="Min. Price">
										<option value="">{{ __('messages.lbl_min_price') }}</option>
										@foreach($priceRange as $key=>$value)
											<option value="{{ $value }}" {{ ($minprice==$value)?"selected='selected'":"" }}>DKK {{ number_format($value,0,',','.') }}</option>
										@endforeach
									</select>
								</div>
								
								<div class="form-control-small">
									<select id="search_maxprice" name="maxPrice" class="chosen_no_search_bar" data-placeholder="Max. Price">
										<option value="">{{ __('messages.lbl_max_price') }}</option>
										@foreach($priceRange as $key=>$value)
											<option value="{{ $value }}" {{ ($maxprice==$value)?"selected='selected'":"" }}>DKK {{ number_format($value,0,',','.') }}</option>
										@endforeach
									</select>
								</div>
								
								<input type="submit" id="refineSubmitBtn" name="refineSubmit" class="btn btn-fullcolor"  value="{{ __('messages.search') }}" />
								
								<a href="{{ url('property') }}" class="btn btn-fullcolor" >{{ __('messages.listview') }}</a>
								
							</div>
						</form>
						
					</div>	
		
				</div>
			</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/js/markerclusterer.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

$(document).ready(function(){
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
			source: "{{ url('auto_search') }}",
			select: function (event, ui) { 
				//alert(ui.item.searchBy); 
				$("#code").val(ui.item.code);
				$(this).val(ui.item.label);
			}
		});
	//-------------------------------------
});

	var latitude = [];
    var longitude = [];
    var nameArray = [];
    var thumbnailArray = [];
    var descArray = [];
    var idArray = [];
    var priceArray = [];
	var sizeArray = [];
	var isRentArray = [];
	var typeArray = [];
	var roomsArray = [];
	var addressArray = [];
	var cityName = [];
	
    latitude = <?php echo json_encode($arrayLatitude); ?>;
    longitude = <?php echo json_encode($arrayLongitude); ?>;
    var name = <?php echo json_encode($nameString); ?>;
    var thumbnail = <?php echo json_encode($thumbString); ?>;
    var desc = <?php echo json_encode($descString); ?>;
    var id = <?php echo json_encode($idString); ?>;
    var price = <?php echo json_encode($priceString); ?>;
    var size = <?php echo json_encode($sizeString); ?>;
	var ptype = <?php echo json_encode($typeString); ?>;
	var prooms = <?php echo json_encode($roomsString); ?>;
	var isRent = <?php echo json_encode($rateString); ?>;
	var address = <?php echo json_encode($addressString); ?>;
	var cityName = <?php echo json_encode($cityString); ?>;

	nameArray = name.split("###");
    thumbnailArray = thumbnail.split(",");
    descArray = desc.split("###");
    idArray = id.split(",");
    priceArray = price.split("###");
    sizeArray = size.split(",");
    isRentArray = isRent.split(",");
    ptypeArray 	  = ptype.split(",");
    proomsArray   =	prooms.split(",");
    paddress = address.split("###");
    pCityName = cityName.split("###");
    
    var noProperty = false;
    
    var properties = [];
    if(latitude.length > 0)
    {
        for (var i = 0; i < latitude.length; i++) 
	    {
    	    if(i == 0)
    	    {    
		    	var properties_mapInitialLatitude = latitude[i],					        //Properties map initial Latitude
		    		properties_mapInitialLongitude = longitude[i];
    	    }
	    	properties.push({
					    		"id": idArray[i],
					    		"title": nameArray[i],
					    		"latitude":latitude[i],
					    		"longitude":longitude[i],
					    		"image":thumbnailArray[i],
					    		"description":descArray[i],
					    		"link":'{{ url("property_detail") }}/'+idArray[i],
					    		"map_marker_icon":"{{ asset('public/images/markers/green-marker-residential.png') }}"
					    	});
	    }
    }
    else
    {
    	noProperty = true;        
    	var properties_mapInitialLatitude = 55.67629038914166;
      	var properties_mapInitialLongitude = 12.568422930688484;
    }
    
		(function($){
			"use strict";
			
			$(document).ready(function(){
				//Create porperties map
				
				if($('#c_zoom').length > 0)
				{ Cozy.properties_initialZoom = parseInt($('#c_zoom').val()); }
					
				Cozy.propertiesMap(properties, 'properties_map');
				//alert(Cozy.properties_initialZoom);
				$("#txtKeywords").autocomplete({
			        url: 'auto_suggest_keywords.php',
			        //extraParams : {'action': $("#proAction").val()},
			        useCache: false,
			        filterResults: false
			    });

				$('#mc-embedded-subscribe-form').submit(function (event)
				{   if ( event ) event.preventDefault();
				    var $form = $(this);
				    if ( $form.length > 0 ) { register($form); }
			    });

			    if(noProperty)
			    {	setTimeout(function(){alert('No Properties Found')}, 3000); }    
			});
		})(jQuery);

		function register($form)
		{
		    $.ajax({
			        type		: "GET",
			        url			: $form.attr('action'),
			        data		: $form.serialize(),
			        cache       : false,
			        async 		: false,
			        dataType    : 'json',
			        contentType	: "application/json; charset=utf-8",
			        error       : function(err) { alert("{{ __('messages.registration_msg_1') }}"); },
		        	success     : function(data)
		        				  {
	            						if(data.result != "success")
		            					{
			            					var subscribe_msg = '';
			            					subscribe_msg += '<div class="alert alert-danger alert-dismissable" style="margin-top: 10px">';
			            					subscribe_msg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">'+'&times;'+'</button>';
			            					subscribe_msg += "{{ __('messages.error_msg_1') }}! ";
			            					subscribe_msg += '</div>';
			            					 
								        	$("#subscribe_msg_box").html(subscribe_msg);
								        } else {
								        	var subscribe_msg = '';

								        	subscribe_msg += '<div class="alert alert-success alert-dismissable" style="margin-top: 10px">';
								        	subscribe_msg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">'+'&times;'+'</button>';
								        	subscribe_msg += '<strong>{{ __("messages.thankyou") }}! </strong>';
			            					subscribe_msg += '{{ __("messages.successfully_subscribed_msg") }}! ';
			            					subscribe_msg += '</div>';

								        	$("#subscribe_msg_box").html(subscribe_msg);
										};
		        				}
		    });
		}
	</script>
@endsection