@extends('layouts.app')

@section('title', 'Chỉnh Sửa Đề Tài')
@section('content')
<div class="container">
    <h2 class="text-center mb-4">Chỉnh Sửa Đề Tài</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('topics.update', $topic->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Tên Đề Tài</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $topic->title }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $topic->description }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">Giảng Viên</label>
                    <select class="form-control" id="lecturer_id" name="lecturer_id">
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ $topic->lecturer_id == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                    <a href="{{ route('topics.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection