<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// UPDATE STATUS
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE pendaftaran SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// DATA
$data = $conn->query("
    SELECT p.*, u.nama, u.email 
    FROM pendaftaran p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
");
?>

<?php
$css = "../assets/css/siswa.css";
include '../includes/header.php';
?>

<div class="layout">

<!-- SIDEBAR (SAMA SEPERTI SISWA) -->
<div class="sidebar d-flex flex-column">

    <div>
        <div class="text-center mb-4">
            <img src="../assets/img/logo-isfi.png" height="60">
            <h6 class="text-white fw-semibold">PPDB ISFI</h6>
        </div>

        <ul class="nav flex-column">
            <li class="mb-2">
                <a class="nav-link active">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="mt-auto">
        <a href="../auth/logout.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

</div>

<!-- CONTENT -->
<div class="content">

<!-- HERO -->
<div class="hero-card p-4 mb-4 text-white">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">
                Dashboard Admin
            </h4>
            <p class="mb-0">Kelola data pendaftar di sini</p>
        </div>
    </div>
</div>

<!-- LIST PENDAFTAR (CARD STYLE) -->
<div class="card p-4">

<h5 class="mb-4">
    <i class="bi bi-people"></i> Data Pendaftar
</h5>

<?php while($row = $data->fetch_assoc()): ?>

<div class="card mb-3 p-3">

<div class="row align-items-center">

<!-- INFO -->
<div class="col-md-4">
    <b><?= $row['nama'] ?></b><br>
    <small class="text-muted"><?= $row['email'] ?></small><br>
    <span class="badge bg-secondary"><?= $row['jurusan'] ?></span>
</div>

<!-- STATUS -->
<div class="col-md-4">

<form method="POST" class="d-flex flex-column gap-2">

<input type="hidden" name="id" value="<?= $row['id'] ?>">

<select name="status" class="form-select form-select-sm">
    <option value="menunggu" <?= $row['status']=='menunggu'?'selected':'' ?>>Menunggu</option>
    <option value="lulus" <?= $row['status']=='lulus'?'selected':'' ?>>Lulus</option>
    <option value="tidak lulus" <?= $row['status']=='tidak lulus'?'selected':'' ?>>Tidak Lulus</option>
</select>

<button name="update" class="btn btn-success btn-sm">
    <i class="bi bi-check"></i> Simpan
</button>

</form>

</div>

<!-- AKSI -->
<div class="col-md-4 text-end">
    <a href="detail_pendaftar.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
        <i class="bi bi-eye"></i> Detail
    </a>
</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>
</div>

<?php include '../includes/footer.php'; ?>