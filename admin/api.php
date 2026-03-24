<?php
require_once 'auth.php';
requireLogin();

header('Content-Type: application/json');

$dataDir = __DIR__ . '/../data/';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'load_content':
        echo file_get_contents($dataDir . 'content.json');
        break;

    case 'save_content':
        $data = $_POST['data'] ?? '';
        $json = json_decode($data, true);
        if ($json === null) {
            echo json_encode(['status' => 'error', 'message' => 'Neispravan JSON format']);
            break;
        }
        // Backup
        $backup = $dataDir . 'content_backup_' . date('Y-m-d_H-i-s') . '.json';
        copy($dataDir . 'content.json', $backup);
        file_put_contents($dataDir . 'content.json', json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['status' => 'ok', 'message' => 'Sadržaj sačuvan']);
        break;

    case 'save_section':
        $section = $_POST['section'] ?? '';
        $data = $_POST['data'] ?? '';
        $sectionData = json_decode($data, true);
        if (empty($section) || $sectionData === null) {
            echo json_encode(['status' => 'error', 'message' => 'Sekcija i podaci su obavezni']);
            break;
        }
        $content = json_decode(file_get_contents($dataDir . 'content.json'), true);
        $backup = $dataDir . 'content_backup_' . date('Y-m-d_H-i-s') . '.json';
        copy($dataDir . 'content.json', $backup);
        // Support saving multiple sections at once (e.g. site, cta, footer)
        $sections = explode(',', $section);
        if (count($sections) > 1) {
            foreach ($sections as $s) {
                $s = trim($s);
                if (isset($sectionData[$s])) {
                    $content[$s] = $sectionData[$s];
                }
            }
        } else {
            $content[$section] = $sectionData;
        }
        file_put_contents($dataDir . 'content.json', json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['status' => 'ok', 'message' => 'Sadržaj sačuvan']);
        break;

    case 'load_seo':
        echo file_get_contents($dataDir . 'seo.json');
        break;

    case 'save_seo':
        $data = $_POST['data'] ?? '';
        $json = json_decode($data, true);
        if ($json === null) {
            echo json_encode(['status' => 'error', 'message' => 'Neispravan JSON format']);
            break;
        }
        $backup = $dataDir . 'seo_backup_' . date('Y-m-d_H-i-s') . '.json';
        copy($dataDir . 'seo.json', $backup);
        file_put_contents($dataDir . 'seo.json', json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['status' => 'ok', 'message' => 'SEO podaci sačuvani']);
        break;

    case 'generate_sitemap':
        $seo = json_decode(file_get_contents($dataDir . 'seo.json'), true);
        $baseUrl = $seo['global']['base_url'] ?? 'https://dobar.psihijatar.info';
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($seo['pages'] as $page => $data) {
            $robots = $data['robots'] ?? 'index, follow';
            if (strpos($robots, 'noindex') !== false) continue;
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/{$page}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $priority = ($page === 'index.php') ? '1.0' : '0.8';
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';
        file_put_contents(__DIR__ . '/../sitemap.xml', $xml);
        echo json_encode(['status' => 'ok', 'message' => 'Sitemap generisan', 'pages' => count($seo['pages'])]);
        break;

    case 'save_robots':
        $content = $_POST['content'] ?? '';
        file_put_contents(__DIR__ . '/../robots.txt', $content);
        echo json_encode(['status' => 'ok', 'message' => 'robots.txt sačuvan']);
        break;

    case 'change_password':
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';
        if (strlen($newPass) < 6) {
            echo json_encode(['status' => 'error', 'message' => 'Lozinka mora imati najmanje 6 karaktera']);
            break;
        }
        if ($newPass !== $confirmPass) {
            echo json_encode(['status' => 'error', 'message' => 'Lozinke se ne poklapaju']);
            break;
        }
        changePassword($newPass);
        echo json_encode(['status' => 'ok', 'message' => 'Lozinka promijenjena']);
        break;

    case 'cleanup_backups':
        $files = glob($dataDir . '*_backup_*.json');
        // Keep last 5 backups of each type
        $contentBackups = array_filter($files, fn($f) => strpos($f, 'content_backup') !== false);
        $seoBackups = array_filter($files, fn($f) => strpos($f, 'seo_backup') !== false);
        rsort($contentBackups);
        rsort($seoBackups);
        $deleted = 0;
        foreach (array_slice($contentBackups, 5) as $f) { unlink($f); $deleted++; }
        foreach (array_slice($seoBackups, 5) as $f) { unlink($f); $deleted++; }
        echo json_encode(['status' => 'ok', 'message' => "Obrisano {$deleted} starih backup-a"]);
        break;

    case 'upload_og_image':
        $uploadDir = __DIR__ . '/../images/og/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        if (!isset($_FILES['og_image']) || $_FILES['og_image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'error', 'message' => 'Greška pri uploadu fajla']);
            break;
        }
        $file = $_FILES['og_image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Dozvoljeni formati: ' . implode(', ', $allowed)]);
            break;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Maksimalna veličina: 5MB']);
            break;
        }
        $filename = 'og_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $destPath = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            $seo = json_decode(file_get_contents($dataDir . 'seo.json'), true);
            $baseUrl = $seo['global']['base_url'] ?? 'https://dobar.psihijatar.info';
            $imageUrl = $baseUrl . '/images/og/' . $filename;
            echo json_encode(['status' => 'ok', 'message' => 'Slika uploadovana', 'url' => $imageUrl, 'path' => 'images/og/' . $filename]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Greška pri čuvanju fajla na server']);
        }
        break;

    case 'upload_image':
        $targetDir = $_POST['target_dir'] ?? 'images/uploads/';
        $uploadDir = __DIR__ . '/../' . $targetDir;
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'error', 'message' => 'Greška pri uploadu fajla']);
            break;
        }
        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Dozvoljeni formati: ' . implode(', ', $allowed)]);
            break;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Maksimalna veličina: 5MB']);
            break;
        }
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $destPath = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            echo json_encode(['status' => 'ok', 'message' => 'Slika uploadovana', 'path' => $targetDir . $filename]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Greška pri čuvanju fajla']);
        }
        break;

    case 'create_article':
        $key = $_POST['key'] ?? '';
        $title = $_POST['title'] ?? '';
        $key = preg_replace('/[^a-z0-9]/', '', strtolower($key));
        if (empty($key) || empty($title)) {
            echo json_encode(['status' => 'error', 'message' => 'Ključ i naslov su obavezni']);
            break;
        }
        $phpFile = __DIR__ . '/../' . $key . '.php';
        if (file_exists($phpFile)) {
            echo json_encode(['status' => 'error', 'message' => 'Fajl ' . $key . '.php već postoji']);
            break;
        }
        // Create PHP file
        $phpContent = "<?php \$articleKey = '" . $key . "'; include 'elements/article-template.php'; ?>";
        file_put_contents($phpFile, $phpContent);
        // Add to content.json
        $content = json_decode(file_get_contents($dataDir . 'content.json'), true);
        $backup = $dataDir . 'content_backup_' . date('Y-m-d_H-i-s') . '.json';
        copy($dataDir . 'content.json', $backup);
        $content['articles'][$key] = [
            'page_title' => $title,
            'page_head_class' => 'page-head-health',
            'sidebar_title' => 'Naslovi',
            'sections' => [
                ['id' => 'intro', 'title' => '', 'content' => '']
            ]
        ];
        file_put_contents($dataDir . 'content.json', json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        // Add to seo.json
        $seoFile = $dataDir . 'seo.json';
        if (file_exists($seoFile)) {
            $seo = json_decode(file_get_contents($seoFile), true);
            if (!isset($seo['pages'][$key . '.php'])) {
                $seo['pages'][$key . '.php'] = [
                    'title' => $title,
                    'meta_description' => '',
                    'meta_keywords' => '',
                    'og_title' => $title,
                    'og_description' => '',
                    'og_image' => '',
                    'og_image_alt' => '',
                    'og_type' => 'article',
                    'robots' => 'index, follow',
                    'canonical' => '',
                    'h1' => ''
                ];
                file_put_contents($seoFile, json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }
        echo json_encode(['status' => 'ok', 'message' => 'Članak kreiran: ' . $key . '.php', 'key' => $key]);
        break;

    case 'delete_article':
        $key = $_POST['key'] ?? '';
        $key = preg_replace('/[^a-z0-9]/', '', strtolower($key));
        if (empty($key)) {
            echo json_encode(['status' => 'error', 'message' => 'Ključ je obavezan']);
            break;
        }
        // Remove from content.json
        $content = json_decode(file_get_contents($dataDir . 'content.json'), true);
        if (!isset($content['articles'][$key])) {
            echo json_encode(['status' => 'error', 'message' => 'Članak ne postoji u bazi']);
            break;
        }
        $backup = $dataDir . 'content_backup_' . date('Y-m-d_H-i-s') . '.json';
        copy($dataDir . 'content.json', $backup);
        unset($content['articles'][$key]);
        file_put_contents($dataDir . 'content.json', json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        // Delete PHP file
        $phpFile = __DIR__ . '/../' . $key . '.php';
        $fileDeleted = false;
        if (file_exists($phpFile)) {
            $fileDeleted = unlink($phpFile);
        }
        // Remove from seo.json
        $seoFile = $dataDir . 'seo.json';
        if (file_exists($seoFile)) {
            $seo = json_decode(file_get_contents($seoFile), true);
            if (isset($seo['pages'][$key . '.php'])) {
                unset($seo['pages'][$key . '.php']);
                file_put_contents($seoFile, json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }
        echo json_encode(['status' => 'ok', 'message' => 'Članak obrisan: ' . $key . '.php', 'file_deleted' => $fileDeleted]);
        break;

    case 'list_articles':
        $content = json_decode(file_get_contents($dataDir . 'content.json'), true);
        $articles = [];
        foreach (($content['articles'] ?? []) as $key => $art) {
            $articles[] = ['key' => $key, 'title' => $art['page_title'] ?? $key, 'file' => $key . '.php'];
        }
        echo json_encode($articles);
        break;

    case 'protect_data':
        file_put_contents($dataDir . '.htaccess', "Deny from all\n");
        echo json_encode(['status' => 'ok', 'message' => '.htaccess kreiran']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Nepoznata akcija']);
}
