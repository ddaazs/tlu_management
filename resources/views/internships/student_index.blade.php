@extends('layouts.app')

@section('title', 'Danh Sách Thực Tập')
@section('content')
<style>
    .custom-pagination .page-item {
        margin: 0 5px; /* Tạo khoảng cách ngang giữa các nút */
    }
    
</style>
<div class="container">
    <h2>Danh sách Thực tập</h2>
    
    <!-- Nút đăng ký thực tập -->
    <a href="{{ route('internships.studentCreate') }}" class="btn btn-success mb-3">Đăng ký thực tập</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Công ty</th>
                <th>Giảng viên hướng dẫn</th>
                <th>Ngày bắt đầu</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($internships as $internship)
                <tr>
                    <td>{{ $internship->title }}</td>
                    <td>{{ $internship->description }}</td>
                    <td>{{ $internship->company->company_name }}</td>
                    <td>{{ $internship->instructor->full_name ?? 'Chưa có' }}</td>
                    <td>{{ $internship->start_date }}</td>
                    <td>
                        @if($internship->status == 'Đang thực tập')
                            <span class="badge bg-warning">Đang thực tập</span>
                        @elseif($internship->status == 'Hoàn thành')
                            <span class="badge bg-success">Hoàn thành</span>
                        @elseif($internship->status == 'Chưa bắt đầu')
                            <span class="badge bg-secondary">Chưa bắt đầu</span>
                        @endif
                    </td>
        
                    <td>
                        <a href="{{ route('internships.show', $internship->id) }}" class="btn btn-info btn-sm">Xem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex flex-column align-items-center mt-4">
        
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination">
                <li class="page-item">{{ $internships->links('pagination::bootstrap-5') }}</li>
            </ul>
        </nav>
    </div>
</div>
@endsection
