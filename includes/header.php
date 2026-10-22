<?php require_once __DIR__ . '/auth_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple ERP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f2f2f2; }
        nav { background: #2d6cdf; padding: 12px 20px; }
        nav a { color: #fff; margin-right: 18px; text-decoration: none; }
        .container { max-width: 900px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #eee; }
        input { padding: 8px; width: 100%; box-sizing: border-box; margin: 6px 0 12px; }
        .btn { display: inline-block; padding: 8px 14px; background: #2d6cdf; color: #fff; border: 0; text-decoration: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
<nav>
    <a href="/simple_erp/index.php">Dashboard</a>
    <a href="/simple_erp/products/list.php">Products</a>
    <a href="/simple_erp/customers/list.php">Customers</a>
    <a href="/simple_erp/suppliers/list.php">Suppliers</a>
    <a href="/simple_erp/sales/list.php">Sales</a>
    <a href="/simple_erp/logout.php">Logout</a>
</nav>
<div class="container">