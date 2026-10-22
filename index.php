<?php require 'includes/auth_check.php'; ?>
<!DOCTYPE html>
<html>
<head><title>ERP Dashboard</title></head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h1>
    <p>Your role: <?= htmlspecialchars($_SESSION['role']) ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>