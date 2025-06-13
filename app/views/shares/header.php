<?php
// Kích hoạt session nếu chưa được kích hoạt
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Bao gồm SessionHelper
require_once 'app/helpers/SessionHelper.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pham Ta Manh Lan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            background: linear-gradient(to right bottom, #e0f2f7, #c6e0e5);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-top: 70px;
        }

        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: bold;
            color: #007bff !important;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item .nav-link {
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
            color: #555;
            font-weight: 500;
        }

        .navbar-nav .nav-item .nav-link:hover,
        .navbar-nav .nav-item .nav-link.active {
            color: #007bff !important;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .navbar-nav .nav-item:last-child .nav-link,
        .navbar-nav .nav-item:nth-last-child(2) .nav-link:not([href]) {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            margin-left: 15px;
            font-weight: bold;
            color: #495057;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .nav-item:last-child .nav-link:hover,
        .navbar-nav .nav-item:nth-last-child(2) .nav-link:not([href]):hover {
            background-color: #dee2e6;
        }

        .navbar-nav .nav-item .nav-link[href*="/account/login"] {
            background-color: #28a745;
            color: white !important;
            border-radius: 8px;
        }

        .navbar-nav .nav-item .nav-link[href*="/account/login"]:hover {
            background-color: #218838;
        }

        .navbar-nav .nav-item .nav-link[href*="/account/logout"] {
            background-color: #dc3545;
            color: white !important;
            border-radius: 8px;
        }

        .navbar-nav .nav-item .nav-link[href*="/account/logout"]:hover {
            background-color: #c82333;
        }

        .product-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/2280618888_PhamTaManhLan_Bai2/product">Pham Tạ Mạnh Lân</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/2280618888_PhamTaManhLan_Bai2/product">Danh sách sản phẩm</a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/2280618888_PhamTaManhLan_Bai2/product/add">Thêm sản phẩm</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item" id="nav-login">
                    <?php 
                        if (!SessionHelper::isLoggedIn()) {
                            echo "<a class='nav-link' href='/2280618888_PhamTaManhLan_Bai2/account/login'>Đăng nhập</a>";
                        } else {
                            echo "<a class='nav-link'>" . htmlspecialchars($_SESSION['username'] ?? 'Khách') . " (" . htmlspecialchars($_SESSION['role'] ?? 'Người dùng') . ")</a>";
                        }
                    ?>
                </li>
                <li class="nav-item" id="nav-logout" style="display: <?php echo SessionHelper::isLoggedIn() ? 'block' : 'none'; ?>;">
                    <a class="nav-link" href="#" onclick="logout()">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        function logout() {
            <?php
            // Xóa session khi logout
            session_destroy();
            // Xóa token từ localStorage
            echo "localStorage.removeItem('jwtToken');";
            ?>
            location.href = '/2280618888_PhamTaManhLan_Bai2/account/login';
        }

        document.addEventListener("DOMContentLoaded", function () {
            const token = localStorage.getItem('jwtToken');
            const isLoggedIn = <?php echo SessionHelper::isLoggedIn() ? 'true' : 'false'; ?>;
            if (isLoggedIn || token) {
                document.getElementById('nav-login').style.display = 'none';
                document.getElementById('nav-logout').style.display = 'block';
            } else {
                document.getElementById('nav-login').style.display = 'block';
                document.getElementById('nav-logout').style.display = 'none';
            }
        });
    </script>
</body>
</html>