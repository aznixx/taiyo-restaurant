<?php
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Logout | Taiyo Admin</title>
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
    }

    .logout-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 2.5rem 2rem;
      text-align: center;
      width: min(380px, 100%);
    }

    .logout-title {
      font: 700 1.1rem/1 'Montserrat', sans-serif;
      color: var(--text-primary);
      margin: 0 0 0.75rem;
    }

    .logout-msg {
      font: 400 0.9rem/1.6 'Open Sans', sans-serif;
      color: var(--text-muted);
      margin: 0 0 1.5rem;
    }
  </style>
</head>

<body>


  <div class="logout-card">
    <h1 class="logout-title">You have been logged out</h1>
    <p class="logout-msg">Thank you for using the Taiyo admin panel.</p>
    <a href="login.php" class="btn btn-primary">Back to Login</a>
  </div>

</body>

</html>