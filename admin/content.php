<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sadržaj - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Upravljanje sadržajem</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Sajt</a>
            </div>
        </div>

        <!-- Section Navigation -->
        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-site">Osnovni podaci</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-slider">Slider</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-services">Usluge</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-quotes">Citati</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-testimonials">Iskustva</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-team">Tim</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-cta">CTA</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-footer">Footer</a></li>
        </ul>

        <div class="tab-content">
            <!-- SITE INFO -->
            <div class="tab-pane fade show active" id="sec-site">
                <div class="card-section">
                    <h5><i class="bi bi-building"></i> Osnovni podaci sajta</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naziv ustanove</label>
                            <input type="text" class="form-control" id="site-title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="site-email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="site-phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adresa</label>
                            <input type="text" class="form-control" id="site-address">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">WhatsApp broj</label>
                            <input type="text" class="form-control" id="site-whatsapp">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Viber broj</label>
                            <input type="text" class="form-control" id="site-viber">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Facebook stranica</label>
                            <input type="text" class="form-control" id="site-facebook">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Copyright tekst</label>
                            <input type="text" class="form-control" id="site-copyright">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDER -->
            <div class="tab-pane fade" id="sec-slider">
                <div class="card-section" id="slider">
                    <h5><i class="bi bi-images"></i> Slider na naslovnoj</h5>
                    <div id="slider-items"></div>
                    <button class="btn-add mt-2" onclick="addSlider()"><i class="bi bi-plus-lg"></i> Dodaj slide</button>
                </div>
            </div>

            <!-- SERVICES -->
            <div class="tab-pane fade" id="sec-services">
                <div class="card-section">
                    <h5><i class="bi bi-grid"></i> Usluge na naslovnoj</h5>
                    <div id="services-items"></div>
                    <button class="btn-add mt-2" onclick="addService()"><i class="bi bi-plus-lg"></i> Dodaj uslugu</button>
                </div>
            </div>

            <!-- QUOTES -->
            <div class="tab-pane fade" id="sec-quotes">
                <div class="card-section">
                    <h5><i class="bi bi-quote"></i> Citati</h5>
                    <div id="quotes-items"></div>
                    <button class="btn-add mt-2" onclick="addQuote()"><i class="bi bi-plus-lg"></i> Dodaj citat</button>
                </div>
            </div>

            <!-- TESTIMONIALS -->
            <div class="tab-pane fade" id="sec-testimonials">
                <div class="card-section">
                    <h5><i class="bi bi-chat-quote"></i> Iskustva klijenata</h5>
                    <div id="testimonials-items"></div>
                    <button class="btn-add mt-2" onclick="addTestimonial()"><i class="bi bi-plus-lg"></i> Dodaj iskustvo</button>
                </div>
            </div>

            <!-- TEAM -->
            <div class="tab-pane fade" id="sec-team">
                <div class="card-section" id="team">
                    <h5><i class="bi bi-people"></i> Članovi tima</h5>
                    <div id="team-items"></div>
                    <button class="btn-add mt-2" onclick="addTeamMember()"><i class="bi bi-plus-lg"></i> Dodaj člana</button>
                </div>
            </div>

            <!-- CTA -->
            <div class="tab-pane fade" id="sec-cta">
                <div class="card-section">
                    <h5><i class="bi bi-megaphone"></i> Call to Action</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naslov</label>
                            <input type="text" class="form-control" id="cta-heading">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="cta-email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tekst dugmeta</label>
                            <input type="text" class="form-control" id="cta-button">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Podtekst</label>
                            <input type="text" class="form-control" id="cta-subtext">
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="tab-pane fade" id="sec-footer">
                <div class="card-section">
                    <h5><i class="bi bi-layout-text-window-reverse"></i> Footer</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" class="form-control" id="footer-tagline">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Naslov za rezervacije</label>
                            <input type="text" class="form-control" id="footer-booking-title">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save button fixed bottom -->
        <div class="text-end mt-3 mb-5">
            <button class="btn btn-primary btn-lg" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve promjene</button>
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
    let contentData = {};

    // Load data
    fetch('api.php?action=load_content', { credentials: 'same-origin' })
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            contentData = data;
            populateForm();
            showToast('Podaci učitani', 'success');
        })
        .catch(err => {
            console.error('Greška pri učitavanju:', err);
            showToast('Greška pri učitavanju podataka: ' + err.message, 'danger');
        });

    function populateForm() {
        const d = contentData;
        // Site
        document.getElementById('site-title').value = d.site?.title || '';
        document.getElementById('site-email').value = d.site?.email || '';
        document.getElementById('site-phone').value = d.site?.phone || '';
        document.getElementById('site-address').value = d.site?.address || '';
        document.getElementById('site-whatsapp').value = d.site?.whatsapp || '';
        document.getElementById('site-viber').value = d.site?.viber || '';
        document.getElementById('site-facebook').value = d.site?.facebook || '';
        document.getElementById('site-copyright').value = d.site?.copyright || '';
        // CTA
        document.getElementById('cta-heading').value = d.cta?.heading || '';
        document.getElementById('cta-email').value = d.cta?.email || '';
        document.getElementById('cta-button').value = d.cta?.button_text || '';
        document.getElementById('cta-subtext').value = d.cta?.subtext || '';
        // Footer
        document.getElementById('footer-tagline').value = d.footer?.tagline || '';
        document.getElementById('footer-booking-title').value = d.footer?.booking_title || '';
        // Dynamic sections
        renderSliders();
        renderServices();
        renderQuotes();
        renderTestimonials();
        renderTeam();
    }

    // ===== SLIDER =====
    function renderSliders() {
        const container = document.getElementById('slider-items');
        container.innerHTML = '';
        (contentData.slider || []).forEach((item, i) => {
            container.innerHTML += `
            <div class="item-card" id="slider-${i}">
                <div class="item-header">
                    <h6>Slide ${i + 1}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('slider',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('slider',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.heading)}" onchange="contentData.slider[${i}].heading=this.value">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Podnaslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.subheading)}" onchange="contentData.slider[${i}].subheading=this.value">
                    </div>
                </div>
            </div>`;
        });
    }
    function addSlider() {
        contentData.slider = contentData.slider || [];
        contentData.slider.push({ heading: '', subheading: '', active: true });
        renderSliders();
    }

    // ===== SERVICES =====
    function renderServices() {
        const container = document.getElementById('services-items');
        container.innerHTML = '';
        (contentData.services || []).forEach((item, i) => {
            container.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.title) || 'Usluga ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('services',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('services',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.services[${i}].title=this.value">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Link (stranica)</label>
                        <input type="text" class="form-control" value="${escHtml(item.link)}" onchange="contentData.services[${i}].link=this.value">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tekst</label>
                        <textarea class="form-control" onchange="contentData.services[${i}].text=this.value">${escHtml(item.text)}</textarea>
                    </div>
                </div>
            </div>`;
        });
    }
    function addService() {
        contentData.services = contentData.services || [];
        contentData.services.push({ title: '', text: '', link: '', active: true });
        renderServices();
    }

    // ===== QUOTES =====
    function renderQuotes() {
        const container = document.getElementById('quotes-items');
        container.innerHTML = '';
        (contentData.quotes || []).forEach((item, i) => {
            container.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.author) || 'Citat ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('quotes',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('quotes',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tekst citata</label>
                    <textarea class="form-control" onchange="contentData.quotes[${i}].text=this.value">${escHtml(item.text)}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Autor</label>
                    <input type="text" class="form-control" value="${escHtml(item.author)}" onchange="contentData.quotes[${i}].author=this.value">
                </div>
            </div>`;
        });
    }
    function addQuote() {
        contentData.quotes = contentData.quotes || [];
        contentData.quotes.push({ text: '', author: '', active: true });
        renderQuotes();
    }

    // ===== TESTIMONIALS =====
    function renderTestimonials() {
        const container = document.getElementById('testimonials-items');
        container.innerHTML = '';
        (contentData.testimonials || []).forEach((item, i) => {
            container.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.author) || 'Iskustvo ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('testimonials',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('testimonials',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tekst iskustva</label>
                    <textarea class="form-control" style="min-height:120px" onchange="contentData.testimonials[${i}].text=this.value">${escHtml(item.text)}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Potpis (ime, zanimanje, godine)</label>
                    <input type="text" class="form-control" value="${escHtml(item.author)}" onchange="contentData.testimonials[${i}].author=this.value">
                </div>
            </div>`;
        });
    }
    function addTestimonial() {
        contentData.testimonials = contentData.testimonials || [];
        contentData.testimonials.push({ text: '', author: '', active: true });
        renderTestimonials();
    }

    // ===== TEAM =====
    function renderTeam() {
        const container = document.getElementById('team-items');
        container.innerHTML = '';
        (contentData.team || []).forEach((item, i) => {
            container.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.name) || 'Član ' + (i+1)}</h6>
                    <div>
                        <select class="form-select form-select-sm d-inline-block" style="width:auto;background:var(--darkest);color:#ccc;" onchange="contentData.team[${i}].role=this.value">
                            <option value="lead" ${item.role==='lead'?'selected':''}>Glavni</option>
                            <option value="member" ${item.role==='member'?'selected':''}>Član</option>
                        </select>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('team',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('team',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">ID (slug)</label>
                        <input type="text" class="form-control" value="${escHtml(item.id)}" onchange="contentData.team[${i}].id=this.value">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Ime i prezime</label>
                        <input type="text" class="form-control" value="${escHtml(item.name)}" onchange="contentData.team[${i}].name=this.value">
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Slika (putanja)</label>
                        <input type="text" class="form-control" value="${escHtml(item.image)}" onchange="contentData.team[${i}].image=this.value">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Opis / biografija</label>
                        <textarea class="form-control" style="min-height:100px" onchange="contentData.team[${i}].description=this.value">${escHtml(item.description)}</textarea>
                    </div>
                </div>
            </div>`;
        });
    }
    function addTeamMember() {
        contentData.team = contentData.team || [];
        contentData.team.push({ id: '', name: '', image: 'images/team/', description: '', role: 'member', active: true });
        renderTeam();
    }

    // ===== HELPERS =====
    function toggleActive(section, index) {
        contentData[section][index].active = !contentData[section][index].active;
        const renderMap = { slider: renderSliders, services: renderServices, quotes: renderQuotes, testimonials: renderTestimonials, team: renderTeam };
        renderMap[section]();
    }

    function removeItem(section, index) {
        if (!confirm('Obrisati stavku?')) return;
        contentData[section].splice(index, 1);
        const renderMap = { slider: renderSliders, services: renderServices, quotes: renderQuotes, testimonials: renderTestimonials, team: renderTeam };
        renderMap[section]();
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function collectData() {
        contentData.site = {
            title: document.getElementById('site-title').value,
            email: document.getElementById('site-email').value,
            phone: document.getElementById('site-phone').value,
            address: document.getElementById('site-address').value,
            whatsapp: document.getElementById('site-whatsapp').value,
            viber: document.getElementById('site-viber').value,
            facebook: document.getElementById('site-facebook').value,
            copyright: document.getElementById('site-copyright').value
        };
        contentData.cta = {
            heading: document.getElementById('cta-heading').value,
            email: document.getElementById('cta-email').value,
            button_text: document.getElementById('cta-button').value,
            subtext: document.getElementById('cta-subtext').value
        };
        contentData.footer = {
            tagline: document.getElementById('footer-tagline').value,
            booking_title: document.getElementById('footer-booking-title').value
        };
    }

    function saveAll() {
        collectData();
        const formData = new FormData();
        formData.append('action', 'save_content');
        formData.append('data', JSON.stringify(contentData));

        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                showToast(data.message, data.status === 'ok' ? 'success' : 'danger');
            })
            .catch(() => showToast('Greška pri čuvanju', 'danger'));
    }

    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        const body = document.getElementById('toast-body');
        toast.className = 'toast show bg-' + type + ' text-white';
        body.textContent = msg;
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // Handle hash navigation
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        const tab = document.querySelector(`[href="#sec-${hash}"]`) || document.querySelector(`[href="#sec-site"]`);
        if (tab) new bootstrap.Tab(tab).show();
    }
    </script>
</body>
</html>
