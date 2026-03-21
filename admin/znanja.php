<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Znanja - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-book"></i> Znanja</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../znanja.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-services">Kartice znanja</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-quotes1">Citati (sekcija 1)</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-quotes2">Citati (sekcija 2)</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-gallery">Galerija</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <!-- SERVICES/ARTICLES -->
            <div class="tab-pane fade show active" id="sec-services">
                <div class="card-section">
                    <h5><i class="bi bi-grid"></i> Kartice znanja (članci)</h5>
                    <p class="text-muted">Prvih 6 imaju fiksne pozicije u HTML-u. Svaka kartica vodi na članak.</p>
                    <div id="service-items"></div>
                    <button class="btn-add mt-2" onclick="addService()"><i class="bi bi-plus-lg"></i> Dodaj karticu/članak</button>
                </div>
            </div>

            <!-- QUOTES 1 -->
            <div class="tab-pane fade" id="sec-quotes1">
                <div class="card-section">
                    <h5><i class="bi bi-quote"></i> Citati - sekcija 1 (između prve i druge grupe kartica)</h5>
                    <div id="quotes1-items"></div>
                    <button class="btn-add mt-2" onclick="addQuote(1)"><i class="bi bi-plus-lg"></i> Dodaj citat</button>
                </div>
            </div>

            <!-- QUOTES 2 -->
            <div class="tab-pane fade" id="sec-quotes2">
                <div class="card-section">
                    <h5><i class="bi bi-quote"></i> Citati - sekcija 2 (između druge i treće grupe kartica)</h5>
                    <div id="quotes2-items"></div>
                    <button class="btn-add mt-2" onclick="addQuote(2)"><i class="bi bi-plus-lg"></i> Dodaj citat</button>
                </div>
            </div>

            <!-- GALLERY -->
            <div class="tab-pane fade" id="sec-gallery">
                <div class="card-section">
                    <h5><i class="bi bi-images"></i> Galerija na dnu stranice</h5>
                    <div id="gallery-items"></div>
                    <button class="btn-add mt-2" onclick="addGallery()"><i class="bi bi-plus-lg"></i> Dodaj sliku</button>
                </div>
            </div>

            <!-- SETTINGS -->
            <div class="tab-pane fade" id="sec-settings">
                <div class="card-section">
                    <h5><i class="bi bi-gear"></i> Postavke stranice</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naslov stranice</label>
                            <input type="text" class="form-control" id="page-title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Podnaslov</label>
                            <input type="text" class="form-control" id="page-subtitle">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3 mb-5">
            <button class="btn btn-primary btn-lg" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve promjene</button>
        </div>
    </div>

    <div class="toast-container">
        <div id="toast" class="toast" role="alert"><div class="toast-body" id="toast-body"></div></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let contentData = {};

    fetch('api.php?action=load_content', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => { contentData = data; populateForm(); showToast('Podaci učitani', 'success'); })
        .catch(err => showToast('Greška: ' + err.message, 'danger'));

    function populateForm() {
        const z = contentData.znanja || {};
        document.getElementById('page-title').value = z.page_title || '';
        document.getElementById('page-subtitle').value = z.subtitle || '';
        renderServices();
        renderQuotes(1);
        renderQuotes(2);
        renderGallery();
    }

    function renderServices() {
        const c = document.getElementById('service-items');
        c.innerHTML = '';
        (contentData.znanja?.services || []).forEach((item, i) => {
            const badge = i < 6 ? '<span class="badge bg-warning text-dark">Fiksna pozicija ' + (i+1) + '</span>' : '<span class="badge bg-secondary">Dinamička</span>';
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.title) || 'Kartica ' + (i+1)} ${badge}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleService(${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeService(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.znanja.services[${i}].title=this.value">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Link (članak)</label>
                        <select class="form-select" onchange="contentData.znanja.services[${i}].link=this.value">
                            <option value="">-- Izaberi članak --</option>
                            ${getArticleOptions(item.link)}
                        </select>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Opis (prikazuje se na kartici)</label>
                        <textarea class="form-control" onchange="contentData.znanja.services[${i}].text=this.value">${escHtml(item.text)}</textarea>
                    </div>
                </div>
            </div>`;
        });
    }

    function addService() {
        if (!contentData.znanja) contentData.znanja = { services: [] };
        if (!contentData.znanja.services) contentData.znanja.services = [];
        contentData.znanja.services.push({ title: '', text: '', link: '', active: true });
        renderServices();
    }

    function toggleService(i) {
        contentData.znanja.services[i].active = !contentData.znanja.services[i].active;
        renderServices();
    }

    function removeService(i) {
        if (!confirm('Obrisati karticu?')) return;
        contentData.znanja.services.splice(i, 1);
        renderServices();
    }

    function renderQuotes(num) {
        const key = 'quotes_' + num;
        const c = document.getElementById('quotes' + num + '-items');
        c.innerHTML = '';
        (contentData.znanja?.[key] || []).forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.author) || 'Citat ' + (i+1)}</h6>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeQuote(${num},${i})"><i class="bi bi-trash"></i></button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tekst</label>
                    <textarea class="form-control" onchange="contentData.znanja.${key}[${i}].text=this.value">${escHtml(item.text)}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Autor</label>
                    <input type="text" class="form-control" value="${escHtml(item.author)}" onchange="contentData.znanja.${key}[${i}].author=this.value">
                </div>
            </div>`;
        });
    }

    function addQuote(num) {
        const key = 'quotes_' + num;
        if (!contentData.znanja[key]) contentData.znanja[key] = [];
        contentData.znanja[key].push({ text: '', author: '' });
        renderQuotes(num);
    }

    function removeQuote(num, i) {
        if (!confirm('Obrisati citat?')) return;
        contentData.znanja['quotes_' + num].splice(i, 1);
        renderQuotes(num);
    }

    function renderGallery() {
        const c = document.getElementById('gallery-items');
        c.innerHTML = '';
        (contentData.znanja?.gallery || []).forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>Slika ${i + 1}</h6>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeGalleryItem(${i})"><i class="bi bi-trash"></i></button>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-2">${item.thumb ? '<img src="../' + escHtml(item.thumb) + '" style="width:80px;height:60px;object-fit:cover;border-radius:6px;" onerror="this.style.display=\'none\'">' : ''}</div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Puna slika</label>
                        <input type="text" class="form-control" id="zn-gimg-${i}" value="${escHtml(item.image)}" onchange="contentData.znanja.gallery[${i}].image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalleryImg(${i},'image',this)">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Thumbnail</label>
                        <input type="text" class="form-control" id="zn-gthumb-${i}" value="${escHtml(item.thumb)}" onchange="contentData.znanja.gallery[${i}].thumb=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalleryImg(${i},'thumb',this)">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.znanja.gallery[${i}].title=this.value">
                    </div>
                </div>
            </div>`;
        });
    }

    function addGallery() {
        if (!contentData.znanja.gallery) contentData.znanja.gallery = [];
        contentData.znanja.gallery.push({ image: '', thumb: '', title: '' });
        renderGallery();
    }

    function removeGalleryItem(i) {
        if (!confirm('Obrisati?')) return;
        contentData.znanja.gallery.splice(i, 1);
        renderGallery();
    }

    function uploadGalleryImg(i, field, input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/gallery/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.znanja.gallery[i][field] = data.path;
                    document.getElementById('zn-g' + field + '-' + i).value = data.path;
                    showToast('Slika uploadovana', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function getArticleOptions(currentLink) {
        let opts = '';
        const articles = contentData.articles || {};
        for (const [key, art] of Object.entries(articles)) {
            const file = key + '.php';
            const sel = (file === currentLink) ? 'selected' : '';
            opts += '<option value="' + file + '" ' + sel + '>' + escHtml(art.page_title) + ' (' + file + ')</option>';
        }
        return opts;
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function saveAll() {
        contentData.znanja.page_title = document.getElementById('page-title').value;
        contentData.znanja.subtitle = document.getElementById('page-subtitle').value;
        const formData = new FormData();
        formData.append('action', 'save_content');
        formData.append('data', JSON.stringify(contentData));
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => showToast(data.message, data.status === 'ok' ? 'success' : 'danger'))
            .catch(() => showToast('Greška pri čuvanju', 'danger'));
    }

    function showToast(msg, type) {
        const t = document.getElementById('toast'), b = document.getElementById('toast-body');
        t.className = 'toast show bg-' + type + ' text-white';
        b.textContent = msg;
        setTimeout(() => t.classList.remove('show'), 3000);
    }
    </script>
</body>
</html>
