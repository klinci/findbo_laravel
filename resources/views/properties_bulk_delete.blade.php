@extends('layout.index')
@section('pageTitle','Bulk Deletes')

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
					<h1 class="page-title">Bulk Deletes</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('home') }}">
								@lang('messages.lbl_home')
							</a>
						</li>
						<li>Bulk Deletes</li>
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

					<center>
						<h3><b>PROPERTIES BULK DELETES</b></h3>
					</center>
					<br>

					{{-- row --}}
					<div class="row">
						<form class="deleteForm">

							{{-- col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="alert alert-danger">
									<span class="glyphicon glyphicon-exclamation-sign"></span>
									Be Careful using this feature!
								</div>
							</div>
							{{-- ./ col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}

							{{-- col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 messageDeleted"></div>
							{{-- ./ col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}

							{{-- col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<button type="button" class="btn btn-primary deleteButton">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</div>
							</div>
							{{-- ./ col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}

							{{-- col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="dateFrom">Date From</label>
									<input type="date" name="dateFrom" id="dateFrom" class="form-control">
								</div>
							</div>
							{{-- ./ col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}

							{{-- col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="dateEnd">Date End</label>
									<input type="date" name="dateEnd" id="dateEnd" class="form-control">
								</div>
							</div>
							{{-- ./ col-md-6 col-lg-6 col-sm-12 col-xs-12 --}}

						</form>
					</div>
					{{-- ./row --}}

				</div>
				{{-- ./ main col-sm-12 mainpbt --}}

			</div>
			{{-- ./ row --}}
		</div>
		{{-- ./ container --}}
	</div>
	{{-- ./ content --}}

@endsection

@section('scripts')
	<script type="text/javascript">

		var deleteButton = jQuery('.deleteButton');

		jQuery(document.body).on('click','.deleteButton', function() {
			jQuery.ajax({
				url : "{{ route('properties.bulk.post') }}",
				method : "post",
				headers : {
					'X-CSRF-TOKEN' : "{{ csrf_token() }}"
				},
				dataType : "json",
				data : 'dateFrom=' + jQuery('#dateFrom').val() + '&dateEnd=' + jQuery('#dateEnd').val(),
				beforeSend : function() {
					deleteButton.attr('disabled','disabled');
					deleteButton.html('Loading...');
					return jQuery('.messageDeleted').html(`
						<div class="alert alert-danger">
							Dont refresh this page!
						</div>
					`);
				},
				success : function(res) {
					deleteButton.removeAttr('disabled');
					deleteButton.html('<span class="glyphicon glyphicon-trash"></span>');
					if(res.error == 0) {
						return jQuery('.messageDeleted').html(`
							<div class="alert alert-success">
								`+ res.message +`
							</div>
						`);
					} else {
						return jQuery('.messageDeleted').html(`
							<div class="alert alert-danger">
								`+ res.message +`
							</div>
						`);
					}
				},
				error : function() {
					deleteButton.removeAttr('disabled');
					deleteButton.html('<span class="glyphicon glyphicon-trash"></span>');
					return jQuery('.messageDeleted').html(`
						<div class="alert alert-danger">
							Bulk delete is error.
						</div>
					`);
				}
			});
		});
	</script>
@endsection