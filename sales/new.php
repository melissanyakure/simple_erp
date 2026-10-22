<?php
require '../includes/auth_check.php';
require '../config/db.php';
require '../includes/functions.php';

$customers = $pdo->query("SELECT id, name FROM customers ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$products  = $pdo->query("SELECT id, name, price, stock_qty FROM products WHERE stock_qty > 0 ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = $_POST['customer_id'] ?? '';
    $items = [];

    foreach ($_POST['product_id'] as $i => $productId) {
        $qty = (int) ($_POST['quantity'][$i] ?? 0);
        if ($productId !== '' && $qty > 0) {
            $items[] = ['product_id' => (int) $productId, 'quantity' => $qty];
        }
    }

    if ($customerId === '') {
        $error = "Please choose a customer.";
    } elseif (empty($items)) {
        $error = "Please add at least one product with a quantity.";
    } else {
        try {
            createSale($pdo, $customerId, $_SESSION['user_id'], $items);
            header("Location: list.php?success=1");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

require '../includes/header.php';
?>

<h2>New Sale</h2>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Customer</label>
    <select name="customer_id" style="width:100%; padding:8px; margin:6px 0 12px;">
        <option value="">-- Choose customer --</option>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Products sold</label>
    <table>
        <tr><th>Product</th><th style="width:120px">Quantity</th></tr>
        <?php for ($i = 0; $i < 5; $i++): ?>
        <tr>
            <td>
                <select name="product_id[]" style="width:100%; padding:8px;">
                    <option value="">-- Choose product --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['name']) ?> - KES <?= number_format($p['price'], 2) ?> (stock: <?= $p['stock_qty'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" name="quantity[]" min="0" value="0"></td>
        </tr>
        <?php endfor; ?>
    </table>

    <br>
    <button type="submit" class="btn">Save Sale</button>
    <a href="list.php">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>