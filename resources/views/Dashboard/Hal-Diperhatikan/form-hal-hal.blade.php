<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - {{ isset($data) ? 'Edit' : 'Tambah' }} Hal Yang Diperhatikan</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Hal Hal yang perlu diperhatikan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Laporan Hasil Audit</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('audit.notice.index', $auditId) }}">Hal-hal Yang Perlu
                                        Diperhatikan</a>
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
                                        @if (Route::is('audit.notice.create'))
                                            <form action="{{ route('audit.notice.store', $auditId) }}" method="POST">
                                            @else
                                                <form
                                                    action="{{ route('audit.notice.update', ['audit' => $auditId, 'id' => $data->id]) }}"
                                                    method="POST">
                                                    @method('PUT')
                                        @endif

                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="title">Hal Yang Perlu Diperhatikan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="title"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            placeholder="Hal Yang Perlu Diperhatikan" name="title"
                                                            value="{{ old('title', $data->title ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-suitcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="consequence">Akibat</label>
                                                    <div class="position-relative has-icon-left">
                                                        <select id="consequence" name="consequence"
                                                            class="form-control @error('consequence') is-invalid @enderror">
                                                            <option value="">-- Pilih Akibat --</option>
                                                            @foreach ($akibat as $value)
                                                                <option value="{{ $value['value'] }}"
                                                                    {{ old('consequence', $data->consequence ?? '') == $value['value'] ? 'selected' : '' }}>
                                                                    {{ $value['value'] }} - {{ $value['label'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-position">
                                                            <i class="fa fa-briefcase"></i>
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
                                                <a href="{{ route('audit.notice.index', $auditId) }}"
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
