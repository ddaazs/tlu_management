@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết Thực tập</h2>
    
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $internship->title }}</h4>
            <p><strong>Mô tả:</strong> {{ $internship->description }}</p>
            <p><strong>Sinh viên:</strong> {{ $internship->student->full_name }}</p>
            <p><strong>Công ty:</strong> {{ $internship->company->company_name }}</p>
            <p><strong>Giảng viên hướng dẫn:</strong> {{ $internship->instructor->full_name ?? 'Không có' }}</p>
            <p><strong>Ngày bắt đầu:</strong> {{ $internship->start_date }}</p>
            <p><strong>Ngày kết thúc:</strong> {{ $internship->end_date }}</p>
            <p><strong>Trạng thái:</strong> {{ $internship->status }}</p>
        </div>
    </div>
    <div class="d-flex gap-2 mt-3">
        <div class="mb-3 text-end">
            <a href="{{ route(auth()->user()->role === 'sinhvien' ? 'internships.studentIndex' : 'internships.index') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Quay lại
            </a>
        </div>
    </div>
    
</div>
@endsection
