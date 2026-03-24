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

// CSS class to image mapping for OG fallback
$cssClassImages = [
    'page-head-health' => 'images/shutterstock_2011327436.jpg',
    'page-head-psihijatrija' => 'images/vaves.jpg',
    'page-head-o-psiho' => 'images/shutterstock_1906731082.jpg',
    'page-head-konst' => 'images/konstelacije.jpg',
    'page-head-emdr' => 'images/shutterstock_2033568857.jpg',
    'page-head-grupna' => 'images/cicrles.jpg',
    'page-head-asert' => 'images/bookcover/heart1.jpg',
    'page-head-depr' => 'images/shutterstock_1819084715.jpg',
    'page-head-plavi-sat' => 'images/plavi-sat-bg.jpg',
    'page-head-anksiolitik' => 'images/anksiolitik.jpg',
    'page-head-dementofobija' => 'images/dementophobia.jpg',
    'page-head-pst' => 'images/shutterstock_2015673821.jpg',
    'page-head-norm' => 'images/normalan.jpg',
    'page-head-bol' => 'images/bol.jpg',
    'page-head-veze' => 'images/veze.png',
    'page-head-partnerskaterapija' => 'images/partnerskaterapija.png',
    'page-head-stres' => 'images/stres.png',
    'page-head-debljina' => 'images/debljina.jpg',
    'page-head-ciklusi' => 'images/ciklusi.png',
    'page-head-four' => 'images/bookcover/water.jpg',
    'page-head-burn' => 'images/bookcover/burnout.jpg',
    'page-head-ppl' => 'images/shutterstock_1929703829.jpg',
    'page-head-know' => 'images/shutterstock_1155338887.jpg',
    'page-head-books' => 'images/polica.jpg',
    'page-head-contact' => 'images/team/05.jpg',
    'page-head-news' => 'images/shutterstock_1501617461.jpg',
    'page-head-simptom' => 'images/plant.jpg',
    'page-head-kbt' => 'images/delfini.jpg',
    'page-head-neuroloskipregled' => 'images/neuroni.webp',
];

// Resolve OG image: head_image > CSS class image
$ogImage = $headImage;
if (empty($ogImage) && isset($cssClassImages[$article['page_head_class'] ?? ''])) {
    $ogImage = $cssClassImages[$article['page_head_class']];
}
// Make absolute URL for OG
$seoData = loadSeoData();
$baseUrl = $seoData['global']['base_url'] ?? 'https://dobar.psihijatar.info';
if ($ogImage && strpos($ogImage, 'http') !== 0) {
    $ogImage = $baseUrl . '/' . $ogImage;
}

// Extract description from intro section
$ogDesc = '';
foreach ($sections as $sec) {
    if ($sec['id'] === 'intro' && !empty($sec['content'])) {
        $ogDesc = strip_tags($sec['content']);
        $ogDesc = mb_substr($ogDesc, 0, 200);
        break;
    }
}

// Set OG override for head.php
$articleOgOverride = [
    'title' => $article['page_title'] ?? '',
    'description' => $ogDesc,
    'image' => $ogImage,
];

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

	<?php $headImageAlt = htmlspecialchars($article['head_image_alt'] ?? $pageTitle); ?>
	<div class="page-head <?= $pageHeadClass ?>"<?php if ($headImage): ?> style="background: url('<?= htmlspecialchars($headImage) ?>') center/cover no-repeat;" role="img" aria-label="<?= $headImageAlt ?>"<?php endif; ?>>
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
