<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = $conn->query("
    SELECT p.*, u.nama as user_nama, u.email, 
           b.pas_foto, b.ijazah, b.nilai
    FROM pendaftaran p
    JOIN users u ON p.user_id = u.id
    LEFT JOIN berkas b ON b.pendaftaran_id = p.id
    WHERE p.id='$id'
");

$data = $query->fetch_assoc();
?>

<?php
$css = "../assets/css/form.css";
include '../includes/header.php';
?>

<!-- NAVBAR -->
<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard_admin.php">
            <img src="../assets/img/logo-isfi.png" height="50">
            <span class="fw-semibold text-light">SMKS ISFI BANJARMASIN</span>
        </a>
    </div>
</nav>

<div class="content">

<div class="card shadow-sm form-card p-4">

<!-- HEADER -->
<div class="mb-4 p-3 rounded-3 header-form text-center">
    <h4 class="fw-bold mb-1">Detail Pendaftar</h4>
    <p class="mb-0 small">Informasi lengkap calon siswa</p>
</div>

<!-- DATA DIRI -->
<div class="section-box p-3 mb-4">
<h5 class="mb-3">Data Diri</h5>

<div class="row g-3">

<div class="col-md-6">
<label>Nama</label>
<input class="form-control" value="<?= $data['nama'] ?>" readonly>
</div>

<div class="col-md-6">
<label>Jenis Kelamin</label>
<input class="form-control" value="<?= $data['jk']=='L'?'Laki-laki':'Perempuan' ?>" readonly>
</div>

<div class="col-md-6">
<label>Tempat Lahir</label>
<input class="form-control" value="<?= $data['tempat_lahir'] ?>" readonly>
</div>

<div class="col-md-6">
<label>Tanggal Lahir</label>
<input class="form-control" value="<?= $data['tanggal_lahir'] ?>" readonly>
</div>

<div class="col-md-6">
<label>Agama</label>
<input class="form-control" value="<?= $data['agama'] ?>" readonly>
</div>

<div class="col-md-6">
<label>No HP</label>
<input class="form-control" value="<?= $data['no_hp'] ?>" readonly>
</div>

<div class="col-md-12">
<label>Alamat</label>
<textarea class="form-control" readonly><?= $data['alamat'] ?></textarea>
</div>

</div>
</div>

<!-- DATA SEKOLAH -->
<div class="section-box p-3 mb-4">
<h5 class="mb-3">Data Sekolah</h5>

<div class="row g-3">

<div class="col-md-6">
<label>Asal Sekolah</label>
<input class="form-control" value="<?= $data['asal_sekolah'] ?>" readonly>
</div>

<div class="col-md-6">
<label>Jurusan</label>
<input class="form-control" value="<?= $data['jurusan'] ?>" readonly>
</div>

</div>
</div>

<!-- ORANG TUA -->
<div class="section-box p-3 mb-4">
<h5 class="mb-3">Data Orang Tua</h5>

<div class="row g-3">

<div class="col-md-6">
<label>Nama Ayah</label>
<input class="form-control" value="<?= $data['ayah'] ?>" readonly>
</div>

<div class="col-md-6">
<label>HP Ayah</label>
<input class="form-control" value="<?= $data['hp_ayah'] ?>" readonly>
</div>

<div class="col-md-6">
<label>Nama Ibu</label>
<input class="form-control" value="<?= $data['ibu'] ?>" readonly>
</div>

<div class="col-md-6">
<label>HP Ibu</label>
<input class="form-control" value="<?= $data['hp_ibu'] ?>" readonly>
</div>

</div>
</div>

<!-- MOTIVASI -->
<div class="section-box p-3 mb-4">
<h5 class="mb-3">Motivasi</h5>
<textarea class="form-control" readonly><?= $data['motivasi'] ?></textarea>
</div>

<!-- STATUS -->
<div class="section-box p-3 mb-4">
<h5 class="mb-3">Status</h5>

<?php if($data['status'] == 'lulus'): ?>
    <span class="badge bg-success">Lulus</span>

<?php elseif($data['status'] == 'tidak lulus'): ?>
    <span class="badge bg-danger">Tidak Lulus</span>

<?php elseif($data['status'] == 'menunggu'): ?>
    <span class="badge bg-warning text-dark">Menunggu</span>

<?php else: ?>
    <span class="badge bg-secondary">Belum</span>
<?php endif; ?>

</div>

<!-- BERKAS -->
<div class="section-box p-3">
<h5 class="mb-3">Berkas</h5>

<div class="row">

<div class="col-md-4 text-center">
<p>Pas Foto</p>
<img src="../uploads/pas_foto/<?= $data['pas_foto'] ?>" width="120" class="rounded">
</div>

<div class="col-md-4 text-center">
<p>Ijazah</p>
<?php if($data['ijazah']): ?>
<a href="../uploads/ijazah/<?= $data['ijazah'] ?>" target="_blank" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-file-earmark"></i> Lihat
</a>
<?php else: ?>
<span class="text-muted">Tidak ada</span>
<?php endif; ?>
</div>

<div class="col-md-4 text-center">
<p>Nilai</p>
<?php if($data['nilai']): ?>
<a href="../uploads/nilai/<?= $data['nilai'] ?>" target="_blank" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-file-earmark"></i> Lihat
</a>
<?php else: ?>
<span class="text-muted">Tidak ada</span>
<?php endif; ?>
</div>

</div>

</div>

</div>
</div>

<?php include '../includes/footer.php'; ?>