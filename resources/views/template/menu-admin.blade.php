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
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                    aria-expanded="false" href="#">
                    <span class="nav-main-link-name">TWK</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 1']) }}">
                            <span class="nav-main-link-name">Bagian 1</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 2']) }}">
                            <span class="nav-main-link-name">Bagian 2</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 3']) }}">
                            <span class="nav-main-link-name">Bagian 3</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 4']) }}">
                            <span class="nav-main-link-name">Bagian 4</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 5']) }}">
                            <span class="nav-main-link-name">Bagian 5</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TWK', 'sub' => 'Bagian 6']) }}">
                            <span class="nav-main-link-name">Bagian 6</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                    aria-expanded="false" href="#">
                    <span class="nav-main-link-name">TIU</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Analogi']) }}">
                            <span class="nav-main-link-name">Analogi</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Silogisme']) }}">
                            <span class="nav-main-link-name">Silogisme</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Deret']) }}">
                            <span class="nav-main-link-name">Deret</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Hitung Cepat']) }}">
                            <span class="nav-main-link-name">Hitung Cepat</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Aritmatika Sosial']) }}">
                            <span class="nav-main-link-name">Aritmatika Sosial</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Perbandingan Cerita']) }}">
                            <span class="nav-main-link-name">Perbandingan Cerita</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Analitis']) }}">
                            <span class="nav-main-link-name">Analitis</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TIU', 'sub' => 'Figural']) }}">
                            <span class="nav-main-link-name">Figural</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                    aria-expanded="false" href="#">
                    <span class="nav-main-link-name">TKP</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link"
                            href="{{ route('admin.soal.cat', ['kategori' => 'TKP', 'sub' => 'Random']) }}">
                            <span class="nav-main-link-name">Random</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
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
        <a class="nav-main-link {{ activeMenu('laporan') }}" href="{{ route('admin.laporan') }}">
            <i class="nav-main-link-icon fa fa-print"></i>
            <span class="nav-main-link-name">Laporan</span>
        </a>
    </li>


</ul>
