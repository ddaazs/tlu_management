@extends('layouts.app')

@section('title', 'Đăng ký Thực tập')
@section('content')
<div class="container">
    <h2>Đăng ký Thực tập</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('internships.studentStore') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Công ty</label>
            <select name="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Giảng viên hướng dẫn <span class="text-danger">*</span></label>
            <select name="instructor_id" class="form-control @error('instructor_id') is-invalid @enderror" required>
                <option value="" disabled selected>Chọn giảng viên...</option>
                @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}" {{ old('instructor_id') == $lecturer->id ? 'selected' : '' }}>
                        {{ $lecturer->full_name }}
                    </option>
                @endforeach
            </select>
            @error('instructor_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Chưa bắt đầu" {{ old('status') == 'Chưa bắt đầu' ? 'selected' : '' }}>Chưa bắt đầu</option>
                <option value="Đang thực tập" {{ old('status') == 'Đang thực tập' ? 'selected' : '' }}>Đang thực tập</option>
                <option value="Hoàn thành" {{ old('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <a href="{{ route('internships.studentIndex') }}" class="btn btn-secondary">Quay lại</a>
        </div>

    </form>
</div>
@endsection