<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /simple_erp/login.php");
    exit;
}