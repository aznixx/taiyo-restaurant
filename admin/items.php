<?php

session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

require __DIR__ . "/../config/db.php";

$stmt = $pdo->query("SELECT * FROM menu_items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Menu Items | Taiyo Admin</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="admin.css" />
</head>

<body>

  <app-sidebar></app-sidebar>

  <!-- Main -->
  <div class="main-content">
    <header class="topbar">
      <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12" />
          <line x1="3" y1="6" x2="21" y2="6" />
          <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>
      <span class="topbar-title">Menu Items</span>
    </header>

    <main class="page-body">
      <div class="page-header">
        <div>
          <h1 class="page-title">MENU ITEMS</h1>
          <p class="page-subtitle">Manage all dishes on your menu</p>
        </div>
        <a href="add-item.php" class="btn btn-primary">+ Add New Item</a>
      </div>

      <div class="card">
        <h2 class="card-title">All Items</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- PHP: loop over all menu items from DB -->
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <?php echo htmlspecialchars($item['name']); ?>
                  </td>
                  <td><span class="badge badge-gold"><?php echo htmlspecialchars($item['category_id']); ?></span></td>
                  <td>€<?php echo number_format($item['price'], 2); ?></td>
                  <td><?php echo htmlspecialchars(substr($item['description'], 0, 60)) . '...'; ?></td>
                  <td>
                    <div class="action-group">
                      <a href="edit-item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm">Edit</a>
                      <form method="POST" action="delete-item.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger btn-delete">Delete</button>
                      </form>
                    </div>
                  </td>
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