<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjige - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-book"></i> Knjige</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../knjige.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-books">Knjige</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="sec-books">
                <div class="card-section">
                    <h5><i class="bi bi-journal-bookmark"></i> Lista knjiga</h5>
                    <p class="text-muted">Dodajte, uredite ili obrišite knjige. Svaka knjiga ima naslov, autora, sliku, opis i link za naručivanje.</p>
                    <div id="book-items"></div>
                    <button class="btn-add mt-2" onclick="addBook()"><i class="bi bi-plus-lg"></i> Dodaj knjigu</button>
                </div>
            </div>

            <div class="tab-pane fade" id="sec-settings">
                <div class="card-section">
                    <h5><i class="bi bi-gear"></i> Postavke stranice</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naslov stranice</label>
                            <input type="text" class="form-control" id="page-title">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Podnaslov / Opis</label>
                            <textarea class="form-control" id="page-subtitle" rows="2"></textarea>
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
        const k = contentData.knjige || {};
        document.getElementById('page-title').value = k.page_title || '';
        document.getElementById('page-subtitle').value = k.subtitle || '';
        renderBooks();
    }

    function renderBooks() {
        const c = document.getElementById('book-items');
        c.innerHTML = '';
        const items = contentData.knjige?.items || [];
        if (items.length === 0) {
            c.innerHTML = '<div class="text-center p-4 text-muted"><i class="bi bi-journal-x" style="font-size:48px;"></i><p class="mt-2">Nema knjiga. Dodajte prvu klikom na dugme ispod.</p></div>';
            return;
        }
        items.forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6><i class="bi bi-book"></i> ${escHtml(item.title) || 'Knjiga ' + (i+1)}</h6>
                    <div>
                        <button class="btn btn-sm btn-outline-light" onclick="moveBook(${i},-1)" ${i===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveBook(${i},1)" ${i===items.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm ${item.active !== false ? 'btn-success' : 'btn-secondary'}" onclick="toggleBook(${i})">${item.active !== false ? 'Aktivna' : 'Neaktivna'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeBook(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Naslov</label>
                        <input type="text" class="form-control" value="${escHtml(item.title)}" onchange="contentData.knjige.items[${i}].title=this.value">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Autor</label>
                        <input type="text" class="form-control" value="${escHtml(item.author)}" onchange="contentData.knjige.items[${i}].author=this.value">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Slika (URL ili upload)</label>
                        <input type="text" class="form-control" id="book-img-${i}" value="${escHtml(item.image)}" onchange="contentData.knjige.items[${i}].image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadBookCover(${i}, this)">
                        <small class="text-muted" id="upload-status-${i}"></small>
                    </div>
                    <div class="col-md-8 mb-2">
                        <label class="form-label">Opis</label>
                        <textarea class="form-control" rows="3" onchange="contentData.knjige.items[${i}].text=this.value">${escHtml(item.text)}</textarea>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Link za naručivanje</label>
                        <input type="text" class="form-control" value="${escHtml(item.link)}" onchange="contentData.knjige.items[${i}].link=this.value">
                        ${item.image ? '<img src="'+escHtml(item.image)+'" style="max-width:80px;max-height:100px;margin-top:8px;border-radius:4px;" onerror="this.style.display=\'none\'">' : ''}
                    </div>
                </div>
            </div>`;
        });
    }

    function addBook() {
        if (!contentData.knjige) contentData.knjige = { items: [] };
        if (!contentData.knjige.items) contentData.knjige.items = [];
        contentData.knjige.items.push({ title: '', author: '', image: '', text: '', link: '', active: true });
        renderBooks();
    }

    function toggleBook(i) {
        contentData.knjige.items[i].active = !(contentData.knjige.items[i].active !== false);
        renderBooks();
    }

    function removeBook(i) {
        if (!confirm('Obrisati knjigu "' + (contentData.knjige.items[i].title || '') + '"?')) return;
        contentData.knjige.items.splice(i, 1);
        renderBooks();
    }

    function moveBook(i, dir) {
        const items = contentData.knjige.items;
        const j = i + dir;
        if (j < 0 || j >= items.length) return;
        [items[i], items[j]] = [items[j], items[i]];
        renderBooks();
    }

    function uploadBookCover(i, input) {
        if (!input.files[0]) return;
        const status = document.getElementById('upload-status-' + i);
        status.textContent = 'Uploadujem...';
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/bookcover/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.knjige.items[i].image = data.path;
                    document.getElementById('book-img-' + i).value = data.path;
                    status.textContent = 'Uploadovano!';
                    showToast('Cover uploadovan', 'success');
                } else {
                    status.textContent = data.message;
                    showToast(data.message, 'danger');
                }
            })
            .catch(() => { status.textContent = 'Greška'; });
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function saveAll() {
        contentData.knjige.page_title = document.getElementById('page-title').value;
        contentData.knjige.subtitle = document.getElementById('page-subtitle').value;
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'knjige');
        formData.append('data', JSON.stringify(contentData.knjige));
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
