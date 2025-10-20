<!DOCTYPE html>
<html lang="id">

<head>
    @include('Template.head')
    <title>Daftar Tindak Lanjut</title>
    <style>
        .table td,
        .table th {
            word-wrap: break-word;
            white-space: normal;
            max-width: 200px;
            text-align: center;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .alert {
            text-align: center;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar">
    @include('Template.nav')
    @include('Template.side-menu')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <h3 class="content-header-title">Daftar Tindak Lanjut</h3>
                </div>
            </div>
            <div class="content-body">
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> Tindak Lanjut</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @if (Session::get('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            </div>
                                        @endif

                                        @if (Session::get('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ Session::get('error') }}
                                                <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            </div>
                                        @endif

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>ID Rekomendasi</th>
                                                        <th>Catatan TL</th>
                                                        <th>Status TL</th>
                                                        <th>Batas Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tindakLanjuts as $tl)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $tl->id_recomendeds }}</td>
                                                            <td>{{ $tl->catatan_tl }}</td>
                                                            <td>
                                                                @if ($tl->status_tl == 'Belum Tindak Lanjut')
                                                                    <span class="badge badge-secondary">Belum Tindak
                                                                        Lanjut</span>
                                                                @elseif ($tl->status_tl == 'Sudah Tindak Lanjut')
                                                                    <span class="badge badge-success">Sudah Tindak
                                                                        Lanjut</span>
                                                                @elseif ($tl->status_tl == 'Tindak Lanjut Tidak Sesuai')
                                                                    <span class="badge badge-danger">Tindak Lanjut Tidak
                                                                        Sesuai</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d M Y', strtotime($tl->batas_waktu)) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="pagination-container">
                                            {{ $tindakLanjuts->links('pagination::bootstrap-5') }}
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

    @include('Template.footer')
    @include('Template.js')
</body>

</html>
