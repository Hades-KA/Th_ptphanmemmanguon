<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h2>Thêm sản phẩm mới</h2>
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
            <form id="add-product-form" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="name" class="fw-bold">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="fw-bold">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="price" class="fw-bold">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
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
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success px-4">Thêm sản phẩm</button>
                    <a href="/2280618888_PhamTaManhLan_Bai2/product" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.getElementById('category_id');

        // Tải danh mục từ API
        fetch('http://localhost:90/2280618888_PhamTaManhLan_Bai2/api/category', {
            method: 'GET',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Category response status:', response.status); // Debug
            if (!response.ok) throw new Error('Lỗi khi tải danh mục');
            return response.json();
        })
        .then(data => {
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Lỗi khi tải danh mục:', error);
            alert('Lỗi: Không thể tải danh mục. Vui lòng thử lại!');
        });

        // Xử lý submit form
        document.getElementById('add-product-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this); // Sử dụng FormData trực tiếp

            fetch('http://localhost:90/2280618888_PhamTaManhLan_Bai2/api/product', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Product response status:', response.status); // Debug
                if (!response.ok) throw new Error('Lỗi khi thêm sản phẩm');
                return response.json();
            })
            .then(data => {
                if (data && data.message && data.message.includes('successfully')) {
                    alert('Thêm sản phẩm thành công!');
                    location.href = 'http://localhost:90/2280618888_PhamTaManhLan_Bai2/product';
                } else {
                    alert('Thêm sản phẩm thất bại: ' + (data.message || 'Lỗi không xác định'));
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Lỗi: Không thể kết nối đến máy chủ. Chi tiết: ' + error.message);
            });
        });
    });
</script>