<!DOCTYPE html>
<html lang="en">
	<?php include 'elements/head.php' ?>
<body id="page-top" class="subpage">

<div class="body">
	<?php include 'elements/header.php' ?>

	<?php $kratkiData = getContent('kratki'); $items = $kratkiData['items'] ?? []; ?>

	<style type="text/css">
		h3,h4{ color: #229C8C; }
		h4:hover{ color: #414a39; transition-duration: 0.5s; }
		.clear{ display: inline-block; float: left; width: 100%; }
		.kratki-meta { font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
		.service-box2.service-paragraph2 p { white-space: pre-line; }
	</style>

	<div class="page-head page-head-news">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= htmlspecialchars($kratkiData['page_title'] ?? 'Kratki tekstovi') ?></h1>
					<ol class="breadcrumb">
						<li><?= htmlspecialchars($kratkiData['subtitle'] ?? '') ?></li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<?php
	$activeItems = array_values(array_filter($items, fn($it) => $it['active'] ?? true));
	if (empty($activeItems)): ?>
		<section class="services2">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<p class="text-muted" style="padding: 60px 0;">Uskoro stižu novi tekstovi.</p>
					</div>
				</div>
			</div>
		</section>
	<?php else:
		foreach (array_chunk($activeItems, 3) as $chunk): ?>
		<section class="services2">
			<div class="container">
				<div class="row">
					<?php foreach ($chunk as $item): ?>
					<div class="col-md-4 col-sm-6">
						<div class="service-box2 service-paragraph2">
							<div>
								<?php if (!empty($item['date'])): ?>
								<div class="kratki-meta"><i class="icon-clock2"></i> <?= htmlspecialchars($item['date']) ?></div>
								<?php endif; ?>
								<h4 class="intro-title"><?= htmlspecialchars($item['title'] ?? '') ?></h4>
								<p><?= htmlspecialchars($item['excerpt'] ?? '') ?></p>
							</div>
						</div>
						<?php if (!empty($item['link'])): ?>
						<a href="<?= htmlspecialchars($item['link']) ?>" class="btn btn-primary btn-lg">Pročitaj više</a>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endforeach;
	endif; ?>

	<br><br>

	<?php include 'elements/cta.php' ?>
	<?php include 'elements/footer.php' ?>
</div>

	<?php include 'elements/jsscripts.php' ?>
</body>
</html>
