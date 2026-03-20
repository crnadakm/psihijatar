<?php
require_once 'auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (checkLogin($user, $pass)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Pogrešno korisničko ime ili lozinka.';
    }
}

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - DOBAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #16213e; border-radius: 16px; padding: 40px; max-width: 400px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .login-card h2 { color: #229C8C; text-align: center; margin-bottom: 30px; letter-spacing: 8px; font-weight: 700; }
        .form-control { background: #0f3460; border: 1px solid #1a1a4e; color: #fff; padding: 12px 16px; }
        .form-control:focus { background: #0f3460; color: #fff; border-color: #229C8C; box-shadow: 0 0 0 0.2rem rgba(34,156,140,.25); }
        .btn-login { background: #229C8C; border: none; padding: 12px; font-weight: 600; letter-spacing: 2px; width: 100%; }
        .btn-login:hover { background: #1a7a6e; }
        .alert { font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>DOBAR</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Korisničko ime" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Lozinka" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login">PRIJAVA</button>
        </form>
    </div>
</body>
</html>
