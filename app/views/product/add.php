<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <script>
        function validateForm() {
            let name = document.getElementById('name').value;
            let price = document.getElementById('price').value;
            let errors = [];

            // Check if the product name is valid
            if (name.length < 10 || name.length > 100) {
                errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
            }
            // Check if the price is valid
            if (price <= 0 || isNaN(price)) {
                errors.push('Giá phải là một số dương lớn hơn 0.');
            }

            // If errors exist, show them and prevent form submission
            if (errors.length > 0) {
                alert(errors.join('\n'));
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h1>Thêm sản phẩm mới</h1>

    <!-- Display server-side validation errors if any -->
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Product add form -->
    <form method="POST" action="/2280618888_PhamTaManhLan/Product/add" onsubmit="return validateForm();">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <button type="submit">Thêm sản phẩm</button>
    </form>

    <a href="/2280618888_PhamTaManhLan/Product/list">Quay lại danh sách sản phẩm</a>
</body>
</html>
