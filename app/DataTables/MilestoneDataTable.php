<?php

namespace App\DataTables;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MilestoneDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('tahun', fn ($m) => e($m->tahun))
            ->addColumn('judul', fn ($m) => e($m->judul))
            ->addColumn('deskripsi', fn ($m) => e(Str::limit($m->clean_deskripsi, 80)))
            ->addColumn('action', function ($milestone) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('milestone.edit', $milestone->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('milestone.destroy', $milestone->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus milestone ini?\')">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit"
                                   class="btn btn-sm btn-danger"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                           </button>
                         </form>';

                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action']);
    }

    public function query(Milestone $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'tahun', 'judul', 'deskripsi'])->orderBy('tahun');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('milestone-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->width('5%')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),

            Column::make('tahun')
                ->title('Tahun')
                ->width('10%')
                ->addClass('text-center'),

            Column::make('judul')
                ->title('Judul Milestone'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width('10%')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Milestone_'.date('YmdHis');
    }
}
