@extends('layouts.app')

@section('title', 'Chi tiết Báo Cáo Thực Tập')

@section('content')
    <div class="container">
        <h1 class="mt-4">Chi tiết Báo Cáo: {{ $internship->title }}</h1>
        @if($internship->report_file)
            <div style="width: 100%; height: 600px;">
                <iframe src="{{ asset('storage/' . $internship->report_file) }}" style="width:100%; height:100%;" frameborder="0"></iframe>
            </div>
        @else
            <p>Không có file để hiển thị.</p>
        @endif
        <a href="{{ route('observe.internships') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
@endsection
