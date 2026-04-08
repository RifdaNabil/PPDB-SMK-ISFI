<?php
$css = "assets/css/index.css";
include 'includes/header.php';
?>

<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<nav class="navbar navbar-dark shadow-sm">
  <div class="container d-flex justify-content-between">

    <a class="navbar-brand d-flex align-items-center gap-2">
      <img src="assets/img/logo-isfi.png" height="50">
      <span class="text-white fw-semibold">SMKS ISFI</span>
    </a>

    <div>
      <a href="auth/login.php" class="btn btn-outline-light btn-sm me-2">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </a>
      <a href="auth/register.php" class="btn btn-light btn-sm">
        <i class="bi bi-person-plus"></i> Daftar Sekarang
      </a>
    </div>

  </div>
</nav>

<section id="hero" class="vh-100 d-flex align-items-center">
<div class="container">

<div class="row align-items-center">

<div class="col-md-6 text-white" data-aos="fade-right">

<h1 class="fw-bold mb-3">
Wujudkan Masa Depanmu Bersama SMKS ISFI
</h1>

<p class="fs-5 mb-4">
Portal resmi penerimaan peserta didik baru.
</p>

<a href="auth/register.php" class="btn btn-brand-me me-2">
Daftar Sekarang Juga
</a>

<a href="auth/login.php" class="btn btn-outline-brand">
Masuk
</a>

</div>

<div class="col-md-6 text-center" data-aos="fade-left">
<img src="assets/img/hero.png" class="img-fluid">
</div>

</div>

</div>
</section>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 800 });
</script>

<?php include 'includes/footer.php'; ?>