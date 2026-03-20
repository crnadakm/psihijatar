<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h5 class="mb-0"><i class="bi bi-house"></i> Početna</h5>
            <div>
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light"><i class="bi bi-eye"></i> Pogledaj sajt</a>
                <a href="logout.php" class="btn btn-sm btn-outline-danger ms-2"><i class="bi bi-box-arrow-left"></i> Odjava</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="icon" style="background:rgba(34,156,140,0.15);color:var(--primary);"><i class="bi bi-file-text"></i></div>
                    <h3 id="stat-pages">0</h3>
                    <p>Stranica</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="icon" style="background:rgba(52,152,219,0.15);color:#3498db;"><i class="bi bi-people"></i></div>
                    <h3 id="stat-team">0</h3>
                    <p>Članova tima</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="icon" style="background:rgba(155,89,182,0.15);color:#9b59b6;"><i class="bi bi-chat-quote"></i></div>
                    <h3 id="stat-testimonials">0</h3>
                    <p>Iskustava</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="icon" style="background:rgba(230,126,34,0.15);color:#e67e22;"><i class="bi bi-search"></i></div>
                    <h3 id="stat-seo">0</h3>
                    <p>SEO stranica</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h6 class="text-muted mb-3">BRZE AKCIJE</h6>
        <div class="row mb-4">
            <div class="col-md-3 col-6 mb-3">
                <a href="content.php#slider" class="quick-action">
                    <i class="bi bi-images"></i>
                    <span>Uredi Slider</span>
                </a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <a href="content.php#team" class="quick-action">
                    <i class="bi bi-people"></i>
                    <span>Uredi Tim</span>
                </a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <a href="seo.php" class="quick-action">
                    <i class="bi bi-search"></i>
                    <span>SEO Podešavanje</span>
                </a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <a href="seo.php#sitemap" class="quick-action">
                    <i class="bi bi-diagram-3"></i>
                    <span>Generiši Sitemap</span>
                </a>
            </div>
        </div>

        <!-- Info -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <h6><i class="bi bi-info-circle text-info"></i> Info o panelu</h6>
                    <hr style="border-color:rgba(255,255,255,0.1);">
                    <p><strong>Sadržaj panel</strong> - mijenjaj tekstove, slike, tim, kontakt podatke</p>
                    <p><strong>SEO Expert panel</strong> - meta tagovi, Open Graph, Schema.org, robots.txt, sitemap</p>
                    <p class="text-muted mt-2"><small>Podaci se čuvaju u JSON fajlovima. Svaka izmjena pravi automatski backup.</small></p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <h6><i class="bi bi-clock-history text-warning"></i> Backup</h6>
                    <hr style="border-color:rgba(255,255,255,0.1);">
                    <p class="text-muted">Svaki put kad sačuvate promjene, prethodni podaci se automatski backup-uju.</p>
                    <button class="btn btn-sm btn-outline-warning mt-2" onclick="cleanupBackups()"><i class="bi bi-trash"></i> Obriši stare backup-e</button>
                    <div id="backup-msg" class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Load stats
    fetch('api.php?action=load_content')
        .then(r => r.json())
        .then(data => {
            document.getElementById('stat-team').textContent = data.team ? data.team.filter(t => t.active).length : 0;
            document.getElementById('stat-testimonials').textContent = data.testimonials ? data.testimonials.length : 0;
        });
    fetch('api.php?action=load_seo')
        .then(r => r.json())
        .then(data => {
            const pages = data.pages ? Object.keys(data.pages).length : 0;
            document.getElementById('stat-pages').textContent = pages;
            document.getElementById('stat-seo').textContent = pages;
        });

    function cleanupBackups() {
        fetch('api.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'action=cleanup_backups' })
            .then(r => r.json())
            .then(data => {
                document.getElementById('backup-msg').innerHTML = '<small class="text-success">' + data.message + '</small>';
            });
    }
    </script>
</body>
</html>
