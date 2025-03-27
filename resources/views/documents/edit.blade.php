@extends('layouts.app')

@section('title', 'Chỉnh Sửa Tài Liệu Mẫu')

@section('content')
    <div class="container mt-5">
        <h1>Chỉnh sửa tài liệu</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Title Field -->
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề:</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $document->title) }}">
            </div>

            <!-- Description Field -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $document->description) }}</textarea>
            </div>

            <!-- File Field -->
            <div class="mb-3">
                <label for="file" class="form-label">Chọn file (pdf, doc, docx, zip tối đa 20MB):</label>
                <input type="file" name="file" id="file" class="form-control">
                @if($document->file)
                    <p class="mt-2">Tệp hiện tại: <a href="{{ route('documents.download', $document->id) }}" target="_blank">Tải xuống</a></p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
