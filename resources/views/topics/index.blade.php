@extends('layouts.app')

@section('content')
<style>
    .table-container {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>
<div class="container">
    <h2 class="text-center mb-4">Danh Sách Đề Tài</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex gap-2">
        <div class="mb-3 text-end">
            <a href="{{ route('projects.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Danh Sách Đồ Án
            </a>
        </div>
        <div class="mb-3 text-end">
            <a href="{{ route('topics.pending') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Duyệt Đề Tài
            </a>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên đề tài</th>
                    <th>Mô tả</th>
                    <th>Giảng viên</th>
                    <th>Sinh viên</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                <tr>
                    <td>{{ $topic->id }}</td>
                    <td>{{ Str::limit($topic->title, 10, '...') }}</td>
                    <td>{{ Str::limit($topic->description, 50, '...') }}</td>
                    <td>{{ optional($topic->lecturer)->full_name ?? 'N/A' }}</td>
                    <td>{{ optional($topic->student)->full_name ?? 'N/A' }}</td>
                    <td>
                        @if($topic->status == 'pending')
                            <span class="badge bg-warning">Chờ duyệt</span>
                        @elseif($topic->status == 'approved')
                            <span class="badge bg-success">Đã duyệt</span>
                        @elseif($topic->status == 'rejected')
                            <span class="badge bg-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('topics.show', ['topic' => $topic->id]) }}" class="btn btn-primary btn-sm">Xem</a>
                        <a href="{{ route('topics.edit', ['topic' => $topic->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">{{ $topics->links('pagination::bootstrap-5') }}</li>
            </ul>
        </nav>
    </div>
</div>
@endsection
