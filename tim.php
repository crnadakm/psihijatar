<?php require_once __DIR__ . '/php/data-loader.php'; ?>
<?php
	$teamData = getContent('team');
	$activeMembers = array_values(array_filter($teamData ?? [], fn($m) => ($m['active'] ?? true) !== false));

	// Worker detail (legacy support: tim.php?ime=dragan)
	$workerSlug = strtolower($_GET['ime'] ?? '');
	$workerData = null;
	if ($workerSlug !== '') {
		foreach ($activeMembers as $m) {
			$slug = strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', $m['name'] ?? '')[0] ?? ''));
			if ($slug === $workerSlug) { $workerData = $m; break; }
		}
	}

	// Pass worker-specific OG data to head.php
	if ($workerData) {
		$articleOgOverride = [
			'title' => 'Naš tim: ' . $workerData['name'] . ' | ZU DOBAR',
			'description' => $workerData['description'] ?? '',
			'image' => 'https://dobar.psihijatar.info/' . ($workerData['image'] ?? ''),
		];
	}

	// Build slug for anchor IDs
	function memberAnchor($m) {
		return strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', $m['name'] ?? '')[0] ?? ''));
	}
?>
<!DOCTYPE html>
<html lang="sr">
<?php include 'elements/head.php' ?>
<link rel="stylesheet" href="css/lightbox.css">

<body id="page-top" class="subpage">

	<style type="text/css">
		.circle-title { font-weight: 700; font-size: 20px; line-height: 155px; color: #fff; }
		.ppl-one { padding-top: 150px; }
		.text-center h3 { font-size: 36px; }
		@media only screen and (min-width: 250px) and (max-width: 767px) {
			.circle-title { font-size: 19px; line-height: 144px; }
			.text-center h3 { font-size: 24px; }
		}
	</style>

	<div class="body">
		<!-- HEADER -->
		<?php include 'elements/header.php' ?>

		<!-- PAGE HEAD -->
		<div class="page-head page-head-ppl">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1>Ljudi</h1>
						<h3>koji podržavaju koncept D.O.B.A.R.</h3>
					</div>
				</div>
			</div>
		</div>

		<!-- TEAM -->
		<div class="team team-dark">
			<div class="container">

				<?php if (empty($activeMembers)): ?>
					<div class="row"><div class="col-md-12 text-center"><p>Tim će uskoro biti predstavljen.</p></div></div>
				<?php else:
					// First member gets the big featured card
					$first = $first = $activeMembers[0];
					$rest = array_slice($activeMembers, 1);
				?>

				<!-- Featured (first member, full width) -->
				<div class="row">
					<div id="<?= htmlspecialchars(memberAnchor($first)) ?>" class="col-sm-12 col-md-12 team-box team-box-p text-center">
						<figure class="col-sm-6 col-md-6">
							<img class="img-responsive" src="<?= htmlspecialchars($first['image'] ?? '') ?>" alt="<?= htmlspecialchars(($first['image_alt'] ?? '') ?: $first['name']) ?>" loading="lazy" decoding="async">
						</figure>
						<div class="col-sm-6 col-md-6">
							<h4 class="intro-title"><?= htmlspecialchars($first['name']) ?></h4><br>
							<span><?= nl2br(htmlspecialchars($first['description'] ?? '')) ?></span><br><br>
						</div>
					</div>
				</div>

				<div class="space40"></div>

				<!-- Rest of team in pairs -->
				<?php foreach (array_chunk($rest, 2) as $pair): ?>
				<div class="row">
					<?php foreach ($pair as $m): ?>
					<div class="col-sm-6 col-md-6">
						<div id="<?= htmlspecialchars(memberAnchor($m)) ?>" class="team-box text-center team-coworker">
							<figure>
								<img class="img-responsive" src="<?= htmlspecialchars($m['image'] ?? '') ?>" alt="<?= htmlspecialchars(($m['image_alt'] ?? '') ?: $m['name']) ?>" loading="lazy" decoding="async">
							</figure>
							<div>
								<h4 class="intro-title"><?= htmlspecialchars($m['name']) ?></h4>
								<span><?= nl2br(htmlspecialchars($m['description'] ?? '')) ?></span>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<br>
				<?php endforeach; ?>

				<?php endif; ?>

			</div>
		</div>

		<!-- CALL TO ACTION -->
		<?php include 'elements/cta.php' ?>

		</div>
		<br>
		<br>
		<br>


		<!-- FOOTER -->
		<?php include 'elements/footer.php' ?>
	</div>

	<!-- JAVASCRIPT =============================-->
	<?php include 'elements/jsscripts.php' ?>
	<script src="js/lightbox-plus-jquery.js"></script>
</body>

</html>
