<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class ProductApiController
{
    private $productModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded ? true : false;
            }
        }
        return false;
    }

    // Lấy danh sách sản phẩm
    public function index()
    {
        if ($this->authenticate()) {
            header('Content-Type: application/json');
            $products = $this->productModel->getProducts();
            echo json_encode($products);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
        }
    }

    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    // Thêm sản phẩm mới
    public function store()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        header('Content-Type: application/json');
        $data = [];
        $files = $_FILES;

        // Xử lý FormData
        if (isset($_POST['name'])) {
            $data['name'] = $_POST['name'];
            $data['description'] = $_POST['description'] ?? '';
            $data['price'] = $_POST['price'] ?? '';
            $data['category_id'] = $_POST['category_id'] ?? null;
        } else {
            $input = file_get_contents("php://input");
            $data = json_decode($input, true);
            $data['name'] = $data['name'] ?? '';
            $data['description'] = $data['description'] ?? '';
            $data['price'] = $data['price'] ?? '';
            $data['category_id'] = $data['category_id'] ?? null;
        }

        $image = null;
        if (!empty($files['image']['name'])) {
            $image = $this->uploadImage($files['image']);
            if (!$image) {
                http_response_code(400);
                echo json_encode(['errors' => ['image' => 'Upload image failed']]);
                return;
            }
        }

        $result = $this->productModel->addProduct(
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $image
        );

        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }

    // Cập nhật sản phẩm theo ID
    public function update($id)
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        header('Content-Type: application/json');
        $data = [];
        $files = $_FILES;

        // Xử lý FormData
        if (isset($_POST['name'])) {
            $data['name'] = $_POST['name'];
            $data['description'] = $_POST['description'] ?? '';
            $data['price'] = $_POST['price'] ?? '';
            $data['category_id'] = $_POST['category_id'] ?? null;
        } else {
            $input = file_get_contents("php://input");
            $data = json_decode($input, true);
            $data['name'] = $data['name'] ?? '';
            $data['description'] = $data['description'] ?? '';
            $data['price'] = $data['price'] ?? '';
            $data['category_id'] = $data['category_id'] ?? null;
        }

        $image = null;
        if (!empty($files['image']['name'])) {
            $image = $this->uploadImage($files['image']);
            if (!$image) {
                http_response_code(400);
                echo json_encode(['errors' => ['image' => 'Upload image failed']]);
                return;
            }
        }

        $result = $this->productModel->updateProduct(
            $id,
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $image
        );

        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }

    // Xóa sản phẩm theo ID
    public function destroy($id)
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        header('Content-Type: application/json');
        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }

    private function uploadImage($file)
    {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedTypes)) {
            return false;
        }

        if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
            return false;
        }

        return $targetFile;
    }
}
