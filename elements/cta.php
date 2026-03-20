<?php $ctaData = getContent('cta'); ?>
	<div class="cta-wrap">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-8 col-md-offset-2">
					<h2><?= htmlspecialchars($ctaData['heading'] ?? 'Ako imate pitanje slobodno napišite') ?></h2>
					<div class="space20"></div>
					<a href="mailto:<?= htmlspecialchars($ctaData['email'] ?? 'dobar@psihijatar.info') ?>" class="btn btn-lg btn-default"><?= htmlspecialchars($ctaData['button_text'] ?? 'Ovdje') ?></a>
					<div class="space20"></div>
					<p class="cta-text"><?= htmlspecialchars($ctaData['subtext'] ?? 'Rado ćemo odgovoriti') ?></p>
				</div>
			</div>
		</div>
	</div>
