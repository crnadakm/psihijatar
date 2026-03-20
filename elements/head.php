<?php require_once __DIR__ . '/../php/data-loader.php'; ?>
<head>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="author" content="Dragan Tešanović">

	<!-- SEO TAGS FROM ADMIN PANEL -->
<?php echo renderSeoHead(); ?>

	<!-- FAVICON -->
	<link rel="shortcut icon" href="images/icon.png">

	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- ICONS -->
	<link rel="stylesheet" href="css/icons/fontawesome/css/style.css">
	<link rel="stylesheet" href="css/icons/style.css">

	<!-- THEME / PLUGIN CSS -->
	<link rel="stylesheet" href="js/vendors/flexslider/flexslider.css">
	<link rel="stylesheet" href="js/vendors/slick/slick.css">
	<link rel="stylesheet" href="css/style.css">
<?php
	$seoGlobal = loadSeoData()['global'] ?? [];
	$fbPixel = $seoGlobal['fb_pixel'] ?? '802963224108602';
	$gaId = $seoGlobal['google_analytics'] ?? 'G-QLNGMJ0T1B';
?>
	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '<?= htmlspecialchars($fbPixel) ?>');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=<?= htmlspecialchars($fbPixel) ?>&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($gaId) ?>"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', '<?= htmlspecialchars($gaId) ?>');
	</script>

</head>
