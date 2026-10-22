<?php
require '../config/db.php';
require '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name          = trim($_POST['name']);
    $price         = $_POST['price'];
    $stock_qty     = $_POST['stock_qty'];
    $reorder_level = $_POST['reorder_level'];

    if ($name === '' || $price < 0 || $stock_qty < 0) {
        $error = "Please enter a name, and a price and stock of 0 or more.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock_qty, reorder_level) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $stock_qty, $reorder_level]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Add Product</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Product name</label>
    <input type="text" name="name" required>

    <label>Price (KES)</label>
    <input type="number" step="0.01" name="price" required>

    <label>Stock quantity</label>
    <input type="number" name="stock_qty" value="0" required>

    <label>Reorder level (low stock warning)</label>
    <input type="number" name="reorder_level" value="5" required>

    <button type="submit" class="btn">Save Product</button>
</form>

<?php require '../includes/footer.php'; ?>