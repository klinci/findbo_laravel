@extends('layout.index')

@section('pageTitle', __('messages.title_package'))

@section('meta_tags')
<meta name="keywords" content="{{ __('messages.meta_keyword_package') }}"> 
<meta name="description" content="{{ __('messages.meta_desc_package') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ ($active_pack_id>0)?__('messages.lbl_active_package'):__('messages.postPackageselect') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="index.php">{{ __('messages.lbl_home') }} </a></li>
					<li>{{ ($active_pack_id>0)?__('messages.lbl_active_package'):__('messages.postPackageselect') }}</li>
				</ul>
						
						
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
			<div class="main col-sm-12 section-about mainpbt">
				
				@if(session()->has('message.level'))
					<div class="col-md-12">
						<div class="alert alert-{{ session('message.level') }}"> 
					    {!! session('message.content') !!}
					    </div>
					</div>
				@endif
			
				@if($active_pack_id==0)
					<h1 class="animate-from-top animation-from-top" data-animation-delay="50" data-animation-direction="from-top">{{ __('messages.lbl_seeker_packages_msg_header') }}</h1>
					<p class="section-about animate-from-top animation-from-top" data-animation-delay="50" data-animation-direction="from-top">
						{{ __('messages.lbl_seeker_packages_msg_1') }}
					</p>
				@elseif($active_pack_id==1)
					<h3 data-animation-delay="50" data-animation-direction="from-top" class="animate-from-top animation-from-top">
						{{ __('messages.lbl_dear') }} <a href="javascript:void(0);">{{ (Auth::check())?Auth::user()->fname:'' }}</a>, {{ __('messages.lbl_seeker_packages_msg_2') }} "{{ __('messages.seeker_green_package_name') }}"
					</h3>
					<p class="section-about animate-from-top animation-from-top" data-animation-delay="50" data-animation-direction="from-top">
						{{ __('messages.lbl_seeker_packages_msg_3') .' "'. __('messages.seeker_blue_package_name').'" '. __('messages.lbl_seeker_packages_msg_4') }}<br/>
						{{ __('messages.lbl_seeker_packages_msg_5')." $remaining_days ". __('messages.lbl_days')." ". __('messages.lbl_seeker_packages_msg_6') }}
					</p>
				@elseif($active_pack_id==2)
					<h3 data-animation-delay="50" data-animation-direction="from-top" class="animate-from-top animation-from-top">
						{{ __('messages.lbl_dear') }} <a href="javascript:void(0);">{{ (Auth::check())?Auth::user()->fname:'' }}</a>, {{ __('messages.lbl_seeker_packages_msg_2')}} "{{ __('messages.seeker_blue_package_name') }}"
					</h3>
					<p class="section-about animate-from-top animation-from-top" data-animation-delay="50" data-animation-direction="from-top">
						{{ __('messages.lbl_seeker_packages_msg_5')." $remaining_days ".__('messages.lbl_days')." ".__('messages.lbl_seeker_packages_msg_6') }}
					</p>
				@endif

				@if (Auth::check() && $active_pack_id != 0)

					<!-- AUTO-RENEW CONTROL -->

					<form id="form3" action="{{ route('package_auto_renew') }}" method="post" class="center row">
						{{ csrf_field() }}
						<div class="item col-sm-offset-1 col-sm-10" style="border: 1px solid #e3e3e3; border-radius: 4px; padding: 5px; margin-bottom: 40px;">	
							<input type="hidden" name="autorenew" value="{{ Auth::user()->auto_renew_seek_package == 1 ? 0 : 1 }}" />
							<input type="submit" class="btn btn-{{ Auth::user()->auto_renew_seek_package == 1 ? 'danger' : 'success' }}"
									value="{{ Auth::user()->auto_renew_seek_package == 1 ? __('messages.lbl_disable_auto_renewal') : __('messages.lbl_enable_auto_renewal') }}" style="text-transform:uppercase;">
						</div>
					</form>

					<!-- AUTO-RENEW CONTROL ENDS -->

				@endif


				


				<form id="form2" action="{{ route('purchase_package') }}" method="post" class="row">
					{{ csrf_field() }}
					<div class="pricing" style="margin-top: 50px;">
						<div class="col-sm-1">
							<input type="hidden" id="pk_rGroup" name="rGroup" value="1" />
						</div>
						
						<div class="item col-sm-5 green_pk col-md-6 col-md-offset-2">
							<div id="pk_1" class="priceDiV {{ ($active_pack_id == 2)?'selected':'' }}">



								<header>
									@if($active_pack_id == 0)
										<h2>{{ __('messages.seeker_green_package_name') }}</h2>
										<div class="price">{{ $objGreenSeekPackages->price }} Kr.
											<small>({{ $objGreenSeekPackages->duration .' '.__('messages.lbl_days') }})</small>
										</div>
									@else
										<h2>{{ __('messages.seeker_blue_package_name') }}</h2>
										<div class="price">{{ $objBlueSeekPackages->price }} Kr.
											<small>({{ $objBlueSeekPackages->duration .' '.__('messages.lbl_days') }})</small>
										</div>
									@endif
								</header>



								<ul>
									<li>{{ __('messages.lbl_seeker_packages_feature_1') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_2') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_2_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_3') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_3_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_4') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_5') }}</li>
									<li class="disabled">{{ __('messages.lbl_seeker_packages_feature_6') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_6_1') }}" ></i></li>
									
									@if(Auth::check())
										<li class="payNowWaitBtnsSec" style="min-height: 70px; display: none;">
											<img id="payNowWaitBtn_1" class="payNowWaitBtns" src="images/loader.gif" alt="..." style="display: none; width: 25px; margin: 0px;" />
										</li>
										<button type="button" class="payNowBtns btn btn-default-color" 

										@if($active_pack_id == 2 && $remaining_days > 1) disabled="disabled"
										@else
											@if($active_pack_id == 0) onclick="javascript:getGreenPackage();"
											@elseif($active_pack_id == 1) onclick="javascript:getBluePackage();"
											@endif
										@endif >


											@if($active_pack_id == 2)
												{{ __('messages.lbl_activated') }}
											@else
												{{ __('messages.lbl_select') }}
											@endif


										</button>
									@endif

								</ul>
							</div>
						</div>
					</div>
					
					@if(Auth::check())
						@isset($property_id) <input type="hidden" name="property_id" value="{{ $property_id }}" /> @endisset
						<input type="hidden" id="stripeToken" name="stripeToken" value="" />
						<input type="hidden" id="u_id" name="u_id" value="{{ Auth::user()->id }}" />
						<input type="hidden" id="selected_pack" name="selected_pack" value="{{ ($active_pack_id == 1)?'2':'1' }}" />
						<input type="hidden" id="packageName" name="packageName"
								value="{{ ($active_pack_id == 1)?__('messages.seeker_green_package_name'):__('messages.seeker_blue_package_name') }}" />
						<input type="hidden" id="packageAmount" name="packageAmount"
								value="{{ ($active_pack_id == 1) ? $objGreenSeekPackages->price:$objBlueSeekPackages->price }}" />
					@endif
				</form>








				<script src="https://checkout.stripe.com/checkout.js"></script>
				
				<script type="text/javascript">
					var handler;
					handler = StripeCheckout.configure({
							  key: '{{ $stripe_key }}',
							  image: "{{ asset('public/images/findbo-home.png') }}",	
							  currency: 'DKK',
							  panelLabel: "{{ __('messages.pay') }} ",
							  token: function(token){
							   $('#stripeToken').val(token.id);
							   setTimeout(function(){ $('#form2').submit(); }, 1000);
						  	},
				  			  closed: onCheckoutClose		  
					});
 
					// Close Checkout on page navigation
					$(window).on('popstate', function() {
					  handler.close();
					});

					function changeAutoRenewOption()
					{
						$("#form3").submit();
					}

					function onCheckoutClose()
					{
						$(".payNowWaitBtnsSec").hide();
						$(".payNowWaitBtns").hide();
						$(".payNowBtns").show();
					}
					
					function purchase(id)
					{
						$("#mainErrorMsgDiv").remove();
						$(".payNowBtns").hide();
						$(".payNowWaitBtnsSec").show();
						$("#payNowWaitBtn_"+id).show();
						
					     //Open Checkout with further options
					    handler.open({
								      name: 'FindBo',
								      description: $("#packageName").val(),
								      amount: parseFloat($("#packageAmount").val() * 100)
								    });
					}
					
					function getBluePackage()
					{
						$("#selected_pack").val('2');
						$("#packageName").val("{{ __('messages.seeker_blue_package_name') }}");
						$("#packageAmount").val("{{ $objBlueSeekPackages->price }}");

						purchase('2');
					}
					
					function getGreenPackage()
					{
						$("#selected_pack").val('1');
						$("#packageName").val("{{ __('messages.seeker_green_package_name') }}");
						$("#packageAmount").val("{{ $objGreenSeekPackages->price }}");

						purchase('1');
					}
				</script>
				
				<div class="col-sm-10 center section-about">
					<div class="animate-from-left animation-from-left" data-animation-delay="50" data-animation-direction="from-left">{{ __('messages.lbl_seeker_packages_msg_11') }}</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="greenPackConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="text-center">{{ __("messages.lbl_seeker_packages_msg_10") }}</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default-color" onclick="javascript:submitGreenPackage();">{{ __('messages.yes') }}</button>
		        <button type="button" class="btn btn-default-color" data-dismiss="modal">{{ __('messages.no') }}</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="bluePackConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="text-center">{{ __("messages.lbl_seeker_packages_msg_14") }}</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default-color" onclick="javascript:submitBluePackage();">{{ __("messages.yes") }}</button>
		        <button type="button" class="btn btn-default-color" data-dismiss="modal">{{ __("messages.no") }}</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		
		
	</div>
</div>

<script src="{{ asset('public/js/tipso/src/tipso.js') }}"></script>
<script type="text/javascript">
	(function($){
		"use strict";
		
		$(document).ready(function()
		{
			$('.tipso').tipso();
		});

	})(jQuery);

	function submitGreenPackage()
	{
		$('#greenPackConfirmModal').modal('hide');
		$('#form2').submit();
	}

	function submitBluePackage()
	{
		$('#bluePackConfirmModal').modal('hide');
		$('#form2').submit();
	}
</script>
@endsection