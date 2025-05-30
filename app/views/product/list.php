<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Danh sách sản phẩm</h1>
    <a href="/2280618888_PhamTaManhLan_Bai2/product/add" class="btn btn-success mb-3">+ Thêm sản phẩm mới</a>

    <ul class="list-group">
        <?php foreach ($products as $product): ?>
            <li class="list-group-item">
                <h2>
                    <a href="/2280618888_PhamTaManhLan_Bai2/product/show/<?php echo $product->id; ?>">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h2>

                <?php if (!empty($product->image)): ?>
                    <img src="/2280618888_PhamTaManhLan_Bai2/<?php echo $product->image; ?>" alt="Product Image"
                        style="max-width: 100px;">
                <?php endif; ?>

                <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</p>
                <p>Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>

                <!-- Các nút hành động -->
                <a href="/2280618888_PhamTaManhLan_Bai2/product/edit/<?php echo $product->id; ?>"
                    class="btn btn-warning btn-sm">Sửa</a>
                <a href="/2280618888_PhamTaManhLan_Bai2/product/delete/<?php echo $product->id; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                <a href="/2280618888_PhamTaManhLan_Bai2/product/addToCart/<?php echo $product->id; ?>"
                    class="btn btn-primary btn-sm">Thêm vào giỏ hàng</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'app/views/shares/footer.php'; ?>