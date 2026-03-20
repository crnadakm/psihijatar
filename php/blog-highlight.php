

<?php
 function htmlBlogHighlight(string $link = "", string $author = "", string $img = "", string $title = "", string $date = "" )
{
	$authorString = $author == "" ? "" : "<i class=\"icon-head\"></i> {$author}";
	$html = "
	<article class=\"blog-item col-md-3 col-sm-6 no-padding\">
		<div class=\"blog-mason-item\">
			<a href=\"{$link}\">
			<img src=\"{$img}\" class=\"img-responsive img-hover\" alt=\"\">
			</a>
			<div class=\"blog-mason-excerpt\">
				<h2>
					<a href=\"{$link}\">{$title}</a>
				</h2>
				<div class=\"blog-meta\"><i class=\"icon-clock2\"></i> {$date} $authorString </div>
			</div>
		</div>
	</article>
	";
	return $html;
}

?>