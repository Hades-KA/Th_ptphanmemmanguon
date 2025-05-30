<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark text-center">
            <h2>Sửa sản phẩm</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="POST" action="/2280618888_PhamTaManhLan_Bai2/product/update" enctype="multipart/form-data"
                onsubmit="return validateForm();">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <div class="form-group mb-3">
                    <label for="name" class="fw-bold">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="fw-bold">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control"
                        required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="price" class="fw-bold">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01"
                        value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="category_id" class="fw-bold">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="image" class="fw-bold">Hình ảnh:</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                    <?php if ($product->image): ?>
                        <div class="mt-2">
                            <img src="/2280618888_PhamTaManhLan_Bai2/<?php echo $product->image; ?>" alt="Product Image"
                                style="max-width: 120px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
                    <a href="/2280618888_PhamTaManhLan_Bai2/product" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>