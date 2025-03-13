@extends('layouts.app')

@section('content')


<div class="container">
    <h2 class="text-center mb-4">Danh Sách Thực Tập</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2">
        <div class="mb-3 text-end">
            <a href="{{ route('internships.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Thực Tập
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Sinh viên</th>
                    <th>Công ty</th>
                    <th>Giảng viên hướng dẫn</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $internship)
                <tr>
                    <td>{{ $internship->id }}</td>
                    <td>{{ Str::limit($internship->title, 10, '...') }}</td>
                    <td>{{ optional($internship->student)->full_name ?? 'Không có' }}</td>
                    <td>{{ optional($internship->company)->company_name ?? 'Không có' }}</td>
                    <td>{{ optional($internship->instructor)->full_name ?? 'Không có' }}</td>
                    <td>{{ $internship->start_date }}</td>
                    <td>{{ $internship->end_date }}</td>
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
                        <a href="{{ route('internships.show', ['internship' => $internship->id]) }}" class="btn btn-primary btn-sm">Xem</a>
                        <a href="{{ route('internships.edit', ['internship' => $internship->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">{{ $internships->links('pagination::bootstrap-5') }}</li>
            </ul>
        </nav>
    </div>
</div>


@endsection