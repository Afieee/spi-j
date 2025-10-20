<!DOCTYPE html>
<html lang="en">

<head>
    @include('Template.head')
    <title>Tambah Tindak Lanjut</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Tambah Tindak Lanjut</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('rekomendasi.index') }}">Rekomendasi</a>
                                </li>
                                <li class="breadcrumb-item active">Tambah Tindak Lanjut</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="form-action-layouts">
                    <div class="row">
                        <!-- Tabel di kiri -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">Daftar Tindak Lanjut - {{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered text-center">
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
                                                @foreach ($tindakLanjuts as $index => $tl)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $tl->id_recomendeds }}</td>
                                                        <td>{{ $tl->catatan_tl }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $tl->status_tl == 'Belum Tindak Lanjut' ? 'badge-danger' : ($tl->status_tl == 'Sudah Tindak Lanjut' ? 'badge-success' : 'badge-warning') }}">
                                                                {{ $tl->status_tl }}
                                                            </span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($tl->batas_waktu)->format('d-m-Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- Pagination links --}}
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Menampilkan {{ $tindakLanjuts->firstItem() }}–{{ $tindakLanjuts->lastItem() }} dari {{ $tindakLanjuts->total() }} data
                                            </div>
                                            <div>
                                                {{ $tindakLanjuts->links() }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{-- {{ $tindakLanjuts->links() }} --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form di kanan -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">Form Tambah Tindak Lanjut</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('tl.store') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="id_recomendeds" value="{{ $id_recomendeds }}">

                                        <div class="form-group">
                                            <label for="judul_rekomendasi">Judul Tindak Lanjut:</label>
                                            <input type="text" class="form-control" id="judul_rekomendasi">
                                        </div>

                                        <div class="form-group">
                                            <label for="catatan_tl">Catatan Tindak Lanjut:</label>
                                            <textarea name="catatan_tl" id="catatan_tl" class="form-control" rows="3" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="status_tl">Status:</label>
                                            <select name="status_tl" id="status_tl" class="form-control" required>
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="Sudah Tindak Lanjut">Sudah Tindak Lanjut</option>
                                                <option value="Belum Tindak Lanjut">Belum Tindak Lanjut</option>
                                                <option value="Tindak Lanjut Tidak Sesuai">Tindak Lanjut Tidak Sesuai
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="batas_waktu">Batas Waktu:</label>
                                            <input type="date" name="batas_waktu" id="batas_waktu"
                                                class="form-control" required>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <a href="{{ route('rekomendasi.index') }}"
                                                class="btn btn-secondary">Batal</a>
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

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
</body>

</html>
