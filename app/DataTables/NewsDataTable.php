<?php

namespace App\DataTables;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<News>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('thumbnail', function ($news) {
                if ($news->thumbnail) {
                    return '<img src="'.asset('storage/'.$news->thumbnail).'"
                                 alt="'.e($news->title).'"
                                 style="width:70px;height:45px;object-fit:cover;border-radius:4px;border:1px solid #dee2e6"
                                 loading="lazy">';
                }

                return '<div class="d-inline-flex align-items-center justify-content-center"
                             style="width:70px;height:45px;border-radius:4px;border:1px solid #cbd5e1;background-color:#e2e8f0;color:#64748b;">
                            <i class="bi bi-image" style="font-size:1.25rem;line-height:1;"></i>
                        </div>';
            })
            ->addColumn('title', function ($news) {
                return e($news->title);
            })
            ->addColumn('category', function ($news) {
                $cat = $news->category ?: 'Berita Universitas';

                return '<span class="badge bg-light text-dark border fw-medium">'.e($cat).'</span>';
            })
            ->addColumn('author', function ($news) {
                return $news->user ? e($news->user->name) : '<span class="text-muted fst-italic">Anonim</span>';
            })
            ->addColumn('published_at', function ($news) {
                $date = $news->published_at ?? $news->created_at;

                return $date ? '<span class="small text-nowrap"><i class="bi bi-clock me-1 text-muted"></i>'.$date->format('d/m/Y H:i').'</span>' : '-';
            })
            ->addColumn('status', function ($news) {
                if ($news->status === 'published') {
                    return '<span class="badge bg-success">Published</span>';
                }

                return '<span class="badge bg-secondary">Draft</span>';
            })
            ->addColumn('action', function ($news) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('news.edit', $news->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus (SweetAlert2)
                $btn .= '<form action="'.route('news.destroy', $news->id).'"
                              method="POST" class="m-0 form-delete-news">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="button"
                                   class="btn btn-sm btn-danger"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus"
                                   data-title="'.htmlspecialchars($news->title, ENT_QUOTES, 'UTF-8').'"
                                   onclick="confirmDeleteNews(event, this)">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                           </button>
                         </form>';

                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['thumbnail', 'category', 'published_at', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<News>
     */
    public function query(News $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with('user')
            ->select(['id', 'user_id', 'thumbnail', 'title', 'category', 'status', 'published_at', 'created_at']);

        // Jika role penulis (dan bukan admin), hanya tampilkan berita miliknya sendiri. Admin menampilkan semua.
        if (Auth::check() && Auth::user()->hasExactRole('penulis') && ! Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        return $query->latest('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('news-table')
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

            Column::computed('thumbnail')
                ->title('Thumbnail')
                ->width('10%')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false),

            Column::make('title')
                ->title('Judul Berita'),

            Column::make('category')
                ->title('Kategori')
                ->width('15%')
                ->addClass('text-center'),

            Column::computed('author')
                ->title('Penulis'),

            Column::make('published_at')
                ->title('Tanggal Publish')
                ->width('14%')
                ->addClass('text-center'),

            Column::make('status')
                ->title('Status')
                ->width('10%')
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
        return 'News_'.date('YmdHis');
    }
}
