<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - {{ isset($data) ? 'Edit' : 'Tambah' }} Laporan Hasil Audit</title>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Temuan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Laporan Hasil Audit</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('audit.temuan.index', $auditId) }}">Temuan</a>
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
                                        @if (Route::is('audit.temuan.create'))
                                            <form action="{{ route('audit.temuan.store', $auditId) }}" method="POST">
                                            @else
                                                <form
                                                    action="{{ route('audit.temuan.update', ['audit' => $auditId, 'id' => $data->id]) }}"
                                                    method="POST">
                                                    @method('PUT')
                                        @endif

                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="temuan">Temuan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="temuan"
                                                            class="form-control @error('temuan') is-invalid @enderror"
                                                            placeholder="Temuan" name="temuan"
                                                            value="{{ old('temuan', $data->title ?? '') }}">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-suitcase"></i>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="type_finding">Jenis Temuan</label>
                                                    <div class="position-relative has-icon-left">
                                                        <select id="type_finding" name="type_finding"
                                                            class="form-control @error('type_finding') is-invalid @enderror"
                                                            onchange="showFormFinding(this.value)">
                                                            <option value="">-- Pilih Jenis Temuan --
                                                            </option>
                                                            @foreach ($jenisTemuan as $value)
                                                                <option value="{{ $value['value'] }}"
                                                                    {{ old('type_finding', $data->type_finding ?? '') == $value['value'] ? 'selected' : '' }}>
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
                                            <div class="col-md-3" id="field_mark_finding"
                                                style="display: {{ old('type_finding') || (isset($data) && $data->type_finding) == '1' ? 'block' : 'none' }}">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="mark_finding">Nilai Temuan</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" id="mark_finding"
                                                            class="form-control @error('mark_finding') is-invalid @enderror"
                                                            placeholder="Nilai Temuan (Dalam RUpiah)"
                                                            name="mark_finding"
                                                            value="{{ old('mark_finding', $data->mark_finding ?? '') }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">,00</span>
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
                                            <div class="col-md-6">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="reason">Penyebab</label>
                                                    <div class="position-relative has-icon-left repeater-default">
                                                        @if (isset($data))
                                                            <div data-repeater-list="reason">
                                                                @if ($data->reason)
                                                                    @foreach ($data->reason as $item)
                                                                        <div class="input-group mb-1"
                                                                            data-repeater-item>
                                                                            <input type="text"
                                                                                class="form-control reason-spi"
                                                                                placeholder="Penyebab" name="reason"
                                                                                value="{{ $item }}">
                                                                            <span class="input-group-append"
                                                                                id="button-addon2">
                                                                                <button class="btn btn-danger"
                                                                                    type="button"
                                                                                    data-repeater-delete><i
                                                                                        class="ft-x"></i></button>
                                                                            </span>
                                                                            <div class="form-control-position">
                                                                                <i class="fa fa-file-o"></i>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="input-group mb-1" data-repeater-item>
                                                                        <input type="text"
                                                                            class="form-control reason-spi"
                                                                            placeholder="Penyebab" name="reason">
                                                                        <span class="input-group-append"
                                                                            id="button-addon2">
                                                                            <button class="btn btn-danger"
                                                                                type="button" data-repeater-delete><i
                                                                                    class="ft-x"></i></button>
                                                                        </span>
                                                                        <div class="form-control-position">
                                                                            <i class="fa fa-file-o"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div data-repeater-list="reason">
                                                                <div class="input-group mb-1" data-repeater-item>
                                                                    <input type="text"
                                                                        class="form-control reason-spi"
                                                                        placeholder="Penyebab" name="reason">
                                                                    <span class="input-group-append"
                                                                        id="button-addon2">
                                                                        <button class="btn btn-danger" type="button"
                                                                            data-repeater-delete><i
                                                                                class="ft-x"></i></button>
                                                                    </span>
                                                                    <div class="form-control-position">
                                                                        <i class="fa fa-file-o"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <button type="button" data-repeater-create
                                                            class="btn btn-primary">
                                                            <i class="ft-plus"></i> Tambah Penyebab
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="criteria">Kriteria</label>
                                                    <div class="position-relative has-icon-left repeater-default">
                                                        @if (isset($data))
                                                            <div data-repeater-list="criteria">
                                                                @if ($data->criteria)
                                                                    @foreach ($data->criteria as $item)
                                                                        <div class="input-group mb-1"
                                                                            data-repeater-item>
                                                                            <input type="text"
                                                                                class="form-control criteria-spi"
                                                                                placeholder="Penyebab" name="criteria"
                                                                                value="{{ $item }}">
                                                                            <span class="input-group-append"
                                                                                id="button-addon2">
                                                                                <button class="btn btn-danger"
                                                                                    type="button"
                                                                                    data-repeater-delete><i
                                                                                        class="ft-x"></i></button>
                                                                            </span>
                                                                            <div class="form-control-position">
                                                                                <i class="fa fa-file-o"></i>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="input-group mb-1" data-repeater-item>
                                                                        <input type="text"
                                                                            class="form-control criteria-spi"
                                                                            placeholder="Penyebab" name="criteria">
                                                                        <span class="input-group-append"
                                                                            id="button-addon2">
                                                                            <button class="btn btn-danger"
                                                                                type="button" data-repeater-delete><i
                                                                                    class="ft-x"></i></button>
                                                                        </span>
                                                                        <div class="form-control-position">
                                                                            <i class="fa fa-file-o"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div data-repeater-list="criteria">
                                                                <div class="input-group mb-1" data-repeater-item>
                                                                    <input type="text"
                                                                        class="form-control criteria-spi"
                                                                        placeholder="Penyebab" name="criteria">
                                                                    <span class="input-group-append"
                                                                        id="button-addon2">
                                                                        <button class="btn btn-danger" type="button"
                                                                            data-repeater-delete><i
                                                                                class="ft-x"></i></button>
                                                                    </span>
                                                                    <div class="form-control-position">
                                                                        <i class="fa fa-file-o"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <button type="button" data-repeater-create
                                                            class="btn btn-primary">
                                                            <i class="ft-plus"></i> Tambah Kriteria
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12">
                                                <a href="{{ route('audit.temuan.index', $auditId) }}"
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
    <script>
        const showFormFinding = (value) => {
            if (value == 1) {
                $("#field_mark_finding").show('slow');
            } else {
                $("#mark_finding").val('');
                $("#field_mark_finding").hide('slow');
            }
        }
    </script>
</body>

</html>
