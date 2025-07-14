<?php require_once BASE_PATH . '/app/views/admin/templates/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý sản phẩm</h1>
    <a href="<?= BASE_URL ?>/admin/product/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <form action="<?= BASE_URL ?>/admin/product/search" method="GET" class="d-flex gap-2">
                <input type="text" 
                       name="keyword" 
                       class="form-control" 
                       placeholder="Tìm kiếm sản phẩm..." 
                       value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                                             class="img-thumbnail" 
                                             style="max-width: 50px;">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/public/images/no-image.jpg" 
                                             alt="No Image" 
                                             class="img-thumbnail" 
                                             style="max-width: 50px;">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product->name) ?></td>
                                <td><?= htmlspecialchars($product->category_name) ?></td>
                                <td><?= number_format($product->price, 0, ',', '.') ?> đ</td>
                                <td><?= $product->stock ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($product->created_at)) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/product/edit/<?= $product->id ?>" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= BASE_URL ?>/admin/product/delete/<?= $product->id ?>" 
                                          method="POST" 
                                          class="d-inline" 
                                          data-confirm="Bạn có chắc chắn muốn xóa sản phẩm này?">
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
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
</div>

<?php require_once BASE_PATH . '/app/views/admin/templates/footer.php'; ?> 