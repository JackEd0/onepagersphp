<?php
session_start();
$config = require __DIR__ . '/../config.php';

if (isset($_POST['password'])) {
    if ($_POST['password'] === $config['admin_password']) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin/dashboard.php');
        exit;
    } else {
        $error = 'Invalid password.';
    }
}

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: admin/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sakura Sushi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { max-width: 400px; width: 100%; padding: 40px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); background: white; }
        .btn-primary-custom { background-color: #ff7f7f; border-color: #ff7f7f; color: white; padding: 12px 30px; border-radius: 50px; transition: all 0.3s ease; width: 100%; }
        .btn-primary-custom:hover { background-color: #ff6b6b; border-color: #ff6b6b; }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="text-center mb-4 fw-bold">Sakura Sushi Admin</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary-custom">Login</button>
        </form>
    </div>
</body>
</html>
