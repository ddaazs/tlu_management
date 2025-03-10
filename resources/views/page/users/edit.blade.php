@extends('layouts.app')

@section('title', 'Tài khoản')
    
@section('content')
<div class="wrapper">
    <h2>Chỉnh sửa tài khoản</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT') 
        
        <!-- Họ tên -->
        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror
        </div>

        <!-- Tên đăng nhập -->
        <div class="mb-3">
            <label for="email" class="form-label">Tên đăng nhập (Email)</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror
        </div>

        <!-- Mật khẩu (Không bắt buộc, chỉ cập nhật nếu nhập) -->
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="text-muted">Để trống nếu không muốn thay đổi</small>
        </div>

        <!-- Vai trò -->
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select class="form-select" id="role" name="role" required>
                <option value="quantri" {{ $user->role == 'quantri' ? 'selected' : '' }}>Quản trị viên</option>
                <option value="giangvien" {{ $user->role == 'giangvien' ? 'selected' : '' }}>Giảng viên</option>
                <option value="sinhvien" {{ $user->role == 'sinhvien' ? 'selected' : '' }}>Sinh viên</option>
            </select>
        </div>

        <!-- Nút cập nhật -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

@endsection