<?php
require_once __DIR__ . '/../config/db.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $error = 'Please enter both username and password.';
  } else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
      $_SESSION['user_id'] = $admin['id'];
      $_SESSION['username'] = $admin['username'];
      header('Location: dashboard.php');
      exit;
    } else {
      $error = 'Invalid username or password.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Taiyo Admin</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: var(--bg-body);
    }

    .login-wrap {
      width: min(420px, 100%);
      padding: 1.25rem;
    }

    .login-logo {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-logo-name {
      font: 800 2rem/1 'Montserrat', sans-serif;
      letter-spacing: 4px;
      color: var(--gold);
    }

    .login-logo-sub {
      font: 400 0.78rem/1 'Open Sans', sans-serif;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-top: 0.4rem;
    }

    .login-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 2rem;
    }

    .login-title {
      margin: 0 0 1.5rem;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.85rem;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--gold);
      padding-bottom: 0.75rem;
      border-bottom: 1px solid var(--border);
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 1.1rem;
    }

    .login-form .form-field {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .login-submit {
      width: 100%;
      height: 46px;
      margin-top: 0.5rem;
    }

    .login-error {
      background: rgba(229, 86, 86, 0.08);
      border: 1px solid rgba(229, 86, 86, 0.3);
      border-radius: 4px;
      padding: 0.75rem 1rem;
      color: var(--danger);
      font: 400 0.88rem/1.4 'Open Sans', sans-serif;
      display: none;
    }

    .login-error:not(:empty) {
      display: block;
    }

    .register-footer {
      text-align: center;
      margin-top: 1.25rem;
      font-size: 0.85rem;
      color: var(--text-muted);
    }

    .register-footer a {
      color: var(--gold);
      text-decoration: none;
      font-weight: 600;
    }

    .register-footer a:hover {
      color: var(--gold-hover);
    }
  </style>
</head>

<body>
  <div class="login-wrap">
    <div class="login-logo">
      <div class="login-logo-name">TAIYO</div>
      <div class="login-logo-sub">Admin Panel</div>
    </div>

    <div class="login-card">
      <h1 class="login-title">Sign in</h1>

      <form class="login-form" action="login.php" method="POST">
        <div class="login-error"><?= htmlspecialchars($error) ?></div>

        <div class="form-field">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" autocomplete="username" placeholder="Enter your username"
            required />
        </div>

        <div class="form-field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" autocomplete="current-password"
            placeholder="Enter your password" required />
        </div>

        <button type="submit" class="btn btn-primary login-submit">Sign In</button>
      </form>
    </div>

    <div class="register-footer">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </div>
</body>

</html>
