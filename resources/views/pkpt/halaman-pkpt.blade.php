<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Laporan Hasil Audit</title>
    <style>
        .custom-file-label::after {
            content: "Pilih File";
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">

    @include('Template.nav')
    @include('Template.side-menu')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">PKPT</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">PKPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="dom">
                    <div class="row">
                        <!-- Kolom untuk tabel -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between mb-3">
                                        <form method="GET" action="{{ route('halaman-tampil-pkpt') }}">
                                            <label for="tahun">Filter Tahun:</label>
                                            <select name="tahun" id="tahun"
                                                class="form-control d-inline-block w-auto"
                                                onchange="this.form.submit()">
                                                @for ($i = 2023; $i <= 2028; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </form>
                                    </div>
                                    <h4 class="card-title">List File PKPT</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>ID PKPT</th>
                                                        <th>Nama Penugasan</th>
                                                        <th>File</th>
                                                        <th>Bulan Penugasan</th>
                                                        <th>Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pkpt as $data)
                                                        <tr>
                                                            <td>{{ $data->id_pkpt }}</td>
                                                            <td>{{ $data->nama_penugasan_pkpt }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $data->file_pkpt) }}"
                                                                    target="_blank">
                                                                    Lihat File
                                                                </a>
                                                            </td>
                                                            <td>{{ $data->created_at->format('F Y') }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    data-toggle="modal" data-target="#detailModal"
                                                                    data-id="{{ $data->id_pkpt }}"
                                                                    data-nama="{{ $data->nama_penugasan_pkpt }}"
                                                                    data-file="{{ $data->file_pkpt }}"
                                                                    data-bulan="{{ $data->created_at->format('F Y') }}">
                                                                    Detail
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-center mt-3">
                                                {{ $pkpt->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom untuk form -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Tambah Laporan PKPT</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('isi-pka') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama_penugasan">Nama Penugasan</label>
                                            <input type="text" class="form-control" name="nama_penugasan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">File PKPT</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file"
                                                    id="fileInput" onchange="updateFileName(this)" required>
                                                <label class="custom-file-label" for="fileInput">Pilih File</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Audit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID PKPT:</strong> <span id="modalId"></span></p>
                    <p><strong>Nama Penugasan:</strong> <span id="modalNama"></span></p>
                    <p><strong>File:</strong> <a id="modalFile" href="" target="_blank">Lihat File</a></p>
                    <p><strong>Bulan Penugasan:</strong> <span id="modalBulan"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @include('Template.footer')
    @include('Template.js')

    <script>
        function updateFileName(input) {
            if (input.files.length > 0) {
                let fileName = input.files[0].name;
                let label = input.nextElementSibling;
                label.innerText = fileName;
            }
        }

        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var nama = button.data('nama');
            var file = button.data('file');
            var bulan = button.data('bulan');

            var modal = $(this);
            modal.find('#modalId').text(id);
            modal.find('#modalNama').text(nama);
            modal.find('#modalFile').attr('href', '{{ asset('storage') }}/' + file);
            modal.find('#modalBulan').text(bulan);
        });
    </script>

</body>

</html>
