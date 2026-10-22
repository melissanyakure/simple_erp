<?php
require 'config/db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $p) {
    echo $p['name'] . " - KES " . $p['price'] . " - Stock: " . $p['stock_qty'] . "<br>";
}