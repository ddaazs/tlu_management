@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thêm mới thực tập</h2>
    <form action="{{ route('internships.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Sinh viên</label>
            <select name="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Công ty</label>
            <select name="company_id" class="form-control" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Giảng viên hướng dẫn</label>
            <select name="instructor_id" class="form-control">
                <option value="">Không có</option>
                @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <input type="text" name="status" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>


@endsection
