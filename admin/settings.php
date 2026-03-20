<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postavke - Admin DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-gear"></i> Postavke</h5>
            <a href="logout.php" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-left"></i> Odjava</a>
        </div>

        <div class="card-section" style="max-width:500px;">
            <h5><i class="bi bi-lock"></i> Promjena lozinke</h5>
            <div class="mb-3">
                <label class="form-label">Nova lozinka</label>
                <input type="password" class="form-control" id="new-pass">
            </div>
            <div class="mb-3">
                <label class="form-label">Potvrdi lozinku</label>
                <input type="password" class="form-control" id="confirm-pass">
            </div>
            <button class="btn btn-primary" onclick="changePass()"><i class="bi bi-check-lg"></i> Promijeni lozinku</button>
            <div id="pass-msg" class="mt-3"></div>
        </div>

        <div class="card-section" style="max-width:500px;">
            <h5><i class="bi bi-info-circle"></i> Informacije</h5>
            <p><strong>Korisničko ime:</strong> admin</p>
            <p><strong>Podrazumjevana lozinka:</strong> dobar2024</p>
            <p class="text-warning"><small><i class="bi bi-exclamation-triangle"></i> Promijenite podrazumjevanu lozinku nakon prvog logina!</small></p>
        </div>

        <div class="card-section" style="max-width:500px;">
            <h5><i class="bi bi-shield-lock"></i> Zaštita data foldera</h5>
            <p class="text-muted">Preporučuje se zaštititi <code>/data/</code> folder od direktnog pristupa. Dodajte <code>.htaccess</code> fajl:</p>
            <pre style="background:var(--darkest);padding:10px;border-radius:8px;color:#2ecc71;">Deny from all</pre>
            <button class="btn btn-sm btn-outline-warning" onclick="protectData()"><i class="bi bi-shield-check"></i> Kreiraj .htaccess zaštitu</button>
            <div id="htaccess-msg" class="mt-2"></div>
        </div>
    </div>

    <script>
    function changePass() {
        const newPass = document.getElementById('new-pass').value;
        const confirmPass = document.getElementById('confirm-pass').value;
        const formData = new FormData();
        formData.append('action', 'change_password');
        formData.append('new_password', newPass);
        formData.append('confirm_password', confirmPass);

        fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                const cls = data.status === 'ok' ? 'text-success' : 'text-danger';
                document.getElementById('pass-msg').innerHTML = '<span class="' + cls + '">' + data.message + '</span>';
                if (data.status === 'ok') {
                    document.getElementById('new-pass').value = '';
                    document.getElementById('confirm-pass').value = '';
                }
            });
    }

    function protectData() {
        fetch('api.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'action=protect_data' })
            .then(r => r.json())
            .then(data => {
                document.getElementById('htaccess-msg').innerHTML = '<small class="text-success">Zaštita kreirana!</small>';
            })
            .catch(() => {
                document.getElementById('htaccess-msg').innerHTML = '<small class="text-warning">Ručno kreirajte .htaccess u /data/ folderu</small>';
            });
    }
    </script>
</body>
</html>
