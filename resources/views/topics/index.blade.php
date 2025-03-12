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
                        <button class="btn btn-success btn-sm assign-btn" data-bs-toggle="modal" data-bs-target="#assignModal" 
                            data-topic-id="{{ $topic->id }}">
                            Phân công
                        </button>
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
<!-- Modal Phân Công -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Phân Công Đề Tài</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('topics.assign') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="topic_id" name="topic_id">

                    <div class="mb-3">
                        <label for="lecturer_id" class="form-label">Chọn Giảng Viên</label>
                        <select class="form-select" id="lecturer_id" name="lecturer_id" required>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="student_id" class="form-label">Chọn Sinh Viên</label>
                        <select class="form-select" id="student_id" name="student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".assign-btn").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("topic_id").value = this.getAttribute("data-topic-id");
            });
        });
    });
</script>

@endsection
