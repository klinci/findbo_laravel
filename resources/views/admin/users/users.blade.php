@extends('admin.layout.index')

@section('pageTitle', 'Users')

@section('styles')
<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.core.css') }}"> 
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.datepicker.css') }}"> 
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.theme.css') }}">

<style type="text/css">
td > span.landlord_bg, .label-landlord {
    background-color: #a1d2dd;
}
td > span.seeker_bg, .label-seeker {
    background-color: #bcebe3;
    height: 30px;
}
.username {
	padding: 0px;
}
</style>
@endsection

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Users</h3>
			</div>
			
			<div class="x_panel">
				<div class="row">
					<div class="col-md-12  col-sm-12 ptp10">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
						
						<form class="form-horizontal" name="frmProperty" id="frmProperty" method="get" action="{{ url('admin/users/index')}}">
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">User Type</label>
								<div class="col-sm-7 col-md-3">
									<select name="accType" id="accType" class="form-control">
										<option {{ ($userType=='')?' selected="selected"':''}} value="">Select User Type</option>
										<option {{ ($userType=='1')?' selected="selected"':''}} value="1">Landlord</option>
										<option {{ ($userType=='2')?' selected="selected"':''}} value="2">House Seeker</option>
									</select>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Search By Email, Name OR Phone Number</label>
								<div class="col-sm-7 col-md-3">
									<input type="text" name="txtKeyword" id="txtKeyword" value="{{ $keyword }}" class="form-control" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Reg. Date From</label>
								<div class="col-sm-7 col-md-3">
									<input type="text" name="txtFromDate" id="txtFromDate" value="{{ $fromDate }}" class="form-control" readonly />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Reg. Date To</label>
								<div class="col-sm-7 col-md-3">
									<input type="text" name="txtToDate" id="txtToDate" value="{{ $toDate }}" class="form-control" readonly />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Status</label>
								<div class="col-sm-7 col-md-3">
									<select name="cmbStatus" id="cmbStatus" class="form-control">
										<option {{ ($status=='0')?' selected="selected"':''}} value="">Status - All</option>
		                            	<option {{ ($status=='1')?' selected="selected"':''}} value="1">Inactive</option>
		                            	<option {{ ($status=='2')?' selected="selected"':''}} value="2">Active</option>
		                            	<option {{ ($status=='3')?' selected="selected"':''}} value="3">Ban</option>
		                            	<option {{ ($status=='4')?' selected="selected"':''}} value="4">Admin</option>
									</select>
								</div>
							</div>
							
							<div class="item form-group">
								<div class="col-sm-offset-5 col-md-offset-5 col-sm-7 col-md-8">
									<button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success">Submit</button>
									<button type="reset" name="btnClear" id="btnClear" class="btn btn-primary">Clear</button>
								</div>
							</div>
							
						</form>
					</div>
					
					<div class="clearfix"></div>
					
					<div class="col-md-12  col-sm-12 ptp10">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td class="nopaddingtd">
										<table id="example" class="table table-striped responsive-utilities jambo_table">
											<thead>
												<tr class="headings">
													<th>Account Type</th>
													<th>Full Name</th>
													<th>Email</th>
													<th>Phone Number</th>
													<th>Date Registered</th>
													<th>Status</th>
													<th>Active Package</th>
													<th style="width: 130px;">Actions</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Dashboard End -->
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/admin/js/datepicker/jquery.ui.core.js') }}"></script>
<script src="{{ asset('public/admin/js/datepicker/jquery.ui.datepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/admin/css/datatable_1_10/datatables.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {

	$("#btnClear").click(function(){
		window.location.href="{{ url('admin/users/index') }}";
	});

	$( "#txtFromDate" ).datepicker({
	    changeMonth: true,
	    changeYear: true,
		onSelect: function(dateText) {
			$("#txtToDate").val($( "#txtFromDate" ).val());
	        $("#txtToDate").datepicker("option","minDate", dateText);
		}
	});

	$( "#txtToDate" ).datepicker({
	    changeMonth: true,
	    changeYear: true
	});

	
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                 "url": "{{ url('/admin/users/ajaxusers') }}",
                 "dataType": "json",
                 "type": "POST",
                 "data":{ _token: "{{csrf_token()}}", "userType": "{{ $userType }}", "keyword": "{{ $keyword }}", "fromDate": "{{$fromDate}}", "toDate": "{{ $toDate }}", "status": "{{ $status }}" }
		},
		"searching" : false,
		"aLengthMenu": [ [20, 50, 100], [20, 50, 100] ],
		"iDisplayLength": 20,
        "columns": [
			{ "data": "account_type",orderable: false},
            { "data": "full_name",orderable: false},
            { "data": "email",orderable: false },
            { "data": "phone_number",orderable: false },
            { "data": "date_registered",orderable: false },
            { "data": "status",orderable: false },
            { "data": "active_package",orderable: false },
            { "data": "action",orderable: false }
        ]
    });
});
</script>
@endsection