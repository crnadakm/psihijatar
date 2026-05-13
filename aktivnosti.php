<!DOCTYPE html>
<html lang="sr">
<?php include 'elements/head.php' ?>
<link rel="stylesheet" href="css/lightbox.css">
<style>
	/* Standardizovan accordion stil scoped pod .ak-page */
	.ak-page .blog-standard h1 { color: #000; }
	.ak-page .ak-category { margin-bottom: 48px; }
	.ak-page .ak-category-head { margin: 32px 0 8px; padding-bottom: 12px; border-bottom: 2px solid #229C8C; }
	.ak-page .ak-category-head h2 { font-size: 24px; color: #229C8C; margin: 0; font-weight: 700; }
	.ak-page .ak-category-head p { color: #555; margin: 8px 0 0; font-style: italic; }
	.ak-page .ak-item { background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 12px; overflow: hidden; transition: box-shadow 0.2s; }
	.ak-page .ak-item:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
	.ak-page .ak-item-toggle { display: block; padding: 16px 22px; color: #202020; font-size: 16px; font-weight: 600; cursor: pointer; text-decoration: none; position: relative; padding-right: 50px; }
	.ak-page .ak-item-toggle:hover { color: #229C8C; text-decoration: none; }
	.ak-page .ak-item-toggle::after { content: '+'; position: absolute; right: 22px; top: 50%; transform: translateY(-50%); font-size: 22px; font-weight: 300; color: #229C8C; transition: transform 0.2s; }
	.ak-page .ak-item-toggle[aria-expanded="true"]::after { content: '−'; }
	.ak-page .ak-item-body { padding: 0 22px 18px; color: #444; line-height: 1.7; }
	.ak-page .ak-collapse { display: none; }
	.ak-page .ak-collapse.open { display: block; }
	.ak-page .ak-upcoming { background: #fafaf8; padding: 28px; border-radius: 8px; margin-top: 32px; border-left: 4px solid #d4a857; }
	.ak-page .ak-upcoming h2 { color: #d4a857; font-size: 20px; margin-top: 0; }
	.ak-page .ak-upcoming h3 { font-size: 16px; color: #555; margin-top: 24px; }
	.ak-page .ak-upcoming .ak-item { background: #fff; }
	.ak-page .ak-upcoming .ak-item-toggle { color: #555; }
	.ak-page .ak-gallery { margin: 64px 0 32px; }
	.ak-page .ak-gallery .shots { display: grid; grid-template-columns: repeat(6, 1fr); gap: 0; }
	.ak-page .ak-gallery .shots > div img { width: 100%; height: auto; display: block; transition: transform 0.3s; }
	.ak-page .ak-gallery .shots > div:hover img { transform: scale(1.02); }
	@media (max-width: 768px) {
		.ak-page .ak-category-head h2 { font-size: 20px; }
		.ak-page .ak-item-toggle { font-size: 15px; padding: 14px 18px; padding-right: 44px; }
		.ak-page .ak-gallery .shots { grid-template-columns: repeat(3, 1fr); }
	}
</style>

<body id="page-top" class="subpage ak-page">

	<div class="body">
		<?php include 'elements/header.php' ?>

		<!-- PAGE HEAD -->
		<div class="page-head page-head-news">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1><?= htmlspecialchars(getContent('aktivnosti')['page_title'] ?? 'Aktivnosti') ?></h1>
					</div>
				</div>
			</div>
		</div>

		<?php $ak = getContent('aktivnosti'); ?>

		<div class="blog-standard">
			<div class="container">
				<div class="col-md-10 col-md-offset-1">

					<?php if (!empty($ak['intro_title'])): ?>
					<h1 style="margin-top:32px;"><?= htmlspecialchars($ak['intro_title']) ?></h1>
					<?php endif; ?>

					<?php foreach (($ak['categories'] ?? []) as $catIdx => $cat):
						if (!($cat['active'] ?? true)) continue;
						$activeItems = array_values(array_filter($cat['items'] ?? [], fn($it) => $it['active'] ?? true));
						if (empty($activeItems)) continue;
						$catId = $cat['id'] ?: 'cat' . $catIdx;
					?>
					<section class="ak-category" id="<?= htmlspecialchars($catId) ?>">
						<div class="ak-category-head">
							<h2><?= htmlspecialchars($cat['title']) ?></h2>
							<?php if (!empty($cat['subtitle'])): ?>
							<p><?= htmlspecialchars($cat['subtitle']) ?></p>
							<?php endif; ?>
						</div>
						<?php foreach ($activeItems as $itIdx => $it):
							$itemId = $catId . '-' . $itIdx;
						?>
						<div class="ak-item">
							<a class="ak-item-toggle" href="#<?= htmlspecialchars($itemId) ?>" data-target="<?= htmlspecialchars($itemId) ?>" aria-expanded="false">
								<?= htmlspecialchars($it['title']) ?>
							</a>
							<div class="ak-collapse" id="<?= htmlspecialchars($itemId) ?>">
								<div class="ak-item-body"><?= nl2br(htmlspecialchars($it['description'])) ?></div>
							</div>
						</div>
						<?php endforeach; ?>
					</section>
					<?php endforeach; ?>

					<?php
					$upcomingCats = array_filter($ak['upcoming_categories'] ?? [], fn($c) => $c['active'] ?? true);
					if (!empty($upcomingCats)): ?>
					<div class="ak-upcoming">
						<h2><?= htmlspecialchars($ak['upcoming_title'] ?? 'U pripremi:') ?></h2>
						<?php foreach ($upcomingCats as $ucIdx => $uc):
							$activeUcItems = array_values(array_filter($uc['items'] ?? [], fn($it) => $it['active'] ?? true));
							if (empty($activeUcItems)) continue;
						?>
						<h3><?= htmlspecialchars($uc['title']) ?></h3>
						<?php foreach ($activeUcItems as $uiIdx => $ui):
							$uItemId = 'upcoming-' . $ucIdx . '-' . $uiIdx;
						?>
						<div class="ak-item">
							<a class="ak-item-toggle" href="#<?= htmlspecialchars($uItemId) ?>" data-target="<?= htmlspecialchars($uItemId) ?>" aria-expanded="false">
								<?= htmlspecialchars($ui['title']) ?>
							</a>
							<?php if (!empty($ui['description'])): ?>
							<div class="ak-collapse" id="<?= htmlspecialchars($uItemId) ?>">
								<div class="ak-item-body"><?= nl2br(htmlspecialchars($ui['description'])) ?></div>
							</div>
							<?php endif; ?>
						</div>
						<?php endforeach; endforeach; ?>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>

		<hr>

		<!-- CALL TO ACTION -->
		<?php include 'elements/cta.php' ?>

		<!-- GALLERY -->
		<?php
		$gallery = array_filter($ak['gallery'] ?? [], fn($g) => $g['active'] ?? true);
		if (!empty($gallery)): ?>
		<div class="ak-gallery">
			<div class="container-fluid no-padding">
				<div class="shots">
					<?php foreach ($gallery as $g): ?>
					<div>
						<a href="<?= htmlspecialchars($g['image']) ?>" data-lightbox="image-set" data-title="<?= htmlspecialchars($g['title']) ?>">
							<img src="<?= htmlspecialchars($g['thumb'] ?: $g['image']) ?>" class="img-responsive" alt="<?= htmlspecialchars($g['alt'] ?? $g['title']) ?>" loading="lazy" decoding="async">
						</a>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<br><br>

		<!-- FOOTER -->
		<?php include 'elements/footer.php' ?>
	</div>

	<?php include 'elements/jsscripts.php' ?>
	<script src="js/lightbox-plus-jquery.js"></script>
	<script>
	// Simple accordion: only one open at a time within same category
	document.querySelectorAll('.ak-page .ak-item-toggle').forEach(function(toggle) {
		toggle.addEventListener('click', function(e) {
			e.preventDefault();
			var target = document.getElementById(this.getAttribute('data-target'));
			if (!target) return;
			var isOpen = target.classList.contains('open');
			var section = this.closest('.ak-category, .ak-upcoming');
			if (section) {
				section.querySelectorAll('.ak-collapse.open').forEach(function(c) { c.classList.remove('open'); });
				section.querySelectorAll('.ak-item-toggle[aria-expanded="true"]').forEach(function(t) { t.setAttribute('aria-expanded', 'false'); });
			}
			if (!isOpen) {
				target.classList.add('open');
				this.setAttribute('aria-expanded', 'true');
			}
		});
	});
	</script>
</body>
</html>
