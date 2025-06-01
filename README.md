# Laravel Project

## Hướng dẫn cài đặt

1. **Clone dự án về máy:**

   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. **Cài đặt các package:**

   ```bash
   composer install
   ```

3. **Tạo file môi trường và cấu hình database:**

   ```bash
   cp .env.example .env
   ```

   Sau đó chỉnh sửa thông tin kết nối CSDL trong file `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ten_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key:**

   ```bash
   php artisan key:generate
   ```

5. **Chạy migrate để tạo các bảng trong database:**

   ```bash
   php artisan migrate
   ```

6. **Chạy server:**

   ```bash
   php artisan serve
   ```

---

## Kiến trúc dự án

### Service Layer Pattern

Dự án sử dụng mẫu kiến trúc **Service Layer Pattern** nhằm tách biệt phần xử lý logic nghiệp vụ ra khỏi Controller. Mục tiêu của mô hình này:

- **Controller:** chỉ nhận request, gọi Service tương ứng và trả về response.
- **Service:** chứa toàn bộ logic xử lý chính của ứng dụng.
- **Repository (nếu có):** xử lý giao tiếp với database.

### Lợi ích:

- Code gọn gàng, dễ đọc, dễ bảo trì.
- Dễ mở rộng và tái sử dụng logic ở nhiều nơi.
- Dễ dàng test unit cho logic nghiệp vụ mà không cần liên quan đến HTTP layer.

---

## Cấu trúc thư mục liên quan

```
app/
├── Http/
│   └── Controllers/
│       └── [TênController].php
├── Services/
│   └── [TênService].php
├── Repositories/         (tuỳ chọn nếu có)
│   └── [TênRepository].php
```

---

## Ví dụ

### Trong Controller:

```php
public function store(Request $request)
{
    return $this->userService->createUser($request->all());
}
```

### Trong Service:

```php
public function createUser(array $data)
{
    // Logic tạo user, validate, xử lý thêm
}
```

---

## Ghi chú

- Đảm bảo đã tạo sẵn database trước khi chạy `php artisan migrate`.
- Có thể dùng thêm các package hỗ trợ như `laravel-debugbar`, `laravel-ide-helper` để hỗ trợ dev.
