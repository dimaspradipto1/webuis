@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Arah Sasaran Strategis Civitas Akademika Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam')

@push('styles')
<style>
  .visi-misi-img-box {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    transition: transform 0.28s ease, box-shadow 0.28s ease;
    background-color: transparent;
  }
  .visi-misi-img-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(2, 56, 20, 0.18);
  }
  .visi-misi-img-box img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 14px;
  }

  /* Perbaikan Z-Index Modal Lightbox agar tidak tertutup backdrop & selalu bisa diklik */
  #modalVisiMisiViewer {
    z-index: 99999 !important;
  }
  .modal-backdrop.show {
    z-index: 99990 !important;
    opacity: 0.75 !important;
  }
  #modalVisiMisiViewer .modal-dialog {
    z-index: 100000 !important;
    pointer-events: auto !important;
  }
  .btn-close-lightbox {
    position: absolute;
    top: -16px;
    right: -10px;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #ffffff;
    color: #111827;
    border: 2px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 6px 18px rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    z-index: 100010 !important;
    transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
  }
  .btn-close-lightbox:hover {
    transform: scale(1.12);
    background-color: #fee2e2;
    color: #dc2626;
  }
  @media (max-width: 768px) {
    .btn-close-lightbox {
      top: 2px;
      right: 2px;
      width: 38px;
      height: 38px;
      font-size: 16px;
    }
  }
</style>
@endpush

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'visi-misi',
    'heroClass' => 'visimisi-hero'
])

<!-- ═══════════════════════════════════════════════
     VISI & MISI IMAGES (3 COLUMNS - ONLY IMAGES)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-2">
    {{-- Grid 3 Kolom - Hanya Gambar Fullwidth Tanpa Card/Title/Description --}}
    <div class="row g-4 justify-content-center">
      @if(isset($visiMisiGambar) && $visiMisiGambar->isNotEmpty())
        @foreach($visiMisiGambar as $index => $item)
          <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ ($index % 3 + 1) * 100 }}">
            <div class="visi-misi-img-box" onclick="showVisiMisiModal('{{ $item->gambar_url }}')" title="Klik untuk memperbesar gambar">
              <img src="{{ $item->gambar_url }}"
                   alt="Visi Misi Universitas Ibnu Sina"
                   class="img-fluid w-100"
                   loading="lazy">
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center py-4">
          <div class="alert alert-light border border-success-subtle p-4 d-inline-block text-center shadow-sm" style="max-width: 600px; border-radius: 12px;">
            <i class="bi bi-images text-success fs-1 d-block mb-2"></i>
            <h5 class="fw-bold text-dark mb-1">Gambar Visi & Misi Sedang Dipersiapkan</h5>
            <p class="text-muted small mb-0">
              Silakan unggah gambar Visi, Misi, dan Tata Nilai melalui menu <strong>Profil > Visi & Misi</strong> di dashboard admin.
            </p>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>

{{-- Modal Popup Ukuran Penuh (Dipindahkan ke <body> via JS untuk mencegah bug stacking context) --}}
<div class="modal fade" id="modalVisiMisiViewer" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down p-2 p-md-4">
    <div class="modal-content border-0 bg-transparent shadow-none position-relative">
      {{-- Tombol Close X Sangat Jelas & Selalu Bisa Diklik --}}
      <button type="button"
              class="btn-close-lightbox"
              data-bs-dismiss="modal"
              aria-label="Tutup"
              title="Tutup (Esc)">
        <i class="bi bi-x-lg"></i>
      </button>

      <div class="text-center w-100 p-2">
        <img id="modalVisiMisiImage"
             src=""
             alt="Visi Misi Penuh"
             class="img-fluid rounded-3 shadow-lg"
             style="max-height: 90vh; width: auto; max-width: 100%; object-fit: contain; cursor: pointer;"
             data-bs-dismiss="modal"
             title="Klik gambar untuk menutup">
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('modalVisiMisiViewer');
    // Pindahkan modal langsung ke <body> agar terbebas dari stacking context parent / filter / transform
    if (modalEl && modalEl.parentNode !== document.body) {
      document.body.appendChild(modalEl);
    }

    if (modalEl) {
      // Klik di luar gambar / pada background langsung menutup modal
      modalEl.addEventListener('click', function (e) {
        if (e.target === modalEl) {
          const instance = bootstrap.Modal.getInstance(modalEl);
          if (instance) instance.hide();
        }
      });
    }
  });

  function showVisiMisiModal(imgUrl) {
    const modalEl = document.getElementById('modalVisiMisiViewer');
    if (!modalEl) return;
    const modalImg = document.getElementById('modalVisiMisiImage');
    if (modalImg) modalImg.src = imgUrl;

    let instance = bootstrap.Modal.getInstance(modalEl);
    if (!instance) {
      instance = new bootstrap.Modal(modalEl, {
        backdrop: true,
        keyboard: true
      });
    }
    instance.show();
  }
</script>
@endpush
