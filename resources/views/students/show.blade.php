@extends('layouts.app')

@section('content')
    <h2>Chi tiết sinh viên</h2>
    <p><strong>Họ và tên:</strong> {{ $student->full_name }}</p>
    <p><strong>Email:</strong> {{ $student->email }}</p>
    <p><strong>Ngày sinh:</strong> {{ $student->date_of_birth }}</p>
    <p><strong>Giới tính:</strong> {{ $student->gender }}</p>
    <p><strong>Lớp:</strong> {{ $student->class }}</p>
    <p><strong>Ngành:</strong> {{ $student->major }}</p>
    <a href="{{ route('students.search') }}" class="btn btn-secondary">Quay lại</a>
@endsection
