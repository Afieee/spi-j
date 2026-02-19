<?php

namespace App\DataTables;

use App\Models\Audit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class LaporanHasilAuditTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addIndexColumn()

            ->addColumn('status', function ($row) {

                $totalRekom = 0;
                $totalClosedTL = 0;

                foreach ($row->temuans as $temuan) {

                    foreach ($temuan->recomendeds as $rekom) {

                        $totalRekom++;

                        // Jika tidak ada TL sama sekali → otomatis proses
                        if ($rekom->tindakLanjut->isEmpty()) {
                            continue;
                        }

                        foreach ($rekom->tindakLanjut as $tl) {

                            if (trim(strtolower($tl->status_tl)) === strtolower("Sudah Tindak Lanjut")) {
                                $totalClosedTL++;
                            }
                        }
                    }
                }

                // Jika tidak ada rekomendasi
                if ($totalRekom === 0) {
                    return '<span class="badge badge-warning">Proses</span>';
                }

                // Jika semua rekomendasi sudah memiliki TL yang closed
                if ($totalClosedTL >= $totalRekom) {
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
     * Get the query source of dataTable.
     */
    public function query(Audit $model): QueryBuilder
    {
        return $model->newQuery()
            ->with([
                'temuans.recomendeds.tindakLanjut'
            ]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('lha-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100, 200, 500])
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons(
                Button::make('pageLength'),
                Button::make('excel')
            );
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::computed('DT_RowIndex')
                ->title('No')
                ->addClass('text-center')
                ->width(20),

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
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Laporan_Hasil_Audit_' . date('YmdHis');
    }
}
