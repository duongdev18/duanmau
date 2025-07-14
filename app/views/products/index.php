<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Danh sách sản phẩm</h2>
        <a href="<?= BASE_URL ?>/product/create" class="btn btn-primary">Thêm sản phẩm</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <form action="<?= BASE_URL ?>/product/search" method="GET" class="d-flex">
            <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
            <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product->id ?></td>
                            <td>
                                <?php if ($product->image): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/products/<?= htmlspecialchars($product->image) ?>" 
                                         alt="<?= htmlspecialchars($product->name) ?>" 
                                         class="img-thumbnail" style="max-width: 50px;">
                                <?php else: ?>
                                    <img src="<?= BASE_URL ?>/public/images/no-image.jpg" 
                                         alt="No Image" 
                                         class="img-thumbnail" style="max-width: 50px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product->name) ?></td>
                            <td><?= htmlspecialchars($product->category_name) ?></td>
                            <td><?= number_format($product->price, 0, ',', '.') ?> đ</td>
                            <td><?= $product->stock ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($product->created_at)) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/product/edit/<?= $product->id ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="<?= BASE_URL ?>/product/delete/<?= $product->id ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?> 