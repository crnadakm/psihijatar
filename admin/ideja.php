<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ideja - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-lightbulb"></i> Ideja</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../ideja.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-timeline">Timeline stavke</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-gallery">Galerija</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke stranice</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="sec-timeline">
                <div class="card-section">
                    <h5><i class="bi bi-clock-history"></i> Timeline stavke</h5>
                    <p class="text-muted">Stavke se prikazuju naizmjenično lijevo-desno (cik-cak)</p>
                    <div id="timeline-items"></div>
                    <button class="btn-add mt-2" onclick="addTimelineItem()"><i class="bi bi-plus-lg"></i> Dodaj stavku</button>
                </div>
            </div>

            <div class="tab-pane fade" id="sec-gallery">
                <div class="card-section">
                    <h5><i class="bi bi-images"></i> Galerija ordinacije</h5>
                    <div id="gallery-items"></div>
                    <button class="btn-add mt-2" onclick="addGalleryItem()"><i class="bi bi-plus-lg"></i> Dodaj sliku</button>
                </div>
            </div>

            <div class="tab-pane fade" id="sec-settings">
                <div class="card-section">
                    <h5><i class="bi bi-gear"></i> Postavke stranice</h5>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Naslov stranice</label>
                        <input type="text" class="form-control" id="page-title">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3 mb-5">
            <button class="btn btn-primary btn-lg" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve promjene</button>
        </div>
    </div>

    <div class="toast-container">
        <div id="toast" class="toast" role="alert">
            <div class="toast-body" id="toast-body"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let contentData = {};

    fetch('api.php?action=load_content', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            contentData = data;
            populateForm();
            showToast('Podaci učitani', 'success');
        })
        .catch(err => showToast('Greška: ' + err.message, 'danger'));

    function populateForm() {
        document.getElementById('page-title').value = contentData.ideja?.page_title || '';
        renderTimeline();
        renderGallery();
    }

    function renderTimeline() {
        const c = document.getElementById('timeline-items');
        c.innerHTML = '';
        (contentData.ideja?.items || []).forEach((item, i) => {
            const pos = i % 2 === 0 ? 'Lijevo' : 'Desno';
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${escHtml(item.title) || 'Stavka ' + (i+1)} <span class="badge bg-info">${pos}</span></h6>
                    <div>
                        <button class="btn btn-sm ${item.active ? 'btn-success' : 'btn-secondary'}" onclick="toggleActive('ideja','items',${i})">${item.active ? 'Aktivan' : 'Neaktivan'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('items',${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Naslov (prikazuje se u krugu)</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.ideja.items[${i}].title=this.value">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tekst</label>
                        <textarea class="form-control" style="min-height:120px" onchange="contentData.ideja.items[${i}].text=this.value">${escHtml(item.text)}</textarea>
                    </div>
                </div>
            </div>`;
        });
    }

    function addTimelineItem() {
        if (!contentData.ideja) contentData.ideja = { items: [], gallery: [] };
        if (!contentData.ideja.items) contentData.ideja.items = [];
        contentData.ideja.items.push({ title: '', text: '', active: true });
        renderTimeline();
    }

    function renderGallery() {
        const c = document.getElementById('gallery-items');
        c.innerHTML = '';
        (contentData.ideja?.gallery || []).forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>Slika ${i + 1}</h6>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeGallery(${i})"><i class="bi bi-trash"></i></button>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-2 mb-2">
                        ${item.thumb ? '<img src="../' + escHtml(item.thumb) + '" style="width:80px;height:60px;object-fit:cover;border-radius:6px;" onerror="this.style.display=\'none\'">' : ''}
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Puna slika</label>
                        <input type="text" class="form-control" id="ideja-gimg-${i}" value="${escHtml(item.image)}" onchange="contentData.ideja.gallery[${i}].image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalleryImg(${i},'image',this)">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Thumbnail</label>
                        <input type="text" class="form-control" id="ideja-gthumb-${i}" value="${escHtml(item.thumb)}" onchange="contentData.ideja.gallery[${i}].thumb=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalleryImg(${i},'thumb',this)">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Naslov / Alt</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.ideja.gallery[${i}].title=this.value" placeholder="Koristi se i kao alt text">
                    </div>
                </div>
            </div>`;
        });
    }

    function addGalleryItem() {
        if (!contentData.ideja) contentData.ideja = { items: [], gallery: [] };
        if (!contentData.ideja.gallery) contentData.ideja.gallery = [];
        contentData.ideja.gallery.push({ image: '', thumb: '', title: '' });
        renderGallery();
    }

    function removeGallery(i) {
        if (!confirm('Obrisati sliku?')) return;
        contentData.ideja.gallery.splice(i, 1);
        renderGallery();
    }

    function toggleActive(section, key, i) {
        contentData[section][key][i].active = !contentData[section][key][i].active;
        renderTimeline();
    }

    function removeItem(key, i) {
        if (!confirm('Obrisati stavku?')) return;
        contentData.ideja[key].splice(i, 1);
        renderTimeline();
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
                    contentData.ideja.gallery[i][field] = data.path;
                    document.getElementById('ideja-g' + field + '-' + i).value = data.path;
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
        contentData.ideja.page_title = document.getElementById('page-title').value;
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'ideja');
        formData.append('data', JSON.stringify(contentData.ideja));
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => showToast(data.message, data.status === 'ok' ? 'success' : 'danger'))
            .catch(() => showToast('Greška pri čuvanju', 'danger'));
    }

    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        const body = document.getElementById('toast-body');
        toast.className = 'toast show bg-' + type + ' text-white';
        body.textContent = msg;
        setTimeout(() => toast.classList.remove('show'), 3000);
    }
    </script>
</body>
</html>
