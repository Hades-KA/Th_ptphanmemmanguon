<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* Global Body Styles for a nice background */
        body {
            background: linear-gradient(to right bottom, #e0f2f7, #c6e0e5); /* Light blue-green gradient */
            min-height: 100vh; /* Ensure gradient covers full height */
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern, readable font */
            color: #333; /* Dark gray for main text */
            padding-top: 70px; /* Space for fixed navbar. Adjust if your navbar height changes */
        }

        /* Navbar Custom Styles */
        .navbar {
            background-color: #ffffff !important; /* White background for navbar */
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* Stronger shadow for depth */
            position: fixed; /* Make navbar fixed at the top */
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1030; /* Ensure navbar is on top of other content */
        }

        .navbar-brand {
            font-weight: bold;
            color: #007bff !important; /* Bootstrap primary blue */
            font-size: 1.5rem; /* Larger brand text */
        }

        .navbar-nav .nav-item .nav-link {
            padding: 0.8rem 1.2rem; /* More padding for links */
            transition: all 0.3s ease;
            color: #555; /* Default link color */
            font-weight: 500;
        }

        .navbar-nav .nav-item .nav-link:hover,
        .navbar-nav .nav-item .nav-link.active { /* You might add 'active' class via JS for current page */
            color: #007bff !important;
            background-color: #f8f9fa; /* Light background on hover */
            border-radius: 5px;
        }

        /* Styles for User Info / Login / Logout links */
        .navbar-nav .nav-item:last-child .nav-link,
        .navbar-nav .nav-item:nth-last-child(2) .nav-link:not([href]) { /* Target user info text */
            background-color: #e9ecef; /* Light gray background */
            border-radius: 8px; /* More rounded corners */
            padding: 0.6rem 1.2rem;
            margin-left: 15px; /* More space from previous item */
            font-weight: bold;
            color: #495057; /* Darker text */
            transition: background-color 0.3s ease;
        }
        .navbar-nav .nav-item:last-child .nav-link:hover,
        .navbar-nav .nav-item:nth-last-child(2) .nav-link:not([href]):hover {
            background-color: #dee2e6;
        }

        .navbar-nav .nav-item .nav-link[href*="/account/login"] {
            background-color: #28a745; /* Green for login */
            color: white !important;
            border-radius: 8px;
        }
        .navbar-nav .nav-item .nav-link[href*="/account/login"]:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .navbar-nav .nav-item .nav-link[href*="/account/logout"] {
            background-color: #dc3545; /* Red for logout */
            color: white !important;
            border-radius: 8px;
        }
        .navbar-nav .nav-item .nav-link[href*="/account/logout"]:hover {
            background-color: #c82333; /* Darker red on hover */
        }
        /* Hide default .product-image style if not used elsewhere */
        .product-image {
            display: none; /* This style is probably not needed anymore with card images */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> <li class="nav-item">
                    <a class="nav-link" href="/2280618888_PhamTaManhLan_Bai2/Product/">Danh sách sản phẩm</a>
                </li>
                <?php if (SessionHelper::isAdmin()) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/2280618888_PhamTaManhLan_Bai2/Product/add">Thêm sản phẩm</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?php 
                        if (SessionHelper::isLoggedIn()) {
                            // Hiển thị tên người dùng và vai trò nếu đã đăng nhập
                            // Lưu ý: SessionHelper::getRole() cần trả về chuỗi 'admin' hoặc 'user'
                            echo "<a class='nav-link'>" . htmlspecialchars($_SESSION['username']) . " (" . htmlspecialchars(SessionHelper::getRole()) . ")</a>";
                        } else {
                            // Hiển thị liên kết đăng nhập nếu chưa đăng nhập
                            echo "<a class='nav-link' href='/2280618888_PhamTaManhLan_Bai2/account/login'>Đăng nhập</a>";
                        }
                    ?>
                </li>
                <?php if (SessionHelper::isLoggedIn()) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/2280618888_PhamTaManhLan_Bai2/account/logout">Đăng xuất</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>