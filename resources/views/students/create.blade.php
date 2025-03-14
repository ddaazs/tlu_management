@extends('layouts.app')

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card" style="width: 50%; min-width: 500px;">
        <div class="card-header bg-success text-white" style="position: sticky; top: 0; z-index: 10;">
            <h4 class="mb-0 text-center">Thêm sinh viên mới</h4>
        </div>
        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Mã tài khoản (Account ID):</label>
                    <input type="text" name="account_id" class="form-control" value="{{ old('account_id') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Họ và tên:</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại:</label>
                    <input type="text" name="phone_number" class="form-control" pattern="^0[0-9]{9}$" title="Số điện thoại phải có 10 chữ số và bắt đầu bằng 0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày sinh:</label>
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính:</label>
                    <select name="gender" class="form-select" required>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lớp:</label>
                    <select name="class" class="form-select" required>
                        @for ($i = 1; $i <= 100; $i++)
                            <option value="Lớp {{ $i }}">Lớp {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngành:</label>
                    <input type="text" name="major" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('students.search') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
