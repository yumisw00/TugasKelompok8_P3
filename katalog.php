<?php
// katalog.php
include 'koneksi.php'; // file koneksi ke database
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katalog Produk - Toko Bu Sarpi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .produk {
      border: 1px solid #ddd;
      border-radius: 15px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      transition: transform 0.3s;
    }
    .produk:hover {
      transform: translateY(-5px);
    }
    .produk img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .produk h3 {
      margin-top: 15px;
      font-size: 1.2rem;
    }
    .produk p {
      color: #333;
      margin: 10px 0;
    }
    .produk button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
    }
    .produk button:hover {
      background-color: #0056b3;
    }
    footer {
      background: linear-gradient(135deg, #343a40, #495057);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Kelontong Bu Sarpi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link active" href="katalog.php">Katalog</a></li>
        <li class="nav-item"><a class="nav-link" href="checkout.php">Checkout</a></li>
        <li class="nav-item"><a class="nav-link" href="tentangkami.php">tentangkami</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<header class="custom-header text-white text-center py-5" style="background: linear-gradient(135deg, #007bff, #00c6ff);">
  <h1 class="display-5">Katalog Produk</h1>
  <p class="lead">Produk-produk terbaik dari Toko Bu Sarpi</p>
</header>

<!-- Input Pencarian -->
<!-- Tombol Kelola Produk + Input Pencarian -->
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div></div>
    <a href="crud_produk.php" class="btn btn-warning">Kelola Produk</a>
  </div>
  <input type="text" id="cariProduk" class="form-control" placeholder="Cari produk...">
</div>

<!-- Katalog Produk -->
<div class="container my-4">
  <div class="row g-4" id="produkContainer">
    <?php
    $query = "SELECT * FROM barang ORDER BY nama_barang ASC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
        $nama = $row['nama_barang'];
        $harga = $row['harga_jual'];
        $gambar = $row['gambar'] ?? 'gambar/default.jpg'; // gunakan default jika kolom gambar kosong
    ?>
    <div class="col-md-3 col-sm-6 produk-item">
      <div class="produk text-center">
        <img src="<?= $gambar ?>" alt="<?= htmlspecialchars($nama) ?>">
        <h3><?= htmlspecialchars($nama) ?></h3>
        <p>Rp <?= number_format($harga, 0, ',', '.') ?></p>
        <button onclick='tambahKeKeranjang(<?= json_encode(["nama" => $nama, "harga" => $harga, "gambar" => $gambar]) ?>)'>Tambah Ke Keranjang</button>
      </div>
    </div>
    <?php
      endwhile;
    else:
    ?>
      <p class="text-center">Produk tidak tersedia.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Footer -->
<footer class="text-white text-center py-4 mt-5">
  <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
</footer>

<script>
  function tambahKeKeranjang(produk) {
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    keranjang.push(produk);
    localStorage.setItem('keranjang', JSON.stringify(keranjang));
    alert(${produk.nama} ditambahkan ke keranjang!);
  }

  // Filter produk lokal di halaman (JS hanya menyembunyikan, bukan mengambil ulang dari server)
  document.getElementById('cariProduk').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const items = document.querySelectorAll('.produk-item');

    items.forEach(item => {
      const namaProduk = item.querySelector('h3').textContent.toLowerCase();
      item.style.display = namaProduk.includes(keyword) ? 'block' : 'none';
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
