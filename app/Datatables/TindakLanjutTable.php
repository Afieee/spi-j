<?php

namespace App\DataTables;

use App\Models\Recomended;
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

class TindakLanjutTable extends DataTable
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
            ->addColumn('code', function ($row) {
                return $row->audit->code;
            })
            ->addColumn('title', function ($row) {
                return $row->audit->title;
            })
            ->addColumn('rekomendasi', function ($row) {
                return $row->title;
            })
            ->addColumn('temuan', function ($row) {
                $result = "";
                $result .= '<ol>';
                foreach ($row->audit->findings as $key => $value) {
                    $result .= '<li>' . $value->title . '</li>';
                }
                $result .= '</ol>';
                return $result;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-primary">' . Status::getDescription($row->status) . '</span>';
                } else if ($row->status == 2) {
                    return '<span class="badge badge-warning">' . Status::getDescription($row->status) . '</span>';
                } else {
                    return '<span class="badge badge-success">' . Status::getDescription($row->status) . '</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $btn =   '
                    <button type="button"
                        class="btn btn-outline-success block btn-lg" onclick="handlerSetStatus(\'' . $row->id . '\')">
                        Ubah Status
                    </button>
                ';
                return $btn;
            })
            ->rawColumns(['no', 'code', 'title', 'temuan', 'rekomendasi', 'status', 'action'])
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Recomended $model): QueryBuilder
    {
        return $model
            ->with('audit', 'audit.findings')->whereIn('status', [1, 2])
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tindak-lanjut-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            // ->dom('lfrtip')
            ->pageLength(10)
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
            Column::make('title')->title('Judul LHA'),
            Column::computed('temuan')->title('Temuan'),
            Column::computed('rekomendasi')->title('Rekomendasi'),
            Column::make('status')->title('Status'),
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
        return 'Tindak Lanjut_' . date('YmdHis');
    }
}
