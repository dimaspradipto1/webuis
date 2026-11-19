<?php

namespace App\DataTables;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TestimonialDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Testimonial>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('nama', function ($testimonial) {
                return '<div class="fw-semibold">'.e($testimonial->nama).'</div>'
                     .'<span class="text-muted small">'.e($testimonial->pekerjaan).'</span>';
            })
            ->addColumn('rating', function ($testimonial) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $testimonial->bintang) {
                        $stars .= '<i class="bi bi-star-fill text-warning" style="margin-right:2px"></i>';
                    } else {
                        $stars .= '<i class="bi bi-star text-muted" style="margin-right:2px"></i>';
                    }
                }

                return $stars;
            })
            ->addColumn('pesan', function ($testimonial) {
                if (! $testimonial->pesan) {
                    return '<span class="text-muted fst-italic">—</span>';
                }
                $clean = trim(html_entity_decode(strip_tags($testimonial->pesan), ENT_QUOTES, 'UTF-8'));

                return '<span title="'.e($clean).'">'.e(Str::limit($clean, 60)).'</span>';
            })
            ->addColumn('kategori', function ($testimonial) {
                $kat = strtolower($testimonial->kategori ?? '');
                if (str_contains($kat, 'alumni')) {
                    return '<span class="badge text-white" style="background:#046B26;">Alumni</span>';
                } elseif (str_contains($kat, 'mahasiswa')) {
                    return '<span class="badge bg-primary">Mahasiswa</span>';
                } elseif (str_contains($kat, 'mitra') || str_contains($kat, 'industri') || str_contains($kat, 'perusahaan') || str_contains($kat, 'rumah sakit')) {
                    return '<span class="badge bg-success">Mitra Industri / DUDI</span>';
                } elseif (str_contains($kat, 'dosen') || str_contains($kat, 'staff') || str_contains($kat, 'pendidik')) {
                    return '<span class="badge bg-info text-dark">Dosen & Staff</span>';
                } elseif (str_contains($kat, 'pengguna') || str_contains($kat, 'stakeholder')) {
                    return '<span class="badge text-white" style="background:#823ca2;">Pengguna Lulusan</span>';
                }

                return '<span class="badge bg-secondary">'.e($testimonial->kategori ?? 'Umum').'</span>';
            })
            ->addColumn('aktif', function ($testimonial) {
                if ($testimonial->aktif) {
                    return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif / Tayang</span>';
                }

                return '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>';
            })
            ->addColumn('action', function ($testimonial) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('testimonial.edit', $testimonial->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('testimonial.destroy', $testimonial->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus ulasan ini?\')">'
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
            ->rawColumns(['nama', 'rating', 'pesan', 'kategori', 'aktif', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Testimonial>
     */
    public function query(Testimonial $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'nama', 'pekerjaan', 'kategori', 'bintang', 'pesan', 'aktif'])
            ->latest('id'); // Input terakhir selalu berada di posisi paling atas (DESC)
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testimonial-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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

            Column::make('nama')
                ->title('Nama & Pekerjaan'),

            Column::computed('rating')
                ->title('Rating')
                ->width('12%')
                ->addClass('text-center'),

            Column::make('pesan')
                ->title('Ulasan'),

            Column::make('kategori')
                ->title('Kategori')
                ->width('12%')
                ->addClass('text-center'),

            Column::make('aktif')
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
        return 'Testimonial_'.date('YmdHis');
    }
}
