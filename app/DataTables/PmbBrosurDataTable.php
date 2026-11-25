<?php

namespace App\DataTables;

use App\Models\PmbBrosur;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PmbBrosurDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<PmbBrosur>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('gambar_preview', function (PmbBrosur $b) {
                return '<a href="'.$b->gambar_url.'" target="_blank" title="Klik untuk perbesar">'
                     .'<img src="'.$b->gambar_url.'" alt="'.e($b->judul).'" '
                     .'class="rounded-3 shadow-sm border" style="width:64px;height:84px;object-fit:cover;cursor:pointer;">'
                     .'</a>';
            })
            ->addColumn('judul_lengkap', function (PmbBrosur $b) {
                $html = '<div class="fw-bold text-dark" style="font-size:14px;">'.e($b->judul).'</div>';
                if ($b->tahun_akademik) {
                    $html .= '<span class="badge bg-light text-muted border me-1" style="font-size:11px;">TA: '.e($b->tahun_akademik).'</span>';
                }
                if ($b->deskripsi) {
                    $html .= '<div class="text-muted small mt-1" style="font-size:11.5px;max-width:320px;">'.e(\Illuminate\Support\Str::limit($b->deskripsi, 90)).'</div>';
                }
                return $html;
            })
            ->addColumn('kategori_fakultas', function (PmbBrosur $b) {
                $badgeColor = match ($b->kategori_fakultas) {
                    'Fakultas Sains dan Teknologi' => 'background:#0d6efd;color:#ffffff;',
                    'Fakultas Ekonomi dan Bisnis' => 'background:#0dcaf0;color:#000000;',
                    'Fakultas Ilmu Kesehatan' => 'background:#dc3545;color:#ffffff;',
                    'Program Pascasarjana' => 'background:#6f42c1;color:#ffffff;',
                    default => 'background:#046B26;color:#ffffff;',
                };

                return '<span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="'.$badgeColor.'font-size:11.5px;">'
                     .e($b->kategori_fakultas ?: 'Universitas')
                     .'</span>';
            })
            ->addColumn('file_pdf', function (PmbBrosur $b) {
                if ($b->file_pdf) {
                    return '<a href="'.$b->pdf_url.'" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" style="font-size:11px;">'
                         .'<i class="bi bi-file-earmark-pdf-fill me-1"></i>Unduh PDF</a>';
                }
                return '<span class="text-muted small">-</span>';
            })
            ->addColumn('urutan', function (PmbBrosur $b) {
                return '<span class="badge bg-light text-dark border px-2.5 py-1 fw-bold">'.$b->urutan.'</span>';
            })
            ->addColumn('status', function (PmbBrosur $b) {
                return $b->is_active
                    ? '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small"><i class="bi bi-check-circle me-1"></i>Aktif</span>'
                    : '<span class="badge bg-secondary-subtle text-muted rounded-pill px-2.5 py-1 small">Nonaktif</span>';
            })
            ->addColumn('action', function (PmbBrosur $b) {
                $btn = '<div class="d-flex justify-content-center align-items-center gap-1.5">';

                // Tombol Edit
                $btn .= '<button type="button" class="btn btn-sm btn-warning text-dark btn-edit-brosur" '
                     .'data-id="'.$b->id.'" '
                     .'data-judul="'.e($b->judul).'" '
                     .'data-kategori="'.e($b->kategori_fakultas).'" '
                     .'data-tahun="'.e($b->tahun_akademik).'" '
                     .'data-deskripsi="'.e($b->deskripsi).'" '
                     .'data-urutan="'.$b->urutan.'" '
                     .'data-active="'.($b->is_active ? '1' : '0').'" '
                     .'data-gambar-url="'.$b->gambar_url.'" '
                     .'data-pdf-url="'.($b->pdf_url ?? '').'" '
                     .'data-update-url="'.route('admin.pmb.brosur.update-item', $b->id).'" '
                     .'style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;" '
                     .'title="Edit Brosur">'
                     .'<i class="bi bi-pencil-fill" style="font-size:12px"></i>'
                     .'</button>';

                // Tombol Hapus
                $btn .= '<form action="'.route('admin.pmb.brosur.destroy', $b->id).'" '
                     .'method="POST" class="m-0" '
                     .'onsubmit="return confirm(\'Yakin ingin menghapus brosur/poster PMB ini?\')">'
                     .csrf_field().method_field('DELETE')
                     .'<button type="submit" class="btn btn-sm btn-danger text-white" '
                     .'style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;" '
                     .'title="Hapus Brosur">'
                     .'<i class="bi bi-trash-fill" style="font-size:12px"></i>'
                     .'</button>'
                     .'</form>';

                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['gambar_preview', 'judul_lengkap', 'kategori_fakultas', 'file_pdf', 'urutan', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PmbBrosur>
     */
    public function query(PmbBrosur $model): QueryBuilder
    {
        return $model->newQuery()
            ->orderBy('urutan')
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pmb-brosur-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
                'language' => [
                    'search' => 'Cari Brosur:',
                    'lengthMenu' => 'Tampilkan _MENU_ data',
                    'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ brosur',
                    'infoEmpty' => 'Tidak ada data',
                    'zeroRecords' => 'Brosur tidak ditemukan',
                    'paginate' => [
                        'first' => 'Awal',
                        'last' => 'Akhir',
                        'next' => 'Berikutnya',
                        'previous' => 'Sebelumnya',
                    ],
                ],
            ])
            ->orderBy(4, 'asc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('reload')->text('<i class="bi bi-arrow-clockwise"></i> Segarkan'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width('45px')->addClass('text-center align-middle')->searchable(false)->orderable(false),
            Column::make('gambar_preview')->title('Poster')->width('80px')->addClass('text-center align-middle')->searchable(false)->orderable(false),
            Column::make('judul_lengkap')->title('Judul Brosur & Keterangan')->addClass('align-middle'),
            Column::make('kategori_fakultas')->title('Fakultas / Kategori')->width('180px')->addClass('text-center align-middle'),
            Column::make('file_pdf')->title('Dokumen PDF')->width('120px')->addClass('text-center align-middle'),
            Column::make('urutan')->title('Urutan')->width('70px')->addClass('text-center align-middle'),
            Column::make('status')->title('Status')->width('90px')->addClass('text-center align-middle'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('100px')->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PmbBrosur_'.date('YmdHis');
    }
}
