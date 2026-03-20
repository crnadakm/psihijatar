<!DOCTYPE html>
<html lang="en">
	<?php include 'elements/head.php' ?>
	<link rel="stylesheet" href="css/lightbox.css">
<body id="page-top" class="subpage">

<div class="body">
	<?php include 'elements/header.php' ?>

	<?php $znanjaData = getContent('znanja'); $services = $znanjaData['services'] ?? []; ?>

	<style type="text/css">
		h3,h4{ color: #229C8C; }
		h4:hover{ color: #414a39; transition-duration: 0.5s; }
		.clear{ display: inline-block; float: left; width: 100%; }
	</style>

	<div class="page-head page-head-know">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= htmlspecialchars($znanjaData['page_title'] ?? 'O NAŠIM ZNANJIMA') ?></h1>
					<ol class="breadcrumb">
						<li><?= htmlspecialchars($znanjaData['subtitle'] ?? 'ovdje možete doznati više') ?></li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<!-- SERVICES GROUP 1 (first 3) -->
	<section class="services2">
		<div class="container">
			<div class="row">
			<?php for ($i = 0; $i < 3 && $i < count($services); $i++): $s = $services[$i]; if (!($s['active'] ?? true)) continue; ?>
				<div class="col-md-4 col-sm-6">
					<div class="service-box2 service-paragraph2">
						<div>
							<h4 class="intro-title"><?= htmlspecialchars($s['title'] ?? '') ?></h4>
							<p><?= htmlspecialchars($s['text'] ?? '') ?></p>
						</div>
					</div>
					<a href="<?= htmlspecialchars($s['link'] ?? '#') ?>" class="btn btn-primary btn-lg">Pročitaj više</a>
				</div>
			<?php endfor; ?>
			</div>
		</div>
	</section>
<br><br>

	<!-- QUOTES SECTION 1 -->
	<?php $q1 = $znanjaData['quotes_1'] ?? []; if (!empty($q1)): ?>
	<section class="testimonial-p testimonial-p6" id="testimonial">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="quote">
						<?php foreach ($q1 as $q): ?>
						<div class="testimonial">
							<div class="quote text-center quote-text-center-ggc"><?= htmlspecialchars($q['text'] ?? '') ?></div>
							<div class="author"><cite><b><?= htmlspecialchars($q['author'] ?? '') ?></b></cite></div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- SERVICES GROUP 2 (items 4-6) -->
	<section class="services2">
		<div class="container">
			<?php for ($i = 3; $i < 6 && $i < count($services); $i++): $s = $services[$i]; if (!($s['active'] ?? true)) continue; ?>
				<div class="col-md-4 col-sm-6">
					<div class="service-box2 service-paragraph2">
						<div>
							<h4 class="intro-title"><?= htmlspecialchars($s['title'] ?? '') ?></h4>
							<p><?= htmlspecialchars($s['text'] ?? '') ?></p>
						</div>
					</div>
					<a href="<?= htmlspecialchars($s['link'] ?? '#') ?>" class="btn btn-primary btn-lg">Pročitaj više</a>
				</div>
			<?php endfor; ?>
			<div class="clear"></div>
		</div>
	</section>
	<br>

	<!-- QUOTES SECTION 2 -->
	<?php $q2 = $znanjaData['quotes_2'] ?? []; if (!empty($q2)): ?>
	<section class="testimonial-p testimonial-p4" id="testimonial">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="quote">
						<?php foreach ($q2 as $q): ?>
						<div class="testimonial">
							<div class="quote text-center quote-text-center-ggc"><?= htmlspecialchars($q['text'] ?? '') ?></div>
							<div class="author"><cite><b><?= htmlspecialchars($q['author'] ?? '') ?></b></cite></div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- SERVICES GROUP 3+ (remaining items, 3 per row) -->
	<?php $remaining = array_slice($services, 6); $chunks = array_chunk($remaining, 3); ?>
	<?php foreach ($chunks as $chunk): ?>
	<section class="services2">
		<div class="container">
			<?php foreach ($chunk as $s): if (!($s['active'] ?? true)) continue; ?>
				<div class="col-md-4 col-sm-6">
					<div class="service-box2 service-paragraph2">
						<div>
							<h4 class="intro-title"><?= htmlspecialchars($s['title'] ?? '') ?></h4>
							<p><?= htmlspecialchars($s['text'] ?? '') ?></p>
						</div>
					</div>
					<a href="<?= htmlspecialchars($s['link'] ?? '#') ?>" class="btn btn-primary btn-lg">Pročitaj više</a>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endforeach; ?>

	<br><br>

	<?php include 'elements/cta.php' ?>

	<div class="about-info">
		<div class="container">
			<div class="col-md-10 col-md-offset-1"></div>
		</div>
		<br>
		<div class="container-fluid no-padding">
			<div class="shots">
				<?php foreach (($znanjaData['gallery'] ?? []) as $gal): ?>
				<div><a href="<?= htmlspecialchars($gal['image'] ?? '') ?>" data-lightbox="image-set" data-title="<?= htmlspecialchars($gal['title'] ?? '') ?>"><img src="<?= htmlspecialchars($gal['thumb'] ?? $gal['image'] ?? '') ?>" class="img-responsive" alt="<?= htmlspecialchars($gal['title'] ?? '') ?>"/></a></div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<br><br><br>

	<?php include 'elements/footer.php' ?>
</div>

	<script src="js/lightbox-plus-jquery.js"></script>
	<?php include 'elements/jsscripts.php' ?>
</body>
</html>
