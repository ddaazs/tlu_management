
        <ul class="nav nav-pills flex-column mb-auto">
          {{-- <li>
            <a href="{{ route('students.search') }}" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Sinh viên
            </a>
          </li> --}}
          <li>
            <a href="{{ route('projects.index') }}" class="nav-link {{ request()->is('projects*') ? 'active' : 'text-white' }}">
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
 



