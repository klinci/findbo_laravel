@extends('layout.index')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row green" style="padding-top:70px; padding-bottom:30px; border-bottom:solid 1px #ccc;">
	        <div class="main col-sm-12 mainpbt" style="text-align:center; font-weight:bold;">
	          <h3> <b> {{ __('messages.propertyaddedplswait') }} </b></h3>
	          <br/>
	          <h1> <i class="fa fa-lg fa-spinner fa-spin"></i></h1>
	        </div>
	      </div>
	</div>
</div>
<?php 
sleep(2);
?>
<script type="text/javascript">
window.location.href="{{ route('myads') }}";
</script>
@endsection