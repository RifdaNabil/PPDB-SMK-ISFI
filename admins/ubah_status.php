<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_POST['id'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE pendaftaran SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: dashboard_admin.php");
} else {
    echo "Gagal update";
}