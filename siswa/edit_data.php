<?php
session_start();
include_once '../config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// AMBIL DATA
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// CEK KALAU BELUM ADA DATA
if (!$data) {
    header("Location: form_ppdb.php");
    exit();
}
?>

<?php
$css = "../assets/css/form.css";
include '../includes/header.php';
?>

<!-- NAVBAR -->
<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard_siswa.php">
            <img src="../assets/img/logo-isfi.png" alt="logo-isfi" height="50">
            <span class="fw-semibold text-light">SMKS ISFI BANJARMASIN</span>
        </a>
    </div>
</nav>

<div class="content">

    <div class="card shadow-sm form-card p-4">

        <!-- HEADER FORM -->
        <div class="mb-4 p-3 rounded-3 header-form text-center">
            <h4 class="fw-bold mb-1">Ubah Data Diri</h4>
            <p class="mb-0 small">
                Lengkapi data dengan benar untuk proses seleksi awal.
            </p>
        </div>

        <div class="content">

            <div class="card shadow-sm form-card p-4">

                <h4 class="fw-bold mb-4">Edit Data Diri</h4>

                <form action="form_ppdb_proses.php" method="POST">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                value="<?= htmlspecialchars($data['nama']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jk" class="form-select">
                                <option value="L" <?= $data['jk'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $data['jk'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="<?= htmlspecialchars($data['tempat_lahir']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="<?= $data['tanggal_lahir'] ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control"
                                value="<?= htmlspecialchars($data['agama']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control"
                                value="<?= htmlspecialchars($data['no_hp']) ?>">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat']) ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control"
                                value="<?= htmlspecialchars($data['asal_sekolah']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan" class="form-select">
                                <option value="RPL" <?= $data['jurusan'] == 'RPL' ? 'selected' : '' ?>>RPL</option>
                                <option value="Farmasi" <?= $data['jurusan'] == 'Farmasi' ? 'selected' : '' ?>>Farmasi</option>
                                <option value="Kecantikan" <?= $data['jurusan'] == 'Kecantikan' ? 'selected' : '' ?>>Kecantikan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="ayah" class="form-control"
                                value="<?= htmlspecialchars($data['ayah']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">HP Ayah</label>
                            <input type="text" name="hp_ayah" class="form-control"
                                value="<?= htmlspecialchars($data['hp_ayah']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="ibu" class="form-control"
                                value="<?= htmlspecialchars($data['ibu']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">HP Ibu</label>
                            <input type="text" name="hp_ibu" class="form-control"
                                value="<?= htmlspecialchars($data['hp_ibu']) ?>">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Motivasi</label>
                            <textarea name="motivasi" class="form-control"><?= htmlspecialchars($data['motivasi']) ?></textarea>
                        </div>

                    </div>

                    <button class="btn btn-warning w-100 mt-4">
                        Update Data
                    </button>

                </form>

            </div>

        </div>

        <?php include '../includes/footer.php'; ?>