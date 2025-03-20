@extends('layouts.app')

@section('title', 'Đăng ký Thực tập')
@section('content')
<div class="container">
    <h2>Đăng ký Thực tập</h2>
    <form action="{{ route('internships.studentStore') }}" method="POST">
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
            <label>Công ty</label>
            <select name="company_id" class="form-control" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Giảng viên hướng dẫn <span class="text-danger">*</span></label>
            <select name="instructor_id" class="form-control" required>
                <option value="" disabled selected>Chọn giảng viên...</option>
                @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control" required>
                <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                <option value="Đang thực tập">Đang thực tập</option>
                <option value="Hoàn thành">Hoàn thành</option>
            </select>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <a href="{{ route('internships.studentIndex') }}" class="btn btn-secondary">Quay lại</a>
        </div>
        
    </form>
</div>
@endsection
