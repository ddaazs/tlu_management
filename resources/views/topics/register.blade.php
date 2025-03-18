@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Đăng Ký Đề Tài</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('topics.storeStudent') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề đề tài</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="lecturer_id" class="form-label">Chọn giảng viên hướng dẫn</label>
            <select class="form-control" id="lecturer_id" name="lecturer_id" required>
                @foreach($lecturers as $lecturer)
                    <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Gửi đăng ký</button>
        <a href="{{ route('topics.student') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
