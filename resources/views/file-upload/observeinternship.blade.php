@extends('layouts.app')

@section('title', 'Duyệt Báo Cáo Thực Tập - Giáo Viên')

@section('content')
    <div class="container">
        <h1 class="mt-4">Báo Cáo Thực Tập Sinh Viên</h1>
        @if($internships->count())
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>File Nộp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($internships as $internship)
                    <tr>
                        <td>{{ $internship->id }}</td>
                        <td>{{ $internship->title }}</td>
                        <td>{{ $internship->description }}</td>
                        <td>
                            @if($internship->report_file)
                                <a href="{{ asset('storage/' . $internship->report_file) }}" target="_blank" class="btn btn-sm btn-info">Tải file</a>
                            @else
                                <span class="text-muted">Chưa nộp</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $internships->links() }}
        @else
            <p>Không có báo cáo thực tập nào để duyệt.</p>
        @endif
    </div>
@endsection
