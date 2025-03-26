
@extends('layouts.app')
@section('content')
<style>
    
    .badge-cancelled {
        background-color: #dc3545 !important; /* Màu nền đỏ */
        color: white !important; /* Chữ trắng */
        border: 1px solid #dc3545 !important; /* Viền đỏ */
        padding: 2px 6px; /* Giảm padding để nhỏ lại */
        border-radius: 4px;
        font-size: 12px; /* Giảm cỡ chữ */
        font-weight: bold;
        white-space: nowrap; /* Tránh bị cắt chữ */
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Danh Sách Đồ Án</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Nút thêm đề tài mới -->
    <div class="d-flex gap-2">
        <div class="mb-3 text-end">
            <a href="{{ route('topics.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Đề Tài Mới
            </a>
        </div>

        <div class="mb-3 text-end">
            <a href="{{ route('topics.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Danh Sách Đề Tài
            </a>
        </div>
        
    </div>

    <!-- Bảng hiển thị đồ án -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên đồ án</th>
                    <th>Mô tả</th>
                    <th>Sinh viên</th>
                    <th>Giảng viên</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td class="text-truncate" style="max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ $project->description }}</td>
                        <td>{{ optional($project->student)->full_name ?? 'N/A' }}</td>
                        <td>{{ optional($project->instructor)->full_name ?? 'N/A' }}</td>
                        <td>
                            @if($project->status == 'Đang thực hiện')
                                <span class="badge bg-warning">Đang thực hiện</span>
                            @elseif($project->status == 'Hoàn thành')
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge badge-cancelled">Huỷ bỏ</span>
                            @endif
                        </td>
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center text-black">
        {{ $projects->links() }}
      </div>
</div>
@endsection
