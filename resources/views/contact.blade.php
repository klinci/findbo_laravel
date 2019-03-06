@extends('layout.index')

@section('pageTitle', __('messages.title_contact_us'))

@section('meta_tags')
<meta name="description" content="{{ __('messages.meta_desc_contact_us') }}"> 
<meta name="keywords" content="{{ __('messages.meta_keyword_contact_us') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.contactus') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.contactus') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content contacts">
	<div id="contacts_map"></div>
	
	<div class="container">
		
		<div class="row mainpbt">
		
		
		
			<div id="contacts-overlay" class="col-sm-7">
				<i id="contacts-overlay-close" class="fa fa-minus"></i>
				
				<ul class="col-sm-6">
					<li><i class="fa fa-map-marker"></i> {{ __('messages.contact_us_addr') }}</li>
					<li><i class="fa fa-envelope"></i> <a href="mailto:contact@findbo.dk">info@findbo.dk</a></li>
				</ul>
				
				<ul class="col-sm-6">
					<!--<li><i class="fa fa-phone"></i> Tlf.: 0045 4082 0577</li>-->
					<li><i class="fa fa-legal"></i> CVR nr.: 36041730</li>
				</ul>
			</div>
			
			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-4 col-sm-offset-8">
				@if(session()->has('message.level'))
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						</div>
					</div>
				@endif
	
				<h2 class="section-title">{{ __('messages.contactus') }}</h2>
				<?php /*if($status_msg) { ?>
				<h4 class="text-center successMsg"><?php echo $lang['msgSent']; ?></h4>
				<h4 class="text-center successMsg"><?php echo $lang['supportMsg']; ?></h4>
				<?php }*/ ?>
				
				<form action="{{ url('submit_contact') }}" method="post" name="frmContactUs" id="frmContactUs">		
					{{ csrf_field() }}			
					<div class="col-sm-12">
						<input type="text" id="contactName" name="contactName" placeholder="{{ __('messages.Name') }}" class="form-control fromName" />
						
						<input type="email" id="contactEmail" name="contactEmail" placeholder="{{ __('messages.emaill') }}" class="form-control fromEmail"  />
						
						<input type="text" id="contactSubject" name="contactSubject" placeholder="{{ __('messages.subject') }}" class="form-control subject" />
						
						<textarea id="contactMessage" name="contactMessage" placeholder="{{ __('messages.message') }}" class="form-control" rows="5"></textarea> 
					</div>
					
					<div class="center">
						<input type="submit" class="btn btn-default-color btn-lg" value="{{ __('messages.sendmsg') }}" name="contactSubmit" />
					</div>
				</form>
			</div>	
			<!-- END MAIN CONTENT -->

		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#frmContactUs").validate({
		rules: {
			"contactName": {
				required: true
			},
			"contactEmail": {
				required: true,
				email: true
			},
			"contactSubject": {
				required: true
			},
			"contactMessage": {
				required: true
			}
		},
		messages: {
			"contactName": {
				required: "Please enter name."
			},
			"contactEmail": {
				required: "Please enter email.",
				email: "Please enter valid email."
			},
			"contactSubject": {
				required: "Please enter subject."
			},
			"contactMessage": {
				required: "Please enter message."
			}
		}
	});
});


var singleMarker = [
	{
		"id": 0,
		"title": "Findbo",
		"latitude": 55.696014,
		"longitude": 9.523203,
		//"image": "http://placehold.it/700x603",
		"image": "{{ asset('public/images/logo.png') }}",
		"description": "Pedersholms �lle 13, 7100 Vejle <br> Phone: 0045 4082 0577",
		"map_marker_icon": "{{ asset('pulic/images/markers/green-marker-house.png') }}"
	}
];

(function ($) {
	"use strict";
	$(document).ready(function () {
    	//Create contacts map. Usage: Cozy.contactsMap(marker_JSON_Object, map canvas, map zoom);
		Cozy.contactsMap(singleMarker, 'contacts_map', 12);
	});
})(jQuery);
</script>
@endsection