<?php
session_start();

define('ADMIN_USER', 'dragi_tesanov1c');
define('ADMIN_PASS_HASH', '$2y$10$YourHashHere'); // Change this after first login

// Default password: dobar2024 - CHANGE THIS!
define('ADMIN_PASS_DEFAULT', '$2y$10$wNjgqfUdJjh54mPD2oVpVOax6AzdKkAsS8v/8XkjGmwwfn0l2vrYu');

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}

function checkLogin($username, $password) {
    if ($username !== ADMIN_USER) return false;

    $passFile = __DIR__ . '/../data/admin_pass.json';
    if (file_exists($passFile)) {
        $data = json_decode(file_get_contents($passFile), true);
        $hash = $data['hash'] ?? '';
    } else {
        $hash = ADMIN_PASS_DEFAULT;
    }

    return password_verify($password, $hash);
}

function changePassword($newPassword) {
    $passFile = __DIR__ . '/../data/admin_pass.json';
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    file_put_contents($passFile, json_encode(['hash' => $hash]));
    return true;
}
