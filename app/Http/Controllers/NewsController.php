<?php

namespace App\Http\Controllers;

use App\DataTables\NewsDataTable;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Services\FileUploadService;
use App\Services\NewsExcelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService,
        protected NewsExcelService $excelService
    ) {}

    public function index(NewsDataTable $dataTable)
    {
        return $dataTable->render('pages.news.index');
    }

    public function create(): View
    {
        return view('pages.news.create');
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->fileUploadService->uploadThumbnail($request->file('thumbnail'), 'news');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            $galleryPaths = $this->fileUploadService->uploadMultiple($request->file('gallery'), 'news/gallery');
        }

        $publishedAt = $request->filled('published_at')
            ? Carbon::parse($request->published_at)
            : now();

        News::create([
            'user_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'gallery' => ! empty($galleryPaths) ? $galleryPaths : null,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'category' => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
            'created_at' => $publishedAt,
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit(News $news): View
    {
        Gate::authorize('update', $news);

        return view('pages.news.edit', compact('news'));
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        Gate::authorize('update', $news);

        $thumbnailPath = $news->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $this->fileUploadService->delete($news->thumbnail);
            $thumbnailPath = $this->fileUploadService->uploadThumbnail($request->file('thumbnail'), 'news');
        }

        $currentGallery = is_array($news->gallery) ? $news->gallery : [];

        // Hapus gambar galeri yang ditandai hapus
        if ($request->filled('delete_gallery_images')) {
            $deleteList = (array) $request->input('delete_gallery_images');
            $this->fileUploadService->deleteMultiple($deleteList);
            $currentGallery = array_values(array_filter(
                $currentGallery,
                fn ($item) => ! in_array($item, $deleteList, true)
            ));
        }

        // Tambah gambar galeri baru jika diunggah
        if ($request->hasFile('gallery')) {
            $newGallery = $this->fileUploadService->uploadMultiple($request->file('gallery'), 'news/gallery');
            $currentGallery = array_merge($currentGallery, $newGallery);
        }

        $publishedAt = $request->filled('published_at')
            ? Carbon::parse($request->published_at)
            : now();

        $news->update([
            'thumbnail' => $thumbnailPath,
            'gallery' => ! empty($currentGallery) ? array_values($currentGallery) : null,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'category' => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
            'created_at' => $publishedAt,
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita dan galeri berhasil diperbarui.');
    }

    public function destroy(News $news): RedirectResponse
    {
        Gate::authorize('delete', $news);

        DB::transaction(function () use ($news) {
            $this->fileUploadService->delete($news->thumbnail);

            if (is_array($news->gallery)) {
                $this->fileUploadService->deleteMultiple($news->gallery);
            }

            $this->fileUploadService->deleteEmbeddedContentImages($news->content);

            $news->delete();
        });

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita dan file gambar terkait berhasil dihapus.');
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:20480',
        ]);

        if ($request->hasFile('file')) {
            $path = $this->fileUploadService->upload($request->file('file'), 'news/content');

            return response()->json([
                'location' => asset('storage/'.$path),
            ]);
        }

        return response()->json(['error' => 'Gagal mengunggah gambar'], 400);
    }

    public function downloadTemplate(): StreamedResponse
    {
        return $this->excelService->downloadTemplate();
    }

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
            $importedCount = $this->excelService->importExcel($request->file('file_excel'), Auth::id() ?? 1);

            if ($importedCount === 0) {
                return redirect()
                    ->route('news.index')
                    ->with('error', 'Tidak ada data berita yang valid untuk diimpor. Pastikan kolom judul berita sudah terisi.');
            }

            return redirect()
                ->route('news.index')
                ->with('success', "Proses impor selesai! Sebanyak {$importedCount} data berita berhasil diimpor ke database.");
        } catch (\Exception $e) {
            return redirect()
                ->route('news.index')
                ->with('error', 'Terjadi kesalahan saat memproses file Excel: '.$e->getMessage());
        }
    }
}
