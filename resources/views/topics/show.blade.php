@extends('layouts.app')

@section('title', 'Chi Tiết Đề Tài')
@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-sm" style="max-width: 700px; margin: auto;">
        <h2 class="mb-3 text-primary">{{ $topic->title }}</h2>

        <p><strong>Mô tả:</strong> {{ $topic->description }}</p>

        <h4 class="mt-3">👨‍🏫 Giảng viên hướng dẫn</h4>
        <div class="border p-3 rounded bg-light">
            <p><strong>Họ và tên:</strong> {{ $topic->lecturer['full_name'] }}</p>
            <p><strong>Email:</strong> {{ $topic->lecturer['email'] }}</p>
            <p><strong>Số điện thoại:</strong> {{ $topic->lecturer['phone_number'] }}</p>
            <p><strong>Học vị:</strong> {{ $topic->lecturer['degree'] }}</p>
            <p><strong>Sinh viên đăng ký:</strong> {{ optional($topic->student)->full_name ?? 'Chưa có sinh viên' }}</p>
        </div>

        <p class="mt-3"><strong>Trạng thái:</strong> 
            @if($topic->status == 'pending')
                <span class="badge bg-warning">Chờ duyệt</span>
            @elseif($topic->status == 'approved')
                <span class="badge bg-success">Đã duyệt</span>
            @elseif($topic->status == 'rejected')
                <span class="badge bg-danger">Từ chối</span>
            @endif
        </p>
        {{-- <div class="mb-3 text-end">
            <a href="{{ route('topics.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Quay lại
            </a>
        </div> --}}
        <div class="mb-3 text-end">
            <a href="{{ route(auth()->user()->role === 'sinhvien' ? 'topics.student' : 'topics.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Quay lại
            </a>
        </div>
    </div>
</div>

@endsection
