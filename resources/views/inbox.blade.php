@extends('layout.index')

@section('pageTitle', __('messages.title_message'))

@section('meta_tags')
<meta name="description" content="{{ __('messages.meta_desc_message') }}"> 
<meta name="keywords" content="{{ __('messages.meta_keyword_message') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.messages') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">{{ __('messages.lbl_home') }} </a></li>
					<li>{{ __('messages.messages') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
			<div class="container">
				<div class="row">
				
					<!-- BEGIN MAIN CONTENT -->
					<div class="main col-sm-12">
						<form action="{{ route('message_inbox') }}" method="post" name="frmInbox" id="frmInbox">
							{{ csrf_field() }}
							<input type="hidden" name="page" id="page" value="{{ $page }}" />
							<div class="col-md-12" style="margin-bottom: 5px;">
								<div class="" style="width: 25%;">
									<div class="search-messages">
										<div class="input-group">
											<input type="text" class="form-control" name="keywords" placeholder="{{ __('messages.lbl_search_messages') }}" value="{{ $keywords }}" style="display: inline; height: 42px;" />
											<span class="input-group-btn">
												<button class="btn" type="submit" name="searchMsgBtn" style="border: 1px solid #e3e3e3; height: 42px;"><i class="fa fa-search"></i></button>
											</span>
										</div>
										<input type="hidden" name="list_section" value="{{ $list_type }}" />
									</div>
								</div>
	
								@if(!empty($result) && count($result)>0)
									@if(!empty($pagination) && count($pagination)>0)
										<div class="pagination" style="padding: 0px 10px 0px 0px; text-align: right; border: none; width: 60%; float: right;">
											
											@if(empty($pagination['previous']))
												<ul id='previous'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-left'></i></a></li></ul>
											@else
												<ul id='previous'><li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['previous'] }}"><i class='fa fa-chevron-left'></i></a></li></ul>
											@endif
											
											<ul>
												@if(array_key_exists('firstpage',$pagination))
													<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['firstpage']['page'] }}">{{ $pagination['firstpage']['page'] }}</a></li>
												@endif
												
												@if(array_key_exists('secondpage',$pagination))
													<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['secondpage']['page'] }}">{{ $pagination['secondpage']['page'] }}</a></li>
												@endif
												
												@if(array_key_exists('first_dot',$pagination))
													<li class='dot'>..</li>
												@endif
											
												@foreach($pagination["page"] as $page)
													@if(empty($page['url']))
														<li class='active'><a href='javascript:void(0);'>{{ $page['page'] }}</a></li>
													@else
														<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $page['page'] }}">{{ $page['page'] }}</a></li>
													@endif
												@endforeach
												
												@if(array_key_exists('last_dot',$pagination))
													<li class='dot'>..</li>
												@endif
												
												@if(array_key_exists('lpm1', $pagination))
													<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['lpm1']['page'] }}">{{ $pagination['lpm1']['page'] }}</a></li>
												@endif
												
												@if(array_key_exists('lastpage', $pagination))
													<li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['lastpage']['page'] }}">{{ $pagination['lastpage']['page'] }}</a></li>
												@endif
											</ul>
											
											
											@if(empty($pagination['next']))
												<ul id='next'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-right'></i></a></li></ul>
											@else
												<ul id='next'><li><a href="javascript::void(0);" class="pagination1" data-page="{{ $pagination['next'] }}"><i class='fa fa-chevron-right'></i></a></li></ul>
											@endif
											
										</div>
									@endif
								@endif
								<div style="clear: both;"></div>
							</div>
						</form>
						
						<!-- BEGIN TABS -->
						<div class="col-md-12">
							<ul class="nav nav-tabs tabs-left">
								<li class="active"><a href="{{ route('message_inbox') }}" ><i class="fa fa-inbox"> {{ __('messages.lbl_inbox') }}</i></a></li>
								<li class=""><a href="{{ route('message_sent') }}" ><i class="fa fa-envelope-o"> {{ __('messages.lbl_sent') }}</i></a></li>
							</ul>

							<div class="tab-content tabs-left">
								<div class="tab-pane active" id="tab5">
									<ul class="list-group msg_list">
										@if(!empty($result) && count($result)>0)
											@foreach($result as $res)
												<li class="list-group-item clearfix inbox-item">
													<div class="conv_container new_msg">
															<div class="left_section"> 
																<label class="label-checkbox">
																	<input type="checkbox" name="del_chk_{{ $res['c_id'] }}" id="del_chk_{{ $res['c_id'] }}" value="{{ $res['c_id'] }}" />
																</label>
															</div>
															
															<div class="msg_container">
																<a href="{{ route('conversation', $res['c_id']) }}">
																	<div class="conv_header">
																		<span class="from">{{ $res['c_title'] }}</span>		
																		<span class="pull-right new {{ (($res['is_seen'] == 'false') && ($list_type=='inbox'))?'':'hdn' }}">
																			<i class="fa fa-envelope-o"></i>
																		</span>
																		<span class="inline-block pull-right date">							
																			 <i>{{ date("jS M, Y, h:i A", strtotime($res['message_date'])) }}</i>	
																		</span>
																	</div>
																	<div class="msg_content">
																		<p class="detail {{ (($res['is_seen'] == 'false') && ($list_type=='inbox'))?'new_msg':'' }}">	
																			{{ $res['message_text'] }}
																		</p>
																	</div>
																</a>
															</div>
															<div style="clear: both;"></div>
													</div>
												</li>
											@endforeach
										@else
											<li class="list-group-item clearfix inbox-item">
												Ingen beskeder.
											</li>
										@endif
									</ul>
								</div>
								
								@if(!empty($result) && count($result)>0)
									<div style="width: 40%; float: left; margin-top: 20px;">
										<input type="button" onclick="javascript:deleteMessages();" class="btn btn-primary button" id="deleteMsgBtn" value="{{ __('messages.deleteselected') }}" name="deleteMessage" />
									</div>
								@endif
								
								<!-- BEGIN PAGINATION -->
								<div class="pagination" style="padding: 0; text-align: right; border: none; width: 60%; float: right;">
									<?php //echo pagination2($pgn_query,$limit,$page); ?>
								</div>
								<div style="clear: both;"></div>
								<!-- END PAGINATION -->
							</div>
						</div>
						<!-- END TABS -->
						
					</div>	
					<!-- END MAIN CONTENT -->
					
				</div>
			</div>
		</div>
		
		<div style="display: none;">
			<form id="deleteForm" action="{{ route('delete_msg') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="deleteArray" id="deleteArray" value="" />
				<input type="hidden" name="deleteMsgs" value="yes" />			
			</form>
			<script type="text/javascript">
				function deleteMessages()
				{
					var chks = $("input[name^='del_chk']:checked").map(function(){return this.value;}).get().join(",");
					if(chks != '')
					{
						$("#deleteArray").val(chks);
						$("#deleteForm").submit();
					}
				}
			</script>
		</div>
		
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$(".pagination1").click(function(){
		var getPage = $(this).attr('data-page');
		$("#page").val(getPage);
		$("#frmInbox").submit();
	});
});
</script>
@endsection