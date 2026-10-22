<?php
require '../includes/auth_check.php';
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    try {
        $stmt = $pdo->prepare("DELETE FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: list.php");
    } catch (PDOException $e) {
        header("Location: list.php?error=" . urlencode("Cannot delete: this supplier is linked to products or purchase orders."));
    }
    exit;
}

header("Location: list.php");