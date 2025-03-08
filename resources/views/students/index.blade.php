@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="text-center mb-4"> </h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Thanh tìm kiếm -->
    <form id="search-form" action="{{ route('students.search') }}" method="GET" class="mb-4">
    <div class="row g-3 align-items-center">
        <!-- Ô nhập tên sinh viên -->
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Nhập tên sinh viên..." value="{{ request('full_name') }}">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </div>
    
    <div class="row g-3 align-items-center mt-2">
        <!-- Chọn ngành -->
        <div class="col-md-3">
            <select id="major" name="major" class="form-control">
                <option value="">NGÀNH</option>
                <option value="Cơ Khí" {{ request('major') == 'Cơ Khí' ? 'selected' : '' }}>Cơ Khí</option>
                <option value="CNTT" {{ request('major') == 'CNTT' ? 'selected' : '' }}>CNTT</option>
                <option value="Xây dựng" {{ request('major') == 'Xây dựng' ? 'selected' : '' }}>Xây dựng</option>
                <option value="Kinh tế" {{ request('major') == 'Kinh tế' ? 'selected' : '' }}>Kinh tế</option>
            </select>
        </div>
        
        <!-- Chọn lớp -->
        <div class="col-md-3">
    <select id="class" name="class" class="form-control">
        <option value="">LỚP</option>
        @for ($i = 1; $i <= 100; $i++)
            <option value="Lớp {{ $i }}" {{ request('class') == "Lớp $i" ? 'selected' : '' }}>
                Lớp {{ $i }}
            </option>
        @endfor
    </select>
</div>

        
        <!-- Nút lọc -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary w-100">
                <i class="fas fa-filter"></i> Lọc
            </button>
        </div>
    </div>
        
       
    </form>

    <!-- Bảng hiển thị sinh viên -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Mã sinh viên</th>
                    <th>Họ và tên</th>
                    <th>Lớp</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->account_id }}</td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
   
                   



 
</div>
@endsection
