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

	<!-- Floating dugme „Zakažite termin" — otvara modal sa izborom Viber / WhatsApp -->
	<div class="dobar-fab">
		<button type="button" class="dobar-fab-toggle" id="dobarFabToggle" aria-haspopup="dialog" aria-controls="dobarModal" aria-label="Zakažite termin — izaberite Viber ili WhatsApp">
			<span class="dobar-fab-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM7 9h10v2H7V9zm0 4h7v2H7v-2z"/></svg>
			</span>
			<span class="dobar-fab-label">Zakažite termin</span>
		</button>
	</div>

	<!-- Modal: izbor kanala za zakazivanje -->
	<div class="dobar-modal" id="dobarModal" role="dialog" aria-modal="true" aria-labelledby="dobarModalTitle" hidden>
		<div class="dobar-modal-backdrop" data-dobar-close></div>
		<div class="dobar-modal-card" role="document">
			<button type="button" class="dobar-modal-close" data-dobar-close aria-label="Zatvori">&times;</button>
			<div class="dobar-modal-badge" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM7 9h10v2H7V9zm0 4h7v2H7v-2z"/></svg>
			</div>
			<h3 class="dobar-modal-title" id="dobarModalTitle">Zakažite termin</h3>
			<p class="dobar-modal-sub">Izaberite kako želite da nam se javite — odgovaramo brzo.</p>
			<div class="dobar-modal-actions">
				<a class="dobar-choice dobar-choice-viber" href="viber://chat?number=<?= htmlspecialchars($siteData['viber'] ?? '38766945702') ?>" aria-label="Zakažite termin ili pregled preko Vibera">
					<span class="dobar-choice-ico"><img height="26" width="26" src="images/viber.png" alt="" decoding="async"></span>
					<span class="dobar-choice-txt"><b>Viber</b><small>Pozovite ili pošaljite poruku</small></span>
					<span class="dobar-choice-arrow" aria-hidden="true">&rsaquo;</span>
				</a>
				<a class="dobar-choice dobar-choice-wa" href="https://wa.me/<?= htmlspecialchars(ltrim($siteData['whatsapp'] ?? '+38766945702', '+')) ?>" aria-label="Zakažite termin ili pregled preko WhatsAppa">
					<span class="dobar-choice-ico"><img height="26" width="26" src="images/whatsapp.png" alt="" decoding="async"></span>
					<span class="dobar-choice-txt"><b>WhatsApp</b><small>Pošaljite poruku</small></span>
					<span class="dobar-choice-arrow" aria-hidden="true">&rsaquo;</span>
				</a>
			</div>
		</div>
	</div>
	<script>
	(function () {
		var toggle = document.getElementById('dobarFabToggle');
		var modal = document.getElementById('dobarModal');
		if (!toggle || !modal) return;
		var card = modal.querySelector('.dobar-modal-card');

		function open() {
			modal.hidden = false;
			// sljedeći frame -> okidamo CSS tranzicije
			requestAnimationFrame(function () { modal.classList.add('is-open'); });
			document.body.style.overflow = 'hidden';
			toggle.setAttribute('aria-expanded', 'true');
		}
		function close() {
			modal.classList.remove('is-open');
			document.body.style.overflow = '';
			toggle.setAttribute('aria-expanded', 'false');
			// sačekaj kraj animacije pa sakrij
			window.setTimeout(function () {
				if (!modal.classList.contains('is-open')) { modal.hidden = true; }
			}, 320);
		}

		toggle.addEventListener('click', open);

		// Klik na pozadinu ili dugme za zatvaranje
		modal.addEventListener('click', function (e) {
			if (e.target.hasAttribute('data-dobar-close')) { close(); }
		});
		// Klik unutar kartice ne zatvara
		if (card) { card.addEventListener('click', function (e) { e.stopPropagation(); }); }

		// Klik na opciju (Viber/WhatsApp) zatvara modal
		var choices = modal.querySelectorAll('.dobar-choice');
		for (var i = 0; i < choices.length; i++) {
			choices[i].addEventListener('click', function () { close(); });
		}

		// Escape zatvara
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !modal.hidden) { close(); }
		});
	})();
	</script>
