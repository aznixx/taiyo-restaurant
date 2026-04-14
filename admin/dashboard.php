<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}


require __DIR__ . "/../config/db.php";

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$itemCount = $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$unreadCount = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetchColumn();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Taiyo Admin</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="admin.css" />
</head>

<body>
  <app-sidebar></app-sidebar>

  <div class="main-content">
    <header class="topbar">
      <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12" />
          <line x1="3" y1="6" x2="21" y2="6" />
          <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>
      <span class="topbar-title">Dashboard</span>
      <div class="topbar-right">

        <span class="topbar-user">Welcome back
          <?= htmlspecialchars($_SESSION['username']); ?>
        </span>
      </div>
    </header>

    <main class="page-body">
      <div class="page-header">
        <div>
          <h1 class="page-title">DASHBOARD</h1>
          <p class="page-subtitle">Overview of your restaurant</p>
        </div>
      </div>

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-card-value" id="statItems"><?= $itemCount ?></div>
          <div class="stat-card-label">Menu Items</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-value" id="statCategories"><?= $categoryCount ?></div>
          <div class="stat-card-label">Categories</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-value" id="statMessages"><?= $messageCount ?></div>
          <div class="stat-card-label">Messages</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-value" id="statUnread"><?= $unreadCount ?></div>
          <div class="stat-card-label">Unread Messages</div>
        </div>
      </div>


      <div class="card">
        <h2 class="card-title">Recent Messages</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="recentMessages">

              <?php foreach ($messages as $msg): ?>
                <tr>
                  <td><?php echo htmlspecialchars($msg['full_name']); ?></td>
                  <td><?php echo htmlspecialchars($msg['email']); ?></td>
                  <td><?php echo htmlspecialchars($msg['message']); ?></td>
                  <td><?php echo $msg['created_at']; ?></td>
                  <td><span
                      class="badge <?php echo $msg['is_read'] ? 'badge-green' : 'badge-gold'; ?>"><?php echo $msg['is_read'] ? 'Read' : 'Unread'; ?></span>
                  </td>
                  <td><a href="messages.php?id=<?php echo $msg['id']; ?>" class="btn btn-sm">View</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>

  <div id="toastHost"></div>
  <script src="sidebar.js"></script>
  <script src="common.js"></script>
</body>

</html>