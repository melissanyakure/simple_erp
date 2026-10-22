<?php
require '../config/db.php';
require '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if ($name === '') {
        $error = "Supplier name is required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO suppliers (name, phone, email) VALUES (?, ?, ?)");
        $stmt->execute([$name, $phone, $email]);
        header("Location: list.php");
        exit;
    }
}
?>

<h2>Add Supplier</h2>

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

    <button type="submit" class="btn">Save Supplier</button>
    <a href="list.php">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>