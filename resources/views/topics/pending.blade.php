@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh Sách Đề Tài Chờ Duyệt</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($topics->isEmpty())
        <div class="alert alert-info">Không có đề tài nào cần duyệt.</div>
    @else
    <div class="d-flex">
        <div class="mb-3 text-end">
            <a href="{{ route('topics.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Danh Sách Đề Tài
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
                        <form action="{{ route('topics.changeStatus', ['id' => $topic->id, 'action' => 'approve']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Duyệt</button>
                        </form>
                        
                        <form action="{{ route('topics.changeStatus', ['id' => $topic->id, 'action' => 'reject']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Từ chối</button>
                        </form>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
