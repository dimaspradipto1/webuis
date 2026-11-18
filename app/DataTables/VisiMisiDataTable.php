<?php

namespace App\DataTables;

use App\Models\VisiMisi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VisiMisiDataTable extends DataTable
{
    /**
     * @param  QueryBuilder<VisiMisi>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('gambar', function ($vm) {
                if ($vm->gambar_url) {
                    return '<div class="d-flex align-items-center gap-2">
                        <a href="'.$vm->gambar_url.'" target="_blank" title="Klik untuk lihat gambar penuh">
                            <img src="'.$vm->gambar_url.'" alt="'.e($vm->judul ?? 'Visi Misi').'"
                                 class="img-thumbnail rounded shadow-sm"
                                 style="width: 100px; height: 65px; object-fit: cover;">
                        </a>
                    </div>';
                }

                return '<span class="badge bg-light text-muted border"><i class="bi bi-image me-1"></i>Belum ada gambar</span>';
            })
            ->addColumn('judul', function ($vm) {
                $output = '<div class="fw-bold text-dark mb-1">'.e($vm->judul ?: 'Gambar Visi Misi #'.$vm->id).'</div>';
                if ($vm->keterangan) {
                    $output .= '<small class="text-muted d-block">'.e(Str::limit($vm->keterangan, 70)).'</small>';
                } elseif ($vm->isi) {
                    $output .= '<small class="text-muted d-block">'.e(Str::limit(strip_tags($vm->isi), 60)).'</small>';
                }
                return $output;
            })
            ->addColumn('urutan', fn ($vm) => '<span class="badge bg-secondary">'.$vm->urutan.'</span>')
            ->addColumn('status', function ($vm) {
                return $vm->is_active
                    ? '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>'
                    : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-x-circle-fill me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function ($visimisi) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:6px">';
                $btn .= '<a href="'.route('visimisi.edit', $visimisi->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:13px"></i>
                         </a>';
                $btn .= '<form action="'.route('visimisi.destroy', $visimisi->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus gambar visi misi ini?\')">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit"
                                   class="btn btn-sm btn-danger"
                                   style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;"
                                   title="Hapus">
                            <i class="bi bi-trash-fill" style="font-size:13px"></i>
                          </button>
                         </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['gambar', 'judul', 'urutan', 'status', 'action']);
    }

    /**
     * @return QueryBuilder<VisiMisi>
     */
    public function query(VisiMisi $model): QueryBuilder
    {
        return $model->newQuery()
            ->orderBy('urutan')
            ->orderBy('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('visimisi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3, 'asc')
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
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->width(50)->addClass('text-center align-middle'),
            Column::make('gambar')->title('Gambar')->orderable(false)->searchable(false)->width(130)->addClass('align-middle'),
            Column::make('judul')->title('Judul & Keterangan')->addClass('align-middle'),
            Column::make('urutan')->title('Urutan')->width(80)->addClass('text-center align-middle'),
            Column::make('status')->title('Status')->width(100)->addClass('text-center align-middle'),
            Column::computed('action')->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(110)
                ->addClass('text-center align-middle'),
        ];
    }

    protected function filename(): string
    {
        return 'VisiMisi_'.date('YmdHis');
    }
}
