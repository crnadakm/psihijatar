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
						<li><a href="https://wa.me/<?= htmlspecialchars(ltrim($siteData['whatsapp'] ?? '+38766945702', '+')) ?>"><i class="fa fa-whatsapp"><img height="28" src="images/whatsapp.png" alt="WhatsApp kontakt" width="28" loading="lazy" decoding="async"></i></a></li>
						<li><a href="viber://chat?number=<?= htmlspecialchars($siteData['viber'] ?? '38766945702') ?>"><img height="28" src="images/viber.png" alt="Viber kontakt" width="28" loading="lazy" decoding="async"></a></li>
						<li class="facebook"><a target="_blank" href="<?= htmlspecialchars($siteData['facebook'] ?? 'https://www.facebook.com/dobarpsihijatar') ?>"><img height="28" src="images/fb.png" alt="Facebook stranica" width="28" loading="lazy" decoding="async"></a></li>
						<li class="instagram"><a target="_blank" href="<?= htmlspecialchars($siteData['instagram'] ?? 'https://www.instagram.com/dobar.zdravstvena.ustanova/') ?>"><img height="28" src="images/ig.svg" alt="Instagram stranica" width="28" loading="lazy" decoding="async"></a></li>
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

	<!-- Floating dugme „Zakažite termin" — otvara izbor Viber / WhatsApp -->
	<div class="dobar-fab" id="dobarFab">
		<div class="dobar-fab-options" id="dobarFabOptions" hidden>
			<a class="dobar-fab-opt dobar-fab-viber" href="viber://chat?number=<?= htmlspecialchars($siteData['viber'] ?? '38766945702') ?>" aria-label="Zakažite termin preko Vibera">
				<img height="22" width="22" src="images/viber.png" alt="" decoding="async"><span>Viber</span>
			</a>
			<a class="dobar-fab-opt dobar-fab-wa" href="https://wa.me/<?= htmlspecialchars(ltrim($siteData['whatsapp'] ?? '+38766945702', '+')) ?>" aria-label="Zakažite termin preko WhatsAppa">
				<img height="22" width="22" src="images/whatsapp.png" alt="" decoding="async"><span>WhatsApp</span>
			</a>
		</div>
		<button type="button" class="dobar-fab-toggle" id="dobarFabToggle" aria-expanded="false" aria-controls="dobarFabOptions" aria-label="Zakažite termin — izaberite Viber ili WhatsApp">
			<span class="dobar-fab-icon dobar-fab-icon-open" aria-hidden="true">📅</span>
			<span class="dobar-fab-icon dobar-fab-icon-close" aria-hidden="true">✕</span>
			<span class="dobar-fab-label">Zakažite termin</span>
		</button>
	</div>
	<script>
	(function () {
		var fab = document.getElementById('dobarFab');
		var toggle = document.getElementById('dobarFabToggle');
		var options = document.getElementById('dobarFabOptions');
		if (!fab || !toggle || !options) return;

		function open() {
			fab.classList.add('is-open');
			options.hidden = false;
			toggle.setAttribute('aria-expanded', 'true');
		}
		function close() {
			fab.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
			options.hidden = true;
		}

		toggle.addEventListener('click', function (e) {
			e.stopPropagation();
			if (fab.classList.contains('is-open')) { close(); } else { open(); }
		});

		// Klik van dugmeta zatvara izbor
		document.addEventListener('click', function (e) {
			if (fab.classList.contains('is-open') && !fab.contains(e.target)) { close(); }
		});

		// Escape zatvara
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { close(); }
		});
	})();
	</script>
