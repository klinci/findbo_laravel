@extends('admin.layout.index')

@section('pageTitle', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/admin/css/dashboard.min.css') }}">
<style type="text/css">
.count { font-size: 25px !important; }
.tile-stats h3 { font-size: 14px !important; color: #979797 !important; }
.padder-v { margin-bottom: 20px; font-size: 15px !important; }
.tile-stats .icon { color: #7A7474; right: 38px; top: 10px; }
.tile-stats .icon i { font-size: 40px !important; }
</style>
@endsection

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<div class="timebox">
					<a href="javascript:void(0);" class="btn btn-primary" id="btnFuturePayments">Future Payments</a>
					<a href="{{ url('admin/register') }}" class="btn btn-primary" id="btnFuturePayments">Create a new admin</a>
				</div>
			</div>
			<div class="x_panel">
				<div class="row">
					@if(session()->has('message.level'))
						<div class="col-md-12">
							<div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						</div>
					@endif
					<div class="col-md-12  col-sm-12 ptp10 pbp10">
						<div class="row">
							<div class="col-md-4" style="border-right: 1px solid #ddd;">
								<small class="col-sm-12 col-md-12 text-center padder-v"><b> ALL TIME </b></small>

								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-male"></i>
										</div>
										<div class="count">
											{{ $all_time["total_users"] }}
										</div>
										<h3>USERS</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-building-o"></i>
										</div>
										<div class="count">
											{{ $all_time["total_active_properties"] }}
										</div>
										<h3>Active Properties</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-home"></i>
										</div>
										<div class="count">
											{{ $all_time["total_active_seek_properties"] }}
										</div>
										<h3>Active Property Seek Ads</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<div class="count">
											{{ $all_time["total_messages"] }}
										</div>
										<h3>Total messages sent</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-success"></i>
										</div>
										<div class="count">
											{{ $all_time["total_green_packages"] }}
										</div>
										<h3>Intro Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-info"></i>
										</div>
										<div class="count">
											{{ $all_time["total_blue_packages"] }}
										</div>
										<h3>Findbo Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-thumbs-o-down"></i>
										</div>
										<div class="count">
											{{ $all_time["total_unsubscribed"] }}
										</div>
										<h3>Unsubscribed Users</h3>
									</div>
								</div>

							</div>
							<div class="col-md-4" style="border-right: 1px solid #ddd;">
								<small class="col-sm-12 col-md-12 text-center padder-v"><b> LAST 30 DAYS </b></small>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-male"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_users"] }}
										</div>
										<h3>USERS</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-building-o"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_active_properties"] }}
										</div>
										<h3>Active Properties</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-home"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_active_seek_properties"] }}
										</div>
										<h3>Active Property Seek Ads</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_messages"] }}
										</div>
										<h3>Total messages sent</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-success"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_green_packages"] }}
										</div>
										<h3>Intro Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-info"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_blue_packages"] }}
										</div>
										<h3>Findbo Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-thumbs-o-down"></i>
										</div>
										<div class="count">
											{{ $last_30_days["total_unsubscribed"] }}
										</div>
										<h3>Unsubscribed Users</h3>
									</div>
								</div>
								
								
							</div>
							<div class="col-md-4">
								<small class="col-sm-12 col-md-12 text-center padder-v"><b> LAST 7 DAYS </b></small>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-male"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_users"] }}
										</div>
										<h3>USERS</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-building-o"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_active_properties"] }}
										</div>
										<h3>Active Properties</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-home"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_active_seek_properties"] }}
										</div>
										<h3>Active Property Seek Ads</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_messages"] }}
										</div>
										<h3>Total messages sent</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-success"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_green_packages"] }}
										</div>
										<h3>Intro Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-gift text-info"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_blue_packages"] }}
										</div>
										<h3>Findbo Packages</h3>
									</div>
								</div>
								
								<div class="clear"></div>
								
								<div class="animated flipInY col-md-8 col-md-offset-2">
									<div class="tile-stats">
										<div class="icon">
											<i class="fa fa-thumbs-o-down"></i>
										</div>
										<div class="count">
											{{ $last_7_days["total_unsubscribed"] }}
										</div>
										<h3>Unsubscribed Users</h3>
									</div>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Expected Payments  - <span style="color:#53B567;font-weight: bold;">Total : {{ $total_future_payments }} Kr.</span></h4>
			</div>
			<div class="modal-body row">
				<div class="col-md-6 col-sm-12">
					<table class="table table-striped">
	                  	<thead>
	                  		<tr>
	                  			<th>Date</th>
	                  			<th>Amount</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<?php $f_display_counter = 0 ?>
	                  		@foreach($future_payments as $date => $amount)
	                  			<?php $f_display_counter++ ?>
	                  			@if($f_display_counter < 16)
	                  				<tr>
	                  					<td>{{ $date }}</td>
	                  					<td>{{ $amount }} Kr.</td>
	                  				</tr>
	                  			@endif
	                  		@endforeach
	                  	</tbody>
					</table>
				</div>
				<div class="col-md-6 col-sm-12">
					<table class="table table-striped">
	                  	<thead>
	                  		<tr>
	                  			<th>Date</th>
	                  			<th>Amount</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<?php $f_display_counter = 0 ?>
	                  		@foreach($future_payments as $date => $amount)
	                  			<?php $f_display_counter++ ?>
	                  			@if($f_display_counter > 15)
	                  				<tr>
	                  					<td>{{ $date }}</td>
	                  					<td>{{ $amount }} Kr.</td>
	                  				</tr>
	                  			@endif
	                  		@endforeach
	                  	</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$("#btnFuturePayments").click(function(){
		//alert("test");
		$("#myModal").modal('show');
	});
});
</script>
@endsection