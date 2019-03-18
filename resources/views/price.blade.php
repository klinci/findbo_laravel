@extends('layout.index')

@section('pageTitle', __('messages.title_how_it_works'))

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.lbl_pricing') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ route('home')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.lbl_pricing_tables') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
			<div class="min col-sm-12 mainpbt">
	
				<div class="row">
				
					<!-- BEGIN MAIN CONTENT -->
					<div class="main col-sm-12" style="padding-top: 0px; padding-bottom: 0px;">
						
						<h1 class="section-title" >Udlejers og Sælgers Pakke</h1>
						<p class="center" data-animation-direction="from-bottom" data-animation-delay="150">Som udlejer eller sælger kan du altid placere din bolig gratis på findbo.dk.
							Vi tilbyder to fantastiske pakker med ekstra fordele til dig, der sikrer, at din bolig bliver set af så mange som muligt.
							Ved at vælge den Grønne pakke,får du en topplacering på søgelisten og der vil blive sendt en nyhedsmail til alle boligsøgende i løbet af ugen. 
							Den Blå pakke indeholder den grønne pakke, og samtidig får du annonceplads på forsiden hele ugen.
							Findbo.dk har de laveste priser på markedet. 
						</p>
						
						<!-- BEGIN PRICING TABLES -->
						<div class="pricing">
						
							<div class="item col-sm-4">
								<header>
									<h2>{{ __('messages.postStandart') }}</h2>
									<div class="price">
										{{ __('messages.postFree') }}<small>&nbsp;</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postFreeweb') }}</li>
								</ul>
							</div>
							
							<div class="item col-sm-4">
								<header>
									<h2>{{ __('messages.postGreen') }}</h2>
									<div class="price">
										Kr.89<small>{{ __('messages.postSeven') }}</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postSevendays') }}</li>
								</ul>
							</div>
							
							<div class="item col-sm-4">
								<header>
									<h2>{{ __('messages.postBlue') }}</h2>
									<div class="price">
										Kr.129<small>{{ __('messages.postSeven') }}</small>
									</div>
								</header>
								<ul>
									<li style="min-height: 75px;">{{ __('messages.postSevendaysBlue') }}</li>
								</ul>
							</div>
						</div>
						<!-- END PRICING TABLES -->
						
					</div>	
					<!-- END MAIN CONTENT -->
					
				</div>
				<div class="row">
				
					<!-- BEGIN MAIN CONTENT -->
					<div class="col-sm-12" style="padding-top: 0px;">
						
						<h1 style="margin-top: 25px;" class="section-title">Boligsøgendes Pakke</h1>
						<p class="center">{{ __('messages.lbl_seeker_packages_msg_1') }}</p>
						
						<!-- BEGIN PRICING TABLES -->
						<div class="pricing">
							<div class="item col-sm-6">
								<header>
									<h2>{{ __('messages.seeker_green_package_name') }}</h2>
									<div class="price">
										Kr.{{ $green_pack_info->price }}<small>({{ $green_pack_info->duration.' '.__('messages.lbl_days') }})</small>
										<!--{{ __('messages.postFree') }}<small>&nbsp;</small>-->
									</div>
								</header>
								<ul>
									<li>{{ __('messages.lbl_seeker_packages_feature_1') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_2') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_2_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_3') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_3_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_4') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_5') }}</li>
									<li class="disabled">{{ __('messages.lbl_seeker_packages_feature_6') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_6_1') }}"></i></li>
								</ul>
							</div>
							
							<div class="item col-sm-6">
								<header>
									<h2>{{ __('messages.seeker_blue_package_name') }}</h2>
									<div class="price">
										Kr.{{ $blue_pack_info->price }}<small>({{ $blue_pack_info->duration.' '.__('messages.lbl_days') }})</small>
									</div>
								</header>
								<ul>
									<li>{{ __('messages.lbl_seeker_packages_feature_1') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_2') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_2_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_3') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_3_1') }}"></i></li>
									<li>{{ __('messages.lbl_seeker_packages_feature_4') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_5') }}</li>
									<li>{{ __('messages.lbl_seeker_packages_feature_6') }}<i class="fa fa-question-circle tipso" title="{{ __('messages.lbl_seeker_packages_feature_6_1') }}"></i></li>
								</ul>
							</div>
						</div>
						<!-- END PRICING TABLES -->
						
					</div>	
					<!-- END MAIN CONTENT -->
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection