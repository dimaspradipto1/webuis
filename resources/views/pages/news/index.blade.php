@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Post / Berita</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Post</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-newspaper me-2 text-primary"></i>Daftar Post / Berita
        </h5>
        <div class="d-flex flex-wrap align-items-center gap-2">
            {{-- Tombol Download Template Excel --}}
            <a href="{{ route('news.download-template') }}" class="btn btn-outline-secondary btn-sm" title="Download Template Format Excel Berita">
                <i class="bi bi-file-earmark-excel me-1 text-success"></i> Template Excel
            </a>

            {{-- Tombol Export Excel --}}
            <a href="{{ route('news.export-excel') }}" class="btn btn-outline-success btn-sm fw-semibold" title="Export Seluruh Data Berita ke Excel (.xlsx)">
                <i class="bi bi-file-earmark-arrow-down me-1"></i> Export Excel
            </a>

            {{-- Tombol Import Excel --}}
            <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                <i class="bi bi-file-earmark-arrow-up me-1"></i> Import Excel
            </button>

            {{-- Tombol Tambah Post / Berita --}}
            <a href="{{ route('news.create') }}" class="btn btn-primary btn-sm" style="background: var(--uis-purple); border-color: var(--uis-purple);">
                <i class="bi bi-plus-lg me-1"></i> Tambah Post
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>

{{-- Modal Import Excel --}}
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background: #046B26;">
                <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                    <i class="bi bi-file-earmark-excel me-2 text-warning"></i>Import Data Berita dari Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('news.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i>Petunjuk Impor Berita:</h6>
                        <ol class="small text-muted mb-2 ps-3">
                            <li>Unduh template Excel resmi terlebih dahulu agar format kolom sesuai.</li>
                            <li>Isi Judul, Kategori, Status (published/draft), Artikel Unggulan, Deskripsi Singkat, dan Konten Berita.</li>
                            <li><strong>Kolom Gambar / Thumbnail boleh dikosongkan.</strong> Gambar cover dapat diunggah kemudian melalui tombol edit berita.</li>
                            <li>Simpan dalam format <code>.xlsx</code>, <code>.xls</code>, atau <code>.csv</code> (Maks. 10MB).</li>
                        </ol>
                        <a href="{{ route('news.download-template') }}" class="btn btn-sm btn-outline-success fw-semibold">
                            <i class="bi bi-download me-1"></i> Download Format Template Excel (.xlsx)
                        </a>
                    </div>

                    <div class="mb-3">
                        <label for="file_excel" class="form-label fw-semibold text-dark">
                            Pilih File Excel / CSV Berita <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               name="file_excel"
                               id="file_excel"
                               class="form-control"
                               accept=".xlsx,.xls,.csv"
                               required>
                        <div class="form-text text-muted small">Mendukung file ekstensi .xlsx, .xls, atau .csv hingga ukuran 10 MB.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 text-white fw-semibold">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Mulai Impor Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        function confirmDeleteNews(e, btn) {
            if (e) e.preventDefault();
            const form = btn.closest('form');
            const title = btn.getAttribute('data-title') || 'berita ini';

            Swal.fire({
                title: 'Hapus Berita Ini?',
                text: 'Apakah Anda yakin ingin menghapus "' + title + '"? Berita dan file gambar terkait akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                    cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush
