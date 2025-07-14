<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm sản phẩm mới</h3>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/product/store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select <?= isset($errors['category_id']) ? 'is-invalid' : '' ?>" 
                                    id="category_id" name="category_id">
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id ?>" <?= (isset($data['category_id']) && $data['category_id'] == $category->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['category_id'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['category_id'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
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

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <div class="input-group">
                                <input type="number" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" 
                                       id="price" name="price" min="0" step="1000" 
                                       value="<?= isset($data['price']) ? $data['price'] : '' ?>">
                                <span class="input-group-text">đ</span>
                                <?php if (isset($errors['price'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['price'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Số lượng tồn kho</label>
                            <input type="number" class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" 
                                   id="stock" name="stock" min="0" 
                                   value="<?= isset($data['stock']) ? $data['stock'] : '0' ?>">
                            <?php if (isset($errors['stock'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['stock'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Chọn file ảnh (JPG, PNG, GIF)</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/product" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?> 