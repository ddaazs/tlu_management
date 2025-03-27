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
      <h1>Danh sách tài khoản</h1>
      <hr>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Vai trò</th>
                <th scope="col">Trạng thái</th>
                <th scope="col" class="text-center">Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $index=>$user)
                <tr>
                  <th scope="row">{{ ($users->currentPage() -1) * $users->perPage() + $index +1}}</th>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->role }}</td>
                  <td>
                    <div class="
                    @if($user->status == 'active') text-bg-success text-center
                    @elseif($user->status == 'inactive') text-bg-warning text-center
                    @elseif($user->status == 'banned') text-bg-danger text-center
                    @endif
                    " style="padding: 5px; border-radius:10px;">
                    @if($user->status == 'active') Đang hoạt động
                    @elseif($user->status == 'inactive') Đã khóa
                    @elseif($user->status == 'banned') Khóa vĩnh viễn
                    @endif
                    </div>
                    
                  </td>
                  <td class="d-flex justify-content-around">
                    @if($user->status != 'banned')
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                      Sửa
                    </a>
                     <!-- Nút Khóa/Mở khóa -->
                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('PATCH')
                        @if($user->status === 'active')
                            <button type="submit" class="btn btn-sm btn-warning" style="width:100px">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                              </svg>
                              Khóa
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-success" style="width:100px">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                                <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2"/>
                              </svg>
                              Mở khóa
                            </button>
                        @endif
                    </form>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $user->id }}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                          </svg>
                          Xóa
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{ $user->id }}" tabindex="-1" aria-labelledby="confirmModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Hành động này sẽ khóa tài khoản vĩnh viễn!!
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
                  @else 
                  <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-success" style="width:100px">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                        <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2"/>
                      </svg>
                      Mở khóa
                  </button>
                  </form>                   
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center text-black">
            {{ $users->links() }}
          </div>
    </div>
@endsection