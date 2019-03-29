@extends('layout.index')
@section('pageTitle','Opret annonce')

@section('styles')

	<link
		href="{{ asset('public/css/datepickr.css') }}"
		rel="stylesheet"
		type="text/css">

@endsection

@section('content')

	{{-- PAGE TITLE/BREADCRUMB --}}
	<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="page-title">{{ __('messages.postlisting') }}</h1>
					<ul class="breadcrumb">
						<li><a href="{{ route('home') }}">{{ __('messages.lbl_home') }} </a></li>
						<li>{{ __('messages.post_ad') }}</li>
					</ul>

				</div>
			</div>
		</div>
	</div>
	{{-- PAGE TITLE/BREADCRUMB --}}

	{{-- content --}}
	<div class="content">
		{{-- container --}}
		<div class="container">
			{{-- row --}}
			<div class="row">
				{{-- main col-sm-12 mainpbt --}}
				<div class="main col-sm-12 mainpbt">
					<form
						action="{{ route('property.insert') }}"
						method="POST"
						class="formSubmitUpload"
						enctype="multipart/form-data">
						{{ csrf_field() }}
						{{-- nav nav-tabs tabcostum --}}
						<ul class="nav nav-tabs tabcostum" role="tablist" style="margin:10px 0;border:none;">
							{{-- <li class="rentt active">
								<a href="#rent" role="tab" data-toggle="tab">
									<b>{{ __('messages.rentPdetails') }}</b>
									<label></label>
								</a>
							</li> --}}
							<li class="buyy" style="display: none;">
								<a href="#sell" role="tab" data-toggle="tab">
									<b>{{ __('messages.sellPdetails') }}</b>
									<input type="radio" id="radio_1" name="action" value="rent" checked style="visibility: hidden;" />
									<label><input type="radio" id="radio_2" name="action" value="buy" style="visibility: hidden;" /></label>
								</a>
							</li>

							@if(!Auth::check())
								<h4 style="color: #74777c; font-weight: normal; padding: 12px 0; text-align: center;">
									You need to have a Findbo account to post your listing. Create account <a style="font-size: 12px;" href="{{ route('login') }}"> HERE</a>
								</h4>
							@endif
						</ul>
						{{-- ./nav nav-tabs tabcostum --}}

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
											<input class="form-control adform" type="text" name="headline_dk" required>
										</div>

										<div class="col-md-3">
											<label><strong>{{ __('messages.bodyText') }}: *</strong></label>
										</div>

										<div class="col-md-8">
											<textarea class="areatxt form-control" rows="3" name="text_dk" id="texta" required></textarea>
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
											<input class="form-control adform" type="text" name="headline_eng" maxlength="50">
										</div>

										<div class="col-md-3">
											<label><strong>{{ __('messages.bodyText') }}: </strong></label>
										</div>

										<div class="col-md-8">
											<textarea class="areatxt form-control" rows="3" name="text_eng" id="texta"></textarea>
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
														<option value="{{ $area->id }}">{{ $area->name }}</option>
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
														<option value="{{ $zipcode->id }}">{{ $zipcode->city_name }}</option>
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
											<input id="address" placeholder="{{ __('messages.lbl_enter_address') }}" class="form-control adform" type="text" name="address" required>
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
											<input class="form-control adform" type="text" name="housenum" required>
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
												<option value="kld">kld</option>
								                <option value="kld tv">kld tv</option>
								                <option value="kld mf">kld mf</option>
								                <option value="kld th">kld th</option>
								                <option value="Stuen">Stuen</option>
								                <option value="st tv">st tv</option>
								                <option value="st mf">st mf</option>
								                <option value="st th">st th</option>
								                 <?php
							                	for($floorIndex = 1; $floorIndex<=16; $floorIndex++)
							                	{
							                		?>
							                		<option value="<?php echo $floorIndex; ?>. sal"><?php echo $floorIndex; ?>. sal</option>
							                		<option value="<?php echo $floorIndex; ?>. tv"><?php echo $floorIndex; ?>. tv</option>
							                		<option value="<?php echo $floorIndex; ?>. mf"><?php echo $floorIndex; ?>. mf</option>
							                		<option value="<?php echo $floorIndex; ?>. th"><?php echo $floorIndex; ?>. th</option>
							                		<?php
							                	}
							                	?>
											</select>
										</div>
										<div class="col-md-4" style="visibility: hidden;">
											<input class="form-control adf9orm" type="text" name="floor" id="floortxt">
										</div>
										<div class="col-sm-2"> </div>
									</div>

									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<br>
											<div class="col-sm-6" style="padding: 0px !important; padding-right:5px !important;">
												<input type="hidden" name="location1" class="form-control adform" id="latitude" placeholder="{{ __('messages.latitude') }}" name="latitude"  required >
											</div>
											<div class="col-sm-6" style="padding: 0px !important; padding-left:5px !important;">
												<input type="hidden" name="location2" class="form-control adform" id="longitude" placeholder="{{ __('messages.longitude') }}" name="longitude" required>
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
												<input englishversion type="radio" onclick="javascript:setVacantOption('immediately');" name="vacant" id="handlerImmediately" value="Immediately"> {{ __('messages.immediately') }}
											</label>

											<label for="handlerAppointment">
												<input englishversion onclick="javascript:setVacantOption('appointment');" type="radio" name="vacant" style="margin-top:4px;" id="handlerAppointment" value="appointment"> {{ __('messages.postAppoinment') }}
											</label>

											<label for="handlerDate">
												<input englishversion onclick="javascript:setVacantOption('date');" type="radio" name="vacant" id="handlerDate" value="Date" checked="checked"> {{ __('messages.lbl_date') }}
											</label>

											<div id="datepickDiv">
												<input id="datepick" style="width: 236px;" size="50" name="vacantDate" class="form-control" required />
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
												<option value="Room">{{ __('messages.postroom') }}</option>
												<option value="Apartment">{{ __('messages.postapartment') }}</option>
												<option value="House">{{ __('messages.posthouse') }}</option>
												<option value="Villa">{{ __('messages.post_villa') }}</option>
												<option value="Shared">{{ __('messages.postaccomodation') }}</option>
												<option value="Exchange">{{ __('messages.postexchange') }}</option>
												<option value="Holiday">{{ __('messages.postholiday') }}</option>
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
														<option value="{{ $rentalPeriod->id }}">{{ __('messages.rental_period_'.$rentalPeriod->id) }}</option>
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
												<input class="form-control adform" type="text" name="size" required>
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
												<input class="form-control adform" type="text" name="groundarea">
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
											<input class="form-control adform" type="number" name="rooms" id="NewConfirmPassword" required min="1">
										</div>
										<div class="col-sm-4"> </div>
									</div>

									<div class="row petsrow">
										<div class="col-md-3">
											<label><strong>{{ __('messages.postpetss') }}:</strong></label>
										</div>
										<div class="col-md-3">
											<select class="form-control adform" name="pets">
												<option value="1" selected>{{ __('messages.postallowed') }}</option>
												<option value="2">{{ __('messages.postNotallowed') }}</option>
												<option value="3">{{ __('messages.postLandlord') }}</option>
											</select>
											<br/>
										</div>
										<div class="col-md-4">
											<input class="form-control adform" type="text" name="petcomment" placeholder="{{ __('messages.possibleComments') }}" id="">
										</div>
									</div>

									<div class="row yearbuild" style="display:none;">
										<div class="col-md-3">
											<label><strong>{{ __('messages.builtyear') }}: </strong></label>
										</div>
										<div class="col-md-3">
											<input class="form-control adform" type="text" name="year">
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
													<input englishversion type="checkbox" id="chkBalcony" name="balcony" value="1">
		            								{{ __('messages.postBalcony') }}
												</label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="dd_li">
												<label for="chkGarage">
										            <input englishversion type="checkbox" id="chkGarage" name="garage" value="1">
										            {{ __('messages.garage') }}
										        </label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="dd_li">
												<label for="chkLift">
													<input englishversion type="checkbox" id="chkLift" name="lift" value="1">
	            									{{ __('messages.postlift') }}
												</label>
											</div>
										</div>

										<div class="col-md-3">
											<div class="dd_li">
												<label for="chkGarden">
													<input englishversion type="checkbox" id="chkGarden" name="garden" value="1">
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
													<input englishversion type="checkbox" id="chkShareFriendly" name="sharefriendly" value="1">
													{{ __('messages.shareFriendly') }}
												</label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="dd_li">
												<label for="chkHandicapFriendly">
													<input englishversion type="checkbox" id="chkHandicapFriendly" name="handicapfriendly" value="1">
		            								{{ __('messages.handicapFriendly') }}
												</label>
											</div>
										</div>

										<div class="col-md-2">
											<div class="dd_li">
												<label for="chkYouthHousing">
													<input englishversion type="checkbox" id="chkYouthHousing" name="youthhousing" value="1">
													{{ __('messages.youthFriendly') }}
												</label>
											</div>
										</div>

										<div class="col-md-3">
											<div class="dd_li">
												<label for="chkSeniorFriendly">
													<input englishversion type="checkbox" id="chkSeniorFriendly" name="seniorfriendly" value="1">
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
													<input englishversion type="checkbox" id="chk_furnished" name="furnished" value="1">
													{{ __('messages.lbl_furnished') }}
												</label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="dd_li">
												<label for="chk_basement">
													<input englishversion type="checkbox" id="chk_basement" name="basement" value="1">
													{{ __('messages.lbl_basement') }}
												</label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="dd_li">
												<label for="chk_entryphone">
													<input englishversion type="checkbox" id="chk_entryphone" name="entryphone" value="1">
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
												<input class="form-control adform " type="text" name="rent" id="ammount" required placeholder="{{ __('messages.propertyCost') }}">
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
													<input class="form-control adform " type="text" name="payment" placeholder="{{ __('messages.amount') }}"></span>
												</div>
												<div class="col-sm-6"> </div>
											</div>
											<div class="row payments">
												<div class="col-md-3">
													<label><strong>{{ __('messages.downpayment') }}: *</strong></label>
												</div>
												<div class="col-md-3" style="padding-bottom: 10px;">
													<div class="input-group">
														<input class="form-control adform" type="text" name="downpayment" id="dpayment" >
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
														<input class="form-control adform" type="text" name="gross" placeholder="{{ __('messages.writenumber') }}">
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
														<input class="form-control adform" type="text" name="net" placeholder="{{ __('messages.writenumber') }}"></span>
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
														<option>{{ __('messages.postchoosee') }}</option>
														<option>{{ __('messages.postonemonth') }}</option>
														<option>{{ __('messages.posttwomonth') }}</option>
														<option>{{ __('messages.postthreemonth') }}</option>
													</select>
												</div>

												<div class="col-md-4" style="padding-bottom: 10px;">
													<div class="input-group">
														<input class="form-control adform" type="text" name="depositValue" id="depositValue" placeholder="{{ __('messages.depositValue') }}">
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
														<option>{{ __('messages.postchoosee') }}</option>
									                    <option>{{ __('messages.postonemonth') }}</option>
									                    <option>{{ __('messages.posttwomonth') }}</option>
									                    <option>{{ __('messages.postthreemonth') }}</option>
													</select>
												</div>
												<div class="col-md-4" style="padding-bottom: 10px;">
													<div class="input-group">
					              						<input class="form-control adform" type="text" name="prepaidValue" id="prepaidValue" placeholder="">
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
									          	<input class="form-control adform" type="text" name="expenses" placeholder="{{ __('messages.writenumber') }}">
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
												<option value="">N/A</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="D">D</option>
												<option value="E">E</option>
												<option value="F">F</option>
												<option value="G">G</option>
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
											<input class="form-control adform" type="text" name="company_name" placeholder="" />
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.postphone') }}: *</strong></label>
										</div>
										<div class="col-md-2">
											<input class="form-control adform" type="text" name="country1" placeholder="{{ __('messages.county') }}" maxlength="5">
										</div>
										<div class="col-md-4">
											<input class="form-control adform" type="text" name="number1" id="" placeholder="{{ __('messages.actualphone') }}">
										</div>
										<span class="showphone green" style="cursor:pointer;">{{ __('messages.lbl_add_secondary_contact_no') }}</span>
									</div>

									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.emaill') }}: *</strong></label>
										</div>

										<div class="col-md-6">
											<input class="form-control adform" type="email" name="emailadd" id="NewConfirmPassword" placeholder="{{ __('messages.enteremail') }}" required></span>
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
											<label><strong>{{ __('messages.url') }}: </strong></label>
										</div>

										<div class="col-md-6">
											<input class="form-control adform" type="text" name="txtURL" id="txtURL" placeholder="{{ __('messages.url') }}">
										</div>
									</div>

									<div class="secondphone" style="display: none">
										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.emaill') }} 2:</strong></label>
											</div>
											<div class="col-md-6">
												<input class="form-control adform" type="email" name="emailadd2" id="NewConfirmPassword" placeholder="{{ __('messages.enteremail') }}" ></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.postphone') }} 2: </strong></label>
											</div>
											<div class="col-md-2">
												<input class="form-control adform" type="text" name="country2" id="NewConfirmPassword" placeholder="{{ __('messages.county') }}" maxlength="5">
											</div>
											<div class="col-md-4">
												<input class="form-control adform" type="text" name="number2" id="" placeholder="{{ __('messages.actualphone') }}">
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
												<input englishversion class="showOpenhouse" type="checkbox" id="englishversion" name="businessContract" value="1">
												<label for="englishversion"  >{{ __('messages.postContractB') }}</label>
											</div>
										</div>
									</div>
									<br>

									<div class="openHousetoggle" style="display:none;">
										<div class="row">
											<div class="col-sm-3">
												<label><strong>{{ __('messages.lbl_time') }}: </strong></label>
											</div>

											<div class="col-sm-3">
												<div>
													<input id="datepick2" size="50" name="openHouseDate" class="form-control" />
												</div>
											</div>

											<span style="float:left;padding-top:5px;">{{ __('messages.between') }}</span>
											<div class="col-sm-2">
												<select id="OpenHouseStartTime" class="form-control adform" name="openHouseStartTime">
											 		<option value="08:00" selected>08:00</option>
													<option value="08:30">08:30</option>
													<option value="09:00">09:00</option>
													<option value="09:30">09:30</option>
													<option value="10:00">10:00</option>
													<option value="10:30">10:30</option>
													<option value="11:00">11:00</option>
													<option value="11:30">11:30</option>
													<option value="12:00">12:00</option>
													<option value="12:30">12:30</option>
													<option value="13:00">13:00</option>
													<option value="13:30">13:30</option>
													<option value="14:00">14:00</option>
													<option value="14:30">14:30</option>
													<option value="15:00">15:00</option>
													<option value="15:30">15:30</option>
													<option value="16:00">16:00</option>
													<option value="16:30">16:30</option>
													<option value="17:00">17:00</option>
													<option value="17:30">17:30</option>
													<option value="18:00">18:00</option>
													<option value="18:30">18:30</option>
													<option value="19:00">19:00</option>
													<option value="19:30">19:30</option>
													<option value="20:00">20:00</option>
													<option value="20:30">20:30</option>
													<option value="21:00">21:00</option>
													<option value="21:30">21:30</option>
													<option value="22:00">22:00</option>
												</select>
											</div>

											<span style="float:left;padding-top:5px;">{{ __('messages.and') }}</span>
											<div class="col-sm-2">
												<select id="OpenHouseEndTime" class="form-control adform" name="openHouseEndTime">
													<option value="08:00" selected>08:00</option>
													<option value="08:30">08:30</option>
													<option value="09:00">09:00</option>
													<option value="09:30">09:30</option>
													<option value="10:00">10:00</option>
													<option value="10:30">10:30</option>
													<option value="11:00">11:00</option>
													<option value="11:30">11:30</option>
													<option value="12:00">12:00</option>
													<option value="12:30">12:30</option>
													<option value="13:00">13:00</option>
													<option value="13:30">13:30</option>
													<option value="14:00">14:00</option>
													<option value="14:30">14:30</option>
													<option value="15:00">15:00</option>
													<option value="15:30">15:30</option>
													<option value="16:00">16:00</option>
													<option value="16:30">16:30</option>
													<option value="17:00">17:00</option>
													<option value="17:30">17:30</option>
													<option value="18:00">18:00</option>
													<option value="18:30">18:30</option>
													<option value="19:00">19:00</option>
													<option value="19:30">19:30</option>
													<option value="20:00">20:00</option>
													<option value="20:30">20:30</option>
													<option value="21:00">21:00</option>
													<option value="21:30">21:30</option>
													<option value="22:00">22:00</option>
												</select>
											</div>
										</div>

										<div class="row">
											<div class="col-md-3">
												<label><strong>{{ __('messages.openhouse') }}: </strong></label>
							            	</div>
							            	<div class="col-md-6">
												<input class="form-control adform" type="text" name="openHouseAddress" id="NewConfirmPassword" placeholder="">
											</div>
							          	</div>

							          	<div class="row">
							          		<div class="col-md-3">
							          			<label><strong>{{ __('messages.postComments') }}: </strong></label>
							          		</div>
							          		<div class="col-md-6">
							          			<input class="form-control adform" type="text" name="openHouseComment" id="NewConfirmPassword" placeholder="">
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
							               	<output id="result" />
										</article>
									</div>
								</div>
							</div>
						</div>

						<input type="hidden" id="pk_rGroup" name="package_type_id" value="1" />

						<button type='button' class='btn btn-primary submitUpload' style='font-weight:bold;'>{{ __('messages.lbl_post_prop') }}</button>
						<br><br>

					</form>
				</div>
				{{-- ./main col-sm-12 mainpbt --}}
			</div>
			{{-- /row --}}
		</div>
		{{-- ./container --}}
	</div>
	{{-- ./content --}}

@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('public/js/map_address_search.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpNqB30eVLDw9fM5qTFqJvkA4XdJslXm0&libraries=places&callback=initAddressAutocomplete&country=DK" ></script>
	<script src="{{ asset('public/js/datepickr.js') }}"></script>

	<script type="text/javascript">

		jQuery(document.body).on('click','.submitUpload', function() {
			jQuery('.formSubmitUpload').submit();
		});

		var selDiv = "";
		window.onload = function() {
		  //Check File API support
		  if(window.File && window.FileList && window.FileReader) {
				var filesInput = document.getElementById("files");

	      filesInput.addEventListener("change", function(event) {

          var files = event.target.files; //FileList object
          var output = document.getElementById("result");

          for(var i = 0; i< files.length; i++) {
            var file = files[i];

            //Only pics
            if(!file.type.match('image'))
              continue;

            var picReader = new FileReader();

            picReader.addEventListener("load",function(event) {

              var picFile = event.target;

              var div = document.createElement("div");
              div.className = "imgprev";
              div.innerHTML = "<input type='hidden' value='"+picFile.result+"' name='image_files[]'><img class='thumbnail' src='" + picFile.result + "'" + "title='" + picFile.name + "'/> <a onclick='remove_div(this)' href='#collapseSixth' class='remove_pict'>X</a>";
              output.insertBefore(div,null);
              div.children[1].addEventListener("click", function(event) {
                 div.parentNode.removeChild(div);
              });
            });

             //Read the image
            picReader.readAsDataURL(file);
          }
	      });

		  } else {
				console.log("Your browser does not support File API");
		  }
		}

		function remove_div(obj){
			$(obj).parent().remove();
		}

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

		$(".showphone").click(function() {
			$(".secondphone").toggle("slow");
		});

		$(".energy").click(function(){
			$(".energyinput").show();
		});

		function init() {
			document.querySelector('#files').addEventListener('change', handleFileSelect, false);
			return document.querySelector("#selectedFiles");
		}

		document.addEventListener("DOMContentLoaded", init(), false);

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

		function showRent() {
		  $(function () {
		     $('#rent').tab('show');
		  })
		}

		function showRent() {
		  $(function () {
		     $('#buy').tab('show')
		  })
		}

		function validateProperty() {
			var lat = $("#latitude").val();
			var lan = $("#longitude").val();

			if((lat == '') || (lan == '')) {
				alert('Please select proper address');
				return false;
			}
			return true;
		}

		function setVacantOption(val) {
			if(val == 'date') {
				$("#datepickDiv").show();
				$("#datepick").attr("required", true);
			} else {
				$("#datepick").val('');
				$("#datepickDiv").hide();
				$("#datepick").attr("required", false);
			}
		}

		$(document).ready(function () {
		  var rb = $('.radioss').find('input:radio');
		  rb.click(function () {

		  	var selected = $(this).val();

		  	if(selected == "1") {
		  		$("#totalammount").text("");
		  	} else if(selected == "2") {
		  		$("#totalammount").text(" Kr.89 ");
		  	} else if(selected == "3") {
		  		$("#totalammount").text(" Kr.129 ");
		  	}

		  });
		});

	</script>

@endsection