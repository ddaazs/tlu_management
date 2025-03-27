@extends('layouts.app')

@section('title', 'Chi tiết Đồ Án')

@section('content')
    <div class="container">
        <h1 class="mt-4">Chi tiết Đồ Án: {{ $project->name }}</h1>
        @if($project->project_file)
            <!-- Nhúng file PDF qua iframe -->
            <div style="width: 100%; height: 600px;">
                <iframe src="{{ asset('storage/' . $project->project_file) }}" style="width:100%; height:100%;" frameborder="0"></iframe>
            </div>
        @else
            <p>Không có file để hiển thị.</p>
        @endif
        <a href="{{ route('observe.projects') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
@endsection
