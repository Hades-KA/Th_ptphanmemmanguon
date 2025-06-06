<?php
class SessionHelper {
    // Khởi động session nếu chưa bắt đầu và kiểm tra lỗi
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            try {
                session_start();
            } catch (Exception $e) {
                // Ghi log lỗi nếu cần
                error_log("Lỗi khởi động session: " . $e->getMessage());
                return false;
            }
        }
        return true;
    }

    // Kiểm tra người dùng đã đăng nhập chưa
    public static function isLoggedIn() {
        self::start();
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }

    // Kiểm tra người dùng có phải admin không
    public static function isAdmin() {
        self::start();
        return self::isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Lấy vai trò của người dùng, mặc định là 'guest'
    public static function getRole() {
        self::start();
        return $_SESSION['role'] ?? 'guest';
    }

    // Kiểm tra người dùng có vai trò cụ thể không
    public static function hasRole($role) {
        self::start();
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    // Đăng xuất người dùng
    public static function logout() {
        self::start();
        session_unset();
        session_destroy();
        session_start(); // Khởi động lại session mới nếu cần
        return true;
    }
}
?>
