@extends('layout.index')

@section('pageTitle', 'Favoritter')

@section('meta_tags')
<meta name="keywords" content="{{ __('messages.meta_keyword_favorite') }}"> 
<meta name="description" content="{{ __('messages.meta_desc_favorite') }}"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.lbl_favorites') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/') }}">{{ __('messages.lbl_home') }}</a></li>
					<li><a href="#">{{ __('messages.lbl_favorites') }}</a></li>
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
			<div class="main col-sm-12 mainpbt">
			
				<div id="property-listing" class="grid-style1 clearfix">
					@if(!empty($objFavorite) && count($objFavorite)>0)
						@foreach($objFavorite as $favorite)
							<div class="item col-sm-3">
								<div class="image"  style="border: 1px solid #e4e4e4;">
									<a target="_blank" href="{{ url('property_detail/'.$favorite->id) }}">
										@if(!empty($favorite->headline_dk))
											<h3>{{ $favorite->headline_dk }}</h3>
										@else
											<h3>{{ $favorite->headline_eng }}</h3>
										@endif
										<span class="location"><?php echo $favorite->city_name; ?></span>
									</a>
									@if(file_exists($favorite->thumbnail) && $favorite->thumbnail!="")
										<img src="{{ asset($favorite->thumbnail) }}" alt="..." width="230" height="237" />
									@else
										<img src="{{ asset('public/images/ikke_navngivet_thumb.png') }}" alt="Bolig billeder - Findbo" />
									@endif
								</div>
								<div class="price">
									<i class="fa fa-home"></i>{{ ($favorite->action == 'rent')?__('messages.lbl_for_rent'):__('messages.lbl_for_sale') }}
									<span>{{ number_format($favorite->price,0,',','.') }} kr {{ ($favorite->action=='rent')?'/md':''}}</span>
									<!-- <span>{{ number_format($favorite->price_usd/1000,3).' kr' }} {{ ($favorite->action == 'rent')?'/md':'' }}</span> -->
								</div>
								<ul class="amenities">
									@if(!empty($favorite->size))
										{{ $favorite->size .'m2' }}
									@endif
									<li><i class="icon-bedrooms"></i> {{ $favorite->rooms }}</li>
								</ul>
								<div class="center" style="padding-top: 10px;">
									<a href="javascript:void(0);" class="btn btn-default-color col-sm-12" onclick="javascript:return showHint( {{ $favorite->wishlistid }});">{{ __('messages.lbl_remove_from_favorite') }}</a>
								</div>
							</div>
						@endforeach
					@else
						<div class="row center"><label>{{ __('messages.noResults') }}</label></div>
					@endif
				</div>
				
			</div>	
			<!-- END MAIN CONTENT -->

		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
function showHint(str)
{
    $.ajax({
        url: "{{ url('removetowishlist') }}",
        data: 'id='+str,
        type: 'POST',
        success: function(){
            window.location.reload();
        },
        error: function(){
        }
    });
}
</script>
@endsection