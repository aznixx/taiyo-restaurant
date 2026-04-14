<?php
require __DIR__ . '/../../config/db.php';

header('Content-Type: application/json');

$full_name = trim($_POST['fullName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$party_size = trim($_POST['partySize'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$full_name || !$email || !$message || !$party_size) {
    echo json_encode(['ok' => false, 'error' => 'missing']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_email']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO messages (full_name, email, phone, party_size, message) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$full_name, $email, $phone, $party_size, $message]);

echo json_encode(['ok' => true]);
exit;
?>