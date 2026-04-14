<?php

$pdo = new PDO("mysql:host=db;dbname=taiyo;charset=utf8mb4", "taiyo", "taiyo123", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$host = 'db';
$dbname = 'taiyo';
$user = 'taiyo';
$pass = 'taiyo123';
$charset = 'utf8mb4';
