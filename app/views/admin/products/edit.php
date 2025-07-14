<?php require_once BASE_PATH . '/app/views/admin/templates/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Sửa sản phẩm</h1>
    <a href="<?= BASE_URL ?>/admin/product" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>/admin/product/update/<?= $product->id ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label required">Tên sản phẩm</label>
                        <input type="text" 
                               class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                               id="name" 
                               name="name" 
                               value="<?= htmlspecialchars($product->name) ?>" 
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
                                  rows="5"><?= htmlspecialchars($product->description) ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Danh mục</label>
                        <select class="form-select <?= isset($errors['category_id']) ? 'is-invalid' : '' ?>" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>" 
                                        <?= $product->category_id == $category->id ? 'selected' : '' ?>>
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
                        <label for="price" class="form-label required">Giá</label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" 
                                   id="price" 
                                   name="price" 
                                   min="0" 
                                   step="1000" 
                                   value="<?= $product->price ?>" 
                                   required>
                            <span class="input-group-text">đ</span>
                            <?php if (isset($errors['price'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['price'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label required">Số lượng tồn kho</label>
                        <input type="number" 
                               class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" 
                               id="stock" 
                               name="stock" 
                               min="0" 
                               value="<?= $product->stock ?>" 
                               required>
                        <?php if (isset($errors['stock'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['stock'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <?php if ($product->image): ?>
                            <div class="mb-2">
                                <img src="<?= BASE_URL ?>/public/uploads/products/<?= htmlspecialchars($product->image) ?>" 
                                     alt="<?= htmlspecialchars($product->name) ?>" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               class="form-control" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <div class="form-text">Để trống nếu không muốn thay đổi hình ảnh</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/admin/product" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/admin/templates/footer.php'; ?> 