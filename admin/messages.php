<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

require __DIR__ . '/../config/db.php';

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['isread'])) {
  $id = $_GET['isread'];
  $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
  $stmt->execute([$id]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Messages | Taiyo Admin</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    .message-detail {
      background: var(--bg-section);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 1.5rem;
      margin-top: 1.5rem;
      display: none;
    }

    .message-detail.visible {
      display: block;
    }

    .message-meta {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 1rem;
      margin-bottom: 1.25rem;
      padding-bottom: 1.25rem;
      border-bottom: 1px solid var(--border);
    }

    .message-meta-item label {
      display: block;
      margin-bottom: 0.25rem;
    }

    .message-meta-item span {
      font: 400 0.9rem/1 'Open Sans', sans-serif;
      color: var(--text-primary);
    }

    .message-body {
      font: 400 0.95rem/1.7 'Open Sans', sans-serif;
      color: var(--text-secondary);
      white-space: pre-wrap;
    }
  </style>
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
      <span class="topbar-title">Messages</span>
    </header>

    <main class="page-body">
      <div class="page-header">
        <div>
          <h1 class="page-title">MESSAGES</h1>
          <p class="page-subtitle">Contact form submissions from customers</p>
        </div>
      </div>

      <div class="card">
        <h2 class="card-title">All Messages</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Party Size</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- PHP: loop over messages from DB -->
              <?php foreach ($messages as $msg): ?>

                <tr>
                  <td><?php echo htmlspecialchars($msg['full_name']); ?></td>
                  <td><?php echo htmlspecialchars($msg['email']); ?></td>
                  <td><?php echo htmlspecialchars($msg['party_size']); ?></td>
                  <td><?php echo $msg['created_at']; ?></td>
                  <td>
                    <span class="badge <?php echo $msg['is_read'] ? 'badge-green' : 'badge-gold'; ?>">
                      <?php echo $msg['is_read'] ? 'Read' : 'Unread'; ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-group">
                      <a href="#" class="btn btn-sm btn-view" data-id="<?= $msg['id'] ?>"
                        data-name="<?= htmlspecialchars($msg['full_name']) ?>"
                        data-email="<?= htmlspecialchars($msg['email']) ?>"
                        data-phone="<?= htmlspecialchars($msg['phone'] ?: '—') ?>"
                        data-party="<?= htmlspecialchars($msg['party_size']) ?>" data-date="<?= $msg['created_at'] ?>"
                        data-message="<?= htmlspecialchars($msg['message']) ?>">View</a>
                      <form method="POST" action="delete-message.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
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

  <div id="msgModal"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:999; align-items:center; justify-content:center;">
    <div
      style="background:var(--bg-card); border:1px solid var(--border); border-radius:8px; padding:2rem; max-width:600px; width:90%; position:relative;">
      <button id="modalClose"
        style="position:absolute; top:1rem; right:1rem; background:none; border:none; color:var(--text-primary); font-size:1.2rem; cursor:pointer;">✕</button>
      <h2 style="margin:0 0 1.5rem; font-family:Montserrat; color:var(--gold); letter-spacing:1px;">MESSAGE DETAIL</h2>
      <div class="message-meta">
        <div class="message-meta-item"><label>From</label><span id="mName"></span></div>
        <div class="message-meta-item"><label>Email</label><span id="mEmail"></span></div>
        <div class="message-meta-item"><label>Phone</label><span id="mPhone"></span></div>
        <div class="message-meta-item"><label>Party Size</label><span id="mParty"></span></div>
        <div class="message-meta-item"><label>Date</label><span id="mDate"></span></div>
      </div>
      <div class="message-body" id="mMessage"></div>
      <div
        style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); display:flex; gap:0.75rem;">
        <a id="mMarkRead" href="#" class="btn btn-primary btn-sm">Mark as Read</a>
        <button id="modalClose2" class="btn btn-sm">Close</button>
      </div>
    </div>
  </div>

  <div id="toastHost"></div>
  <script src="sidebar.js"></script>
  <script src="common.js"></script>

  <script>
    const modal = document.getElementById('msgModal');

    document.querySelectorAll('.btn-view').forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('mName').textContent = this.dataset.name;
        document.getElementById('mEmail').textContent = this.dataset.email;
        document.getElementById('mPhone').textContent = this.dataset.phone;
        document.getElementById('mParty').textContent = this.dataset.party;
        document.getElementById('mDate').textContent = this.dataset.date;
        document.getElementById('mMessage').textContent = this.dataset.message;
        document.getElementById('mMarkRead').href = 'messages.php?isread=' + this.dataset.id;
        modal.style.display = 'flex';
      });
    });

    document.getElementById('modalClose').addEventListener('click', () => {
      modal.style.display = 'none';
    });

    modal.addEventListener('click', function (e) {
      if (e.target === this) this.style.display = 'none';
    });
  </script>
</body>

</html>