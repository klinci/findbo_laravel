@extends('layout.index')

@section('pageTitle', __('messages.title_how_it_works'))

@section('meta_tags')
<meta name="description" content="Det er nemt og hurtigt at oprette en konto på findbo.dk. Du kan tilmelde dig ved hjælp af din Facebook konto eller ved at registrere dine personlige oplysninger gennem tilmeldingsformularen."> 
	
<meta name="keywords" content="hvordan virker det, lejligheder i aarhus, lejligheder i ålborg, lejligheder til leje i århus, bolig til leje københavn, lejligheder til leje københavn, lejlighed københavn til leje, lejligheder til leje i københavn, lejligheder i nørresundby, ungdomsbolig randers, værelser til leje i københavn"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Findbo - {{ __('messages.lbl_how_it_works') }}</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.lbl_how_it_works') }}</li>
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
				<div class="col-sm-12">
					<h3 data-animation-direction="from-left" data-animation-delay="200"><i class="fa fa-user"></i> Opret en Konto</h3>
				</div>
				<div class="col-sm-5" data-animation-direction="from-left" data-animation-delay="200">
					<p>Det er nemt og hurtigt at oprette en konto på findbo.dk. Du kan tilmelde dig ved hjælp af din Facebook konto eller ved at registrere dine personlige oplysninger gennem tilmeldingsformularen. Du kan gå i gang med at søge, oprette eller organisere annoncer med det samme.</p>
					<p>Du har mulighed for at oprette dig som <strong>boligsøgende</strong> eller <strong>boligudbyder</strong>. Du kan til enhver tid opgradere din konto og benytte fordelene af de forskellige <a href="{{ url('price')}}">pakker</a> på findbo.dk.</p>
					<a href="{{ url('login') }}" class="btn btn-fullcolor">Registrer Dig Nu!</a>
				</div>
				
				<div class="col-sm-7">
					<img src="{{ asset('public/images/account.png') }}" alt="Create an Account on Findbo" data-animation-direction="from-right" data-animation-delay="200" />
				</div>
				<div class="sp100"></div>
				<div class="col-sm-12">
					<h3 data-animation-direction="from-left" data-animation-delay="200" ><i class="fa fa-edit"></i> Opret din Boligannonce eller Find en Bolig</h3>
				</div>					
				<div class="col-sm-7">
					<img src="{{ asset('public/images/search-findbo.png') }}" alt="" data-animation-direction="from-left" data-animation-delay="200" />
				</div>
				<div class="col-sm-5" data-animation-direction="from-right" data-animation-delay="200" >
					<p>Findbo.dk har en brugervenlig formular til at annoncere boliger til leje eller salg. Indtast informationer om din bolig med placering, størrelse, faciliteter og billeder. Din bolig er klar til at blive offentliggjort og blivet set af boligsøgende.</p>
					<p>Findbo.dk tilbyder nyttige features til at oprette og styre dine boliger. Vi hjælper gerne, hvis der er vanskeligheder eller problemer ved brug af vores ydelser.</p>
					<p>Find din drømmebolig på en nem måde – i hele Danmark. Vi har gjort det nemt for dig at søge og sortere efter boliger ved hjælp af søgefunktionen og <a href="{{ url('map') }}">mapvisning</a>.</p>
					<a href="{{ url('property') }}" class="btn btn-fullcolor">FIND DET PERFEKTE HJEM</a>
				</div>
				
				<div class="col-sm-12">
					<h3 data-animation-direction="from-left" data-animation-delay="200"><i class="fa fa-bar-chart-o"></i> Øg Synligheden for Din Bolig</h3>
				</div>					
				<div class="col-sm-12" data-animation-direction="from-right" data-animation-delay="200" >
					<p>Som boligudbyder, hvad enten det er udlejning eller salg af boliger, har du mulighed for at oprette en konto og annoncere dine boliger. Du vil blive set af boligsøgende i dit område, og i hele Danmark.</p>
					<p>Som boligsøgende, har du mulighed for at søge efter behov og ønsker en bolig. Boligudbydere kan derefter finde dig. Du kan også selv finde og kontakte boligudbydere på findbo.dk.</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection