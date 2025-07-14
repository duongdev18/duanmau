<?php require_once BASE_PATH . '/app/views/admin/templates/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Sửa danh mục</h1>
    <a href="<?= BASE_URL ?>/admin/category" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/admin/category/update/<?= $category->id ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label required">Tên danh mục</label>
                <input type="text" 
                       class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($category->name) ?>" 
                       required>
                <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['name'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" 
                          id="description" 
                          name="description" 
                          rows="3"><?= htmlspecialchars($category->description) ?></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/admin/category" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/admin/templates/footer.php'; ?> 