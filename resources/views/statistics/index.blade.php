@extends('layouts.app')

@section('title', 'Trang Thống Kê Báo Cáo')

@section('content')
    <div class="container my-4">
        <style>
            /* Lớp CSS cho các nút xuất báo cáo */
            .btn-custom {
                background-color: #457B9D;
                border-color: #457B9D;
                color: #fff;
                transition: background-color 0.3s, border-color 0.3s;
            }
            .btn-custom:hover {
                background-color: #35678B; /* Màu đậm hơn */
                border-color: #35678B;
            }
        </style>

        <h1 class="mb-4 text-center" style="color: #333;">Trang Thống Kê Báo Cáo</h1>

        <!-- Thống kê theo Ngành -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #457B9D; color: #fff;">
                Thống kê số lượng sinh viên theo Ngành
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #457B9D; color: #fff;">
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
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.major') }}" class="btn btn-custom mt-2">Xuất Excel</a>
                    <a href="{{ route('export.major.pdf') }}" class="btn btn-custom mt-2">Xuất PDF</a>
                    <a target="_blank" href="{{ route('view.major.pdf') }}" class="btn btn-custom mt-2">Xem File(PDF)</a>
                </div>
            </div>
        </div>

        <!-- Thống kê theo Giảng Viên -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #457B9D; color: #fff;">
                Thống kê số lượng sinh viên theo Giảng Viên Hướng Dẫn
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #457B9D; color: #fff;">
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
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.lecturer') }}" class="btn btn-custom mt-2">Xuất Excel</a>
                    <a href="{{ route('export.lecturer.pdf') }}" class="btn btn-custom mt-2">Xuất PDF</a>
                    <a target="_blank" href="{{ route('view.lecturer.pdf') }}" class="btn btn-custom mt-2">Xem File(PDF)</a>
                </div>
            </div>
        </div>

        <!-- Thống kê theo Điểm Số Đồ Án -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #457B9D; color: #fff;">
                Thống kê Đồ Án theo Điểm Số
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #457B9D; color: #fff;">
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
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.score') }}" class="btn btn-custom mt-2">Xuất Excel</a>
                    <a href="{{ route('export.score.pdf') }}" class="btn btn-custom mt-2">Xuất PDF</a>
                    <a target="_blank" href="{{ route('view.score.pdf') }}" class="btn btn-custom mt-2">Xem File(PDF)</a>
                </div>
            </div>
        </div>

        <!-- Thống kê theo Trạng Thái Đồ Án -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #457B9D; color: #fff;">
                Thống kê Trạng Thái Đồ Án
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #457B9D; color: #fff;">
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
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.status') }}" class="btn btn-custom mt-2">Xuất Excel</a>
                    <a href="{{ route('export.status.pdf') }}" class="btn btn-custom mt-2">Xuất PDF</a>
                    <a target="_blank" href="{{ route('view.status.pdf') }}" class="btn btn-custom mt-2">Xem File(PDF)</a>
                </div>
            </div>
        </div>

        <!-- Thống kê Số File Nộp -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #457B9D; color: #fff;">
                Thống kê Số File Nộp
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #457B9D; color: #fff;">
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
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.submission') }}" class="btn btn-custom mt-2">Xuất Excel</a>
                    <a href="{{ route('export.submission.pdf') }}" class="btn btn-custom mt-2">Xuất PDF</a>
                    <a target="_blank" href="{{ route('view.submission.pdf') }}" class="btn btn-custom mt-2">Xem File(PDF)</a>
                </div>
            </div>
        </div>
    </div>
@endsection
