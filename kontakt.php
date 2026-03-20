<!DOCTYPE html>
<html lang="en">
<meta property="og:title" content="DOBAR - Kontakt">
<meta property="og:image" content="https://dobar.psihijatar.info/images/team/05.jpg">
	<?php include 'elements/head.php' ?>
<body id="page-top" class="subpage">

<div class="body">
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
					<div class="sidebar">
						<h3 class="intro-title">Online zakazivanje</h3>
						<ul class="list-inline social-icons icon-circle">
							<!--li><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
							<li><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li-->
							<li><a href="https://api.whatsapp.com/send?phone=+38766945702"><i class="fa fa-whatsapp"><img height="40" src="images/whatsapp.png"></i></a></li>
							<li><a href="viber://chat?number=38766945702"><img height="40" src="images/viber.png"></i></a></li>				
						</ul>
						<br>
						<br>
						<h2 class="intro-title">Kako do nas</h2>
						<ul class="list">
							<li><i class="icon-home"></i>Ulica Vojvode Pere Krece 2 <br><span class="pl-20">Banja Luka, 78 000</span></li>
							<li><i class="icon-call"></i><abbr title="Phone">+387 66 945 702</abbr> </li>
							<small>*Broj je samo za viber poruke</small>
							<!--li><i class="icon-phone"></i><abbr title="Mobile">M:</abbr> (123) 456-7890</li>
							<li><i class="icon-mail"></i><a href="mailto:info@drdobar.com">teatrorapija@gmail.com</a></li-->
						</ul>
						
					</div>
				</aside>

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
			<img src="images/Ulaz.jpg" width="100%">
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

