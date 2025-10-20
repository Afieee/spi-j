<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Ubah Status Rekomendasi</title>
    <style>
        .form-container {
            display: none;
            margin-top: 20px;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
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
                    <h3 class="content-header-title mb-0 d-inline-block">Ubah Status Rekomendasi</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Tindak Lanjut Hasil Audit</li>
                                <li class="breadcrumb-item active">Ubah Status</li>
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

                                        <form action="{{ route('updateRecomendeds', $recomendeds->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div>
                                                <p><strong>Judul Audit:</strong> {{ $recomendeds->title }}</p>
                                                <p><strong>Kode Audit:</strong> {{ $recomendeds->code }}</p>
                                                <p><strong>Divisi:</strong> {{ $recomendeds->divisi }}</p>
                                                <p><strong>Aktivitas:</strong> {{ $recomendeds->activity }}</p>
                                                <hr>
                                                <label for="status"><strong>Status</strong></label>
                                                <select name="status" class="form-control">
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $recomendeds->status == $i ? 'selected' : '' }}>
                                                            @if ($i == 1)
                                                                Terbuka
                                                            @elseif ($i == 2)
                                                                On Progress
                                                            @elseif ($i == 3)
                                                                Selesai
                                                            @endif
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> Ubah Status
                                                </button>
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

    {{-- Footer --}}
    @include('Template.footer')

    {{-- JS --}}
    @include('Template.js')
</body>

</html>
