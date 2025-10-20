<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - {{ isset($data) ? 'Edit' : 'Tambah' }} Rekomendasi</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Rekomendasi</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Laporan Hasil Audit</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('audit.rekomendasi.index', $auditId) }}">Rekomendasi</a>
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
                                        @if (Route::is('audit.rekomendasi.create'))
                                            <form action="{{ route('audit.rekomendasi.store', $auditId) }}"
                                                method="POST">
                                            @else
                                                <form
                                                    action="{{ route('audit.rekomendasi.update', ['audit' => $auditId, 'id' => $data->id]) }}"
                                                    method="POST">
                                                    @method('PUT')
                                        @endif

                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="nomorLHA">Nomor LHA</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="nomorLHA" class="form-control"
                                                            placeholder="nomor LHA" name="title" disabled
                                                            value="{{ $audit->code }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-briefcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="title">Rekomendasi</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="title"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            placeholder="Rekomendasi" name="title"
                                                            value="{{ old('title', $data->title ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-suitcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="pic">PIC</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="pic"
                                                            class="form-control @error('pic') is-invalid @enderror"
                                                            placeholder="Rekomendasi" name="pic"
                                                            value="{{ old('pic', $data->pic ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-suitcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="batas_waktu">Batas Waktu</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="date" id="batas_waktu" name="batas_waktu"
                                                            class="form-control @error('batas_waktu') is-invalid @enderror">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        @error('batas_waktu')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="status">Status</label>
                                                    <div class="position-relative has-icon-left">
                                                        <select id="status" name="status"
                                                            class="form-control @error('status') is-invalid @enderror">
                                                            <option value="">-- Pilih Status --</option>
                                                            @foreach ($statuses as $value)
                                                                <option value="{{ $value['value'] }}"
                                                                    {{ old('status', $data->status ?? '') == $value['value'] ? 'selected' : '' }}>
                                                                    {{ $value['value'] }} - {{ $value['label'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-position">
                                                            <i class="fa fa-exclamation-circle"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12">
                                                <a href="{{ route('audit.rekomendasi.index', $auditId) }}"
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
