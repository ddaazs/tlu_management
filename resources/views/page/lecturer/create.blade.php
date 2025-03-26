@extends('layouts.app')

@section('title', 'Thêm giảng viên')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <h1 class="mt-3 mb-3">Thêm mới giảng viên</h1>

                <div class="card-body">
                    <form method="POST" action="{{ route('lecturers.store') }}">
                        @csrf

                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Học vị -->
                        <div class="mb-3">
                            <label for="degree" class="form-label">Học vị</label>
                            <select class="form-select @error('degree') is-invalid @enderror" id="degree" name="degree" required>
                                <option value="">-- Chọn học vị --</option>
                                <option value="Thạc sĩ" {{ old('degree') == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                                <option value="Tiến sĩ" {{ old('degree') == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
                                <option value="Giáo sư" {{ old('degree') == 'Giáo sư' ? 'selected' : '' }}>Giáo sư</option>
                                <option value="Phó giáo sư" {{ old('degree') == 'Phó giáo sư' ? 'selected' : '' }}>Phó giáo sư</option>
                            </select>
                            @error('degree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bộ môn -->
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Bộ môn</label>
                            <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                                <option value="">-- Chọn bộ môn --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
