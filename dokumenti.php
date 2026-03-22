<!DOCTYPE html>
<html lang="en">
	<?php include 'elements/head.php' ?>
<body id="page-top" class="subpage">

<div class="body">
	<?php include 'elements/header.php' ?>

	<?php $citankaData = getContent('citanka'); ?>

	<div class="page-head">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= htmlspecialchars($citankaData['page_title'] ?? 'Čitanka') ?></h1>
					<ol class="breadcrumb">
						<li><?= htmlspecialchars($citankaData['subtitle'] ?? '') ?></li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="portfolio-wrap portfolio-3col">
		<div class="container">
			<div class="portfolio-grid">
				<?php foreach (($citankaData['items'] ?? []) as $i => $item):
					if (!($item['active'] ?? true)) continue;
					$bgColor = $item['bg_color'] ?? '#229C8C';
				?>
				<div class="portfolio-item dataoption<?= $i + 1 ?>" style="background-color: <?= htmlspecialchars($bgColor) ?>;">
					<a href="<?= htmlspecialchars($item['link'] ?? '#') ?>">
						<?php if (!empty($item['image'])): ?>
						<img class="img-responsive" src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>">
						<?php endif; ?>
						<div class="portfolio-item-overlay" style="background-color: <?= htmlspecialchars($bgColor) ?>;">
							<div class="portfolio-item-overlay-inner">
								<h3><?= htmlspecialchars($item['title'] ?? '') ?></h3>
								<p><?= htmlspecialchars($item['text'] ?? '') ?></p>
								<a href="<?= htmlspecialchars($item['link'] ?? '#') ?>" class="btn btn-knowl">Pročitaj više</a>
							</div>
						</div>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
			<br><br>
			<?php if (!empty($citankaData['upcoming_text'])): ?>
			<div class="col-md-10 col-md-offset-1">
				<h3 class="intro-title"><?= htmlspecialchars($citankaData['upcoming_text']) ?></h3>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<?php include 'elements/cta.php' ?>
	<?php include 'elements/footer.php' ?>
</div>

	<?php include 'elements/jsscripts.php' ?>
</body>
</html>
