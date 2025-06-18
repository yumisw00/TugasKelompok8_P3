<?php
session_start();
require_once 'koneksi.php'; // koneksi ke database toko_sarpi

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, nama, password, role FROM pengguna WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nama, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['id'] = $id;
                $_SESSION['nama'] = $nama;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;

                header("Location: home.php"); // redirect ke dashboard
                exit;
            } else {
                $login_error = "Kata sandi salah!";
            }
        } else {
            $login_error = "Email tidak ditemukan!";
        }
        $stmt->close();
    } else {
        $login_error = "Harap isi email dan kata sandi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Bu Sarpi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logo {
            width: 100px;
            height: 100px;
            background: #007bff;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">LOGO</div>
        <h4 class="text-center mb-3 text-primary">Login Toko Bu Sarpi</h4>

        <?php if ($login_error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required placeholder="Masukkan email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi:</label>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan kata sandi">
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        <p class="text-center mt-3"><a href="#">Lupa kata sandi?</a></p>
        <p class="text-center">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>