<?php require_once 'php/data-loader.php'; ?>
<!DOCTYPE html>
<html lang="sr">
<head>
	<?php include 'elements/head.php' ?>
	<style>
		/* ============================================================
		   DEMO HOMEPAGE — naslovna-novi-dizajn.php
		   Self-contained CSS scoped to .nd-* classes so it doesn't
		   bleed into the rest of the site.
		   ============================================================ */
		:root {
			--nd-primary: #229C8C;
			--nd-primary-dark: #1a7d6f;
			--nd-primary-darker: #145e54;
			--nd-primary-light: #e7f5f3;
			--nd-primary-bg: #f0faf8;
			--nd-accent: #d4a857;
			--nd-dark: #1f2d28;
			--nd-text: #2c3e35;
			--nd-text-muted: #6c7a73;
			--nd-light: #ffffff;
			--nd-bg: #fafaf8;
			--nd-border: #e5e9e7;
			--nd-shadow-sm: 0 2px 8px rgba(20, 60, 50, 0.06);
			--nd-shadow-md: 0 8px 24px rgba(20, 60, 50, 0.1);
			--nd-shadow-lg: 0 16px 48px rgba(20, 60, 50, 0.14);
			--nd-radius: 12px;
			--nd-radius-lg: 20px;
			--nd-transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
		}
		body { background: var(--nd-bg); }
		.nd-page { font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif; color: var(--nd-text); line-height: 1.6; -webkit-font-smoothing: antialiased; }
		.nd-page * { box-sizing: border-box; }
		.nd-container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
		.nd-page h1, .nd-page h2, .nd-page h3, .nd-page h4 { font-weight: 700; line-height: 1.2; margin: 0 0 16px; color: var(--nd-dark); }
		.nd-page p { margin: 0 0 12px; }
		.nd-page a { color: var(--nd-primary); text-decoration: none; transition: color var(--nd-transition); }
		.nd-page a:hover { color: var(--nd-primary-dark); }

		/* TOP UTILITY BAR */
		.nd-topbar { background: var(--nd-dark); color: rgba(255,255,255,0.85); font-size: 13px; padding: 8px 0; }
		.nd-topbar .nd-container { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
		.nd-topbar-info { display: flex; gap: 24px; flex-wrap: wrap; }
		.nd-topbar-info span, .nd-topbar-info a { display: inline-flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.85); }
		.nd-topbar-info a:hover { color: #fff; }
		.nd-topbar-info i { color: var(--nd-accent); font-size: 12px; }
		.nd-topbar-cta { display: inline-flex; align-items: center; gap: 8px; background: var(--nd-primary); color: #fff !important; padding: 6px 16px; border-radius: 100px; font-weight: 600; font-size: 13px; }
		.nd-topbar-cta:hover { background: var(--nd-primary-dark); }

		/* SIMPLIFIED NAV */
		.nd-nav { background: #fff; padding: 16px 0; box-shadow: var(--nd-shadow-sm); position: sticky; top: 0; z-index: 100; }
		.nd-nav .nd-container { display: flex; align-items: center; justify-content: space-between; }
		.nd-nav-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 22px; letter-spacing: 6px; color: var(--nd-dark); }
		.nd-nav-brand img { height: 36px; }
		.nd-nav-links { display: flex; gap: 28px; list-style: none; padding: 0; margin: 0; }
		.nd-nav-links a { color: var(--nd-text); font-weight: 500; font-size: 15px; }
		.nd-nav-cta { background: var(--nd-primary); color: #fff !important; padding: 10px 22px; border-radius: 100px; font-weight: 600; font-size: 14px; }
		.nd-nav-cta:hover { background: var(--nd-primary-dark); color: #fff !important; transform: translateY(-1px); }
		.nd-nav-toggle { display: none; background: none; border: 0; font-size: 24px; cursor: pointer; color: var(--nd-dark); }

		/* HERO */
		.nd-hero { position: relative; min-height: 620px; background: linear-gradient(135deg, #1a7d6f 0%, #229C8C 60%, #2ab8a4 100%); color: #fff; overflow: hidden; padding: 80px 0 100px; }
		.nd-hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at top right, rgba(212, 168, 87, 0.25), transparent 60%); pointer-events: none; }
		.nd-hero::after { content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 60px; background: var(--nd-bg); clip-path: polygon(0 100%, 100% 100%, 100% 0, 0 100%); }
		.nd-hero-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px; align-items: center; position: relative; z-index: 2; }
		.nd-hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); padding: 8px 16px; border-radius: 100px; font-size: 13px; font-weight: 500; margin-bottom: 24px; backdrop-filter: blur(8px); }
		.nd-hero-eyebrow i { color: var(--nd-accent); }
		.nd-hero h1 { color: #fff; font-size: 52px; line-height: 1.1; margin-bottom: 20px; font-weight: 800; }
		.nd-hero h1 span { color: var(--nd-accent); }
		.nd-hero-sub { font-size: 18px; line-height: 1.6; opacity: 0.95; margin-bottom: 32px; max-width: 520px; }
		.nd-hero-trust { display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 36px; padding: 16px 20px; background: rgba(255,255,255,0.1); border-radius: var(--nd-radius); backdrop-filter: blur(8px); }
		.nd-trust-item { display: flex; flex-direction: column; }
		.nd-trust-value { font-size: 22px; font-weight: 800; color: #fff; line-height: 1; }
		.nd-trust-value .nd-stars { color: var(--nd-accent); margin-left: 6px; font-size: 16px; letter-spacing: 1px; }
		.nd-trust-label { font-size: 12px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }
		.nd-hero-cta-row { display: flex; gap: 14px; flex-wrap: wrap; }
		.nd-btn { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 100px; font-weight: 600; font-size: 15px; transition: all var(--nd-transition); border: 0; cursor: pointer; text-decoration: none; }
		.nd-btn-primary { background: #fff; color: var(--nd-primary-dark) !important; box-shadow: var(--nd-shadow-md); }
		.nd-btn-primary:hover { transform: translateY(-2px); box-shadow: var(--nd-shadow-lg); color: var(--nd-primary-darker) !important; }
		.nd-btn-ghost { background: transparent; color: #fff !important; border: 2px solid rgba(255,255,255,0.5); }
		.nd-btn-ghost:hover { background: rgba(255,255,255,0.15); border-color: #fff; color: #fff !important; }
		.nd-btn-accent { background: var(--nd-accent); color: var(--nd-dark) !important; box-shadow: var(--nd-shadow-md); }
		.nd-btn-accent:hover { transform: translateY(-2px); background: #c89a4d; color: var(--nd-dark) !important; }

		/* HERO IMAGE STACK */
		.nd-hero-visual { position: relative; }
		.nd-hero-visual-card { background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: var(--nd-radius-lg); padding: 32px; box-shadow: var(--nd-shadow-lg); }
		.nd-hero-visual-card img { width: 100%; border-radius: var(--nd-radius); display: block; }
		.nd-hero-visual-card-title { color: #fff; font-weight: 700; font-size: 18px; margin-top: 20px; }
		.nd-hero-visual-card-meta { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 4px; }
		.nd-hero-visual-floater { position: absolute; bottom: 20px; left: -28px; background: #fff; padding: 16px 20px; border-radius: var(--nd-radius); box-shadow: var(--nd-shadow-lg); display: flex; align-items: center; gap: 12px; }
		.nd-hero-visual-floater-icon { width: 44px; height: 44px; background: var(--nd-primary-light); color: var(--nd-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; }
		.nd-hero-visual-floater-text strong { display: block; color: var(--nd-dark); font-size: 14px; }
		.nd-hero-visual-floater-text small { color: var(--nd-text-muted); font-size: 12px; }

		/* SECTION COMMON */
		.nd-section { padding: 96px 0; }
		.nd-section-head { text-align: center; max-width: 720px; margin: 0 auto 56px; }
		.nd-section-eyebrow { display: inline-block; color: var(--nd-primary); font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px; }
		.nd-section-head h2 { font-size: 38px; line-height: 1.2; }
		.nd-section-head p { font-size: 17px; color: var(--nd-text-muted); }

		/* SERVICES */
		.nd-services-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
		.nd-service-card { background: #fff; border-radius: var(--nd-radius-lg); padding: 36px 28px; box-shadow: var(--nd-shadow-sm); transition: all var(--nd-transition); border: 1px solid var(--nd-border); position: relative; overflow: hidden; }
		.nd-service-card:hover { transform: translateY(-6px); box-shadow: var(--nd-shadow-md); border-color: var(--nd-primary-light); }
		.nd-service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--nd-primary); transform: scaleX(0); transform-origin: left; transition: transform var(--nd-transition); }
		.nd-service-card:hover::before { transform: scaleX(1); }
		.nd-service-icon { width: 64px; height: 64px; background: var(--nd-primary-light); color: var(--nd-primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; font-size: 28px; transition: all var(--nd-transition); }
		.nd-service-card:hover .nd-service-icon { background: var(--nd-primary); color: #fff; transform: rotate(-5deg) scale(1.05); }
		.nd-service-card h3 { font-size: 19px; margin-bottom: 12px; }
		.nd-service-card p { font-size: 14px; color: var(--nd-text-muted); margin-bottom: 16px; line-height: 1.6; }
		.nd-service-link { display: inline-flex; align-items: center; gap: 6px; color: var(--nd-primary); font-weight: 600; font-size: 14px; }
		.nd-service-link::after { content: '→'; transition: transform var(--nd-transition); }
		.nd-service-link:hover::after { transform: translateX(4px); }

		/* ABOUT SPLIT */
		.nd-about { background: #fff; }
		.nd-about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
		.nd-about-image { position: relative; }
		.nd-about-image img { width: 100%; border-radius: var(--nd-radius-lg); display: block; box-shadow: var(--nd-shadow-md); }
		.nd-about-image-badge { position: absolute; bottom: -30px; right: -30px; background: var(--nd-primary); color: #fff; padding: 28px; border-radius: var(--nd-radius); box-shadow: var(--nd-shadow-lg); text-align: center; min-width: 130px; }
		.nd-about-image-badge strong { display: block; font-size: 38px; line-height: 1; font-weight: 800; }
		.nd-about-image-badge span { font-size: 13px; opacity: 0.9; }
		.nd-about-content h2 { font-size: 36px; margin-bottom: 20px; }
		.nd-about-content p { color: var(--nd-text-muted); font-size: 16px; margin-bottom: 16px; }
		.nd-about-features { list-style: none; padding: 0; margin: 24px 0 32px; }
		.nd-about-features li { display: flex; align-items: flex-start; gap: 12px; padding: 8px 0; }
		.nd-about-features i { color: var(--nd-primary); font-size: 18px; margin-top: 2px; flex-shrink: 0; }

		/* STATS */
		.nd-stats { background: linear-gradient(135deg, var(--nd-primary-darker) 0%, var(--nd-primary) 100%); color: #fff; padding: 72px 0; position: relative; overflow: hidden; }
		.nd-stats::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 80% 50%, rgba(212,168,87,0.15), transparent 50%); }
		.nd-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; position: relative; }
		.nd-stat { text-align: center; }
		.nd-stat-number { font-size: 56px; font-weight: 800; line-height: 1; color: #fff; }
		.nd-stat-number span { color: var(--nd-accent); }
		.nd-stat-label { margin-top: 8px; font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px; }

		/* TEAM */
		.nd-team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
		.nd-team-card { background: #fff; border-radius: var(--nd-radius-lg); overflow: hidden; box-shadow: var(--nd-shadow-sm); transition: all var(--nd-transition); }
		.nd-team-card:hover { transform: translateY(-6px); box-shadow: var(--nd-shadow-md); }
		.nd-team-image { aspect-ratio: 4/5; overflow: hidden; position: relative; }
		.nd-team-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
		.nd-team-card:hover .nd-team-image img { transform: scale(1.05); }
		.nd-team-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(20,60,50,0.6) 0%, transparent 50%); }
		.nd-team-info { padding: 24px; }
		.nd-team-info h3 { font-size: 19px; margin-bottom: 4px; }
		.nd-team-role { color: var(--nd-primary); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
		.nd-team-bio { color: var(--nd-text-muted); font-size: 14px; margin-top: 12px; line-height: 1.5; }

		/* REVIEWS */
		.nd-reviews { background: var(--nd-primary-bg); }
		.nd-reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
		.nd-review { background: #fff; padding: 32px; border-radius: var(--nd-radius-lg); box-shadow: var(--nd-shadow-sm); position: relative; }
		.nd-review-stars { color: var(--nd-accent); font-size: 16px; letter-spacing: 2px; margin-bottom: 16px; }
		.nd-review p { color: var(--nd-text); font-size: 15px; line-height: 1.6; font-style: italic; margin-bottom: 20px; }
		.nd-review-author { display: flex; align-items: center; gap: 12px; padding-top: 16px; border-top: 1px solid var(--nd-border); }
		.nd-review-avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--nd-primary-light); color: var(--nd-primary); display: flex; align-items: center; justify-content: center; font-weight: 700; }
		.nd-review-author-info strong { display: block; font-size: 14px; color: var(--nd-dark); }
		.nd-review-author-info small { color: var(--nd-text-muted); font-size: 12px; }
		.nd-reviews-cta { text-align: center; margin-top: 40px; }

		/* CTA BANNER */
		.nd-cta-banner { background: linear-gradient(135deg, var(--nd-dark) 0%, #2c4a3f 100%); color: #fff; padding: 80px 0; position: relative; overflow: hidden; }
		.nd-cta-banner::before { content: ''; position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(212,168,87,0.18), transparent 60%); }
		.nd-cta-banner::after { content: ''; position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(34,156,140,0.25), transparent 60%); }
		.nd-cta-banner-inner { position: relative; text-align: center; max-width: 700px; margin: 0 auto; }
		.nd-cta-banner h2 { color: #fff; font-size: 36px; margin-bottom: 16px; }
		.nd-cta-banner p { font-size: 17px; opacity: 0.9; margin-bottom: 32px; }
		.nd-cta-banner-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

		/* CONTACT MAP */
		.nd-contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: stretch; }
		.nd-contact-info { background: #fff; border-radius: var(--nd-radius-lg); padding: 40px; box-shadow: var(--nd-shadow-sm); }
		.nd-contact-info h3 { font-size: 24px; margin-bottom: 24px; }
		.nd-contact-row { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid var(--nd-border); align-items: flex-start; }
		.nd-contact-row:last-child { border-bottom: 0; }
		.nd-contact-row-icon { width: 44px; height: 44px; background: var(--nd-primary-light); color: var(--nd-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
		.nd-contact-row-content strong { display: block; color: var(--nd-dark); font-size: 14px; margin-bottom: 4px; }
		.nd-contact-row-content a, .nd-contact-row-content span { color: var(--nd-text-muted); font-size: 15px; }
		.nd-contact-row-content a:hover { color: var(--nd-primary); }
		.nd-contact-map { border-radius: var(--nd-radius-lg); overflow: hidden; box-shadow: var(--nd-shadow-sm); min-height: 420px; }
		.nd-contact-map iframe { width: 100%; height: 100%; min-height: 420px; border: 0; }

		/* DEMO BANNER */
		.nd-demo-banner { background: #fef3c7; border-bottom: 2px solid #f59e0b; color: #78350f; padding: 12px 0; text-align: center; font-size: 14px; font-weight: 500; }

		/* RESPONSIVE */
		@media (max-width: 991px) {
			.nd-hero h1 { font-size: 40px; }
			.nd-hero-grid { grid-template-columns: 1fr; gap: 40px; }
			.nd-hero { padding: 60px 0 80px; min-height: auto; }
			.nd-services-grid { grid-template-columns: repeat(2, 1fr); }
			.nd-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 40px; }
			.nd-about-grid { grid-template-columns: 1fr; gap: 60px; }
			.nd-about-image-badge { right: 20px; bottom: -24px; }
			.nd-team-grid { grid-template-columns: repeat(2, 1fr); }
			.nd-reviews-grid { grid-template-columns: 1fr; }
			.nd-contact-grid { grid-template-columns: 1fr; }
			.nd-section { padding: 64px 0; }
			.nd-section-head h2 { font-size: 30px; }
		}
		@media (max-width: 640px) {
			.nd-topbar-info { font-size: 12px; gap: 12px; }
			.nd-topbar-info span { display: none; }
			.nd-topbar-info a { display: inline-flex; }
			.nd-nav-links { display: none; }
			.nd-nav-toggle { display: block; }
			.nd-nav-cta { padding: 8px 14px; font-size: 13px; }
			.nd-hero h1 { font-size: 32px; }
			.nd-hero-trust { flex-direction: column; gap: 12px; }
			.nd-hero-cta-row { flex-direction: column; }
			.nd-hero-cta-row .nd-btn { width: 100%; justify-content: center; }
			.nd-services-grid { grid-template-columns: 1fr; }
			.nd-stats-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
			.nd-stat-number { font-size: 40px; }
			.nd-team-grid { grid-template-columns: 1fr; }
			.nd-cta-banner h2 { font-size: 28px; }
			.nd-cta-banner-actions .nd-btn { width: 100%; justify-content: center; }
		}
	</style>
</head>
<body class="nd-page">

	<!-- DEMO BANNER -->
	<div class="nd-demo-banner">
		⚠️ DEMO STRANICA · Nije povezana sa glavnim sajtom · noindex/nofollow
	</div>

	<!-- TOP UTILITY BAR -->
	<div class="nd-topbar">
		<div class="nd-container">
			<div class="nd-topbar-info">
				<a href="tel:+38766945702"><i class="fa fa-phone"></i> +387 66 945-702</a>
				<a href="mailto:dobar@psihijatar.info"><i class="fa fa-envelope"></i> dobar@psihijatar.info</a>
				<span><i class="fa fa-map-marker"></i> Vojvode Pere Krece 2, Banja Luka</span>
				<span><i class="fa fa-clock-o"></i> Pon-Pet 9-17h, Sri 11-19h</span>
			</div>
			<a href="https://wa.me/38766945702" class="nd-topbar-cta">
				<i class="fa fa-whatsapp"></i> WhatsApp
			</a>
		</div>
	</div>

	<!-- NAV -->
	<nav class="nd-nav">
		<div class="nd-container">
			<a href="#" class="nd-nav-brand">
				<img src="images/logo.png" alt="DOBAR logo" width="346" height="407" decoding="async">
				DOBAR
			</a>
			<ul class="nd-nav-links">
				<li><a href="#usluge">Usluge</a></li>
				<li><a href="#o-nama">O nama</a></li>
				<li><a href="#tim">Tim</a></li>
				<li><a href="#recenzije">Recenzije</a></li>
				<li><a href="#kontakt">Kontakt</a></li>
			</ul>
			<a href="#kontakt" class="nd-nav-cta">Zakaži pregled</a>
			<button class="nd-nav-toggle" aria-label="Meni">☰</button>
		</div>
	</nav>

	<!-- HERO -->
	<section class="nd-hero">
		<div class="nd-container">
			<div class="nd-hero-grid">
				<div>
					<div class="nd-hero-eyebrow">
						<i class="fa fa-stethoscope"></i> Specijalistička psihijatrijska ordinacija
					</div>
					<h1>Psihijatar <span>Banja Luka</span> — pristup koji poštuje vaše dostojanstvo</h1>
					<p class="nd-hero-sub">Dr Dragan Tešanović i tim stručnjaka za mentalno zdravlje. Psihijatrijski pregledi, psihoterapija, EMDR i sistemske konstelacije u sigurnom i diskretnom okruženju.</p>

					<div class="nd-hero-trust">
						<div class="nd-trust-item">
							<div class="nd-trust-value">4.6 <span class="nd-stars">★★★★★</span></div>
							<div class="nd-trust-label">Google ocjena</div>
						</div>
						<div class="nd-trust-item">
							<div class="nd-trust-value">20+</div>
							<div class="nd-trust-label">Recenzija</div>
						</div>
						<div class="nd-trust-item">
							<div class="nd-trust-value">5 god.</div>
							<div class="nd-trust-label">U Banjoj Luci</div>
						</div>
					</div>

					<div class="nd-hero-cta-row">
						<a href="#kontakt" class="nd-btn nd-btn-primary">
							<i class="fa fa-calendar-check-o"></i> Zakaži pregled
						</a>
						<a href="tel:+38766945702" class="nd-btn nd-btn-ghost">
							<i class="fa fa-phone"></i> 066 945-702
						</a>
					</div>
				</div>

				<div class="nd-hero-visual">
					<div class="nd-hero-visual-card">
						<img src="images/team/12zelenasoba.jpg" alt="Ordinacija DOBAR Banja Luka" loading="lazy" width="1303" height="1955" decoding="async">
						<div class="nd-hero-visual-card-title">Naša ordinacija u Banjoj Luci</div>
						<div class="nd-hero-visual-card-meta">Mirno i diskretno okruženje</div>
					</div>
					<div class="nd-hero-visual-floater">
						<div class="nd-hero-visual-floater-icon"><i class="fa fa-shield"></i></div>
						<div class="nd-hero-visual-floater-text">
							<strong>100% Diskrecija</strong>
							<small>Povjerljivi razgovor</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- SERVICES -->
	<section class="nd-section" id="usluge">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Naše usluge</span>
				<h2>Stručna podrška za vaše mentalno zdravlje</h2>
				<p>Specijalistički psihijatrijski pristup uz savremene psihoterapijske metode prilagođene svakoj osobi.</p>
			</div>
			<div class="nd-services-grid">
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-stethoscope"></i></div>
					<h3>Psihijatrijski pregled</h3>
					<p>Specijalistički pregled, dijagnostika i terapija za sve uzraste. Prvi pregled traje do sat vremena.</p>
					<a href="psihijatrija.php" class="nd-service-link">Saznaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-comments-o"></i></div>
					<h3>Individualna psihoterapija</h3>
					<p>Razgovorni terapijski pristup koji vam pomaže da razumijete i mijenjate obrasce mišljenja i ponašanja.</p>
					<a href="psihoterapija.php" class="nd-service-link">Saznaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-eye"></i></div>
					<h3>EMDR terapija</h3>
					<p>Naučno potvrđena metoda za liječenje traume, PTSP-a i anksioznosti kroz pokrete očiju.</p>
					<a href="emdr.php" class="nd-service-link">Saznaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-users"></i></div>
					<h3>Grupni rad i konstelacije</h3>
					<p>Grupna psihoterapija i sistemske konstelacije — moćan rad u zaštićenom okruženju grupe.</p>
					<a href="konstelacije.php" class="nd-service-link">Saznaj više</a>
				</div>
			</div>
		</div>
	</section>

	<!-- ABOUT SPLIT -->
	<section class="nd-section nd-about" id="o-nama">
		<div class="nd-container">
			<div class="nd-about-grid">
				<div class="nd-about-image">
					<img src="images/team/11mjestoklijent.jpg" alt="Mjesto za klijenta - DOBAR Banja Luka" loading="lazy" width="1382" height="2073" decoding="async">
					<div class="nd-about-image-badge">
						<strong>2021</strong>
						<span>Otvorena ordinacija</span>
					</div>
				</div>
				<div class="nd-about-content">
					<span class="nd-section-eyebrow">O nama</span>
					<h2>D.O.B.A.R. — pristup koji nas vodi</h2>
					<p>Akronim DOBAR opisuje principe kojima pristupamo svakom čovjeku koji nam se obrati za pomoć:</p>
					<ul class="nd-about-features">
						<li><i class="fa fa-check-circle"></i> <span><strong>Dostojanstvo</strong> svakog ko nam se obrati</span></li>
						<li><i class="fa fa-check-circle"></i> <span><strong>Odgovorno</strong> pristupanje svakom slučaju</span></li>
						<li><i class="fa fa-check-circle"></i> <span><strong>Brižno</strong> odnošenje prema osobi</span></li>
						<li><i class="fa fa-check-circle"></i> <span><strong>Angažovan</strong> rad na očuvanju mentalnog zdravlja zajednice</span></li>
						<li><i class="fa fa-check-circle"></i> <span><strong>Rado</strong> obavljanje našeg poziva</span></li>
					</ul>
					<a href="ideja.php" class="nd-btn nd-btn-accent">Naš koncept</a>
				</div>
			</div>
		</div>
	</section>

	<!-- STATS -->
	<section class="nd-stats">
		<div class="nd-container">
			<div class="nd-stats-grid">
				<div class="nd-stat">
					<div class="nd-stat-number">5<span>+</span></div>
					<div class="nd-stat-label">Godina iskustva</div>
				</div>
				<div class="nd-stat">
					<div class="nd-stat-number">7</div>
					<div class="nd-stat-label">Stručnjaka u timu</div>
				</div>
				<div class="nd-stat">
					<div class="nd-stat-number">4.6<span>★</span></div>
					<div class="nd-stat-label">Google ocjena</div>
				</div>
				<div class="nd-stat">
					<div class="nd-stat-number">100<span>%</span></div>
					<div class="nd-stat-label">Diskrecija</div>
				</div>
			</div>
		</div>
	</section>

	<!-- TEAM -->
	<section class="nd-section" id="tim">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Naš tim</span>
				<h2>Stručnjaci kojima vjerujete</h2>
				<p>Tim psihijatara, psihoterapeuta i medicinskog osoblja sa dugogodišnjim iskustvom.</p>
			</div>
			<div class="nd-team-grid">
				<div class="nd-team-card">
					<div class="nd-team-image">
						<img src="images/team/dragan.jpg" alt="Dr Dragan Tešanović - psihijatar Banja Luka" loading="lazy" width="1000" height="812" decoding="async">
						<div class="nd-team-overlay"></div>
					</div>
					<div class="nd-team-info">
						<h3>Dr Dragan Tešanović</h3>
						<div class="nd-team-role">Specijalista psihijatrije</div>
						<p class="nd-team-bio">Edukacija iz transakcione analize, EMDR-a i sistemskih konstelacija. Više hiljada psihijatrijskih pregleda.</p>
					</div>
				</div>
				<div class="nd-team-card">
					<div class="nd-team-image">
						<img src="images/team/zeljka.jpg" alt="Dr Željka Štrbac - psihijatar" loading="lazy" width="1600" height="1066" decoding="async">
						<div class="nd-team-overlay"></div>
					</div>
					<div class="nd-team-info">
						<h3>Dr Željka Štrbac</h3>
						<div class="nd-team-role">Specijalista psihijatrije</div>
						<p class="nd-team-bio">Bolnički i ambulantni rad u tretmanu osoba sa mentalnim smetnjama, psihofarmakološki tretman.</p>
					</div>
				</div>
				<div class="nd-team-card">
					<div class="nd-team-image">
						<img src="images/team/tatjana.jpg" alt="Dr Tatjana Maglov - psihijatar" loading="lazy" width="1600" height="1067" decoding="async">
						<div class="nd-team-overlay"></div>
					</div>
					<div class="nd-team-info">
						<h3>Dr Tatjana Maglov</h3>
						<div class="nd-team-role">Specijalista psihijatrije</div>
						<p class="nd-team-bio">Tretman zavisnosti, psihoterapeut sa edukacijom iz transakcione analize.</p>
					</div>
				</div>
			</div>
			<div style="text-align:center; margin-top:40px;">
				<a href="tim.php" class="nd-btn nd-btn-primary" style="background:var(--nd-primary); color:#fff !important;">
					<i class="fa fa-arrow-right"></i> Cijeli tim
				</a>
			</div>
		</div>
	</section>

	<!-- REVIEWS -->
	<section class="nd-section nd-reviews" id="recenzije">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Recenzije</span>
				<h2>Šta kažu naši pacijenti</h2>
				<p>4.6 prosječna ocjena na Google-u od 20+ stvarnih recenzija.</p>
			</div>
			<div class="nd-reviews-grid">
				<div class="nd-review">
					<div class="nd-review-stars">★★★★★</div>
					<p>"Pomoć psihoterapeuta potražila sam za brata, a ubrzo shvatila da je pomoć potrebna meni. Terapeut i grupa pomogli su mi da upoznajem sebe i svoje potrebe."</p>
					<div class="nd-review-author">
						<div class="nd-review-avatar">D</div>
						<div class="nd-review-author-info">
							<strong>Anonimni pacijent</strong>
							<small>Februar 2026</small>
						</div>
					</div>
				</div>
				<div class="nd-review">
					<div class="nd-review-stars">★★★★★</div>
					<p>"Profesionalan pristup i topla atmosfera. Dr Tešanović i tim su mi pomogli kroz najteži period u životu. Preporučujem od srca."</p>
					<div class="nd-review-author">
						<div class="nd-review-avatar">M</div>
						<div class="nd-review-author-info">
							<strong>Anonimni pacijent</strong>
							<small>Januar 2026</small>
						</div>
					</div>
				</div>
				<div class="nd-review">
					<div class="nd-review-stars">★★★★★</div>
					<p>"Dolazila sam na grupnu terapiju i sistemske konstelacije. Preokreti koje sam doživjela u radu su neprocjenjivi. Hvala timu."</p>
					<div class="nd-review-author">
						<div class="nd-review-avatar">S</div>
						<div class="nd-review-author-info">
							<strong>Anonimni pacijent</strong>
							<small>Decembar 2025</small>
						</div>
					</div>
				</div>
			</div>
			<div class="nd-reviews-cta">
				<a href="https://www.google.com/maps/search/?api=1&query=DOBAR+psihijatar+Banja+Luka" target="_blank" rel="noopener" class="nd-btn nd-btn-primary" style="background:var(--nd-primary); color:#fff !important;">
					Sve recenzije na Google
				</a>
			</div>
		</div>
	</section>

	<!-- CTA BANNER -->
	<section class="nd-cta-banner">
		<div class="nd-container">
			<div class="nd-cta-banner-inner">
				<h2>Niste sigurni da li je psihoterapija za vas?</h2>
				<p>Prvi razgovor je prilika da bez obaveze procijenite šta vam najbolje odgovara. Dostupni smo putem telefona, Vibera i WhatsApp-a.</p>
				<div class="nd-cta-banner-actions">
					<a href="https://wa.me/38766945702" class="nd-btn nd-btn-accent">
						<i class="fa fa-whatsapp"></i> Pošalji WhatsApp poruku
					</a>
					<a href="tel:+38766945702" class="nd-btn nd-btn-ghost">
						<i class="fa fa-phone"></i> Pozovi sada
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- CONTACT + MAP -->
	<section class="nd-section" id="kontakt">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Kontakt</span>
				<h2>Pronađite nas</h2>
				<p>U centru Banje Luke, lako dostupno.</p>
			</div>
			<div class="nd-contact-grid">
				<div class="nd-contact-info">
					<h3>Informacije</h3>
					<div class="nd-contact-row">
						<div class="nd-contact-row-icon"><i class="fa fa-map-marker"></i></div>
						<div class="nd-contact-row-content">
							<strong>Adresa</strong>
							<span>Vojvode Pere Krece 2, Banja Luka 78000</span>
						</div>
					</div>
					<div class="nd-contact-row">
						<div class="nd-contact-row-icon"><i class="fa fa-phone"></i></div>
						<div class="nd-contact-row-content">
							<strong>Telefon</strong>
							<a href="tel:+38766945702">+387 66 945-702</a>
						</div>
					</div>
					<div class="nd-contact-row">
						<div class="nd-contact-row-icon"><i class="fa fa-envelope"></i></div>
						<div class="nd-contact-row-content">
							<strong>Email</strong>
							<a href="mailto:dobar@psihijatar.info">dobar@psihijatar.info</a>
						</div>
					</div>
					<div class="nd-contact-row">
						<div class="nd-contact-row-icon"><i class="fa fa-clock-o"></i></div>
						<div class="nd-contact-row-content">
							<strong>Radno vrijeme</strong>
							<span>Pon, Uto, Čet, Pet: 9–17h</span><br>
							<span>Srijeda: 11–19h</span><br>
							<span style="color:#999;">Vikend: zatvoreno</span>
						</div>
					</div>
				</div>
				<div class="nd-contact-map">
					<iframe src="https://www.google.com/maps?q=Vojvode+Pere+Krece+2,+Banja+Luka,+78000&output=embed" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokacija ordinacije DOBAR"></iframe>
				</div>
			</div>
		</div>
	</section>

	<?php include 'elements/footer.php' ?>

</body>
</html>
