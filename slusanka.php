<!DOCTYPE html>
<html lang="en">
<style>
	.text-center p{ color: white; }
	.audio-card { background: #f9f9f9; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
	.audio-card h4 { color: #229C8C; margin-bottom: 10px; }
	.audio-card p { color: #666; font-size: 14px; }
	.audio-card audio { width: 100%; margin-top: 10px; }
	.audio-card .audio-meta { font-size: 12px; color: #999; margin-top: 8px; }
	.audio-card .audio-cover { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
</style>
	<?php include 'elements/head.php' ?>
<body id="page-top" class="subpage">

<div class="body">
	<?php include 'elements/header.php' ?>

	<?php $slusankaData = getContent('slusanka'); $audioItems = $slusankaData['items'] ?? []; ?>

	<div class="page-head">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= htmlspecialchars($slusankaData['page_title'] ?? 'Slušanka') ?></h1>
					<p><?= htmlspecialchars($slusankaData['subtitle'] ?? '') ?></p>
					<p><?= htmlspecialchars($slusankaData['description'] ?? '') ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="about-info">
		<div class="container">
			<div class="col-md-10 col-md-offset-1 text-center">
				<?php
				$activeAudio = array_filter($audioItems, fn($a) => $a['active'] ?? true);
				if (empty($activeAudio)):
				?>
				<img src="<?= htmlspecialchars($slusankaData['placeholder_image'] ?? 'images/work.jpg') ?>" width="100%" style="max-width: 500px; margin-bottom: 50px;">
				<?php else: ?>
				<?php foreach ($activeAudio as $audio): ?>
				<div class="audio-card text-left">
					<div class="d-flex align-items-start" style="display:flex;">
						<?php if (!empty($audio['cover_image'])): ?>
						<img src="<?= htmlspecialchars($audio['cover_image']) ?>" class="audio-cover" alt="<?= htmlspecialchars($audio['title'] ?? '') ?>">
						<?php endif; ?>
						<div style="flex:1;">
							<h4><?= htmlspecialchars($audio['title'] ?? '') ?></h4>
							<?php if (!empty($audio['description'])): ?>
							<p><?= htmlspecialchars($audio['description']) ?></p>
							<?php endif; ?>
							<?php if (!empty($audio['audio_url'])): ?>
							<audio controls preload="metadata">
								<source src="<?= htmlspecialchars($audio['audio_url']) ?>" type="audio/mpeg">
								Vaš pregledač ne podržava audio element.
							</audio>
							<?php endif; ?>
							<div class="audio-meta">
								<?php if (!empty($audio['duration'])): ?>
								<span>Trajanje: <?= htmlspecialchars($audio['duration']) ?></span>
								<?php endif; ?>
								<?php if (!empty($audio['date'])): ?>
								<span style="margin-left:15px;">Objavljeno: <?= htmlspecialchars($audio['date']) ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
				<br>
			</div>
		</div>
	</div>

	<?php include 'elements/cta.php' ?>
	<?php include 'elements/footer.php' ?>
</div>

	<?php include 'elements/jsscripts.php' ?>
</body>
</html>
