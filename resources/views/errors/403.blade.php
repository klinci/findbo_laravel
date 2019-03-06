@extends('layout.index')

@section('pageTitle', 'Boligen er desværre udlejet')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">403 : Unauthorized</h1>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row">
		
			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-12 mainpbt">
			
				<h1>Sorry, you are not authorized to visit this page.</h1>
				
			</div>	
			<!-- END MAIN CONTENT -->

		</div>
	</div>
</div>

<script src="{{ asset('public/js/tipso/src/tipso.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.tipso').tipso();
	});
</script>
@endsection