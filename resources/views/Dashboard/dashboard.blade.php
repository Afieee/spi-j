<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    @include('Template.head')
    <title>SPI Navigator - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">
    @include('Template.nav')
    @include('Template.side-menu')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="filterTahun">Filter Tahun:</label>
                        <select id="filterTahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            @for ($year = 2023; $year <= 2028; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                @php
                    // Data Tindak Lanjut
                    $statusTL1 = App\Models\TindakLanjut::where('status_tl', 'Tindak Lanjut Tidak Sesuai')->count();
                    $statusTL2 = App\Models\TindakLanjut::where('status_tl', 'Sudah Tindak Lanjut')->count();
                    $statusTL3 = App\Models\TindakLanjut::where('status_tl', 'Belum Tindak Lanjut')->count();

                    // Data Tindak Lanjut berdasarkan tahun
                    $dataTindakLanjut = App\Models\TindakLanjut::selectRaw(
                        'YEAR(created_at) as tahun, status_tl, COUNT(*) as jumlah',
                    )
                        ->groupBy('tahun', 'status_tl')
                        ->get()
                        ->groupBy('tahun');

                    // Data lainnya
                    $auditCountStatus1 = App\Models\Recomended::where('status', 1)->count();
                    $auditCountStatus2 = App\Models\Recomended::where('status', 2)->count();
                    $auditCountStatus3 = App\Models\Recomended::where('status', 3)->count();

                    $auditCount = App\Models\Audit::count();
                    $data = App\Models\Recomended::selectRaw('YEAR(created_at) as tahun, status, COUNT(*) as jumlah')
                        ->groupBy('tahun', 'status')
                        ->get()
                        ->groupBy('tahun');

                    $hitungPKA = App\Models\Pkpt::whereNotNull('id_pkpt')->count();
                    $hitungSurat = App\Models\Audit::whereNotNull('file_surat_tugas')->count();
                @endphp

                <script>
                    var auditData = {
                        auditCount: {{ $auditCount }},
                        tahunData: {!! json_encode($data) !!},
                        hitungPKA: {{ $hitungPKA }},
                        hitungSurat: {{ $hitungSurat }},
                        closedCount: {{ $auditCountStatus3 }},
                        hitungPKAByYear: {!! json_encode(
                            App\Models\Pkpt::whereNotNull('id_pkpt')->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!},
                        hitungSuratByYear: {!! json_encode(
                            App\Models\Audit::whereNotNull('file_surat_tugas')->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!},
                        closedByYear: {!! json_encode(
                            App\Models\Recomended::where('status', 3)->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!},
                        statusTL1: {{ $statusTL1 }},
                        statusTL2: {{ $statusTL2 }},
                        statusTL3: {{ $statusTL3 }},
                        dataTindakLanjut: {!! json_encode($dataTindakLanjut) !!},
                        statusTL1ByYear: {!! json_encode(
                            App\Models\TindakLanjut::where('status_tl', 'Tindak Lanjut Tidak Sesuai')->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!},
                        statusTL2ByYear: {!! json_encode(
                            App\Models\TindakLanjut::where('status_tl', 'Sudah Tindak Lanjut')->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!},
                        statusTL3ByYear: {!! json_encode(
                            App\Models\TindakLanjut::where('status_tl', 'Belum Tindak Lanjut')->selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')->groupBy('tahun')->get()->keyBy('tahun'),
                        ) !!}
                    };
                </script>

                <div class="row">
                    <!-- Card untuk Laporan Hasil Audit -->
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-files-o font-large-2 blue-grey"></i>
                                <h3 class="mt-2" id="auditCount">{{ $auditCount }}</h3>
                                <p class="text-muted">Laporan Hasil Audit Keseluruhan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk PKPT -->
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                        <div class="card text-center">
                            <div class="card-body">
                                <a href="/halaman-pkpt">
                                    <i class="fa fa-clipboard font-large-2 blue"></i>
                                    <h3 class="mt-2" id="hitungPKA">{{ $hitungPKA }}</h3>
                                    <p class="text-muted">PKPT</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk Surat Tugas -->
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-envelope font-large-2 green"></i>
                                <h3 class="mt-2" id="hitungSurat">{{ $hitungSurat }}</h3>
                                <p class="text-muted">Surat Tugas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Chart untuk PKPT vs Surat Tugas -->
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">PKPT vs Surat Tugas</h4>
                                    <canvas id="auditBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart untuk Status Tindak Lanjut -->
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">Status Tindak Lanjut</h4>
                                    <canvas id="tindakLanjutPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Helper function to calculate percentages
            function calculatePercentages(values) {
                const total = values.reduce((sum, value) => sum + value, 0);
                return values.map(value => ((value / total) * 100).toFixed(1));
            }

            // Inisialisasi Chart 1: PKPT vs Surat Tugas
            var ctxDataPie = document.getElementById("auditBarChart").getContext("2d");
            var auditDataPieChart = new Chart(ctxDataPie, {
                type: "pie",
                data: {
                    labels: ["PKPT", "Surat Tugas"],
                    datasets: [{
                        data: [auditData.hitungPKA, auditData.hitungSurat],
                        backgroundColor: ["#9b59b6", "#1abc9c"],
                        borderColor: "#ffffff",
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Inisialisasi Chart 2: Status Tindak Lanjut (tanpa Tindak Lanjut Tidak Sesuai)
            var ctxTindakLanjutPie = document.getElementById("tindakLanjutPieChart").getContext("2d");
            var tindakLanjutPieChart = new Chart(ctxTindakLanjutPie, {
                type: "pie",
                data: {
                    labels: ["Sudah Tindak Lanjut", "Belum Tindak Lanjut"],
                    datasets: [{
                        data: [auditData.statusTL2, auditData.statusTL3],
                        backgroundColor: ["#16a085", "#e67e22"],
                        borderColor: "#ffffff",
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Fungsi untuk update semua chart berdasarkan tahun
            function updateData(tahun) {
                // Update Chart 1: PKPT vs Surat Tugas
                let hitungPKA = 0,
                    hitungSurat = 0;

                if (tahun === "") {
                    hitungPKA = auditData.hitungPKA;
                    hitungSurat = auditData.hitungSurat;
                } else {
                    hitungPKA = auditData.hitungPKAByYear[tahun] ? auditData.hitungPKAByYear[tahun].jumlah : 0;
                    hitungSurat = auditData.hitungSuratByYear[tahun] ? auditData.hitungSuratByYear[tahun].jumlah :
                    0;
                }

                const pkaSuratPercentages = calculatePercentages([hitungPKA, hitungSurat]);
                auditDataPieChart.data.datasets[0].data = [hitungPKA, hitungSurat];
                auditDataPieChart.data.labels = [
                    `PKPT (${pkaSuratPercentages[0]}%)`,
                    `Surat Tugas (${pkaSuratPercentages[1]}%)`
                ];
                auditDataPieChart.update();

                // Update Chart 2: Status Tindak Lanjut (tanpa Tindak Lanjut Tidak Sesuai)
                let statusTL2 = 0,
                    statusTL3 = 0;

                if (tahun === "") {
                    statusTL2 = auditData.statusTL2;
                    statusTL3 = auditData.statusTL3;
                } else {
                    statusTL2 = auditData.statusTL2ByYear[tahun] ? auditData.statusTL2ByYear[tahun].jumlah : 0;
                    statusTL3 = auditData.statusTL3ByYear[tahun] ? auditData.statusTL3ByYear[tahun].jumlah : 0;
                }

                const tindakLanjutPercentages = calculatePercentages([statusTL2, statusTL3]);
                tindakLanjutPieChart.data.datasets[0].data = [statusTL2, statusTL3];
                tindakLanjutPieChart.data.labels = [
                    `Sudah Tindak Lanjut (${tindakLanjutPercentages[0]}%)`,
                    `Belum Tindak Lanjut (${tindakLanjutPercentages[1]}%)`
                ];
                tindakLanjutPieChart.update();
            }

            // Event listener untuk filter tahun
            document.getElementById("filterTahun").addEventListener("change", function() {
                updateData(this.value);
            });

            // Initialize dengan semua data
            updateData("");
        });
    </script>

    @include('Template.footer')
    @include('Template.js')
</body>

</html>
