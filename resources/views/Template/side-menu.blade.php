@if (Auth::user()->role === 'Super Admin')
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li><a class="menu-item" href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>

                <li class="nav-item has-sub">
                    <a href="#"><i class="fa fa-users"></i> Pengguna </a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="/manage-pengguna"><i class="fa fa-users"></i> Manage Pengguna</a>
                        </li>
                        <li><a class="menu-item" href="/tambah-pengguna"><i class="fa fa-user-plus"></i> Tambah
                                Pengguna</a></li>
                    </ul>
                </li>

                <li class="nav-item has-sub">
                    <a href="#"><i class="fa fa-eye"></i> Hasil Pengawasan</a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('audit.index') }}"><i class="fa fa-file-text"></i>
                                Laporan Hasil Audit</a></li>
                        <li><a class="menu-item" href="{{ route('rekomendasi.index') }}"><i
                                    class="fa fa-check-circle"></i> Monitoring TL</a></li>
                        {{-- <li><a class="menu-item" href="{{ route('tindakLanjut.index') }}"><i class="fa fa-tasks"></i>
                                Monitoring TL</a></li> --}}
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endif

@if (Auth::user()->role === 'Admin')
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li><a class="menu-item" href="{{ route('dashboard') }}"><i class="fa fa-house"></i> Dashboard</a></li>
                <li><a class="menu-item" href="{{ route('audit.index') }}"><i class="fa fa-file-text"></i> Laporan Hasil
                        Audit</a></li>
                {{-- <li><a class="menu-item" href="{{ route('rekomendasi.index') }}"><i class="fa fa-tasks"></i> Rekomendasi</a></li> --}}
                {{-- <li><a class="menu-item" href="{{ route('tindakLanjut.index') }}"><i class="fa fa-tasks"></i>
                        Monitoring TL</a></li> --}}
                <li><a class="menu-item" href="{{ route('rekomendasi.index') }}"><i class="fa fa-tasks"></i> Monitoring
                        TL</a></li>
            </ul>
        </div>
    </div>
@endif

@if (Auth::user()->role === 'User')
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li><a class="menu-item" href="{{ route('audit.index') }}"><i class="fa fa-file-text"></i> Laporan Hasil
                        Audit</a></li>
                <li><a class="menu-item" href="{{ route('rekomendasi.index') }}"><i class="fa fa-tasks"></i> Monitoring
                        TL</a></li>
            </ul>
        </div>
    </div>
@endif
