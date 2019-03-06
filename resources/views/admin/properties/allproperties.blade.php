@extends('admin.layout.index')

@section('pageTitle', 'Properties')

@section('styles')
<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.core.css') }}"> 
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.datepicker.css') }}"> 
<link rel="stylesheet" href="{{ asset('public/admin/css/datepicker/jquery.ui.theme.css') }}">
@endsection

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Properties</h3>
			</div>
			
			<div class="x_panel">
				<div class="row">
					<div class="col-md-12  col-sm-12 ptp10">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
						
						<form class="form-horizontal" name="frmProperty" id="frmProperty" method="get" action="{{ url('admin/properties/allproperties')}}">
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Search By Headline, City OR Area</label>
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
		                            	<option {{ ($status=='1')?' selected="selected"':''}} value="1">Pending</option>
		                            	<option {{ ($status=='2')?' selected="selected"':''}} value="2">Approved</option>
		                            	<option {{ ($status=='3')?' selected="selected"':''}} value="3">Rejected</option>
		                            	<option {{ ($status=='4')?' selected="selected"':''}} value="4">Inactive</option>
									</select>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-sm-5 col-md-5 control-label" for="name">Sagsnummer</label>
								<div class="col-sm-7 col-md-3">
									<input type="text" name="txtPid" id="txtPid" value="{{ $propertyId }}" class="form-control" />
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
										<form method="post" action="{{ url('admin/properties/deleteproperties') }}" name="frmDelete" id="frmDelete">
											{{csrf_field()}}
											<input type="hidden" name="kw" value="{{ $keyword }}" />
											<input type="hidden" name="fd" value="{{ $fromDate }}" />
											<input type="hidden" name="td" value="{{ $toDate }}" />
											<input type="hidden" name="sts" value="{{ $status }}" />
											<input type="hidden" name="prt" value="{{ $propertyId }}" />
											
											<table id="example" class="table table-striped responsive-utilities jambo_table">
												<thead>
													<tr class="headings">
														<th style="text-align: center;width: 50px;"><input type="checkbox" name="chkAll" id="chkAll" /></th>
														<th>Property ID</th>
														<th>Property Name</th>
														<th style="width: 130px;">Imported From</th>
														<th>Owner</th>
														<th>Date Added</th>
														<th>Inactivate/Activate</th>
														<th style="width: 130px;">Actions</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="8" style="text-align: left;"><button name="btnDelete" id="btnDelete" class="btn btn-primary">Delete</button></td>
													</tr>
												</tfoot>
											</table>
										</form>
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
		window.location.href="{{ url('admin/properties/allproperties') }}";
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
                 "url": "{{ url('/admin/properties/ajaxallproperties') }}",
                 "dataType": "json",
                 "type": "POST",
                 "data":{ _token: "{{csrf_token()}}", "keyword": "{{ $keyword }}", "fromDate": "{{$fromDate}}", "toDate": "{{ $toDate }}", "status": "{{ $status }}", "pid": "{{ $propertyId }}"}
		},
		"searching" : false,
		"aLengthMenu": [ [20, 50, 100], [20, 50, 100] ],
		"iDisplayLength": 20,
        "columns": [
			{ "data": "checkboxes",orderable: false,"sClass": "text-center" },
            { "data": "property_id",orderable: false },
            { "data": "property_name",orderable: false },
            { "data": "imported_from",orderable: false },
            { "data": "owner",orderable: false },
            { "data": "date_added",orderable: false },
            { "data": "inactivate_activate",orderable: false },
            { "data": "action",orderable: false }
        ]
    });

    $("#btnDelete").click(function(){
		if(!$(".chkProperties").is(":checked"))
		{
			alert("Please check atleast one checkbox to delete.");
			return false;
		}
	});

    $("#chkAll").click(function(){
		if($(this).is(":checked"))
		{
			$(".chkProperties").prop("checked",true);
		}
		else
		{
			$(".chkProperties").prop("checked",false);
		}
	});
});
</script>
@endsection