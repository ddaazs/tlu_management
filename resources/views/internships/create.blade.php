@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thêm mới thực tập</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('internships.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>Sinh viên</label>
            <select name="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Công ty</label>
            <select name="company_id" class="form-control" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Giảng viên hướng dẫn</label>
            <select name="instructor_id" class="form-control">
                <option value="">Không có</option>
                @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}" {{ old('instructor_id') == $lecturer->id ? 'selected' : '' }}>
                        {{ $lecturer->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
            @error('start_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
            @error('end_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control" required>
                <option value="Chưa bắt đầu" {{ old('status') == 'Chưa bắt đầu' ? 'selected' : '' }}>Chưa bắt đầu</option>
                <option value="Đang thực tập" {{ old('status') == 'Đang thực tập' ? 'selected' : '' }}>Đang thực tập</option>
                <option value="Hoàn thành" {{ old('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('internships.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
