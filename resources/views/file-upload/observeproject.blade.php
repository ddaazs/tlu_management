@extends('layouts.app')

@section('title', 'Duyệt Đồ Án - Giáo Viên')

@section('content')
    <div class="container">
        <h1 class="mt-4">Đồ Án Sinh Viên</h1>
        @if($projects->count())
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên Đồ Án</th>
                    <th>Mô tả</th>
                    <th>File Nộp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>
                            @if($project->project_file)
                                <a href="{{ asset('storage/' . $project->project_file) }}" target="_blank" class="btn btn-sm btn-info">Tải file</a>
                            @else
                                <span class="text-muted">Chưa nộp</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- Hiển thị phân trang -->
            {{ $projects->links() }}
        @else
            <p>Không có đồ án nào để duyệt.</p>
        @endif
    </div>
@endsection
