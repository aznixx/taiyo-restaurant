<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

require __DIR__ . '/../config/db.php';

$id = $_POST['id'] ?? null;

if ($id) {
  $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
  $stmt->execute([$id]);
}

header("Location: messages.php");
exit;

?>