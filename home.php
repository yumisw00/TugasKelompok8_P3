<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Toko Bu Sarpi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        html, body {
             height: 100%;
            }
            body {
             display: flex;
             flex-direction: column;
            }
            footer {
            margin-top: auto;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.7;
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
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }
        footer {
            background: linear-gradient(135deg, #343a40, #495057);
        }
        .container {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .content {
            max-width: 400px;
        }

        .content h1 {
            font-size: 2.5rem;
            margin-bottom: 16px;
            color: #2C2C2C;
        }

        .content p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #FFB84D;
            color: #fff;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #007bff;
        }

        .image-gallery {
            display: flex;
            gap: 20px;
        }

        .image-gallery img {
            width: 180px;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-gallery img:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kelontong Bu Sarpi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="checkout.php">Checkout</a></li>
                    <li class="nav-item"><a class="nav-link" href="tentangkami.php">tentangkami</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="custom-header text-white text-center py-5">
        <h1 class="display-4">Selamat Datang di Toko Bu Sarpi</h1>
        <p class="lead">Toko Bu Sarpi Terlengkap dan Terjangkau</p>
    </header>

    <div class="container my-5" id="menu">
        <div class="content">
            <h1>Toko Bu Sarpi</h1>
            <p>Tempat belanja kebutuhan sehari-hari yang lengkap dan terjangkau.</p>
            <a href="katalog.html" class="btn">Lihat Menu</a>
        </div>

        <div class="image-gallery">
            <img src="gambar/toko1.jpg" alt="toko 1">
            <img src="gambar/toko2.jpg" alt="toko 2">
            <img src="gambar/toko1.jpg" alt="toko 3">
        </div>
    </div>

    <footer class="text-white text-center py-4">
        <p>&copy; 2025 Toko Bu Sarpi. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>