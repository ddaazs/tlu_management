@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Danh Sách Tài Liệu Mẫu</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(Gate::allows('giangvien') or Gate::allows('quantri'))
        <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3">Thêm tài liệu mới</a>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{ $document->title }}</td>
                    <td>{{ Str::limit($document->description, 50, '...') }}</td>
                    <td>
                        <a href="{{ route('documents.download', $document->id) }}" class="btn btn-success">Tải xuống</a>
                        @if(Gate::allows('giangvien') or Gate::allows('quantri'))
                        <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center text-black">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
