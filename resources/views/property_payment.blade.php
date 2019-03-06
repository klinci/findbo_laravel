
@extends('layout.index')

@section('pageTitle', 'Opret annonce')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.selectedpackage') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="index.php">{{ __('messages.lbl_home') }} </a></li>
					<li>{{ __('messages.selectedpackage') }}</li>
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
			
				<div class="pricing">
					<form id="form2" action="{{ url('purchase_property') }}" method="post">
						
						
						<input type="hidden" id="prop_id" name="prop_id" value="{{ $id }}" />
						<input type="hidden" id="selected_pack" name="selected_pack" value="{{ $pid }}" />
						<input type="hidden" id="stripeToken" name="stripeToken" value="" />
						<input type="hidden" id="packageName" name="packageName" value="{{ ($pid==2)?__('messages.postGreen'):__('messages.postBlue') }}" />
						<input type="hidden" id="packageAmount" name="packageAmount" value="{{ ($pid==2)?$objGreenPackages->price:$objBluePackages->price }}" />
						
						<div class="item col-sm-4">
							
							<div id="pk_1" class="priceDiV {{ ($pid == 1)?'selected':'' }}">
								<header>
									<h2>{{ __('messages.postStandart') }}</h2>
									<div class="price">
										{{ __('messages.postFree') }} <small>&nbsp;</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postFreeweb') }}</li>
									<li class="payNowWaitBtnsSec" style="min-height: 75px; display: none;">
										<img id="payNowWaitBtn_1" class="payNowWaitBtns" src="{{ asset('public/images/loader.gif') }}" alt="..." style="display: none;" />
									</li>
									<a href="javascript:void(0);" style="font-size: 18px;font-weight: bold;" onclick="javascript:getStandardPackage();" class="btn btn-default-color payNowBtns saveproceed">{{ __('messages.postFree') }}</a>
								</ul>
							</div>
						</div>
						
						<div class="item col-sm-4 green_pk">
							<div id="pk_2" class="priceDiV {{ ($pid == 2)?'selected':'' }}">
								<header>
									<h2>{{ __('messages.postGreen') }}</h2>
									<div class="price">
										Kr.{{ $objGreenPackages->price }} <small>{{ __('messages.postSeven') }}</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postSevendays') }}</li>
									<li class="payNowWaitBtnsSec" style="min-height: 75px; display: none;">
										<img id="payNowWaitBtn_2" class="payNowWaitBtns" src="{{ asset('public/images/loader.gif') }}" alt="..." style="display: none;" />
									</li>
									<a href="javascript:void(0);" style="font-size: 18px;font-weight: bold;" onclick="javascript:getGreenPackage();" class="btn btn-default-color payNowBtns saveproceed">{{ __('messages.pay') }}</a>
								</ul>
							</div>
						</div>
						
						<div class="item col-sm-4 blue_pk">
							<div id="pk_3" class="priceDiV {{ ($pid == 3)?'selected':'' }}">
								<header>
									<h2>{{ __('messages.postBlue') }}</h2>
									<div class="price">
										Kr.{{ $objBluePackages->price }} <small>{{ __('messages.postSeven') }}</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postSevendaysBlue') }}</li>
									<li class="payNowWaitBtnsSec" style="min-height: 75px; display: none;">
										<img id="payNowWaitBtn_3" class="payNowWaitBtns" src="{{ asset('public/images/loader.gif') }}" alt="..." style="display: none;" />	
									</li>
									<a href="javascript:void(0);" style="font-size: 18px;font-weight: bold;" onclick="javascript:getBluePackage();" class="btn btn-default-color payNowBtns saveproceed">{{ __('messages.pay') }}</a>
								</ul>
							</div>
						</div>
						
					</form>
				</div>
				
				<script src="https://checkout.stripe.com/checkout.js"></script>
				<script type="text/javascript">
        			var handler;
					handler = StripeCheckout.configure({
							key: 'pk_live_oKjHVwZ3sTnKvJv83LZc7Qhn',
							  image: "{{ asset('public/images2/findbo-home.png') }}",
							  currency: 'DKK',
							  panelLabel: "{{ __('messages.pay') }}",
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
						$(".priceDiV").removeClass("selected");
						$("#pk_3").addClass("selected");
						
						$("#selected_pack").val('3');
						$("#packageName").val("{{ __('messages.postBlue') }}");
						$("#packageAmount").val('{{ $objBluePackages->price }}');

						purchase('3');
					}
					
					function getGreenPackage()
					{
						$(".priceDiV").removeClass("selected");
						$("#pk_2").addClass("selected");
						
						$("#selected_pack").val('2');
						$("#packageName").val("{{ __('messages.postGreen') }}");
						$("#packageAmount").val('{{ $objGreenPackages->price }}');

						purchase('2');
					}

					function getStandardPackage()
					{
						window.location.href = "{{ url('redirect') }}"
					}	
        		</script>
        		
			</div>	
		</div>
	</div>
</div>
@endsection