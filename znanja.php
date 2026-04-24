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

	<?php
	// Configurable quote slider positions (after which card index to show)
	$q1Pos = (int)($znanjaData['quotes_1_after'] ?? 3);
	$q2Pos = (int)($znanjaData['quotes_2_after'] ?? 6);
	$q1 = $znanjaData['quotes_1'] ?? [];
	$q2 = $znanjaData['quotes_2'] ?? [];
	$activeServices = array_values(array_filter($services, fn($s) => $s['active'] ?? true));
	$total = count($activeServices);

	// Build list of break points: [position => quote_data]
	$breaks = [];
	if (!empty($q1)) $breaks[$q1Pos][] = ['quotes' => $q1, 'class' => 'testimonial-p6'];
	if (!empty($q2)) $breaks[$q2Pos][] = ['quotes' => $q2, 'class' => 'testimonial-p4'];

	// Render each group of cards between breaks, and insert quote sliders at break points
	$renderCardGroup = function($group) {
		if (empty($group)) return;
		// Chunk by 3 to match original visual spacing between rows
		foreach (array_chunk($group, 3) as $chunk) {
			echo '<section class="services2"><div class="container"><div class="row">';
			foreach ($chunk as $s) {
				echo '<div class="col-md-4 col-sm-6"><div class="service-box2 service-paragraph2"><div>';
				echo '<h4 class="intro-title">' . htmlspecialchars($s['title'] ?? '') . '</h4>';
				echo '<p>' . htmlspecialchars($s['text'] ?? '') . '</p>';
				echo '</div></div>';
				echo '<a href="' . htmlspecialchars($s['link'] ?? '#') . '" class="btn btn-primary btn-lg">Pročitaj više</a></div>';
			}
			echo '<div class="clear"></div></div></div></section>';
		}
	};

	$renderQuotes = function($quotesSet, $cls) {
		echo '<section class="testimonial-p ' . $cls . '"><div class="container"><div class="row"><div class="col-md-12"><div class="quote">';
		foreach ($quotesSet as $q) {
			echo '<div class="testimonial">';
			echo '<div class="quote text-center quote-text-center-ggc">' . htmlspecialchars($q['text'] ?? '') . '</div>';
			echo '<div class="author"><cite><b>' . htmlspecialchars($q['author'] ?? '') . '</b></cite></div>';
			echo '</div>';
		}
		echo '</div></div></div></div></section>';
	};

	// Walk through cards, emitting quote sliders at configured break positions.
	// Between break points, all cards render in a single <section> — Bootstrap col-md-4 wraps to 3-per-row automatically.
	$currentGroup = [];
	for ($i = 0; $i <= $total; $i++) {
		if (isset($breaks[$i])) {
			$renderCardGroup($currentGroup);
			$currentGroup = [];
			foreach ($breaks[$i] as $b) {
				$renderQuotes($b['quotes'], $b['class']);
			}
		}
		if ($i < $total) {
			$currentGroup[] = $activeServices[$i];
		}
	}
	$renderCardGroup($currentGroup);
	?>

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
