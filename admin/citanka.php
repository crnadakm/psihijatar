<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Čitanka - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-journal-text"></i> Čitanka</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../dokumenti.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-items">Tekstovi</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="sec-items">
                <div class="card-section">
                    <h5><i class="bi bi-collection"></i> Tekstovi čitanke</h5>
                    <p class="text-muted">Svaki tekst ima naslov, opis, sliku, link i pozadinsku boju overlay-a</p>
                    <div id="citanka-items"></div>
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
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Podnaslov</label>
                            <input type="text" class="form-control" id="page-subtitle">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tekst "u pripremi"</label>
                            <input type="text" class="form-control" id="upcoming-text">
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
        const c = contentData.citanka || {};
        document.getElementById('page-title').value = c.page_title || '';
        document.getElementById('page-subtitle').value = c.subtitle || '';
        document.getElementById('upcoming-text').value = c.upcoming_text || '';
        renderItems();
    }

    function renderItems() {
        const c = document.getElementById('citanka-items');
        c.innerHTML = '';
        (contentData.citanka?.items || []).forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.title) || 'Tekst ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleItem(${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.citanka.items[${i}].title=this.value">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Link (članak)</label>
                        <select class="form-select" onchange="contentData.citanka.items[${i}].link=this.value">
                            <option value="">-- Izaberi članak --</option>
                            ${getArticleOptions(item.link)}
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Slika (URL ili upload)</label>
                        <input type="text" class="form-control" id="cit-img-${i}" value="${escHtml(item.image)}" onchange="contentData.citanka.items[${i}].image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadCitImg(${i},this)">
                    </div>
                    <div class="col-md-9 mb-2">
                        <label class="form-label">Opis</label>
                        <textarea class="form-control" onchange="contentData.citanka.items[${i}].text=this.value">${escHtml(item.text)}</textarea>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Pozadinska boja overlay-a</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color" class="form-control form-control-color" value="${item.bg_color || '#229C8C'}" onchange="contentData.citanka.items[${i}].bg_color=this.value;this.nextElementSibling.value=this.value" style="width:50px;height:40px;">
                            <input type="text" class="form-control" value="${escHtml(item.bg_color || '#229C8C')}" onchange="contentData.citanka.items[${i}].bg_color=this.value;this.previousElementSibling.value=this.value" style="width:100px;">
                        </div>
                        <div class="mt-1" style="width:100%;height:30px;border-radius:4px;background:${item.bg_color || '#229C8C'};opacity:0.85;"></div>
                    </div>
                </div>
            </div>`;
        });
    }

    function addItem() {
        if (!contentData.citanka) contentData.citanka = { items: [] };
        if (!contentData.citanka.items) contentData.citanka.items = [];
        contentData.citanka.items.push({ title: '', text: '', link: '', image: 'images/gallery/1.jpg', bg_color: '#229C8C', active: true });
        renderItems();
    }

    function toggleItem(i) {
        contentData.citanka.items[i].active = !contentData.citanka.items[i].active;
        renderItems();
    }

    function removeItem(i) {
        if (!confirm('Obrisati tekst?')) return;
        contentData.citanka.items.splice(i, 1);
        renderItems();
    }

    function uploadCitImg(i, input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/uploads/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.citanka.items[i].image = data.path;
                    document.getElementById('cit-img-' + i).value = data.path;
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
        contentData.citanka.page_title = document.getElementById('page-title').value;
        contentData.citanka.subtitle = document.getElementById('page-subtitle').value;
        contentData.citanka.upcoming_text = document.getElementById('upcoming-text').value;
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
