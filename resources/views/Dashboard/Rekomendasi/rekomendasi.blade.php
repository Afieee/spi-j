<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Rekomendasi</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Rekomendasi</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Rekomendasi</li>
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
                                    <h4 class="card-title">List Rekomendasi - {{ $isi_temuan }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Rekomendasi</th>
                                                        <th>Status</th>
                                                        <th>File Closing</th>
                                                        <th>Batas Waktu</th>
                                                        <th>PIC</th>
                                                        <th>Tindak Lanjut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($rekomendasi as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>
                                                            @if ($item->status == 1)
                                                                <span class="badge bg-warning text-dark">Terbuka</span>
                                                            @elseif ($item->status == 2)
                                                                <span class="badge bg-success">Progress</span>
                                                            @else
                                                                <span class="badge bg-secondary">Closed</span>
                                                            @endif
                                                        </td>
                                                        <td>  
                                                            @if ($item->closed_file_surat)
                                                                <a href="{{ asset('storage/audit/uploads/' . $item->closed_file_surat) }}" 
                                                                target="_blank" 
                                                                class="btn btn-sm btn-info">
                                                                Lihat File
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Tidak ada file</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->batas_waktu }}</td>
                                                        <td>{{ $item->pic }}</td>

                                                        <td><a href="{{ route('audit.tindak-lanjut.index', $item->id)  }}" class="btn btn-primary">Tindak Lanjut</a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{-- Pagination links --}}
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="text-muted">
                                                    Menampilkan {{ $rekomendasi->firstItem() }}–{{ $rekomendasi->lastItem() }} dari {{ $rekomendasi->total() }} data
                                                </div>
                                                <div>
                                                    {{ $rekomendasi->links() }}
                                                </div>
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
                                    <form action="{{ route('audit.rekomendasi.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="form-group mb-3">
                                            <label for="title" class="font-weight-bold">Judul Rekomendasi</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul rekomendasi" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="status" class="font-weight-bold">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="" disabled selected>Pilih status</option>
                                                <option value="1">Terbuka</option>
                                                <option value="2">Progress</option>
                                                <option value="3">Closed</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="file_temuan" class="font-weight-bold">Upload File Pendukung</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_temuan" name="closed_file_surat" required>
                                                <label class="custom-file-label" for="file_temuan">Pilih file...</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="batas_waktu" class="font-weight-bold">Batas Temuan</label>
                                            <input type="date" class="form-control" id="batas_waktu" name="batas_waktu" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pic" class="font-weight-bold">PIC</label>
                                            <input type="text" class="form-control" id="pic" name="pic" placeholder="Masukkan nama PIC" required>
                                        </div>

                                        <input type="hidden" name="id_temuan" value="{{ $id_temuan }}">

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>
                                        </div>
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
