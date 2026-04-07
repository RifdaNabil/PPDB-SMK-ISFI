<?php
//KONEKSI DATABASE
include_once '../config/database.php';


// INISIALISASI
$message = "";
$message_class = "";
$nama = '';
$email = '';

// PROSES REGISTRASI
if (($_SERVER['REQUEST_METHOD']) === 'POST') {

    // AMBIL DATA DARI FORM
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // VALIDASI DATA
    if (empty($nama) || empty($email) || empty($password) || empty($password_confirm)) {
        $message = "Semua field harus diisi!";
        $message_class = "alert-danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid!";
        $message_class = "alert-danger";
    } elseif ($password !== $password_confirm) {
        $message = "Password tidak cocok!";
        $message_class = "alert-danger";
    } else {
        // CEK APAKAH EMAIL SUDAH TERDAFTAR
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows > 0) {
            $message = "Email sudah terdaftar!";
            $message_class = "alert-danger";
        } else {
            // ENKRIPSI PASSWORD AGAR LEBIH AMAN
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            // SIMPAN DATA KE DATABASE
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'siswa')");
            $stmt->bind_param("sss", $nama, $email, $pass_hash);
            $insert = $stmt->execute();

            // KALAU SUKSES REDIRECT KE HALAMAN LOGIN
            if ($insert) {
                $message = "Pendaftaran Berhasil! Mengalihkan Ke Login...";
                $message_class = "alert-success";
                header("refresh:2;url=login.php");
                // KALAU GAGAL 
            } else {
                $message = "Terjadi kesalahan :" . $conn->error;
                $message_class = "alert-danger";
            }
        }
    }
}
?>

<?php
$css = "../assets/css/auth.css";
include '../includes/header.php';
?>

<!-- NAVBAR -->
<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="../index.php">
            <img src="../assets/img/logo-isfi.png" alt="logo-isfi" height="50">
            <span class="fw-semibold text-light">SMKS ISFI BANJARMASIN</span>
        </a>
    </div>
</nav>

<section id="daftar" class="vh-100 d-flex align-items-center justify-content-center">
    <div class="container d-flex justify-content-center">

        <div class="card p-4 rounded-4 shadow text-center" style="max-width: 400px; width:100%;">

            <!-- LOGO -->
            <div class="mb-3">
                <img src="../assets/img/logo-isfi.png" alt="logo" style="height:70px;">
            </div>

            <!-- TITLE -->
            <h2 class="fw-bold">Buat Akun</h2>
            <p class="text-muted mb-4">
                Mulai pendaftaranmu di SMKS ISFI
            </p>

            <?php if ($message): ?>
                <div class="alert <?php echo $message_class; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form method="POST">

                <div class="mb-3 text-start">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($nama) ?>" placeholder="Masukkan Nama Lengkap Kamu" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="contoh@gmail.com" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan Password Kamu" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirm" placeholder="Konfirmasi Password Kamu" required>
                </div>

                <button type="submit" class="btn btn-regis w-100 py-2">
                    Daftar Sekarang
                </button>

            </form>

            <!-- LINK -->
            <p class="mt-3">
                Sudah punya akun?
                <a href="login.php" class="login-link">Masuk</a>
            </p>

        </div>

    </div>
</section>

<?php include '../includes/footer.php'; ?>