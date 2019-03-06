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
							<li><a href="https://www.findbo.dk/index.php">Forside </a></li>
							<li><a href="https://www.findbo.dk/blog">Blog </a></li>
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
					
						<h1 class="blog-title">{{ $post->post_title }}</h1>
						
						<div class="blog-main-image">
							<img src="{{ asset($post->post_image) }}" alt="" />
						</div>
						
						<div class="blog-bottom-info">
							<ul>
								<li><i class="fa fa-calendar"></i>{{ $post->date }}</li>
<!--								<li><i class="fa fa-comments-o"></i> <span class="disqus-comment-count" data-disqus-identifier='7'></span></li>-->
<!--								<li><i class="fa fa-tags"></i> Properties, Prices, best deals</li>-->
							</ul>
							
							<div id="post-author"><i class="fa fa-pencil"></i> {{ $post->postedByName }}</div>
						</div>
						
						<div style="display: none;">
							<input type="hidden" id="pid_for_disqus" value="7" />
						</div>
						
						<div class="post-content">
							{!! $post->description !!}
						</div>
						
						<div class="share-wraper col-sm-12">
							<h5>Del Denne Artikel:</h5>
							<ul class="social-networks">
								<li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u={{ url('/blog/'.$post->post_seo_title) }}">
									<i class="fa fa-facebook"></i></a></li>
								<li><a target="_blank" href="https://twitter.com/intent/tweet?text={{ url('/blog/'.$post->post_seo_title) }}">
									<i class="fa fa-twitter"></i></a></li>
								<li><a target="_blank" href="https://plus.google.com/share?url={{ url('/blog/'.$post->post_seo_title) }}">
									<i class="fa fa-google"></i></a></li>
<!--								<li><a target="_blank" href="http://pinterest.com/pin/create/button/?url=https://www.findbo.dk/blog/al-pacinos-hus-i-filmen-scarface-er-til-salg&description=<p>Scarfaces hus kan nu k&oslash;bes for 200 mio. kr.</p>

<p>Gangsterdr&oslash;mmen kan hermed leves ud.</p>

<p>Huset ligger dog ikke i Miamis coke-omr&aring;de som i Brian de Palmas film fra 1983 men i Santa Barbara i Californien.<br />
Pal&aelig;et, der er bygget i 1906 i det, der engang var en botanisk have, hedder i virkeligheden El Fureidis, som betyder tropisk paradis if&oslash;lge&nbsp;<a href="http://www.villagesite.com/property/631-parra-grande-lane-montecito_14-1459">ejendomsm&aelig;gleren</a>.&nbsp;Navnet passer rigtigt godt til det smukke hus.</p>

<p><img alt="" src="http://www.findbo.dk/post_files/images/Luxury-Rentals-04.jpg" style="height:750px; width:750px" /></p>

<p>&nbsp;</p>&media=https://www.findbo.dk/images/blog/posts/c9cb161f4fa406707f0a2fba94daff4e_image.jpg"><i class="fa fa-pinterest"></i></a></li>-->
<!--								<li><a href="mailto:"><i class="fa fa-envelope"></i></a></li>-->
							</ul>
							<a class="print-button" href="javascript:window.print();">
								<i class="fa fa-print"></i>
							</a>
						</div>
						
						<h1 class="section-title">Kommentar</h1>

						<div class="col-sm-12">
							<div id="disqus_thread"></div>
							<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
						</div>
												
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

		<script src="{{ asset('public/js/disqus_for_count.js') }}"></script>
		<script src="{{ asset('public/js/disqus_for_post.js') }}"></script>





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