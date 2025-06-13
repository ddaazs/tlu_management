Khi clone về chạy lệnh\
composer install\
để tải các package composer\
Sau đó cp .env.example .env để tạo file môi trường\
chạy php artisan key:generate
Chỉnh lại DB trong env\
chạy php artisan migrate để chạy DB\
chạy php artisan serve để chạy server

Về mục tiêu:
Project Dùng design pattern dựa theo https://refactoring.guru/design-patterns/behavioral-patterns\
Tùy vào controller đã chọn rồi thay đổi theo design pattern
