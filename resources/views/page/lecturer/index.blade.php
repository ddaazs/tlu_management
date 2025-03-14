@extends('layouts.app')

@section('title', 'Danh sách tài khoản')

@section('content')
    <div class="d-flex flex-column justify-content-start align-items-center mt-5" style="height: 90vh">
      @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show position-absolute">
              {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

      @elseif(session('error'))
          <div class="alert alert-danger alert-dismissible fade show position-absolute">
              {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      
      <h1>Danh sách giảng viên</h1>
      <hr>

      <div class="align-self-start mb-3">
          <a href="{{ route('import.lecturers.form') }}" class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
              Import Danh sách Giảng viên
          </a>
        <a class="btn btn-primary" href="">
        <a class="btn btn-primary" href="{{ route('lecturers.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
            Thêm giảng viên
        </a>
      </div>

        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Học vị</th>
                <th scope="col">Bộ môn</th>
                <th scope="col">Trạng thái</th>
                <th scope="col" class="text-center">Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($lecturers as $index=>$lecturer)
                <tr>
                  <th scope="row">{{ ($lecturers->currentPage() -1) * $lecturers->perPage() + $index +1}}</th>
                  <td>{{ $lecturer->full_name }}</td>
                  <td>{{ $lecturer->email }}</td>
                  <td>{{ $lecturer->phone_number }}</td>
                  <td>{{ $lecturer->degree }}</td>
                  <td>{{ $lecturer->department->name }}</td>
                  <td class="">
                      <div class="
                      @if ($lecturer->status == 'Đang làm việc') text-bg-success text-center
                      @elseif ($lecturer->status == 'Đã nghỉ việc') text-bg-danger text-center
                      @elseif ($lecturer->status == 'Chuyển công tác') text-bg-warning text-center
                      @endif
                      " style="padding:5px; border-radius:10px">
                      {{ $lecturer->status }}                   
                    </div>
                  </td>
                  <td class="d-flex justify-content-around">
                    <a href="{{ route('lecturers.edit', $lecturer) }}" class="btn btn-sm btn-primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                      Sửa
                    </a>
                    <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $lecturer->id }}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                          </svg>
                          Xóa
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{ $lecturer->id }}" tabindex="-1" aria-labelledby="confirmModalLabel-{{ $lecturer->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xóa giáo viên này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>

                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center text-black">
            {{ $lecturers->links() }}
          </div>
    </div>
@endsection
