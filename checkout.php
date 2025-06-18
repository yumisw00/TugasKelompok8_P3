<?php // checkout.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Toko Bu Sarpi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
    .custom-header { background: linear-gradient(135deg, #007bff, #00c6ff); color: white; padding: 20px; text-align: center; }
    .product-card { background: #cce5ff; border-radius: 10px; padding: 15px; text-align: center; }
    .product-image img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
    footer { background: linear-gradient(135deg, #343a40, #495057); color: white; text-align: center; padding: 10px 0; }
  </style>
</head>
<body>

<!-- Navbar -->
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
        <li class="nav-item"><a class="nav-link active" href="checkout.php">Checkout</a></li>
        <li class="nav-item"><a class="nav-link" href="tentangkami.php">tentangkami</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<header class="custom-header">
  <h1>Checkout Produk</h1>
  <p>Pastikan produk yang Anda beli sesuai</p>
</header>

<!-- Keranjang Produk -->
<div class="container my-5">
  <h2 class="text-center mb-4">Produk di Keranjang</h2>
  <div class="text-end mb-3">
    <a href="crud_keranjang.php" class="btn btn-warning">Kelola Keranjang</a>
  </div>
  <div class="row g-4" id="keranjangContainer"></div>

  <h3 class="mt-5">Detail Pembeli</h3>
  <form id="checkoutForm">
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" class="form-control" id="nama" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <input type="text" class="form-control" id="alamat" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Metode Pembayaran</label>
      <select class="form-control" id="paymentMethod">
        <option value="qris">QRIS</option>
        <option value="cod">COD</option>
      </select>
    </div>
    <button type="button" class="btn btn-success w-100" onclick="processPayment()">Checkout Sekarang</button>
  </form>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
  const container = document.getElementById('keranjangContainer');

  function tampilkanKeranjang() {
    container.innerHTML = "";
    if (keranjang.length === 0) {
      container.innerHTML = '<p class="text-center text-muted">Keranjang masih kosong.</p>';
      return;
    }

    keranjang.forEach((produk, index) => {
      const col = document.createElement('div');
      col.className = 'col-md-3';
      col.innerHTML = `
        <div class="card product-card">
          <div class="product-image"><img src="${produk.gambar}" alt="${produk.nama}"></div>
          <h5>${produk.nama}</h5>
          <p>Rp ${produk.harga.toLocaleString('id-ID')}</p>
          <button class="btn btn-danger btn-sm mt-2" onclick="hapusItem(${index})">Hapus</button>
        </div>
      `;
      container.appendChild(col);
    });
  }

  function hapusItem(index) {
    if (confirm("Hapus produk ini dari keranjang?")) {
      keranjang.splice(index, 1);
      localStorage.setItem("keranjang", JSON.stringify(keranjang));
      tampilkanKeranjang();
    }
  }

  function processPayment() {
    const nama = document.getElementById("nama").value.trim();
    const alamat = document.getElementById("alamat").value.trim();
    const paymentMethod = document.getElementById("paymentMethod").value;

    if (!nama || !alamat) {
      alert("Silakan lengkapi data pembeli.");
      return;
    }

    if (keranjang.length === 0) {
      alert("Keranjang kosong. Silakan pilih produk terlebih dahulu.");
      return;
    }

    // Tambahkan jumlah default jika belum ada
    const keranjangFinal = keranjang.map(item => ({
      ...item,
      jumlah: item.jumlah || 1
    }));

    const totalHarga = keranjangFinal.reduce((acc, item) => acc + (item.harga * item.jumlah), 0);
    localStorage.setItem("totalHarga", totalHarga);

    const dataTransaksi = {
      pembeli: { nama, alamat, metode: paymentMethod },
      keranjang: keranjangFinal
    };

    localStorage.setItem("dataTransaksi", JSON.stringify(dataTransaksi));

    // Kirim ke server
    fetch("simpan_transaksi.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(dataTransaksi)
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        localStorage.removeItem("keranjang");
        window.location.href = paymentMethod === "qris" ? "qris.php" : "transaksi.php";
      } else {
        alert("Gagal menyimpan transaksi ke database.");
      }
    })
    .catch(() => {
      alert("Terjadi kesalahan saat menyimpan.");
    });
  }

  tampilkanKeranjang();
</script>
</body>
</html>
