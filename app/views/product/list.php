<?php include 'app/views/shares/header.php'; ?>
<?php
// Kích hoạt session nếu chưa được kích hoạt
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Bao gồm SessionHelper nếu nó chưa được tải
// Đảm bảo đường dẫn này đúng với vị trí của SessionHelper.php trong dự án của bạn
require_once 'app/helpers/SessionHelper.php';
?>

<div class="content-wrapper mt-5 pt-5 pb-5"> <div class="container">
        <h1 class="mb-5 text-center text-primary font-weight-bold display-4 animate__animated animate__fadeInDown">
            <i class="fas fa-box-open mr-3"></i>Danh sách sản phẩm
        </h1>
        
        <?php if (SessionHelper::isAdmin()) : ?>
        <div class="text-center mb-5 animate__animated animate__fadeInUp">
            <a href="/2280618888_PhamTaManhLan_Bai2/product/add" class="btn btn-success btn-lg shadow-lg add-product-btn">
                <i class="fas fa-plus-circle mr-2"></i>Thêm sản phẩm mới
            </a>
        </div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php if (empty($products)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm animate__animated animate__zoomIn" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>Không có sản phẩm nào để hiển thị. Vui lòng thêm sản phẩm mới!
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="col mb-4 animate__animated animate__fadeInUp"> <div class="card h-100 shadow-lg border-0 rounded-lg product-card-hover">
                            <?php if (!empty($product->image)): ?>
                                <img src="/2280618888_PhamTaManhLan_Bai2/<?php echo htmlspecialchars($product->image); ?>"
                                     class="card-img-top product-thumbnail-image"
                                     alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/200x200?text=No+Image"
                                     class="card-img-top product-thumbnail-image"
                                     alt="No Image">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate mb-2">
                                    <a href="/2280618888_PhamTaManhLan_Bai2/product/show/<?php echo $product->id; ?>" 
                                       class="text-decoration-none text-dark font-weight-bold product-name-link"
                                       title="<?php echo htmlspecialchars($product->name); ?>">
                                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small description-clamp mb-2">
                                    <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <p class="card-text mb-2">
                                    <strong>Giá: <span class="text-danger font-weight-bold price-text">
                                        <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                    </span></strong>
                                </p>
                                <p class="card-text small text-secondary">
                                    Danh mục: <span class="font-weight-normal"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                                </p>

                                <div class="mt-auto d-grid gap-2">
                                    <?php if (SessionHelper::isAdmin()) : ?>
                                    <a href="/2280618888_PhamTaManhLan_Bai2/product/edit/<?php echo $product->id; ?>"
                                        class="btn btn-outline-warning btn-sm product-action-btn"><i class="fas fa-edit mr-1"></i>Sửa</a>
                                    <a href="/2280618888_PhamTaManhLan_Bai2/product/delete/<?php echo $product->id; ?>"
                                        class="btn btn-outline-danger btn-sm product-action-btn"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="fas fa-trash-alt mr-1"></i>Xóa</a>
                                    <?php endif; ?>
                                    <a href="/2280618888_PhamTaManhLan_Bai2/product/addToCart/<?php echo $product->id; ?>"
                                        class="btn btn-primary btn-sm add-to-cart-btn"><i class="fas fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    /* CSS for content-wrapper to prevent content from being hidden by fixed navbar */
    .content-wrapper {
        padding-top: 70px; /* Adjust this value based on your navbar's height */
    }

    /* Global styles for the background - Repeated for clarity, ideally in a separate CSS file */
    body {
        background: linear-gradient(to right bottom, #e0f2f7, #c6e0e5);
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    /* Adjust container padding for better visual spacing */
    .container {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    /* Main Heading */
    .display-4 {
        color: #007bff;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    /* Add Product Button */
    .add-product-btn {
        font-size: 1.1rem;
        padding: 0.8rem 1.8rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        background-color: #28a745;
        border-color: #28a745;
        text-transform: uppercase; /* Chữ in hoa */
        letter-spacing: 1px; /* Khoảng cách chữ */
    }
    .add-product-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 0.8rem 1.5rem rgba(40, 167, 69, 0.3) !important;
    }

    /* Product Card specific styles */
    .product-card-hover {
        transition: all 0.3s ease-in-out;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        display: flex; /* Use flexbox to ensure h-100 works well */
        flex-direction: column;
        justify-content: space-between; /* Push content to top/bottom */
    }

    .product-card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.18) !important;
        border-color: #007bff;
    }

    .product-thumbnail-image {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background-color: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px;
    }
    
    .card-body {
        padding: 1.25rem;
        flex-grow: 1; /* Allow card body to grow and fill space */
    }

    .card-title .product-name-link {
        font-size: 1.25rem;
        line-height: 1.3;
        color: #343a40;
    }
    .card-title .product-name-link:hover {
        color: #0056b3 !important;
    }

    .description-clamp {
        height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-size: 0.95rem;
        color: #6c757d;
    }

    .price-text {
        font-size: 1.4rem;
        font-weight: 800;
        color: #dc3545;
    }

    /* Button styling within cards */
    .product-action-btn, .add-to-cart-btn {
        font-size: 0.9rem;
        padding: 0.6rem 0.75rem;
        border-radius: 0.4rem;
        transition: all 0.2s ease-in-out;
    }
    .product-action-btn:hover, .add-to-cart-btn:hover {
        transform: translateY(-2px);
    }

    /* Specific button colors */
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #212529 !important;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff !important;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    /* Gutter spacing for Bootstrap 4 */
    .row.g-4 {
        margin-left: -0.75rem; /* half of gutter-x */
        margin-right: -0.75rem; /* half of gutter-x */
    }
    .row.g-4 > .col,
    .row.g-4 > [class*="col-"] {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        padding-bottom: 1.5rem; /* margin-bottom for each col */
    }

    /* Animation for empty products message */
    .alert {
        border-radius: 0.5rem;
        font-size: 1.1rem;
    }

    /* Responsive adjustments for columns */
    @media (min-width: 768px) {
        .row-cols-md-3 > * {
            flex: 0 0 auto;
            width: 33.33333333%;
        }
    }
    @media (min-width: 992px) {
        .row-cols-lg-4 > * {
            flex: 0 0 auto;
            width: 25%;
        }
    }
</style>