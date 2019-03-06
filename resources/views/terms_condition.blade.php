@extends('layout.index')

@section('pageTitle', __('messages.page_title_terms_condition'))

@section('meta_tags')
<meta name="description" content="På findbo.dk kan du som boligudbyder oprette en boligannonce, som manuelt bliver godkendt af vores medarbejdere. Herefter dannes en side på www.findbo.dk, hvor din annonce offentliggøres.">	
<meta name="keywords" content=" retningslinier, lejligheder i ålborg, lejligheder til leje i århus, bolig til leje københavn, lejligheder til leje københavn, lejlighed københavn til leje, lejligheder til leje i københavn, lejligheder i nørresundby, ungdomsbolig randers"> 
@endsection

@section('content')
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Retningslinier</h1>
				
				<ul class="breadcrumb">
					<li><a href="{{ url('/')}}">{{ __('messages.lbl_home') }}</a></li>
					<li>{{ __('messages.guidelines') }}</li>
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
				
				<h1 class="blog-title">Retningslinier for brug af findbo.dk</h1>
				
				<div class="post-content">
					<h2 class="blog-title">1. Retningslinier</h2>
					<p>På findbo.dk kan du som boligudbyder oprette en boligannonce, som manuelt bliver godkendt af vores medarbejdere. Herefter dannes en side på www.findbo.dk, hvor din annonce offentliggøres. Annoncen kan også findes med brug af søgemaskiner – f.eks. Google.

Som boligsøgende kan du oprette en boligsøgeannonce på findbo.dk. Du accepterer at modtage e-mails fra www.findbo.dk med relevante boliger, der er til leje eller salg afhængig af din søgeprofil. Findbo.dk videregiver ikke din e-mail adresse eller andre oplysninger til tredjepart.</p>
					<h3 class="blog-title">1.1	FindboPakken</h3>
					<p>FindboPakken giver dig mulighed for at oprette en boligsøgeannonce, som bliver set af udlejere og sælgere. FindboPakken giver adgang til kontaktoplysninger for boligudbydere. Søgeprofilen angiver hvilke typer boliger og områder, du søger. Søgeprofilen kan altid redigeres på din brugerkonto. Med denne pakke får du adgang til kontaktoplysninger til alle boligudbydere på <a href="https://www.findbo.dk/">findbo.dk</a>.</p>
					<h3 class="blog-title">1.2	IntroPakken</h3>
					<p>IntroPakken giver dig de samme muligheder som FindboPakken, dog ikke featuren 'boligjagten'. Denne giver dig mulighed for, at modtage mails om ledige boliger, der matcher dine kriterier. Bemærk venligst, at IntroPakken er en prøveperiode og opgraderes til FindboPakken efter fire dage, som koster 289 kr. for 30 dage. Hvis du ikke ønsker at blive opgraderet til FindboPakken, så skal du slå funktionen automatisk fornyelse fra, som du finder på siden 'Køb pakke' under din profil. Linket til siden hedder: <a href="{{ url('package')}}">findbo.dk/package</a>.</p>
					<h3 class="blog-title">1.3 Betaling</h3>
					<p>Ved køb af FindboPakken, kan du vælge at betale med betalingskort. Du er altid sikret mod misbrug ved online betaling. Alle data krypteres af vores eksterne betalingsudbyder – Stripe. Findbo.dk tilbyder to forskellige pakker. IntroPakken, som er en prøveperiode, koster 19,- DKK for fire dage og FindboPakken koster 289,- DKK for 30 dages abonnement. Bemærk venligst, at IntroPakken automatisk opgraderes til FindboPakken efter 4 dage. Hvis du ikke ønsker at blive opgraderet til FindboPakken, så skal du slå funktionen automatisk fornyelse fra, som du finder på siden 'Køb pakke' under din profil. Linket til siden hedder: <a href="{{ url('package')}}">findbo.dk/package</a>. Hver gang abonnementet fornyes, vil du modtage en kvittering. Du kan til enhver tid opsige abonnementet.</p>
					<h3 class="blog-title">1.4 Anvendelsesret</h3>
					<p>Det er ikke tilladt at videregive brugernavn og adgangskode samt andre informationer knyttet til FindboPakken. Disse oplysninger anses for strengt personlige og må kun benyttes af den boligsøgende, der har oprettet FindboPakken. Misbrug af disse oplysninger vil medføre, at den pågældende brugerkonto uden varsel spærres. Ved køb af FindboPakken er der ingen fortrydelsesret, og dette accepteres af brugeren ved oprettelse af FindboPakken.</p>
					<h3 class="blog-title">1.5	Annoncering</h3>
					<p>Findbo.dk skal være bekendt med de nødvendige oplysninger om lejemålet og udlejers/kontaktpersons navn, adresse, telefonnummer og e-mail, for at en boligannonce kan oprettes. Det er ikke tilladt at selve annonceteksterne indeholder kontaktoplysninger i form af telefonnumre, e-mail, adresser, firmanavn, internetadresser og lignende. Det er ikke tilladt at oprette flere annoncer for det samme lejemål. Desuden er det ikke tilladt at et lejemål er betinget af varekøb eller levering af ydelser. Dermed forbeholder findbo.dk sig ret til uden varsel at redigere eller forkaste annoncer, som overskrider et eller flere af de omtalte forhold.</p>
					<h3 class="blog-title">1.6 Kommunikation</h3>
					<p>Kommunikation mellem boligudbyder og boligsøgende må kun omhandle konkrete lejemål som annonceres på findbo.dk. Det er dermed ikke tilladt at tilbyde annoncering af lejemål andre steder end på findbo.dk. Dette kan i yderste konsekvens medføre øjeblikkelig fjernelse af den pågældende boligannonce. Udlejeren er forpligtet til at opdatere sine boligannoncer på findbo.dk med relevante informationer, herunder markere om lejemålet er udlejet eller der er prisændringer. Findbo.dk har pligt til at opbevare data på et lejemål og boligudbyderen i minimum 2 år. De opbevarede data vil blive behandlet sikkert og videregives ikke til en tredjepart.</p>
					<h3 class="blog-title">1.7 Accept af retningslinjer</h3>
					<p>Ved accept af findbo.dk's retningslinjer for annoncering, accepterer boligudbyderen samtidig, at findbo.dk må benytte boligudbyderen i marketingsøjemed uden forudgående godkendelse fra boligudbyderen. Såfremt boligudbyderens adfærd er i konflikt med findbo.dk's interesser, forbeholder findbo.dk sig ret til at ophæve samarbejdet med boligudbyderen med øjeblikkelig virkning.
					</p>
					<h2 class="blog-title">2. Forretningsbetingelser</h2>
					<p>Der kan kun bestilles tjenesteydelser via vores hjemmeside. Alle priser er inklusive moms og andre afgifter. Handelsaftaler med findbo.dk indgås på dansk. For at se tidligere ordrer på findbo.dk, bedes du at sende en mail til info@findbo.dk og oplyse den e-mail adresse, som er tilknyttet din findbo.dk's brugerkonto.</p>
					<h3 class="blog-title">2.1 Betaling</h3>
					<p>Ved gennemførelse af en online betaling med betalingskort, er alle oplysninger som angives i den forbindelse krypteret (SSL), og du er altid sikret mod misbrug. Det er kun findbo.dk's eksterne betalingsudbyder, som kan læse dine oplysninger. Beløbet hæves først på din konto, når serviceydelsen aktiveres på findbo.dk. Der tages ikke gebyr ved betaling på findbo.dk.</p>
					<h3 class="blog-title">2.2 Abonnementsbetaling</h3>
					<p>Ved abonnementsbetaling fornyes aftalen automatisk for hver 30. dag. Første gang du tilmelder dig, vil beløbet automatisk blive trukket fra din konto inden for 4 dage. Du kan til enhver tid opsige dit abonnement. Hver gang abonnementet fornyes, vil du modtage en mail med kvittering for gennemført betaling. Hvis dit betalingskort udløber eller bliver spærret, bliver abonnementsaftalen sat i bero. Der vil herefter blive foretaget en ny trækning, og hvis det mislykkes, vil abonnementsaftalen blive indstillet. Ved ændring af betalingskort for din abonnementsaftale, skal aftalen opsiges. FindboPakken genkøbes herefter med dit nye betalingskort.</p>
					<h3 class="blog-title">2.3 Fortrydelsesret</h3>
					<p>Ved køb af tjenesteydelserne på findbo.dk giver du derved dit samtykke til, at købet ikke kan fortrydes. </p>
					<h3 class="blog-title">2.4 Reklamationsret</h3>
					<p>Du har reklamationsret, når du handler på findbo.dk. Dog betinges det, at reklamationen er berettiget, og at manglen ikke skyldes fejlagtig brug af produktet, opsætningsproblemer på din computer, browser eller hos din Internetudbyder. Reklamation betragtes som rettidig, hvis der reklameres inden for to måneder efter, at fejlen er opdaget. Den korte frist skyldes, at tjenesteydelserne på findbo.dk er tidsbegrænsede. Ved ønsket om reklamation for en tjenesteydelse, skal reklamationen indsendes til vores postadresse: FindBo.dk ApS, Pedersholms Álle 13, DK-7100 Vejle.</p>
					<h2 class="blog-title">3. Persondatapolitik</h2>
					<p>Når du registrerer dig på findbo.dk, afgiver du personlige oplysninger, som gemmes fortroligt hos FindBo.dk ApS og opbevares lovpligtigt i fem år. Følgende personlige oplysninger angives ved registrering: - For- og efternavn - Evt. firmanavn og cvr - Adresse - Telefonnummer - E-mail adresser. Du kan til enhver tid gøre indsigelse mod registrering af dine personlige oplysninger, og du kan få indsigt i, hvilke oplysninger der er registreret om dig. Henvendelse i den forbindelse kan ske ved at sende en mail til info@findbo.dk.
					</p>
					<h3 class="blog-title">3.1 Cookies</h3>
					<p>Findbo.dk anvender cookies med henblik på at forbedre brugeroplevelsen for dig. Cookies bruges til at lagre oplysninger om din adfærd på hjemmesiden, således at vi har mulighed for at optimere hjemmesiden bedst muligt for dig. Cookies aktiveres i det øjeblik, du giver dit samtykke til det.</p>
				</div>
				
			</div>	
				
				
				
			</div>
		</div>
	</div>
</div>
@endsection