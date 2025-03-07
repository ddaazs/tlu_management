
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách sinh viên</h2>
    
    <form method="GET" action="{{ route('students.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="class" class="form-control">
                    <option value="">Chọn lớp</option>
                    <option value="A" {{ request('class') == '97' ? 'selected' : '' }}>Lớp 97</option>
                    <option value="B" {{ request('class') == 'B' ? 'selected' : '' }}>Lớp B</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="major" class="form-control">
                    <option value="">Chọn ngành</option>
                    <option value="CNTT" {{ request('major') == 'CNTT' ? 'selected' : '' }}>CNTT</option>
                    <option value="QTKD" {{ request('major') == 'QTKD' ? 'selected' : '' }}>QTKD</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="gender" class="form-control">
                    <option value="">Chọn giới tính</option>
                    <option value="Nam" {{ request('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                    <option value="Nữ" {{ request('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Lớp</th>
                <th>Ngành</th>
                <th>Giới tính</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone_number }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->major }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

    <script>
        function fetchStudents() {
            let search = $('#search').val();
            let classFilter = $('#class').val();
            let majorFilter = $('#major').val();
            let genderFilter = $('#gender').val();

            $.ajax({
                url: '/students',
                method: 'GET',
                data: { search: search, class: classFilter, major: majorFilter, gender: genderFilter },
                success: function(response) {
                    let rows = '';
                    response.forEach(student => {
                        rows += `<tr>
                            <td>${student.id}</td>
                            <td>${student.full_name}</td>
                            <td>${student.email}</td>
                            <td>${student.phone_number}</td>
                            <td>${student.class}</td>
                            <td>${student.major}</td>
                            <td>${student.gender}</td>
                        </tr>`;
                    });
                    $('#student-list').html(rows);
                }
            });
        }

        $(document).ready(function() {
            fetchStudents();
            $('#search, #class, #major, #gender').on('input change', fetchStudents);
        });
    </script>
</body>
</html>
