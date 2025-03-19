<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê theo điểm số</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #457B9D;
            color: #fff;
        }
    </style>
</head>
<body>
<h1>Báo cáo thống kê theo điểm số đồ án</h1>
<table>
    <thead>
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
</body>
</html>
