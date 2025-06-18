<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $nama = trim($_POST['nama_barang']);
        $harga = (int)$_POST['harga_jual'];
        $gambar = 'gambar/default.jpg';

        if (!empty($_FILES['gambar']['name'])) {
            $targetDir = 'gambar/';
            $targetFile = $targetDir . time() . '_' . basename($_FILES['gambar']['name']);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $targetFile;
            }
        }

        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, harga_jual, gambar) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama, $harga, $gambar);
        $stmt->execute();
        $stmt->close();
        header("Location: crud_produk.php");
        exit;
    }

    if (isset($_POST['update'])) {
        $id = (int)$_POST['id_barang'];
        $nama = trim($_POST['nama_barang']);
        $harga = (int)$_POST['harga_jual'];
        $gambar = $_POST['gambar_lama'];

        if (!empty($_FILES['gambar']['name'])) {
            $targetDir = 'gambar/';
            $targetFile = $targetDir . time() . '_' . basename($_FILES['gambar']['name']);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $targetFile;
            }
        }

        $stmt = $conn->prepare("UPDATE barang SET nama_barang=?, harga_jual=?, gambar=? WHERE id_barang=?");
        $stmt->bind_param("sisi", $nama, $harga, $gambar, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: crud_produk.php");
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM barang WHERE id_barang=$id");
    header("Location: crud_produk.php");
    exit;
}

$produk = $conn->query("SELECT * FROM barang ORDER BY id_barang DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Produk - Toko Bu Sarpi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-backdrop.show { opacity: .15 !important; }
        .modal-content {
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            border: none;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-4">Manajemen Produk</h2>

    <!-- Form Tambah -->
    <div class="card mb-5">
        <div class="card-header fw-bold">Tambah Produk</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary mt-3">Simpan</button>
            </form>

            <div class="text-end mt-3">
                <a href="katalog.php" class="btn btn-primary">&larr; Kembali ke Katalog</a>
            </div>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="table-responsive bg-white rounded-3 shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-secondary text-center">
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Harga Jual</th>
                    <th>Gambar</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($produk->num_rows): $no=1; ?>
                <?php while ($row = $produk->fetch_assoc()): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td class="text-center">
                        <img src="<?= $row['gambar'] ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px">
                    </td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_barang'] ?>">Edit</button>
                        <a href="?hapus=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center py-4">Belum ada data.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit Produk: Ditempatkan DI LUAR TABEL -->
    <?php
    $produk->data_seek(0); // ulangi pointer hasil query
    while ($row = $produk->fetch_assoc()):
    ?>
    <div class="modal fade" id="editModal<?= $row['id_barang'] ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title w-100 text-center fw-semibold">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-1 px-4">
                    <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_barang" class="form-control rounded-2 shadow-sm" value="<?= htmlspecialchars($row['nama_barang']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control rounded-2 shadow-sm" value="<?= $row['harga_jual'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4">
                    <button class="btn btn-primary px-4" name="update" type="submit">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
