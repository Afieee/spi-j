<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Laporan Hasil Audit</title>
</head>
<style>
    .table td,
    .table th {
        word-wrap: break-word;
        white-space: normal;
        max-width: 200px;
    }
</style>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">

    {{-- Navbar --}}
    <!-- fixed-top-->
    @include('Template.nav')
    {{-- Navbar --}}

    {{-- Side Menu --}}
    @include('Template.side-menu')
    {{-- Side Menu --}}

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Update Pengguna</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="/manage-pengguna">Manage Pengguna</a>
                                </li>
                                <li class="breadcrumb-item active">Update Pengguna
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Form Laporan Hasil Audit -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-content">
                                        <div class="card-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                            <form class="form-horizontal"
                                                action="{{ route('updatePengguna', $pengguna->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control input-lg" name="name"
                                                        tabindex="1" value="{{ old('name', $pengguna->name) }}">
                                                    <div class="form-control-position">
                                                        <i class="ft-user"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>

                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="email" class="form-control input-lg" name="email"
                                                        tabindex="1" value="{{ old('email', $pengguna->email) }}">
                                                    <div class="form-control-position">
                                                        <i class="ft-mail"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <select name="role" class="form-control input-lg pl-4" required>
                                                        <option value="{{ old('email', $pengguna->role) }}">
                                                            {{ old('email', $pengguna->role) }} (Role Anda Sekarang)
                                                        </option>
                                                        <option value="Super Admin">Super Admin</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="User">User</option>
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <div class="form-control-position">
                                                        <i class="fa fa fa-users"></i>
                                                    </div>
                                                    <select name="divisi" class="form-control input-lg pl-4" required>
                                                        <option value="{{ old('email', $pengguna->divisi) }}">
                                                            {{ old('email', $pengguna->divisi) }} (Divisi Anda Sekarang)
                                                        </option>
                                                        <option value="Sekretariat">Sekretariat</option>
                                                        <option value="Manager Management Proyek TPK">Manager Management
                                                            Proyek TPK</option>
                                                        <option value="GM Terminal Peti Kemas">GM Terminal Peti Kemas
                                                        </option>
                                                        <option value="GM Operasi & Pemasaran">GM Operasi & Pemasaran
                                                        </option>
                                                        <option value="GM Keuangan & Risk Management">GM Keuangan & Risk
                                                            Management</option>
                                                        <option value="GM SDM & Umum">GM SDM & Umum</option>
                                                        <option value="Kepala Satuan Pengawas Internal">Kepala Satuan
                                                            Pengawas Internal</option>
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control input-lg" name="password"
                                                        tabindex="1"
                                                        placeholder="Masukkan Password Baru / Lama Untuk konfirmasi">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>

                                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                                    Update</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')

</body>

</html>
