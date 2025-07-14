<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sản phẩm trong danh mục: <?= htmlspecialchars($category->name) ?></h2>
        <a href="<?= BASE_URL ?>/product" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    <?php if (!empty($products)): ?>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <?php if ($product->image): ?>
                            <img src="<?= BASE_URL ?>/public/uploads/products/<?= htmlspecialchars($product->image) ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?= BASE_URL ?>/public/images/no-image.jpg" 
                                 class="card-img-top" alt="No Image"
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($product->description) ?></p>
                            <p class="card-text">
                                <strong>Giá: </strong><?= number_format($product->price, 0, ',', '.') ?> đ<br>
                                <strong>Tồn kho: </strong><?= $product->stock ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/product/edit/<?= $product->id ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="<?= BASE_URL ?>/product/delete/<?= $product->id ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Không có sản phẩm nào trong danh mục này.
        </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?> 