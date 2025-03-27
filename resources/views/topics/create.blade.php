@extends('layouts.app')

@section('title', 'Thêm Đề Tài Mới')
@section('content')
<div class="container"> 
    <h2>Thêm Đề Tài Mới</h2>
    <form action="{{ route('topics.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tên Đề Tài</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="lecturer_id" class="form-label">Chọn Giảng Viên</label>
            <select class="form-control" name="lecturer_id">
                <option value="">-- Chọn giảng viên --</option>
                @if(isset($lecturers) && $lecturers->count() > 0)
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                    @endforeach
                @else
                    <option value="">Không có giảng viên nào</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Đề Tài</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Hủy</a>

    </form>
</div>
@endsection
