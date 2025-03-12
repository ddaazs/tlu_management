@extends('layouts.app')

@section('title', 'Thống Kê Trạng Thái Đồ Án')

@section('content')
    <div class="container">
        <h1 class="mt-4">Thống kê trạng thái của đồ án</h1>
        @if($byStatus->count())
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
        @else
            <p>Không có dữ liệu.</p>
        @endif
        <a href="{{ route('statistics.export.status') }}" class="btn btn-primary mt-3">Xuất báo cáo (Excel)</a>
    </div>
@endsection
