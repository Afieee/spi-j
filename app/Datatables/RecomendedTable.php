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
use Illuminate\Http\Request;

class RecomendedTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Ambil filter divisi dari request
        $filterDivisi = request()->get('filterDivisi');

        // Tambahkan filter ke query
        if (!empty($filterDivisi)) {
            $query->whereHas('audit', function ($q) use ($filterDivisi) {
                $q->where('divisi', $filterDivisi);
            });
        }

        return (new EloquentDataTable($query))
            ->addColumn('no', function ($row) use ($query) {
                $index = $query->get()->search($row) + 1;
                return $index;
            })
            ->addColumn('codeLHA', function ($row) {
                return $row->audit->code;
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
            ->addColumn('fileClose', function ($row) {
                if ($row->status == 3) {
                    return '<a href="' . $row->closed_file_surat . '" class="btn btn-primary" target="_BLANK">Lihat File</a>';
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if ($row->status != 3) {
                    $btn =   '
                        <div class="btn-group" role="group" aria-label="First Group">
                            <button type="button" class="btn btn-info mr-1" onclick="handlerEdit(\'' . $row->id . '\')"><i
                                    class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" onclick="handlerDelete(\'' . $row->id . '\')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                } else {
                    $btn = '-';
                }

                return $btn;
            })
            ->rawColumns(['no', 'codeLHA', 'status', 'fileClose', 'action'])
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Recomended $model, Request $request): QueryBuilder
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
            ->setTableId('rekomendasi-table')
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
            Column::computed('codeLHA')->title('Nomor LHA'),
            Column::make('title')->title('Rekomendasi'),
            Column::make('status')->title('Status'),
            Column::make('fileClose')->title('File Tutup Rekomendasi'),
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
        return 'Rekomendasi_' . date('YmdHis');
    }
}
