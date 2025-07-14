<?php
class AdminController extends Controller {
    protected $userModel;

    public function __construct() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để truy cập trang quản trị';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $this->userModel = $this->model('User');
        $user = $this->userModel->getById($_SESSION['user_id']);
        
        if (!$user || $user->role !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị';
            header('Location: ' . BASE_URL);
            exit();
        }
    }

    public function index() {
        header('Location: ' . BASE_URL . '/admin/dashboard');
        exit();
    }

    public function dashboard() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        $orderModel = $this->model('Order');
        $userModel = $this->model('User');

        $data = [
            'title' => 'Dashboard',
            'total_products' => count($productModel->getAll()),
            'total_categories' => count($categoryModel->getAll()),
            'total_orders' => $orderModel ? count($orderModel->getAll()) : 0,
            'total_users' => count($userModel->getAll()),
            'recent_orders' => $orderModel ? $orderModel->getRecent(5) : [],
            'recent_users' => $userModel->getRecent(5)
        ];

        $this->view('admin/dashboard/index', $data);
    }

    public function profile() {
        $user = $this->userModel->getById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address'])
            ];

            // Validate input
            $errors = [];
            if (empty($data['full_name'])) {
                $errors['full_name'] = 'Vui lòng nhập họ tên';
            }
            if (empty($data['email'])) {
                $errors['email'] = 'Vui lòng nhập email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ';
            }

            // Check if email exists
            if ($data['email'] !== $user->email) {
                $existingUser = $this->userModel->getByEmail($data['email']);
                if ($existingUser) {
                    $errors['email'] = 'Email đã được sử dụng';
                }
            }

            // Update password if provided
            if (!empty($_POST['password'])) {
                if (strlen($_POST['password']) < 6) {
                    $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                } else {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
            }

            if (empty($errors)) {
                if ($this->userModel->update($_SESSION['user_id'], $data)) {
                    $_SESSION['success'] = 'Cập nhật thông tin thành công';
                    header('Location: ' . BASE_URL . '/admin/profile');
                    exit();
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->view('admin/profile/index', [
                'title' => 'Thông tin tài khoản',
                'user' => (object)array_merge((array)$user, $data),
                'errors' => $errors
            ]);
        } else {
            $this->view('admin/profile/index', [
                'title' => 'Thông tin tài khoản',
                'user' => $user
            ]);
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit();
    }
} 