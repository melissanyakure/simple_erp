<?php
require '../config/db.php';
require '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $address = trim($_POST['address']);

    if ($name === '') {
        $error = "Customer name is required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO customers (name, phone, email, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $email, $address]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Add Customer</h2>

<?php if ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Phone</label>
    <input type="text" name="phone">

    <label>Email</label>
    <input type="email" name="email">

    <label>Address</label>
    <input type="text" name="address">

    <button type="submit" class="btn">Save Customer</button>
    <a href="list.php">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>