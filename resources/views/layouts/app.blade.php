<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Đại học Thủy Lợi')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      li{
        border-radius: 10px;
      }
      li:hover{
        background-color: rgb(49, 159, 203); 

      }
    </style>
</head>
<body>

    <header class="p-3 border-bottom" style="background-color: #D9D9D9; width:100%">
        <div class="container-fluid">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
              <img class="bi me-2" width="55" height="42" role="img" aria-label="Bootstrap" src="{{ asset('images/tlu/tlu_logo.png') }}" alt="logo đhtl">
            </a>
    
            {{-- <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li>
              <li><a href="#" class="nav-link px-2 link-body-emphasis">Inventory</a></li>
              <li><a href="#" class="nav-link px-2 link-body-emphasis">Customers</a></li>
              <li><a href="#" class="nav-link px-2 link-body-emphasis">Products</a></li>
            </ul> --}}
    
            {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
              <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form> --}}
    
            <div class="dropdown text-end">
              <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <strong>{{ Auth::user()->name }}</strong>
              </a>
              <ul class="dropdown-menu text-small">
                {{-- <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li> --}}
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Đăng xuất</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>
    
      {{-- <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary" style="width: 4.5rem;">
        <a href="/" class="d-block p-3 link-body-emphasis text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
          <svg class="bi pe-none" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="visually-hidden">Icon-only</span>
        </a>
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
          <li class="nav-item">
            <a href="#" class="nav-link active py-3 border-bottom rounded-0" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
              <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Home"><use xlink:href="#home"></use></svg>
            </a>
          </li>
          <li>
            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Dashboard" data-bs-original-title="Dashboard">
              <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Dashboard"><use xlink:href="#speedometer2"></use></svg>
            </a>
          </li>
          <li>
            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Orders" data-bs-original-title="Orders">
              <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Orders"><use xlink:href="#table"></use></svg>
            </a>
          </li>
          <li>
            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Products" data-bs-original-title="Products">
              <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Products"><use xlink:href="#grid"></use></svg>
            </a>
          </li>
          <li>
            <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Customers" data-bs-original-title="Customers">
              <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Customers"><use xlink:href="#people-circle"></use></svg>
            </a>
          </li>
        </ul>
        <div class="dropdown border-top">
          <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
      </div> --}}
<div class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-dark" style="width: 280px; height: 100vh; background-color: #457B9D" id="sidebar">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
          <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
          {{-- @if(Auth::user()->role == 'quantri') --}}
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white" aria-current="page">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
              Tài khoản
            </a>
          </li>
          <li>
            <a href="{{ route('students.search') }}" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Sinh viên
            </a>
          </li>
          <li>
            <a href="{{ route('lecturers.index') }}" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              Giảng viên
            </a>
          </li>
          <li>
            <a href="#" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
              Đồ án
            </a>
          </li>
          <li>
            <a href="#" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Thực tập
            </a>
          </li>
          <li>
            <a href="#" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Tài liệu
            </a>
          </li>
          <li>
            <a href="#" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Báo cáo
            </a>
          </li>
          {{-- @endif --}}
        </ul>
      </div>

      <div class="container">
        {{-- <div class="content p-4" style="margin-left: 280px; width: calc(100% - 280px); margin-top: 56px;">
        <h2>Main Content</h2>
        <p>This is the main content area.</p>
      </div> --}}
      @yield('content')
      </div>
      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>