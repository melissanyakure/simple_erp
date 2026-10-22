<?php
require '../config/db.php';
require '../includes/header.php';

$sql = "SELECT so.id, so.total, so.status, so.created_at,
               c.name AS customer, u.name AS seller
        FROM sales_orders so
        JOIN customers c ON so.customer_id = c.id
        JOIN users u ON so.user_id = u.id
        ORDER BY so.id DESC";
$orders = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Sales</h2>
<a href="new.php" class="btn">+ New Sale</a>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green">Sale recorded successfully.</p>
<?php endif; ?>

<table>
    <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Customer</th>
        <th>Sold by</th>
        <th>Total (KES)</th>
        <th>Status</th>
    </tr>
    <?php foreach ($orders as $o): ?>
    <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $o['created_at'] ?></td>
        <td><?= htmlspecialchars($o['customer']) ?></td>
        <td><?= htmlspecialchars($o['seller']) ?></td>
        <td><?= number_format($o['total'], 2) ?></td>
        <td><?= $o['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>