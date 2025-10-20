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
    @if (Auth::user()->role === 'Super Admin')

        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                        <h3 class="content-header-title mb-0 d-inline-block">Laporan Hasil Audit</h3>
                        <div class="row breadcrumbs-top d-inline-block">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Laporan Hasil Audit
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
                                        <a href="{{ route('audit.create') }}" class="btn btn-primary mr-1">
                                            Tambah Laporan Audit</a>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            @if (Session::get('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (Session::get('error'))
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('danger') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="table-responsive">
                                                {{ $dataTable->table(['class' => 'table table-striped table-bordered dom-jQuery-events', 'id' => 'table-id']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- DOM - jQuery events table -->
                    {{-- Detail Data with Modal --}}
                    <div class="modal fade" id="detailLaporanHasilAudit" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><strong>Detail Laporan Hasil
                                            Audit</strong></h5>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btnDelete" onclick="handlerDelete()"><i
                                            class="fa fa-trash"></i> Hapus
                                        Data</button>
                                    <button type="button" class="btn btn-warning btnEdit" onclick="handlerEdit()"><i
                                            class="fa fa-edit"></i> Ubah
                                        Data</button>
                                    <button type="button" class="btn grey btn-outline-secondary"
                                        onclick="handlerCloseModal()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Detail Data with Modal --}}
                </div>
            </div>
        </div>

    @endif
    @if (Auth::user()->role === 'Admin')

        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                        <h3 class="content-header-title mb-0 d-inline-block">Laporan Hasil Audit</h3>
                        <div class="row breadcrumbs-top d-inline-block">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Laporan Hasil Audit
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
                                        <a href="{{ route('audit.create') }}" class="btn btn-primary mr-1">
                                            Tambah Laporan Audit</a>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            @if (Session::get('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (Session::get('error'))
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('danger') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="table-responsive">
                                                {{ $dataTable->table(['class' => 'table table-striped table-bordered dom-jQuery-events', 'id' => 'table-id']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- DOM - jQuery events table -->
                    {{-- Detail Data with Modal --}}
                    <div class="modal fade" id="detailLaporanHasilAudit" data-backdrop="static"
                        data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><strong>Detail Laporan Hasil
                                            Audit</strong></h5>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btnDelete"
                                        onclick="handlerDelete()"><i class="fa fa-trash"></i> Hapus
                                        Data</button>
                                    <button type="button" class="btn btn-warning btnEdit" onclick="handlerEdit()"><i
                                            class="fa fa-edit"></i> Ubah
                                        Data</button>
                                    <button type="button" class="btn grey btn-outline-secondary"
                                        onclick="handlerCloseModal()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Detail Data with Modal --}}
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role === 'User')

        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                        <h3 class="content-header-title mb-0 d-inline-block">Laporan Hasil Audit</h3>
                        <div class="row breadcrumbs-top d-inline-block">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Laporan Hasil Audit
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
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            @if (Session::get('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (Session::get('error'))
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                    role="alert">
                                                    {{ Session::get('danger') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="table-responsive">
                                                {{ $dataTable->table(['class' => 'table table-striped table-bordered dom-jQuery-events', 'id' => 'table-id']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- DOM - jQuery events table -->
                    {{-- Detail Data with Modal --}}
                    <div class="modal fade" id="detailLaporanHasilAudit" data-backdrop="static"
                        data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><strong>Detail Laporan Hasil
                                            Audit</strong></h5>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btnDelete"
                                        onclick="handlerDelete()"><i class="fa fa-trash"></i> Hapus
                                        Data</button>
                                    <button type="button" class="btn btn-warning btnEdit" onclick="handlerEdit()"><i
                                            class="fa fa-edit"></i> Ubah
                                        Data</button>
                                    <button type="button" class="btn grey btn-outline-secondary"
                                        onclick="handlerCloseModal()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Detail Data with Modal --}}
                </div>
            </div>
        </div>
    @endif


    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
    {{-- JS --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const detailData = (id) => {
            $("#detailLaporanHasilAudit .modal-body").html();
            $.ajax({
                url: "{{ url('audit/laporan-hasil-audit') }}" + `/${id}/show`,
                type: 'GET',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.data) {
                        let members = '';

                        if (response.data.member) {
                            response.data.member.map((value, index) => {
                                members += `<span>${index + 1}. ${value}</span><br>`
                            })
                        }
                        $("#detailLaporanHasilAudit").modal('show');
                        $("#detailLaporanHasilAudit .modal-body").html(`
                            <input type="hidden" class="form-control" name="dataId" id="dataId" value="${response.data.id}"/>
                            <table class="table w-100">
                                <tr>
                                    <th width="25%">Nomor LHA</th>
                                    <th width="2%" class="text-center">:</th>
                                    <td width="71%">${response.data.code}</td>
                                </tr>
                                <tr>
                                    <th>Judul Audit</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.judul_audit}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal LHA</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.date}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.divisi}</td>
                                </tr>


                                <tr>
                                    <th>Surat Tugas</th>
                                    <th class="text-center">:</th>
                                    <td><a href="${response.data.file_surat_tugas}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>
                                </tr>
                                <tr>
                                    <th>Berita Acara Exit Meeting</th>
                                    <th class="text-center">:</th>
                                    <td><a href="/storage/${response.data.berita_acara_exit_meeting}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>

                                </tr>

                                <tr>
                                    <th>PKA</th>
                                    <th class="text-center">:</th>
                                    <td><a href="/storage/${response.data.pka}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>
                                </tr>

                                <tr>
                                    <th>File Nota Dinas</th>
                                    <th class="text-center">:</th>
                                    <td><a href="${response.data.file_nota_dinas}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>
                                </tr>

                                <tr>
                                    <th>laporan_dan_lampiran</th>
                                    <th class="text-center">:</th>
                                    <td><a href="/storage/${response.data.laporan_dan_lampiran}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>
                                </tr>
                            </table>
                        `);
                    }
                },
                error: function(xhr, error, status) {
                    alert(error)
                },
            });
        }

        const handlerEdit = () => {
            const dataId = $("#dataId").val();
            location.href = "{{ url('audit/laporan-hasil-audit') }}" + `/${dataId}/edit`;
        }

        const handlerCloseModal = () => {
            $("#detailLaporanHasilAudit").modal('hide');
            $("#detailLaporanHasilAudit .modal-body").html('')
        }

        const handlerDelete = () => {
            const dataId = $("#dataId").val();
            let confirmation = confirm("Yakin ingin menghapus data?");
            if (confirmation) {
                $.ajax({
                    url: "{{ url('audit/laporan-hasil-audit/destroy') }}",
                    type: 'POST',
                    data: {
                        dataId,
                        '_method': 'delete'
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message)
                        if (response.status) {
                            setTimeout(() => location.reload(), 1000);
                        }

                    },
                    error: function(xhr, error, status) {
                        alert(error)
                    },
                });
            }

        }
    </script>

</body>

</html>
