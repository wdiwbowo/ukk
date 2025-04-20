<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir App - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #003366, #0056b3);
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            font-size: 20px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .section-title {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: #007bff;
        }
        .feature-icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .footer {
            background: #222;
            color: white;
            padding: 20px 0;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 20px;
        }
        .footer a:hover {
            color: white;
        }
        /* Map Styling */
        #map {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di <span style="color:#007bff;">Kasir App</span></h1>
            <p class="lead">Solusi kasir modern untuk kemudahan transaksi usaha Anda.</p>
            <a href='login' class="btn btn-primary">Mulai Sekarang</a>
        </div>
    </div>

    <!-- About Section -->
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div id="map"></div>
            </div>
            <div class="col-md-6">
                <h2 class="section-title">Tentang Kami</h2>
                <p>Kami menyediakan solusi kasir berbasis digital yang cepat, aman, dan mudah digunakan untuk bisnis kecil hingga besar.</p>
                <ul>
                    <li>🔹 Transaksi Cepat & Mudah</li>
                    <li>🔹 Pelacakan Stok Otomatis</li>
                    <li>🔹 Laporan Penjualan Real-Time</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5 text-center">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="row">
            <div class="col-md-4">
                <i class="fa fa-box-open feature-icon"></i>
                <h4>Manajemen Produk</h4>
                <p>Kelola produk dengan harga dan stok yang otomatis diperbarui.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-chart-line feature-icon"></i>
                <h4>Analisis Laporan</h4>
                <p>Dapatkan laporan penjualan dalam bentuk grafik dan tabel.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-lock feature-icon"></i>
                <h4>Keamanan Data</h4>
                <p>Sistem kami melindungi data transaksi dengan enkripsi tinggi.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2025 Kasir App. Hak Cipta Dilindungi.</p>
            <div>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-6.200000, 106.816666], 13); // Koordinat Jakarta (default)
        
        // Tambahkan Tile Layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Marker
        L.marker([-6.200000, 106.816666]).addTo(map)
            .bindPopup("Lokasi Kantor Kasir App")
            .openPopup();
    </script>

</body>
</html>
