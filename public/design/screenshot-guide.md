# Hướng dẫn chụp ảnh màn hình cho Figma Design

## Các màn hình cần chụp

### 1. Trang chủ (Homepage)
- Toàn bộ trang chủ (full page)
- Menu navigation
- Banner chính
- Danh sách sản phẩm nổi bật
- Footer

### 2. Trang Admin
- Dashboard với 4 thẻ thống kê
- Bảng danh sách đơn hàng gần đây
- Bảng danh sách người dùng mới
- Menu sidebar admin

### 3. Trang Sản phẩm
- Grid hiển thị sản phẩm
- Card sản phẩm đơn lẻ
- Bộ lọc và tìm kiếm
- Phân trang

### 4. Trang Chi tiết sản phẩm
- Hình ảnh sản phẩm
- Thông tin sản phẩm
- Nút thêm vào giỏ hàng
- Mô tả sản phẩm
- Sản phẩm liên quan

### 5. Trang Giỏ hàng
- Bảng sản phẩm trong giỏ
- Form thông tin đặt hàng
- Tổng tiền và thanh toán

### 6. Trang Đăng nhập/Đăng ký
- Form đăng nhập
- Form đăng ký
- Thông báo lỗi/thành công

## Hướng dẫn chụp ảnh

1. Độ phân giải màn hình: 1920x1080px
2. Zoom trình duyệt: 100%
3. Chụp ở chế độ responsive:
   - Desktop: 1920px
   - Tablet: 768px
   - Mobile: 375px

## Cấu trúc thư mục

```
public/design/screenshots/
├── homepage/
│   ├── desktop.png
│   ├── tablet.png
│   └── mobile.png
├── admin/
│   ├── dashboard.png
│   ├── products.png
│   └── orders.png
├── products/
│   ├── list.png
│   └── detail.png
├── cart/
│   └── cart.png
└── auth/
    ├── login.png
    └── register.png
```

## Quy tắc đặt tên file

- Sử dụng chữ thường
- Phân tách bằng dấu gạch ngang
- Thêm hậu tố thiết bị (-desktop, -tablet, -mobile)
- Ví dụ: homepage-desktop.png, products-list-mobile.png

## Công cụ chụp ảnh

1. Windows: 
   - Snipping Tool
   - Windows + Shift + S
   - Browser Developer Tools (F12) cho chế độ responsive

2. MacOS:
   - Command + Shift + 4
   - Command + Shift + 5
   - Browser Developer Tools (F12) cho chế độ responsive

## Import vào Figma

1. Tạo file Figma mới
2. Tổ chức theo pages:
   - 📱 Components
   - 🎨 Style Guide
   - 🏠 Homepage
   - 👤 Admin
   - 🛍️ Products
   - 🛒 Cart
   - 🔐 Auth

3. Import ảnh vào từng page tương ứng
4. Sử dụng auto-layout và constraints
5. Tạo components cho các elements lặp lại
6. Áp dụng style guide (colors, typography, spacing) 