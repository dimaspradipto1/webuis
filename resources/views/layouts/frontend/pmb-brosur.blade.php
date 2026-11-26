@extends('layouts.frontend.template')

@section('title', 'Galeri Brosur & Poster PMB — Universitas Ibnu Sina')
@section('meta_description', 'Galeri brosur promosi dan poster infografis resmi Penerimaan Mahasiswa Baru (PMB) Universitas Ibnu Sina serta seluruh fakultas. Unduh materi publikasi resolusi HD dan dokumen PDF gratis.')

@push('styles')
<style>
  .hero-clean-pmb {
    background: linear-gradient(135deg, #046B26 0%, #024719 100%);
    padding: 48px 0 36px 0;
    position: relative;
    border-bottom: 3px solid #FED802;
  }
  .breadcrumb-clean {
    font-size: 13px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
  }
  .breadcrumb-clean a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: color 0.2s ease;
  }
  .breadcrumb-clean a:hover {
    color: #FED802;
  }
  .breadcrumb-clean span.separator {
    color: rgba(255, 255, 255, 0.45);
  }
  .breadcrumb-clean span.active {
    color: #FED802;
    font-weight: 700;
  }

  /* Filter Tabs */
  .filter-brosur-pill {
    background: #ffffff;
    color: #374151;
    border: 1.5px solid #e5e7eb;
    border-radius: 50px;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }
  .filter-brosur-pill:hover {
    background: #f0fdf4;
    border-color: #046B26;
    color: #046B26;
  }
  .filter-brosur-pill.active {
    background: #046B26 !important;
    border-color: #046B26 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25);
  }
  .filter-brosur-pill .badge {
    font-size: 11px;
    padding: 3px 7px;
  }

  /* Gallery Card - Borderless & Modern Showcase */
  .gallery-brosur-card {
    background: #ffffff;
    border-radius: 18px;
    border: none !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
  }
  .gallery-brosur-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(4, 107, 38, 0.15);
  }

  /* Image Wrapper - Full Width Edge-to-Edge with A4 Ratio */
  .gallery-img-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1.414; /* Rasio A4 Standar Brosur PMB */
    overflow: hidden;
    cursor: pointer;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.4s ease;
  }
  .gallery-brosur-card:hover .gallery-img-wrapper img {
    transform: scale(1.03);
  }

  /* Floating Badges on Top of Image */
  .floating-badge-fakultas {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 5;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    letter-spacing: 0.2px;
    border: 1px solid rgba(255, 255, 255, 0.25);
  }
  .floating-badge-ta {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 5;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 10.5px;
    font-weight: 600;
    background: rgba(15, 23, 42, 0.72);
    color: #ffffff;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  /* Overlay on Hover */
  .gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(4, 107, 38, 0.65) 0%, rgba(0,0,0,0.05) 50%, rgba(0,0,0,0.35) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s ease;
    z-index: 4;
  }
  .gallery-brosur-card:hover .gallery-overlay {
    opacity: 1;
  }
  .gallery-overlay-badge {
    background: rgba(0, 0, 0, 0.85);
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    backdrop-filter: blur(6px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.35);
    border: 1px solid rgba(255, 255, 255, 0.25);
    transform: translateY(8px);
    transition: transform 0.25s ease;
  }
  .gallery-brosur-card:hover .gallery-overlay-badge {
    transform: translateY(0);
  }

  .gallery-card-body {
    padding: 14px 16px 4px 16px;
    background: #ffffff;
  }
  .gallery-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 4px;
    transition: color 0.2s ease;
  }
  .gallery-brosur-card:hover .gallery-card-title {
    color: #046B26;
  }
  .gallery-card-desc {
    color: #64748b;
    font-size: 11.5px;
    line-height: 1.5;
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .gallery-card-footer {
    padding: 8px 16px 16px 16px;
    background: #ffffff;
  }

  .btn-download-action {
    background: linear-gradient(135deg, #046B26 0%, #024719 100%);
    color: #ffffff !important;
    font-weight: 700;
    border-radius: 10px;
    padding: 9px 12px;
    font-size: 12px;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 3px 8px rgba(4, 107, 38, 0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
  }
  .btn-download-action:hover {
    background: linear-gradient(135deg, #03531e 0%, #012d10 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(4, 107, 38, 0.3);
  }
  .btn-pdf-action {
    background: #fef2f2;
    color: #dc2626 !important;
    border: 1.5px solid #fca5a5;
    font-weight: 700;
    border-radius: 10px;
    padding: 8px 11px;
    font-size: 11.5px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    text-decoration: none;
  }
  .btn-pdf-action:hover {
    background: #dc2626;
    color: #ffffff !important;
    border-color: #dc2626;
    transform: translateY(-2px);
  }
  .btn-preview-action {
    background: #ffffff;
    color: #046B26 !important;
    border: 1.5px solid #046B26;
    font-weight: 700;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12.5px;
    transition: all 0.2s ease;
  }
  .btn-preview-action:hover {
    background: #f0fdf4;
    transform: translateY(-2px);
  }
</style>
@endpush

@section('content')

@php
  $cleanWa = $pmb->clean_wa ?? '6282283958644';
  $pmbPortalUrl = ($pmb?->link_pendaftaran) ?: ($pmbSetting->tombol_link_1 ?? 'https://pmb.uis.ac.id');
  if (!str_starts_with($pmbPortalUrl, 'http://') && !str_starts_with($pmbPortalUrl, 'https://')) {
      $pmbPortalUrl = 'https://' . $pmbPortalUrl;
  }
@endphp

<!-- ══════════════════════════════════════════════════════
     1. HERO HEADER BERSIH
     ══════════════════════════════════════════════════════ -->
<header class="hero-clean-pmb">
  <div class="container">
    <div class="breadcrumb-clean">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span class="separator">/</span>
      <a href="{{ route('homepage.informasi-pmb') }}">Admisi & PMB</a>
      <span class="separator">/</span>
      <span class="active">Galeri Brosur & Poster</span>
    </div>

    <div class="row align-items-center g-4">
      <div class="col-12">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 fw-bold" style="background: rgba(254, 216, 2, 0.2); border: 1px solid #FED802; color: #FED802; font-size: 12px;">
          <i class="bi bi-images"></i> Galeri Media Visual & Informasi PMB
        </div>
        <h1 class="fw-bold mb-2 text-white" style="font-size: clamp(24px, 3.2vw, 34px); letter-spacing: -0.3px;">
          Galeri Brosur & Poster PMB Seluruh Fakultas
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 14.5px; max-width: 840px; line-height: 1.6;">
          Eksplorasi kumpulan brosur dan infografis resmi Penerimaan Mahasiswa Baru Universitas Ibnu Sina serta seluruh fakultas. Anda dapat memfilter berdasarkan fakultas, melihat pratinjau, dan mengunduh gambar resolusi tinggi (HD) secara gratis.
        </p>
      </div>
    </div>
  </div>
</header>

<!-- ══════════════════════════════════════════════════════
     2. CONTENT GALERI BROSUR SEMUA FAKULTAS
     ══════════════════════════════════════════════════════ -->
<main class="py-5" style="background-color: #f8fafc; min-height: 70vh;">
  <div class="container">

    @if($brosurs->isEmpty())
      {{-- Placeholder jika belum ada brosur di database --}}
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
          <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
            <div class="rounded-circle mx-auto p-4 mb-3 d-flex align-items-center justify-content-center text-success" style="background-color: #eef7f0; width: 90px; height: 90px;">
              <i class="bi bi-images fs-1 text-success"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Galeri Brosur PMB Sedang Dipersiapkan</h4>
            <p class="text-muted small mx-auto mb-4" style="max-width: 540px; line-height: 1.7;">
              Materi brosur dan poster infografis PMB untuk universitas dan tiap fakultas sedang dalam proses pembaharuan materi visual oleh tim Humas dan Panitia PMB UIS.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
              <a href="{{ route('homepage.pmb-panduan') }}" class="btn btn-download-action">
                <i class="bi bi-file-earmark-pdf me-1"></i> Buka Dokumen Panduan PDF
              </a>
              <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Panitia%20PMB%20UIS,%20saya%20ingin%20meminta%20brosur%20pendaftaran%20terbaru" target="_blank" class="btn btn-preview-action">
                <i class="bi bi-whatsapp text-success me-1"></i> Minta Brosur via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    @else
      {{-- FILTER TABS BERDASARKAN FAKULTAS / KATEGORI --}}
      <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-4 pb-2" id="brosurFilterContainer">
        <button type="button" class="filter-brosur-pill active" data-filter="all">
          <i class="bi bi-grid-fill"></i>
          <span>Semua Brosur</span>
          <span class="badge bg-light text-dark rounded-pill ms-1">{{ $brosurs->count() }}</span>
        </button>

        @foreach($categories as $cat)
          @php
            $countCat = $brosurs->where('kategori_fakultas', $cat)->count();
            $slugCat = \Illuminate\Support\Str::slug($cat);
          @endphp
          <button type="button" class="filter-brosur-pill" data-filter="{{ $slugCat }}">
            <span>{{ $cat }}</span>
            <span class="badge bg-light text-muted rounded-pill ms-1">{{ $countCat }}</span>
          </button>
        @endforeach
      </div>

      {{-- GRID GALERI POSTER & BROSUR (Borderless & Full Poster View) --}}
      <div class="row g-3 g-md-4 mb-5" id="galleryBrosurGrid">
        @foreach($brosurs as $b)
          @php
            $slugCat = \Illuminate\Support\Str::slug($b->kategori_fakultas ?: 'universitas');
            $badgeBg = match ($b->kategori_fakultas) {
                'Fakultas Sains dan Teknologi' => 'background: rgba(13, 110, 253, 0.92); color: #ffffff;',
                'Fakultas Ekonomi dan Bisnis' => 'background: rgba(2, 132, 199, 0.92); color: #ffffff;',
                'Fakultas Ilmu Kesehatan' => 'background: rgba(220, 38, 38, 0.92); color: #ffffff;',
                'Program Pascasarjana' => 'background: rgba(124, 58, 237, 0.92); color: #ffffff;',
                default => 'background: rgba(4, 107, 38, 0.92); color: #ffffff;',
            };
          @endphp
          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 gallery-item" data-category="{{ $slugCat }}">
            <div class="gallery-brosur-card">
              <div>
                {{-- Gambar Cover Brosur (Tampil Full Tanpa Border Box) --}}
                <div class="gallery-img-wrapper btn-trigger-lightbox" 
                     data-title="{{ $b->judul }}" 
                     data-kategori="{{ $b->kategori_fakultas }}" 
                     data-img="{{ $b->gambar_url }}" 
                     data-download="{{ route('homepage.pmb-brosur.download', $b->id) }}"
                     data-pdf="{{ $b->file_pdf ? route('homepage.pmb-brosur.download-pdf', $b->id) : '' }}"
                     title="Klik untuk melihat poster & zoom in">
                  
                  {{-- Floating Badge Kategori & TA --}}
                  <span class="floating-badge-fakultas" style="{{ $badgeBg }}">
                    <i class="bi bi-bookmark-fill me-1"></i> {{ $b->kategori_badge ?? ($b->kategori_fakultas ?: 'Universitas') }}
                  </span>
                  @if($b->tahun_akademik)
                    <span class="floating-badge-ta">
                      TA {{ $b->tahun_akademik }}
                    </span>
                  @endif

                  <img src="{{ $b->gambar_url }}" alt="{{ $b->judul }}" loading="lazy">
                  
                  <div class="gallery-overlay">
                    <span class="gallery-overlay-badge">
                      <i class="bi bi-arrows-angle-expand me-1"></i> Zoom In / Pratinjau
                    </span>
                  </div>
                </div>

                {{-- Deskripsi & Judul Brosur --}}
                <div class="gallery-card-body">
                  <h6 class="gallery-card-title text-truncate" title="{{ $b->judul }}">
                    {{ $b->judul }}
                  </h6>
                  @if(!empty($b->deskripsi))
                    <p class="gallery-card-desc">
                      {{ $b->deskripsi }}
                    </p>
                  @endif
                </div>
              </div>

              {{-- Tombol Aksi di Bawah Card (Download Menggunakan Nama Asli) --}}
              <div class="gallery-card-footer">
                <div class="d-flex align-items-center gap-2">
                  <a href="{{ route('homepage.pmb-brosur.download', $b->id) }}" class="btn-download-action flex-fill" title="Unduh Poster Resolusi Asli">
                    <i class="bi bi-download"></i> Unduh Poster
                  </a>

                  @if($b->file_pdf)
                    <a href="{{ route('homepage.pmb-brosur.download-pdf', $b->id) }}" class="btn-pdf-action" title="Unduh File Dokumen PDF Resmi">
                      <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                    </a>
                  @endif

                  <button type="button" class="btn-preview-action btn-trigger-lightbox" 
                          data-title="{{ $b->judul }}" 
                          data-kategori="{{ $b->kategori_fakultas }}" 
                          data-img="{{ $b->gambar_url }}" 
                          data-download="{{ route('homepage.pmb-brosur.download', $b->id) }}"
                          data-pdf="{{ $b->file_pdf ? route('homepage.pmb-brosur.download-pdf', $b->id) : '' }}" 
                          title="Zoom In & Pratinjau Layar Penuh">
                    <i class="bi bi-zoom-in"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif



    {{-- Banner CTA Pendaftaran Online --}}
    <div class="p-4 p-md-5 rounded-4 shadow-sm text-white text-center mt-4" style="background: linear-gradient(135deg, #046B26 0%, #023814 100%); border: 2px solid #FED802;">
      <span class="badge rounded-pill px-3 py-1 fw-bold mb-2 text-dark" style="background-color: #FED802; font-size: 11px;">
        Pendaftaran Daring
      </span>
      <h3 class="fw-bold mb-2 text-white">Daftar Sekarang Sebagai Mahasiswa Baru UIS</h3>
      <p class="text-white-50 small mx-auto mb-4" style="max-width: 620px; line-height: 1.7;">
        Proses pendaftaran cepat, transparan, dan dapat diakses dari mana saja melalui portal resmi PMB online Universitas Ibnu Sina.
      </p>
      <div class="d-flex flex-wrap justify-content-center gap-2">
        <a href="{{ $pmbPortalUrl }}" target="_blank" rel="noopener noreferrer" class="btn fw-bold px-4 py-2.5 rounded-pill shadow" style="background-color: #FED802; color: #111827;">
          <i class="bi bi-pencil-square me-1"></i> Daftar PMB Online Sekarang <i class="bi bi-box-arrow-up-right ms-1 small"></i>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20PMB%20UIS,%20saya%20ingin%20berkonsultasi%20pendaftaran" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-semibold">
          <i class="bi bi-whatsapp me-1 text-success"></i> Tanya Admin
        </a>
      </div>
    </div>

  </div>
</main>

{{-- MODAL LIGHTBOX / ZOOM POSTER BROSUR INTERAKTIF --}}
<div class="modal fade" id="modalLightboxBrosur" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 overflow-hidden shadow-2xl bg-dark text-white">
      {{-- Header dengan Toolbar Zoom --}}
      <div class="modal-header bg-dark border-bottom border-secondary py-2.5 px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 overflow-hidden me-2" style="max-width: 50%;">
          <i class="bi bi-image text-warning fs-5 flex-shrink-0"></i>
          <div class="text-truncate">
            <h6 class="modal-title fw-bold small mb-0 text-white text-truncate" id="lightboxTitle">Judul Brosur</h6>
            <span class="text-white-50" style="font-size: 11px;" id="lightboxKategori">Universitas</span>
          </div>
        </div>
        
        {{-- ZOOM CONTROLS TOOLBAR --}}
        <div class="d-flex align-items-center gap-1.5 flex-shrink-0 ms-auto">
          <button type="button" class="btn btn-sm btn-outline-light py-1 px-2.5 rounded-pill" id="btnZoomOut" title="Perkecil Zoom (-)">
            <i class="bi bi-dash-lg"></i>
          </button>
          <span class="badge bg-secondary px-2.5 py-1 text-light font-monospace" id="zoomLevelBadge" style="font-size: 11px; min-width: 48px; border: 1px solid rgba(255,255,255,0.2);">100%</span>
          <button type="button" class="btn btn-sm btn-outline-light py-1 px-2.5 rounded-pill" id="btnZoomIn" title="Perbesar Zoom (+)">
            <i class="bi bi-plus-lg"></i>
          </button>
          <button type="button" class="btn btn-sm btn-outline-warning py-1 px-2.5 rounded-pill ms-1" id="btnZoomReset" title="Reset Ukuran (100%)">
            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
          </button>
          <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      
      {{-- MODAL BODY WITH INTERACTIVE SCROLL & ZOOM VIEWPORT --}}
      <div class="modal-body p-0 text-center position-relative" id="lightboxViewport" style="background: #0b111e; min-height: 420px; max-height: 74vh; overflow: auto; cursor: zoom-in;">
        <div id="zoomContainer" style="display: inline-block; min-width: 100%; padding: 20px 10px; transition: transform 0.2s cubic-bezier(0.2, 0, 0, 1); transform-origin: center top;">
          <img id="lightboxImg" src="" alt="Pratinjau Brosur" class="img-fluid rounded shadow-lg" style="max-height: 68vh; width: auto; object-fit: contain; pointer-events: auto;">
        </div>
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 px-3 py-1 rounded-pill text-white-50 small bg-dark bg-opacity-75" style="font-size: 11px; z-index: 10; pointer-events: none;">
          <i class="bi bi-info-circle me-1 text-warning"></i> Klik gambar untuk Zoom In / Out, atau gunakan tombol di atas
        </div>
      </div>

      {{-- Footer Modal --}}
      <div class="modal-footer bg-dark border-top border-secondary py-2 px-3 d-flex justify-content-between flex-wrap gap-2">
        <span class="text-white-50 small"><i class="bi bi-shield-check text-success me-1"></i> Materi Resmi Admisi & PMB UIS</span>
        <div class="d-flex align-items-center gap-2">
          <a id="lightboxNewTabBtn" href="#" target="_blank" class="btn btn-outline-light btn-sm px-3 rounded-pill fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Gambar Penuh
          </a>
          <a id="lightboxPdfBtn" href="#" target="_blank" class="btn btn-outline-danger btn-sm px-3 fw-bold rounded-pill" style="display: none;">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Buka PDF
          </a>
          <a id="lightboxDownloadBtn" href="#" download class="btn btn-success btn-sm px-4 fw-bold rounded-pill" style="background-color: #046B26;">
            <i class="bi bi-download me-1"></i> Unduh Poster (HD)
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. FILTER TABS BERDASARKAN FAKULTAS
  const filterBtns = document.querySelectorAll('.filter-brosur-pill');
  const galleryItems = document.querySelectorAll('.gallery-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const filterValue = this.getAttribute('data-filter');

      galleryItems.forEach(item => {
        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  // 2. LIGHTBOX MODAL & INTERACTIVE ZOOM
  const lightboxModalEl = document.getElementById('modalLightboxBrosur');
  // Pastikan modal berada langsung di body agar terhindar dari z-index/overflow clipping
  if (lightboxModalEl && lightboxModalEl.parentElement !== document.body) {
    document.body.appendChild(lightboxModalEl);
  }

  const lightboxModal = new bootstrap.Modal(lightboxModalEl);
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxTitle = document.getElementById('lightboxTitle');
  const lightboxKategori = document.getElementById('lightboxKategori');
  const lightboxDownloadBtn = document.getElementById('lightboxDownloadBtn');
  const lightboxNewTabBtn = document.getElementById('lightboxNewTabBtn');
  const lightboxPdfBtn = document.getElementById('lightboxPdfBtn');
  const lightboxViewport = document.getElementById('lightboxViewport');
  const zoomContainer = document.getElementById('zoomContainer');
  const zoomLevelBadge = document.getElementById('zoomLevelBadge');
  const btnZoomIn = document.getElementById('btnZoomIn');
  const btnZoomOut = document.getElementById('btnZoomOut');
  const btnZoomReset = document.getElementById('btnZoomReset');

  let currentZoom = 1.0;
  const minZoom = 0.6;
  const maxZoom = 3.0;
  const zoomStep = 0.25;

  function updateZoom(newZoom) {
    currentZoom = Math.min(Math.max(newZoom, minZoom), maxZoom);
    if (zoomContainer) {
      zoomContainer.style.transform = `scale(${currentZoom})`;
    }
    if (zoomLevelBadge) {
      zoomLevelBadge.textContent = Math.round(currentZoom * 100) + '%';
    }
    if (lightboxViewport) {
      lightboxViewport.style.cursor = currentZoom > 1.05 ? 'zoom-out' : 'zoom-in';
    }
  }

  if (btnZoomIn) {
    btnZoomIn.addEventListener('click', function (e) {
      e.stopPropagation();
      updateZoom(currentZoom + zoomStep);
    });
  }

  if (btnZoomOut) {
    btnZoomOut.addEventListener('click', function (e) {
      e.stopPropagation();
      updateZoom(currentZoom - zoomStep);
    });
  }

  if (btnZoomReset) {
    btnZoomReset.addEventListener('click', function (e) {
      e.stopPropagation();
      updateZoom(1.0);
    });
  }

  // Klik gambar poster untuk toggle zoom in / zoom out
  if (lightboxImg) {
    lightboxImg.addEventListener('click', function (e) {
      e.stopPropagation();
      if (currentZoom <= 1.05) {
        updateZoom(1.8);
      } else {
        updateZoom(1.0);
      }
    });
  }

  // Event listener tombol buka lightbox
  document.querySelectorAll('.btn-trigger-lightbox').forEach(el => {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      const title = this.getAttribute('data-title') || 'Brosur PMB UIS';
      const kategori = this.getAttribute('data-kategori') || 'Universitas';
      const imgSrc = this.getAttribute('data-img') || '';
      const downloadSrc = this.getAttribute('data-download') || imgSrc;
      const pdfSrc = this.getAttribute('data-pdf') || '';

      lightboxTitle.innerText = title;
      lightboxKategori.innerText = kategori;
      lightboxImg.src = imgSrc;
      lightboxDownloadBtn.href = downloadSrc;
      if (lightboxNewTabBtn) lightboxNewTabBtn.href = imgSrc;

      if (pdfSrc) {
        lightboxPdfBtn.href = pdfSrc;
        lightboxPdfBtn.style.display = 'inline-flex';
      } else {
        lightboxPdfBtn.style.display = 'none';
      }

      updateZoom(1.0);
      lightboxModal.show();
    });
  });

  // Reset zoom saat modal ditutup
  lightboxModalEl.addEventListener('hidden.bs.modal', function () {
    updateZoom(1.0);
  });
});
</script>
@endpush
