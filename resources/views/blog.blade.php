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
						<h1 class="page-title">Findbo Blog</h1>
						
						<ul class="breadcrumb">
							<li><a href="https://www.findbo.dk/">Forside </a></li>
							<li>Blog</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE TITLE/BREADCRUMB -->
		
		<!-- BEGIN CONTENT WRAPPER -->
		<div class="content">
			<div class="container">
				<div class="row">
				
					<!-- BEGIN MAIN CONTENT -->
					<div class="main col-sm-8" style="padding-top: 0px;">
					
						<div id="listing-header" class="clearfix">

							<div class="view-mode">
								<span>Visning:</span>
								<ul>
									<li data-view="grid-style1" data-target="blog-listing"><i class="fa fa-th"></i></li>
									<li data-view="list-style" data-target="blog-listing" class="active"><i class="fa fa-th-list"></i></li>
								</ul>
							</div>
						</div>
						
						<!-- BEGIN PROPERTY LISTING -->
						<div id="blog-listing" class="list-style clearfix">

						@for($i = 0; $i < count($posts); $i++)

							@if($i % 2 == 0) <div class="row"> @endif

							<div class="item col-md-6">
								<div class="image">
									<a href="{{ url('/blog/'.$posts[$i]->post_seo_title) }}">
										<span class="btn btn-default"><i class="fa fa-file-o"></i> Læs mere</span>
									</a>
									<img src="{{ asset($posts[$i]->post_thumbnail) }}" alt="Bolig billeder - Findbo" />
								</div>
								<div class="info-blog">
									<ul class="top-info">
										<li><i class="fa fa-calendar"></i>{{ $posts[$i]->date }}</li>
									</ul>
									<h3>
										<a href="{{ url('/blog/'.$posts[$i]->post_seo_title) }}">{{ $posts[$i]->post_title }}</a>
									</h3>
									<p>{{ $posts[$i]->shortDescription }}</p>
								</div>
							</div>

							@if($i % 2 == 1 || $i == count($posts) - 1) </div> @endif

						@endfor


						</div>
						<!-- END PROPERTY LISTING -->
						
						<!-- BEGIN PAGINATION -->
						<div class="pagination"></div>
						<!-- END PAGINATION -->
						
					</div>	
					<!-- END MAIN CONTENT -->					
					
					<!-- BEGIN SIDEBAR -->
					<div class="sidebar gray col-sm-4">
						
						<!-- BEGIN LATEST NEWS -->
						<h2 class="section-title">Nyeste News</h2>
						<ul class="latest-news">

							@foreach($latest as $post)
								<li class="col-md-12">
									<div class="image">
										<a href="{{ url('/blog/'.$post->post_seo_title) }}"></a>
										<img src="{{ asset($post->post_thumbnail) }}" alt="" />	
									</div>			
									<ul class="top-info">
										<li><i class="fa fa-calendar"></i> {{ $post->date }}</li>
									</ul>
										
									<h3 class="bottom-info"><a href="{{ url('/blog/'.$post->post_seo_title) }}">{{ $post->post_title }}</a></h3>
								</li>
							@endforeach

						</ul>
						<!-- END LATEST NEWS -->

					</div>
					<!-- END SIDEBAR -->

				</div>
			</div>
		</div>
		<!-- END CONTENT WRAPPER -->

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