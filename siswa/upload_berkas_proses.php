<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// AMBIL PENDAFTARAN
$stmt = $conn->prepare("SELECT id FROM pendaftaran WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: form_ppdb.php");
    exit();
}

$pendaftaran_id = $data['id'];

// ================= PAS FOTO =================
$pas_foto_name = null;

if ($_FILES['pas_foto']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['pas_foto']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg','jpeg','png'])) {
        header("Location: upload_berkas.php?error=format");
        exit();
    }

    if ($_FILES['pas_foto']['size'] > 5 * 1024 * 1024) {
        header("Location: upload_berkas.php?error=size");
        exit();
    }

    $pas_foto_name = time().'_foto.'.$ext;

    move_uploaded_file(
        $_FILES['pas_foto']['tmp_name'],
        "../uploads/pas_foto/".$pas_foto_name
    );
}

// ================= IJAZAH =================
$ijazah_name = null;

if ($_FILES['ijazah']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['ijazah']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg','jpeg','png','pdf'])) {
        header("Location: upload_berkas.php?error=ijazah_format");
        exit();
    }

    $ijazah_name = time().'_ijazah.'.$ext;

    move_uploaded_file(
        $_FILES['ijazah']['tmp_name'],
        "../uploads/ijazah/".$ijazah_name
    );
}

// ================= NILAI =================
$nilai_name = null;

if ($_FILES['nilai']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['nilai']['name'], PATHINFO_EXTENSION));

    if ($ext !== 'pdf') {
        header("Location: upload_berkas.php?error=nilai_format");
        exit();
    }

    $nilai_name = time().'_nilai.pdf';

    move_uploaded_file(
        $_FILES['nilai']['tmp_name'],
        "../uploads/nilai/".$nilai_name
    );
}

// ================= CEK DATA =================
$cek = $conn->prepare("SELECT id FROM berkas WHERE pendaftaran_id=?");
$cek->bind_param("i", $pendaftaran_id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {

    $stmt = $conn->prepare("UPDATE berkas SET pas_foto=?, ijazah=?, nilai=? WHERE pendaftaran_id=?");
    $stmt->bind_param("sssi", $pas_foto_name, $ijazah_name, $nilai_name, $pendaftaran_id);

} else {

    $stmt = $conn->prepare("INSERT INTO berkas (pendaftaran_id, pas_foto, ijazah, nilai) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $pendaftaran_id, $pas_foto_name, $ijazah_name, $nilai_name);
}

// EKSEKUSI
if ($stmt->execute()) {
    header("Location: dashboard_siswa.php?upload=success");
} else {
    header("Location: upload_berkas.php?error=gagal");
}
exit();