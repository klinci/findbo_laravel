@extends('admin.layout.index')

@section('pageTitle', 'Area List')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Area List</h3>
				<div class="timebox">
					<a href="{{ url('admin/area/create') }}" class="btn btn-primary">Add Area</a>
				</div>
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
										<table id="example" class="table table-striped responsive-utilities jambo_table">
											<thead>
												<tr class="headings">
													<th>ID</th>
													<th>Name</th>
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
<script type="text/javascript" src="{{ asset('public/admin/css/datatable_1_10/datatables.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {

    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                 "url": "{{ url('/admin/area/ajaxarea') }}",
                 "dataType": "json",
                 "type": "POST",
                 "data":{ _token: "{{csrf_token()}}" }
		},
		"searching" : false,
		"aLengthMenu": [ [20, 50, 100], [20, 50, 100] ],
		"iDisplayLength": 20,
        "columns": [
			{ "data": "id",orderable: false},
            { "data": "name",orderable: false}
        ]
    });
});
</script>
@endsection