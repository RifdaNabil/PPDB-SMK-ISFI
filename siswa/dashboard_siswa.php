<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'siswa') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// CEK PENDAFTARAN
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$status = $data['status'] ?? null;

// CEK BERKAS
$berkas = null;
if ($data) {
    $pendaftaran_id = $data['id'];

    $cekBerkas = $conn->prepare("SELECT * FROM berkas WHERE pendaftaran_id=?");
    $cekBerkas->bind_param("i", $pendaftaran_id);
    $cekBerkas->execute();
    $berkas = $cekBerkas->get_result()->fetch_assoc();
}
?>

<?php
$css = "../assets/css/siswa.css";
include '../includes/header.php';
?>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">

        <div>
            <div class="text-center mb-4">
                <img src="../assets/img/logo-isfi.png" height="60" class="mb-2">
                <h6 class="text-white fw-semibold">PPDB ISFI</h6>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active">
                        <i class="bi bi-house-door me-2"></i> Beranda
                    </a>
                </li>

                <?php if ($data): ?>
                    <a class="nav-link disabled text-secondary" style="pointer-events:none; opacity:0.6;">
                        <i class="bi bi-file-earmark-text me-2"></i> Isi Data Diri
                    </a>
                <?php else: ?>
                    <a href="form_ppdb.php" class="nav-link">
                        <i class="bi bi-file-earmark-text me-2"></i> Isi Data Diri
                    </a>
                <?php endif; ?>

                <?php if ($berkas): ?>
                    <a class="nav-link disabled text-secondary" style="pointer-events:none; opacity:0.6;">
                        <i class="bi bi-cloud-upload me-2"></i> Upload
                    </a>
                <?php else: ?>
                    <a href="upload_berkas.php" class="nav-link">
                        <i class="bi bi-cloud-upload me-2"></i> Upload
                    </a>
                <?php endif; ?>

            </ul>
        </div>

        <!-- LOGOUT -->
        <div class="mt-auto">
            <a href="../auth/logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
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
                        Selamat Datang, <?= $_SESSION['user_name']; ?>
                    </h4>
                    <p class="mb-0">Pantau proses pendaftaranmu di sini</p>
                </div>
                <img src="../assets/img/hero.png" height="170">
            </div>
        </div>

        <!-- PENGUMUMAN -->
        <div class="card p-4 mb-4">

            <h5 class="mb-3">
                <i class="bi bi-megaphone"></i> Pengumuman
            </h5>

            <?php if (!$data): ?>

                <div class="alert alert-secondary">
                    Silakan isi data terlebih dahulu.
                </div>

            <?php else: ?>

                <?php if ($status == 'menunggu'): ?>
                    <div class="alert alert-warning">
                        Data kamu sedang dalam proses verifikasi oleh admin.
                    </div>

                <?php elseif ($status == 'lulus'): ?>
                    <div class="alert alert-success">
                        <b>Selamat! Kamu dinyatakan LULUS.</b>
                        <br>
                        Silakan melakukan daftar ulang ke sekolah.
                    </div>

                <?php elseif ($status == 'tidak lulus'): ?>
                    <div class="alert alert-danger">
                        <b>Mohon maaf, kamu belum lulus.</b>
                        <br>
                        <?= $data['alasan'] ?? 'Tetap semangat dan coba lagi.' ?>
                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

        <!-- INFO -->
        <div class="card info-card p-3 mb-4">

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    Data diri berhasil disimpan
                </div>

            <?php elseif (isset($_GET['upload'])): ?>
                <div class="alert alert-success">
                    Berkas berhasil diupload
                </div>

            <?php endif; ?>

            <?php if (!$data && !$berkas): ?>
                <div class="alert alert-warning">
                    Kamu belum mengisi Data Diri dan Upload Berkas.
                    Klik tombol di bawah untuk memulai pendaftaran.
                </div>

            <?php endif; ?>

            <div class="row">

                <div class="col-md-4 mb-2">
                    <i class="bi bi-person"></i>
                    <b>Nama:</b><br>
                    <?= $_SESSION['user_name']; ?>
                </div>

                <div class="col-md-4 mb-2">
                    <i class="bi bi-envelope"></i>
                    <b>Email:</b><br>
                    <?= $_SESSION['user_email']; ?>
                </div>

                <div class="col-md-4 mb-2">
                    <i class="bi bi-flag"></i>
                    <b>Status:</b><br>

                    <!-- STATUS -->
                    <?php if (!$data): ?>
                        <span class="badge bg-warning text-dark">Belum Mengisi Data</span>
                    <?php else: ?>
                        <?php
                        if ($status == 'lulus') {
                            echo "<span class='badge bg-success'>Lulus</span>";
                        } elseif ($status == 'tidak lulus') {
                            echo "<span class='badge bg-danger'>Tidak Lulus</span>";
                        } elseif ($status == 'menunggu') {
                            echo "<span class='badge bg-warning text-dark'>Menunggu Verifikasi</span>";
                        } else {
                            echo "<span class='badge bg-secondary'>Belum Mengisi Data dan Berkas</span>";
                        }
                        ?>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <!-- PROGRESS-->
        <div class="card progress-card p-4">

            <h5 class="fw-semibold mb-4">Alur Pendaftaran</h5>

            <div class="progress-wrapper">

                <div class="progress-step active">
                    <div class="icon"><i class="bi bi-person-check"></i></div>
                    <p>Daftar</p>
                </div>

                <div class="progress-step <?= $data ? 'active' : '' ?>">
                    <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
                    <p>Isi Data Diri</p>
                </div>

                <div class="progress-step <?= ($berkas) ? 'active' : '' ?>">
                    <div class="icon"><i class="bi bi-cloud-upload"></i></div>
                    <p>Upload</p>
                </div>

            </div>

            <!-- ACTION -->
            <div class="text-center mt-4">

                <?php if (!$data): ?>
                    <a href="form_ppdb.php" class="btn btn-primary px-4">
                        Isi Formulir
                    </a>
                <?php elseif (!$berkas): ?>
                    <a href="upload_berkas.php" class="btn btn-success px-4">
                        Upload Berkas
                    </a>

                <?php else: ?>

                    <?php if ($status == 'menunggu'): ?>

                        <a href="edit_data.php" class="btn btn-warning px-4 me-2">
                            Edit Data
                        </a>

                        <a href="edit_berkas.php" class="btn btn-success px-4">
                            Edit Berkas
                        </a>

                    <?php else: ?>

                        <button class="btn btn-secondary px-4 me-2" disabled>
                            <i class="bi bi-lock"></i> Edit Data
                        </button>

                        <button class="btn btn-secondary px-4" disabled>
                            <i class="bi bi-lock"></i> Edit Berkas
                        </button>

                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>