@extends('layout.index')

@section('pageTitle', __('messages.title_faq'))

@section('meta_tags')
<meta name="description" content="OFTE STILLEDE SPØRGSMÅL / FAQ - Opret din boligannonce på få minutter. Sælg eller udlej din bolig gratis på Findbo.dk. Log ind/Personlige oplysninger"> 
	
<meta name="keywords" content="faq, lejligheder i aarhus, lejligheder i ålborg, lejligheder til leje i århus, bolig til leje københavn, lejligheder til leje københavn ">
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">FAQ</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>FAQ</li>
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
				
				<h1 class="section-title">Ofte Stillede Spørgsmål / FAQ</h1>
						
				<h3>Log ind/Personlige oplysninger</h3>
				<div id="accordion" class="panel-group">
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">
									Jeg glemte mit brugernavn/adgangskode. Hvad skal jeg gøre?
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse">
							<div class="panel-body">
								Du kan få et nyt ved at klikke på knappen ”Log ind” i øverste højre hjørne. <br/>
								Derefter klikker du på ”Glemt adgangskode?” <br/>
								Herefter indtaster du din e-mail adresse, og du får tilsendt et link til oprettelse af en ny adgangskode.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">
									Hvordan kan jeg redigere mine kontaktoplysninger?
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
							<div class="panel-body">
								Du kan redigere dine kontaktoplysninger ved at klikke på knappen ”Log ind” i øverste højre hjørne – derefter logger du ind.<br/>
								Klik på ”Velkommen”. <br/>
								Klik på ”Redigér profilen”. <br/>
								Redigér din profil. <br/>
								Det er ikke muligt at ændre din e-mail adresse, fordi kontoen er knyttet personligt til dig. <br/>
								Du bedes derfor henvende dig til os for ændring af e-mail adressen. Du kan kontakte os på <a href="mailto:info@findbo.dk">info@findbo.dk</a>. 
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">
									Jeg kan ikke logge ind - hvad gør jeg?
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse">
							<div class="panel-body">
								Kontrollere om du har skrevet brugernavn og adgangskoden korrekt. <br/>
								Hvis det ikke hjælper, så klik på ”Glemt adgangskode”. <br/>
								Herefter indtaster du din e-mail adresse, og du får tilsendt et link til oprettelse af en ny adgangskode. <br/>
								Løser det ikke problemet, er du velkommen til at kontakte os <a href="mailto:info@findbo.dk">her</a>.
							</div>
						</div>
					</div>
				</div>

				<h3>Annoncering</h3>
				<div id="accordion2" class="panel-group">
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" class="collapsed">
									Jeg har en bolig, som jeg gerne vil annoncere på findbo.dk – hvordan gør jeg det?
								</a>
							</h4>
						</div>
						<div id="collapseOne2" class="panel-collapse collapse">
							<div class="panel-body">
								Opret din profil på findbo.dk. <br/>
								Tryk på ”Opret annonce” knappen i øverste højre hjørne. <br/> 
								Herefter skal du skrive informationerne om din bolig. Husk at vælge, om din bolig skal være til leje eller til salg. <br/>
								Hvis du har spørgsmål, kan vi hjælpe dig videre med annoncering af dine boliger.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2" class="collapsed">
									Kan jeg redigere eller slette min udlejningsannonce?
								</a>
							</h4>
						</div>
						<div id="collapseTwo2" class="panel-collapse collapse">
							<div class="panel-body">
								Du kan redigere eller slette din bolig, under ”Slet bolig” knappen, når du er logget ind.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree2" class="collapsed">
									Hvor længe er min udlejningsannonce aktiv?
								</a>
							</h4>
						</div>
						<div id="collapseThree2" class="panel-collapse collapse">
							<div class="panel-body">
								Din udlejningsannonce løber i så lang tid, som du ønsker. <br/>
								Du bestemmer selv, hvornår du vil redigere eller slette den fra din boligliste. 
							</div>
						</div>
					</div>
				</div>
				
				<h3>Sikkerhed og betaling</h3>
				<div id="accordion3" class="panel-group">
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapseOne3" class="collapsed">
									Er findbo.dk en sikker og tryg boligside?
								</a>
							</h4>
						</div>
						<div id="collapseOne3" class="panel-collapse collapse">
							<div class="panel-body">
								Hver enkelt boligannonce skal igennem en række systemtjek og godkendes manuelt af vores medarbejdere, før den bliver uploadet på findbo.dk. Dermed opnår vi en høj grad af sandsynlighed for, at både lejemålet og personen bag lejemålet er ægte.
							</div>
						</div>
					</div> 
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo3" class="collapsed">
									Er betalingen på findbo.dk sikker?
								</a>
							</h4>
						</div>
						<div id="collapseTwo3" class="panel-collapse collapse">
							<div class="panel-body">
								Ved gennemførelse af en online betaling med betalingskort er alle oplysninger, som angives i den forbindelse krypteret (SSL), og du er derfor altid sikret mod misbrug. <br/>
								Det er kun findbo.dk’s eksterne betalingsudbyder, som kan læse dine kortoplysninger. <br/>
								Beløbet hæves først på din konto, når serviceydelsen aktiveres på findbo.dk. Der tages ikke gebyr ved betaling på findbo.dk.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapseThree3" class="collapsed">
									Hvordan sikrer jeg mig, at min betaling er gennemført?
								</a>
							</h4>
						</div>
						<div id="collapseThree3" class="panel-collapse collapse">
							<div class="panel-body">
								Efter oprettelsen af din profil, kan du købe IntroPakken, som er en prøveperiode på 7 dage eller købe et abonnement, FindboPakken, som varer 30 dage. Du modtager en kvittering på din e-mail, når du har købt en pakkeløsning. Hvis du har FindboPakken, sender vi dig en kvittering en gang om måneden, når dit abonnement bliver automatisk fornyet.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapseFour3" class="collapsed">
									Jeg har købt en Intro-/FindboPakke, men udlejeres information er ikke tilgængelig.
								</a>
							</h4>
						</div>
						<div id="collapseFour3" class="panel-collapse collapse">
							<div class="panel-body">
								Når du er logget på, har du adgang til udlejeres kontaktoplysninger. Kan du stadig ikke se kontaktoplysninger, er du velkommen til at <a href="{{ route('home.contact') }}">kontakte os</a>.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapseFive3" class="collapsed">
									Hvordan opsiger jeg mit abonnement
								</a>
							</h4>
						</div>
						<div id="collapseFive3" class="panel-collapse collapse">
							<div class="panel-body">
								For at opsige abonnementet, så skal du logge ind på din brugerprofil og vælge "<a target="_blank" href="{{ route('packages') }}">Køb pakke</a>". På siden kan du finde en funktion, hvor du kan slå automatisk fornyelse fra. Det vil betyde at du ikke længere vil blive opkrævet af os.
								Ønsker du derimod at blive slettet som bruger på findbo.dk, må du sende os en mail til <a href="mailto:info@findbo.dk">info@findbo.dk</a>.
							</div>
						</div>
					</div>
				</div>
				
				<h3>Søgning</h3>
				<div id="accordion4" class="panel-group">
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion4" href="#collapseOne4" class="collapsed">
									Hvordan kan jeg afgrænse min boligsøgning?
								</a>
							</h4>
						</div>
						<div id="collapseOne4" class="panel-collapse collapse">
							<div class="panel-body">
								På findbo.dk er det nemt og hurtigt at finde lige præcis hvad du søger. 
								Vi har vores ”SØG BOLIG” funktionen i kolofonen i højre side, hvor du kan afgrænse din søgning. 
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion4" href="#collapseTwo4" class="collapsed">
									Min bolig er blevet solgt eller lejet ud, men den vises stadig på hjemmesiden. Hvordan fjerner jeg den?
								</a>
							</h4>
						</div>
						<div id="collapseTwo4" class="panel-collapse collapse">
							<div class="panel-body">
								For at fjerne boligen skal du blot trykke på knappen ”Slet bolig”,  der står i din annonces højre side.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion4" href="#collapseThree4" class="collapsed">
									Hvorfor er boligens placering på kortet forkert?
								</a>
							</h4>
						</div>
						<div id="collapseThree4" class="panel-collapse collapse">
							<div class="panel-body">
								I nogle tilfælde kan det ske, at sælger ikke ønsker at angive den fulde adresse. I mange tilfælde kan husnummeret derfor mangle. <br/>
								Findbo.dk vælger derfor at placere boligen et tilfældigt sted på den vej, hvor boligen ligger. 
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion4" href="#collapseFour4" class="collapsed">
									Jeg har fået en server error - hvem kontakter jeg?
								</a>
							</h4>
						</div>
						<div id="collapseFour4" class="panel-collapse collapse">
							<div class="panel-body">
								Vi beder dig kontakte kundeservice. <br/>
								Du er også velkommen til at kontakte os om funktioner, der ikke fungerer optimalt.
							</div>
						</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion4" href="#collapseFive4" class="collapsed">
									Jeg har et spørgsmål, der ikke er besvaret. Hvordan får jeg fat i jer?
								</a>
							</h4>
						</div>
						<div id="collapseFive4" class="panel-collapse collapse">
							<div class="panel-body">
								Du kan skrive til os på <a href="mailto:info@findbo.dk">info@findbo.dk</a> og vi skal gøre vores bedste for at besvare dit spørgsmål så hurtigt som muligt.
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