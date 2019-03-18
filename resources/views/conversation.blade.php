@extends('layout.index')

@section('pageTitle', 'Conversation')

@section('meta_tags')
<meta name="description" content="Boligportal med udlejning og salg af boliger og lejligheder. Lejligheder til leje - køb eller salg af bolig. Find din bolig her - Findbo.dk."> 
	
<meta name="keywords" content=""> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.messages') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ route('home')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.messages') }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		<div class="row howw">
			<div class="min col-sm-12 mainpbt">
				<div class="row">
					<div class="main col-sm-12">
					
						@if(session()->has('message.level'))
							<div class="col-md-12">
								<div class="alert alert-{{ session('message.level') }}"> 
							    {!! session('message.content') !!}
							    </div>
							</div>
						@endif
						
						<div class="col-md-12">
							<ul class="nav nav-tabs tabs-left">
								<li class="active"><a href="{{ route('message_inbox') }}" ><i class="fa fa-inbox"> {{ __('messages.lbl_inbox') }}</i></a></li>
								<li class=""><a href="{{ route('message_sent') }}" ><i class="fa fa-envelope-o"> {{ __('messages.lbl_sent') }}</i></a></li>
							</ul>
							
							<div class="tab-content tabs-left">
								<div class="tab-pane active" id="tab5">
									<div class="comments">
										<ul>
											<?php 
											$propertyId = 0;
											?>
											@if(!empty($objConversation) && count($objConversation)>0)
												@foreach($objConversation as $row)
													<?php 
													$propertyId = $row['propertyId'];
													?>
													<li>
														<div class="comment {{ ($row['receiver_id'] == $userId)?'wbc':'' }}">
															<h3>
																@if(($row['prop_user_id'] != $row['receiver_id']) && ($row['receiver_id'] == $userId))
																	{{ __('messages.landlord') }}
																@else
																	{{ ucfirst($row['name']) }}
																@endif
																<small>
																		{{ date("jS M, Y, h:i A", strtotime($row["message_date"])) }}
																		<a
																			target="_blank"
																			href="{{ route('property_detail.show.withId', $row['propertyId']) }}"
																			style="float: right;">
																			{{ __('messages.lbl_view_property') }}
																		</a>
																</small>
																<span style="clear: both;"></span>
															</h3>
															<p>{{ $row['message_text'] }}</p>
														</div>
													</li>
												@endforeach
											@endif
										</ul>
										
										<div class="">
											<form action="{{ route('conversation_submit') }}" method="post" class="row">
												{{ csrf_field() }}
												<div class="col-sm-12">
													<textarea rows="4" name="replyText" placeholder="{{ __('messages.lbl_write_message') }}..." class="form-control"></textarea>
													<input type="hidden" value="{{ $c_id }}" name="conversationId">
													<input type="hidden" value="{{ $receiver_user_id }}" name="receiverUserId">
													<input type="hidden" value="{{ $propertyId }}" name="propertyId">
													<input type="hidden" value="{{ $c_id }}" name="c" />
												</div>
												
												<div class="center">
													<button type="submit" name="submitReply" class="btn btn-default-color btn-lg">{{ __('messages.sendmsg') }}</button>
												</div>
											</form>
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
</div>
@endsection