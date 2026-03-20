<!DOCTYPE html>
<html lang="en">
<?php include 'elements/head.php' ?>
<link rel="stylesheet" href="css/lightbox.css">

<body id="page-top" class="subpage">

	<style type="text/css">
		.circle-title {
			font-weight: 700;
			font-size: 20px;
			line-height: 155px;
			color: #fff;
		}
		.ppl-one {
			padding-top: 150px;
		}
		.text-center h3 {
			font-size: 36px;
		}
		@media only screen and (min-width: 250px) and (max-width: 767px) {
			.circle-title {
				font-size: 19px;
				line-height: 144px;
			}
			.text-center h3 {
				font-size: 24px;
			}
		}
	</style>

	<div class="body">
		<?php include 'elements/header.php' ?>

		<?php $idejaData = getContent('ideja'); ?>

		<div class="page-head page-head-ppl ppl-one">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h3><?= htmlspecialchars($idejaData['page_title'] ?? 'Otkud DOBAR dolazi i kud je naumio?') ?></h3>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="blog-standard">
						<div class="container">
							<ul class="timeline">
								<?php foreach (($idejaData['items'] ?? []) as $i => $item):
									if (!($item['active'] ?? true)) continue;
									$isLeft = ($i % 2 === 0);
								?>
								<li class="<?= $isLeft ? 'timeline-inverted img-lft' : '' ?>">
									<div class="timeline-image<?= !$isLeft ? ' img-rgt' : '' ?>">
										<h3 class="circle-title"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
									</div>
									<div class="timeline-panel">
										<div class="timeline-body">
											<p class="text-muted"><?= htmlspecialchars($item['text'] ?? '') ?></p>
										</div>
									</div>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include 'elements/cta.php' ?>

		<div class="about-info">
			<div class="container">
				<div class="col-md-10 col-md-offset-1"></div>
			</div>
			<br>
			<div class="container-fluid no-padding">
				<div class="shots">
					<?php foreach (($idejaData['gallery'] ?? []) as $gal): ?>
					<div><a href="<?= htmlspecialchars($gal['image'] ?? '') ?>" data-lightbox="image-set" data-title="<?= htmlspecialchars($gal['title'] ?? '') ?>"><img src="<?= htmlspecialchars($gal['thumb'] ?? $gal['image'] ?? '') ?>" class="img-responsive" alt="<?= htmlspecialchars($gal['title'] ?? '') ?>" /></a></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<br><br><br>

		<?php include 'elements/footer.php' ?>
	</div>

	<?php include 'elements/jsscripts.php' ?>
	<script src="js/lightbox-plus-jquery.js"></script>
</body>
</html>
