@extends('admin.layout.index')

@section('pageTitle', 'Add Rental Period')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Add Rental Period</h3>
			</div>
			
			<div class="x_panel">
				<div class="row">
					<div class="col-md-12  col-sm-12 ptp10">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
					</div>
					
					<div class="clearfix"></div>
					
					<div class="col-md-12  col-sm-12 ptp10">
						
						<form class="form-horizontal form-label-left" name="frmRentalPeriod" id="frmRentalPeriod" action="{{ url('admin/rental_period/store') }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Rental Name <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="rental_name" name="rental_name" class="form-control" type="text" value="" />
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-4">
									<button id="btnRetalPeriod" name="btnRetalPeriod" type="submit" class="btn btn-success">Submit</button>
									<button id="btnRetalPeriodCancel" name="btnRetalPeriodCancel" type="button" class="btn btn-primary" onclick="location.href='{{ url('admin/rental_period/index')}}'">Cancel</button>
								</div>
							</div>
											
						</form>
					
					
					</div>
				</div>
			</div>
		</div>
		<!-- Dashboard End -->
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/admin/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
	$("#frmRentalPeriod").validate({
		rules: {
			"rental_name": {
				required: true
			}
		},
		messages: {
			"rental_name": {
				required: "Please enter rental name."
			}
		}
	});
});
</script>
@endsection