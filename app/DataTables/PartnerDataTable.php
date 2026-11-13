<?php

namespace App\DataTables;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
{
    /**
     * @param  QueryBuilder<Partner>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('logo', function ($p) {
                if ($p->logo) {
                    return '<img src="'.asset('storage/'.$p->logo).'"
                                 alt="'.e($p->nama).'"
                                 style="width:100px;height:50px;object-fit:contain;border-radius:4px;border:1px solid #dee2e6"
                                 loading="lazy">';
                }

                return '<span class="text-muted small">Belum ada logo</span>';
            })
            ->addColumn('nama', fn ($p) => e($p->nama))
            ->addColumn('urutan', fn ($p) => '<span class="badge bg-secondary">'.$p->urutan.'</span>')
            ->addColumn('aktif', function ($p) {
                return $p->aktif
                    ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>'
                    : '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function ($partner) {
                $btn = '<div class="d-flex justify-content-center align-items-center flex-wrap" style="gap:5px">';
                $btn .= '<a href="'.route('partner.agreements.index', $partner->id).'"
                            class="btn btn-sm btn-outline-success"
                            title="Kelola dokumen MOU, MOA, dan IA">
                            <i class="bi bi-file-earmark-text me-1"></i>Dokumen
                         </a>';
                $btn .= '<a href="'.route('partner.edit', $partner->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';
                $btn .= '<form action="'.route('partner.destroy', $partner->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus partner ini?\')">'
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
            ->rawColumns(['logo', 'nama', 'urutan', 'aktif', 'action']);
    }

    /**
     * @return QueryBuilder<Partner>
     */
    public function query(Partner $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'nama', 'logo', 'urutan', 'aktif'])
            ->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('partner-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3)
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
            Column::make('DT_RowIndex')->title('No')->width('5%')->addClass('text-center')->searchable(false)->orderable(false),
            Column::computed('logo')->title('Logo')->width('15%')->addClass('text-center')->exportable(false)->printable(false),
            Column::make('nama')->title('Nama Partner'),
            Column::make('urutan')->title('Urutan')->width('8%')->addClass('text-center'),
            Column::make('aktif')->title('Status')->width('10%')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('20%')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Partner_'.date('YmdHis');
    }
}
