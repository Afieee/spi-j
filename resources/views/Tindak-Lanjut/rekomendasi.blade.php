<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Tindak Lanjut Hasil Audit</title>
    <style>
        .form-container {
            display: none;
            margin-top: 20px;
        }

        .table td,
        .table th {
            word-wrap: break-word;
            white-space: normal;
            max-width: 200px;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }

        .pagination {
            margin: 0;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-link {
            color: #007bff;
        }

        .page-link:hover {
            color: #0056b3;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">

    {{-- Navbar --}}
    @include('Template.nav')
    {{-- Navbar --}}

    {{-- Side Menu --}}
    @include('Template.side-menu')
    {{-- Side Menu --}}

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Rekomendasi</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Rekomendasi
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">


                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @if (Session::get('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        @if (Session::get('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ Session::get('danger') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <!-- Filter Divisi -->
                                        <form action="{{ route('rekomendasi.index') }}" method="GET">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="filterDivisi">Filter Unit:</label>
                                                    <select name="divisi" class="form-control input-lg pl-4" required>
                                                        <option value="" disabled selected>Pilih Unit
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

                                                </div>
                                                <div class="col-md-3 align-self-end">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Judul Rekomendasi</th>
                                                        <th>Status</th>
                                                        <th>Tanggal Audit</th>
                                                        <th>Ubah Status</th>
                                                        <th>Tindak-Lanjut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recomendeds as $recomended)
                                                        <tr>
                                                            <td>{{ $recomended->id }}</td>
                                                            <td>{{ $recomended->title }}</td>
                                                            <td>
                                                                @if ($recomended->status == 1)
                                                                    <span class="badge badge-success">Terbuka</span>
                                                                @elseif ($recomended->status == 2)
                                                                    <span class="badge badge-warning">On Progress</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Unknown</span>
                                                                @endif
                                                            </td>
                                                            </td>
                                                            <td>{{ $recomended->temuan->audit->date ?? '-' }}</td>
                                                            <td>
                                                                <a href="{{ route('halamanUpdateRecomendeds', $recomended->id) }}"
                                                                    class="btn btn-sm btn-primary">
                                                                    Ubah Status
                                                                </a>
                                                            </td>
                                                            <td><a href="{{ route('audit.tindak-lanjut.index', $recomended->id) }}">Buat
                                                                    Tindak-Lanjut</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pagination-container">
                                            {{ $recomendeds->links('pagination::bootstrap-5') }}
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

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
</body>

</html>
