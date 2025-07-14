<?php
class AdminProductController extends AdminController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }

    // List all products
    public function index() {
        $products = $this->productModel->getAll();
        $this->view('admin/products/index', [
            'title' => 'Quản lý sản phẩm',
            'products' => $products
        ]);
    }

    // Show create product form
    public function create() {
        $categories = $this->categoryModel->getAll();
        $this->view('admin/products/create', [
            'title' => 'Thêm sản phẩm mới',
            'categories' => $categories
        ]);
    }

    // Store new product
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => floatval($_POST['price']),
                'stock' => intval($_POST['stock'])
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = $fileName;
                }
            }

            // Validate input
            $errors = [];
            if (empty($data['name'])) {
                $errors['name'] = 'Tên sản phẩm không được để trống';
            }
            if (empty($data['category_id'])) {
                $errors['category_id'] = 'Vui lòng chọn danh mục';
            }
            if ($data['price'] <= 0) {
                $errors['price'] = 'Giá sản phẩm phải lớn hơn 0';
            }
            if ($data['stock'] < 0) {
                $errors['stock'] = 'Số lượng không được âm';
            }

            if (empty($errors)) {
                if ($this->productModel->create($data)) {
                    $_SESSION['success'] = 'Thêm sản phẩm thành công';
                    header('Location: ' . BASE_URL . '/admin/product');
                    exit();
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $categories = $this->categoryModel->getAll();
            $this->view('admin/products/create', [
                'title' => 'Thêm sản phẩm mới',
                'errors' => $errors,
                'data' => $data,
                'categories' => $categories
            ]);
        }
    }

    // Show edit product form
    public function edit($id) {
        $product = $this->productModel->getById($id);
        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại';
            header('Location: ' . BASE_URL . '/admin/product');
            exit();
        }

        $categories = $this->categoryModel->getAll();
        $this->view('admin/products/edit', [
            'title' => 'Sửa sản phẩm',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    // Update product
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => floatval($_POST['price']),
                'stock' => intval($_POST['stock'])
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Delete old image if exists
                    $product = $this->productModel->getById($id);
                    if ($product && $product->image) {
                        $oldImage = $uploadDir . $product->image;
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }
                    $data['image'] = $fileName;
                }
            }

            // Validate input
            $errors = [];
            if (empty($data['name'])) {
                $errors['name'] = 'Tên sản phẩm không được để trống';
            }
            if (empty($data['category_id'])) {
                $errors['category_id'] = 'Vui lòng chọn danh mục';
            }
            if ($data['price'] <= 0) {
                $errors['price'] = 'Giá sản phẩm phải lớn hơn 0';
            }
            if ($data['stock'] < 0) {
                $errors['stock'] = 'Số lượng không được âm';
            }

            if (empty($errors)) {
                if ($this->productModel->update($id, $data)) {
                    $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                    header('Location: ' . BASE_URL . '/admin/product');
                    exit();
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $categories = $this->categoryModel->getAll();
            $this->view('admin/products/edit', [
                'title' => 'Sửa sản phẩm',
                'errors' => $errors,
                'product' => (object)array_merge(['id' => $id], $data),
                'categories' => $categories
            ]);
        }
    }

    // Delete product
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $this->productModel->getById($id);
            if ($product && $this->productModel->delete($id)) {
                // Delete product image if exists
                if ($product->image) {
                    $imagePath = 'public/uploads/products/' . $product->image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $_SESSION['success'] = 'Xóa sản phẩm thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
            }
            header('Location: ' . BASE_URL . '/admin/product');
            exit();
        }
    }

    // Search products
    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $products = $this->productModel->search($keyword);
        $this->view('admin/products/index', [
            'title' => 'Tìm kiếm sản phẩm',
            'products' => $products,
            'keyword' => $keyword
        ]);
    }
} 