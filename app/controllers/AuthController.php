<?php
class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        // If user is already logged in, redirect to home
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Enable error reporting for debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? '')
            ];

            // Validate input
            $errors = [];
            if (empty($data['email'])) {
                $errors['email'] = 'Vui lòng nhập email';
            }
            if (empty($data['password'])) {
                $errors['password'] = 'Vui lòng nhập mật khẩu';
            }

            if (empty($errors)) {
                try {
                    $user = $this->userModel->getByEmail($data['email']);
                    
                    if ($user && password_verify($data['password'], $user->password)) {
                        // Create session
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_role'] = $user->role;
                        $_SESSION['user_name'] = $user->full_name;
                        
                        // Redirect based on role
                        if ($user->role === 'admin') {
                            header('Location: ' . BASE_URL . '/admin/dashboard');
                        } else {
                            header('Location: ' . BASE_URL);
                        }
                        exit();
                    } else {
                        $errors['login'] = 'Email hoặc mật khẩu không chính xác';
                        // Log failed login attempt
                        error_log("Failed login attempt for email: " . $data['email']);
                    }
                } catch (Exception $e) {
                    error_log("Login error: " . $e->getMessage());
                    $errors['login'] = 'Có lỗi xảy ra, vui lòng thử lại sau';
                }
            }

            $this->view('auth/login', [
                'title' => 'Đăng nhập',
                'errors' => $errors,
                'data' => $data
            ]);
        } else {
            $this->view('auth/login', [
                'title' => 'Đăng nhập'
            ]);
        }
    }

    public function register() {
        // If user is already logged in, redirect to home
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? '')
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
            if (empty($data['password'])) {
                $errors['password'] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($data['password']) < 6) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            if ($data['password'] !== $data['confirm_password']) {
                $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp';
            }

            // Check if email exists
            if (empty($errors['email'])) {
                try {
                    $existingUser = $this->userModel->getByEmail($data['email']);
                    if ($existingUser) {
                        $errors['email'] = 'Email đã được sử dụng';
                    }
                } catch (Exception $e) {
                    error_log("Error checking email existence: " . $e->getMessage());
                    $errors['email'] = 'Có lỗi xảy ra, vui lòng thử lại sau';
                }
            }

            if (empty($errors)) {
                try {
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $data['role'] = 'user'; // Default role

                    if ($this->userModel->create($data)) {
                        $_SESSION['success'] = 'Đăng ký thành công, vui lòng đăng nhập';
                        header('Location: ' . BASE_URL . '/login');
                        exit();
                    } else {
                        throw new Exception("Failed to create user");
                    }
                } catch (Exception $e) {
                    error_log("Registration error: " . $e->getMessage());
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->view('auth/register', [
                'title' => 'Đăng ký',
                'errors' => $errors,
                'data' => $data
            ]);
        } else {
            $this->view('auth/register', [
                'title' => 'Đăng ký'
            ]);
        }
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit();
    }
} 