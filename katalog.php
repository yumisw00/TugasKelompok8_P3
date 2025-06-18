<?php // katalog.php ?>
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
<div class="container mt-4">
  <input type="text" id="cariProduk" class="form-control" placeholder="Cari produk...">
</div>

<!-- Katalog Produk -->
<div class="container my-4">
  <div class="row g-4" id="produkContainer">
    <!-- Produk akan dimuat melalui JavaScript -->
  </div>
</div>

<!-- Footer -->
<footer class="text-white text-center py-4 mt-5">
  <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
</footer>

<script>
  const produkList = [
    { nama: "Minyak Goreng", harga: 17500, gambar: "gambar/Minyak_Goreng.jpg" },
    { nama: "Indomie", harga: 3500, gambar: "gambar/Indomie.jpg" },
    { nama: "Gula", harga: 15000, gambar: "gambar/Gula.jpg" },
    { nama: "Susu", harga: 4500, gambar: "gambar/Susu.jpeg" },
    { nama: "Sirup", harga: 18000, gambar: "gambar/sirup.jpg" },
    { nama: "Kecap", harga: 3000, gambar: "gambar/kecap.jpeg" },
    { nama: "Saus", harga: 8000, gambar: "gambar/saus.jpg" },
    { nama: "Royco", harga: 2000, gambar: "gambar/royco.jpg" }
  ];

  const produkContainer = document.getElementById('produkContainer');
  const inputCari = document.getElementById('cariProduk');

  function tampilkanProduk(filter = "") {
    produkContainer.innerHTML = "";
    const hasil = produkList.filter(p =>
      p.nama.toLowerCase().includes(filter.toLowerCase())
    );

    if (hasil.length === 0) {
      produkContainer.innerHTML = "<p class='text-center'>Produk tidak ditemukan.</p>";
      return;
    }

    hasil.forEach(produk => {
      const col = document.createElement('div');
      col.className = 'col-md-3 col-sm-6';
      col.innerHTML = `
        <div class="produk text-center">
          <img src="${produk.gambar}" alt="${produk.nama}">
          <h3>${produk.nama}</h3>
          <p>Rp ${produk.harga.toLocaleString('id-ID')}</p>
          <button onclick='tambahKeKeranjang(${JSON.stringify(produk)})'>Tambah Ke Keranjang</button>
        </div>
      `;
      produkContainer.appendChild(col);
    });
  }

  function tambahKeKeranjang(produk) {
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    keranjang.push(produk);
    localStorage.setItem('keranjang', JSON.stringify(keranjang));
    alert(`${produk.nama} ditambahkan ke keranjang!`);
  }

  // Inisialisasi awal
  tampilkanProduk();

  // Event: pencarian
  inputCari.addEventListener('input', () => {
    tampilkanProduk(inputCari.value);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
