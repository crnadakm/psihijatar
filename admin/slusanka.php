<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slušanka - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-headphones"></i> Slušanka</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../slusanka.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-audio">Audio elementi</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="sec-audio">
                <div class="card-section">
                    <h5><i class="bi bi-music-note-list"></i> Audio elementi</h5>
                    <p class="text-muted">Ako nema audio elemenata, prikazuje se placeholder slika (work.jpg)</p>
                    <div id="audio-items"></div>
                    <button class="btn-add mt-2" onclick="addAudio()"><i class="bi bi-plus-lg"></i> Dodaj audio</button>
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
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Opis</label>
                            <input type="text" class="form-control" id="page-desc">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Placeholder slika (kad nema audio)</label>
                            <input type="text" class="form-control" id="placeholder-img">
                            <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadPlaceholder(this)">
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
        const s = contentData.slusanka || {};
        document.getElementById('page-title').value = s.page_title || '';
        document.getElementById('page-subtitle').value = s.subtitle || '';
        document.getElementById('page-desc').value = s.description || '';
        document.getElementById('placeholder-img').value = s.placeholder_image || 'images/work.jpg';
        renderAudio();
    }

    function renderAudio() {
        const c = document.getElementById('audio-items');
        c.innerHTML = '';
        const items = contentData.slusanka?.items || [];
        if (items.length === 0) {
            c.innerHTML = '<div class="text-center p-4 text-muted"><i class="bi bi-music-note-beamed" style="font-size:48px;"></i><p class="mt-2">Nema audio elemenata. Dodajte prvi audio klikom na dugme ispod.</p></div>';
            return;
        }
        items.forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6><i class="bi bi-music-note"></i> ${escHtml(item.title) || 'Audio ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleAudio(${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeAudio(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.slusanka.items[${i}].title=this.value">
                    </div>
                    <div class="col-md-7 mb-2">
                        <label class="form-label">Audio URL (MP3 fajl ili link)</label>
                        <input type="text" class="form-control" value="${escHtml(item.audio_url)}" onchange="contentData.slusanka.items[${i}].audio_url=this.value">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Opis</label>
                        <textarea class="form-control" onchange="contentData.slusanka.items[${i}].description=this.value">${escHtml(item.description)}</textarea>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Slika/Cover (URL ili upload)</label>
                        <input type="text" class="form-control" id="sl-cover-${i}" value="${escHtml(item.cover_image)}" onchange="contentData.slusanka.items[${i}].cover_image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadSlImg(${i},this)">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Alt text slike (SEO)</label>
                        <input type="text" class="form-control" value="${escHtml(item.cover_image_alt || '')}" onchange="contentData.slusanka.items[${i}].cover_image_alt=this.value" placeholder="Opis slike za pretraživače">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Kratki promo tekst</label>
                        <input type="text" class="form-control" value="${escHtml(item.promo_text || '')}" onchange="contentData.slusanka.items[${i}].promo_text=this.value" placeholder="Kratki promotivni tekst za ovaj audio">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Trajanje</label>
                        <input type="text" class="form-control" value="${escHtml(item.duration)}" onchange="contentData.slusanka.items[${i}].duration=this.value" placeholder="npr. 15:30">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Datum objave</label>
                        <input type="date" class="form-control" value="${escHtml(item.date)}" onchange="contentData.slusanka.items[${i}].date=this.value">
                    </div>
                </div>
            </div>`;
        });
    }

    function addAudio() {
        if (!contentData.slusanka) contentData.slusanka = { items: [] };
        if (!contentData.slusanka.items) contentData.slusanka.items = [];
        contentData.slusanka.items.push({ title: '', audio_url: '', description: '', cover_image: '', duration: '', date: '', active: true });
        renderAudio();
    }

    function toggleAudio(i) {
        contentData.slusanka.items[i].active = !contentData.slusanka.items[i].active;
        renderAudio();
    }

    function removeAudio(i) {
        if (!confirm('Obrisati audio?')) return;
        contentData.slusanka.items.splice(i, 1);
        renderAudio();
    }

    function uploadSlImg(i, input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/uploads/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.slusanka.items[i].cover_image = data.path;
                    document.getElementById('sl-cover-' + i).value = data.path;
                    showToast('Cover uploadovan', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function uploadPlaceholder(input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('placeholder-img').value = data.path;
                    showToast('Slika uploadovana', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function saveAll() {
        contentData.slusanka.page_title = document.getElementById('page-title').value;
        contentData.slusanka.subtitle = document.getElementById('page-subtitle').value;
        contentData.slusanka.description = document.getElementById('page-desc').value;
        contentData.slusanka.placeholder_image = document.getElementById('placeholder-img').value;
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'slusanka');
        formData.append('data', JSON.stringify(contentData.slusanka));
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
