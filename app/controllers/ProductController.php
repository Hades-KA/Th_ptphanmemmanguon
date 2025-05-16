<?php
require_once 'app/models/ProductModel.php';

class ProductController
{
    private $products = [];

    public function __construct()
    {
        // Khởi động session và nạp dữ liệu sản phẩm từ session nếu có
        session_start();
        if (isset($_SESSION['products'])) {
            $this->products = $_SESSION['products'];
        }
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";

        // Lọc sản phẩm theo từ khóa tìm kiếm
        $filteredProducts = array_filter($this->products, function ($product) use ($searchQuery) {
            return empty($searchQuery) || stripos($product->getName(), $searchQuery) !== false;
        });

        $products = $filteredProducts;

        include 'app/views/product/list.php';
    }

    public function add()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = $_POST['price'] ?? '';

            // Kiểm tra tên sản phẩm
            if (empty($name)) {
                $errors[] = 'Tên sản phẩm là bắt buộc.';
            } elseif (strlen($name) < 10 || strlen($name) > 100) {
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
            }

            // Kiểm tra giá sản phẩm
            if (!is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá phải là một số dương lớn hơn 0.';
            }

            if (empty($errors)) {
                $id = count($this->products) + 1;
                $product = new ProductModel($id, $name, $description, $price);
                $this->products[] = $product;

                $_SESSION['products'] = $this->products;

                header('Location: /bai1/Product/list');
                exit();
            }
        }

        include 'app/views/product/add.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($this->products as $key => $product) {
                if ($product->getID() == $id) {
                    $this->products[$key]->setName($_POST['name']);
                    $this->products[$key]->setDescription($_POST['description']);
                    $this->products[$key]->setPrice($_POST['price']);
                    break;
                }
            }

            $_SESSION['products'] = $this->products;

            header('Location: /2280618888_PhamTaManhLan/Product/list');
            exit();
        }

        // Hiển thị form sửa sản phẩm
        foreach ($this->products as $product) {
            if ($product->getID() == $id) {
                include 'app/views/product/edit.php';
                return;
            }
        }

        // Không tìm thấy sản phẩm
        die('Product not found');
    }

    public function delete($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product->getID() == $id) {
                unset($this->products[$key]);
                break;
            }
        }

        // Đặt lại chỉ số mảng
        $this->products = array_values($this->products);

        $_SESSION['products'] = $this->products;

        header('Location: /bai1/Product/list');
        exit();
    }
}
?>
