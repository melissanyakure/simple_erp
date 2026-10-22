<?php
require '../config/db.php';
require '../includes/header.php';

$products = $pdo->query("SELECT * FROM products ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Products</h2>
<a href="add.php" class="btn">+ Add Product</a>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>Name</th>
        <th>Price (KES)</th>
        <th>Stock</th>
        <th>Reorder Level</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= number_format($p['price'], 2) ?></td>
        <td><?= $p['stock_qty'] ?></td>
        <td><?= $p['reorder_level'] ?></td>
        <td>
            <a href="edit.php?id=<?= $p['id'] ?>">Edit</a>
            <form method="POST" action="delete.php" style="display:inline"
                  onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>