<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

require_once 'backend/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username']  = $user['username'];
                setcookie('admin_session', session_id(), time() + (86400 * 7), '/');
                header('Location: admin.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (\PDOException $e) {
            $error = 'A database error occurred. Please try again.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Portfolio</title>
    <meta name="description" content="Admin login page for portfolio management.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-page{min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg-primary);padding:2rem}
        .login-card{background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(20px);border-radius:1.5rem;padding:3rem;width:100%;max-width:420px;box-shadow:0 25px 50px rgba(0,0,0,0.4)}
        .login-card .logo{text-align:center;margin-bottom:2rem}
        .login-card .logo span{font-size:2.5rem}
        .login-card h1{text-align:center;font-size:1.75rem;font-weight:700;color:var(--text-primary);margin-bottom:.5rem}
        .login-card p{text-align:center;color:var(--text-muted);margin-bottom:2rem}
        .error-alert{background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.4);color:#fca5a5;padding:.875rem 1rem;border-radius:.75rem;margin-bottom:1.5rem;font-size:.9rem;text-align:center}
        .back-link{display:block;text-align:center;margin-top:1.5rem;color:var(--accent);text-decoration:none;font-size:.9rem;transition:opacity .2s}
        .back-link:hover{opacity:.7}
    </style>
</head>
<body class="login-page">
    <div class="login-card">
        <div class="logo"><span>🔐</span></div>
        <h1>Admin Login</h1>
        <p>Enter your credentials to manage your portfolio.</p>
        <?php if (!empty($error)): ?>
            <div class="error-alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php" id="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-input" placeholder="admin" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;margin-top:.5rem;">
                Login to Dashboard
            </button>
        </form>
        <a href="index.php" class="back-link">← Back to Portfolio</a>
    </div>
</body>
</html>
