<?php
session_start();
// CEK KALAU SUDAH LOGIN
if (isset($_SESSION['user_id'])) {
    header("Location: ../siswa/dashboard_siswa.php");
    exit();
}

//KONEKSI DATABASE
include_once '../config/database.php';

// INISIALISASI ERROR DAN SUCCESS MESSAGE
$message = "";
$message_class = "";
$email = '';

// PROSES LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // AMBIL DATA DARI FORM
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'];

    // VALIDASI DATA
    if (empty($email) || empty($password)) {
        $message = "Email dan Password harus diisi!";
        $message_class = "alert-danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid!";
        $message_class = "alert-danger";
    } else {
        // CHECK EMAIL DI DATABASE
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='siswa'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows === 1) {

            $user = $check->fetch_assoc();

            // VERIFIKASI PASSWORD
            if (password_verify($password, $user['password'])) {

                // SIMPAN SESSION
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // REDIRECT KE DASHBOARD SISWA
                $message = "Login Berhasil! Mengalihkan Ke Dashboard Siswa...";
                $message_class = "alert-success";
                header("Location: ../siswa/dashboard_siswa.php");
                exit();
            } else {
                $message = "Password salah!";
                $message_class = "alert-danger";
            }
        } else {
            $message = "Email tidak ditemukan!";
            $message_class = "alert-danger";
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

<section id="masuk" class="vh-100 d-flex align-items-center justify-content-center">
    <div class="container d-flex justify-content-center">

        <div class="card p-4 rounded-4 shadow text-center" style="max-width: 400px; width:100%;">

            <!-- LOGO -->
            <div class="mb-3">
                <img src="../assets/img/logo-isfi.png" alt="logo" style="height:70px;">
            </div>

            <!-- TITLE -->
            <h2 class="fw-bold">Selamat Datang</h2>
            <p class="text-muted mb-4">
                Masuk untuk melanjutkan pendaftaranmu
            </p>

            <?php if ($message): ?>
                <div class="alert <?php echo $message_class; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form method="POST">

                <div class="mb-3 text-start">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="contoh@gmail.com" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan Password Kamu" required>
                </div>

                <button class="btn btn-regis w-100 py-2">
                    Masuk
                </button>

            </form>

            <!-- LINK -->
            <p class="mt-3">
                Belum punya akun?
                <a href="register.php" class="login-link">Daftar</a>
            </p>

        </div>

    </div>
</section>

<?php include '../includes/footer.php'; ?>