<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê theo giảng viên</title>
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
<h1>Báo cáo thống kê theo giảng viên hướng dẫn</h1>
<table>
    <thead>
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
</body>
</html>
