        <ul class="nav nav-pills flex-column mb-auto">
          {{-- @if(Auth::user()->role == 'quantri') --}}
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : 'text-white' }}" aria-current="page">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
              Tài khoản
            </a>
          </li>
          {{-- <li>
            <a href="{{ route('students.search') }}" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Sinh viên
            </a>
          </li> --}}
          <li>
            <a href="{{ route('lecturers.index') }}" class="nav-link {{ request()->is('lecturers*') ? 'active' : 'text-white' }}">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              Giảng viên
            </a>
          </li>
          <li>
            <a href="{{ route('topics.index') }}" class="nav-link {{ request()->is('topics*') ? 'active' : 'text-white' }}">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
              Đồ án
            </a>
          </li>
          <li>
            <a href="{{ route('internships.index') }}" class="nav-link {{ request()->is('internships*') ? 'active' : 'text-white' }}">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Thực tập
            </a>
          </li>
          <li>
            <a href="{{ route('documents.index') }}" class="nav-link {{ request()->is('documents*') ? 'active' : 'text-white' }}">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Tài liệu
            </a>
          </li>
          <li>
            <a href="{{ route('statistics.index') }}" class="nav-link {{ request()->is('statistics*') ? 'active' : 'text-white' }}">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Báo cáo
            </a>
          </li>
          {{-- @endif --}}
        </ul>
  



