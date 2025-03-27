
        <ul class="nav nav-pills flex-column mb-auto">
          {{-- <li>
            <a href="{{ route('students.search') }}" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Sinh viên
            </a>
          </li> --}}
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
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-white" id="studentManagementDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                    Quản lý tài liệu
                </a>
                <ul class="dropdown-menu" aria-labelledby="studentManagementDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('observe.projects') }}">Quan sát đồ án</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('observe.internships') }}">Quan sát thực tập</a>
                        </li>
                </ul>
            </li>
          {{-- @endif --}}
        </ul>



