@extends('admin.layout.index')

@section('pageTitle', 'Rejected Properties [{{ $count}}]')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Rejected Properties [{{ $count}}]</h3>
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
														<th>Property ID</th>
														<th>Property Name</th>
														<th>Owner</th>
														<th>Date Added</th>
														<th style="width: 130px;">Actions</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
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
                 "url": "{{ url('/admin/properties/ajaxrejectedproperties') }}",
                 "dataType": "json",
                 "type": "POST",
                 "data":{ _token: "{{csrf_token()}}"}
		},
		"searching" : false,
		"aLengthMenu": [ [20, 50, 100], [20, 50, 100] ],
		"iDisplayLength": 20,
        "columns": [
            { "data": "property_id",orderable: false },
            { "data": "property_name",orderable: false },
            { "data": "owner",orderable: false },
            { "data": "date_added",orderable: false },
            { "data": "action",orderable: false }
        ]
    });
});
</script>
@endsection