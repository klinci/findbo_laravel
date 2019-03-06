@extends('layout.index')

@section('pageTitle', 'Opret annonce')

@section('content')
<link href="{{ asset('public/css/datepickr.css') }}" rel="stylesheet" type="text/css" />

<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.postlisting') }}</h1>
				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home') }} </a></li>
					<li>{{ __('messages.post_ad') }}</li>
				</ul>
					
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
			<div class="main col-sm-12 mainpbt">
			
				<form action="{{ url('update_property') }}" method="POST" class="" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ $objProperty->id }}" />
					<ul class="nav nav-tabs tabcostum" role="tablist" style="margin:10px 0;">
						<li class="rentt active">
							<a href="#rent" role="tab" data-toggle="tab">
								<b>{{ __('messages.rentPdetails') }}</b>
								<label><input type="radio" id="radio_1" name="action" value="rent" checked style="visibility: hidden;" /></label>
							</a>
						</li>
						<li class="buyy" style="display: none;">
							<a href="#sell" role="tab" data-toggle="tab">
								<b>{{ __('messages.sellPdetails') }}</b>
								<label><input type="radio" id="radio_2" name="action" value="buy" style="visibility: hidden;" /></label>
							</a>
						</li>
					  
					</ul>
					
					<div class="panel panel-default">
						
						<div class="panel-heading">
							<h3 class="panel-title">
								<a class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ __('messages.adDetails') }}</a>
							</h3>
						</div>
						
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
								
								<div class="row">
									<div class="col-sm-12 green">
										<div style="padding-bottom:20px; font-size:20px;"> 
											{{ __('messages.danishvers') }} 
										</div> 
									</div>
									
									<div class="col-md-3">
										<label><strong>{{ __('messages.postHeadline') }}: *</strong></label>
									</div> 
									
									<div class="col-md-8">
										<input class="form-control adform" type="text" name="headline_dk" value="{{ $objProperty->headline_dk }}" required>
									</div>
									
									<div class="col-md-3">
										<label><strong>{{ __('messages.bodyText') }}: *</strong></label>
									</div>
									
									<div class="col-md-8">
										<textarea class="areatxt form-control" rows="3" name="text_dk" id="texta" required>{{ $objProperty->description_dk }}</textarea>
										<p>{{ __('messages.hundredminchars') }}</p>
										<span class="dd_li">
											<label for="typevrs">
												<input class="showenglish" englishversion="" type="checkbox" id="typevrs" value="" />
												{{ __('messages.lbl_type_eng_ver') }}
											</label>
										</span>
									</div>
						
								</div>
								
								<div class="row englishversion" style="display:none;">
									<div class="col-sm-12 green"> 
										<div style="padding-bottom:20px; font-size:20px;">
											{{ __('messages.enversion') }} 
										</div> 
									</div>
									
									<div class="col-md-3">
										<label><strong>{{ __('messages.postHeadline') }}:</strong></label>
									</div>
									
									<div class="col-md-8">
										<input class="form-control adform" type="text" name="headline_eng" value="{{ $objProperty->headline_eng }}" maxlength="50">
									</div>
									
									<div class="col-md-3">
										<label><strong>{{ __('messages.bodyText') }}: </strong></label>
									</div>
									
									<div class="col-md-8">
										<textarea class="areatxt form-control" rows="3" name="text_eng" id="texta">{{ $objProperty->description_eng }}</textarea>
										<p>{{ __('messages.hundredminchars') }}</p>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">{{ __('messages.locationDetails') }}</a></h3>
						</div>
						
						<div id="collapseTwo" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postAreas') }} *</strong></label>
									</div>
									
									<div class="col-md-3">
										<select class="form-control adform area" name="areas" id="area" required>
											<option value=""> {{ __('messages.postAreas') }}</option>
											@if(!empty($objArea) && count($objArea)>0)
												@foreach($objArea as $area)
													<option value="{{ $area->id }}" {{ ($objProperty->area_id==$area->id)?'selected="selected"':'' }}>{{ $area->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-6"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postCity') }}: *</strong></label>
									</div>
									<div class="col-md-3">
										<select name="city" id="cityListHandler" class="form-control adform" required>
											<option selected="selected">{{ __('messages.selectCity') }}</option>
											@if(!empty($objZipCode) && count($objZipCode)>0)
												@foreach($objZipCode as $zipcode)
													<option value="{{ $zipcode->id }}" {{ ($objProperty->zip_code_id==$zipcode->id)?'selected="selected"':'' }}>{{ $zipcode->city_name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-6"></div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postAddress') }}: *</strong></label>
									</div>
									<div class="col-md-7">
										<input id="address" placeholder="{{ __('messages.lbl_enter_address') }}" class="form-control adform" type="text" name="address" value="{{ $objProperty->address }}" required>
										<!-- <input id="autocomplete" onFocus="geolocate()" placeholder="{{ __('messages.lbl_enter_address') }}" class="form-control adform" type="text" name="address" required>
										<input placeholder="{{ __('messages.lbl_enter_address') }}" class="form-control adform" type="text" name="address" required>  -->
									</div>
									<div class="col-sm-2"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.houseNr') }}: *</strong></label>
									</div>
									<div class="col-md-3">
										<input class="form-control adform" type="text" name="housenum" value="{{ $objProperty->housenum }}" required>
									</div>
									<div class="col-md-4" style="padding-top:9px; padding-left: 0px;">
										<strong>{{ __('messages.houseMsg') }}</strong>
									</div>
									<div class="col-sm-2"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postFloorSide') }}:</strong></label>
									</div>
									<div class="col-md-3">
										<select class="form-control adform" name="position" id="floorselect">
											<option value="kld" {{ ($objProperty->floor=="kld")?'selected="selected"':'' }}>kld</option>
							                <option value="kld tv" {{ ($objProperty->floor=="kld tv")?'selected="selected"':'' }}>kld tv</option>
							                <option value="kld mf" {{ ($objProperty->floor=="kld mf")?'selected="selected"':'' }}>kld mf</option>
							                <option value="kld th" {{ ($objProperty->floor=="kld th")?'selected="selected"':'' }}>kld th</option>
							                <option value="Stuen" {{ ($objProperty->floor=="Stuen")?'selected="selected"':'' }}>Stuen</option>
							                <option value="st tv" {{ ($objProperty->floor=="st tv")?'selected="selected"':'' }}>st tv</option>
							                <option value="st mf" {{ ($objProperty->floor=="st mf")?'selected="selected"':'' }}>st mf</option>
							                <option value="st th" {{ ($objProperty->floor=="st th")?'selected="selected"':'' }}>st th</option>
							                 <?php
						                	for($floorIndex = 1; $floorIndex<=16; $floorIndex++)
						                	{
						                		?>
						                		<option value="{{ $floorIndex }}. sal" {{ ($objProperty->floor==$floorIndex.". sal")?'selected="selected"':'' }}>{{ $floorIndex }}. sal</option>
						                		<option value="{{ $floorIndex }}. tv" {{ ($objProperty->floor==$floorIndex.". tv")?'selected="selected"':'' }}>{{ $floorIndex }}. tv</option>
						                		<option value="{{ $floorIndex }}. mf" {{ ($objProperty->floor==$floorIndex.". mf")?'selected="selected"':'' }}>{{ $floorIndex }}. mf</option>
						                		<option value="{{ $floorIndex }}. th" {{ ($objProperty->floor==$floorIndex.". th")?'selected="selected"':'' }}>{{ $floorIndex }}. th</option>
						                		<?php 
						                	}
						                	?>
										</select>
									</div>
									<div class="col-md-4" style="visibility: hidden;">
										<input class="form-control adf9orm" type="text" name="floor" id="floortxt" value="{{ $objProperty->floor }}" />
									</div>
									<div class="col-sm-2"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<br>
										<div class="col-sm-6" style="padding: 0px !important; padding-right:5px !important;">
											<input type="hidden" name="location1" class="form-control adform" id="latitude" placeholder="{{ __('messages.latitude') }}" value="{{ $objProperty->latitude }}" required >
										</div>
										<div class="col-sm-6" style="padding: 0px !important; padding-left:5px !important;">
											<input type="hidden" name="location2" class="form-control adform" id="longitude" placeholder="{{ __('messages.longitude') }}" value="{{ $objProperty->longitude }}" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a class="panel-heading accordion-toggle "  data-toggle="collapse" data-parent="#accordion" href="#collapseThree">{{ __('messages.leaseDetails') }}</a></h3>
						</div>
						<div id="collapseThree" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postVacant') }}*:</strong></label>
									</div>
									<div class="col-md-3">
										<label for="handlerImmediately">
											<input type="radio" onclick="javascript:setVacantOption('immediately');" name="vacant" id="handlerImmediately" value="immediately" {{ ($objProperty->vacant=='immediately')?'checked="checked"':'' }}> {{ __('messages.immediately') }}
										</label>
										
										<label for="handlerAppointment">
											<input onclick="javascript:setVacantOption('appointment');" type="radio" name="vacant" style="margin-top:4px;" id="handlerAppointment" value="appointment" {{ ($objProperty->vacant=='appointment')?'checked="checked"':'' }}> {{ __('messages.postAppoinment') }}
										</label>
										
										<label for="handlerDate">
											<input onclick="javascript:setVacantOption('date');" type="radio" name="vacant" id="handlerDate" value="date" {{ ($objProperty->vacant=='date')?'checked="checked"':'' }}> {{ __('messages.lbl_date') }}
										</label>
										
										<div id="datepickDiv" style="{{ ($objProperty->vacant=='date')?'':'display: none;' }}">
											<input id="datepick" style="width: 236px;" size="50" name="vacantDate" class="form-control" value="{{ date('M d,Y',strtotime($objProperty->vacantDate)) }}" {{ ($objProperty->vacant=='date')?'required':'' }} />
										</div>
										<br/>
									</div>
									<div class="col-md-3"></div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.propertyType') }}: *</strong></label>
									</div>
									<div class="col-md-3">
										<select class="form-control adform" name="type" required>
											<option value="Room" {{ ($objProperty->type=='Room')?'selected="selected"':'' }}>{{ __('messages.postroom') }}</option>
											<option value="Apartment" {{ ($objProperty->type=='Apartment')?'selected="selected"':'' }}>{{ __('messages.postapartment') }}</option>
											<option value="House" {{ ($objProperty->type=='House')?'selected="selected"':'' }}>{{ __('messages.posthouse') }}</option>
											<option value="Villa" {{ ($objProperty->type=='Villa')?'selected="selected"':'' }}>{{ __('messages.post_villa') }}</option>
											<option value="Shared" {{ ($objProperty->type=='Shared')?'selected="selected"':'' }}>{{ __('messages.postaccomodation') }}</option>
											<option value="Exchange" {{ ($objProperty->type=='Exchange')?'selected="selected"':'' }}>{{ __('messages.postexchange') }}</option>
											<option value="Holiday" {{ ($objProperty->type=='Holiday')?'selected="selected"':'' }}>{{ __('messages.postholiday') }}</option>
										</select>
										<br/>
									</div>
									<div class="col-sm-6"> </div>
								</div>
								
								<div class="row rental_period_row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.rentalperiod') }}: *</strong></label>
									</div>
									<div class="col-md-3">
										<select id="rental_period_handler" class="form-control adform" name="rentalperiod" required>
											<option value="">{{ __('messages.lbl_choose_renting_period') }}</option>
											@if(!empty($objRentalPeriod) && count($objRentalPeriod)>0)
												@foreach($objRentalPeriod as $rentalPeriod)
													<option value="{{ $rentalPeriod->id }}" {{ ($objProperty->rental_period==$rentalPeriod->id)?'selected="selected"':''}}>{{ __('messages.rental_period_'.$rentalPeriod->id) }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-4"><p></p></div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.areainsqrm') }}: *</strong></label>
									</div>
									<div class="col-md-3" style="padding-bottom: 10px;">
										<div class="input-group">
											<input class="form-control adform" type="text" name="size" value="{{ $objProperty->size }}" required>
											<span class="input-group-addon" style="padding: 8px;">m2</span>
										</div>
									</div>
								</div>
								
								<div class="row ground" style="display:none;">
									<div class="col-md-3">
										<label><strong>{{ __('messags.groundArea') }}: *</strong></label>
									</div>
									<div class="col-md-3" style="padding-bottom: 10px;">
										<div class="input-group">
											<input class="form-control adform" type="text" name="groundarea" value="{{ $objProperty->groundarea }}">
											<span class="input-group-addon" style="padding: 8px;">m2</span>
										</div>
									</div>
									<div class="col-sm-4"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postrooms') }}: *</strong></label>
									</div>
									<div class="col-md-3">
										<input class="form-control adform" type="number" name="rooms" value="{{ $objProperty->rooms }}" id="NewConfirmPassword" required min="1">
									</div>
									<div class="col-sm-4"> </div>
								</div>
								
								<div class="row petsrow">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postpetss') }}:</strong></label>
									</div>
									<div class="col-md-3">
										<select class="form-control adform" name="pets">
											<option value="1" {{ ($objProperty->pets==1)?'selected="selected"':'' }}>{{ __('messages.postallowed') }}</option>
											<option value="2" {{ ($objProperty->pets==2)?'selected="selected"':'' }}>{{ __('messages.postNotallowed') }}</option>
											<option value="3" {{ ($objProperty->pets==3)?'selected="selected"':'' }}>{{ __('messages.postLandlord') }}</option>
										</select>
										<br/>
									</div>
									<div class="col-md-4">
										<input class="form-control adform" type="text" name="petcomment" placeholder="{{ __('messages.possibleComments') }}" value="{{ $objProperty->pets_comment }}" id="">
									</div>
								</div>
								
								<div class="row yearbuild" style="display:none;">
									<div class="col-md-3">
										<label><strong>{{ __('messages.builtyear') }}: </strong></label>
									</div>
									<div class="col-md-3">
										<input class="form-control adform" type="text" name="year" value="{{ $objProperty->year }}">
									</div>
									<div class="col-sm-6"> </div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postFacilities') }}:</strong></label>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkBalcony">
												<input type="checkbox" id="chkBalcony" name="balcony" value="1" {{ $objProperty->balcony == 1 ? 'checked="checked"' : '' }} />
	            								{{ __('messages.postBalcony') }}
											</label>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkGarage">
									            <input englishversion type="checkbox" id="chkGarage" name="garage" value="1" {{ $objProperty->garage == 1 ? 'checked="checked"' : '' }}>
									            {{ __('messages.garage') }}
									        </label>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkLift">
												<input englishversion type="checkbox" id="chkLift" name="lift" value="1" {{ $objProperty->lift == 1 ? 'checked="checked"' : '' }}>
            									{{ __('messages.postlift') }}
											</label>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="dd_li">
											<label for="chkGarden">
												<input englishversion type="checkbox" id="chkGarden" name="garden" value="1" {{ $objProperty->garden == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.postGarden') }}
											</label>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkShareFriendly">
												<input englishversion type="checkbox" id="chkShareFriendly" name="sharefriendly" value="1" {{ $objProperty->shareFriendly == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.shareFriendly') }}
											</label>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkHandicapFriendly">
												<input englishversion type="checkbox" id="chkHandicapFriendly" name="handicapfriendly" value="1" {{ $objProperty->handicapFriendly == 1 ? 'checked="checked"' : '' }}>
	            								{{ __('messages.handicapFriendly') }}
											</label>
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chkYouthHousing">
												<input englishversion type="checkbox" id="chkYouthHousing" name="youthhousing" value="1" {{ $objProperty->youthHousing == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.youthFriendly') }}
											</label>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="dd_li">
											<label for="chkSeniorFriendly">
												<input englishversion type="checkbox" id="chkSeniorFriendly" name="seniorfriendly" value="1" {{ $objProperty->seniorFriendly == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.seniorFriendly') }}
											</label>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chk_furnished">
												<input englishversion type="checkbox" id="chk_furnished" name="furnished" value="1" {{ $objProperty->furnished == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.lbl_furnished') }}
											</label>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chk_basement">
												<input englishversion type="checkbox" id="chk_basement" name="basement" value="1" {{ $objProperty->basement == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.lbl_basement') }}
											</label>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dd_li">
											<label for="chk_entryphone">
												<input englishversion type="checkbox" id="chk_entryphone" name="entryphone" value="1" {{ $objProperty->entry_phone == 1 ? 'checked="checked"' : '' }}>
												{{ __('messages.lbl_entryphone') }}
											</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="dd_li">
											&nbsp;
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<a class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									{{ __('messages.lbl_economy') }}
								</a>
							</h3>
						</div>
						
						<div id="collapseFour" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<label id="postTotal1" ><strong >{{ __('messages.postTotal') }}: *</strong></label>
										<label id="postTotal2" style="display:none;"><strong >{{ __('messages.lbl_price') }}: *</strong></label>
									</div>
									<div class="col-md-3" style="padding-bottom: 10px;">
										<div class="input-group">
											<input class="form-control adform " type="text" name="rent" id="ammount" required placeholder="{{ __('messages.propertyCost') }}" value="{{ $objProperty->price }}" >
											<span class="input-group-addon" style="padding: 8px;">Kr.</span>
										</div>
									</div>
								</div>
								
								<div class="tab-content" style="margin: 0;">
									<div class="tab-pane" id="sell"  style="border: none; padding: 0;">
										<div class="row" style="display: none; padding: 0;">
											<div class="col-md-3">
												<label><strong>{{ __('messages.specifyAmount') }}:</strong></label>
											</div>
											<div class="col-md-3">
												<input class="form-control adform " type="text" name="payment"  placeholder="{{ __('messages.amount') }}" value="{{ $objProperty->payment }}" />
											</div>
											<div class="col-sm-6"> </div>
										</div>
										<div class="row payments">
											<div class="col-md-3">
												<label><strong>{{ __('messages.downpayment') }}: *</strong></label>
											</div>
											<div class="col-md-3" style="padding-bottom: 10px;">
												<div class="input-group">
													<input class="form-control adform" type="text" name="downpayment" id="dpayment" value="{{ $objProperty->downpayment }}" />
													<span class="input-group-addon" style="padding: 8px;">Kr.</span>
												</div>
											</div>
											<div class="col-sm-6"> </div>
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.gross') }}:</strong></label>
											</div>
											<div class="col-md-3" style="padding-bottom: 10px;">
												<div class="input-group">
													<input class="form-control adform" type="text" name="gross" placeholder="{{ __('messages.writenumber') }}" value="{{ $objProperty->gross }}" />
													<span class="input-group-addon" style="padding: 8px;">Kr.</span>
												</div>
											</div>
											<div class="col-sm-6"> </div>
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.net') }}:</strong></label>
											</div>
											<div class="col-md-3" style="padding-bottom: 10px;">
												<div class="input-group">
													<input class="form-control adform" type="text" name="net" placeholder="{{ __('messages.writenumber') }}" value="{{ $objProperty->net }}">
													<span class="input-group-addon" style="padding: 8px;">Kr.</span>
												</div>
											</div>
										</div>
									</div>
									
									
									<div class="tab-pane active" id="rent" style="border: none; padding: 0;">
										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.postDeposit') }}:</strong></label>
											</div>
											
											<div class="col-md-3">
												<select class="form-control adform" name="deposit"  id="deposit">
													<option {{ ($deposit==0)?'selected="selected"':'' }}>{{ __('messages.postchoosee') }}</option>
													<option {{ ($deposit==1)?'selected="selected"':'' }}>{{ __('messages.postonemonth') }}</option>
													<option {{ ($deposit==2)?'selected="selected"':'' }}>{{ __('messages.posttwomonth') }}</option>
													<option {{ ($deposit==3)?'selected="selected"':'' }}>{{ __('messages.postthreemonth') }}</option>
												</select>
											</div>
											
											<div class="col-md-4" style="padding-bottom: 10px;">
												<div class="input-group">
													<input class="form-control adform" type="text" name="depositValue" id="depositValue" placeholder="{{ __('messages.depositValue') }}" value="{{ $depositValue }}" />
				              						<span class="input-group-addon" style="padding: 8px;">Kr.</span>
												</div>
											</div>
											
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.postPrepaid')}} :</strong></label>
											</div>
											<div class="col-md-3">
												<select class="form-control adform" name="prepaid" id="prepaid">
													<option {{ ($prepaid==0)?'selected="selected"':'' }}>{{ __('messages.postchoosee') }}</option>
								                    <option {{ ($prepaid==1)?'selected="selected"':'' }}>{{ __('messages.postonemonth') }}</option>
								                    <option {{ ($prepaid==2)?'selected="selected"':'' }}>{{ __('messages.posttwomonth') }}</option>
								                    <option {{ ($prepaid==3)?'selected="selected"':'' }}>{{ __('messages.postthreemonth') }}</option>
												</select>
											</div>
											<div class="col-md-4" style="padding-bottom: 10px;">
												<div class="input-group">
				              						<input class="form-control adform" type="text" name="prepaidValue" id="prepaidValue" placeholder="" value="{{ $prepaidValue }}">
				              						<span class="input-group-addon" style="padding: 8px;">Kr.</span>
				              					</div>
											</div>
											
										</div>
									</div>
								</div>
								
								<div class="row" style="padding-bottom:5px;">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postfixed') }}:</strong></label>
									</div>
									<div class="col-md-3" style="padding-bottom: 10px;">
										<div class="input-group">
								          	<input class="form-control adform" type="text" name="expenses" placeholder="{{ __('messages.writenumber') }}" value="{{ $objProperty->expenses }}" />
								        	<span class="input-group-addon" style="padding: 8px;">Kr.</span>
										</div>  
									</div>
								</div>
								
								<div class="row" style="padding-bottom:5px;">
									<div class="col-md-3">
										<label><strong>{{ __('messages.lbl_energy_label') }}:</strong></label>
									</div>
									<div class="col-md-3">
										<select class="form-control adform" name="energy">
											<option value="" {{ ($objProperty->energy=='N/A')?'selected="selected"':'' }}>N/A</option>
											<option value="A" {{ ($objProperty->energy=='A')?'selected="selected"':'' }}>A</option>
											<option value="B" {{ ($objProperty->energy=='B')?'selected="selected"':'' }}>B</option>
											<option value="C" {{ ($objProperty->energy=='C')?'selected="selected"':'' }}>C</option>
											<option value="D" {{ ($objProperty->energy=='D')?'selected="selected"':'' }}>D</option>
											<option value="E" {{ ($objProperty->energy=='E')?'selected="selected"':'' }}>E</option>
											<option value="F" {{ ($objProperty->energy=='F')?'selected="selected"':'' }}>F</option>
											<option value="G" {{ ($objProperty->energy=='G')?'selected="selected"':'' }}>G</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<a class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFifth">
									{{ __('messages.postContactinfo') }}
								</a>
							</h3>
						</div>
						
						<div id="collapseFifth" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.lbl_name') }}: </strong></label>
									</div>
									<div class="col-md-2">
										<input class="form-control adform" type="text" name="company_name" placeholder="" value="{{ $objProperty->company_name }}" />
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.postphone') }}: *</strong></label>
									</div>
									<div class="col-md-6">
										<input class="form-control adform" type="text" name="phonenum1" id="" value="{{ $objProperty->phonenum1 }}" placeholder="{{ __('messaages.county').' '.__('messages.actualphone') }}" value="{{ $objProperty->phonenum1 }}" />
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.emaill') }}: *</strong></label>
									</div>
									
									<div class="col-md-6">
										<input class="form-control adform" type="email" name="emailadd" placeholder="{{ __('messages.enteremail') }}" required value="{{ $objProperty->email }}" />
									</div>
								</div>
								
								<?php /*<div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.lbl_case_number') }}:</strong></label>
									</div>
									<div class="col-md-6">
										<input class="form-control adform" type="text" name="sagsnummer" id="NewConfirmPassword" placeholder="" />
									</div>
								</div>*/ ?>
								
								<!-- <div class="row">
									<div class="col-md-3">
										<label><strong>{{ __('messages.url') }}: </strong></label>
									</div>
									
									<div class="col-md-6">
										<input class="form-control adform" type="text" name="txtURL" id="txtURL" placeholder="{{ __('messages.url') }}">
									</div>
								</div>  -->
								
								<div class="secondphone" style="display: none">
									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.emaill') }} 2:</strong></label>
										</div>
										<div class="col-md-6">
											<input class="form-control adform" type="email" name="emailadd2" id="NewConfirmPassword" placeholder="{{ __('messages.enteremail') }}" value="{{ ($objProperty->email2!= 'Not specified')?$objProperty->email2:'' }}" />
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.postphone') }} 2: *</strong></label>
										</div>
										<!-- <div class="col-md-2">
											<input class="form-control adform" type="text" name="country2" id="NewConfirmPassword" placeholder="{{ __('messages.county') }}" maxlength="5">
										</div>  -->
										<div class="col-md-6">
											<input class="form-control adform" type="text" name="number2" id="" placeholder="{{ __('messages.actualphone') }}" value="{{ $objProperty->phonenum2 }}" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a class="panel-heading accordion-toggle "  data-toggle="collapse" data-parent="#accordion" href="#collapseSix">{{ __('messages.postOpenHouse') }}</a></h3>
						</div>
						
						<div id="collapseSix" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<div class="dd_li">
											<input englishversion class="showOpenhouse" type="checkbox" id="englishversion" name="businessContract" value="1" {{ ($objProperty->business_contract==1)?'checked="checked"':'' }}>
											<label for="englishversion"  >{{ __('messages.postContractB') }}</label>
										</div>
									</div>
								</div>
								<br>
								
								<div class="openHousetoggle" {{ ($objProperty->business_contract!=1)?'style="display:none;"':'' }}>
									<div class="row">
										<div class="col-sm-3">
											<label><strong>{{ __('messages.lbl_time') }}: </strong></label>
										</div>
										
										<div class="col-sm-3">
											<div>
												<input id="datepick2" size="50" name="openHouseDate" class="form-control" value="{{ (strtotime($objProperty->openHouseDate)>0)?date('M dS,Y',strtotime($objProperty->openHouseDate)):'' }}" />
											</div>
										</div>
										
										<span style="float:left;padding-top:5px;">{{ __('messages.between') }}</span>
										<div class="col-sm-2">
											<select id="OpenHouseStartTime" class="form-control adform" name="openHouseStartTime">
										 		<option value="08:00" {{ ($objProperty->openHouseStartTime=='08:00'?'selected="selected"':'') }}>08:00</option>
												<option value="08:30" {{ ($objProperty->openHouseStartTime=='08:30'?'selected="selected"':'') }}>08:30</option>
												<option value="09:00" {{ ($objProperty->openHouseStartTime=='09:00'?'selected="selected"':'') }}>09:00</option>
												<option value="09:30" {{ ($objProperty->openHouseStartTime=='09:30'?'selected="selected"':'') }}>09:30</option>
												<option value="10:00" {{ ($objProperty->openHouseStartTime=='10:00'?'selected="selected"':'') }}>10:00</option>
												<option value="10:30" {{ ($objProperty->openHouseStartTime=='10:30'?'selected="selected"':'') }}>10:30</option>
												<option value="11:00" {{ ($objProperty->openHouseStartTime=='11:00'?'selected="selected"':'') }}>11:00</option>
												<option value="11:30" {{ ($objProperty->openHouseStartTime=='11:30'?'selected="selected"':'') }}>11:30</option>
												<option value="12:00" {{ ($objProperty->openHouseStartTime=='12:00'?'selected="selected"':'') }}>12:00</option>
												<option value="12:30" {{ ($objProperty->openHouseStartTime=='12:30'?'selected="selected"':'') }}>12:30</option>
												<option value="13:00" {{ ($objProperty->openHouseStartTime=='13:00'?'selected="selected"':'') }}>13:00</option>
												<option value="13:30" {{ ($objProperty->openHouseStartTime=='13:30'?'selected="selected"':'') }}>13:30</option>
												<option value="14:00" {{ ($objProperty->openHouseStartTime=='14:00'?'selected="selected"':'') }}>14:00</option>
												<option value="14:30" {{ ($objProperty->openHouseStartTime=='14:30'?'selected="selected"':'') }}>14:30</option>
												<option value="15:00" {{ ($objProperty->openHouseStartTime=='15:00'?'selected="selected"':'') }}>15:00</option>
												<option value="15:30" {{ ($objProperty->openHouseStartTime=='15:30'?'selected="selected"':'') }}>15:30</option>
												<option value="16:00" {{ ($objProperty->openHouseStartTime=='16:00'?'selected="selected"':'') }}>16:00</option>
												<option value="16:30" {{ ($objProperty->openHouseStartTime=='16:30'?'selected="selected"':'') }}>16:30</option>
												<option value="17:00" {{ ($objProperty->openHouseStartTime=='17:00'?'selected="selected"':'') }}>17:00</option>
												<option value="17:30" {{ ($objProperty->openHouseStartTime=='17:30'?'selected="selected"':'') }}>17:30</option>
												<option value="18:00" {{ ($objProperty->openHouseStartTime=='18:00'?'selected="selected"':'') }}>18:00</option>
												<option value="18:30" {{ ($objProperty->openHouseStartTime=='18:30'?'selected="selected"':'') }}>18:30</option>
												<option value="19:00" {{ ($objProperty->openHouseStartTime=='19:00'?'selected="selected"':'') }}>19:00</option>
												<option value="19:30" {{ ($objProperty->openHouseStartTime=='19:30'?'selected="selected"':'') }}>19:30</option>
												<option value="20:00" {{ ($objProperty->openHouseStartTime=='20:00'?'selected="selected"':'') }}>20:00</option>
												<option value="20:30" {{ ($objProperty->openHouseStartTime=='20:30'?'selected="selected"':'') }}>20:30</option>
												<option value="21:00" {{ ($objProperty->openHouseStartTime=='21:00'?'selected="selected"':'') }}>21:00</option>
												<option value="21:30" {{ ($objProperty->openHouseStartTime=='21:30'?'selected="selected"':'') }}>21:30</option>
												<option value="22:00" {{ ($objProperty->openHouseStartTime=='22:00'?'selected="selected"':'') }}>22:00</option>
											</select>
										</div>
										
										<span style="float:left;padding-top:5px;">{{ __('messages.and') }}</span>
										<div class="col-sm-2">
											<select id="OpenHouseEndTime" class="form-control adform" name="openHouseEndTime">
												<option value="08:00" {{ ($objProperty->openHouseEndTime=='08:00'?'selected="selected"':'') }}>08:00</option>
												<option value="08:30" {{ ($objProperty->openHouseEndTime=='08:30'?'selected="selected"':'') }}>08:30</option>
												<option value="09:00" {{ ($objProperty->openHouseEndTime=='09:00'?'selected="selected"':'') }}>09:00</option>
												<option value="09:30" {{ ($objProperty->openHouseEndTime=='09:30'?'selected="selected"':'') }}>09:30</option>
												<option value="10:00" {{ ($objProperty->openHouseEndTime=='10:00'?'selected="selected"':'') }}>10:00</option>
												<option value="10:30" {{ ($objProperty->openHouseEndTime=='10:30'?'selected="selected"':'') }}>10:30</option>
												<option value="11:00" {{ ($objProperty->openHouseEndTime=='11:00'?'selected="selected"':'') }}>11:00</option>
												<option value="11:30" {{ ($objProperty->openHouseEndTime=='11:30'?'selected="selected"':'') }}>11:30</option>
												<option value="12:00" {{ ($objProperty->openHouseEndTime=='12:00'?'selected="selected"':'') }}>12:00</option>
												<option value="12:30" {{ ($objProperty->openHouseEndTime=='12:30'?'selected="selected"':'') }}>12:30</option>
												<option value="13:00" {{ ($objProperty->openHouseEndTime=='13:00'?'selected="selected"':'') }}>13:00</option>
												<option value="13:30" {{ ($objProperty->openHouseEndTime=='13:30'?'selected="selected"':'') }}>13:30</option>
												<option value="14:00" {{ ($objProperty->openHouseEndTime=='14:00'?'selected="selected"':'') }}>14:00</option>
												<option value="14:30" {{ ($objProperty->openHouseEndTime=='14:30'?'selected="selected"':'') }}>14:30</option>
												<option value="15:00" {{ ($objProperty->openHouseEndTime=='15:00'?'selected="selected"':'') }}>15:00</option>
												<option value="15:30" {{ ($objProperty->openHouseEndTime=='15:30'?'selected="selected"':'') }}>15:30</option>
												<option value="16:00" {{ ($objProperty->openHouseEndTime=='16:00'?'selected="selected"':'') }}>16:00</option>
												<option value="16:30" {{ ($objProperty->openHouseEndTime=='16:30'?'selected="selected"':'') }}>16:30</option>
												<option value="17:00" {{ ($objProperty->openHouseEndTime=='17:00'?'selected="selected"':'') }}>17:00</option>
												<option value="17:30" {{ ($objProperty->openHouseEndTime=='17:30'?'selected="selected"':'') }}>17:30</option>
												<option value="18:00" {{ ($objProperty->openHouseEndTime=='18:00'?'selected="selected"':'') }}>18:00</option>
												<option value="18:30" {{ ($objProperty->openHouseEndTime=='18:30'?'selected="selected"':'') }}>18:30</option>
												<option value="19:00" {{ ($objProperty->openHouseEndTime=='19:00'?'selected="selected"':'') }}>19:00</option>
												<option value="19:30" {{ ($objProperty->openHouseEndTime=='19:30'?'selected="selected"':'') }}>19:30</option>
												<option value="20:00" {{ ($objProperty->openHouseEndTime=='20:00'?'selected="selected"':'') }}>20:00</option>
												<option value="20:30" {{ ($objProperty->openHouseEndTime=='20:30'?'selected="selected"':'') }}>20:30</option>
												<option value="21:00" {{ ($objProperty->openHouseEndTime=='21:00'?'selected="selected"':'') }}>21:00</option>
												<option value="21:30" {{ ($objProperty->openHouseEndTime=='21:30'?'selected="selected"':'') }}>21:30</option>
												<option value="22:00" {{ ($objProperty->openHouseEndTime=='22:00'?'selected="selected"':'') }}>22:00</option>
											</select>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.openhouse') }}: </strong></label>
						            	</div>
						            	<div class="col-md-6">
											<input class="form-control adform" type="text" name="openHouseAddress" id="" placeholder="" value="{{ $objProperty->openHouseAddress }}" />
										</div>
						          	</div>
						          
						          	<div class="row">
						          		<div class="col-md-3">
						          			<label><strong>{{ __('messages.postComments') }}: </strong></label>
						          		</div>
						          		<div class="col-md-6">
						          			<input class="form-control adform" type="text" name="openHouseComment" id="" placeholder="" value="{{ $objProperty->openHouseComment }}" />
						          		</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a class="panel-heading accordion-toggle "  data-toggle="collapse" data-parent="#accordion" href="#collapseSixth">{{ __('messages.postPictures') }}</a></h3>
						</div>
						<script type="text/javascript">
						window.onload = function(){
					        
						    //Check File API support
						    if(window.File && window.FileList && window.FileReader)
						    {
						        var filesInput = document.getElementById("files");
						        
						        filesInput.addEventListener("change", function(event){
						            
						            var files = event.target.files; //FileList object
						            var output = document.getElementById("result");
						            
						            for(var i = 0; i< files.length; i++)
						            {
						                var file = files[i];
						                
						                //Only pics
						                if(!file.type.match('image'))
						                  continue;
						                
						                var picReader = new FileReader();
						                
						                picReader.addEventListener("load",function(event){
						                    
						                    var picFile = event.target;
						                    
						                    var div = document.createElement("div");
						                    div.className = "imgprev";
						                    div.innerHTML = "<input type='hidden' value='"+picFile.result+"' name='image_files[]'><img class='thumbnail' src='" + picFile.result + "'" +
						                            "title='" + picFile.name + "'/> <a onclick='remove_div(this)' href='#collapseSixth' class='remove_pict'>X</a>";
						                    
						                    output.insertBefore(div,null);   
						                    div.children[1].addEventListener("click", function(event){
						                       div.parentNode.removeChild(div);
						                    });         
						                
						                });
						                
						                 //Read the image
						                picReader.readAsDataURL(file);
						            }                               
						           
						        });
						    }
						    else
						    {
						        console.log("Your browser does not support File API");
						    }
						}
						function remove_div(obj){
							$(obj).parent().remove();
						}
						function delete_prop_image(id)
						{
							var dataString = 'id='+id;
							
							$.ajax({
									url: "{{ url('delete_property_image') }}",
									type: "POST",
									data: dataString,
									dataType: "json",
									global: false,
									cache: false,
									async: false,
									success: function(data)
									{
										var status = data.status;
										if ($.trim(status) == 'OK')
										{
											$("#img_"+id).remove();
										}
									}
								});
						}
						</script>
						
						<div id="collapseSixth" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="fileinput fileinput-new col-md-12" data-provides="fileinput">
										<p>{{ __('messages.postTip') }}</p>
									</div>
									<style type="text/css">
										article
										{
										    margin:auto;
										    margin-top:10px;
										}
										
										#result { float: left;}
										.imgprev { float: left; margin-left:15px; }
										.remove_pict {float: right; margin: -30px -7px 0 0;}
										.thumbnail
										{
										    height: 100px;
										    margin: 10px;  
										    width:  100px;
										}
									</style>
									<div class="fileUpload btn btn-primary">
										<span style="font-weight: bold;">{{ __('messages.choosefile') }}</span>
										<input type="file" id="files" class="upload" name="files[]" multiple="multiple" accept="image/*" />
									</div>
						            <article>
						               	<output id="result">
						               		@if(!empty($objGallery) && count($objGallery)>0)
						               			@foreach($objGallery as $gallery_record)
						               				@if(!empty($gallery_record->path) && file_exists($gallery_record->path))
						               					<div class="imgprev" id="img_{{ $gallery_record->id }}">
						                           			<img class="thumbnail" title="" src="{{ asset($gallery_record->path) }}" alt="..." />
						                           			<a class="remove_pict" href="javascript:void(0);" onclick="javascript:delete_prop_image('{{ $gallery_record->id }}');">X</a>
						                           		</div>
						               				@endif
						               			@endforeach
						               		@endif
						               	</output>
									</article>
								</div>
							</div>
						</div>
					</div>

					<input type="hidden" id="pk_rGroup" name="package_type_id" value="1" />
					<!--
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a class="panel-heading accordion-toggle "  data-toggle="collapse" data-parent="#accordion" href="#collapseSeventh">{{ __('messages.postPackageselect') }}</a></h3>
						</div>
						<div id="collapseSeventh" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<div class="pricing" style="margin-top: 5px;">
										<input type="hidden" id="pk_rGroup" name="package_type_id" value="{{ $objProperty->package_type_id }}" />
										<div class="item col-sm-4 std_pk">
											<div id="pk_1" class="priceDiV {{ ($objProperty->package_type_id==1)?'selected':'' }}">
											<header>
												<h2>{{ __('messages.postStandart') }}</h2>
												<div class="price">
													{{ __('messages.postFree') }}<small>&nbsp;</small>
												</div>
											</header>
											<ul>
												<li style="min-height: 75px;">{{ __('messages.postFreeweb') }}</li>
											</ul>
											<a href="javascript:select_pk('1');" class="btn btn-default-color">{{ __('messages.postFree') }}</a>
											</div>
										</div>
										
										<div class="item col-sm-4 green_pk">
											<div id="pk_2" class="priceDiV {{ ($objProperty->package_type_id==2)?'selected':'' }}">
											<header>
												<h2>{{ __('messages.postGreen') }}</h2>
												<div class="price">
													Kr.89<small>{{ __('messages.postSeven') }}</small>
												</div>
											</header>
											<ul>
												<li style="min-height: 75px;">{{ __('messages.postSevendays') }}</li>
											</ul>
											<a href="javascript:select_pk('2');" class="btn btn-default-color">{{ __('messages.lbl_package_buy') }}</a>
											</div>
										</div>
							
										<div class="item col-sm-4 blue_pk">
											<div id="pk_3" class="priceDiV {{ ($objProperty->package_type_id==3)?'selected':'' }}">
											<header>
												<h2>{{ __('messages.postBlue') }}</h2>
												<div class="price">
													Kr.129<small>{{ __('messages.postSeven') }}</small>
												</div>
											</header>
											<ul>
												<li style="min-height: 75px;">{{ __('messages.postSevendaysBlue') }}</li>
											</ul>
											<a href="javascript:select_pk('3');" class="btn btn-default-color">{{ __('messages.lbl_package_buy') }}</a>
											</div>
										</div>
							
									</div>
									<script type="text/javascript">
									function select_pk(id)
									{
										var freePkTxt = "{{ __('messages.lbl_post_prop') }}";
										var paidPkTxt = "{{ __('messages.lbl_proceed_to_checkout') }}";
			
										if(id == 1)
										{	$("#propSubmitBtn").val(freePkTxt); }
										else
										{	$("#propSubmitBtn").val(paidPkTxt); }		
										
										$("#pk_rGroup").val(id);
										$(".priceDiV").removeClass("selected");
										$("#pk_"+id).addClass("selected");
									}
									</script>
									
									<div class="row">
										<div class="col-md-3 col-md-offset-9">
										</div>
									</div>
						
								</div>
							</div>
						</div>
						
						 <div class="row">
						 	<div class="col-md-4 col-md-offset-9">
						 			<input id='propSubmitBtn' type='submit' class='btn btn-primary' style='font-weight:bold;' value="{{ __('messages.saveandproceed') }}" name='submitProperty'><br><br>
						 	</div>
						 </div>
					</div> -->


		 			<input id='propSubmitBtn' type='submit' class='btn btn-primary' style='font-weight:bold;' value="{{ __('messages.saveandproceed') }}" name='submitProperty'><br><br>

				</form>
			</div>	
		</div>
	</div>
</div>

<script src="{{ asset('public/js/datepickr.js') }}"></script>
<script type="text/javascript">
new datepickr('datepick');

$("#datepick2" ).focus(function() {
  new datepickr('datepick2');
});

$("#ammount").bind("change paste keyup", function() {
    $("#dpayment").val($(this).val()*(0.2));
});

$("#floorselect").bind("change paste keyup", function() {
    $("#floortxt").val($(this).val());
});

$("#deposit").bind("change paste keyup", function() {
    $("#depositValue").val($("#deposit option:selected").index()*$("#ammount").val());
});

  $("#prepaid").bind("change paste keyup", function() {
    $("#prepaidValue").val($("#prepaid option:selected").index()*$("#ammount").val());
});


$('document').ready(function(){
	$(".rentbuysel").val("rent");
	$( ".rentbuyrow" ).hide();
});

$(".showenglish").click(function(){
	$(".englishversion").toggle("slow");
});

$(".showOpenhouse").click(function(){
	$(".openHousetoggle").toggle("slow");
});

$(".showphone").click(function(){
	$(".secondphone").toggle("slow");
});

$(".energy").click(function(){
	$(".energyinput").show();
});
</script>
<script stype="text/javascript">
var selDiv = "";

document.addEventListener("DOMContentLoaded", init, false);

function init() {
	document.querySelector('#files').addEventListener('change', handleFileSelect, false);
	selDiv = document.querySelector("#selectedFiles");
}

function handleFileSelect(e) {

	if(!e.target.files || !window.FileReader) return;

	selDiv.innerHTML = "";

	var files = e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	filesArr.forEach(function(f) {
		if(!f.type.match("image.*")) {
			return;
		}

		var reader = new FileReader();
		reader.onload = function (e) {
			var html = "<div class='col-sm-2'><img src=\"" + e.target.result + "\">" + f.name + "<br clear=\"left\"/></div>";
			selDiv.innerHTML += html;
		}
		reader.readAsDataURL(f);

	});
}

$( ".rentt" ).click(function() {
	  $( ".petsrow" ).show();
	  $( ".payments" ).hide();
	  $(" .yearbuild").hide();
	  $( ".ground" ).hide();
	  $(".rental_period_row").show();
	  $("#rental_period_handler").attr("required", true);
	  $( "#postTotal1" ).show();
	  $( "#postTotal2" ).hide();
	  jQuery("#radio_1").prop("checked", true);
	  jQuery("#radio_2").prop("checked", false);
});

$( ".buyy" ).click(function() {
	$(".rentbuysel").val("buy");
	$( ".petsrow" ).hide();
	$( ".payments" ).show();
	$(" .yearbuild").show();
	$( "#postTotal1" ).hide();
	$( "#postTotal2" ).show();
	$( ".ground" ).show();
	$(".rental_period_row").hide();
	$("#rental_period_handler").attr("required", false);
	$("#rental_period_handler").find('option:selected').attr('selected',false);
	$("#rental_period_handler").trigger("liszt:updated");
	jQuery("#radio_1").prop("checked", false);
	jQuery("#radio_2").prop("checked", true);
});

function showRent(){
    $(function () {
       $('#rent').tab('show');
    })
}

function showRent(){
    $(function () {
       $('#buy').tab('show')
    })
}

function validateProperty()
{
	var lat = $("#latitude").val();
	var lan = $("#longitude").val();

	if((lat == '') || (lan == ''))
	{
		alert('Please select proper address');
		return false;
	}		
	return true;
}

function setVacantOption(val)
{
	if(val == 'date')
	{	
		$("#datepickDiv").show();
		$("#datepick").attr("required", true);
	}
	else
	{
		$("#datepick").val('');
		$("#datepickDiv").hide();
		$("#datepick").attr("required", false);
	}
}
    
$(document).ready(function () {
    // Get the Radio Buttons.
    var rb = $('.radioss').find('input:radio');

    rb.click(function () {
        // Get the selected value
        var selected=$(this).val();
        if(selected=="1"){
            $("#totalammount").text("");}
        else
        if(selected=="2"){
            $("#totalammount").text(" Kr.89 ");}
        else
        if(selected=="3"){
            $("#totalammount").text(" Kr.129 ");}
    });
});
</script>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('public/js/map_address_search.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpNqB30eVLDw9fM5qTFqJvkA4XdJslXm0&libraries=places&callback=initAddressAutocomplete&country=DK" async defer></script>
@endsection