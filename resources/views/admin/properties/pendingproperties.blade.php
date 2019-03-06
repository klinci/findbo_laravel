@extends('admin.layout.index')

@section('pageTitle', 'Pending Properties')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Pending Properties [{{ $count}}]</h3>
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
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td class="nopaddingtd">
										<form method="post" action="{{ url('admin/properties/updatependingproperties') }}" name="frmDelete" id="frmDelete">
											{{csrf_field()}}
											<table id="example" class="table table-striped responsive-utilities jambo_table">
												<thead>
													<tr class="headings">
														<th style="text-align: center;width: 50px;"><input type="checkbox" name="chkAll" id="chkAll" /></th>
														<th style="text-align: center;width: 50px;"><input type="checkbox" name="chkAllApprove" id="chkAllApprove" /></th>
														<th>Owner</th>
														<th>Date Added</th>
														<th style="width: 130px;">Imported From</th>
														<th>Property ID</th>
														<th>Property Name</th>
														<th>Property URL</th>
														<th style="width: 130px;">Actions</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td style="text-align: left;"><button name="btnDelete" id="btnDelete" value="delete" class="btn btn-primary">Delete</button></td>
														<td colspan="8" style="text-align: left;"><button name="btnApprove" value="approve" id="btnApprove" class="btn btn-success">Approve</button></td>
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
<script type="text/javascript" src="{{ asset('public/admin/css/datatable_1_10/datatables.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
	
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                 "url": "{{ url('/admin/properties/ajaxpendingproperties') }}",
                 "dataType": "json",
                 "type": "POST",
                 "data":{ _token: "{{csrf_token()}}"}
		},
		"searching" : false,
		"aLengthMenu": [ [20, 50, 100], [20, 50, 100] ],
		"iDisplayLength": 20,
        "columns": [
			{ "data": "checkboxes",orderable: false,"sClass": "text-center" },
			{ "data": "checkboxes_approve",orderable: false,"sClass": "text-center" },
            { "data": "owner",orderable: false },
            { "data": "date_added",orderable: false },
            { "data": "imported_from",orderable: false },
            { "data": "property_id",orderable: false },
            { "data": "property_name",orderable: false },
            { "data": "property_url",orderable: false },
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

    $("#chkAllApprove").click(function(){
		if($(this).is(":checked"))
		{
			$(".chkPropertiesApprove").prop("checked",true);
		}
		else
		{
			$(".chkPropertiesApprove").prop("checked",false);
		}
	});

    $("#btnApprove").click(function(){
		if(!$(".chkPropertiesApprove").is(":checked"))
		{
			alert("Please check atleast one checkbox to approve.");
			return false;
		}
	});
});
</script>
@endsection