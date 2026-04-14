<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

require __DIR__ . '/../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? '';
  $name = trim($_POST['name'] ?? '');
  $price = trim($_POST['price'] ?? '');
  $category_id = trim($_POST['category_id'] ?? '');
  $description = trim($_POST['description'] ?? '');

  if ($id === '' || $name === '' || $price === '' || $category_id === '') {
    $error = 'Please fill in all required fields.';
  } else {
    $stmt = $pdo->prepare("UPDATE menu_items SET name = ?, price = ?, category_id = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $price, $category_id, $description, $id]);

    header('Location: items.php');
    exit;
  }
}

$id = $_GET['id'] ?? null;

if (!$id) {
  header('Location: items.php');
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
  header('Location: items.php');
  exit;
}

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);




?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Item | Taiyo Admin</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="admin.css" />
</head>

<body>
  
  <aside class="sidebar" id="sidebar">
    <a href="dashboard.php" class="sidebar-brand">
      <span class="sidebar-brand-name">TAIYO</span>
    </a>
    <span class="sidebar-label">Main</span>
    <nav class="sidebar-nav">
      <a href="dashboard.php" class="sidebar-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7" />
          <rect x="14" y="3" width="7" height="7" />
          <rect x="3" y="14" width="7" height="7" />
          <rect x="14" y="14" width="7" height="7" />
        </svg>
        Dashboard
      </a>
      <a href="items.php" class="sidebar-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
          <rect x="9" y="3" width="6" height="4" rx="1" />
        </svg>
        Menu Items
      </a>
      <a href="categories.php" class="sidebar-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
        Categories
      </a>
      <a href="messages.php" class="sidebar-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
        Messages
      </a>
    </nav>
    <div class="sidebar-footer">
      <a href="logout.php" class="sidebar-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          <polyline points="16 17 21 12 16 7" />
          <line x1="21" y1="12" x2="9" y2="12" />
        </svg>
        Logout
      </a>
    </div>
  </aside>

  
  <div class="main-content">
    <header class="topbar">
      <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12" />
          <line x1="3" y1="6" x2="21" y2="6" />
          <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>
      <span class="topbar-title">Edit Menu Item</span>
      <div class="topbar-right">
        <a href="items.php" class="btn btn-sm">← Back to Items</a>
      </div>
    </header>

    <main class="page-body">
      <div class="page-header">
        <div>
          <h1 class="page-title">EDIT ITEM</h1>
          
          <p class="page-subtitle">Editing: <?php echo htmlspecialchars($item['name']); ?></p>
          <p class="page-subtitle">Update the details of this dish</p>
        </div>
      </div>

      <div class="card">
        <h2 class="card-title">Item Details</h2>

        <?php if ($error): ?>
          <div style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        
        
        <form action="edit-item.php" method="POST">
          <input type="hidden" name="id" value="<?= $item['id'] ?>" />

          <div class="form-grid">

            <div class="form-field">
              <label for="name">Dish Name</label>
              
              <input id="name" name="name" type="text" placeholder="e.g. Tonkotsu Ramen"
                value="<?= htmlspecialchars($item['name']); ?>" required />
            </div>

            <div class="form-field">
              <label for="price">Price (€)</label>
              
              <input id="price" name="price" type="number" step="0.01" min="0" placeholder="e.g. 14.50"
                value="<?= htmlspecialchars($item['price']); ?>" required />
            </div>

            <div class="form-field">
              <label for="category_id">Category</label>
              <select id="category_id" name="category_id" required>
                <option value="" disabled>Select a category</option>
                

                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $item['category_id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($cat['name']); ?>
                  </option>
                <?php endforeach; ?>

              </select>
            </div>

            <div class="form-field form-field-full">
              <label for="description">Description</label>
              <textarea id="description" name="description" rows="4"
                placeholder="Short description of the dish"><?= htmlspecialchars($item['description']); ?></textarea>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="items.php" class="btn">Cancel</a>
            </div>

          </div>
        </form>
      </div>

    </main>
  </div>

  <div id="toastHost"></div>
  <script src="common.js"></script>
</body>

</html>