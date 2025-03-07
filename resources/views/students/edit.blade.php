@extends('layouts.app')

@section('content')
    <h2>Chỉnh sửa sinh viên</h2>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Họ và tên:</label>
        <input type="text" name="full_name" value="{{ $student->full_name }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $student->email }}" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone_number" value="{{ $student->phone_number }}">

        <label>Ngày sinh:</label>
        <input type="date" name="date_of_birth" value="{{ $student->date_of_birth }}" required>

        <label>Giới tính:</label>
        <select name="gender" required>
            <option value="Nam" {{ $student->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
            <option value="Nữ" {{ $student->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
        </select>

        <label>Lớp:</label>
        <input type="text" name="class" value="{{ $student->class }}" required>

        <label>Ngành:</label>
        <input type="text" name="major" value="{{ $student->major }}" required>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
@endsection
