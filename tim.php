<!DOCTYPE html>
<html lang="en">
<?php
	$worker = $_GET['ime'] ?? '';

	function getWorkerData($worker) {
		switch ($worker) {
			case 'dragan':
				return [
					'name' => 'Dragan Tešanović',
					'image' => 'images/team/dragan.jpg',
					'description' => 'doktor medicine, specijalista psihijatrije, dodatna obuka iz porodične medicine, edukacija iz psihoterapijskih oblasti TA (transakciona analiza) i EMDR (terapija reprocesiranja), facilitator sistemskih konstelacija, iskustvo intenzivnog ambulantnog psihijatrijskog rada sa više hiljada osoba, stalna psihoterapijska praksa sa pojedincima, grupama kao i radionički rad sa klijentima.'
				];
			case 'tatjana':
				return [
					'name' => 'Tatjana Maglov',
					'image' => 'images/team/tatjana.jpg',
					'description' => 'doktor medicine, specijalista psihijatrije, uža djelatnost u oblasti tretmana zavisnosti, psihoterapeut sa edukacijom iz transakcione analize'
				];
			case 'zeljka':
				return [
					'name' => 'Željka Štrbac',
					'image' => 'images/team/zeljka.jpg',
					'description' => 'doktor medicine, specijalista psihijatrije sa višegodišnjom iskustvom bolničkog i ambulantnog rada u tretmanu osoba sa mentalnim smetnjama uz upotrebu psihofarmakološkog, bazičnog psihoterapijskog i psihosocijalnog tretmana'
				];
			// Add more cases for other workers
			default:
				return [
					'name' => '',
					'image' => '',
					'description' => ''
				];
		}
	}

	$workerData = getWorkerData($worker);
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta property="og:title" content="<?php echo $workerData['name'] || "DOBAR - O nama"; ?>">
		<meta property="og:image" content="<?php echo $workerData['image'] || "https://dobar.psihijatar.info/images/shutterstock_1929703829.jpg"; ?>">
		<meta property="og:description" content="<?php echo $workerData['description'] || "Koncept ili ideja koja se nalazi iza akronima D.O.B.A.R. ili samo riječi DOBAR pojašnjava način na koji bismo da pristupimo našem zadatku. U htijenju smo da poštujemo Dostojanstvo svakog ko nam se obrati, pristupimo Odgovorno onom što nas očekuje, da se Brižno odnosimo prema svakoj osobi, nastupajući Angažovano u širem okviru brige o mentalnom zdravlju zajednice i Rado obavljajući naš izbor."; ?>">
	</head>
<meta property="og:type" content="article" />
<?php include 'elements/head.php' ?>
<link rel="stylesheet" href="css/lightbox.css">

<body id="page-top" class="subpage">

	<style type="text/css">
		.circle-title {

			font-weight: 700;
			font-size: 20px;
			line-height: 155px;
			color: #fff;
		}

		.ppl-one {
			padding-top: 150px;
		}

		.text-center h3 {
			font-size: 36px;
		}

		@media only screen and (min-width: 250px) and (max-width: 767px) {

			.circle-title {
				font-size: 19px;
				line-height: 144px;
			}

			.text-center h3 {
				font-size: 24px;
			}
		}
	</style>

	<div class="body">
		<!-- HEADER -->
		<?php include 'elements/header.php' ?>

		<!-- PAGE HEAD -->
		<div class="page-head page-head-ppl">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1>Ljudi</h1>
						<h3>koji podržavaju koncept D.O.B.A.R.</h3>
					</div>
				</div>
			</div>
		</div>

		<!-- TEAM -->
		<div class="team team-dark">
			<div class="container">



				<div class="row">
					<div id="dragan" class="col-sm-12 col-md-12 team-box team-box-p text-center">
					
							<figure class="col-sm-6 col-md-6">
								<img class="img-responsive" src="images/team/dragan.jpg" alt="">
							</figure>
							<div class="col-sm-6 col-md-6">
								<h4 class="intro-title">Dragan Tešanović</h4><br>
								<span>doktor medicine, specijalista psihijatrije, dodatna obuka iz porodične medicine, edukacija iz psihoterapijskih oblasti TA (transakciona analiza) i EMDR (terapija reprocesiranja), facilitator sistemskih konstelacija, iskustvo intenzivnog ambulantnog psihijatrijskog rada sa više hiljada osoba, stalna psihoterapijska praksa sa pojedincima, grupama kao i radionički rad sa klijentima.</span><br><br>
							</div>
					</div>
				</div>

				<div class="space40"></div>


				<div class="row">
				<div class="col-sm-6 col-md-6">
							<!-- Team Staff 2 -->
							<div id="zeljka" class="team-box text-center team-coworker">
								<figure>
									<img class="img-responsive" src="images/team/zeljka.jpg" alt="">
								</figure>
								<div>
									<h4 class="intro-title">Željka Štrbac</h4>
									<span>
										doktor medicine, specijalista psihijatrije sa višegodišnjom iskustvom bolničkog i ambulantnog rada u tretmanu osoba sa mentalnim smetnjama uz upotrebu psihofarmakološkog, bazičnog psihoterapijskog i psihosocijalnog tretmana
									</span>
								</div>
							</div>
						</div>
					<div class="col-sm-6 col-md-6">
						<div id="tatjana" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/tatjana.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Tatjana Maglov</h4>
								<span>doktor medicine, specijalista psihijatrije, uža djelatnost u oblasti tretmana zavisnosti, psihoterapeut sa edukacijom iz transakcione analize</span>

							</div>
						</div>
					</div>
					<!-- <div class="col-sm-4 col-md-4">
						<div class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/daliborka.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Daliborka Tadić</h4>
								<span>doktor medicinskih nauka, specijalista neurologije, profesor neurologije na Medicinskom fakultetu Univerziteta u Banjoj Luci, uža djelatnost iz oblasti demijelinizacionih i imunski posredovanih bolesti centralnog nervnog sistema</span>

							</div>

						</div>
					</div> -->
					
					<!--div class="col-sm-4 col-md-4">
					<div class="team-box text-center team-coworker">
						<figure>
							<img class="img-responsive" src="images/team/ivana.jpg" alt="">
						</figure>
						<div>
							<h4 class="intro-title">Ivana Stanišljević</h4>
							<span>psiholog, specijalista medicinske psihologije, sistemski porodični psihoterapeut sa dugogodišnjim profesionalnim iskustvom u oblasti mentalnog zdravlja</span>

						</div>
					</div>
				</div-->


					<!--div class="col-sm-4 col-md-4">
					
					<div class="team-box text-center team-coworker">
						<figure>
							<img class="img-responsive" src="images/team/02drDijana.jpg" alt="">
						</figure>
						<div>
							<h4 class="intro-title">Diana Zorić</h4>
							<span>doktor medicine, primarijus, specijalista psihijatrije, uža djelatnost u oblasti tretmana afektivnih poremećaja i suicidalnosti, edukacija iz kognitvno-bihejvioralne psihoterapije</span>
					
						</div>
					</div>
				</div-->


				</div>
				<br>
				<!-- <div class="row">
					
					<div class="col-sm-6 col-md-6">
						<div id="macura" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/macura.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Dragan Macura</h4>
								<span>doktor medicine, specijalista neurologije,  iskustvo u bolničkom i ambulantom ljekarskom radu, bliža interesovanja vrtoglavice, glavobolje, akutni i hronični bolni sindromi, zaboravnost.
								aktivan član strukovnog udruženja</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6">
						<div id="andrej" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/andrej.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Andrej Blagojević</h4>
								<span>doktor medicine, specijalista neurologije, višegodišnje iskustvo rada na odjelu neurorehabilitacije. uže oblasti interesovanja  demencije, oboljenja perifernog nervnog sistema, oboljenja ekstrapiramidalnog sistema te cerebrovaskularna oboljenja, stalno aktivan u edukacijama u zemlji i inostranstvu</span>
							</div>
						</div>
					</div>
				</div>
				<br> -->
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<div id="maric" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/maric.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Tatjana Marić</h4>
								<span>dr sci., pedagog,  psihoterapeut pod supervizijom, praktičar transakcione analize, iskustvo u radu sa djecom, mladima na problemima odrastanja, samopouzdanja, stresa te sa odraslim osobama  sa problemima anksioznosti i depresivnosti, opredjeljenje na individualni rad sa klijentima</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6">
						<div id="andrea" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/andrea.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Andrea Dursun</h4>
								<span>porodični , sistemski psihoterapeut pod supervizijom, uz dodatnu edukaciju iz tjelesno orijentisane psihoterapije.</span>
								<span>studij socijalnog rada završila u Geteborgu, kao master iz oblasti “Child and Youth Studies”. Obrazovanje i profesionalno iskustvo kroz rad s djecom, mladima, parovima i porodicama u različitim sistemima, što omogućava sveobuhvatan uvid u psihičko, tjelesno i emocionalno funkcionisanje pojedinca. Terapeutski rad temelji na stvaranju sigurnog prostora, osnaživanju unutrašnjih resursa i podršci u prevazilaženju ličnih, porodičnih i partnerskih izazova.</span>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<div id="suncica" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/suncica.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Sunčica Jugović</h4>
								<span>master psiholog,  psihoterapeut pod supervizijom kognitivno-bihejvioralnog usmjerenja  (ACT - Acceptance and Commitment Therapy; CFT-a - Compassion focused therapy), praktičar mindfulness tehnika, rad sa odraslima i djecom  sa poteškočama anksioznosti, paničnosti, depresivnosti, prokrastinacije,  poteškoćama učenja</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6">
						<div id="sasa" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/sasa.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Saša Stanivuković</h4>
								<span>diplomirani medicinar zdravstvene njege, master zdravstvene njege</span>
	
							</div>
						</div>
					</div>
				</div>
				<br>
<br>
				<!-- <div class="row">
					<div class="col-sm-4 col-md-4">
						<div id="gabi" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="images/team/gabriela.jpg" alt="">
							</figure>
							<div>
								<h4 class="intro-title">Gabrijela Janković</h4>
								<span>diplomirani psiholog, sistemsko porodična savjetnica, završen napredni nivo treninga za kognitivno bihejvioralnu terapiju. Višegodišnje iskustvo u psihodijagnostičkoj procjeni ličnosti,te savjetodavnom radu sa pojedincem, porodicom i vulnerabilnim grupama.</span>

							</div>
						</div>
					</div>
				</div> -->

			</div>
		</div>



		<!-- TIMELINE
	<section class="timeline-wrap">
		<div class="container">
			<div class="section-head text-center col-md-8 col-md-offset-2 space40">
				<h1 class="intro-title">Naš razvoj</h1>
				<p style="color: #333">Prikaz našeg razvoja </p>
			</div>

			<ul class="timeline">
				<li class="timeline-inverted">
					<div class="timeline-image">
						<i class="fa fa-home"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4>Septembar 2021</h4>
							<h4 class="subheading">Otvorili smo ustanovu</h4>
						</div>
						<div class="timeline-body">
							<p class="text-muted">Uskoro više informacija</p>
						</div>
					</div>
				</li>

				<li>
					<div class="timeline-image">
						<i class="fa fa-briefcase"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4>Oktobar 2021</h4>
							<h4 class="subheading">Pokrenuli online savjetovanje</h4>
						</div>
						<div class="timeline-body">
							<p class="text-muted">Uskoro više informacija</p>
						</div>
					</div>
				</li>

				<li class="timeline-inverted">
					<div class="timeline-image">
						<i class="fa fa-user"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4>Novembar 2021</h4>
							<h4 class="subheading">Proširili smo djelatnost</h4>
						</div>
						<div class="timeline-body">
							<p class="text-muted">Uskoro više informacija</p>
						</div>
					</div>
				</li>

				<li class="timeline-inverted">
					<div class="timeline-image">
						<h4>Piši nam
							<br>Čitaj
							<br>Javi se!
						</h4>
					</div>
				</li>
			</ul>
		</div>
	</section>
	 -->
		<!-- CALL TO ACTION -->
		<?php include 'elements/cta.php' ?>


		</div>
		<br>
		<br>
		<br>


		<!-- FOOTER -->
		<?php include 'elements/footer.php' ?>
	</div>

	<!-- JAVASCRIPT =============================-->
	<?php include 'elements/jsscripts.php' ?>
	<script src="js/lightbox-plus-jquery.js"></script>
</body>

</html>