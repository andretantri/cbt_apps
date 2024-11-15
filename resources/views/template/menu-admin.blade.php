<ul class="nav-main">
    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('dashboard') }}" href="{{ route('admin.dashboard') }}">
            <i class="nav-main-link-icon fa fa-location-arrow"></i>
            <span class="nav-main-link-name">Dashboard</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
            href="#">
            <i class="nav-main-link-icon fa fa-question-circle"></i>
            <span class="nav-main-link-name">Soal</span>
        </a>

    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('ujian') }}" href="{{ route('admin.ujian') }}">
            <i class="nav-main-link-icon fa fa-pencil"></i>
            <span class="nav-main-link-name">Ujian</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('token') }}" href="{{ route('admin.token') }}">
            <i class="nav-main-link-icon fa fa-calendar"></i>
            <span class="nav-main-link-name">Token Ujian</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
            href="#">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Manajemen User</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link {{ activeMenu('user') }}" href="{{ route('admin.user') }}">
                    <i class="nav-main-link-icon fa fa-users"></i>
                    <span class="nav-main-link-name">Manajemen User</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link {{ activeMenu('operator') }}" href="{{ route('admin.operator') }}">
                    <i class="nav-main-link-icon fa fa-users"></i>
                    <span class="nav-main-link-name">Manajemen Operator</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link {{ activeMenu('admin') }}" href="{{ route('admin.admin') }}">
                    <i class="nav-main-link-icon fa fa-users"></i>
                    <span class="nav-main-link-name">Manajemen Super Admin</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('laporan') }}" href="#">
            <i class="nav-main-link-icon fa fa-print"></i>
            <span class="nav-main-link-name">Laporan</span>
        </a>
    </li>


</ul>
