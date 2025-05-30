<?php
session_start();
require_once 'app/models/ProductModel.php';

// Xử lý URL từ GET (nếu có)
$url = $_GET['url'] ?? '';

// Xử lý POST request từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $url = 'product/' . $_POST['action'];
}

$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Bỏ qua prefix "2280618888_PhamTaManhLan_Bai2" nếu có
$prefix = '2280618888_PhamTaManhLan_Bai2';
if (!empty($url) && $url[0] === $prefix) {
    array_shift($url);
}

// Kiểm tra phần đầu tiên của URL để xác định controller, chuẩn hóa chữ thường
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) . 'Controller' : 'ProductController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Debug
// var_dump($_GET['url']);
// var_dump($url);
// die("controller=$controllerName - action=$action");

if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    die('Action not found');
}

call_user_func_array([$controller, $action], array_slice($url, 2));