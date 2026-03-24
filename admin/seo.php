<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Expert - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-search"></i> SEO Expert Panel</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Sajt</a>
            </div>
        </div>

        <!-- Section Navigation -->
        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-pages">Stranice</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-global">Globalna podešavanja</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-schema">Schema.org</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-robots">Robots.txt</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-sitemap">Sitemap</a></li>
        </ul>

        <div class="tab-content">
            <!-- PAGES SEO -->
            <div class="tab-pane fade show active" id="sec-pages">
                <div class="row">
                    <!-- Page List -->
                    <div class="col-md-4">
                        <div class="card-section">
                            <h5><i class="bi bi-files"></i> Stranice</h5>
                            <input type="text" class="form-control mb-3" placeholder="Pretraži..." oninput="filterPages(this.value)">
                            <div id="page-list" style="max-height:600px;overflow-y:auto;"></div>
                        </div>
                    </div>
                    <!-- Page SEO Editor -->
                    <div class="col-md-8">
                        <div class="card-section" id="page-editor" style="display:none;">
                            <h5><i class="bi bi-pencil"></i> SEO za: <span id="editing-page" class="text-white"></span></h5>

                            <!-- Auto OG info -->
                            <div id="auto-og-info" class="mb-3 p-3" style="display:none;background:rgba(34,156,140,0.15);border:1px solid var(--primary);border-radius:8px;font-size:13px;color:#ccc;">
                            </div>

                            <!-- Score -->
                            <div class="mb-3 p-3" style="background:var(--darkest);border-radius:8px;">
                                <strong>SEO Score: </strong><span id="seo-score-badge" class="seo-score">0</span>
                                <span id="seo-tips" class="ms-3 text-muted" style="font-size:13px;"></span>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Title tag <span class="char-count" id="title-count"></span></label>
                                    <input type="text" class="form-control" id="page-title" oninput="updatePreview();countChars(this,'title-count',50,60)">
                                    <small class="text-muted">Preporučeno: 50-60 karaktera</small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Description <span class="char-count" id="desc-count"></span></label>
                                    <textarea class="form-control" id="page-description" rows="3" oninput="updatePreview();countChars(this,'desc-count',120,160)"></textarea>
                                    <small class="text-muted">Preporučeno: 120-160 karaktera</small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control" id="page-keywords">
                                    <small class="text-muted">Odvojeni zarezom</small>
                                </div>
                            </div>

                            <h6 class="text-info mt-3 mb-3"><i class="bi bi-facebook"></i> Open Graph (Facebook/LinkedIn)</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">OG Title</label>
                                    <input type="text" class="form-control" id="page-og-title" oninput="updatePreview()">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">OG Type</label>
                                    <select class="form-select" id="page-og-type">
                                        <option value="website">website</option>
                                        <option value="article">article</option>
                                        <option value="profile">profile</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">OG Description</label>
                                    <textarea class="form-control" id="page-og-desc" rows="2" oninput="updatePreview()"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">OG Image</label>
                                    <div class="d-flex gap-2 align-items-start">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control mb-2" id="page-og-image" oninput="updatePreview()" placeholder="URL slike ili uploadujte novu">
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="file" class="form-control form-control-sm" id="og-image-file" accept="image/*" onchange="uploadOgImage(this)">
                                                <span id="og-upload-status" class="text-muted" style="font-size:12px;white-space:nowrap;"></span>
                                            </div>
                                            <small class="text-muted">Preporučena veličina: 1200x630px. Uploadujte sliku ili unesite URL.</small>
                                        </div>
                                        <div id="og-image-preview" style="width:120px;height:63px;background:var(--darkest);border-radius:6px;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                            <small class="text-muted">Preview</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">OG Image Alt tekst</label>
                                    <input type="text" class="form-control" id="page-og-image-alt" oninput="updatePageScore()" placeholder="Opis slike za pristupačnost i SEO">
                                    <small class="text-muted">Alt tekst za OG sliku — poboljšava pristupačnost i SEO score</small>
                                </div>
                            </div>

                            <h6 class="text-warning mt-3 mb-3"><i class="bi bi-robot"></i> Indeksiranje</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Robots meta</label>
                                    <select class="form-select" id="page-robots">
                                        <option value="index, follow">index, follow</option>
                                        <option value="index, nofollow">index, nofollow</option>
                                        <option value="noindex, follow">noindex, follow</option>
                                        <option value="noindex, nofollow">noindex, nofollow</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Canonical URL</label>
                                    <input type="text" class="form-control" id="page-canonical">
                                    <small class="text-muted">Ostaviti prazno za automatski</small>
                                </div>
                            </div>

                            <button class="btn btn-primary" onclick="savePageSeo()"><i class="bi bi-check-lg"></i> Sačuvaj ovu stranicu</button>

                            <!-- Google Preview -->
                            <h6 class="mt-4 mb-2"><i class="bi bi-google"></i> Google Preview</h6>
                            <div class="preview-google">
                                <div class="g-title" id="preview-g-title">Naslov stranice</div>
                                <div class="g-url" id="preview-g-url">dobar.psihijatar.info</div>
                                <div class="g-desc" id="preview-g-desc">Opis stranice...</div>
                            </div>

                            <!-- OG Preview -->
                            <h6 class="mt-4 mb-2"><i class="bi bi-facebook"></i> Facebook Preview</h6>
                            <div class="preview-og">
                                <div class="og-image" id="preview-og-image">Nema slike</div>
                                <div class="og-body">
                                    <div class="og-site">dobar.psihijatar.info</div>
                                    <div class="og-title" id="preview-og-title">OG Naslov</div>
                                    <div class="og-desc" id="preview-og-desc">OG Opis</div>
                                </div>
                            </div>
                        </div>

                        <div id="no-page-selected" class="card-section text-center" style="padding:60px;">
                            <i class="bi bi-hand-index" style="font-size:48px;color:var(--primary);"></i>
                            <p class="mt-3 text-muted">Izaberite stranicu sa lijeve strane za uređivanje SEO podešavanja</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GLOBAL SEO -->
            <div class="tab-pane fade" id="sec-global">
                <div class="card-section">
                    <h5><i class="bi bi-globe"></i> Globalna SEO podešavanja</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naziv sajta (OG site_name)</label>
                            <input type="text" class="form-control" id="global-site-name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Podrazumjevani OG Image</label>
                            <input type="text" class="form-control" id="global-og-image">
                            <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGlobalOgImg(this)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Podrazumjevani autor</label>
                            <input type="text" class="form-control" id="global-author">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jezik sajta</label>
                            <input type="text" class="form-control" id="global-language">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Base URL</label>
                            <input type="text" class="form-control" id="global-base-url">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Google Analytics ID</label>
                            <input type="text" class="form-control" id="global-ga">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Facebook Pixel ID</label>
                            <input type="text" class="form-control" id="global-fb-pixel">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SCHEMA.ORG -->
            <div class="tab-pane fade" id="sec-schema">
                <div class="card-section">
                    <h5><i class="bi bi-code-square"></i> Schema.org (Structured Data)</h5>
                    <p class="text-muted">JSON-LD podaci za Google Rich Results. Tip: MedicalBusiness</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tip organizacije</label>
                            <select class="form-select" id="schema-type">
                                <option value="MedicalBusiness">MedicalBusiness</option>
                                <option value="Physician">Physician</option>
                                <option value="Hospital">Hospital</option>
                                <option value="MedicalClinic">MedicalClinic</option>
                                <option value="LocalBusiness">LocalBusiness</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naziv</label>
                            <input type="text" class="form-control" id="schema-name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Opis</label>
                            <textarea class="form-control" id="schema-description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL sajta</label>
                            <input type="text" class="form-control" id="schema-url">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="schema-telephone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ulica</label>
                            <input type="text" class="form-control" id="schema-street">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Grad</label>
                            <input type="text" class="form-control" id="schema-city">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Poštanski broj</label>
                            <input type="text" class="form-control" id="schema-postal">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Država (ISO)</label>
                            <input type="text" class="form-control" id="schema-country">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="schema-lat">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="schema-lng">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Radno vrijeme</label>
                            <input type="text" class="form-control" id="schema-hours" placeholder="Mo-Fr 08:00-16:00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Raspon cijena</label>
                            <input type="text" class="form-control" id="schema-price" placeholder="$$">
                        </div>
                    </div>

                    <!-- Preview -->
                    <h6 class="mt-3"><i class="bi bi-code"></i> JSON-LD Preview</h6>
                    <pre id="schema-preview" style="background:var(--darkest);padding:15px;border-radius:8px;color:#2ecc71;font-size:13px;max-height:300px;overflow-y:auto;"></pre>
                    <button class="btn btn-sm btn-outline-info" onclick="updateSchemaPreview()"><i class="bi bi-arrow-repeat"></i> Osvježi preview</button>
                </div>
            </div>

            <!-- ROBOTS.TXT -->
            <div class="tab-pane fade" id="sec-robots">
                <div class="card-section">
                    <h5><i class="bi bi-robot"></i> Robots.txt</h5>
                    <p class="text-muted">Kontroliše koji djelovi sajta su dostupni web crawlerima</p>
                    <textarea class="form-control" id="robots-content" rows="12" style="font-family:monospace;"></textarea>
                    <button class="btn btn-primary mt-3" onclick="saveRobots()"><i class="bi bi-check-lg"></i> Sačuvaj robots.txt</button>
                </div>
            </div>

            <!-- SITEMAP -->
            <div class="tab-pane fade" id="sec-sitemap">
                <div class="card-section" id="sitemap">
                    <h5><i class="bi bi-diagram-3"></i> Sitemap Generator</h5>
                    <p class="text-muted">Automatski generise sitemap.xml na osnovu stranica definisanih u SEO podešavanjima. Stranice sa "noindex" neće biti uključene.</p>
                    <button class="btn btn-primary btn-lg" onclick="generateSitemap()"><i class="bi bi-arrow-repeat"></i> Generiši sitemap.xml</button>
                    <div id="sitemap-result" class="mt-3"></div>
                    <div class="mt-3">
                        <a href="../sitemap.xml" target="_blank" class="btn btn-outline-light btn-sm"><i class="bi bi-eye"></i> Pogledaj trenutni sitemap.xml</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3 mb-5">
            <button class="btn btn-primary btn-lg" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve SEO promjene</button>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container">
        <div id="toast" class="toast" role="alert">
            <div class="toast-body" id="toast-body"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let seoData = {};
    let contentData = {};
    let currentPage = null;

    const cssClassImages = {
        'page-head-health': 'images/shutterstock_2011327436.jpg',
        'page-head-psihijatrija': 'images/vaves.jpg',
        'page-head-o-psiho': 'images/shutterstock_1906731082.jpg',
        'page-head-konst': 'images/konstelacije.jpg',
        'page-head-emdr': 'images/shutterstock_2033568857.jpg',
        'page-head-grupna': 'images/cicrles.jpg',
        'page-head-asert': 'images/bookcover/heart1.jpg',
        'page-head-depr': 'images/shutterstock_1819084715.jpg',
        'page-head-plavi-sat': 'images/plavi-sat-bg.jpg',
        'page-head-anksiolitik': 'images/anksiolitik.jpg',
        'page-head-dementofobija': 'images/dementophobia.jpg',
        'page-head-pst': 'images/shutterstock_2015673821.jpg',
        'page-head-norm': 'images/normalan.jpg',
        'page-head-bol': 'images/bol.jpg',
        'page-head-veze': 'images/veze.png',
        'page-head-partnerskaterapija': 'images/partnerskaterapija.png',
        'page-head-stres': 'images/stres.png',
        'page-head-debljina': 'images/debljina.jpg',
        'page-head-ciklusi': 'images/ciklusi.png',
        'page-head-four': 'images/bookcover/water.jpg',
        'page-head-burn': 'images/bookcover/burnout.jpg',
        'page-head-ppl': 'images/shutterstock_1929703829.jpg',
        'page-head-know': 'images/shutterstock_1155338887.jpg',
        'page-head-books': 'images/polica.jpg',
        'page-head-contact': 'images/team/05.jpg',
        'page-head-news': 'images/shutterstock_1501617461.jpg',
        'page-head-simptom': 'images/plant.jpg',
        'page-head-kbt': 'images/delfini.jpg',
        'page-head-neuroloskipregled': 'images/neuroni.webp'
    };

    // Get auto OG data for an article page
    function getArticleAuto(pageFile) {
        const key = pageFile.replace('.php', '');
        const art = (contentData.articles || {})[key];
        if (!art) return null;
        const baseUrl = seoData.global?.base_url || 'https://dobar.psihijatar.info';
        let image = art.head_image || '';
        if (!image && art.page_head_class && cssClassImages[art.page_head_class]) {
            image = cssClassImages[art.page_head_class];
        }
        if (image && !image.startsWith('http')) image = baseUrl + '/' + image;
        let desc = '';
        if (art.sections) {
            const intro = art.sections.find(s => s.id === 'intro' && s.content);
            if (intro) {
                const tmp = document.createElement('div');
                tmp.innerHTML = intro.content;
                desc = (tmp.textContent || tmp.innerText || '').substring(0, 200);
            }
        }
        return { title: art.page_title || '', description: desc, image: image };
    }

    Promise.all([
        fetch('api.php?action=load_seo', { credentials: 'same-origin' }).then(r => r.json()),
        fetch('api.php?action=load_content', { credentials: 'same-origin' }).then(r => r.json())
    ]).then(([seo, content]) => {
        seoData = seo;
        contentData = content;
        // Auto-sync: add articles missing from SEO
        let added = 0;
        if (contentData.articles) {
            for (const [key, art] of Object.entries(contentData.articles)) {
                const file = key + '.php';
                if (!seoData.pages[file]) {
                    seoData.pages[file] = {
                        title: art.page_title || '',
                        meta_description: '',
                        meta_keywords: '',
                        og_title: art.page_title || '',
                        og_description: '',
                        og_image: '',
                        og_image_alt: '',
                        og_type: 'article',
                        robots: 'index, follow',
                        canonical: '',
                        h1: ''
                    };
                    added++;
                }
            }
        }
        renderPageList();
        populateGlobal();
        populateSchema();
        document.getElementById('robots-content').value = seo.global?.robots_txt || '';
        if (added > 0) {
            showToast('SEO podaci učitani. Dodano ' + added + ' novih članaka - kliknite Sačuvaj da ih trajno dodate.', 'info');
        } else {
            showToast('SEO podaci učitani', 'success');
        }
    }).catch(err => {
        console.error('Greška pri učitavanju:', err);
        showToast('Greška pri učitavanju SEO podataka: ' + err.message, 'danger');
    });

    // ===== PAGE LIST =====
    function renderPageList() {
        const list = document.getElementById('page-list');
        list.innerHTML = '';
        const pages = seoData.pages || {};
        Object.keys(pages).sort().forEach(page => {
            const p = pages[page];
            const score = calcScore(p);
            const scoreClass = score >= 80 ? 'score-good' : score >= 50 ? 'score-ok' : 'score-bad';
            list.innerHTML += `
                <div class="page-item ${currentPage === page ? 'active' : ''}" onclick="selectPage('${page}')">
                    <div>
                        <div class="page-name">${page}</div>
                        <div class="page-status">
                            ${p.meta_description ? '<span class="badge-ok">meta</span>' : '<span class="badge-missing">meta</span>'}
                            ${p.og_title ? '<span class="badge-ok ms-1">og</span>' : '<span class="badge-missing ms-1">og</span>'}
                        </div>
                    </div>
                    <span class="seo-score ${scoreClass}">${score}</span>
                </div>`;
        });
    }

    function calcScore(p) {
        let score = 0;
        if (p.title && p.title.length > 10) score += 18;
        if (p.meta_description && p.meta_description.length > 50) score += 22;
        if (p.og_title) score += 12;
        if (p.og_description) score += 13;
        if (p.og_image) score += 13;
        if (p.meta_keywords) score += 7;
        if (p.canonical) score += 5;
        if (p.og_image && p.og_image_alt) score += 5;
        if (p.robots && p.robots !== 'noindex, nofollow') score += 5;
        return Math.min(score, 100);
    }

    function filterPages(query) {
        const items = document.querySelectorAll('.page-item');
        query = query.toLowerCase();
        items.forEach(item => {
            const name = item.querySelector('.page-name').textContent.toLowerCase();
            item.style.display = name.includes(query) ? 'flex' : 'none';
        });
    }

    // ===== PAGE EDITOR =====
    function selectPage(page) {
        currentPage = page;
        const p = seoData.pages[page] || {};
        document.getElementById('page-editor').style.display = 'block';
        document.getElementById('no-page-selected').style.display = 'none';
        document.getElementById('editing-page').textContent = page;

        const auto = getArticleAuto(page);

        document.getElementById('page-title').value = p.title || '';
        document.getElementById('page-title').placeholder = auto ? auto.title : '';
        document.getElementById('page-description').value = p.meta_description || '';
        document.getElementById('page-description').placeholder = auto ? auto.description : '';
        document.getElementById('page-keywords').value = p.meta_keywords || '';
        document.getElementById('page-og-title').value = p.og_title || '';
        document.getElementById('page-og-title').placeholder = auto ? auto.title : '';
        document.getElementById('page-og-desc').value = p.og_description || '';
        document.getElementById('page-og-desc').placeholder = auto ? auto.description : '';
        document.getElementById('page-og-image').value = p.og_image || '';
        document.getElementById('page-og-image').placeholder = auto && auto.image ? auto.image : '';
        document.getElementById('page-og-image-alt').value = p.og_image_alt || '';
        document.getElementById('page-og-type').value = p.og_type || (auto ? 'article' : 'website');
        document.getElementById('page-robots').value = p.robots || 'index, follow';
        document.getElementById('page-canonical').value = p.canonical || '';

        // Show auto-info banner
        const autoInfo = document.getElementById('auto-og-info');
        if (auto) {
            let html = '<i class="bi bi-info-circle"></i> Ova stranica je članak — prazna polja se automatski popunjavaju iz podataka članka:';
            html += '<ul class="mb-0 mt-1" style="font-size:12px;">';
            if (auto.title) html += '<li><b>Naslov:</b> ' + escHtml(auto.title) + '</li>';
            if (auto.description) html += '<li><b>Opis:</b> ' + escHtml(auto.description.substring(0, 80)) + '...</li>';
            if (auto.image) html += '<li><b>Slika:</b> ' + escHtml(auto.image.split('/').pop()) + '</li>';
            html += '</ul>';
            autoInfo.innerHTML = html;
            autoInfo.style.display = 'block';
        } else {
            autoInfo.style.display = 'none';
        }

        countChars(document.getElementById('page-title'), 'title-count', 50, 60);
        countChars(document.getElementById('page-description'), 'desc-count', 120, 160);
        updatePreview();
        updatePageScore();
        updateOgImagePreview(p.og_image || (auto && auto.image ? auto.image : ''));
        document.getElementById('og-upload-status').textContent = '';
        document.getElementById('og-image-file').value = '';
        renderPageList();
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function savePageSeo() {
        if (!currentPage) return;
        seoData.pages[currentPage] = {
            title: document.getElementById('page-title').value,
            meta_description: document.getElementById('page-description').value,
            meta_keywords: document.getElementById('page-keywords').value,
            og_title: document.getElementById('page-og-title').value,
            og_description: document.getElementById('page-og-desc').value,
            og_image: document.getElementById('page-og-image').value,
            og_image_alt: document.getElementById('page-og-image-alt').value,
            og_type: document.getElementById('page-og-type').value,
            robots: document.getElementById('page-robots').value,
            canonical: document.getElementById('page-canonical').value,
            h1: seoData.pages[currentPage]?.h1 || ''
        };
        renderPageList();
        showToast('SEO za ' + currentPage + ' sačuvan lokalno. Kliknite "Sačuvaj sve" za trajno čuvanje.', 'info');
    }

    function updatePreview() {
        const auto = currentPage ? getArticleAuto(currentPage) : null;
        const title = document.getElementById('page-title').value || (auto ? auto.title : '') || 'Naslov stranice';
        const desc = document.getElementById('page-description').value || (auto ? auto.description : '') || 'Opis stranice...';
        const ogTitle = document.getElementById('page-og-title').value || (auto ? auto.title : '') || title;
        const ogDesc = document.getElementById('page-og-desc').value || (auto ? auto.description : '') || desc;
        const ogImage = document.getElementById('page-og-image').value || (auto ? auto.image : '');
        const baseUrl = seoData.global?.base_url || 'https://dobar.psihijatar.info';

        document.getElementById('preview-g-title').textContent = title;
        document.getElementById('preview-g-url').textContent = baseUrl + '/' + (currentPage || '');
        document.getElementById('preview-g-desc').textContent = desc;

        document.getElementById('preview-og-title').textContent = ogTitle;
        document.getElementById('preview-og-desc').textContent = ogDesc;
        const imgEl = document.getElementById('preview-og-image');
        if (ogImage) {
            imgEl.innerHTML = '<img src="' + ogImage + '" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.textContent=\'Slika nije dostupna\'">';
        } else {
            imgEl.textContent = 'Nema OG slike';
        }

        updatePageScore();
    }

    function updatePageScore() {
        if (!currentPage) return;
        const auto = getArticleAuto(currentPage);
        const p = {
            title: document.getElementById('page-title').value || (auto ? auto.title : ''),
            meta_description: document.getElementById('page-description').value || (auto ? auto.description : ''),
            meta_keywords: document.getElementById('page-keywords').value,
            og_title: document.getElementById('page-og-title').value || (auto ? auto.title : ''),
            og_description: document.getElementById('page-og-desc').value || (auto ? auto.description : ''),
            og_image: document.getElementById('page-og-image').value || (auto ? auto.image : ''),
            og_image_alt: document.getElementById('page-og-image-alt').value,
            canonical: document.getElementById('page-canonical').value,
            robots: document.getElementById('page-robots').value
        };
        const score = calcScore(p);
        const badge = document.getElementById('seo-score-badge');
        badge.textContent = score;
        badge.className = 'seo-score ' + (score >= 80 ? 'score-good' : score >= 50 ? 'score-ok' : 'score-bad');

        const tips = [];
        if (!p.title || p.title.length < 10) tips.push('Dodajte title (50-60 char)');
        if (!p.meta_description || p.meta_description.length < 50) tips.push('Dodajte meta description (120-160 char)');
        if (!p.og_title) tips.push('Dodajte OG title');
        if (!p.og_description) tips.push('Dodajte OG description');
        if (!p.og_image) tips.push('Dodajte OG image');
        if (p.og_image && !p.og_image_alt) tips.push('Dodajte alt tekst za OG sliku');
        if (!p.canonical) tips.push('Dodajte canonical URL');
        document.getElementById('seo-tips').textContent = tips.length ? tips.join(' | ') : 'Odlično!';
    }

    function countChars(el, countId, min, max) {
        const len = el.value.length;
        const countEl = document.getElementById(countId);
        countEl.textContent = `(${len} karaktera)`;
        countEl.className = 'char-count' + (len > max ? ' danger' : len < min ? ' warn' : '');
    }

    // ===== GLOBAL =====
    function populateGlobal() {
        const g = seoData.global || {};
        document.getElementById('global-site-name').value = g.site_name || '';
        document.getElementById('global-og-image').value = g.default_og_image || '';
        document.getElementById('global-author').value = g.default_author || '';
        document.getElementById('global-language').value = g.language || '';
        document.getElementById('global-base-url').value = g.base_url || '';
        document.getElementById('global-ga').value = g.google_analytics || '';
        document.getElementById('global-fb-pixel').value = g.fb_pixel || '';
    }

    function collectGlobal() {
        seoData.global.site_name = document.getElementById('global-site-name').value;
        seoData.global.default_og_image = document.getElementById('global-og-image').value;
        seoData.global.default_author = document.getElementById('global-author').value;
        seoData.global.language = document.getElementById('global-language').value;
        seoData.global.base_url = document.getElementById('global-base-url').value;
        seoData.global.google_analytics = document.getElementById('global-ga').value;
        seoData.global.fb_pixel = document.getElementById('global-fb-pixel').value;
        seoData.global.robots_txt = document.getElementById('robots-content').value;
    }

    // ===== SCHEMA =====
    function populateSchema() {
        const s = seoData.global?.schema_org || {};
        document.getElementById('schema-type').value = s.type || 'MedicalBusiness';
        document.getElementById('schema-name').value = s.name || '';
        document.getElementById('schema-description').value = s.description || '';
        document.getElementById('schema-url').value = s.url || '';
        document.getElementById('schema-telephone').value = s.telephone || '';
        document.getElementById('schema-street').value = s.address?.street || '';
        document.getElementById('schema-city').value = s.address?.city || '';
        document.getElementById('schema-postal').value = s.address?.postal || '';
        document.getElementById('schema-country').value = s.address?.country || '';
        document.getElementById('schema-lat').value = s.geo?.latitude || '';
        document.getElementById('schema-lng').value = s.geo?.longitude || '';
        document.getElementById('schema-hours').value = s.opening_hours || '';
        document.getElementById('schema-price').value = s.price_range || '';
        updateSchemaPreview();
    }

    function collectSchema() {
        seoData.global.schema_org = {
            type: document.getElementById('schema-type').value,
            name: document.getElementById('schema-name').value,
            description: document.getElementById('schema-description').value,
            url: document.getElementById('schema-url').value,
            telephone: document.getElementById('schema-telephone').value,
            address: {
                street: document.getElementById('schema-street').value,
                city: document.getElementById('schema-city').value,
                postal: document.getElementById('schema-postal').value,
                country: document.getElementById('schema-country').value
            },
            geo: {
                latitude: document.getElementById('schema-lat').value,
                longitude: document.getElementById('schema-lng').value
            },
            opening_hours: document.getElementById('schema-hours').value,
            price_range: document.getElementById('schema-price').value
        };
    }

    function updateSchemaPreview() {
        collectSchema();
        const s = seoData.global.schema_org;
        const jsonLd = {
            "@context": "https://schema.org",
            "@type": s.type,
            "name": s.name,
            "description": s.description,
            "url": s.url,
            "telephone": s.telephone,
            "address": {
                "@type": "PostalAddress",
                "streetAddress": s.address.street,
                "addressLocality": s.address.city,
                "postalCode": s.address.postal,
                "addressCountry": s.address.country
            }
        };
        if (s.geo.latitude && s.geo.longitude) {
            jsonLd.geo = { "@type": "GeoCoordinates", "latitude": s.geo.latitude, "longitude": s.geo.longitude };
        }
        if (s.opening_hours) jsonLd.openingHours = s.opening_hours;
        if (s.price_range) jsonLd.priceRange = s.price_range;

        document.getElementById('schema-preview').textContent = JSON.stringify(jsonLd, null, 2);
    }

    // ===== SAVE ALL =====
    function saveAll() {
        // Collect current page if editing
        if (currentPage) savePageSeo();
        collectGlobal();
        collectSchema();

        const formData = new FormData();
        formData.append('action', 'save_seo');
        formData.append('data', JSON.stringify(seoData));

        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => showToast(data.message, data.status === 'ok' ? 'success' : 'danger'))
            .catch(() => showToast('Greška pri čuvanju', 'danger'));
    }

    function saveRobots() {
        const content = document.getElementById('robots-content').value;
        const formData = new FormData();
        formData.append('action', 'save_robots');
        formData.append('content', content);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => showToast(data.message, data.status === 'ok' ? 'success' : 'danger'));
    }

    function generateSitemap() {
        fetch('api.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'action=generate_sitemap' })
            .then(r => r.json())
            .then(data => {
                document.getElementById('sitemap-result').innerHTML = '<div class="alert alert-success">' + data.message + ' (' + data.pages + ' stranica)</div>';
            });
    }

    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        const body = document.getElementById('toast-body');
        toast.className = 'toast show bg-' + type + ' text-white';
        body.textContent = msg;
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function uploadGlobalOgImg(input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_og_image');
        formData.append('og_image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('global-og-image').value = data.url;
                    showToast('OG slika uploadovana', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function uploadOgImage(input) {
        if (!input.files || !input.files[0]) return;
        const statusEl = document.getElementById('og-upload-status');
        statusEl.textContent = 'Uploadovanje...';
        statusEl.className = 'text-warning';
        const formData = new FormData();
        formData.append('action', 'upload_og_image');
        formData.append('og_image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('page-og-image').value = data.url;
                    statusEl.textContent = 'Uploadovano!';
                    statusEl.className = 'text-success';
                    updatePreview();
                    updateOgImagePreview(data.url);
                } else {
                    statusEl.textContent = data.message;
                    statusEl.className = 'text-danger';
                }
            })
            .catch(() => { statusEl.textContent = 'Greška'; statusEl.className = 'text-danger'; });
    }

    function updateOgImagePreview(url) {
        const el = document.getElementById('og-image-preview');
        if (url) {
            el.innerHTML = '<img src="' + url + '" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML=\'<small class=text-muted>Nije dostupna</small>\'">';
        } else {
            el.innerHTML = '<small class="text-muted">Preview</small>';
        }
    }

    // Handle hash
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        const tab = document.querySelector(`[href="#sec-${hash}"]`);
        if (tab) new bootstrap.Tab(tab).show();
    }
    </script>
</body>
</html>
