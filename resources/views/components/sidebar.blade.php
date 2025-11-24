@props(['active' => false])

<nav class="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-tasks"></i> {{ Auth::user()->role === 'admin' ? 'Task Management' : 'Task Manager' }}</h3>
    </div>

    {{-- Main Menu Items --}}
    <ul class="nav flex-column">
        @php $role = Auth::user()->role ?? 'member'; @endphp

        {{-- Dashboard --}}
        <li class="nav-item">
            @if($role === 'admin')
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            @elseif($role === 'leader')
                <a class="nav-link {{ request()->routeIs('leader.dashboard') ? 'active' : '' }}"
                   href="{{ route('leader.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            @else
                <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                   href="{{ route('member.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            @endif
        </li>

        {{-- Role-specific Menu Items --}}
        @if($role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Quản Lý User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"
                   href="{{ route('admin.projects.index') }}">
                    <i class="fas fa-project-diagram"></i> Quản Lý Dự Án
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
                   href="{{ route('admin.reports') }}">
                    <i class="fas fa-chart-bar"></i> Thống Kê Tổng Thể
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                   href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog"></i> Cài Đặt Hệ Thống
                </a>
            </li>

        @elseif($role === 'leader')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leader.projects.*') ? 'active' : '' }}"
                   href="{{ route('leader.projects.index') }}">
                    <i class="fas fa-project-diagram"></i> Dự Án
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leader.tasks.*') ? 'active' : '' }}"
                   href="{{ route('leader.tasks.index') }}">
                    <i class="fas fa-list-check"></i> Công Việc
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leader.team.index') ? 'active' : '' }}"
                   href="{{ route('leader.team.index') }}">
                    <i class="fas fa-users"></i> Đội Nhóm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leader.reports') ? 'active' : '' }}"
                   href="{{ route('leader.reports') }}">
                    <i class="fas fa-chart-bar"></i> Báo Cáo
                </a>
            </li>

        @else
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('member.projects.*') ? 'active' : '' }}"
                   href="{{ route('member.projects.index') }}">
                    <i class="fas fa-project-diagram"></i> Dự Án
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('member.tasks.*') ? 'active' : '' }}"
                   href="{{ route('member.tasks.index') }}">
                    <i class="fas fa-list-check"></i> Công Việc
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('member.notifications.*') ? 'active' : '' }}"
                   href="{{ route('member.notifications.index') }}">
                    <i class="fas fa-bell"></i> Thông Báo
                    @php $notificationCount = Auth::user()->systemNotifications()->where('is_read', false)->count(); @endphp
                    @if($notificationCount > 0)
                        <span class="badge bg-danger ms-2">{{ $notificationCount }}</span>
                    @endif
                </a>
            </li>
        @endif
    </ul>

    <hr>

    {{-- User Menu Items --}}
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
               href="{{ route('profile.edit') }}">
                <i class="fas fa-user"></i> Hồ Sơ
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                </a>
            </form>
        </li>
    </ul>
</nav>
