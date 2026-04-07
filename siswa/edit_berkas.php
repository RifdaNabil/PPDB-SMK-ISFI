<?php
session_start();
include_once '../config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// AMBIL PENDAFTARAN
$stmt = $conn->prepare("SELECT id FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pendaftaran = $stmt->get_result()->fetch_assoc();

if (!$pendaftaran) {
    header("Location: form_ppdb.php");
    exit();
}

// AMBIL BERKAS
$cek = $conn->prepare("SELECT * FROM berkas WHERE pendaftaran_id=?");
$cek->bind_param("i", $pendaftaran['id']);
$cek->execute();
$data = $cek->get_result()->fetch_assoc();

if (!$data) {
    header("Location: upload_berkas.php");
    exit();
}
?>

<?php
$css = "../assets/css/form.css";
include '../includes/header.php';
?>

<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard_siswa.php">
            <img src="../assets/img/logo-isfi.png" height="50">
            <span class="fw-semibold text-light">SMKS ISFI BANJARMASIN</span>
        </a>
    </div>
</nav>

<div class="content">

    <div class="card shadow-sm form-card p-4">

        <h4 class="fw-bold mb-3 text-center">Edit Berkas</h4>

        <!-- PREVIEW -->
        <div class="mb-4">

            <label class="fw-semibold">Pas Foto Saat Ini:</label><br>
            <img src="../uploads/pas_foto/<?= $data['pas_foto']; ?>" width="120" class="mb-3">

            <br>

            <label class="fw-semibold">Ijazah:</label><br>
            <?php if ($data['ijazah']): ?>
                <a href="../uploads/ijazah/<?= $data['ijazah']; ?>" target="_blank">Lihat File</a>
            <?php else: ?>
                <small class="text-muted">Belum ada</small>
            <?php endif; ?>

            <br><br>

            <label class="fw-semibold">Nilai:</label><br>
            <?php if ($data['nilai']): ?>
                <a href="../uploads/nilai/<?= $data['nilai']; ?>" target="_blank">Lihat File</a>
            <?php else: ?>
                <small class="text-muted">Belum ada</small>
            <?php endif; ?>

        </div>

        <!-- FORM -->
        <form action="upload_berkas_proses.php" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Ganti Pas Foto</label>
                <input type="file" name="pas_foto" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Ijazah</label>
                <input type="file" name="ijazah" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Nilai</label>
                <input type="file" name="nilai" class="form-control">
            </div>

            <button class="btn btn-warning w-100 mt-3">
                Update Berkas
            </button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>