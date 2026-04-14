<?php
require __DIR__ . '/../../config/db.php';

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
$sql = "
    SELECT m.*, c.name AS category_name 
    FROM menu_items m
    JOIN categories c ON c.id = m.category_id
    WHERE m.name LIKE ? OR m.description LIKE ?
    ORDER BY c.name, m.name
";

$stmt = $pdo->prepare($sql);
$stmt->execute($q ? ["%$q%", "%$q%"] : ['%%', '%%']);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
foreach ($items as $item) {
    $cat = $item['category_name'];
    $categories[$cat]['name'] = $cat;
    $categories[$cat]['items'][] = $item;
}

echo json_encode(['categories' => array_values($categories)]);