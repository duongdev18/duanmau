<?php
class AdminCategoryController extends AdminController {
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->categoryModel = $this->model('Category');
    }

    // List all categories
    public function index() {
        $categories = $this->categoryModel->getAll();
        $this->view('admin/categories/index', [
            'title' => 'Quản lý danh mục',
            'categories' => $categories
        ]);
    }

    // Show create category form
    public function create() {
        $this->view('admin/categories/create', [
            'title' => 'Thêm danh mục mới'
        ]);
    }

    // Store new category
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];

            // Validate input
            $errors = [];
            if (empty($data['name'])) {
                $errors['name'] = 'Tên danh mục không được để trống';
            }

            if (empty($errors)) {
                if ($this->categoryModel->create($data)) {
                    $_SESSION['success'] = 'Thêm danh mục thành công';
                    header('Location: ' . BASE_URL . '/admin/category');
                    exit();
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->view('admin/categories/create', [
                'title' => 'Thêm danh mục mới',
                'errors' => $errors,
                'data' => $data
            ]);
        }
    }

    // Show edit category form
    public function edit($id) {
        $category = $this->categoryModel->getById($id);
        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại';
            header('Location: ' . BASE_URL . '/admin/category');
            exit();
        }

        $this->view('admin/categories/edit', [
            'title' => 'Sửa danh mục',
            'category' => $category
        ]);
    }

    // Update category
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];

            // Validate input
            $errors = [];
            if (empty($data['name'])) {
                $errors['name'] = 'Tên danh mục không được để trống';
            }

            if (empty($errors)) {
                if ($this->categoryModel->update($id, $data)) {
                    $_SESSION['success'] = 'Cập nhật danh mục thành công';
                    header('Location: ' . BASE_URL . '/admin/category');
                    exit();
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->view('admin/categories/edit', [
                'title' => 'Sửa danh mục',
                'errors' => $errors,
                'category' => (object)array_merge(['id' => $id], $data)
            ]);
        }
    }

    // Delete category
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->categoryModel->delete($id)) {
                $_SESSION['success'] = 'Xóa danh mục thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
            }
            header('Location: ' . BASE_URL . '/admin/category');
            exit();
        }
    }
} 