<?php require_once BASE_PATH . '/app/views/admin/templates/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý danh mục</h1>
    <a href="<?= BASE_URL ?>/admin/category/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm danh mục
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $category->id ?></td>
                                <td><?= htmlspecialchars($category->name) ?></td>
                                <td><?= htmlspecialchars($category->description) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($category->created_at)) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/category/edit/<?= $category->id ?>" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= BASE_URL ?>/admin/category/delete/<?= $category->id ?>" 
                                          method="POST" 
                                          class="d-inline" 
                                          data-confirm="Bạn có chắc chắn muốn xóa danh mục này?">
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
                            <td colspan="5" class="text-center">Không có danh mục nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/admin/templates/footer.php'; ?> 