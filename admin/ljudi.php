<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ljudi - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
    <style>
        .member-grid { display: grid; grid-template-columns: 120px 1fr; gap: 16px; align-items: start; }
        .member-photo-preview { width: 120px; height: 150px; border-radius: 8px; background: var(--darkest); overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .member-photo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .member-photo-preview .no-photo { color: #555; font-size: 11px; text-align: center; padding: 8px; }
        @media (max-width: 640px) {
            .member-grid { grid-template-columns: 80px 1fr; }
            .member-photo-preview { width: 80px; height: 100px; }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-people-fill"></i> Ljudi</h5>
            <div>
                <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="bi bi-check-lg"></i> Sačuvaj sve</button>
                <a href="../tim.php" target="_blank" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-eye"></i> Pogledaj stranicu</a>
            </div>
        </div>

        <div class="card-section">
            <h5><i class="bi bi-person-badge"></i> Članovi tima</h5>
            <p class="text-muted">Prvi aktivan član se prikazuje kao "featured" velikoj kartici na vrhu strane <code>tim.php</code>. Ostali aktivni idu u parove (2 po redu). Neaktivni se ne prikazuju nigdje (ali ostaju snimljeni). Strelice ▲▼ mijenjaju redoslijed.</p>
            <div id="ljudi-list"></div>
            <button class="btn-add mt-2" onclick="addMember()"><i class="bi bi-plus-lg"></i> Dodaj člana</button>
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
        .then(data => { contentData = data; if (!contentData.team) contentData.team = []; renderMembers(); showToast('Podaci učitani', 'success'); })
        .catch(err => showToast('Greška: ' + err.message, 'danger'));

    function renderMembers() {
        const c = document.getElementById('ljudi-list');
        c.innerHTML = '';
        const team = contentData.team || [];
        team.forEach((m, i) => {
            const photoSrc = m.image ? '../' + m.image.replace(/^\//, '') : '';
            const photoHtml = photoSrc
                ? `<img id="prev-${i}" src="${escAttr(photoSrc)}" alt="${escAttr(m.name||'')}" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><div class="no-photo" style="display:none">Slika nije dostupna</div>`
                : `<div class="no-photo">Nema slike</div>`;
            const status = m.active !== false ? 'AKTIVAN' : 'NEAKTIVAN';
            const statusClass = m.active !== false ? 'btn-success' : 'btn-secondary';
            const positionLabel = (i === 0 && m.active !== false) ? '<span class="badge bg-warning text-dark ms-2">Featured (velika kartica)</span>' : '';
            c.innerHTML += `
            <div class="item-card">
                <div class="item-header">
                    <h6>#${i+1} — ${escHtml(m.name) || 'Bez imena'} ${positionLabel}</h6>
                    <div class="d-flex gap-1 flex-wrap">
                        <button class="btn btn-sm btn-outline-light" onclick="moveMember(${i},-1)" ${i===0?'disabled':''} title="Pomjeri gore"><i class="bi bi-arrow-up"></i></button>
                        <button class="btn btn-sm btn-outline-light" onclick="moveMember(${i},1)" ${i===team.length-1?'disabled':''} title="Pomjeri dole"><i class="bi bi-arrow-down"></i></button>
                        <button class="btn btn-sm ${statusClass}" onclick="toggleMember(${i})">${status}</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeMember(${i})"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="member-grid">
                    <div class="member-photo-preview">${photoHtml}</div>
                    <div class="row" style="margin:0;">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Ime i prezime</label>
                            <input type="text" class="form-control" value="${escAttr(m.name)}" onchange="contentData.team[${i}].name=this.value;renderMembers()">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Pozicija / titula (opciono, npr. "specijalista psihijatrije")</label>
                            <input type="text" class="form-control" value="${escAttr(m.role_title || '')}" onchange="contentData.team[${i}].role_title=this.value">
                        </div>
                        <div class="col-md-8 mb-2">
                            <label class="form-label">Slika člana</label>
                            <input type="text" class="form-control" id="ljudi-img-${i}" value="${escAttr(m.image)}" onchange="contentData.team[${i}].image=this.value;renderMembers()" placeholder="images/team/ime.jpg">
                            <input type="file" class="form-control mt-1" accept="image/*" onchange="uploadMemberImg(${i},this)">
                            <small class="text-muted">Preporuka: portret 600x750px ili veći. Cropuje se automatski na 4:5.</small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Alt text (SEO/pristupačnost)</label>
                            <input type="text" class="form-control" value="${escAttr(m.image_alt || '')}" onchange="contentData.team[${i}].image_alt=this.value" placeholder="Dr X - specijalnost">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Opis / biografija</label>
                            <textarea class="form-control" rows="4" onchange="contentData.team[${i}].description=this.value">${escHtml(m.description)}</textarea>
                        </div>
                    </div>
                </div>
            </div>`;
        });
    }

    function addMember() {
        contentData.team = contentData.team || [];
        contentData.team.push({ name: '', image: '', description: '', image_alt: '', role_title: '', active: true });
        renderMembers();
    }

    function moveMember(i, dir) {
        const j = i + dir;
        const t = contentData.team;
        if (j < 0 || j >= t.length) return;
        [t[i], t[j]] = [t[j], t[i]];
        renderMembers();
    }

    function toggleMember(i) {
        contentData.team[i].active = contentData.team[i].active === false;
        renderMembers();
    }

    function removeMember(i) {
        if (!confirm('Obrisati člana?')) return;
        contentData.team.splice(i, 1);
        renderMembers();
    }

    function uploadMemberImg(i, input) {
        if (!input.files[0]) return;
        const formData = new FormData();
        formData.append('action', 'upload_image');
        formData.append('target_dir', 'images/team/');
        formData.append('image', input.files[0]);
        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'ok') {
                    contentData.team[i].image = data.path;
                    document.getElementById('ljudi-img-' + i).value = data.path;
                    renderMembers();
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
        const formData = new FormData();
        formData.append('action', 'save_section');
        formData.append('section', 'team');
        formData.append('data', JSON.stringify(contentData.team));
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
