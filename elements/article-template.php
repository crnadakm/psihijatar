<?php
// Usage: set $articleKey before including this file
// Example: $articleKey = 'mentalnozdravlje'; include 'elements/article-template.php';
require_once __DIR__ . '/../php/data-loader.php';
$articles = getContent('articles');
$article = $articles[$articleKey] ?? null;
if (!$article) { echo '<p>Članak nije pronađen.</p>'; return; }

$pageTitle = htmlspecialchars($article['page_title'] ?? '');
$pageHeadClass = htmlspecialchars($article['page_head_class'] ?? 'page-head-health');
$headImage = $article['head_image'] ?? '';
$sidebarTitle = $article['sidebar_title'] ?? '';
$sections = $article['sections'] ?? [];

// Separate intro from titled sections
$intro = null;
$namedSections = [];
foreach ($sections as $sec) {
    if (empty($sec['title']) && $sec['id'] === 'intro') {
        $intro = $sec;
    } else {
        $namedSections[] = $sec;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<?php include __DIR__ . '/head.php' ?>
<body id="page-top" class="subpage">

<div class="body">
	<style type="text/css">
		h1,h2,h3,h4 { color: black; scroll-margin: 100px; }
		p { color: black; font-size: 15px; }
		.article-content ul, .article-content ol, .article-content li { margin: inherit; padding: inherit; list-style: unset; }
		.shaded { background-color: lightgray; border-radius: 4px; padding: 4px 8px; }
	</style>

	<?php include __DIR__ . '/header.php' ?>

	<div class="page-head <?= $pageHeadClass ?>"<?php if ($headImage): ?> style="background: url('<?= htmlspecialchars($headImage) ?>') center/cover no-repeat;"<?php endif; ?>>
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= $pageTitle ?></h1>
				</div>
			</div>
		</div>
	</div>

	<div class="blog-standard">
		<div class="container">
			<?php if (!empty($namedSections) && !empty($sidebarTitle)): ?>
			<div class="col-md-4">
				<div class="side-widget">
					<h5 class="intro-title"><?= htmlspecialchars($sidebarTitle) ?></h5>
					<ul class="cat">
						<?php foreach ($namedSections as $sec): ?>
						<li><a href="#<?= htmlspecialchars($sec['id']) ?>"><?= htmlspecialchars($sec['title']) ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="col-md-8 article-content">
			<?php else: ?>
			<div class="col-md-10 col-md-offset-1 article-content">
			<?php endif; ?>

				<?php if ($intro): ?>
				<?php if (!empty($intro['html'])): ?>
				<?= $intro['content'] ?>
				<?php else: ?>
				<p><?= nl2br(htmlspecialchars($intro['content'])) ?></p>
				<?php endif; ?>
				<?php endif; ?>

				<?php foreach ($namedSections as $sec): ?>
				<br><h3 id="<?= htmlspecialchars($sec['id']) ?>"><?= htmlspecialchars($sec['title']) ?></h3><br>
				<?php if (!empty($sec['html'])): ?>
				<?= $sec['content'] ?>
				<?php else: ?>
				<p><?= nl2br(htmlspecialchars($sec['content'])) ?></p>
				<?php endif; ?>
				<?php endforeach; ?>

			</div>
		</div>
	</div>

	<?php include __DIR__ . '/footer.php' ?>
</div>

	<?php include __DIR__ . '/jsscripts.php' ?>
	<script>
	document.querySelectorAll('.cat a[href^="#"]').forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			var target = document.querySelector(this.getAttribute('href'));
			if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	});
	</script>
</body>
</html>
