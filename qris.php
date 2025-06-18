<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran QRIS - Toko Bu Sarpi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
    }
    .custom-header {
      background: linear-gradient(135deg, #007bff, #00c6ff);
      animation: fadeIn 1.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .payment-container {
      max-width: 400px;
      margin: 40px auto;
      padding: 25px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .hidden { display: none; }
    footer {
      background: linear-gradient(135deg, #343a40, #495057);
      color: white;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Kelontong Bu Sarpi</a>
  </div>
</nav>

<header class="custom-header text-white text-center py-5">
  <h1 class="display-4">Pembayaran QRIS</h1>
  <p class="lead">Scan QR Code untuk membayar</p>
</header>

<div class="container my-5">
  <div class="payment-container">
    <h2>QRIS</h2>
    <p class="text-muted">Total Pembayaran:</p>
    <h4 id="totalHarga" class="text-success">Rp 0</h4>
    <div class="my-3 d-flex justify-content-center" id="qrcode"></div>
    <button class="btn btn-primary w-100 mt-3" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
    <div id="notification" class="alert alert-success hidden mt-3">
      ✅ Pembayaran berhasil! Anda akan diarahkan ke halaman transaksi.
    </div>
  </div>
</div>

<footer class="text-center py-3">
  <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
</footer>

<script>
  let total = parseInt(localStorage.getItem("totalHarga")) || 0;
  document.getElementById("totalHarga").innerText = "Rp " + total.toLocaleString("id-ID");

  let qrisData = "https://qris.id/bayar?toko=TokoBuSarpi&jumlah=" + total;
  new QRCode(document.getElementById("qrcode"), {
    text: qrisData,
    width: 200,
    height: 200
  });

  function confirmPayment() {
  document.getElementById("notification").classList.remove("hidden");
  let button = document.querySelector("button");
  button.classList.remove("btn-primary");
  button.classList.add("btn-success");
  button.innerText = "Pembayaran Berhasil";

  setTimeout(() => {
    localStorage.removeItem("totalHarga");
    window.location.href = "transaksi.php";
  }, 3000);
}
</script>
</body>
</html>
