<?php

namespace App\DataTables;

use App\Models\OrganisasiMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrganisasiMahasiswaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('logo_preview', function ($o) {
                if (! empty($o->logo)) {
                    return '<img src="'.asset('storage/'.$o->logo).'" alt="'.e($o->nama_organisasi).'" class="rounded shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">';
                }
                $initial = strtoupper(substr($o->singkatan ?: $o->nama_organisasi, 0, 2));

                return '<div class="rounded d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #823ca2 0%, #190a24 100%); font-size: 13px;">'.$initial.'</div>';
            })
            ->editColumn('nama_organisasi', function ($o) {
                $html = '<div class="fw-bold text-dark text-nowrap" style="min-width: 220px;">'.e($o->nama_organisasi).'</div>';
                if (! empty($o->singkatan)) {
                    $html .= '<span class="badge bg-light text-primary border me-1">'.e($o->singkatan).'</span>';
                }
                if (! empty($o->periode)) {
                    $html .= '<span class="badge bg-light text-muted border">Periode '.e($o->periode).'</span>';
                }

                return $html;
            })
            ->editColumn('kategori', function ($o) {
                return '<span class="badge" style="background:#823ca2; color:#fff; font-size:11.5px; padding:5px 10px;">'.e($o->kategori).'</span>';
            })
            ->addColumn('kepengurusan', function ($o) {
                $html = '<div class="small text-nowrap">';
                if (! empty($o->nama_ketua)) {
                    $html .= '<div><strong>Ketua:</strong> '.e($o->nama_ketua).'</div>';
                }
                if (! empty($o->nama_wakil)) {
                    $html .= '<div class="text-muted"><strong>Wakil:</strong> '.e($o->nama_wakil).'</div>';
                }
                $html .= '</div>';

                return $html ?: '<span class="text-muted">-</span>';
            })
            ->addColumn('kontak', function ($o) {
                $html = '<div class="d-flex align-items-center gap-1">';
                if (! empty($o->instagram)) {
                    $html .= '<a href="'.e($o->instagram).'" target="_blank" class="badge bg-light text-danger border" title="Instagram"><i class="bi bi-instagram"></i></a>';
                }
                if (! empty($o->email)) {
                    $html .= '<a href="mailto:'.e($o->email).'" class="badge bg-light text-primary border" title="Email"><i class="bi bi-envelope"></i></a>';
                }
                if (! empty($o->link_pendaftaran)) {
                    $html .= '<a href="'.e($o->link_pendaftaran).'" target="_blank" class="badge bg-success text-white" title="Link Pendaftaran"><i class="bi bi-pencil-square"></i></a>';
                }
                $html .= '</div>';

                return $html;
            })
            ->addColumn('status', function ($o) {
                return $o->is_active
                    ? '<span class="badge bg-success text-nowrap">Aktif</span>'
                    : '<span class="badge bg-secondary text-nowrap">Nonaktif</span>';
            })
            ->addColumn('action', function ($o) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('organisasi-mahasiswa.edit', $o->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('organisasi-mahasiswa.destroy', $o->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus data organisasi mahasiswa ini?\')">'
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
            ->filterColumn('nama_organisasi', function ($query, $keyword) {
                $query->where('nama_organisasi', 'like', "%{$keyword}%")
                    ->orWhere('singkatan', 'like', "%{$keyword}%");
            })
            ->filterColumn('kategori', function ($query, $keyword) {
                $query->where('kategori', 'like', "%{$keyword}%");
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['logo_preview', 'nama_organisasi', 'kategori', 'kepengurusan', 'kontak', 'status', 'action']);
    }

    public function query(OrganisasiMahasiswa $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('urutan')->orderBy('nama_organisasi');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('organisasi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
            ])
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
            Column::make('DT_RowIndex')->title('No')->width('50px')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('logo_preview')->title('Logo')->width('70px')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('nama_organisasi')->title('Nama Organisasi & Periode')->width('260px')->searchable(true),
            Column::make('kategori')->title('Kategori')->width('180px')->addClass('text-center')->searchable(true),
            Column::make('kepengurusan')->title('Ketua & Wakil')->width('180px')->searchable(false),
            Column::make('kontak')->title('Media Sosial / Pendaftaran')->width('130px')->addClass('text-center')->searchable(false),
            Column::make('status')->title('Status')->width('90px')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('90px')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'OrganisasiMahasiswa_'.date('YmdHis');
    }
}
