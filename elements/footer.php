<?php $siteData = getContent('site'); $footerData = getContent('footer'); ?>
	<!-- FOOTER -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<h4 class="intro-title"><?= htmlspecialchars($footerData['tagline'] ?? 'preventivne, dijagnostičke i terapijske aktivnosti u oblasti mentalnog zdravlja') ?></h4>
					<a class="navbar-brand" href="index.php"><span class="smalltext"> DR </span> DRAGAN TEŠANOVIĆ <span class="smalltext"> PSIHIJATAR</span></a>
					<ul class="list-inline social-icons icon-circle space20">
						<h4 class="intro-title"><?= htmlspecialchars($footerData['booking_title'] ?? 'Linkovi za rezervaciju termina') ?></h4>
						<li><a href="https://api.whatsapp.com/send?phone=<?= htmlspecialchars($siteData['whatsapp'] ?? '+38766945702') ?>"><i class="fa fa-whatsapp"><img height="28" src="images/whatsapp.png"></i></a></li>
						<li><a href="viber://chat?number=<?= htmlspecialchars($siteData['viber'] ?? '38766945702') ?>"><img height="28" src="images/viber.png"></a></li>
						<li class="facebook"><a target="_blank" href="<?= htmlspecialchars($siteData['facebook'] ?? 'https://www.facebook.com/dobarpsihijatar') ?>"><img height="28" src="images/fb.png"></a></li>
					</ul>
					<ul class="footer-links space40">
						<li><a href="index.php">Naslovna</a></li>
						<li><a href="onama.php">O nama</a></li>
						<li><a href="znanja.php">Znanja</a></li>
						<li><a href="aktivnosti.php">Aktivnosti</a></li>
						<li><a href="dokumenti.php">Čitanka</a></li>
						<li><a href="knjige.php">Knjige</a></li>
						<li><a href="kontakt.php">Kontakt</a></li>
					</ul>
					<p class="copy"><?= htmlspecialchars($siteData['copyright'] ?? 'Copyright © 2021 Dobar - ustanova za mentalno zdravlje. Sva prava zadržana') ?></p>
				</div>
			</div>
		</div>
	</footer>
