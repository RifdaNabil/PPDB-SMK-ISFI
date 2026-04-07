<?php
$conn = new mysqli("localhost", "root", "", "ppdb");

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>