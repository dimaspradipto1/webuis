<?php

namespace App\DataTables;

use App\Models\Sarana;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SaranaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Sarana>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('icon_preview', function (Sarana $sarana) {
                return '<div style="font-size:26px;color:#823ca2;">'
                     .'<i class="bi '.e($sarana->icon).'"></i>'
                     .'</div>'
                     .'<span class="text-muted small">'.e($sarana->icon).'</span>';
            })
            ->addColumn('nama', function (Sarana $sarana) {
                $kat = $sarana->kategori ?: 'Fasilitas Kampus';
                $badgeClass = $kat === 'Laboratorium & Studio' ? 'bg-primary' : 'bg-success';

                return '<div class="fw-semibold">'.e($sarana->nama).'</div>'
                     .'<span class="badge '.$badgeClass.' mt-1" style="font-size:10.5px;">'.e($kat).'</span>';
            })
            ->addColumn('deskripsi', function (Sarana $sarana) {
                if (! $sarana->deskripsi) {
                    return '<span class="text-muted fst-italic">&mdash;</span>';
                }
                $clean = trim(html_entity_decode(strip_tags($sarana->deskripsi), ENT_QUOTES, 'UTF-8'));

                return '<span title="'.e($clean).'">'
                      .e(Str::limit($clean, 65))
                      .'</span>';
            })
            ->addColumn('urutan', function (Sarana $sarana) {
                return '<span class="badge bg-secondary">'.$sarana->urutan.'</span>';
            })
            ->addColumn('status', function (Sarana $sarana) {
                return $sarana->is_active
                    ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>'
                    : '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function (Sarana $sarana) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Lihat Detail di Frontend
                $detailUrl = route('homepage.fasilitas.detail', $sarana->slug ?: $sarana->id);
                $btn .= '<a href="'.$detailUrl.'" target="_blank"
                            class="btn btn-sm btn-info text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Lihat Halaman Detail">
                            <i class="bi bi-eye-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Edit
                $btn .= '<a href="'.route('sarana.edit', $sarana->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit Detail">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('sarana.destroy', $sarana->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus sarana ini?\')">'
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
            ->rawColumns(['icon_preview', 'nama', 'deskripsi', 'urutan', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Sarana>
     */
    public function query(Sarana $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'slug', 'kategori', 'icon', 'nama', 'deskripsi', 'urutan', 'is_active'])
            ->when(request('kategori'), fn ($q, $kat) => $q->where('kategori', $kat))
            ->orderBy('urutan');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sarana-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5) // order by urutan
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

            Column::make('nama')
                ->title('Nama Sarana / Fasilitas'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

            Column::computed('status')
                ->title('Status')
                ->width('10%')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false),

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
        return 'Sarana_'.date('YmdHis');
    }
}
