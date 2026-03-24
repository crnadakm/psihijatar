<!DOCTYPE html>
<html lang="en">
	<?php include 'elements/head.php' ?>
<body id="page-top" class="subpage">
<style>
	.book {
		padding: 20px !important;
	}
</style>
<div class="body">
	<?php include 'elements/header.php' ?>

	<?php $knjigeData = getContent('knjige'); $bookItems = $knjigeData['items'] ?? []; ?>

	<div class="page-head page-head-books">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1><?= htmlspecialchars($knjigeData['page_title'] ?? 'Knjige') ?></h1>
					<ol class="breadcrumb">
						<li><?= htmlspecialchars($knjigeData['subtitle'] ?? '') ?></li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="blog-standard">
		<div class="container">
			<div class="blog-masonry blog-masonry-2col">
				<?php foreach ($bookItems as $i => $book):
					if (!($book['active'] ?? true)) continue;
				?>
				<article class="book item" id="blog<?= $i + 1 ?>">
					<div class="media">
						<img class="img-responsive" src="<?= htmlspecialchars($book['image'] ?? '') ?>" alt="<?= htmlspecialchars($book['image_alt'] ?? $book['title'] ?? '') ?>" width="250">
					</div>
					<div class="blog-excerpt">
						<h4><?= htmlspecialchars($book['title'] ?? '') ?></h4>
						<div class="post-meta">
							<span><i class="fa fa-user"></i>Autor: <?= htmlspecialchars($book['author'] ?? '') ?></span>
						</div>
						<p><?= htmlspecialchars($book['text'] ?? '') ?></p>
						<?php if (!empty($book['link'])): ?>
						<a href="<?= htmlspecialchars($book['link']) ?>" class="rmore btn btn-default btn-xs">Naručivanje naslova online</a>
						<?php endif; ?>
					</div>
				</article>
				<?php endforeach; ?>
			</div>

			<aside class="col-md-4">
			</aside>
		</div>
	</div>

	<?php include 'elements/cta.php' ?>
	<?php include 'elements/footer.php' ?>
</div>

	<?php include 'elements/jsscripts.php' ?>
	<script>
	$(window).on('load', function(){
		var $grid = $('.blog-masonry');
		$grid.isotope('layout');
		$grid.find('img').on('load error', function(){ $grid.isotope('layout'); });
	});
	</script>
</body>
</html>
