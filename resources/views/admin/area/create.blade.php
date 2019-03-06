@extends('admin.layout.index')

@section('pageTitle', 'Add Area')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Add Area</h3>
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
						
						<form class="form-horizontal form-label-left" name="frmArea" id="frmArea" action="{{ url('admin/area/store') }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Area Name <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="name" name="name" class="form-control" type="text" value="" />
								</div>
							</div>
							
							<span class="section">Each area has to have at least one city</span>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">City Name <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="city_name" name="city_name" class="form-control" type="text" value="" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">City ZIP Code <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="code" name="code" class="form-control" type="text" value="" />
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-4">
									<button id="btnArea" name="btnArea" type="submit" class="btn btn-success">Submit</button>
									<button id="btnArea" name="btnArea" type="button" class="btn btn-primary" onclick="location.href='{{ url('admin/area/index')}}'">Cancel</button>
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
	$("#frmArea").validate({
		rules: {
			"name": {
				required: true
			},
			"city_name": {
				required: true
			},
			"code": {
				required: true
			}
		},
		messages: {
			"name": {
				required: "Please enter area name."
			},
			"city_name": {
				required: "Please enter city name."
			},
			"code": {
				required: "Please enter city zipcode."
			}
		}
	});
});
</script>
@endsection