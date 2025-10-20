<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Laporan Kegiatan SPI</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Laporan Kegiatan SPI</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Kegiatan SPI
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
                                    <a href="{{ route('laporan.create') }}" class="btn btn-primary mr-1">
                                        Tambah Laporan</a>
                                </div>
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
                <div class="modal fade" id="detailLaporan" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
    {{-- JS --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const detailData = (id) => {
            $("#detailLaporan .modal-body").html();
            $.ajax({
                url: "{{ url('laporan') }}" + `/${id}/show`,
                type: 'GET',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.data) {
                        $("#detailLaporan").modal('show');
                        $("#detailLaporan .modal-body").html(`
                            <input type="hidden" class="form-control" name="dataId" id="dataId" value="${response.data.id}"/>
                            <table class="table w-100">
                                <tr>
                                    <th width="25%">Nomor LHA</th>
                                    <th width="2%" class="text-center">:</th>
                                    <td width="71%">${response.data.code}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal LHA</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.date}</td>
                                </tr>
                                <tr>
                                    <th>Judul LHA</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.title}</td>
                                </tr>
                                <tr>
                                    <th>Divisi / Unit</th>
                                    <th class="text-center">:</th>
                                    <td >${response.data.divisi}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <th class="text-center">:</th>
                                    <td>${response.data.description}</td>
                                </tr>
                                <tr>
                                    <th>Attachment</th>
                                    <th class="text-center">:</th>
                                    <td><a href="${response.data.attachment}" class="btn btn-primary" target="_BLANK">Lihat File</a></td>
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
            location.href = "{{ url('laporan') }}" + `/${dataId}/edit`;
        }

        const handlerCloseModal = () => {
            $("#detailLaporan").modal('hide');
            $("#detailLaporan .modal-body").html('')
        }

        const handlerDelete = () => {
            const dataId = $("#dataId").val();
            let confirmation = confirm("Yakin ingin menghapus data?");
            if (confirmation) {
                $.ajax({
                    url: "{{ url('laporan/destroy') }}",
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
