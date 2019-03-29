@extends('layout.index')

@section('pageTitle', 'Tak for at registrere dig!')

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">
					@lang('messages.activate_title')
				</h1>
				
				<ul class="breadcrumb">
					<li>
						<a href="{{ route('home') }}">
							@lang('messages.lbl_home')	
						</a>
					</li>
					<li>
						@lang('messages.activate_title')
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->

<div class="content">
	<div class="container">
		 <div class="row green" style="padding-top:70px; padding-bottom:30px; border-bottom:solid 1px #ccc;">
			<div class="main col-sm-12" style="text-align:center; font-weight:bold;">
				<h3 style="color: #4D4F56;">
					@lang('messages.activate_title_body')
				</h3>
				<br/>
				<h3 style="color: #4D4F56;">
					@lang('messages.activate_message1')	
				</h3>
				<br/>
				<h3 style="color: #4D4F56;">
					@lang('messages.activate_message2', [
						'url' => route('resend_code')
					])
				</h3>
			</div>
		</div>
	</div>
</div>
@endsection
