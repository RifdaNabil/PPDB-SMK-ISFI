<?php
$css = "assets/css/index.css";
include 'includes/header.php';
?>

<!-- NAVBAR -->
<nav class="navbar navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <img src="assets/img/logo-isfi.png" alt="logo-isfi" height="50">
      <span class="fw-semibold text-light">SMKS ISFI BANJARMASIN</span>
    </a>
  </div>
</nav>

<!-- HERO -->
<section id="hero" class="vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row align-items-center">

      <!-- LEFT CONTENT -->
      <div class="col-md-6 text-white">
        <h1 class="fw-bold mb-3">
          Wujudkan Masa Depanmu Bersama SMKS ISFI
        </h1>

        <p class="fs-5 mb-4">
          Daftar sekarang dan jadilah bagian dari sekolah yang
          inovatif, kreatif, dan siap menghadapi dunia kerja.
        </p>

        <div class="d-flex gap-3">
          <a href="auth/register.php" class="btn btn-brand-me btn-lg px-4">
            Daftar Sekarang
          </a>
          <a href="auth/login.php" class="btn btn-outline-brand btn-lg px-4">
            Masuk
          </a>
        </div>
      </div>

      <!-- RIGHT ILLUSTRATION -->
      <div class="col-md-6 text-center mt-4 mt-md-0">
        <img src="assets/img/hero.png"
          alt="Ilustrasi siswa"
          class="img-fluid">
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>