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
	{{-- <div id="contacts_map"></div> --}}
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2248.595804275932!2d9.521014015392932!3d55.696013580538164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x464c82f9e6e17d45%3A0xaa32ac815e12f68f!2sPedersholms+All%C3%A9+13%2C+7100+Vejle%2C+Denmark!5e0!3m2!1sid!2sid!4v1552754713897" id="contacts_map" frameborder="0" style="border:0" allowfullscreen></iframe>
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
				@if(session()->has('messages.level'))
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-{{ session('messages.level') }}"> 
						    {!! session('messages.content') !!}
						    </div>
						</div>
					</div>
				@endif
	
				<h2 class="section-title">{{ __('messages.contactus') }}</h2>
				<?php /*if($status_msg) { ?>
				<h4 class="text-center successMsg"><?php echo $lang['msgSent']; ?></h4>
				<h4 class="text-center successMsg"><?php echo $lang['supportMsg']; ?></h4>
				<?php }*/ ?>
				
				<form action="{{ route('submit_contact') }}" method="post" name="frmContactUs" id="frmContactUs">		
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
				required: "@lang('messages.required_contact_name_error_label')"
			},
			"contactEmail": {
				required: "@lang('messages.required_contact_email_error_label')",
				email: "@lang('messages.required_contact_email_error_label')"
			},
			"contactSubject": {
				required: "@lang('messages.required_contact_subject_error_label')"
			},
			"contactMessage": {
				required: "@lang('messages.required_contact_message_error_label')"
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
		"description": "Pedersholms Álle 13, 7100 Vejle <br> Phone: 0045 4082 0577",
		"map_marker_icon": "{{ asset('pulic/images/markers/green-marker-house.png') }}"
	}
];

(function ($) {
	"use strict";
	$(document).ready(function () {
    	//Create contacts map. Usage: Cozy.contactsMap(marker_JSON_Object, map canvas, map zoom);
		// Cozy.contactsMap(singleMarker, 'contacts_map', 12);
	});
})(jQuery);
</script>
@endsection