<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh sách sản phẩm</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Light mode variables */
    :root {
      --bg-color: #d4edda;
      --container-bg: #f8fff6;
      --primary-color: #2e7d32;
      --secondary-color: #388e3c;
      --accent-color: #66bb6a;
      --search-bg: #a5d6a7;
      --footer-bg: #a5d6a7;
      --text-color: #2e7d32;
      --card-bg: #ffffff;
    }
    /* Dark mode overrides */
    body.dark-mode {
      --bg-color: #121212;
      --container-bg: #1e1e1e;
      --primary-color: #bb86fc;
      --secondary-color: #03dac6;
      --accent-color: #03a9f4;
      --search-bg: #333333;
      --footer-bg: #333333;
      --text-color: #ffffff;  /* Now text will be white in dark mode */
      --card-bg: #2c2c2c;
    }
    body {
      background-color: var(--bg-color);
      font-family: 'Roboto', sans-serif;
      transition: background-color 0.5s ease;
      padding-bottom: 100px; /* Ensure content doesn't collide with footer */
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: var(--container-bg);
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: background 0.5s ease;
    }
    h1 {
      color: var(--primary-color);
      font-weight: 700;
    }
    .search-bar {
      background-color: var(--search-bg);
      border-radius: 8px;
      padding: 8px 12px;
    }
    .search-bar input {
      border: none;
      padding: 10px;
      border-radius: 5px;
      width: 85%;
    }
    .search-bar button {
      background-color: var(--accent-color);
      border: none;
      padding: 10px 20px;
      color: white;
      border-radius: 5px;
    }
    .add-product {
      background-color: var(--accent-color);
      border: none;
    }
    .add-product:hover {
      background-color: #4caf50;
    }
    .product-item {
      background-color: var(--card-bg);
      border: 1px solid var(--search-bg);
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 15px;
      transition: background-color 0.5s ease;
    }
    .product-item h2 {
      color: var(--secondary-color);
      font-size: 1.5rem;
    }
    .footer {
      background: var(--footer-bg);
      padding: 20px 10px;
      border-top: 3px solid var(--secondary-color);
      text-align: center;
      border-radius: 0 0 8px 8px;
      margin-top: 40px;
      transition: background 0.5s ease;
    }
    .footer p {
      margin-bottom: 15px;
      font-weight: 700;
      color: var(--primary-color);
    }
    .footer a {
      color: var(--text-color);
      margin: 0 10px;
      text-decoration: none;
      font-size: 24px;
      transition: color 0.3s ease;
    }
    .footer a:hover {
      color: #1b5e20;
    }
    /* Toggle Dark/Light Mode Button */
    .toggle-mode {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
    }
  </style>
</head>
<body>
  <!-- Toggle Dark/Light Mode Button -->
  <button class="toggle-mode btn btn-outline-secondary" onclick="toggleMode()">Dark Mode</button>
  
  <div class="container">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    
    <!-- Search Bar -->
    <form method="GET" action="/2280618888_PhamTaManhLan/Product/list" class="mb-3 search-bar d-flex justify-content-between align-items-center">
      <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm..." 
             value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
      <button type="submit" class="btn">Tìm kiếm</button>
    </form>
    
    <a class="btn add-product w-100 text-white mb-3" href="/2280618888_PhamTaManhLan/Product/add">Thêm sản phẩm mới</a>
    
    <!-- Product List -->
    <ul class="list-unstyled">
      <?php if (!empty($products) && is_array($products)): ?>
        <?php foreach ($products as $product): ?>
          <li class="product-item">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <div class="flex-grow-1">
                <h2><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, "UTF-8"); ?></h2>
                <p><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, "UTF-8"); ?></p>
                <p><strong>Giá:</strong> <?php echo htmlspecialchars($product->getPrice(), ENT_QUOTES, "UTF-8"); ?> VNĐ</p>
              </div>
              <div class="actions mt-3 mt-md-0">
                <a class="btn btn-warning text-dark" href="/2280618888_PhamTaManhLan/Product/edit/<?php echo $product->getID(); ?>">Sửa</a>
                <a class="btn btn-danger text-white" href="/2280618888_PhamTaManhLan/Product/delete/<?php echo $product->getID(); ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-danger">Không có sản phẩm nào để hiển thị.</p>
      <?php endif; ?>
    </ul>
  </div>
  
  <!-- Footer with Social Media Links -->
  <div class="footer">
    <p>Liên hệ với chúng tôi:</p>
    <div class="d-flex justify-content-center gap-4">
      <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
      <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
      <a href="https://github.com" target="_blank"><i class="bi bi-github"></i></a>
    </div>
  </div>
  
  <script>
    // Check localStorage on page load for dark mode
    document.addEventListener("DOMContentLoaded", function() {
      const darkModeEnabled = localStorage.getItem("darkMode") === "true";
      if (darkModeEnabled) {
        document.body.classList.add("dark-mode");
        const btn = document.querySelector(".toggle-mode");
        if (btn) {
          btn.textContent = "Light Mode";
        }
      }
    });
    
    function toggleMode() {
      document.body.classList.toggle("dark-mode");
      var btn = document.querySelector(".toggle-mode");
      if (document.body.classList.contains("dark-mode")) {
        btn.textContent = "Light Mode";
        localStorage.setItem("darkMode", "true");
      } else {
        btn.textContent = "Dark Mode";
        localStorage.setItem("darkMode", "false");
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>