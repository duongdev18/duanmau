# PHP E-commerce Website (MVC)

Đây là website bán hàng được xây dựng bằng PHP theo mô hình MVC.

## Yêu cầu hệ thống
- PHP >= 7.4
- MySQL
- XAMPP

## Cấu trúc thư mục
```
app/
├── config/         # Cấu hình database và các thiết lập khác
├── controllers/    # Các controller xử lý logic
├── models/        # Các model tương tác với database
├── views/         # Giao diện người dùng
├── core/          # Các class core của framework
└── helpers/       # Các hàm tiện ích

public/
├── css/           # File CSS
├── js/            # File JavaScript
└── images/        # File hình ảnh

```

## Cài đặt
1. Clone repository này vào thư mục htdocs của XAMPP
2. Import file database.sql vào MySQL
3. Cấu hình kết nối database trong file app/config/database.php
4. Truy cập website qua: http://localhost/duanmau 