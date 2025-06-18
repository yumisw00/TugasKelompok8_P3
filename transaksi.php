<?php // transaksi.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Struk Transaksi - Toko Bu Sarpi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .custom-header {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        .container-box {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .btn-area {
            margin-top: 20px;
        }
        footer {
            background: linear-gradient(135deg, #343a40, #495057);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }
       @media print {
  * {
    -webkit-print-color-adjust: exact !important; /* agar warna tetap tampil saat print */
    print-color-adjust: exact !important;
  }

  body {
    background: white !important;
  }

  .custom-header {
    background: linear-gradient(135deg, #007bff, #00c6ff) !important;
    color: white !important;
  }

  .btn-area, nav, footer {
    display: none !important; /* sembunyikan tombol dan navbar saat cetak */
  }

  .container-box {
    box-shadow: none !important;
    margin-top: 0 !important;
  }

  th {
    background-color: #007bff !important;
    color: white !important;
  }

  .success-message {
    color: green !important;
  }
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="home.php">Kelontong Bu Sarpi</a>
    </div>
</nav>

<header class="custom-header">
    <h1>Struk Transaksi</h1>
    <p>Terima kasih telah berbelanja di Toko Bu Sarpi</p>
</header>

<div class="container-box" id="transaksiArea">
    <div id="dataPembeli" class="mb-3"></div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan (Rp)</th>
                <th>Jumlah</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody id="transactionBody"></tbody>
    </table>

    <h4 class="mt-4" id="grandTotal">Total Pembayaran: Rp 0</h4>

    <div class="d-flex align-items-center mt-3">
        <span class="success-message">Pembayaran Berhasil melalui QRIS ✅</span>
    </div>

    <div class="btn-area mt-3">
        <a href="home.php" class="btn btn-outline-primary">⬅ Kembali ke Beranda</a>
        <button class="btn btn-success" onclick="window.print()">🖨️ Cetak Struk</button>
    </div>
</div>

<footer>
    <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
</footer>

<script>
    const data = JSON.parse(localStorage.getItem('dataTransaksi')) || {};
    const cart = data.keranjang || [];
    const pembeli = data.pembeli || {};
    let totalPayment = 0;

    function displayTransaction() {
        const transactionBody = document.getElementById('transactionBody');
        const grandTotal = document.getElementById('grandTotal');
        const dataPembeli = document.getElementById('dataPembeli');

        if (Object.keys(pembeli).length > 0) {
            dataPembeli.innerHTML = `
                <p><strong>Nama:</strong> ${pembeli.nama}</p>
                <p><strong>Alamat:</strong> ${pembeli.alamat}</p>
                <p><strong>Metode Pembayaran:</strong> ${pembeli.metode?.toUpperCase()}</p>
            `;
        }

        if (cart.length === 0) {
            transactionBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Tidak ada data transaksi.</td></tr>';
            grandTotal.textContent = "Total Pembayaran: Rp 0";
            return;
        }

        cart.forEach(item => {
            const jumlah = item.jumlah || 1;
            const total = item.harga * jumlah;
            totalPayment += total;

            transactionBody.innerHTML += `
                <tr>
                    <td>${item.nama}</td>
                    <td>${item.harga.toLocaleString('id-ID')}</td>
                    <td>${jumlah}</td>
                    <td>${total.toLocaleString('id-ID')}</td>
                </tr>
            `;
        });

        grandTotal.textContent = "Total Pembayaran: Rp " + totalPayment.toLocaleString('id-ID');
    }

    displayTransaction();
</script>

</body>
</html>
