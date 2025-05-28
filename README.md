Khi clone về chạy lệnh
composer install
để tải các package composer
Sau đó cp .env.example .env để tạo file môi trường
Chỉnh lại DB trong env
chạy php artisan migrate để chạy DB
chạy php artisan serve để chạy server

Về mục tiêu:
Project sửa dùng theo mẫu: Service Layer Pattern
Cách hoạt động của mẫu:

-   Thay vì để tất cả xử lý trong controller thì sẽ xử lý logic ở Service
-   Controller chỉ gọi service rồi return
    => Code dễ nhìn hơn, thay đổi dễ hơn
