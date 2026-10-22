<?php
require '../config/db.php';
require '../includes/header.php';

$id = $_GET['id'] ?? null;

// Load the product to edit
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<p class='error'>Product not found.</p>";
    require '../includes/footer.php';
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name          = trim($_POST['name']);
    $price         = $_POST['price'];
    $stock_qty     = $_POST['stock_qty'];
    $reorder_level = $_POST['reorder_level'];

    if ($name === '' || $price < 0 || $stock_qty < 0) {
        $error = "Please enter a name, and a price and stock of 0 or more.";
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, stock_qty = ?, reorder_level = ? WHERE id = ?");
        $stmt->execute([$name, $price, $stock_qty, $reorder_level, $id]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Edit Product</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Product name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Price (KES)</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

    <label>Stock quantity</label>
    <input type="number" name="stock_qty" value="<?= $product['stock_qty'] ?>" required>

    <label>Reorder level</label>
    <input type="number" name="reorder_level" value="<?= $product['reorder_level'] ?>" required>

    <button type="submit" class="btn">Update Product</button>
    <a href="list.php">Cancel</a>
</form>