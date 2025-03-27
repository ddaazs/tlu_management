<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Trường Đại Học Thủy Lợi</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex flex-column" style="background-color: #457B9D">
    <header>
        <div class="logo mb-4" style="background-color: white">
            <img class="mt-2" src="{{ asset('images/tlu/tlu_banner.png') }}" alt="Trường Đại Học Thủy Lợi" class="img-fluid">
        </div>
    </header>
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="card p-4" style="max-width: 500px; width: 100%;" id="login_box">
            <h2 class="text-center mb-3 ">ĐĂNG NHẬP</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 d-flex flex-start flex-column align-items-start">
                    <label for="email" class="form-label">EMAIL</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3 d-flex flex-start flex-column align-items-start">
                    <label for="password" class="form-label">MẬT KHẨU</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>
                    @error('password')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" id="login_button">ĐĂNG NHẬP
                    {{-- {{ __('Log in') }} --}}
                </button>
            </form>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">QUÊN MẬT KHẨU?</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
