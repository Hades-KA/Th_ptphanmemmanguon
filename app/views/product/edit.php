<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
</head>
<body>
    <h1>Sửa sản phẩm</h1>

    <form method="POST" action="/2280618888_PhamTaManhLan/Product/edit/<?php echo $product->getID(); ?>">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8'); ?></textarea><br><br>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars(number_format($product->getPrice(), 2, ',', '.'), ENT_QUOTES, 'UTF-8'); ?>" step="0.01" required><br><br>

        <button type="submit">Lưu thay đổi</button>
    </form>

    <a href="/2280618888_PhamTaManhLan/Product/list">Quay lại danh sách sản phẩm</a>
</body>
</html>
