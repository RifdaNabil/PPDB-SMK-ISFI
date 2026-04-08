<?php
session_start();
include_once '../config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'siswa') {
    header("Location: ../auth/login.php");
    exit();
}

// CEK SUDAH ISI DATA ATAU BELUM
$stmt = $conn->prepare("SELECT id FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // SUDAH ISI → TOLAK
    header("Location: dashboard_siswa.php");
    exit();
}

// VALUE BIAR GA ILANG
$nama = $_POST['nama'] ?? '';
$jk = $_POST['jk'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$agama = $_POST['agama'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$asal_sekolah = $_POST['asal_sekolah'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$ayah = $_POST['ayah'] ?? '';
$hp_ayah = $_POST['hp_ayah'] ?? '';
$ibu = $_POST['ibu'] ?? '';
$hp_ibu = $_POST['hp_ibu'] ?? '';
$motivasi = $_POST['motivasi'] ?? '';

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
            <h4 class="fw-bold mb-1">Isi Data Diri</h4>
            <p class="mb-0 small">
                Lengkapi data dengan benar untuk proses seleksi awal.
            </p>
        </div>

        <form action="form_ppdb_proses.php" method="POST">

            <!-- DATA DIRI -->
        <div class="section-box p-3 mb-4">
            <h5 class="mb-3">Data Diri</h5>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= htmlspecialchars($nama) ?>"
                        placeholder="Masukkan nama lengkap kamu" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jk" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" <?= $jk == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $jk == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control"
                        value="<?= htmlspecialchars($tempat_lahir) ?>"
                        placeholder="Contoh: Banjarmasin" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                        value="<?= $tanggal_lahir ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" class="form-control"
                        value="<?= htmlspecialchars($agama) ?>"
                        placeholder="Contoh: Islam" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control"
                        value="<?= htmlspecialchars($no_hp) ?>"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"
                        placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($alamat) ?></textarea>
                </div>
        </div>

            </div>

            <hr class="my-4">

            <!-- DATA SEKOLAH -->
        <div class="section-box p-3 mb-4">
            <h5 class="mb-3">Data Sekolah</h5>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="form-control"
                        value="<?= htmlspecialchars($asal_sekolah) ?>"
                        placeholder="Nama sekolah asal" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-select" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="RPL" <?= $jurusan == 'RPL' ? 'selected' : '' ?>>Rekayasa Perangkat Lunak</option>
                        <option value="Farmasi" <?= $jurusan == 'Farmasi' ? 'selected' : '' ?>>Farmasi Klinis dan Komunitas</option>
                        <option value="Kecantikan" <?= $jurusan == 'Kecantikan' ? 'selected' : '' ?>>Tata Kecantikan Kulit dan Rambut</option>
                    </select>
                </div>
            </div>
        </div>

            <hr class="my-4">

            <!-- DATA ORANG TUA -->
        <div class="section-box p-3 mb-4">
            <h5 class="mb-3">Data Orang Tua</h5>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" name="ayah" class="form-control"
                        value="<?= htmlspecialchars($ayah) ?>"
                        placeholder="Nama ayah" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">No HP Ayah</label>
                    <input type="text" name="hp_ayah" class="form-control"
                        value="<?= htmlspecialchars($hp_ayah) ?>"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="ibu" class="form-control"
                        value="<?= htmlspecialchars($ibu) ?>"
                        placeholder="Nama ibu" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">No HP Ibu</label>
                    <input type="text" name="hp_ibu" class="form-control"
                        value="<?= htmlspecialchars($hp_ibu) ?>"
                        placeholder="08xxxxxxxxxx" required>
                </div>
            </div>
        </div>

            <hr class="my-4">

            <!-- MOTIVASI -->
        <div class="section-box p-3 mb-4">
            <h5 class="mb-3">Motivasi</h5>

            <div class="mb-3">
                <textarea name="motivasi" class="form-control" rows="3"
                    placeholder="Ceritakan alasan kamu ingin masuk sekolah ini"><?= htmlspecialchars($motivasi) ?></textarea>
            </div>
        </div>

            <button type="submit" class="btn btn-primary w-100 mt-3 py-2">
                Simpan Data
            </button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>