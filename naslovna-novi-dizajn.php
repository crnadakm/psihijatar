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
		.nd-topbar-actions { display: inline-flex; gap: 8px; }
		.nd-topbar-cta-viber { background: #665CAC; }
		.nd-topbar-cta-viber:hover { background: #574d99; }
		.nd-viber-ico { vertical-align: middle; }

		/* SIMPLIFIED NAV */
		.nd-nav { background: #fff; padding: 16px 0; box-shadow: var(--nd-shadow-sm); position: sticky; top: 0; z-index: 100; }
		.nd-nav .nd-container { display: flex; align-items: center; justify-content: space-between; }
		.nd-nav-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 22px; letter-spacing: 6px; color: var(--nd-dark); }
		.nd-nav-brand img { height: 36px; width: auto; }
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
		.nd-hero-sub { font-size: 18px; line-height: 1.6; color: #fff !important; opacity: 0.95; margin-bottom: 32px; max-width: 520px; }
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
		.nd-hero-visual-card img { width: 100%; height: auto; border-radius: var(--nd-radius); display: block; }
		.nd-hero-visual-card-title { color: #fff; font-weight: 700; font-size: 18px; margin-top: 20px; }
		.nd-hero-visual-card-meta { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 4px; }
		.nd-hero-visual-floater { display: none; } /* uklonjen plutajući badge — preklapao tekst/dugmad u heru */
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
		.nd-about-image img { width: 100%; height: auto; border-radius: var(--nd-radius-lg); display: block; box-shadow: var(--nd-shadow-md); }
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
		.nd-cta-banner p { font-size: 17px; color: #fff !important; opacity: 0.92; margin-bottom: 32px; }
		.nd-cta-banner-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
		.nd-msg-choice { display: none; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap; }
		.nd-msg-choice.open { display: flex; }

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
			.nd-tb-email { display: none; }
			.nd-topbar .nd-container { flex-wrap: nowrap; gap: 8px; }
			.nd-topbar-info { gap: 8px; flex-wrap: nowrap; }
			.nd-topbar-actions { gap: 6px; }
			.nd-topbar-info a { display: inline-flex; }
			.nd-nav-links { display: none; }
			.nd-nav-toggle { display: block; }
			.nd-nav-cta { padding: 8px 14px; font-size: 13px; }
			.nd-hero h1 { font-size: 32px; }
			.nd-hero-trust { flex-direction: row; gap: 10px; padding: 12px; }
			.nd-hero-trust .nd-trust-item { flex: 1; }
			.nd-trust-value { font-size: 16px; }
			.nd-trust-value .nd-stars { display: none; }
			.nd-trust-label { font-size: 10px; }
			.nd-hero-cta-row { flex-direction: column; }
			.nd-hero-cta-row .nd-btn { width: 100%; justify-content: center; }
			.nd-services-grid { grid-template-columns: 1fr; }
			.nd-stats-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
			.nd-stat-number { font-size: 40px; }
			.nd-team-grid { grid-template-columns: 1fr; }
			.nd-cta-banner h2 { font-size: 28px; }
			.nd-cta-banner-actions .nd-btn { width: 100%; justify-content: center; }
		}

		/* === V2 STRUKTURA (multi-page, ne one-pager) === */
		.nd-nav-links { flex-wrap: wrap; gap: 20px; }
		.nd-nav-links a { font-size: 14px; }

		/* CITATI */
		.nd-quotes { background: var(--nd-primary-bg); }
		.nd-quotes-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; }
		.nd-quote-card { background: #fff; border-radius: var(--nd-radius-lg); padding: 32px 36px; box-shadow: var(--nd-shadow-sm); border-left: 4px solid var(--nd-primary); }
		.nd-quote-card p { font-size: 16px; line-height: 1.7; font-style: italic; color: var(--nd-text); margin: 0 0 14px; }
		.nd-quote-card cite { font-style: normal; font-weight: 700; color: var(--nd-primary-dark); font-size: 14px; }

		/* BLOG KARTICE */
		.nd-blog-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
		.nd-blog-card { background: #fff; border-radius: var(--nd-radius); overflow: hidden; box-shadow: var(--nd-shadow-sm); transition: transform var(--nd-transition), box-shadow var(--nd-transition); display: flex; flex-direction: column; }
		.nd-blog-card:hover { transform: translateY(-6px); box-shadow: var(--nd-shadow-md); }
		.nd-blog-card-img { aspect-ratio: 1 / 1; overflow: hidden; display: block; }
		.nd-blog-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform var(--nd-transition); }
		.nd-blog-card:hover .nd-blog-card-img img { transform: scale(1.05); }
		.nd-blog-card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
		.nd-blog-card-body h3 { font-size: 16px; line-height: 1.35; margin: 0 0 10px; }
		.nd-blog-card-body h3 a { color: var(--nd-dark); }
		.nd-blog-card-meta { margin-top: auto; font-size: 12px; color: var(--nd-text-muted); }

		/* ISKUSTVA (koristi .nd-review stilove) */
		.nd-iskustva-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }

		/* RESPONSIVE V2 */
		@media (max-width: 991px) {
			.nd-quotes-grid { grid-template-columns: 1fr; }
			.nd-blog-grid { grid-template-columns: 1fr 1fr; }
			.nd-iskustva-grid { grid-template-columns: 1fr; }
			.nd-hero-visual-card img { max-height: 360px; object-fit: cover; }
		}
		@media (max-width: 640px) {
			.nd-blog-grid { grid-template-columns: 1fr; }
			.nd-nav .nd-container { flex-wrap: wrap; }
			.nd-nav-links.open { display: flex; flex-direction: column; width: 100%; gap: 10px; margin-top: 14px; }
			.nd-wa-text { display: none; }
			.nd-hero-visual-card { padding: 16px; }
			.nd-hero-visual-card img { max-height: 240px; object-fit: cover; }
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
				<span><i class="fa fa-map-marker"></i> Vojvode Pere Krece 2, Banja Luka</span>
				<span><i class="fa fa-clock-o"></i> Pon-Pet 9-17h, Sri 11-19h</span>
			</div>
			<div class="nd-topbar-actions">
				<a href="https://wa.me/38766945702" class="nd-topbar-cta"><i class="fa fa-whatsapp"></i> <span class="nd-wa-text">WhatsApp</span></a>
				<a href="viber://chat?number=38766945702" class="nd-topbar-cta nd-topbar-cta-viber"><img src="images/viber.png" alt="Viber" width="14" height="14" class="nd-viber-ico"> <span class="nd-wa-text">Viber</span></a>
			</div>
		</div>
	</div>

	<!-- NAV -->
	<nav class="nd-nav">
		<div class="nd-container">
			<a href="index.php" class="nd-nav-brand">
				<img src="images/logo.png" alt="DOBAR logo" width="346" height="407" decoding="async">
				DOBAR
			</a>
			<ul class="nd-nav-links">
				<li><a href="index.php">Naslovna</a></li>
				<li><a href="ideja.php">O nama</a></li>
				<li><a href="tim.php">Ljudi</a></li>
				<li><a href="znanja.php">Znanja</a></li>
				<li><a href="aktivnosti.php">Aktivnosti</a></li>
				<li><a href="dokumenti.php">Čitanka</a></li>
				<li><a href="knjige.php">Knjige</a></li>
				<li><a href="kontakt.php">Kontakt</a></li>
			</ul>
			<a href="kontakt.php" class="nd-nav-cta">Zakaži pregled</a>
			<button class="nd-nav-toggle" aria-label="Meni" onclick="document.querySelector('.nd-nav-links').classList.toggle('open')">&#9776;</button>
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
						<a href="kontakt.php" class="nd-btn nd-btn-primary">
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
					<h3>Šta je psihijatrija?</h3>
					<p>Najvažniji aspekt rada psihijatra je povjerljiv i detaljan razgovor s pacijentom, uz medicinske i psihološke procjene koje daju jasnu sliku stanja.</p>
					<a href="psihijatrija.php" class="nd-service-link">Pročitaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-comments-o"></i></div>
					<h3>O psihoterapiji</h3>
					<p>Skup metoda i tehnika čiji je cilj liječenje psihičkih tegoba razgovorom — olakšanje tegoba, sagledavanje rješenja i razvoj ličnosti.</p>
					<a href="psihoterapija.php" class="nd-service-link">Pročitaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-eye"></i></div>
					<h3>EMDR — psihoterapijska metoda</h3>
					<p>Metoda koja kroz prirodne pokrete očiju (eye movement) uspješno liječi posljedice traumatskih doživljaja (PTSP).</p>
					<a href="emdr.php" class="nd-service-link">Pročitaj više</a>
				</div>
				<div class="nd-service-card">
					<div class="nd-service-icon"><i class="fa fa-users"></i></div>
					<h3>Ko je ko u brizi o mentalnom zdravlju</h3>
					<p>Psihijatar? Psiholog? Psihoterapeut? Pojašnjavamo razlike da lakše odlučite kome da se obratite.</p>
					<a href="kojeko.php" class="nd-service-link">Pročitaj više</a>
				</div>
			</div>
		</div>
	</section>

	<!-- CITATI -->
	<section class="nd-section nd-quotes">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Misli koje nas vode</span>
				<h2>O čovjeku i promjeni</h2>
			</div>
			<div class="nd-quotes-grid">
				<div class="nd-quote-card"><p>"Svaki čovjek već posjeduje ono što je potrebno da napravi unutrašnju promjenu. Ono što možemo da uradimo jeste da podstaknemo druge da pronađu izvor u sebi i podržimo ih na njihovom putu ka rastu i napretku."</p><cite>— Milton Erikson</cite></div>
				<div class="nd-quote-card"><p>"Samo zato što te neko ne voli onako kako želiš, ne znači da nisi voljen cijelim njegovim bićem."</p><cite>— Gabriel Garcia Markez</cite></div>
				<div class="nd-quote-card"><p>"Nesretnog življenja je onaj ko mora da ponižava druge da bi održao vlastito samopouzdanje."</p><cite>— Harry Stack Sullivan</cite></div>
				<div class="nd-quote-card"><p>"Najveće u ljudima je ono što ih čini ravnopravnim sa svima ostalima. Sve ono čime nastojimo da odstupimo iznad ili ispod onog zajedničkog svim ljudima čini nas manjim."</p><cite>— Bert Hellinger</cite></div>
			</div>
		</div>
	</section>

	<!-- BLOG -->
	<section class="nd-section" id="blog">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Iz naše čitanke</span>
				<h2>Tekstovi i članci</h2>
				<p>Pišemo o temama mentalnog zdravlja — pristupačno i iz prakse.</p>
			</div>
			<div class="nd-blog-grid">
<?php
	$shown = 0;
	foreach (getContent("blog_highlights") as $bh):
		if (!($bh["active"] ?? true)) continue;
		if ($shown >= 4) break;
		$shown++;
		$blink = htmlspecialchars($bh["link"] ?? "#");
		$bimg = htmlspecialchars($bh["image"] ?? "");
		$btitle = htmlspecialchars($bh["title"] ?? "");
		$bauthor = htmlspecialchars($bh["author"] ?? "");
		$bdate = htmlspecialchars($bh["date"] ?? "");
		$balt = htmlspecialchars($bh["image_alt"] ?? $bh["title"] ?? "");
		$bmeta = trim($bdate . ($bauthor ? " · " . $bauthor : ""));
?>
				<article class="nd-blog-card">
					<a href="<?= $blink ?>" class="nd-blog-card-img"><img src="<?= $bimg ?>" alt="<?= $balt ?>" loading="lazy" decoding="async"></a>
					<div class="nd-blog-card-body">
						<h3><a href="<?= $blink ?>"><?= $btitle ?></a></h3>
						<div class="nd-blog-card-meta"><i class="fa fa-clock-o"></i> <?= $bmeta ?></div>
					</div>
				</article>
<?php endforeach; ?>
			</div>
			<div class="nd-reviews-cta">
				<a href="dokumenti.php" class="nd-btn nd-btn-primary" style="background:var(--nd-primary); color:#fff !important;">Cijela čitanka</a>
			</div>
		</div>
	</section>

	<!-- ISKUSTVA -->
	<section class="nd-section nd-reviews" id="iskustva">
		<div class="nd-container">
			<div class="nd-section-head">
				<span class="nd-section-eyebrow">Iskustva</span>
				<h2>Šta kažu oni koji su prošli kroz proces</h2>
			</div>
			<div class="nd-iskustva-grid">
				<div class="nd-review"><p>"Pomoć psihoterapeuta potražila sam za brata a ubrzo shvatila da je pomoć potrebna MENI. Terapeut i inspirativni članovi grupe pomogli su da upoznajem sebe, svoje potrebe, da glasno kažem šta osjećam, šta želim a šta ne želim. Zahvalna sam za posvećenost koja me povela u dragocjeno životno iskustvo."</p><div class="nd-review-author"><div class="nd-review-avatar">D</div><div class="nd-review-author-info"><strong>D.</strong><small>Prosvjetni radnik u penziji, 69 god.</small></div></div></div>
				<div class="nd-review"><p>"Na terapiji sam se konačno počela od srca smijati i plakati. Mnogo mi je pomoglo što me niko nije kritikovao za ono što osjećam i mislim. Dobro je u životu poznavati nekoga ko u pravo vrijeme umije postaviti prava pitanja."</p><div class="nd-review-author"><div class="nd-review-avatar">M</div><div class="nd-review-author-info"><strong>M.</strong><small>Pravnica, 35 god.</small></div></div></div>
				<div class="nd-review"><p>"Odlazak na prvi susret je bio teška odluka. Tražio sam samo tablete, ali doktor rješenje nije vidio u tome — bio je preda mnom dug proces. Trajalo je četiri godine, a rezultat je da ponovo živim. Živim sa strahovima koje prepoznajem i prihvatam, ali ŽIVIM."</p><div class="nd-review-author"><div class="nd-review-avatar">P</div><div class="nd-review-author-info"><strong>P.</strong><small>Radnik, 53 god.</small></div></div></div>
				<div class="nd-review"><p>"Naučila sam da sve što se dešava u meni zavisi isključivo od mene. Ja sam ta koja odlučuje kako će se osjećati. Kada sam to shvatila, osjetila sam slobodu i zagrlila život. Neopisivo je lijepo naći sreću u sebi."</p><div class="nd-review-author"><div class="nd-review-avatar">S</div><div class="nd-review-author-info"><strong>S.</strong><small>Administrativni referent, 48 god.</small></div></div></div>
				<div class="nd-review"><p>"Teret samo jednom postane pretežak. Prijateljica mi je preporučila psihoterapeuta koji mi je pomogao da otresem prašinu, podignem glavu i sa mirom nastavim. Od tad je život ljepši — kad boli plačem i nije me sramota, kad volim grlim, kad sam srećna pjevam."</p><div class="nd-review-author"><div class="nd-review-avatar">D</div><div class="nd-review-author-info"><strong>D.</strong><small>HR menadžer, 50 god.</small></div></div></div>
			</div>
		</div>
	</section>

	<!-- CTA BANNER -->
	<section class="nd-cta-banner" id="nd-cta-box" style="display:none">
		<div class="nd-container">
			<div class="nd-cta-banner-inner">
				<h2>Niste sigurni da li je psihoterapija za vas?</h2>
				<p>Trenutno smo dostupni — javite se porukom ili pozivom i bez obaveze procijenite šta vam najbolje odgovara.</p>
				<div class="nd-cta-banner-actions">
					<button type="button" class="nd-btn nd-btn-accent" onclick="document.getElementById('nd-msg-choice').classList.toggle('open')"><i class="fa fa-comments"></i> Pošalji poruku</button>
					<a href="tel:+38766945702" class="nd-btn nd-btn-ghost"><i class="fa fa-phone"></i> Pozovi sada</a>
				</div>
				<div id="nd-msg-choice" class="nd-msg-choice">
					<a href="https://wa.me/38766945702" class="nd-btn nd-btn-accent"><i class="fa fa-whatsapp"></i> WhatsApp</a>
					<a href="viber://chat?number=38766945702" class="nd-btn nd-btn-accent"><img src="images/viber.png" alt="Viber" width="16" height="16" class="nd-viber-ico"> Viber</a>
				</div>
			</div>
		</div>
	</section>

	<?php include 'elements/footer.php' ?>

	<script>
	/* CTA box ("Niste sigurni...") — prikaži samo u radno vrijeme (Banja Luka).
	   Pon, Uto, Čet, Pet: 9–17h · Sri: 11–19h · vikend zatvoreno. */
	(function () {
		var box = document.getElementById('nd-cta-box');
		if (!box) return;
		var bl;
		try { bl = new Date(new Date().toLocaleString('en-US', { timeZone: 'Europe/Belgrade' })); }
		catch (e) { bl = new Date(); }
		var day = bl.getDay();              // 0=ned ... 6=sub
		var h = bl.getHours() + bl.getMinutes() / 60;
		var open = false;
		if (day === 1 || day === 2 || day === 4 || day === 5) open = (h >= 9 && h < 17);
		else if (day === 3) open = (h >= 11 && h < 19);
		if (open) box.style.display = '';
	})();
	</script>

</body>
</html>
