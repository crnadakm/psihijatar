<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Članci - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Članci</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card-section" style="max-height:80vh;overflow-y:auto;">
                    <h6><i class="bi bi-list"></i> Izaberi članak</h6>
                    <div id="article-list"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="article-editor" style="display:none;">
                    <div class="card-section mb-3">
                        <h5 id="editor-title"><i class="bi bi-pencil"></i> Uređivanje članka</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Naslov stranice</label>
                                <input type="text" class="form-control" id="art-page-title">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">CSS klasa headera</label>
                                <input type="text" class="form-control" id="art-head-class">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Naslov sidebara</label>
                                <input type="text" class="form-control" id="art-sidebar-title" placeholder="npr. Naslovi">
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <a id="art-preview-link" href="#" target="_blank" class="btn btn-sm btn-outline-light"><i class="bi bi-eye"></i> Pogledaj</a>
                        </div>
                    </div>

                    <div class="card-section">
                        <h6><i class="bi bi-card-text"></i> Sekcije teksta</h6>
                        <p class="text-muted small">Svaka sekcija ima ID (za anchor link), naslov i tekst. Prva sekcija može biti uvod (bez naslova, ID=intro).</p>
                        <div id="sections-list"></div>
                        <button class="btn-add mt-2" onclick="addSection()"><i class="bi bi-plus-lg"></i> Dodaj sekciju</button>
                    </div>

                    <div class="text-end mt-3 mb-5">
                        <button class="btn btn-primary btn-lg" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve promjene</button>
                    </div>
                </div>
                <div id="no-article" class="card-section text-center text-muted p-5">
                    <i class="bi bi-file-earmark-text" style="font-size:64px;"></i>
                    <p class="mt-3">Izaberite članak sa lijeve strane za uređivanje</p>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container">
        <div id="toast" class="toast" role="alert"><div class="toast-body" id="toast-body"></div></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let contentData = {};
    let currentArticle = null;

    fetch('api.php?action=load_content', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => { contentData = data; renderArticleList(); showToast('Podaci učitani', 'success'); })
        .catch(err => showToast('Greška: ' + err.message, 'danger'));

    function renderArticleList() {
        const c = document.getElementById('article-list');
        c.innerHTML = '';
        const articles = contentData.articles || {};
        for (const [key, art] of Object.entries(articles)) {
            const isActive = currentArticle === key;
            c.innerHTML += `
            <div class="p-2 mb-1 rounded" style="cursor:pointer;background:${isActive ? 'var(--primary)' : 'var(--darkest)'}" onclick="selectArticle('${key}')">
                <strong style="color:${isActive ? '#fff' : '#ccc'};font-size:13px;">${escHtml(art.page_title)}</strong>
                <br><small class="text-muted">${key}.php</small>
            </div>`;
        }
    }

    function selectArticle(key) {
        currentArticle = key;
        const art = contentData.articles[key];
        document.getElementById('no-article').style.display = 'none';
        document.getElementById('article-editor').style.display = 'block';
        document.getElementById('editor-title').innerHTML = '<i class="bi bi-pencil"></i> ' + escHtml(art.page_title);
        document.getElementById('art-page-title').value = art.page_title || '';
        document.getElementById('art-head-class').value = art.page_head_class || '';
        document.getElementById('art-sidebar-title').value = art.sidebar_title || '';
        document.getElementById('art-preview-link').href = '../' + key + '.php';
        renderSections();
        renderArticleList();
    }

    function renderSections() {
        const c = document.getElementById('sections-list');
        c.innerHTML = '';
        const sections = contentData.articles[currentArticle].sections || [];
        sections.forEach((sec, i) => {
            const isIntro = sec.id === 'intro' && !sec.title;
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>${isIntro ? '<i class="bi bi-type"></i> Uvod' : '<i class="bi bi-hash"></i> ' + escHtml(sec.title)}</h6>
                    <div>
                        <button class="btn btn-sm btn-outline-light" onclick="moveSection(${i},-1)" ${i===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveSection(${i},1)" ${i===sections.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeSection(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">ID (anchor)</label>
                        <input type="text" class="form-control" value="${escHtml(sec.id)}" onchange="contentData.articles['${currentArticle}'].sections[${i}].id=this.value" placeholder="npr. par1">
                    </div>
                    <div class="col-md-9 mb-2">
                        <label class="form-label">Naslov sekcije</label>
                        <input type="text" class="form-control" value="${escHtml(sec.title)}" onchange="contentData.articles['${currentArticle}'].sections[${i}].title=this.value" placeholder="Ostavi prazno za uvod">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tekst</label>
                        <textarea class="form-control" rows="8" style="font-size:13px;" onchange="contentData.articles['${currentArticle}'].sections[${i}].content=this.value">${escHtml(sec.content)}</textarea>
                        <small class="text-muted">Koristite ● za listu stavki. Svaki red = novi paragraf.</small>
                    </div>
                </div>
            </div>`;
        });
    }

    function addSection() {
        if (!currentArticle) return;
        const sections = contentData.articles[currentArticle].sections;
        const newId = 'par' + (sections.length + 1);
        sections.push({ id: newId, title: '', content: '' });
        renderSections();
    }

    function removeSection(i) {
        if (!confirm('Obrisati sekciju?')) return;
        contentData.articles[currentArticle].sections.splice(i, 1);
        renderSections();
    }

    function moveSection(i, dir) {
        const sections = contentData.articles[currentArticle].sections;
        const j = i + dir;
        if (j < 0 || j >= sections.length) return;
        [sections[i], sections[j]] = [sections[j], sections[i]];
        renderSections();
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function saveAll() {
        if (currentArticle) {
            contentData.articles[currentArticle].page_title = document.getElementById('art-page-title').value;
            contentData.articles[currentArticle].page_head_class = document.getElementById('art-head-class').value;
            contentData.articles[currentArticle].sidebar_title = document.getElementById('art-sidebar-title').value;
        }
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
