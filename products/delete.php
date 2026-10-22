<?php
require '../includes/auth_check.php';
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: list.php");
    } catch (PDOException $e) {
        header("Location: list.php?error=" . urlencode("Cannot delete: this product is used in existing orders."));
    }
    exit;
}

header("Location: list.php");