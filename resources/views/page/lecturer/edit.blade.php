@extends('layouts.app')

@section('title', 'Tài khoản')
    
@section('content')
<div class="wrapper">
    <h2 class="mb-3">Chỉnh sửa thông tin giảng viên</h2>
    
    <form method="POST" action="{{ route('lecturers.update', $lecturer->id) }}">
        @csrf
        @method('PUT')

        <!-- Họ tên -->
        <div class="mb-3">
            <label for="full_name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="full_name" name="full_name" 
                   value="{{ old('full_name', $lecturer->full_name) }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email', $lecturer->email) }}" required>
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" 
                   value="{{ old('phone_number', $lecturer->phone_number) }}" required>
        </div>

        <!-- Học vị -->
        <div class="mb-3">
            <label for="degree" class="form-label">Học vị</label>
            <select class="form-select" id="degree" name="degree" required>
                <option value="Cử nhân" {{ $lecturer->degree == 'Cử nhân' ? 'selected' : '' }}>Cử nhân</option>
                <option value="Thạc sĩ" {{ $lecturer->degree == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                <option value="Tiến sĩ" {{ $lecturer->degree == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
                <option value="Giáo sư" {{ $lecturer->degree == 'Giáo sư' ? 'selected' : '' }}>Giáo sư</option>
            </select>
        </div>

        <!-- Bộ môn -->
        <div class="mb-3">
            <label for="department" class="form-label">Bộ môn</label>
            <select class="form-select" id="department" name="department_id" required>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" 
                            {{ $lecturer->department_id == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Đang làm việc" {{ $lecturer->status == 'Đang làm việc' ? 'selected' : '' }}>Đang làm việc</option>
                <option value="Đã nghỉ việc" {{ $lecturer->status == 'Đã nghỉ việc' ? 'selected' : '' }}>Đã nghỉ việc</option>
                <option value="Chuyển công tác" {{ $lecturer->status == 'Chuyển công tác' ? 'selected' : '' }}>Chuyển công tác</option>
            </select>
        </div>

        <!-- Nút lưu -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

@endsection