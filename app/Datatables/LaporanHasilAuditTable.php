<?php

namespace App\DataTables;

use App\Models\Audit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Collection;

class LaporanHasilAuditTable extends DataTable
{
    /**
     * Hitung Status (0 = Proses, 1 = Ditutup)
     */
    private function getStatusOrder($row)
    {
        $totalRekom = 0;
        $totalClosedTL = 0;

        foreach ($row->temuans as $temuan) {
            foreach ($temuan->recomendeds as $rekom) {

                $totalRekom++;

                if ($rekom->tindakLanjut->isEmpty()) {
                    continue;
                }

                foreach ($rekom->tindakLanjut as $tl) {
                    if (
                        trim(strtolower($tl->status_tl)) ===
                        strtolower("Sudah Tindak Lanjut")
                    ) {
                        $totalClosedTL++;
                    }
                }
            }
        }

        if ($totalRekom === 0) {
            return 0; // Proses
        }

        if ($totalClosedTL >= $totalRekom) {
            return 1; // Ditutup
        }

        return 0; // Proses
    }

    /**
     * Build DataTable
     */
    public function dataTable($query)
    {
        // 🔥 Ambil semua data dulu
        $collection = $query->get();

        // 🔥 Tambahkan status_order ke tiap row
        $collection = $collection->map(function ($row) {
            $row->status_order = $this->getStatusOrder($row);
            return $row;
        });

        // 🔥 SORT MANUAL (Proses dulu, Ditutup bawah)
        $collection = $collection->sortBy('status_order');

        return datatables()
            ->collection($collection)

            ->addIndexColumn()

            ->addColumn('status', function ($row) {

                if ($row->status_order === 1) {
                    return '<span class="badge badge-success">Ditutup</span>';
                }

                return '<span class="badge badge-warning">Proses</span>';
            })

            ->addColumn('action', function ($row) {
                return '
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-info" onclick="detailData(' . $row->id . ')">
                            <i class="fa fa-info"></i>&nbsp; Detail
                        </button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('audit.notice.index', $row->id) . '">
                                Hal-hal yang perlu diperhatikan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="' . route('audit.temuan.index', $row->id) . '">
                                Temuan & Rekomendasi
                            </a>
                        </div>
                    </div>
                ';
            })

            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Query
     */
    public function query(Audit $model)
    {
        return $model->newQuery()
            ->with([
                'temuans.recomendeds.tindakLanjut'
            ]);
    }

    /**
     * HTML Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('lha-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100])
            ->selectStyleSingle()
            ->stateSave(false)
            ->buttons(
                Button::make('pageLength'),
                Button::make('excel')
            );
    }

    /**
     * Columns
     */
    public function getColumns(): array
    {
        return [

            Column::computed('DT_RowIndex')
                ->title('No')
                ->addClass('text-center'),

            Column::make('code')->title('Nomor LHA'),
            Column::make('judul_audit')->title('Judul Audit'),
            Column::make('date')->title('Tanggal LHA'),
            Column::make('divisi')->title('Divisi / Unit'),

            Column::computed('status')
                ->title('Status')
                ->addClass('text-center'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Laporan_Hasil_Audit_' . date('YmdHis');
    }
}
