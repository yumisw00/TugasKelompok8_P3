<?php
$teamMembers = [
    [
        'nama' => 'Bu Sarpi',
        'peran' => 'Pemilik & Pendiri',
        'foto' => 'gambar/download5.webp' // Ganti jika ingin pakai yang baru
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang Kami – Kelontong Bu Sarpi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      color: #212529;
    }
    .section-title {
      font-weight: bold;
      font-size: 2.5rem;
      color: #007bff;
    }
    .member-wrapper {
      display: flex;
      justify-content: center; /* Posisi kartu di tengah halaman */
    }
    .member-card {
      border: none;
      border-radius: 20px;
      background: #e3f2fd;
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1);
      transition: 0.3s ease-in-out;
      text-align: center;
      width: 300px;
    }
    .member-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
    }
    .member-photo {
      width: 160px;
      height: 160px;
      object-fit: cover;
      border-radius: 50%;
      margin: 20px auto 10px;
      display: block;
    }
    footer {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="home.php">Kelontong Bu Sarpi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
        <li class="nav-item"><a class="nav-link" href="checkout.php">Checkout</a></li>
        <li class="nav-item"><a class="nav-link active" href="tentang_kami.php">Tentang Kami</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<header class="text-center py-5 bg-white">
  <h1 class="section-title mb-3">Tentang Kelontong Bu Sarpi</h1>
  <p class="mx-auto" style="max-width: 750px;">
    Sejak 1998, Kelontong Bu Sarpi hadir untuk memenuhi kebutuhan harian masyarakat dengan harga terjangkau,
    pelayanan ramah, dan produk lengkap dari dapur hingga kebutuhan sehari-hari. Sekarang hadir juga dalam bentuk website TokoBuSarpi!
  </p>
</header>

<!-- TIM KAMI -->
<section class="container py-5">
  <div class="member-wrapper">
    <?php foreach ($teamMembers as $member): ?>
      <div class="card member-card">
        <img src="<?= htmlspecialchars($member['foto']) ?>" alt="<?= htmlspecialchars($member['nama']) ?>" class="member-photo">
        <div class="card-body">
          <h5 class="card-title fw-bold"><?= htmlspecialchars($member['nama']) ?></h5>
          <p class="card-text text-muted"><?= htmlspecialchars($member['peran']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- FOOTER -->
<footer class="text-center py-4">
  <p class="mb-1 fw-semibold">Kelontong Bu Sarpi &copy; <?= date('Y') ?></p>
  <small>Jl. Panglima Sudirman No.21, Madiun • Telp: (+62) 812-3456-7890</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

