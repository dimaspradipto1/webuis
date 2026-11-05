<?php

namespace App\DataTables;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GalleryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Gallery>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('foto', function ($gallery) {
                if ($gallery->url) {
                    $count = is_array($gallery->galeri) ? count($gallery->galeri) : 1;
                    $badge = $count > 1
                        ? '<span class="badge bg-dark position-absolute bottom-0 end-0 m-1" style="font-size:10px;"><i class="bi bi-images me-1"></i>'.$count.'</span>'
                        : '';

                    return '<div class="position-relative d-inline-block">'
                        .'<img src="'.asset('storage/'.$gallery->url).'"
                                 alt="'.e($gallery->judul ?? 'Foto').'"
                                 style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6"
                                 loading="lazy">'
                        .$badge
                        .'</div>';
                }

                return '<span class="text-muted small">Tidak ada foto</span>';
            })
            ->addColumn('judul', function ($gallery) {
                return $gallery->judul
                    ? '<span title="'.e($gallery->judul).'">'.e(Str::limit($gallery->judul, 40)).'</span>'
                    : '<span class="text-muted fst-italic">—</span>';
            })
            ->addColumn('deskripsi', function ($gallery) {
                if (! $gallery->deskripsi) {
                    return '<span class="text-muted fst-italic">—</span>';
                }
                $clean = trim(html_entity_decode(strip_tags($gallery->deskripsi), ENT_QUOTES, 'UTF-8'));

                return '<span title="'.e($clean).'">'.e(Str::limit($clean, 60)).'</span>';
            })
            ->addColumn('kategori', function ($gallery) {
                if ($gallery->kategori === 'humas') {
                    return '<span class="badge bg-success px-2 py-1"><i class="bi bi-megaphone-fill me-1"></i>Humas</span>';
                }

                return '<span class="badge bg-primary px-2 py-1"><i class="bi bi-building me-1"></i>Universitas</span>';
            })
            ->addColumn('action', function ($gallery) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('gallery.edit', $gallery->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('gallery.destroy', $gallery->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus foto ini?\')">'
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
            ->rawColumns(['foto', 'judul', 'kategori', 'deskripsi', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Gallery>
     */
    public function query(Gallery $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'judul', 'slug', 'kategori', 'deskripsi', 'url', 'galeri']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('gallery-table')
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

            Column::computed('foto')
                ->title('Foto')
                ->width('10%')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false),

            Column::make('judul')
                ->title('Judul'),

            Column::make('kategori')
                ->title('Kategori')
                ->width('12%')
                ->addClass('text-center'),

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

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Gallery_'.date('YmdHis');
    }
}
