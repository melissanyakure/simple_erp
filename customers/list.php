<?php
require '../config/db.php';
require '../includes/header.php';

$customers = $pdo->query("SELECT * FROM customers ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Customers</h2>
<a href="add.php" class="btn">+ Add Customer</a>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($customers as $c): ?>
    <tr>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['phone']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars($c['address']) ?></td>
        <td>
            <a href="edit.php?id=<?= $c['id'] ?>">Edit</a>
            <form method="POST" action="delete.php" style="display:inline"
                  onsubmit="return confirm('Delete this customer?');">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>