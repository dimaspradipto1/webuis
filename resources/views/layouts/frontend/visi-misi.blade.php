@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Arah Sasaran Strategis Civitas Akademika Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam')

@push('styles')
<style>
  .visi-misi-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .visi-misi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(2, 56, 20, 0.12);
    border-color: #046B26;
  }
  .visi-misi-img-wrap {
    position: relative;
    width: 100%;
    background-color: #f8fafc;
    overflow: hidden;
    cursor: pointer;
  }
  .visi-misi-img-wrap img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
    transition: transform 0.4s ease;
  }
  .visi-misi-card:hover .visi-misi-img-wrap img {
    transform: scale(1.02);
  }
  .visi-misi-zoom-overlay {
    position: absolute;
    inset: 0;
    background: rgba(2, 56, 20, 0.4);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .visi-misi-img-wrap:hover .visi-misi-zoom-overlay {
    opacity: 1;
  }
  .visi-misi-zoom-btn {
    background: #ffffff;
    color: #046B26;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    transform: scale(0.85);
    transition: transform 0.3s ease;
  }
  .visi-misi-img-wrap:hover .visi-misi-zoom-btn {
    transform: scale(1);
  }
  .visi-misi-zoom-text {
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
  }
  .visi-misi-meta {
    padding: 16px 20px;
    background: #ffffff;
    border-top: 1px solid #f1f5f9;
  }
  .visi-misi-badge {
    background: #e8f5e9;
    color: #046B26;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-block;
    margin-bottom: 6px;
  }
</style>
@endpush

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="visimisi-hero">
  <div class="container">
    <div data-aos="fade-up">
      <h1 class="visimisi-hero-title">
        Visi & <em>Misi</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil</a>
        <span>/</span>
        <span class="active">Visi & Misi</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     VISI & MISI IMAGES (3 COLUMNS FULLWIDTH)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label">Arah & Landasan Institusi</div>
      <h2 class="section-title">Visi & Misi <em>Universitas Ibnu Sina</em></h2>
      <p class="section-desc mx-auto" style="max-width: 650px;">
        Komitmen fundamental yang mengarahkan setiap langkah Tri Dharma Perguruan Tinggi di Universitas Ibnu Sina.
      </p>
    </div>

    {{-- Grid 3 Kolom Fullwidth --}}
    <div class="row g-4 justify-content-center">
      @if(isset($visiMisiGambar) && $visiMisiGambar->isNotEmpty())
        @foreach($visiMisiGambar as $index => $item)
          <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ ($index % 3 + 1) * 100 }}">
            <div class="visi-misi-card">
              <div class="visi-misi-img-wrap"
                   onclick="showVisiMisiModal('{{ $item->gambar_url }}', '{{ addslashes($item->judul ?: 'Visi & Misi UIS') }}', '{{ addslashes($item->keterangan ?? '') }}')"
                   title="Klik untuk melihat ukuran penuh">
                <img src="{{ $item->gambar_url }}"
                     alt="{{ $item->judul ?: 'Visi & Misi Universitas Ibnu Sina' }}"
                     class="img-fluid w-100"
                     loading="lazy">
                <div class="visi-misi-zoom-overlay">
                  <div class="visi-misi-zoom-btn">
                    <i class="bi bi-arrows-fullscreen"></i>
                  </div>
                  <span class="visi-misi-zoom-text">Klik Ukuran Penuh</span>
                </div>
              </div>

              @if($item->judul || $item->keterangan)
                <div class="visi-misi-meta mt-auto">
                  @if($item->judul)
                    <div class="visi-misi-badge">{{ $item->judul }}</div>
                  @endif
                  @if($item->keterangan)
                    <p class="small text-muted mb-0" style="line-height: 1.5;">{{ $item->keterangan }}</p>
                  @endif
                </div>
              @endif
            </div>
          </div>
        @endforeach
      @else
        {{-- Jika belum ada upload gambar di admin, tampilkan placeholder 3 kolom informatif --}}
        <div class="col-12 text-center py-4">
          <div class="alert alert-light border border-success-subtle p-4 d-inline-block text-center shadow-sm" style="max-width: 600px; border-radius: 12px;">
            <i class="bi bi-images text-success fs-1 d-block mb-2"></i>
            <h5 class="fw-bold text-dark mb-1">Gambar Visi & Misi Sedang Dipersiapkan</h5>
            <p class="text-muted small mb-0">
              Silakan unggah gambar Visi, Misi, dan Sasaran Strategis melalui menu <strong>Profil > Visi & Misi</strong> di dashboard admin. Gambar akan otomatis tersusun rapi dalam 3 kolom full-width di sini.
            </p>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>

{{-- Modal Popup Ukuran Penuh (Lightbox) --}}
<div class="modal fade" id="modalVisiMisiViewer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #023814 0%, #046B26 100%); color: #ffffff;">
        <h6 class="modal-title fw-bold" id="modalVisiMisiTitle">Visi & Misi Universitas Ibnu Sina</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2 bg-dark text-center">
        <img id="modalVisiMisiImage" src="" alt="Visi Misi Penuh" class="img-fluid w-100" style="max-height: 85vh; object-fit: contain;">
      </div>
      <div class="modal-footer py-2 px-4 bg-light d-flex justify-content-between">
        <small class="text-muted" id="modalVisiMisiDesc"></small>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function showVisiMisiModal(imgUrl, title, desc) {
    const modalEl = document.getElementById('modalVisiMisiViewer');
    if (!modalEl) return;
    document.getElementById('modalVisiMisiImage').src = imgUrl;
    document.getElementById('modalVisiMisiTitle').textContent = title || 'Visi & Misi UIS';
    document.getElementById('modalVisiMisiDesc').textContent = desc || '';
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
</script>
@endpush
