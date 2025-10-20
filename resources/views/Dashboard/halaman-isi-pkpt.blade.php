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
                    <h3 class="content-header-title mb-0 d-inline-block">Laporan Hasil Audit</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Detail PKPT</li>
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
                                <div class="card-header">
                                    <h4 class="card-title">List File PKPT</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Kode Audit</th>
                                                    <th>PKPT</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $audit)
                                                    <tr>
                                                        <td>{{ $audit->code }}</td>
                                                        <td>
                                                            @if ($audit->pka)
                                                                <span class="badge badge-success">PKPT Ada</span>
                                                            @else
                                                                <span class="badge badge-danger">Belum Ada</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!$audit->pka)
                                                                <form action="{{ route('upload.pka', $audit->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="custom-file">
                                                                        <input type="file" name="pka"
                                                                            class="custom-file-input"
                                                                            id="fileInput{{ $audit->id }}" required
                                                                            onchange="updateFileName(this)">
                                                                        <label class="custom-file-label"
                                                                            for="fileInput{{ $audit->id }}">Pilih
                                                                            File...</label>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mt-2">Upload</button>
                                                                </form>
                                                            @else
                                                                <a href="{{ asset('storage/' . $audit->pka) }}"
                                                                    class="btn btn-success btn-sm" target="_blank">Lihat
                                                                    PKPT</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- Paginasi --}}
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $data->links('pagination::bootstrap-4') }}
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

    <script>
        function updateFileName(input) {
            if (input.files.length > 0) {
                let fileName = input.files[0].name;
                let label = input.nextElementSibling;
                label.innerText = fileName;
            }
        }
    </script>

</body>

</html>
