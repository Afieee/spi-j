<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Temuan</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Temuan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Temuan</li>
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
                                    <h4 class="card-title">List Temuan - {{ $judul_audit }} </h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered align-middle">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="width: 5%;">No</th>
                                                        <th style="width: 35%;">Isi Temuan</th>
                                                        <th style="width: 20%;">Jenis Temuan</th>
                                                        <th style="width: 20%;">Akibat</th>
                                                        <th style="width: 20%;">Rekomendasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($temuan as $index => $item)
                                                        <tr>
                                                            {{-- Nomor urut yang tetap berlanjut di tiap halaman --}}
                                                            <td>{{ $loop->iteration + ($temuan->currentPage() - 1) * $temuan->perPage() }}</td>
                                                            <td>{{ $item->isi_temuan }}</td>
                                                            <td>{{ $item->jenis_temuan }}</td>
                                                            <td>{{ $item->akibat }}</td>
                                                            <td>
                                                                <a href="{{ route('audit.rekomendasi.index-user', $item->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="bi bi-lightbulb"></i> Rekomendasi
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Tidak ada data temuan</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Pagination links --}}
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Menampilkan {{ $temuan->firstItem() }}–{{ $temuan->lastItem() }} dari {{ $temuan->total() }} data
                                            </div>
                                            <div>
                                                {{ $temuan->links() }}
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
                                    <h4 class="card-title">Tambah Temuan</h4>
                                </div>
                                <div class="card-body">
                                     <form action="{{ route('audit.temuan.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="isi_temuan">Isi Temuan</label>
                                            <input type="text" class="form-control" name="isi_temuan" placeholder="Isi Temuan" required>

                                            <label for="jenis_temuan">Jenis Temuan</label>
                                            <input type="text" class="form-control" name="jenis_temuan" placeholder="Jenis Temuan" required>

                                            <label for="akibat">Akibat</label>
                                            <input type="text" class="form-control" name="akibat" placeholder="Akibat" required>

                                            <input type="text" class="form-control" name="id_audit" value={{ $id_audit }} placeholder="Id Audit" required hidden>
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
</body>

</html>
