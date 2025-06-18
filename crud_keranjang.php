<?php // crud_keranjang.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Keranjang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
    footer { background: linear-gradient(135deg, #343a40, #495057); color: white; padding: 10px; text-align: center; }
  </style>
</head>
<body>
  <div class="container my-5">
    <h2 class="text-center mb-4">Kelola Keranjang</h2>
    <div id="keranjangList" class="list-group mb-4"></div>

    <div class="text-center">
      <a href="checkout.php" class="btn btn-primary">← Kembali ke Checkout</a>
    </div>
  </div>

  <footer><p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p></footer>

  <script>
    function renderKeranjang() {
      const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
      const list = document.getElementById("keranjangList");
      list.innerHTML = "";
      keranjang.forEach((item, i) => {
        list.innerHTML += `
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <strong>${item.nama}</strong> - Rp ${item.harga.toLocaleString()} x ${item.jumlah}
            </div>
            <div>
              <button class="btn btn-sm btn-secondary" onclick="ubahJumlah(${i}, -1)">-</button>
              <button class="btn btn-sm btn-secondary" onclick="ubahJumlah(${i}, 1)">+</button>
              <button class="btn btn-sm btn-danger" onclick="hapusItem(${i})">Hapus</button>
            </div>
          </div>
        `;
      });
    }

    function ubahJumlah(index, delta) {
      let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
      keranjang[index].jumlah += delta;
      if (keranjang[index].jumlah <= 0) keranjang.splice(index, 1);
      localStorage.setItem("keranjang", JSON.stringify(keranjang));
      renderKeranjang();
    }

    function hapusItem(index) {
      let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
      keranjang.splice(index, 1);
      localStorage.setItem("keranjang", JSON.stringify(keranjang));
      renderKeranjang();
    }

    window.onload = renderKeranjang;
  </script>
</body>
</html>
