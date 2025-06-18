<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);
$nama = $data['pembeli']['nama'];
$alamat = $data['pembeli']['alamat'];
$metode = $data['pembeli']['metode'];
$keranjang = $data['keranjang'];

mysqli_begin_transaction($conn);

try {
    // Simpan ke tabel penjualan
    $stmt = $conn->prepare("INSERT INTO penjualan (nama_pembeli, alamat, metode, tanggal) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $nama, $alamat, $metode);
    $stmt->execute();
    $id_penjualan = $conn->insert_id;

    // Simpan ke tabel detail_penjualan
    $stmt_detail = $conn->prepare("INSERT INTO detail_penjualan (id_penjualan, nama_produk, harga, jumlah) VALUES (?, ?, ?, ?)");

    foreach ($keranjang as $item) {
        $jumlah = isset($item["jumlah"]) ? $item["jumlah"] : 1;
        $stmt_detail->bind_param("isii", $id_penjualan, $item["nama"], $item["harga"], $jumlah);
        $stmt_detail->execute();
    }

    mysqli_commit($conn);
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
