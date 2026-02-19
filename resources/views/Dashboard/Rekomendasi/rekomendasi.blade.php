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

                        <!-- ======================= -->
                        <!-- KOLOM TABEL -->
                        <!-- ======================= -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        List Rekomendasi - {{ $isi_temuan }}
                                    </h4>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Rekomendasi</th>
                                                        <th>File Closing</th>
                                                        <th>Batas Waktu</th>
                                                        <th>PIC</th>
                                                        <th>Status</th>
                                                        <th>Tindak Lanjut</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($rekomendasi as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->title }}</td>

                                                            <td>
                                                                @if ($item->closed_file_surat)
                                                                    <a href="{{ asset('storage/audit/uploads/' . $item->closed_file_surat) }}"
                                                                        target="_blank" class="btn btn-sm btn-info">
                                                                        Lihat File
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">
                                                                        Tidak ada file
                                                                    </span>
                                                                @endif
                                                            </td>

                                                            <td>{{ $item->batas_waktu }}</td>
                                                            <td>{{ $item->pic }}</td>

                                                            <!-- STATUS BERDASARKAN TL -->
                                                            <td>
                                                                @php
                                                                    $adaClosed =
                                                                        $item->tindakLanjut
                                                                            ->where('status_tl', 'Sudah Tindak Lanjut')
                                                                            ->count() > 0;
                                                                @endphp

                                                                @if ($adaClosed)
                                                                    <span class="badge badge-success">
                                                                        Closed
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-warning">
                                                                        Progress
                                                                    </span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('audit.tindak-lanjut.index', $item->id) }}"
                                                                    class="btn btn-primary">
                                                                    Tindak Lanjut
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <!-- PAGINATION -->
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="text-muted">
                                                    Menampilkan
                                                    {{ $rekomendasi->firstItem() }}
                                                    –
                                                    {{ $rekomendasi->lastItem() }}
                                                    dari
                                                    {{ $rekomendasi->total() }}
                                                    data
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

                        <!-- ======================= -->
                        <!-- KOLOM FORM (TIDAK DIUBAH) -->
                        <!-- ======================= -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Tambah Temuan</h4>
                                </div>

                                <div class="card-body">
                                    <form action="{{ route('audit.rekomendasi.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">
                                                Judul Rekomendasi
                                            </label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Masukkan judul rekomendasi" required>
                                        </div>

                                        <input type="hidden" name="status" value="1">

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">
                                                Upload File Pendukung
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="closed_file_surat"
                                                    required>
                                                <label class="custom-file-label">
                                                    Pilih file...
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">
                                                Batas Temuan
                                            </label>
                                            <input type="date" class="form-control" name="batas_waktu" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">
                                                PIC
                                            </label>
                                            <input type="text" class="form-control" name="pic"
                                                placeholder="Masukkan nama PIC" required>
                                        </div>

                                        <input type="hidden" name="id_temuan" value="{{ $id_temuan }}">

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus"></i>
                                                Tambah
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

    @include('Template.footer')
    @include('Template.js')

</body>

</html>
