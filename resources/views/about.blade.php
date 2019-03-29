@extends('layout.index')

@section('pageTitle', __('messages.title_about'))

@section('meta_tags')
<meta name="description" content="Om Findbo.dk  - Velkommen til Findbo. Vi er en ny Boligportal for Udlejere og Lejere. Nemt og Enkelt at Finde en Bolig."> 
	
<meta name="keywords" content="om findbo.dk, Lejligheder Til Leje i Aarhus, Aalborg, Odense, lejligheder i nørresundby, ungdomsbolig randers, værelser til leje i københavn"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">{{ __('messages.about') }} Findbo.dk</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.about') }} Findbo.dk</li>
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
					<div class="main col-sm-12 section-about">
						<div class="center">
							<h1 data-animation-direction="from-top" data-animation-delay="50">{{ __('messages.about_msg_1') }}</h1>
							<p class="section-about" data-animation-direction="from-top" data-animation-delay="50">{{ __('messages.about_msg_2') }}</p>
							<img src="{{ asset('public/images/findbo-about.png') }}" alt="About Findbo" data-animation-direction="from-bottom" data-animation-delay="50">
						</div>
						<div class="col-sm-6">
							<h2 data-animation-direction="from-left" data-animation-delay="200">Gratis Formidling af Boliger</h2>
							<p data-animation-direction="from-left" data-animation-delay="200">Konceptet bag <a target="_blank" href="https://www.findbo.dk/">findbo.dk</a> er at skabe en mere billig, gennemsigtig og brugervenlig portal for boligmarkedet i Danmark. Det betyder, at lejere og udlejere af boliger skal sikres gennemsigtighed, så alle føler sig virkelig godt behandlet. Vi har en indbygget kommunikationsplatform, hvor man kan kontakte udlejere. Vi kan tilbyde vores udlejere en gratis og effektiv formidling af boliger.</p> 
						</div>
						<div class="col-sm-6">
							<h2 data-animation-direction="from-right" data-animation-delay="200">Udlej en Bolig</h2>
							<p data-animation-direction="from-right" data-animation-delay="200">Findbo.dk tilbyder en let anvendelig kommunikationsplatform. Der er mange besøgende på hjemmesiden hver dag. Boligerne markedsføres professionelt, og de ses af rigtig mange potentielle lejere. Hver gang en lejer henvender sig via kommunikationsplatformen, vil udlejer som regel få en mail, hvor det fremgår hvilken bolig, det drejer sig om, og hvem det er, der henvender sig.</p>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 about-services">
						<h2>Nemt og Enkelt at Finde en Bolig</h2>
						<p class="section-about">Findbo er din Genvej til at Finde en Bolig</p>
						<div class="col-md-6" data-animation-direction="from-bottom" data-animation-delay="250">
							<h3><i class="fa fa-bar-chart-o"></i> Markedsføring af Boliger</h3>
							<p class="col-md-10">Findbo er den ideelle samarbejdspartner til markedsføring af de boliger, der er til udlejning. Vi samarbejder med de forskellige udbydere af boliger til leje. Derudover er vi en stærk partner til markedsføring på nettet, da Findbo har medarbejdere, der er kompetente i at arbejde på nettet med de værktøjer, der skaber mest omtale af de boliger, der er til udlejning.</p>
						</div>
						<div class="col-md-6" data-animation-direction="from-bottom" data-animation-delay="250">
							<h3><i class="fa fa-thumbs-o-up"></i> Bliv vores Medspiller</h3>
							<p class="col-md-10">Du vil som medspiller hos findbo.dk være med til at videreudvikle siden, så den kan blive endnu bedre til at hjælpe med udlejning set med lejer eller udlejers side. En moderne side som findbo.dk kan kun udvikle sig, hvis brugerne inddrages i den daglige udvikling af siden. Det er et vigtigt parameter for medarbejderne hos findbo.dk at forstå brugernes behov og ønsker.</p>
						</div>
						<div class="col-md-6" data-animation-direction="from-bottom" data-animation-delay="650">
							<h3><i class="fa fa-heart"></i> Ros og ris</h3>
							<p class="col-md-10">Det er vigtigt for findbo.dk at få ros og ris. Vi vil selvfølgelig helst gøre det så godt, at vi kun får ros. Men i virkelighedens verden er det ikke muligt at gøre alting rigtigt, så ris er ligeså vigtigt - så vi løbende kan forbedre hjemmesiden.</p>
						</div>
						<div class="col-md-6" data-animation-direction="from-bottom" data-animation-delay="650">
							<h3><i class="fa fa-phone"></i> Kontakt Os</h3>
							<p class="col-md-10">Du er altid velkommen til at tage kontakt til Findbo uanset, om det er for at finde eller udleje boliger. Du kan regne med en konstruktiv dialog med Findbos medarbejdere om de ønsker og behov, du måtte have for at finde eller udleje boligen.</p>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
</div>
@endsection