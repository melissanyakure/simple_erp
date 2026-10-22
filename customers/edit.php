<?php
require '../config/db.php';
require '../includes/header.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo "<p class='error'>Customer not found.</p>";
    require '../includes/footer.php';
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $address = trim($_POST['address']);

    if ($name === '') {
        $error = "Customer name is required.";
    } else {
        $stmt = $pdo->prepare("UPDATE customers SET name = ?, phone = ?, email = ?, address = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $email, $address, $id]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Edit Customer</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>">

    <label>Address</label>
    <input type="text" name="address" value="<?= htmlspecialchars($customer['address']) ?>">

    <button type="submit" class="btn">Update Customer</button>
    <a href="list.php">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>