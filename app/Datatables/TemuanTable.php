<?php

namespace App\DataTables;

use App\Enums\Type;
use App\Models\Finding;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use App\Enums\JenisTemuan;
use App\Enums\Akibat;
use Illuminate\Http\Request;

class TemuanTable extends DataTable
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
            ->addColumn('type_finding', function ($row) {
                return JenisTemuan::getDescription($row->type_finding);
            })
            ->addColumn('consequence', function ($row) {
                return Akibat::getDescription($row->consequence);
            })
            ->addColumn('criteria', function ($row) {
                $html = '';
                if ($row->criteria) {
                    $html .= '<ol>';
                    foreach ($row->criteria as $key => $value) {
                        $html .= '<li>' . $value . '</li>';
                    }
                    $html .= '</ol>';
                }
                return $html;
            })
            ->addColumn('reason', function ($row) {
                $html = '';
                if ($row->reason) {
                    $html .= '<ol>';
                    foreach ($row->reason as $key => $value) {
                        $html .= '<li>' . $value . '</li>';
                    }
                    $html .= '</ol>';
                }
                return $html;
            })
            ->addColumn('action', function ($row) {
                $btn =   '
                    <button type="button" class="btn btn-outline-success block btn-lg" onclick="detailData(' . $row->id . ')">
                        Detail
                    </button>
                ';
                return $btn;
            })
            ->rawColumns(['no', 'type_finding', 'consequence', 'criteria', 'reason', 'action'])
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Finding $model, Request $request): QueryBuilder
    {
        $url = explode('/', $request->url());
        return $model
            ->where('audit_id', end($url))
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('temuan-table')
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
                // Button::make('excel'),
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
            Column::make('title')->title('Temuan'),
            Column::make('type_finding')->title('Jenis Temuan'),
            Column::make('consequence')->title('Penyebab'),
            Column::make('criteria')->title('Kriteria'),
            Column::make('reason')->title('Akibat'),
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
        return 'Temuan_' . date('YmdHis');
    }
}
