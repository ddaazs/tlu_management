@extends('layouts.app')

@section('title', 'Thống Kê Điểm Số Đồ Án')

@section('content')
    <div class="container">
        <h1 class="mt-4">Thống kê số lượng sinh viên theo điểm số của đồ án</h1>
        @if($byScore->count())
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
        @else
            <p>Không có dữ liệu.</p>
        @endif
    </div>
@endsection
