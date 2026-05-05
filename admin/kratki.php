<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kratki tekstovi - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-card-text"></i> Kratki tekstovi</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../kratki-tekstovi.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-items">Tekstovi</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="sec-items">
                <div class="card-section">
                    <h5><i class="bi bi-collection"></i> Kratki tekstovi</h5>
                    <p class="text-muted">Svaki tekst ima naslov, kratki pasus i link. Link može voditi na postojeći članak (dropdown) ili na custom URL.</p>
                    <div id="kratki-items"></div>
                    <button class="btn-add mt-2" onclick="addItem()"><i class="bi bi-plus-lg"></i> Dodaj tekst</button>
                </div>
            </div>

            <div class="tab-pane fade" id="sec-settings">
                <div class="card-section">
                    <h5><i class="bi bi-gear"></i> Postavke</h5>
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
        if (!contentData.kratki) contentData.kratki = { page_title: 'Kratki tekstovi', subtitle: '', items: [] };
        if (!contentData.kratki.items) contentData.kratki.items = [];
        document.getElementById('page-title').value = contentData.kratki.page_title || '';
        document.getElementById('page-subtitle').value = contentData.kratki.subtitle || '';
        renderItems();
    }

    function renderItems() {
        const c = document.getElementById('kratki-items');
        c.innerHTML = '';
        const items = contentData.kratki?.items || [];
        items.forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>#${i+1} — ${escHtml(item.title) || 'Tekst ' + (i+1)}</h6>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-light" onclick="moveItem(${i},-1)" ${i===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveItem(${i},1)" ${i===items.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm ${item.active !== false ? 'btn-success' : 'btn-secondary'}" onclick="toggleItem(${i})">${item.active !== false ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.kratki.items[${i}].title=this.value">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Datum</label>
                        <input type="text" class="form-control" value="${escHtml(item.date || '')}" onchange="contentData.kratki.items[${i}].date=this.value" placeholder="npr. Mart '26">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Link (izaberi članak)</label>
                        <select class="form-select" onchange="if(this.value){contentData.kratki.items[${i}].link=this.value;document.getElementById('kr-link-${i}').value=this.value;}">
                            <option value="">-- Izaberi članak --</option>
                            ${getArticleOptions(item.link)}
                        </select>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">ili custom URL</label>
                        <input type="text" class="form-control" id="kr-link-${i}" value="${escHtml(item.link)}" onchange="contentData.kratki.items[${i}].link=this.value" placeholder="npr. ruminacija.php ili https://...">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Excerpt — kratki pasus koji se prikazuje na listi (preporuka: 2-4 rečenice)</label>
                        <textarea class="form-control" rows="3" onchange="contentData.kratki.items[${i}].excerpt=this.value">${escHtml(item.excerpt)}</textarea>
                    </div>
                </div>
            </div>`;
        });
    }

    function addItem() {
        if (!contentData.kratki) contentData.kratki = { page_title: 'Kratki tekstovi', subtitle: '', items: [] };
        if (!contentData.kratki.items) contentData.kratki.items = [];
        contentData.kratki.items.push({ title: '', excerpt: '', link: '', date: '', active: true });
        renderItems();
    }

    function toggleItem(i) {
        contentData.kratki.items[i].active = contentData.kratki.items[i].active === false;
        renderItems();
    }

    function moveItem(i, dir) {
        const items = contentData.kratki.items;
        const j = i + dir;
        if (j < 0 || j >= items.length) return;
        [items[i], items[j]] = [items[j], items[i]];
        renderItems();
    }

    function removeItem(i) {
        if (!confirm('Obrisati tekst?')) return;
        contentData.kratki.items.splice(i, 1);
        renderItems();
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
        contentData.kratki.page_title = document.getElementById('page-title').value;
        contentData.kratki.subtitle = document.getElementById('page-subtitle').value;
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'kratki');
        formData.append('data', JSON.stringify(contentData.kratki));
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
