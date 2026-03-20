<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar d-none d-md-block">
    <div class="brand">
        <h4>DOBAR</h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column mt-3">
        <a class="nav-link <?= $currentPage === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php"><i class="bi bi-house"></i> Početna</a>
        <a class="nav-link <?= $currentPage === 'content.php' ? 'active' : '' ?>" href="content.php"><i class="bi bi-pencil-square"></i> Sadržaj</a>
        <a class="nav-link <?= $currentPage === 'ideja.php' ? 'active' : '' ?>" href="ideja.php"><i class="bi bi-lightbulb"></i> Ideja</a>
        <a class="nav-link <?= $currentPage === 'znanja.php' ? 'active' : '' ?>" href="znanja.php"><i class="bi bi-book"></i> Znanja</a>
        <a class="nav-link <?= $currentPage === 'citanka.php' ? 'active' : '' ?>" href="citanka.php"><i class="bi bi-journal-text"></i> Čitanka</a>
        <a class="nav-link <?= $currentPage === 'slusanka.php' ? 'active' : '' ?>" href="slusanka.php"><i class="bi bi-headphones"></i> Slušanka</a>
        <a class="nav-link <?= $currentPage === 'knjige.php' ? 'active' : '' ?>" href="knjige.php"><i class="bi bi-journal-bookmark"></i> Knjige</a>
        <a class="nav-link <?= $currentPage === 'seo.php' ? 'active' : '' ?>" href="seo.php"><i class="bi bi-search"></i> SEO Expert</a>
        <a class="nav-link <?= $currentPage === 'settings.php' ? 'active' : '' ?>" href="settings.php"><i class="bi bi-gear"></i> Postavke</a>
    </nav>
    <div class="mt-auto p-3" style="position:absolute;bottom:0;width:100%;">
        <a href="logout.php" class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-box-arrow-left"></i> Odjava</a>
    </div>
</div>
