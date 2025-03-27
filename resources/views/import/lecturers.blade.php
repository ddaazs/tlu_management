@extends('layouts.app')

@section('title', 'Import Danh Sách Giảng Viên')

@section('content')
    <div class="container my-4">
        <h1>Import Danh Sách Giảng Viên</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form upload file Excel -->
        <form action="{{ route('import.lecturers') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Chọn file Excel (xlsx, xls, csv):</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #457B9D; border-color: #457B9D;">Import Giảng Viên</button>
            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
