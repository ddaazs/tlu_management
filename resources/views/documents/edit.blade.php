@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Chỉnh Sửa Tài Liệu Mẫu</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề:</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ $document->title }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ $document->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Chọn file (pdf, doc, docx, tối đa 5MB):</label>
{{--                @if($document->file)--}}
{{--                    <p>Tệp hiện tại: {{ $document->file }}--}}
{{--                        <a href="{{ asset('storage/' . $document->file) }}" target="_blank">Tải tệp</a>--}}
{{--                    </p>--}}
{{--                @endif--}}
                <input type="file" name="file" id="file" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
