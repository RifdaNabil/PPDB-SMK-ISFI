<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: form_ppdb.php");
    exit();
}

$cek = $conn->prepare("SELECT * FROM berkas WHERE pendaftaran_id=?");
$cek->bind_param("i", $data['id']);
$cek->execute();
$berkas = $cek->get_result()->fetch_assoc();
?>

<?php
$css = "../assets/css/form.css";
include '../includes/header.php';
?>

<!-- NAVBAR -->
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

        <!-- HEADER FORM -->
        <div class="mb-4 p-3 rounded-3 header-form text-center">
            <h4 class="fw-bold mb-1">Upload Berkas</h4>
            <p class="mb-0 small">Pastikan file sesuai format</p>
        </div>

        <!-- ERROR -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php
                if ($_GET['error'] == 'size') echo "Pas foto maksimal 5MB";
                elseif ($_GET['error'] == 'format') echo "Format pas foto harus JPG/PNG";
                elseif ($_GET['error'] == 'ijazah_format') echo "Ijazah harus JPG/PNG/PDF";
                elseif ($_GET['error'] == 'nilai_format') echo "Nilai harus PDF";
                elseif ($_GET['error'] == 'gagal') echo "Upload gagal";
                ?>
            </div>
        <?php endif; ?>

        <!-- SUCCESS -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Upload berhasil</div>
        <?php endif; ?>

        <!-- INFO -->
        <?php if ($berkas): ?>
            <div class="alert alert-info">
                Berkas sudah pernah diupload (bisa update)
            </div>
        <?php endif; ?>

        <form action="upload_berkas_proses.php" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Pas Foto (JPG/PNG, Max 5MB)</label>
                <input type="file" name="pas_foto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ijazah (JPG/PNG, Max 5MB)</label>
                <input type="file" name="ijazah" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai (PDF)</label>
                <input type="file" name="nilai" class="form-control">
            </div>

            <button class="btn btn-primary w-100">Upload</button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>