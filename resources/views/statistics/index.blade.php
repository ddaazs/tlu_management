@extends('layouts.app')

@section('title', 'Trang Thống Kê Báo Cáo')

@section('content')
    <div class="container">
        <h1 class="mt-4">Trang Thống Kê Báo Cáo</h1>

        <!-- Thống kê theo ngành -->
        <h2 class="mt-4">Thống kê theo Ngành</h2>
        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>Ngành</th>
                <th>Số lượng sinh viên</th>
            </tr>
            </thead>
            <tbody>
            @foreach($byMajor as $record)
                <tr>
                    <td>{{ $record->major }}</td>
                    <td>{{ $record->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('export.major') }}" class="btn btn-primary mb-3">Xuất báo cáo theo ngành (Excel)</a>

        <!-- Thống kê theo giảng viên -->
        <h2 class="mt-4">Thống kê theo Giảng Viên Hướng Dẫn</h2>
        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>Giảng viên</th>
                <th>Số lượng sinh viên</th>
            </tr>
            </thead>
            <tbody>
            @foreach($byLecturer as $record)
                <tr>
                    <td>{{ $record->instructor->full_name ?? 'N/A' }}</td>
                    <td>{{ $record->total_students }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('export.lecturer') }}" class="btn btn-primary mb-3">Xuất báo cáo theo giảng viên (Excel)</a>

        <!-- Thống kê theo điểm số đồ án -->
        <h2 class="mt-4">Thống kê theo Điểm Số Đồ Án</h2>
        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>Điểm số</th>
                <th>Số lượng sinh viên</th>
            </tr>
            </thead>
            <tbody>
            @foreach($byScore as $record)
                <tr>
                    <td>{{ $record->score }}</td>
                    <td>{{ $record->total_students }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('export.score') }}" class="btn btn-primary mb-3">Xuất báo cáo theo điểm số (Excel)</a>

        <!-- Thống kê theo trạng thái đồ án -->
        <h2 class="mt-4">Thống kê Trạng Thái Đồ Án</h2>
        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>Trạng thái</th>
                <th>Số lượng</th>
            </tr>
            </thead>
            <tbody>
            @foreach($byStatus as $record)
                <tr>
                    <td>{{ $record->status }}</td>
                    <td>{{ $record->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('export.status') }}" class="btn btn-primary mb-3">Xuất báo cáo trạng thái (Excel)</a>

        <!-- Thống kê số file nộp -->
        <h2 class="mt-4">Thống kê Số File Nộp</h2>
        <table class="table table-bordered">
            <thead class="table-light">
            <tr>
                <th>Loại File</th>
                <th>Số lượng</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Đồ Án</td>
                <td>{{ $projectCount }}</td>
            </tr>
            <tr>
                <td>Báo Cáo Thực Tập</td>
                <td>{{ $internshipCount }}</td>
            </tr>
            </tbody>
        </table>
        <a href="{{ route('export.submission') }}" class="btn btn-primary mb-3">Xuất báo cáo số file nộp (Excel)</a>
    </div>
@endsection
