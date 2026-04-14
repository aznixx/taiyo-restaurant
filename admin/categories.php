<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}


require __DIR__ . "/../config/db.php";

$error = '';

$stmt = $pdo->query("
    SELECT c.*, COUNT(m.id) AS item_count 
    FROM categories c
    LEFT JOIN menu_items m ON m.category_id = c.id
    GROUP BY c.id
");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $description = trim($_POST['description'] ?? '');

  if ($name === '') {
    $error = "Please enter a category name.";
  } else {

    $check = $pdo->prepare('SELECT id FROM categories WHERE name = ?');
    $check->execute([$name]);

    if ($check->fetch()) {
      $error = "Category '$name' already exists";
    } else {

      $stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
      $stmt->execute([$name, $description]);

      header("Location: categories.php");
      exit;
    }
  }
}



$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Categories | Taiyo Admin</title>
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
      <span class="topbar-title">Categories</span>
    </header>

    <main class="page-body">
      <div class="page-header">
        <div>
          <h1 class="page-title">CATEGORIES</h1>
          <p class="page-subtitle">Manage your menu categories</p>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

        
        <div class="card">
          <h2 class="card-title">Add Category</h2>

          <?php if ($error): ?>
            <div style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          
          <form action="categories.php" method="POST">
            <div class="form-grid" style="grid-template-columns: 1fr;">

              <div class="form-field">
                <label for="cat_name">Category Name</label>
                <input id="cat_name" name="name" type="text" placeholder="e.g. Starters" required />
              </div>

              <div class="form-field">
                <label for="cat_description">Description (optional)</label>
                <textarea id="cat_description" name="description" rows="3"
                  placeholder="Brief description..."></textarea>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Category</button>
              </div>

            </div>
          </form>
        </div>

        
        <div class="card">
          <h2 class="card-title">All Categories</h2>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Items</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                

                <?php foreach ($categories as $cat): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($cat['name']); ?></td>
                    <td><span class="badge badge-gold"><?php echo $cat['item_count']; ?></span></td>
                    <td>
                      <div class="action-group">
                        <form method="POST" action="delete-category.php" style="display:inline;">
                          <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
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

      </div>

    </main>
  </div>

  <div id="toastHost"></div>
  <script src="sidebar.js"></script>
  <script src="common.js"></script>
</body>

</html>