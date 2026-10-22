<?php
require '../config/db.php';
require '../includes/header.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM suppliers WHERE id = ?");
$stmt->execute([$id]);
$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$supplier) {
    echo "<p class='error'>Supplier not found.</p>";
    require '../includes/footer.php';
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if ($name === '') {
        $error = "Supplier name is required.";
    } else {
        $stmt = $pdo->prepare("UPDATE suppliers SET name = ?, phone = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $email, $id]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Edit Supplier</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($supplier['name']) ?>" required>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone']) ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($supplier['email']) ?>">

    <button type="submit" class="btn">Update Supplier</button>
    <a href="list.php">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>