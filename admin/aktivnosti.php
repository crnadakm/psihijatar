<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivnosti - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
    <style>
        .category-box { background: var(--darkest); padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid var(--primary); }
        .item-card.sub { background: rgba(255,255,255,0.04); margin-left: 10px; }
        .move-buttons { display: inline-flex; gap: 4px; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Aktivnosti</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../aktivnosti.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj</a>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sec-cats">Kategorije usluga</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-upcoming">U pripremi</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-gallery">Galerija</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#sec-settings">Postavke</a></li>
        </ul>

        <div class="tab-content">
            <!-- CATEGORIES + ITEMS -->
            <div class="tab-pane fade show active" id="sec-cats">
                <div class="card-section">
                    <h5><i class="bi bi-folder2-open"></i> Kategorije i stavke usluga</h5>
                    <p class="text-muted">Svaka kategorija ima naslov, opcioni podnaslov i listu stavki (svaka stavka je akordeon na sajtu sa naslovom + opisom).</p>
                    <div id="cat-list"></div>
                    <button class="btn-add mt-2" onclick="addCategory()"><i class="bi bi-plus-lg"></i> Dodaj kategoriju</button>
                </div>
            </div>

            <!-- UPCOMING -->
            <div class="tab-pane fade" id="sec-upcoming">
                <div class="card-section">
                    <h5><i class="bi bi-hourglass-split"></i> U pripremi</h5>
                    <p class="text-muted">Usluge koje su najavljene ali još nisu pokrenute. Renderuju se ispod glavnih usluga sa naslovom "U pripremi:".</p>
                    <div id="upcoming-list"></div>
                    <button class="btn-add mt-2" onclick="addUpcomingCategory()"><i class="bi bi-plus-lg"></i> Dodaj kategoriju u pripremi</button>
                </div>
            </div>

            <!-- GALLERY -->
            <div class="tab-pane fade" id="sec-gallery">
                <div class="card-section">
                    <h5><i class="bi bi-images"></i> Galerija na dnu stranice</h5>
                    <p class="text-muted">Slike sa lightbox efektom. Thumb = mala verzija (200-500px), Image = puna slika.</p>
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
                            <label class="form-label">Naslov stranice (h1 u hero-u)</label>
                            <input type="text" class="form-control" id="page-title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naslov iznad kategorija</label>
                            <input type="text" class="form-control" id="intro-title" placeholder="npr. Dostupne usluge:">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naslov sekcije "U pripremi"</label>
                            <input type="text" class="form-control" id="upcoming-title" placeholder="npr. U pripremi:">
                        </div>
                    </div>
                </div>

                <div class="card-section mt-3">
                    <h5><i class="bi bi-image"></i> Hero slika (gornji banner)</h5>
                    <p class="text-muted">Iste opcije kao kod članaka. Možeš izabrati postojeću CSS pozadinu ILI uploadovati svoju sliku (custom override). Preporuka za upload: 1920x600px ili veći.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CSS klasa pozadine (default ako nije uploadovana custom slika)</label>
                            <select class="form-select" id="page-head-class">
                                <option value="page-head-news">News (default — shutterstock_1501617461)</option>
                                <option value="page-head-health">Health (zdravstvo)</option>
                                <option value="page-head-psihijatrija">Psihijatrija</option>
                                <option value="page-head-o-psiho">O psihoterapiji</option>
                                <option value="page-head-konst">Konstelacije</option>
                                <option value="page-head-emdr">EMDR</option>
                                <option value="page-head-grupna">Grupna terapija</option>
                                <option value="page-head-depr">Depresija</option>
                                <option value="page-head-stres">Stres</option>
                                <option value="page-head-burn">Burnout</option>
                                <option value="page-head-bol">Bol</option>
                                <option value="page-head-veze">Veze</option>
                                <option value="page-head-ppl">Ljudi (tim)</option>
                                <option value="page-head-know">Znanja</option>
                                <option value="page-head-books">Knjige</option>
                                <option value="page-head-contact">Kontakt</option>
                                <option value="page-head-four">Voda / 4</option>
                                <option value="page-head-asert">Asertivna prava (srce)</option>
                                <option value="page-head-anksiolitik">Anksiolitik</option>
                                <option value="page-head-dementofobija">Dementofobija</option>
                                <option value="page-head-simptom">Simptom</option>
                                <option value="page-head-kbt">KBT</option>
                                <option value="page-head-plavi-sat">Plavi sat</option>
                                <option value="page-head-norm">Normalan</option>
                                <option value="page-head-debljina">Debljina</option>
                                <option value="page-head-ciklusi">Ciklusi</option>
                                <option value="page-head-partnerskaterapija">Partnerska terapija</option>
                                <option value="page-head-neuroloskipregled">Neurološki pregled</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alt tekst hero slike (SEO/pristupačnost)</label>
                            <input type="text" class="form-control" id="head-image-alt" placeholder="npr. Aktivnosti i usluge ZU DOBAR Banja Luka">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Custom hero slika (override — koristi se ako je uploadovana)</label>
                            <div class="d-flex gap-2 align-items-start">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control mb-2" id="head-image" placeholder="images/uploads/... ili uploadujte ispod">
                                    <input type="file" class="form-control" accept="image/*" onchange="uploadHeadImg(this)">
                                </div>
                                <div id="head-image-preview" style="width:200px;height:80px;background:var(--darkest);border-radius:6px;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                    <small class="text-muted">Preview</small>
                                </div>
                            </div>
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
        if (!contentData.aktivnosti) {
            contentData.aktivnosti = { page_title: 'Aktivnosti', intro_title: 'Dostupne usluge:', upcoming_title: 'U pripremi:', categories: [], upcoming_categories: [], gallery: [] };
        }
        const a = contentData.aktivnosti;
        if (!a.categories) a.categories = [];
        if (!a.upcoming_categories) a.upcoming_categories = [];
        if (!a.gallery) a.gallery = [];

        document.getElementById('page-title').value = a.page_title || 'Aktivnosti';
        document.getElementById('intro-title').value = a.intro_title || '';
        document.getElementById('upcoming-title').value = a.upcoming_title || '';
        document.getElementById('page-head-class').value = a.page_head_class || 'page-head-news';
        document.getElementById('head-image').value = a.head_image || '';
        document.getElementById('head-image-alt').value = a.head_image_alt || '';
        updateHeadImagePreview(a.head_image || '');
        document.getElementById('head-image').addEventListener('input', function() { updateHeadImagePreview(this.value); });
        renderCategories();
        renderUpcoming();
        renderGallery();
    }

    function updateHeadImagePreview(url) {
        const box = document.getElementById('head-image-preview');
        if (url) {
            box.innerHTML = '<img src="../' + url.replace(/^\//, '') + '" alt="" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML=\'<small class=text-muted>Slika nije dostupna</small>\'">';
        } else {
            box.innerHTML = '<small class="text-muted">Bez slike — koristi se CSS klasa</small>';
        }
    }

    function uploadHeadImg(input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/headers/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.aktivnosti.head_image = data.path;
                    document.getElementById('head-image').value = data.path;
                    updateHeadImagePreview(data.path);
                    showToast('Hero slika uploadovana', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function slugify(s) {
        return (s || '').toLowerCase()
            .replace(/[čć]/g, 'c').replace(/š/g, 's').replace(/ž/g, 'z').replace(/đ/g, 'd')
            .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '').substring(0, 40);
    }

    function renderCategories() {
        const c = document.getElementById('cat-list');
        c.innerHTML = '';
        const cats = contentData.aktivnosti.categories;
        cats.forEach((cat, ci) => {
            let itemsHtml = '';
            (cat.items || []).forEach((it, ii) => {
                itemsHtml += `
                <div class="item-card sub">
                    <div class="item-header">
                        <h6>#${ii+1} — ${escHtml(it.title) || 'Stavka'}</h6>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-light" onclick="moveItem(${ci},${ii},-1)" ${ii===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                            <button class="btn btn-sm btn-outline-light" onclick="moveItem(${ci},${ii},1)" ${ii===cat.items.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                            <button class="btn btn-sm ${it.active !== false ? 'btn-success' : 'btn-secondary'}" onclick="toggleItem(${ci},${ii})">${it.active !== false ? 'Aktivna' : 'Neaktivna'}</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${ci},${ii})"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Naslov stavke</label>
                            <input type="text" class="form-control" value="${escAttr(it.title)}" onchange="contentData.aktivnosti.categories[${ci}].items[${ii}].title=this.value">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Opis (otvara se klikom na stavku)</label>
                            <textarea class="form-control" rows="4" onchange="contentData.aktivnosti.categories[${ci}].items[${ii}].description=this.value">${escHtml(it.description)}</textarea>
                        </div>
                    </div>
                </div>`;
            });
            c.innerHTML += `
            <div class="category-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="bi bi-folder"></i> Kategorija #${ci+1}: ${escHtml(cat.title) || 'Bez naslova'}</h5>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-light" onclick="moveCategory(${ci},-1)" ${ci===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveCategory(${ci},1)" ${ci===cats.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm ${cat.active !== false ? 'btn-success' : 'btn-secondary'}" onclick="toggleCategory(${ci})">${cat.active !== false ? 'Aktivna' : 'Neaktivna'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeCategory(${ci})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Naslov kategorije</label>
                        <input type="text" class="form-control" value="${escAttr(cat.title)}" onchange="contentData.aktivnosti.categories[${ci}].title=this.value;contentData.aktivnosti.categories[${ci}].id=slugify(this.value);renderCategories();">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Podnaslov / opis kategorije (opciono)</label>
                        <input type="text" class="form-control" value="${escAttr(cat.subtitle)}" onchange="contentData.aktivnosti.categories[${ci}].subtitle=this.value">
                    </div>
                </div>
                <div>
                    <strong style="font-size:13px;color:#999;">STAVKE:</strong>
                    ${itemsHtml}
                    <button class="btn-add mt-2" onclick="addItem(${ci})"><i class="bi bi-plus-lg"></i> Dodaj stavku u "${escHtml(cat.title)}"</button>
                </div>
            </div>`;
        });
    }

    function renderUpcoming() {
        const c = document.getElementById('upcoming-list');
        c.innerHTML = '';
        const ups = contentData.aktivnosti.upcoming_categories;
        ups.forEach((cat, ci) => {
            let itemsHtml = '';
            (cat.items || []).forEach((it, ii) => {
                itemsHtml += `
                <div class="item-card sub">
                    <div class="item-header">
                        <h6>${escHtml(it.title) || 'Stavka'}</h6>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeUpcomingItem(${ci},${ii})"><i class="bi bi-trash"></i></button>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Naslov</label>
                            <input type="text" class="form-control" value="${escAttr(it.title)}" onchange="contentData.aktivnosti.upcoming_categories[${ci}].items[${ii}].title=this.value">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Opis (opciono)</label>
                            <textarea class="form-control" rows="3" onchange="contentData.aktivnosti.upcoming_categories[${ci}].items[${ii}].description=this.value">${escHtml(it.description)}</textarea>
                        </div>
                    </div>
                </div>`;
            });
            c.innerHTML += `
            <div class="category-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">${escHtml(cat.title) || 'Bez naslova'}</h5>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeUpcomingCategory(${ci})"><i class="bi bi-trash"></i></button>
                </div>
                <div class="mb-3">
                    <label class="form-label">Naslov kategorije</label>
                    <input type="text" class="form-control" value="${escAttr(cat.title)}" onchange="contentData.aktivnosti.upcoming_categories[${ci}].title=this.value">
                </div>
                <div>
                    <strong style="font-size:13px;color:#999;">STAVKE:</strong>
                    ${itemsHtml}
                    <button class="btn-add mt-2" onclick="addUpcomingItem(${ci})"><i class="bi bi-plus-lg"></i> Dodaj stavku</button>
                </div>
            </div>`;
        });
    }

    function renderGallery() {
        const c = document.getElementById('gallery-items');
        c.innerHTML = '';
        contentData.aktivnosti.gallery.forEach((item, i) => {
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>Slika ${i + 1}</h6>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-light" onclick="moveGallery(${i},-1)" ${i===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveGallery(${i},1)" ${i===contentData.aktivnosti.gallery.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm ${item.active !== false ? 'btn-success' : 'btn-secondary'}" onclick="toggleGallery(${i})">${item.active !== false ? 'Aktivna' : 'Neaktivna'}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeGalleryItem(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-2">${item.thumb ? '<img src="../' + escAttr(item.thumb) + '" style="width:80px;height:60px;object-fit:cover;border-radius:6px;" onerror="this.style.display=\'none\'">' : ''}</div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Puna slika (URL)</label>
                        <input type="text" class="form-control" id="ak-gimg-${i}" value="${escAttr(item.image)}" onchange="contentData.aktivnosti.gallery[${i}].image=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalImg(${i},'image',this)">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Thumbnail (URL)</label>
                        <input type="text" class="form-control" id="ak-gthumb-${i}" value="${escAttr(item.thumb)}" onchange="contentData.aktivnosti.gallery[${i}].thumb=this.value">
                        <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadGalImg(${i},'thumb',this)">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Naslov / Alt tekst</label>
                        <input type="text" class="form-control" value="${escAttr(item.title)}" onchange="contentData.aktivnosti.gallery[${i}].title=this.value;contentData.aktivnosti.gallery[${i}].alt=this.value">
                    </div>
                </div>
            </div>`;
        });
    }

    // === CATEGORY ACTIONS ===
    function addCategory() {
        contentData.aktivnosti.categories.push({ id: 'nova-kategorija', title: 'Nova kategorija', subtitle: '', active: true, items: [] });
        renderCategories();
    }
    function moveCategory(i, dir) {
        const cats = contentData.aktivnosti.categories;
        const j = i + dir;
        if (j < 0 || j >= cats.length) return;
        [cats[i], cats[j]] = [cats[j], cats[i]];
        renderCategories();
    }
    function toggleCategory(i) {
        contentData.aktivnosti.categories[i].active = contentData.aktivnosti.categories[i].active === false;
        renderCategories();
    }
    function removeCategory(i) {
        if (!confirm('Obrisati cijelu kategoriju i sve njene stavke?')) return;
        contentData.aktivnosti.categories.splice(i, 1);
        renderCategories();
    }

    // === ITEM ACTIONS ===
    function addItem(ci) {
        contentData.aktivnosti.categories[ci].items.push({ title: 'Nova stavka', description: '', active: true });
        renderCategories();
    }
    function moveItem(ci, ii, dir) {
        const items = contentData.aktivnosti.categories[ci].items;
        const j = ii + dir;
        if (j < 0 || j >= items.length) return;
        [items[ii], items[j]] = [items[j], items[ii]];
        renderCategories();
    }
    function toggleItem(ci, ii) {
        const it = contentData.aktivnosti.categories[ci].items[ii];
        it.active = it.active === false;
        renderCategories();
    }
    function removeItem(ci, ii) {
        if (!confirm('Obrisati stavku?')) return;
        contentData.aktivnosti.categories[ci].items.splice(ii, 1);
        renderCategories();
    }

    // === UPCOMING ACTIONS ===
    function addUpcomingCategory() {
        contentData.aktivnosti.upcoming_categories.push({ title: 'Nova kategorija', active: true, items: [] });
        renderUpcoming();
    }
    function removeUpcomingCategory(i) {
        if (!confirm('Obrisati kategoriju?')) return;
        contentData.aktivnosti.upcoming_categories.splice(i, 1);
        renderUpcoming();
    }
    function addUpcomingItem(ci) {
        contentData.aktivnosti.upcoming_categories[ci].items.push({ title: '', description: '', active: true });
        renderUpcoming();
    }
    function removeUpcomingItem(ci, ii) {
        if (!confirm('Obrisati?')) return;
        contentData.aktivnosti.upcoming_categories[ci].items.splice(ii, 1);
        renderUpcoming();
    }

    // === GALLERY ACTIONS ===
    function addGallery() {
        contentData.aktivnosti.gallery.push({ image: '', thumb: '', title: '', alt: '', active: true });
        renderGallery();
    }
    function moveGallery(i, dir) {
        const g = contentData.aktivnosti.gallery;
        const j = i + dir;
        if (j < 0 || j >= g.length) return;
        [g[i], g[j]] = [g[j], g[i]];
        renderGallery();
    }
    function toggleGallery(i) {
        contentData.aktivnosti.gallery[i].active = contentData.aktivnosti.gallery[i].active === false;
        renderGallery();
    }
    function removeGalleryItem(i) {
        if (!confirm('Obrisati?')) return;
        contentData.aktivnosti.gallery.splice(i, 1);
        renderGallery();
    }
    function uploadGalImg(i, field, input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/gallery/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.aktivnosti.gallery[i][field] = data.path;
                    document.getElementById('ak-g' + field + '-' + i).value = data.path;
                    showToast('Slika uploadovana', 'success');
                } else { showToast(data.message, 'danger'); }
            })
            .catch(() => showToast('Greška pri uploadu', 'danger'));
    }

    function escHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    function escAttr(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/'/g,'&#39;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function saveAll() {
        contentData.aktivnosti.page_title = document.getElementById('page-title').value;
        contentData.aktivnosti.intro_title = document.getElementById('intro-title').value;
        contentData.aktivnosti.upcoming_title = document.getElementById('upcoming-title').value;
        contentData.aktivnosti.page_head_class = document.getElementById('page-head-class').value;
        contentData.aktivnosti.head_image = document.getElementById('head-image').value;
        contentData.aktivnosti.head_image_alt = document.getElementById('head-image-alt').value;
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'aktivnosti');
        formData.append('data', JSON.stringify(contentData.aktivnosti));
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
