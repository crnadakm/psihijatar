<?php
// One-time script to set admin password. DELETE THIS FILE AFTER USE.
$password = 'dO6b1R-l00d1k';
$hash = password_hash($password, PASSWORD_DEFAULT);
$passFile = __DIR__ . '/../data/admin_pass.json';
file_put_contents($passFile, json_encode(['hash' => $hash]));
echo 'Password set. Hash: ' . $hash . '<br>';
echo '<strong>DELETE THIS FILE NOW (admin/set_password.php)</strong>';
