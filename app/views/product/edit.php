<?php include 'app/views/shares/header.php'; ?>
<?php
// Lấy ID sản phẩm từ URL hoặc $product
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($product->id) ? (int)$product->id : 0);
if ($id <= 0) {
    die('ID sản phẩm không hợp lệ!');
}
?>

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
            <form id="edit-product-form" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <div class="form-group mb-3">
                    <label for="name" class="fw-bold">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="fw-bold">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control"
                        required><?php echo htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="price" class="fw-bold">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01"
                        value="<?php echo htmlspecialchars($product->price ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="category_id" class="fw-bold">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="image" class="fw-bold">Hình ảnh:</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <?php if ($product->image): ?>
                        <div class="mt-2">
                            <img src="/2280618888_PhamTaManhLan_Bai2/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image"
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productId = <?php echo $id; ?>;
        console.log('Product ID:', productId); // Debug ID
        const categorySelect = document.getElementById('category_id');
        const form = document.getElementById('edit-product-form');

        // Tải danh mục từ API
        fetch('http://localhost:90/2280618888_PhamTaManhLan_Bai2/api/category', {
            method: 'GET',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Category response status:', response.status);
            if (!response.ok) throw new Error('Lỗi khi tải danh mục');
            return response.json();
        })
        .then(data => {
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                if (category.id == <?php echo $product->category_id ?? 0; ?>) {
                    option.selected = true;
                }
                categorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Lỗi khi tải danh mục:', error);
            alert('Lỗi: Không thể tải danh mục. Vui lòng thử lại!');
        });

        // Xử lý submit form
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(`http://localhost:90/2280618888_PhamTaManhLan_Bai2/api/product/${productId}`, {
                method: 'PUT',
                body: formData
            })
            .then(response => {
                console.log('Update response status:', response.status);
                if (!response.ok) throw new Error('Lỗi khi cập nhật sản phẩm: ' + response.statusText);
                return response.json();
            })
            .then(data => {
                if (data && data.message && data.message.includes('successfully')) {
                    alert('Cập nhật sản phẩm thành công!');
                    location.href = 'http://localhost:90/2280618888_PhamTaManhLan_Bai2/product';
                } else {
                    alert('Cập nhật sản phẩm thất bại: ' + (data.message || 'Lỗi không xác định'));
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Lỗi: Không thể kết nối đến máy chủ. Chi tiết: ' + error.message);
            });
        });
    });
</script>