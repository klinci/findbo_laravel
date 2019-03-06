@extends('layout.index')

@section('pageTitle', 'Boligen er desværre udlejet')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Boligen ikke tilgængelig</h1>
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
			
				<p class="center" style="font-size: 15px;border: 1px solid #dcdcdc;padding: 30px;">
					Boligen er desværre udlejet
				</p>
				
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