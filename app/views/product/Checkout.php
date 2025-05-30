<?php include 'app/views/shares/header.php'; ?>

<h1>Thanh toán</h1>

<form method="POST" action="/2280618888_PhamTaManhLan_Bai2/product/checkout"> <!-- Sử dụng route tương đối -->
    <input type="hidden" name="action" value="processCheckout"> <!-- Thêm hidden input -->
    <div class="form-group">
        <label for="name">Họ tên:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="address">Địa chỉ:</label>
        <textarea id="address" name="address" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Thanh toán</button>
</form>

<a href="/2280618888_PhamTaManhLan_Bai2/product/cart" class="btn btn-secondary mt-2">Quay lại giỏ hàng</a>

<?php include 'app/views/shares/footer.php'; ?>