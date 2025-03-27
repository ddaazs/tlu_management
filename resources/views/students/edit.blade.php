@extends('layouts.app')

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card shadow-sm" style="width: 60%; max-height: 600px; overflow-y: auto;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chỉnh sửa sinh viên</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Họ và tên:</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $student->full_name) }}" required pattern="^[\p{L} ]+$" title="Tên không được chứa số hoặc ký tự đặc biệt">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại:</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $student->phone_number) }}" required pattern="^0[0-9]{9}$" title="Số điện thoại phải có 10 chữ số và bắt đầu bằng 0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày sinh:</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính:</label>
                    <select name="gender" class="form-select" required>
                        <option value="Nam" {{ old('gender', $student->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender', $student->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lớp:</label>
                    <input type="text" name="class" class="form-control" value="{{ old('class', $student->class) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngành:</label>
                    <input type="text" name="major" class="form-control" value="{{ old('major', $student->major) }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('students.search') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
