<?php

namespace App\DataTables;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FeatureDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Feature>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('icon_preview', function ($feature) {
                return '<div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-1" style="width:40px;height:40px;background:#eef8f1;color:#046B26;font-size:20px;">'
                     .'<i class="bi '.e($feature->icon).'"></i></div>'
                     .'<div class="text-muted" style="font-size:11px;">'.e($feature->icon).'</div>';
            })
            ->addColumn('judul', function ($feature) {
                $highlight = (int) $feature->urutan === 1
                    ? '<span class="badge bg-success-subtle text-success border border-success-subtle ms-2" style="font-size:10px;">Kartu Utama (Hijau)</span>'
                    : '';

                return '<span class="fw-semibold text-dark">'.e($feature->judul).'</span>'.$highlight;
            })
            ->addColumn('deskripsi', function ($feature) {
                if (! $feature->deskripsi) {
                    return '<span class="text-muted fst-italic">—</span>';
                }
                $clean = trim(html_entity_decode(strip_tags($feature->deskripsi), ENT_QUOTES, 'UTF-8'));

                return '<span title="'.e($clean).'">'.e(Str::limit($clean, 75)).'</span>';
            })
            ->addColumn('badge_label', function ($feature) {
                return '<span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-bold" style="background:#eef8f1;color:#046B26;border:1px solid #cce8d4;font-size:11px;letter-spacing:0.4px;">'
                     .'<span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span> '
                     .e($feature->badge)
                     .'</span>';
            })
            ->addColumn('urutan', function ($feature) {
                return '<span class="badge bg-secondary">'.$feature->urutan.'</span>';
            })
            ->addColumn('action', function ($feature) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('feature.edit', $feature->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('feature.destroy', $feature->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus kartu keunggulan ini?\')">'
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
            ->rawColumns(['icon_preview', 'judul', 'deskripsi', 'badge_label', 'urutan', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Feature>
     */
    public function query(Feature $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'icon', 'judul', 'deskripsi', 'urutan'])
            ->orderBy('urutan');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('feature-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->width('5%')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),

            Column::computed('icon_preview')
                ->title('Icon')
                ->width('12%')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false),

            Column::make('judul')
                ->title('Judul Kartu'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

            Column::computed('badge_label')
                ->title('Label Badge')
                ->width('15%')
                ->addClass('text-center'),

            Column::make('urutan')
                ->title('Urutan')
                ->width('8%')
                ->addClass('text-center'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width('10%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Feature_' . date('YmdHis');
    }
}
