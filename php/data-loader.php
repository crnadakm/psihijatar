<?php
/**
 * Data Loader - reads JSON data files for the frontend
 */

function loadContentData() {
    static $data = null;
    if ($data === null) {
        $file = __DIR__ . '/../data/content.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true) ?: [];
        } else {
            $data = [];
        }
    }
    return $data;
}

function loadSeoData() {
    static $data = null;
    if ($data === null) {
        $file = __DIR__ . '/../data/seo.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true) ?: [];
        } else {
            $data = [];
        }
    }
    return $data;
}

/**
 * Get SEO data for a specific page
 */
function getPageSeo($pageFile = null) {
    if ($pageFile === null) {
        $pageFile = basename($_SERVER['SCRIPT_NAME']);
    }
    $seo = loadSeoData();
    $page = $seo['pages'][$pageFile] ?? [];
    $global = $seo['global'] ?? [];
    return [
        'title' => $page['title'] ?? $global['site_name'] ?? '',
        'meta_description' => $page['meta_description'] ?? '',
        'meta_keywords' => $page['meta_keywords'] ?? '',
        'og_title' => $page['og_title'] ?? $page['title'] ?? '',
        'og_description' => $page['og_description'] ?? $page['meta_description'] ?? '',
        'og_image' => (!empty($page['og_image']) ? $page['og_image'] : ''),
        'og_image_default' => $global['default_og_image'] ?? '',
        'og_type' => $page['og_type'] ?? 'website',
        'robots' => $page['robots'] ?? 'index, follow',
        'canonical' => $page['canonical'] ?? '',
        'site_name' => $global['site_name'] ?? '',
        'base_url' => $global['base_url'] ?? '',
    ];
}

/**
 * Output SEO meta tags for current page
 */
function renderSeoHead($pageFile = null) {
    global $articleOgOverride;
    $seo = getPageSeo($pageFile);
    $global = loadSeoData()['global'] ?? [];
    $baseUrl = $global['base_url'] ?? '';

    // Apply article overrides as fallback (article data fills in blanks)
    if (!empty($articleOgOverride)) {
        if (empty($seo['title']) && !empty($articleOgOverride['title'])) {
            $seo['title'] = $articleOgOverride['title'];
        }
        if (empty($seo['og_title']) && !empty($articleOgOverride['title'])) {
            $seo['og_title'] = $articleOgOverride['title'];
        }
        if (empty($seo['og_description']) && !empty($articleOgOverride['description'])) {
            $seo['og_description'] = $articleOgOverride['description'];
        }
        if (empty($seo['meta_description']) && !empty($articleOgOverride['description'])) {
            $seo['meta_description'] = $articleOgOverride['description'];
        }
        if (empty($seo['og_image']) && !empty($articleOgOverride['image'])) {
            $seo['og_image'] = $articleOgOverride['image'];
        }
    }

    // If still no og_image, use global default
    if (empty($seo['og_image']) && !empty($seo['og_image_default'])) {
        $seo['og_image'] = $seo['og_image_default'];
    }

    $html = '';

    if ($seo['title']) {
        $html .= "\t<title>" . htmlspecialchars($seo['title']) . "</title>\n";
    }
    if ($seo['meta_description']) {
        $html .= "\t<meta name=\"description\" content=\"" . htmlspecialchars($seo['meta_description']) . "\">\n";
    }
    if ($seo['meta_keywords']) {
        $html .= "\t<meta name=\"keywords\" content=\"" . htmlspecialchars($seo['meta_keywords']) . "\">\n";
    }
    if ($seo['robots'] && $seo['robots'] !== 'index, follow') {
        $html .= "\t<meta name=\"robots\" content=\"" . htmlspecialchars($seo['robots']) . "\">\n";
    }
    if ($seo['canonical']) {
        $html .= "\t<link rel=\"canonical\" href=\"" . htmlspecialchars($seo['canonical']) . "\">\n";
    }

    // Open Graph
    if ($seo['og_title']) {
        $html .= "\t<meta property=\"og:title\" content=\"" . htmlspecialchars($seo['og_title']) . "\">\n";
    }
    if ($seo['og_description']) {
        $html .= "\t<meta property=\"og:description\" content=\"" . htmlspecialchars($seo['og_description']) . "\">\n";
    }
    if ($seo['og_image']) {
        $html .= "\t<meta property=\"og:image\" content=\"" . htmlspecialchars($seo['og_image']) . "\">\n";
    }
    $html .= "\t<meta property=\"og:type\" content=\"" . htmlspecialchars($seo['og_type'] ?: 'article') . "\">\n";
    // og:url
    if ($baseUrl) {
        $html .= "\t<meta property=\"og:url\" content=\"" . htmlspecialchars($baseUrl . '/' . basename($_SERVER['SCRIPT_NAME'])) . "\">\n";
    }
    if ($seo['site_name']) {
        $html .= "\t<meta property=\"og:site_name\" content=\"" . htmlspecialchars($seo['site_name']) . "\">\n";
    }

    // Schema.org JSON-LD (only on index)
    $pageFile = $pageFile ?: basename($_SERVER['SCRIPT_NAME']);
    if ($pageFile === 'index.php' && !empty($global['schema_org'])) {
        $s = $global['schema_org'];
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $s['type'] ?? 'MedicalBusiness',
            'name' => $s['name'] ?? '',
            'description' => $s['description'] ?? '',
            'url' => $s['url'] ?? '',
            'telephone' => $s['telephone'] ?? '',
        ];
        if (!empty($s['address'])) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $s['address']['street'] ?? '',
                'addressLocality' => $s['address']['city'] ?? '',
                'postalCode' => $s['address']['postal'] ?? '',
                'addressCountry' => $s['address']['country'] ?? '',
            ];
        }
        if (!empty($s['geo']['latitude']) && !empty($s['geo']['longitude'])) {
            $schema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $s['geo']['latitude'],
                'longitude' => $s['geo']['longitude'],
            ];
        }
        if (!empty($s['opening_hours'])) $schema['openingHours'] = $s['opening_hours'];
        if (!empty($s['price_range'])) $schema['priceRange'] = $s['price_range'];

        $html .= "\t<script type=\"application/ld+json\">" . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "</script>\n";
    }

    return $html;
}

/**
 * Get content section
 */
function getContent($section = null) {
    $data = loadContentData();
    if ($section) {
        return $data[$section] ?? [];
    }
    return $data;
}
