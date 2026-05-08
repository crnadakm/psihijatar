<!DOCTYPE html>
<html lang="sr">
	<?php include 'elements/head.php' ?>
	<?php $siteData = getContent('site'); ?>
<body id="page-top" class="subpage">

<div class="body">
<!-- Messenger Chat plugin Code (deferred for performance) -->
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
      window.addEventListener('load', function() {
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "101526269003156");
        chatbox.setAttribute("attribution", "biz_inbox");
        window.fbAsyncInit = function() { FB.init({ xfbml: true, version: 'v12.0' }); };
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/sr_RS/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      });
    </script>
	<style type="text/css">
		h1,h3,h4{
			color: black;
		}
		p{
			color: black;
			font-size: 15px;
		}
	</style>

	<!-- HEADER -->
	<?php include 'elements/header.php' ?>

	<!-- PAGE HEAD -->
	<div class="page-head page-head-contact">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>Kontakt</h1>
					<!--ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">Kontakt</li>
					</ol-->
				</div>
			</div>
		</div>
	</div>

	<!-- CONTACT -->
	<div class="contact">
		<div class="container">
			<div class="row">

				<!-- CONTACT INFO -->
				<aside class="col-md-3 col-sm-4">
					<div class="sidebar contact-sidebar">
						<section class="contact-block">
							<h2 class="contact-block-title">Online zakazivanje</h2>
							<ul class="list-inline social-icons icon-circle contact-social">
								<li><a href="https://wa.me/38766945702" aria-label="WhatsApp"><img height="40" src="images/whatsapp.png" alt="WhatsApp kontakt" width="40" loading="lazy" decoding="async"></a></li>
								<li><a href="viber://chat?number=38766945702" aria-label="Viber"><img height="40" src="images/viber.png" alt="Viber kontakt" width="40" loading="lazy" decoding="async"></a></li>
								<li><a target="_blank" href="https://www.facebook.com/dobarpsihijatar" aria-label="Facebook"><img height="40" src="images/fb.png" alt="Facebook stranica" width="40" loading="lazy" decoding="async"></a></li>
								<li><a target="_blank" href="https://www.instagram.com/dobar.zdravstvena.ustanova/" aria-label="Instagram"><img height="40" src="images/ig.svg" alt="Instagram stranica" width="40" loading="lazy" decoding="async"></a></li>
							</ul>
						</section>

						<section class="contact-block">
							<h2 class="contact-block-title">Kako do nas</h2>
							<ul class="contact-info">
								<li><i class="icon-home"></i><span><?= htmlspecialchars($siteData['address'] ?? 'Vojvode Pere Krece 2, Banja Luka 78000') ?></span></li>
								<li><i class="icon-call"></i><a href="tel:+38766945702" class="phone-link"><?= htmlspecialchars($siteData['phone'] ?? '+387 66 945-702') ?></a></li>
							</ul>
							<p class="contact-note">*broj je samo za Viber poruke</p>
						</section>
						<?php
						$tz = new DateTimeZone('Europe/Sarajevo');
						$now = new DateTime('now', $tz);
						$dow = (int)$now->format('w'); // 0=Sun..6=Sat
						$mins = (int)$now->format('H') * 60 + (int)$now->format('i');
						$schedule = [1=>[540,1020], 2=>[540,1020], 3=>[660,1140], 4=>[540,1020], 5=>[540,1020]];
						$dayNames = ['nedjelju','ponedjeljak','utorak','srijedu','četvrtak','petak','subotu'];
						$isOpen = false; $statusText = '';
						if (isset($schedule[$dow]) && $mins >= $schedule[$dow][0] && $mins < $schedule[$dow][1]) {
							$isOpen = true;
							$closesAt = sprintf('%d:%02d', floor($schedule[$dow][1]/60), $schedule[$dow][1]%60);
							$statusText = 'Otvoreno · zatvara u ' . $closesAt;
						} else {
							for ($i = 0; $i <= 7; $i++) {
								$d = ($dow + $i) % 7;
								if (!isset($schedule[$d])) continue;
								if ($i === 0 && $mins >= $schedule[$d][1]) continue; // today already closed
								$opens = sprintf('%d:%02d', floor($schedule[$d][0]/60), $schedule[$d][0]%60);
								if ($i === 0) $statusText = 'Zatvoreno · otvara danas u ' . $opens;
								else if ($i === 1) $statusText = 'Zatvoreno · otvara sutra u ' . $opens;
								else $statusText = 'Zatvoreno · otvara u ' . $dayNames[$d] . ' u ' . $opens;
								break;
							}
						}
						?>
						<section class="contact-block">
							<h2 class="contact-block-title">Radno vrijeme</h2>
							<div class="hours-status <?= $isOpen ? 'open' : 'closed' ?>">
								<span class="dot"></span>
								<span><?= htmlspecialchars($statusText) ?></span>
							</div>
							<ul class="hours-list">
								<li><span>Pon, Uto, Čet, Pet</span><span>9–17h</span></li>
								<li><span>Srijeda</span><span>11–19h</span></li>
								<li><span>Vikend</span><span class="muted">zatvoreno</span></li>
							</ul>
						</section>
					</div>
				</aside>

				<style>
					.contact-sidebar { font-size: 14px; }
					.contact-sidebar .contact-block { padding: 16px 0; border-bottom: 1px solid #eee; }
					.contact-sidebar .contact-block:last-child { border-bottom: 0; }
					.contact-sidebar .contact-block-title { font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 12px 0; color: #333; }
					.contact-sidebar .contact-social { padding: 0; margin: 0; }
					.contact-sidebar .contact-social li { padding: 0 6px 0 0; }
					.contact-sidebar .contact-info { list-style: none; padding: 0; margin: 0; }
					.contact-sidebar .contact-info li { display: flex; align-items: flex-start; gap: 10px; padding: 6px 0; line-height: 1.4; }
					.contact-sidebar .contact-info li i { color: #229C8C; font-size: 16px; flex-shrink: 0; margin-top: 2px; }
					.contact-sidebar .phone-link { color: inherit; text-decoration: none; font-weight: 600; }
					.contact-sidebar .phone-link:hover { color: #229C8C; }
					.contact-sidebar .contact-note { font-size: 12px; color: #999; font-style: italic; margin: 6px 0 0 26px; }
					.contact-sidebar .hours-status { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 6px; background: #f5f5f5; margin-bottom: 10px; font-size: 13px; }
					.contact-sidebar .hours-status .dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
					.contact-sidebar .hours-status.open .dot { background: #28a745; }
					.contact-sidebar .hours-status.closed .dot { background: #dc3545; }
					.contact-sidebar .hours-status.open { color: #155724; }
					.contact-sidebar .hours-status.closed { color: #555; }
					.contact-sidebar .hours-list { list-style: none; padding: 0; margin: 0; }
					.contact-sidebar .hours-list li { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dashed #e5e5e5; }
					.contact-sidebar .hours-list li:last-child { border-bottom: 0; }
					.contact-sidebar .hours-list .muted { color: #999; }
					@media (max-width: 767px) {
						.contact-sidebar .contact-block-title { font-size: 14px; }
						.contact-sidebar .contact-block { padding: 14px 0; }
					}
				</style>

				<!-- CONTACT FORM -->
				<div class="col-md-8 col-md-push-1 col-sm-8">
					<p class="lead">Ako imate pitanje slobodno nam pišite. Rado ćemo odogovoriti</p>
					<div class="contact-form">
						<form name="sentMessage" id="contactForm" action="php/contact.php" method="post">
							<div class="form-group has-feedback">
								<label>Ime*</label>
								<input name="senderName" id="senderName" class="form-control" type="text" required>
								<i class="fa fa-user form-control-feedback"></i>
							</div>
							<div class="form-group has-feedback">
								<label>Vaš email*</label>
								<input name="senderEmail" id="senderEmail" class="form-control" type="email" required>
								<i class="fa fa-envelope form-control-feedback"></i>
							</div>
							<!--div class="form-group has-feedback">
								<label>Naslov*</label>
								<input class="form-control" name="subject" id="subject" type="text">
								<i class="fa fa-navicon form-control-feedback"></i>
							</div-->
							<div class="form-group has-feedback">
								<label>Poruka*</label>
								<textarea class="form-control" name="message" id="message" rows="6"></textarea>
								<i class="fa fa-pencil form-control-feedback"></i>
							</div>
                            <div class="g-recaptcha" data-sitekey="6LewI14gAAAAAG_yOQ5Sxlgiy5PxDA9YwqJkqyJu"></div>

                            <button type="submit" class="submit-button btn btn-primary btn-lg">Pošalji</button>
						</form>
						<div id="sendingMessage" class="statusMessage">
							<p><i class="fa fa-spin fa-spinner"></i> Poruka se šalje, molimo sačekajte...</p>
						</div>

						<div id="successMessage" class="successmessage">
							<p><span class="success-ico"></span> Hvala Vam što ste nam se javili. Odgovorićemo ubrzo.</p>
						</div>
					
						<div id="failureMessage" class="errormessage">
							<p><span class="error-ico"></span> Postoji problem, molimo pokušajte ponovo</p>
						</div>
					
						<div id="incompleteMessage" class="statusMessage">
							<p><i class="fa fa-warning"></i> Molimo popunite sva polja prije slanja emaila</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>
		<br>

		<!-- GOOGLE MAP -->
	    <div class="container">
    			<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
				<div id="map_canvas" style="height: 450px; width: 100%;">
			    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2833.0328099638755!2d17.181853715756475!3d44.75974558819069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475e0325af3935ad%3A0xdf66cfccf1b88115!2z0JLQvtGY0LLQvtC00LUg0J_QtdGA0LUg0JrRgNC10YbQtSAyLCDQkdCw0ZrQsCDQm9GD0LrQsCA3ODAwMA!5e0!3m2!1ssr!2sba!4v1633859799389!5m2!1ssr!2sba" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
		</div>
		<br>
		<br>
		<div class="container">
			<img src="images/Ulaz.jpg" alt="Ulaz u ordinaciju DOBAR - Vojvode Pere Krece 2, Banja Luka" width="1140" height="614" style="width:100%;height:auto;" loading="lazy" decoding="async">
		</div>
	</div>

	<!-- CALL TO ACTION -->


	<!-- FOOTER -->
	<?php include 'elements/footer.php' ?>
</div>

<!-- JAVASCRIPT =============================-->
	<?php include 'elements/jsscripts.php' ?>
</body>
</html>

