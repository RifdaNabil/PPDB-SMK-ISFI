<?php
session_start();
include_once '../config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// AMBIL DATA FORM
$nama = $_POST['nama'];
$jk = $_POST['jk'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$agama = $_POST['agama'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$asal_sekolah = $_POST['asal_sekolah'];
$jurusan = $_POST['jurusan'];
$ayah = $_POST['ayah'];
$hp_ayah = $_POST['hp_ayah'];
$ibu = $_POST['ibu'];
$hp_ibu = $_POST['hp_ibu'];
$motivasi = $_POST['motivasi'];

// CEK SUDAH PERNAH ISI ATAU BELUM
$cek = $conn->prepare("SELECT id FROM pendaftaran WHERE user_id=?");
$cek->bind_param("i", $user_id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {

    // UPDATE
    $stmt = $conn->prepare("UPDATE pendaftaran SET 
        nama=?, jk=?, tempat_lahir=?, tanggal_lahir=?, agama=?, no_hp=?, alamat=?, 
        asal_sekolah=?, jurusan=?, ayah=?, hp_ayah=?, ibu=?, hp_ibu=?, motivasi=? 
        WHERE user_id=?");

    $stmt->bind_param(
        "ssssssssssssssi",
        $nama,
        $jk,
        $tempat_lahir,
        $tanggal_lahir,
        $agama,
        $no_hp,
        $alamat,
        $asal_sekolah,
        $jurusan,
        $ayah,
        $hp_ayah,
        $ibu,
        $hp_ibu,
        $motivasi,
        $user_id
    );

} else {

    // INSERT
    $stmt = $conn->prepare("INSERT INTO pendaftaran (
        user_id, nama, jk, tempat_lahir, tanggal_lahir, agama, no_hp, alamat,
        asal_sekolah, jurusan, ayah, hp_ayah, ibu, hp_ibu, motivasi, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'menunggu')");

    $stmt->bind_param(
        "issssssssssssss",
        $user_id,
        $nama,
        $jk,
        $tempat_lahir,
        $tanggal_lahir,
        $agama,
        $no_hp,
        $alamat,
        $asal_sekolah,
        $jurusan,
        $ayah,
        $hp_ayah,
        $ibu,
        $hp_ibu,
        $motivasi
    );
}

// EKSEKUSI
if ($stmt->execute()) {
    header("Location: dashboard_siswa.php?success=1");
    exit();
} else {
    echo "Gagal menyimpan data: " . $conn->error;
}
?>