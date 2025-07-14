<?php require_once BASE_PATH . '/app/views/admin/templates/header.php'; ?>

<div class="row">
    <div class="col-md-3">
        <div class="stats-card primary">
            <i class="fas fa-box"></i>
            <h3><?= $total_products ?></h3>
            <p>Sản phẩm</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card success">
            <i class="fas fa-list"></i>
            <h3><?= $total_categories ?></h3>
            <p>Danh mục</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card warning">
            <i class="fas fa-shopping-cart"></i>
            <h3><?= $total_orders ?></h3>
            <p>Đơn hàng</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card danger">
            <i class="fas fa-users"></i>
            <h3><?= $total_users ?></h3>
            <p>Người dùng</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_orders)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td><?= $order->id ?></td>
                                        <td><?= htmlspecialchars($order->user_name) ?></td>
                                        <td><?= number_format($order->total_amount, 0, ',', '.') ?> đ</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch ($order->status) {
                                                case 'pending':
                                                    $status_class = 'warning';
                                                    $status_text = 'Chờ xử lý';
                                                    break;
                                                case 'processing':
                                                    $status_class = 'info';
                                                    $status_text = 'Đang xử lý';
                                                    break;
                                                case 'shipped':
                                                    $status_class = 'primary';
                                                    $status_text = 'Đang giao';
                                                    break;
                                                case 'delivered':
                                                    $status_class = 'success';
                                                    $status_text = 'Đã giao';
                                                    break;
                                                case 'cancelled':
                                                    $status_class = 'danger';
                                                    $status_text = 'Đã hủy';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge bg-<?= $status_class ?>"><?= $status_text ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Không có đơn hàng nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Người dùng mới</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_users)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_users as $user): ?>
                                    <tr>
                                        <td><?= $user->id ?></td>
                                        <td><?= htmlspecialchars($user->full_name) ?></td>
                                        <td><?= htmlspecialchars($user->email) ?></td>
                                        <td><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Không có người dùng mới.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/admin/templates/footer.php'; ?> 