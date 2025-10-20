<?php

namespace App\DataTables;

use App\Enums\Type;
use App\Models\Audit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use App\Enums\Status;

class LaporanHasilAuditTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('no', function ($row) use ($query) {
                $index = $query->get()->search($row) + 1;
                return $index;
            })
            ->addColumn('action', function ($row) {
                $btn =   '
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-info" onclick="detailData(' . $row->id . ')"><i class="fa fa-info"></i>&nbsp; Detail</button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(62px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="' . route('audit.notice.index', $row->id) . '">Hal-hal yang perlu diperhatikan</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="' . route('audit.temuan.index', $row->id) . '">Temuan & Rekomendasi</a>
                        </div>
                    </div>
                ';
                return $btn;
            })
            ->rawColumns(['no', 'status', 'action'])
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Audit $model): QueryBuilder
    {
        return $model->newQuery();
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
            // ->dom('lfrtip')
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100, 200, 500])
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons(
                Button::make('pageLength'),
                Button::make('excel'),
                // Button::make('print'),
                // Button::make('pdf'),
            );
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::computed('no')->title('No')
                ->width(20)
                ->addClass('text-center'),
            Column::make('code')->title('Nomor LHA'),
            Column::make('judul_audit')->title('Judul Audit'),
            Column::make('date')->title('Tanggal LHA'),
            Column::make('divisi')->title('Divisi / Unit'),
            Column::computed('action')->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Laporan Hasil Audit_' . date('YmdHis');
    }
}
