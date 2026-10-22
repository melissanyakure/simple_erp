<?php
require '../config/db.php';
require '../includes/header.php';

$suppliers = $pdo->query("SELECT * FROM suppliers ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Suppliers</h2>
<a href="add.php" class="btn">+ Add Supplier</a>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($suppliers as $s): ?>
    <tr>
        <td><?= htmlspecialchars($s['name']) ?></td>
        <td><?= htmlspecialchars($s['phone']) ?></td>
        <td><?= htmlspecialchars($s['email']) ?></td>
        <td>
            <a href="edit.php?id=<?= $s['id'] ?>">Edit</a>
            <form method="POST" action="delete.php" style="display:inline"
                  onsubmit="return confirm('Delete this supplier?');">
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>