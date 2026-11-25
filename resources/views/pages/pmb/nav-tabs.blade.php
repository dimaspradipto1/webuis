<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase" style="background: rgba(4, 107, 38, 0.1); color: #046B26; font-size: 11.5px;">
                <i class="bi bi-mortarboard-fill me-1"></i> Modul PMB Terpadu UIS
            </span>
            <span class="text-muted small">Pusat Pengaturan Informasi & Dokumen Penerimaan Mahasiswa Baru</span>
        </div>
        <a href="{{ route('homepage.informasi-pmb') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Halaman PMB Publik
        </a>
    </div>

    {{-- Submenu Tabs Nav --}}
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.pmb.index') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ Route::is('admin.pmb.index') || Route::is('admin.pmb.gelombang') || Route::is('admin.pmb.syarat') ? 'btn-success text-white shadow-sm' : 'btn-light text-dark' }}" style="{{ Route::is('admin.pmb.index') || Route::is('admin.pmb.gelombang') || Route::is('admin.pmb.syarat') ? 'background-color: #046B26; border-color: #046B26;' : '' }}">
            <i class="bi bi-info-circle-fill me-1"></i> Informasi PMB (Gelombang, Syarat & Beasiswa)
        </a>
        <a href="{{ route('admin.pmb.brosur') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ Route::is('admin.pmb.brosur') ? 'btn-success text-white shadow-sm' : 'btn-light text-dark' }}" style="{{ Route::is('admin.pmb.brosur') ? 'background-color: #046B26; border-color: #046B26;' : '' }}">
            <i class="bi bi-images me-1"></i> Brosur & Poster PMB
        </a>
        <a href="{{ route('admin.pmb.dokumen') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ Route::is('admin.pmb.dokumen') ? 'btn-success text-white shadow-sm' : 'btn-light text-dark' }}" style="{{ Route::is('admin.pmb.dokumen') ? 'background-color: #046B26; border-color: #046B26;' : '' }}">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Dokumen Panduan (PDF)
        </a>
        <a href="{{ route('admin.pmb.link-daftar') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ Route::is('admin.pmb.link-daftar') ? 'btn-success text-white shadow-sm' : 'btn-outline-success' }}" style="{{ Route::is('admin.pmb.link-daftar') ? 'background-color: #046B26; border-color: #046B26;' : 'border-color: #046B26; color: #046B26;' }}">
            <i class="bi bi-pencil-square me-1"></i> Daftar Online (Link PMB)
        </a>
    </div>
</div>
