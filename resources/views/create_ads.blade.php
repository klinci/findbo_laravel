@extends('layout.index')

@section('pageTitle', __('messages.lbl_seek_house_ad'))

@section('meta_tags')
<meta name="keywords" content="">
<meta name="description" content="{{ __('messages.meta_desc_home_seeker') }}">
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1 class="page-title">{{ __('messages.lbl_seek_house_ad') }}</h1>

				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.lbl_seek_ad') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row ">
			<div class="min col-sm-12 mainpbt">
				<div class="row">
					<div class="col-sm-12">
						<br>
						<h2 class="property-title" style="margin: 10px 0px;"> {{ __('messages.seek_ad_msg_1') }} </h2>
						<p>{{ __('messages.seek_ad_msg_2') }}</p>
					</div>

					<div class="col-sm-12">

						<form action="
							@isset($objSeekAds)
								{{ route('home_seeker.show', $objSeekAds->id) }}
							@else
								{{ route('home_seeker.post') }}
							@endisset"
							method="post"
							enctype="multipart/form-data">
							{{ csrf_field() }}

							@isset($method) {{ method_field($method) }} @endisset
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a class="panel-heading accordion-toggle"  data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ __('messages.lbl_ad_information') }}</a>
									</h3>
								</div>

								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_civil_status') }}:</strong></label>
											</div>
											<div class="col-sm-4">
												<select name="civil_status" class="form-control" required>
													@isset($objSeekAds)

													<?php
													$civilstatus = $objSeekAds->civilStatus;
													if (in_array($civilstatus, ['single', 'divorced', 'married']))
														$civilstatus = '';
													?>

													<option value="" {{ ($civilstatus == '')?'selected="selected"':'' }}>{{ __('messages.lbl_please_choose') }}</option>
													<option value="employed"{{ ($civilstatus == 'employed')?'selected="selected"':'' }}>{{ __('messages.lbl_employed') }}</option>
													<option value="unemployed"{{ ($civilstatus == 'unemployed')?'selected="selected"':'' }}>{{ __('messages.lbl_unemployed') }}</option>
													<option value="student"{{ ($civilstatus == 'student')?'selected="selected"':'' }}>{{ __('messages.lbl_student') }}</option>
													<option value="pensionist"{{ ($civilstatus == 'pensionist')?'selected="selected"':'' }}>{{ __('messages.lbl_pensionist') }}</option>
													<option value="other"{{ ($civilstatus == 'other')?'selected="selected"':'' }}>{{ __('messages.lbl_other') }}</option>

													@else

													<option value="">{{ __('messages.lbl_please_choose') }}</option>
													<option value="employed">{{ __('messages.lbl_employed') }}</option>
													<option value="unemployed">{{ __('messages.lbl_unemployed') }}</option>
													<option value="student">{{ __('messages.lbl_student') }}</option>
													<option value="pensionist">{{ __('messages.lbl_pensionist') }}</option>
													<option value="other">{{ __('messages.lbl_other') }}</option>

													@endisset
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-2">
												<label><strong>{{ __('messages.postHeadline') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" value="@isset($objSeekAds){{ $objSeekAds->title }}@endisset" name="title" maxlength="50" placeholder="{{ __('messages.lbl_enter_ad_title') }}" required>
											</div>
										</div>

										<div class="row">
											<!-- Description -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_description') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<textarea class="form-control" name="desc" rows="4" required>@isset($objSeekAds){{ $objSeekAds->description }}@endisset</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a class="panel-heading accordion-toggle"  data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">{{ __('messages.lbl_contact_information') }}</a>
									</h3>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row">
											<!-- Name -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_name') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="name" value="@isset($objSeekAds) {{ $objSeekAds->name }} @endisset" placeholder="{{ __('messages.lbl_enter_name_surname') }}" required>
											</div>
										</div>

										<div class="row">
											<!-- Name -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_age') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="number" min="1" max="120" class="form-control" name="age" value="@isset($objSeekAds){{ $objSeekAds->age }}@endisset" placeholder="{{ __('messages.lbl_enter_age') }}">
											</div>
										</div>

										<div class="row">
											<!-- Phone number -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_phone_number') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone" value="@isset($objSeekAds){{ $objSeekAds->phone }}@endisset" placeholder="{{ __('messages.lbl_enter_phone') }}" required>
											</div>
										</div>

										<div class="row">
											<!-- Phone number -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_phone_number_2') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone2" value="@isset($objSeekAds){{ $objSeekAds->phone2 }}@endisset" placeholder="{{ __('messages.lbl_enter_another_phone') }}" >
											</div>
										</div>

										<div class="row">
											<!-- Email -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.emaill') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="email" class="form-control" name="email" value="@isset($objSeekAds){{ $objSeekAds->email }}@endisset" placeholder="{{ __('messages.lbl_enter_email') }}" required>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a class="panel-heading accordion-toggle"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree">{{ __('messages.lbl_property_requirements') }}</a>
									</h3>
								</div>

								<div id="collapseThree" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row">
											<div class="col-sm-2">
												<label><strong>{{ __('messages.postAreas') }}:</strong></label>
											</div>
											<div class="col-sm-4">
												<select class="form-control" name="location" required>
													<option value=""> {{ __('messages.lbl_please_choose') }}</option>
													@if(!empty($objArea) && count($objArea)>0)
														@foreach($objArea as $area)
															<option value="{{ $area->id }}" @isset($objSeekAds) {{ ($area->id==$objSeekAds->location)?'selected="selected"':'' }} @endisset > {{ $area->name }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>

										<div class="row">
											<!-- Max rent -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_max_rent') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="maxRent" value="@isset($objSeekAds){{ $objSeekAds->maxRent }}@endisset">
											</div>
										</div>

										<div class="row">
											<!-- Min area -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_min_area') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="minArea" value="@isset($objSeekAds){{ $objSeekAds->minArea }}@endisset">
											</div>
										</div>

										<div class="row">
											<!-- Min rooms -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_min_rooms') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												<input type="number" class="form-control" name="minRooms" value="@isset($objSeekAds){{ $objSeekAds->minRooms }}@endisset">
											</div>
										</div>

										<div class="row">
											<!-- Min area -->
											<div class="col-sm-2">
												<label><strong>{{ __('messages.lbl_property_type') }}:</strong></label>
											</div>
											<div class="col-sm-6">
												@isset($objSeekAds)
												<label class="radio-inline">
													<input type="radio" name="type" {{ ($objSeekAds->type == 'apartment')?'checked="checked"':'' }} value="apartment" required> {{ __('messages.postapartment') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" {{ ($objSeekAds->type == 'room')?'checked="checked"':'' }} value="room" required > {{ __('messages.postroom') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" {{ ($objSeekAds->type == 'house')?'checked="checked"':'' }} value="house" required> {{ __('messages.posthouse') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" {{ ($objSeekAds->type == 'villa')?'checked="checked"':'' }} value="villa" required> {{ __('messages.post_villa') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" {{ ($objSeekAds->type == 'holiday')?'checked="checked"':'' }} value="holiday" required> {{ __('messages.postholiday') }}
												</label>
												@else
												<label class="radio-inline">
													<input type="radio" name="type" value="apartment" required> {{ __('messages.postapartment') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" value="room" required > {{ __('messages.postroom') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" value="house" required> {{ __('messages.posthouse') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" value="villa" required> {{ __('messages.post_villa') }}
												</label>
												<label class="radio-inline">
													<input type="radio" name="type" value="holiday" required> {{ __('messages.postholiday') }}
												</label>
												@endisset
											</div>
											<br/><br/>
										</div>

										<div class="row">
											<div class="col-sm-2">
												<label><strong>{{ __('messages.rentalperiod') }} :</strong></label>
											</div>
											<div class="col-sm-6">
												@isset($objSeekAds)
												<label class="radio-inline">
													<input type="radio" name="period" {{ ($objSeekAds->rentalPeriod == 'unlimited')?'checked="checked"':'' }} value="unlimited" required> {{ __('messages.lbl_unlimited') }}
												</label>

												<label class="radio-inline">
													<input type="radio" name="period" {{ ($objSeekAds->rentalPeriod == 'More than 12 months')?'checked="checked"':'' }} value="More than 12 months" required> {{ __('messages.lbl_more_than_12_months') }}
												</label>

												<label class="radio-inline">
													<input type="radio" name="period" {{ ($objSeekAds->rentalPeriod == 'Less than 12 months')?'checked="checked"':'' }} value="Less than 12 months" required> {{ __('messages.lbl_less_than_12_months') }}
												</label>
												@else

												<label class="radio-inline">
													<input type="radio" name="period" value="unlimited" required> {{ __('messages.lbl_unlimited') }}
												</label>

												<label class="radio-inline">
													<input type="radio" name="period" value="More than 12 months" required> {{ __('messages.lbl_more_than_12_months') }}
												</label>

												<label class="radio-inline">
													<input type="radio" name="period" value="Less than 12 months" required> {{ __('messages.lbl_less_than_12_months') }}
												</label>

												@endisset
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a class="panel-heading accordion-toggle"  data-toggle="collapse" data-parent="#accordion" href="#collapseFour">{{ __('messages.lbl_choose_files') }}</a>
							      	</h3>
								</div>
								<div id="collapseFour" class="panel-collapse collapse in">
									<div class="panel-body">
										<input type="file" id="files" class="upload" name="files[]" multiple="multiple" accept="image/*" />
									</div>
								</div>
							</div>

							@isset($objSeekAds) <input type="hidden" name="id" value="{{ $objSeekAds->id }}" />
							<input type="submit" style="font-weight:bold;" class="btn btn-warning" name="submit" value="Opdatering"> @else
							<input type="submit" style="font-weight:bold;" class="btn btn-primary" name="submit" value="{{ __('messages.lbl_post_requirements') }}"> @endisset <br><br>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/datepickr.js') }}"></script>
@endsection
