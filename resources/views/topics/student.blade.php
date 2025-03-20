@extends('layouts.app')

@section('content')
<style>
    .table-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .custom-pagination .page-item {
        margin: 0 5px; /* Tạo khoảng cách ngang giữa các nút */
    }
    
</style>
<div class="container">
    <h2 class="text-center mb-4">Danh Sách Đề Tài</h2>

    {{-- Thông báo --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2">
        {{-- Danh sách đồ án --}}
        <div class="mb-3 text-end">
            <a href="{{ route('projects.student') }}" class="btn btn-success">
                <i class="fas fa-list"></i> Danh Sách Đồ Án
            </a>
        </div>
        {{-- Đăng ký đề tài --}}
        <div class="mb-3 text-end">
            <a href="{{ route('topics.register') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Đăng ký đề tài
            </a>
        </div>
    </div>

    {{-- Kiểm tra và hiển thị đề tài đã đăng ký --}}
    @if($registeredTopic)
        <div class="alert alert-info">
            <h4>Đề tài đã đăng ký:</h4>
            <p><strong>Tên đề tài: {{ $registeredTopic->title }}</strong></p>
            <p>Mô tả: {{ $registeredTopic->description }}</p>
            <p>Giảng viên hướng dẫn: {{ optional($registeredTopic->lecturer)->full_name ?? 'N/A' }}</p>
        </div>
    @else
        <div class="alert alert-warning">
            Bạn chưa đăng ký đề tài nào.
        </div>
    @endif

    <h3>Danh sách đề tài</h3>

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
                @if($topics->count() > 0)
                    @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ Str::limit($topic->title, 20, '...') }}</td>
                        <td>{{ Str::limit($topic->description, 50, '...') }}</td>
                        <td>{{ optional($topic->lecturer)->full_name ?? 'N/A' }}</td>
                        <td>
                            {{ optional($topic->student)->full_name ?? 'Chưa có' }}
                        </td>
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
                            <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-primary btn-sm">Xem</a>
                            @if(is_null($topic->student_id))
                                <form action="{{ route('topics.register.submit', $topic->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Đăng ký</button>
                                </form>
                            @else
                                <span class="text-muted">Đã đăng ký</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">Hiện tại không có đề tài nào.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex flex-column align-items-center mt-4">
        
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination">
                <li class="page-item">{{ $topics->links('pagination::bootstrap-5') }}</li>
            </ul>
        </nav>
    </div>
</div>

@endsection
