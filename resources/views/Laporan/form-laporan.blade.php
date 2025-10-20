<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - {{ isset($data) ? 'Edit' : 'Tambah' }} Laporan Kegiatan SPI</title>
</head>

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
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan
                                        Kegiatan SPI</a>
                                </li>
                                <li class="breadcrumb-item active">{{ isset($data) ? 'Edit' : 'Tambah' }}</li>
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
                                        @if ($errors->any())
                                            <div class="alert alert-danger my-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if (Session::get('success'))
                                            <div class="alert alert-success alert-dismissible fade show mb-3"
                                                role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if (Session::get('error'))
                                            <div class="alert alert-danger alert-dismissible fade show mb-3"
                                                role="alert">
                                                {{ Session::get('danger') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if (Route::is('laporan.create'))
                                            <form action="{{ route('laporan.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                            @else
                                                <form action="{{ route('laporan.update', $data->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                        @endif

                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="nomorLaporan">Nomor Laporan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="nomorLaporan"
                                                            class="form-control @error('nomorLaporan') is-invalid @enderror"
                                                            placeholder="Nomor Laporan" name="nomorLaporan"
                                                            value="{{ old('nomorLaporan', $data->code ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-briefcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="tanggal">Tanggal Laporan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="date" id="tanggal"
                                                            class="form-control @error('tanggal') is-invalid @enderror"
                                                            name="tanggal"
                                                            value="{{ old('tanggal', $data->date ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="judul">Judul Laporan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="judul"
                                                            class="form-control @error('judul') is-invalid @enderror"
                                                            placeholder="Judul Laporan" name="judul"
                                                            value="{{ old('judul', $data->title ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-envelope"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="divisi">Divisi/Unit</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="divisi"
                                                            class="form-control @error('divisi') is-invalid @enderror"
                                                            placeholder="Divisi/Unit" name="divisi"
                                                            value="{{ old('divisi', $data->divisi ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-users"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="attachment">Attachment @if (isset($data))
                                                            <em class="text-muted">*kosongi jika tidak diubah</em>
                                                        @endif
                                                    </label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="file" name="attachment" id="attachment"
                                                            class="form-control @error('attachment') is-invalid @enderror">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="description">Keterangan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <textarea id="keterangan" rows="5" class="form-control @error('description') is-invalid @enderror"
                                                            name="description" placeholder="Keterangan">{{ old('description', $data->description ?? '') }}</textarea>
                                                        <div class="form-control-position">
                                                            <i class="fa fa-info"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12">
                                                <a href="{{ route('laporan.index') }}"
                                                    class="btn btn-outline-danger mr-1">
                                                    <i class="ft-x"></i> Back
                                                </a>
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fa fa-check-square-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
    {{-- JS --}}

</body>

</html>
