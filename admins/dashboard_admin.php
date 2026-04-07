<?php
session_start();
include_once '../config/database.php';

// CEK LOGIN & ROLE
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// AMBIL DATA PENDAFTAR
$query = $conn->query("
    SELECT p.*, u.fullname, u.email 
    FROM pendaftaran p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
");
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">

    <h4 class="mb-4">Dashboard Admin</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $query->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['fullname']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['jurusan']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a href="detail_pendaftar.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div>

<?php include '../includes/footer.php'; ?>