<?php include 'php/blog-highlight.php' ?>
<!DOCTYPE html>
<html lang="en">
	<title>D.O.B.A.R. - zdravstvena ustanova</title>
	<meta property="og:title" content="DOBAR - zdravstvena ustanova">
	<meta property="og:image" content="https://dobar.psihijatar.info/images/logosqare.png">
	<meta name="description" content="Specijalistička psihijatrijska ambulanta 'DOBAR - Dr Dragan Tešanović' je mjesto gdje se briga o liječenju pojedinaca može provoditi u mirnim i zaštićenim okolnostima. U stalnoj smo saradnji sa profesionalcima za mentalno zdravlje različitih profila i iz različitih okruženja kao i medicinskim radnicima drugih profesionalnih usmjerenja.">

	<?php include 'elements/head.php' ?>

<body id="page-top">

<!-- Messenger Chat plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "101526269003156");
      chatbox.setAttribute("attribution", "biz_inbox");

      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/sr_RS/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
   	</script>	
<style type="text/css">
	h2{
		/*display: inline;*/
	}
	.title-effect{
    font-family: Poppins;
    color: #EDF9F4 ;
    font-size: 52px;
    font-weight: 700;
	}
	.text-special{
	letter-spacing: 6px;
	line-height: 1.6em;
	}
</style>
<div class="body">
	<!-- HEADER -->
	<?php include 'elements/header.php' ?>
	

	<!-- INTRO -->
	<div class="intro intro-style6">
		<div class="container-fluid no-padding">
			<div id="intro6-slider" class="flexslider">
				<ul class="slides">
					<li>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center">
									<h2 style="margin-top: 25px"><span class="h2lower">dr</span> Dragan Tešanović </h2><h3>psihijatar</h3><br><br><br><br><br>
									
									<!--a href="#" class="btn btn-primary btn-lg">Learn More</a-->
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center">
									<h2>preventivne i konsultativne aktivnosti</h2><br>
									<h3 style="font-size: 30px;">u oblasti podrške mentalnom zdravlju</h3>
									<!--a href="#" class="btn btn-primary btn-lg">Learn More</a-->
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center">
									<h2>dijagnostički i terapijski protokoli</h2><br>
									<h3 style="font-size: 30px;">u okviru ambulantne vanbolničke prakse</h3>
									<!--a href="#" class="btn btn-primary btn-lg">Learn More</a-->
								</div>
							</div>
						</div>
					</li>					
					<li>
						<div class="container ">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center">
									<img src="images/dobar.png" width="350" style="width:310px; margin: 0 auto;">
									<!--
									<h3 class="text-special">
									<span class="title-effect">D</span>ostojanstveno<br>
									rno<span class="title-effect">O</span>dgovornood<br>
									obrižno<span class="title-effect">B</span>rižnobri<br>
									ngažovano<span class="title-effect">A</span>ngaž<br>
									radoradorado<span class="title-effect">R</span>a
									</h3>
									-->
								</div>
							</div>
						</div>
					</li>
				</ul>
				<div class="is-prev"><i class="icon-angle-left-circle"></i></div>
				<div class="is-next"><i class="icon-angle-right-circle"></i></div>
			</div>
		</div>
	</div>

	
	<!--SERVICES -->
	<section class="services" id="services">
		<div class="container-fluid no-padding">
				<div class="col-md-3 col-sm-3">
					<div class="service-box">
							<h4 class="intro-title">Šta je psihijatrija?</h4><br><br>
							<p class="service-paragraph">Najvažniji aspekt rada psihijatra je povjerljiv, obziran i detaljan razgovor s pacijentom a budući da su ljekari, psihijatri mogu naručiti ili obaviti čitav niz medicinskih, laboratorijskih i psiholoških testova koji, pomažu u stvaranju jasne slike psihičkog i tjelesnog stanja pacijenta.</p>
							<a href="psihijatrija.php" class="btn btn-primary btn-lg">Pročitaj više</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="service-box">

							<h4 class="intro-title">O psihoterapiji</h4><br><br>
							<p class="service-paragraph">Psihoterapija je skup metoda, procedura i tehnika kojima je cilj liječenje psihičkih tegoba razgovorom.Razgovor se vodi između terapeuta i jednog ili više sagovornika/klijenata. Namjena ovakvog razgovora je olakšavanje psihičkih tegoba, sagledavanje mogućih rješenja problema ili razvijanje ličnosti čime se poboljšava kvalitet života osobe.</p>
							<a href="psihoterapija.php" class="btn btn-primary btn-lg">Pročitaj više</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="service-box">
							<h4 class="intro-title">EMDR - psihoterapijska metoda</h4><br><br>
							<p class="service-paragraph">Metoda koristi prirodni proces pokretanja očiju (EM – eye movemant) kako bi se uspješno liječio stresni poremećaj poslije traumatskog doživljaja (PTSP).</p>
							<a href="emdr.php" class="btn btn-primary btn-lg">Pročitaj više</a>
					</div>
				</div>
					
				<!-- <div class="col-md-3 col-sm-3">
					<div class="service-box">
							<h4 class="intro-title">"Anksiolitik je car" ili "Car je go"?</h4><br><br>
							<p class="service-paragraph">Lijekovi za smirenje svojim djelovanjem na nervni sistem umanjuju doživljaj stresa, ublažavaju tjeskobu, zabrinutost, uznemirenost, napetost i nesanicu, a u višim dozama uspavljuju, ali da li je to uvijek tako?</p>
							<a href="anksiolitici.php" class="btn btn-primary btn-lg">Pročitaj više</a>
					</div>
				</div> -->
					

				<div class="col-md-3 col-sm-3">
					<div class="service-box">

							<h4 class="intro-title">Ko je ko u brizi o mentalnom zdravlju</h4><br><br>
							<p class="service-paragraph">Ako razmišljate o tome da se sretnete sa nekim ko bi mogao pomoći u unapređenju i očuvanju vašeg mentalnog zdravlja moguće je da ste zbunjeni zbog različitih pojmova koje možete čuti ili pročitati. Psihijatar? Psiholog? Psihoterapeut?  Vjerujemo da je smisleno da pojasnimo</p>
							<a href="kojeko.php" class="btn btn-primary btn-lg">Pročitaj više</a>

					</div>
				</div>
			
		</div>
	</section>

	<!-- TESTIMONIAL -->
	<section class="testimonial-p" id="testimonial">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="quote">
						<div class="testimonial">
							<div class="quote text-center">
								Svaki čovjek već posjeduje ono što je potrebno da napravi unutrašnju promjenu. Ono što možemo da uradimo jeste da podstaknemo druge da pronađu izvor u sebi i podržimo ih na njihovom putu ka rastu i napretku.
							</div>
							<div class="author">

								<cite><b>Milton Erikson</b></cite>
							</div>
						</div>
						<div class="testimonial">
							<div class="quote text-center quote-text-center-ggc">
								Samo zato što te neko ne voli onako kako želiš, ne znači da nisi voljen cijelim njegovim bićem.
							</div>
							<div class="author">
								<cite><b>Gabriel Garcia Markez</b></cite>
							</div>
						</div>
						<div class="testimonial">
							<div class="quote text-center quote-text-center-ggc">
								Nesretnog življenja je onaj ko mora da ponižava druge da bi održao vlastito samopouzdanje.
							</div>
							<div class="author">
								<cite><b>Harry Stack Sullivan</b></cite>
							</div>
						</div>
						<div class="testimonial">
							<div class="quote text-center">
								Najveće u ljudima je ono što ih čini ravnopravnim sa svima ostalima. Sve ono čime nastojimo da odstupimo „iznad“ ili „ispod“ onog zajedničkog svim ljudima čini nas manjim.
							</div>
							<div class="author">
								<cite><b>Bert Hellinger</b></cite>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="space90 clear"></div>



	<!-- BLOG -->
	<div class="home-blog">
		<div class="container-fluid no-padding">
			<div class="container">
				<div class="section-head text-center col-md-8 col-md-offset-2 space40">
				</div>
			</div>
			<?php
			$shownHighlights = 0;
			foreach (getContent('blog_highlights') as $bh):
				if (!($bh['active'] ?? true)) continue;
				if ($shownHighlights >= 4) break;
				echo htmlBlogHighlight($bh['link'] ?? '', $bh['author'] ?? '', $bh['image'] ?? '', $bh['title'] ?? '', $bh['date'] ?? '', $bh['image_alt'] ?? $bh['title'] ?? '');
				$shownHighlights++;
			endforeach; ?>
			
		</div>
	</div>

	<br>
	<br>
	<br>
<!-- NEWS NEW -->

	<!-- TESTIMONIAL -->
	<!-- <div class="testimonial-wrap testimonial-wrap-green">
		<div class="container">
			<div class="row center-content">
				<div class="col-md-12 col-sm-12">
					<div class="quote">
						<div class="testimonial">
							<div class="quote">
								<h3>Radionica sistemskih konstelacija</h3>
								XVI radionica SK (sistemskih konstelacija) sa voditeljem Draganom Tešanovićem
							</div>
							<div class="author">
								<img class="img-responsive" src="images/team/08figurey.jpg" alt="">
								<a href="aktivnosti.php" class="btn btn-primary" style="margin-bottom: 20px;">Pročitaj više</a>
							</div>
						</div>

						<div class="testimonial">
							<div class="quote">
								<h3>U PRIPREMI SMO ZA</h3>
								Usluge koje ćemo početi da pružamo u skorije vrijeme. 
							</div>
							<div class="author">
								<img class="img-responsive" src="images/team/11mjestoklijent.jpg" alt="">
								<a href="aktivnosti.php" class="btn btn-primary" style="margin-bottom: 20px;">Pročitaj više</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div> -->

<br>
<br>
<br>

<!-- NEWS NEW END -->

	<!-- ISKUSTVA -->
	<!--  section class="testimonial-p testimonial-p3" id="testimonial1" data-stellar-background-ratio="0.4"-->
	<section class="testimonial-p testimonial-p3" id="testimonial1">
		<div class="container">
			<div class="row">
				<h2>Iskustva</h4>
				<div class="col-md-12">
					<div class="quote">

						<div class="testimonial">
							<div class="quote text-center">
								Pomoć psihoterapeuta potražila sam za brata a ubrzo shvatila da je pomoć potrebna MENI. Preuzimajući obaveze i rješavajući probleme uže i šire porodice, usput negdje sam zaboravila sebe. Psihička i fizička opterećenja organizam je godinama je pretvarao u odgovore kako je mogao, u maligne bolesti sa recidivima. Terapeut i inspirativni članovi terapijske grupe pomogli su da upoznajem sebe, svoje potrebe, da glasno kažem šta osjećam, šta želim a šta ne želim! Zahvalna sam za posvećenost i nesebičnost koje su me povele u povezanost i dragocjeno životno iskustvo!
							</div>

							<div class="author">
								<cite><b>D., Prosvjetni radnik u penziji 69 god.</b></cite>
							</div>
						</div>

						<div class="testimonial">
							<div class="quote text-center quote-text-center-m">
								Na terapiji sam se konačno počela od srca smijati i plakati. Mnogo mi je pomoglo što me niko nije kritikovao za ono što osjećam i mislim. Dobro je u životu poznavati nekoga ko u pravo vrijeme umije postaviti prava pitanja.
							</div>

							<div class="author">

								<cite><b>M., pravnica, 35 god.</b></cite>
							</div>
						</div>

						<div class="testimonial">
							<div class="quote text-center quote-text-center-p">
								 Odlazak na prvi susret sa terapeutom/doktorom je bio teška odluka za mene. Način na koji sam tada živio to jest preživljavao odražavao se i na porodicu. Tražio sam tada samo tablete ali doktor me je na prvu razočarao jer rješenje nije vidio u tome, da nema „čarobnog štapića“ i da je preda mnom dug proces. Trajalo je četiri godine a rezultat je da ponovo živim. Živim sa sličnim problemima i strahovima koje prepoznajem i prihvatam ali ŽIVIM. Zahvaljujući terapeutu i grupi gledam naprijed.
							</div>

							<div class="author">

								<cite><b>P. (radnik) 53 godine.</b></cite>
							</div>
						</div>


						<div class="testimonial">
							<div class="quote text-center quote-text-center-s">
								Dozvolila sam da budem u šaci ličnih tragedija i ružnih dešavanja iz prošlosti, svjesna svoje lijepe porodice i našeg napretka ali nesposobna da uživam u svemu tome i budem srećna sve dok se nisam obratila za pomoć a potom naučila da sve što se dešava U meni, zavisi isključivo OD mene. Ja sam ta koja odlučuje kako će se osjećati. Kada sam to shvatila, osjetila sam slobodu i zagrlila život. Neopisivo lijepo je naći sreću u sebi.
							</div>

							<div class="author">

								<cite><b>S., 48 god, administrativni referent.</b></cite>
							</div>
						</div>

						<div class="testimonial">
							<div class="quote text-center quote-text-center-s">
								U mojoj porodici slabost je bila sramota, a briga o drugima je bila veoma bitna uloga. Sve je to OK ali niko me nije naučio kako biti podrška drugima bez preuzimanja njihovih briga na svoja ramena. Uz takav način života, teret samo jednom postane pretežak, a krivica ti ne dozvoljava da ga se rešiš. Tako je počeo moj pad. Prijateljica mi je pokazala put, preporučila mi je psihoterapeuta, isprva stranca, koji mi je pomogao da sama otresem prašinu i ispravim se, podignem glavu i sa mirom u sebi nastavim tamo gde sam stala. Od tad, život je lepši, kad boli plačem i nije me sramota, kad sam ljuta kažem zašto, kad volim grlim i ljubim, kad sam srećna pevam i plešem. 
							</div>

							<div class="author">

								<cite><b>D., 50 godina, HR menadžer</b></cite>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>



	<br>
	
	
	
	<!-- FOOTER -->
	<?php include 'elements/footer.php' ?>
</div>

<!-- JAVASCRIPT =============================-->
	<?php include 'elements/jsscripts.php' ?>

</body>
</html>

