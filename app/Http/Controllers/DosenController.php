<?php

namespace App\Http\Controllers;

use App\DataTables\DosenDataTable;
use App\Http\Requests\DosenRequest;
use App\Models\Dosen;
use App\Models\Layanan;
use App\Services\DosenExcelService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DosenController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService,
        protected DosenExcelService $excelService
    ) {}

    public function index(DosenDataTable $dataTable)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return $dataTable->render('pages.dosen.index', compact('prodis'));
    }

    public function create(): View
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('pages.dosen.create', compact('prodis'));
    }

    public function store(DosenRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->filled('layanan_id')) {
            $prodi = Layanan::find($request->layanan_id);
            $data['prodi_nama'] = $prodi?->judul;
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileUploadService->upload($request->file('foto'), 'dosen/foto');
        }

        Dosen::create($data);

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen): View
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('pages.dosen.edit', compact('dosen', 'prodis'));
    }

    public function update(DosenRequest $request, Dosen $dosen): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->filled('layanan_id')) {
            $prodi = Layanan::find($request->layanan_id);
            $data['prodi_nama'] = $prodi?->judul;
        }

        if ($request->hasFile('foto')) {
            $this->fileUploadService->delete($dosen->foto);
            $data['foto'] = $this->fileUploadService->upload($request->file('foto'), 'dosen/foto');
        }

        $dosen->update($data);

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $this->fileUploadService->delete($dosen->foto);
        $dosen->delete();

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }

    /**
     * Hapus beberapa data dosen terpilih (Multi-Select Delete)
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids');

        if (empty($ids) || ! is_array($ids)) {
            return redirect()
                ->route('dosen.index')
                ->with('error', 'Tidak ada data dosen yang dipilih untuk dihapus.');
        }

        $count = DB::transaction(function () use ($ids) {
            $dosens = Dosen::whereIn('id', $ids)->get();
            $deletedCount = $dosens->count();

            foreach ($dosens as $dosen) {
                $this->fileUploadService->delete($dosen->foto);
                $dosen->delete();
            }

            return $deletedCount;
        });

        return redirect()
            ->route('dosen.index')
            ->with('success', "Berhasil menghapus {$count} data dosen terpilih.");
    }

    /**
     * Hapus semua data dosen (Delete All)
     */
    public function deleteAll(): RedirectResponse
    {
        $count = DB::transaction(function () {
            $dosens = Dosen::all();
            $total = $dosens->count();

            foreach ($dosens as $dosen) {
                $this->fileUploadService->delete($dosen->foto);
                $dosen->delete();
            }

            return $total;
        });

        return redirect()
            ->route('dosen.index')
            ->with('success', "Semua data dosen ({$count} data) berhasil dikosongkan.");
    }

    /**
     * Download Template Excel Format Pengisian Dosen
     */
    public function downloadTemplate(): StreamedResponse
    {
        return $this->excelService->downloadTemplate();
    }

    /**
     * Import Data Dosen dari File Excel / CSV
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:102400'],
        ], [
            'file_excel.required' => 'Silakan pilih file Excel / CSV yang akan diimpor.',
            'file_excel.mimes' => 'Format file harus berupa .xlsx, .xls, atau .csv.',
            'file_excel.max' => 'Ukuran file maksimal 100MB.',
        ]);

        try {
            $importedCount = $this->excelService->importExcel($request->file('file_excel'));

            return redirect()
                ->route('dosen.index')
                ->with('success', "Proses impor selesai! Sebanyak {$importedCount} data dosen berhasil diimpor ke database.");
        } catch (\Exception $e) {
            return redirect()
                ->route('dosen.index')
                ->with('error', 'Terjadi kesalahan saat memproses file Excel: '.$e->getMessage());
        }
    }
}
