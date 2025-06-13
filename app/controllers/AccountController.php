<?php 
require_once('app/config/database.php'); 
require_once('app/models/AccountModel.php'); 
require_once('app/utils/JWTHandler.php'); // <-- Bổ sung dòng này để dùng JWT

class AccountController { 
    private $accountModel; 
    private $db; 
    private $jwtHandler; // <-- Thêm thuộc tính JWT

    public function __construct() { 
        $this->db = (new Database())->getConnection(); 
        $this->accountModel = new AccountModel($this->db); 
        $this->jwtHandler = new JWTHandler(); // <-- Khởi tạo JWT
    } 

    public function register() { 
        include_once 'app/views/account/register.php'; 
    } 

    public function login() { 
        include_once 'app/views/account/login.php'; 
    } 

    public function save() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $username = $_POST['username'] ?? ''; 
            $fullName = $_POST['fullname'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
            $confirmPassword = $_POST['confirmpassword'] ?? ''; 
            $role = $_POST['role'] ?? 'user'; 

            $errors = []; 

            if (empty($username)) $errors['username'] = "Vui lòng nhập username!"; 
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!"; 
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!"; 
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!"; 
            if (!in_array($role, ['admin', 'user'])) $role = 'user'; 

            if ($this->accountModel->getAccountByUsername($username)) { 
                $errors['account'] = "Tài khoản này đã được đăng ký!"; 
            } 

            if (count($errors) > 0) { 
                include_once 'app/views/account/register.php'; 
                return;
            } else { 
                $password = password_hash($password, PASSWORD_BCRYPT); 
                $result = $this->accountModel->save($username, $fullName, $password, $role); 
                if ($result) { 
                    header('Location: /2280618888_PhamTaManhLan_Bai2/account/login'); 
                    exit; 
                } else {
                    $errors['save'] = "Đăng ký không thành công. Vui lòng thử lại.";
                    include_once 'app/views/account/register.php';
                    return;
                }
            }
        }
    } 

    public function logout() { 
        session_start(); 
        unset($_SESSION['username']); 
        unset($_SESSION['role']); 
        header('Location: /2280618888_PhamTaManhLan_Bai2/product'); 
        exit; 
    } 

    // Đăng nhập bằng FORM (session)
    public function checkLogin() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $username = $_POST['username'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
            $error = '';

            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
                include_once 'app/views/account/login.php'; 
                return;
            }

            $account = $this->accountModel->getAccountByUsername($username); 

            if ($account && password_verify($password, $account->password)) { 
                session_start(); 
                $_SESSION['username'] = $account->username; 
                $_SESSION['role'] = $account->role; 
                header('Location: /2280618888_PhamTaManhLan_Bai2/product'); 
                exit; 
            } else { 
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!"; 
                include_once 'app/views/account/login.php'; 
                return;
            } 
        }
    }

    // ✅ Đăng nhập API -> trả về JWT token nếu đúng
    public function apiLogin() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $account = $this->accountModel->getAccountByUsername($username);

        if ($account && password_verify($password, $account->password)) {
            $token = $this->jwtHandler->encode([
                'id' => $account->id,
                'username' => $account->username,
                'role' => $account->role
            ]);
            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Thông tin đăng nhập không đúng']);
        }
    }
}
?>
