<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm danh mục mới</h3>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/category/store" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" value="<?= isset($data['name']) ? htmlspecialchars($data['name']) : '' ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= isset($data['description']) ? htmlspecialchars($data['description']) : '' ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/category" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?> 