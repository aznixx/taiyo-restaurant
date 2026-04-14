<?php
require_once __DIR__ . '/../config/db.php';

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

        if ($admin) {
            $error = 'Username already exists.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register — TAIYO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --gold: #d4a853;
            --gold-hover: #e6bd6a;
            --gold-glow: rgba(212, 168, 83, 0.15);
            --bg-body: #0e0e10;
            --bg-card: #161618;
            --bg-input: #1a1a1e;
            --text-primary: #f5f0e8;
            --text-secondary: #a8a29e;
            --text-muted: #78716c;
            --border: #2a2825;
            --danger: #e55656;
            --transition: 300ms ease;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--bg-body);
            color: var(--text-primary);
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-wrap {
            width: 100%;
            max-width: 380px;
            padding: 1rem;
        }

        .register-brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-brand-name {
            font: 800 2rem/1 'Montserrat', sans-serif;
            letter-spacing: 4px;
            color: var(--gold);
        }

        .register-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 2rem;
        }

        .register-title {
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

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1.25rem;
        }

        label {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--gold);
        }

        input {
            height: 44px;
            padding: 0 1rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            background: var(--bg-input);
            color: var(--text-primary);
            font-family: 'Open Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
            width: 100%;
        }

        input::placeholder {
            color: var(--text-muted);
        }

        input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .error {
            background: rgba(229, 86, 86, 0.08);
            border: 1px solid rgba(229, 86, 86, 0.3);
            border-radius: 4px;
            padding: 0.75rem 1rem;
            color: var(--danger);
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 44px;
            border-radius: 4px;
            border: 1.5px solid var(--gold);
            cursor: pointer;
            background: var(--gold);
            color: var(--bg-body);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: all var(--transition);
            margin-top: 0.5rem;
        }

        .btn:hover {
            background: var(--gold-hover);
            border-color: var(--gold-hover);
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

        .login-logo-sub {
            font: 400 0.78rem/1 'Open Sans', sans-serif;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 0.4rem;
        }
    </style>
</head>

<body>
    <div class="register-wrap">
        <div class="register-brand">
            <span class="register-brand-name">TAIYO</span>
            <div class="login-logo-sub">Admin Panel</div>
        </div>

        <div class="register-card">
            <p class="register-title">Create Account</p>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="form-field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
        </div>

        <div class="register-footer">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>