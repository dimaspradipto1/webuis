@extends('layouts.frontend.template')

@section('title', 'Template Dokumen — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Pusat template dokumen resmi Universitas Ibnu Sina (UIS) Batam. Download templat PowerPoint (.pptx), Word (.docx), Desain (.psd) via Google Drive.')
@section('meta_keywords', 'template dokumen uis, templat pptx uis, templat docx uis, standar komunikasi merek uis')

@section('content')
<style>
  /* ═══════════════════════════════════════════════
     STYLING TEMPLATE DOKUMEN (Matching Reference)
  ═══════════════════════════════════════════════ */
  .template-doc-section {
    background-color: #ffffff;
    padding: 60px 0 80px 0;
  }

  .template-card-link {
    display: block;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .template-icon-card {
    background-color: #ebf3ee;
    border: 1px solid #d8ebd9;
    border-radius: 12px;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
  }

  /* Decorative Wavy Cloud Header on Top of the Card */
  .template-card-cloud {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 48px;
    pointer-events: none;
    z-index: 1;
    opacity: 0.65;
  }

  .template-card-link:hover .template-icon-card {
    transform: translateY(-8px);
    background-color: #fffef2;
    border-color: #f59e0b;
    box-shadow: 0 16px 36px rgba(245, 158, 11, 0.22), 0 0 0 1.5px #f59e0b !important;
  }

  .template-svg-wrap {
    position: relative;
    z-index: 2;
    transition: transform 0.35s ease;
    filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.06));
  }

  .template-card-link:hover .template-svg-wrap {
    transform: scale(1.06);
  }

  .template-card-title {
    font-weight: 700;
    color: #236838;
    font-size: 17px;
    margin-top: 15px;
    text-align: center;
    letter-spacing: -0.2px;
    transition: all 0.25s ease;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .template-card-link:hover .template-card-title {
    color: #d97706;
    text-decoration: underline;
    text-decoration-color: #f59e0b;
    text-underline-offset: 5px;
    text-decoration-thickness: 2px;
  }

  /* Yellow Divider Line matching FAQ Section */
  .divider-line-gold {
    width: 60px;
    height: 4px;
    background: #fab005;
    border-radius: 4px;
    margin: 14px auto 22px auto;
  }
</style>

<!-- ═══════════════════════════════════════════════
     HERO BANNER (Persis Banner FAQ di Image 1)
═══════════════════════════════════════════════ -->
<div class="faq-hero">
  <div class="container">
    <div class="faq-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="faq-hero-title">
        Template Dokumen <em>(UIS)</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.humas') }}">Humas</a>
        <span>/</span>
        <span class="active">Template Dokumen</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     TEMPLATE DOKUMEN SECTION (Persis di Image 1 & 2)
═══════════════════════════════════════════════ -->
<section class="template-doc-section">
  <div class="container text-center">
    
    {{-- Header Judul Seksi (Pusat Bantuan & Standar Dokumen) --}}
    <div class="mb-5" data-aos="fade-up">
      <div class="section-label mx-auto mb-3">
        PUSAT BANTUAN & INFORMASI
      </div>
      
      <h2 class="fw-bold mb-0" style="color: #1e3a29; font-size: 32px; letter-spacing: 0.5px; font-family: 'Plus Jakarta Sans', sans-serif;">
        {{ $setting->judul_seksi ?? 'TEMPLATE DOKUMEN' }}
      </h2>
      
      <div class="divider-line-gold"></div>

      <p class="text-muted mx-auto mb-0" style="max-width: 860px; font-size: 15px; line-height: 1.75;">
        {!! nl2br(e(trim(html_entity_decode(strip_tags($setting->deskripsi_seksi ?? 'Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word dan berbagai format lainnya. Guna menyeragamkan tampilan desain di lingkungan Universitas Ibnu Sina. Berdasarkan Peraturan Rektor tentang STANDAR KOMUNIKASI MEREK UNIVERSITAS IBNU SINA'), ENT_QUOTES | ENT_HTML5, 'UTF-8')))) !!}
      </p>
    </div>

    {{-- Grid 3 Kartu Template Dokumen (Persis Image 2) --}}
    <div class="row g-4 justify-content-center">
      @forelse($templates as $index => $item)
        <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ (($index % 3) + 1) * 100 }}">
          <a href="{{ $item->link_drive }}" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="template-card-link"
             title="Buka & Download {{ $item->judul }} di Google Drive">
            
            {{-- Kotak Ikon Hijau Lembut dengan Aksen Gelombang Awan di Atas --}}
            <div class="template-icon-card">
              <div class="template-card-cloud">
                <svg viewBox="0 0 350 48" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                  <path d="M0 48 Q 25 15, 60 38 Q 95 10, 135 32 Q 175 8, 220 30 Q 260 12, 295 36 Q 325 18, 350 48 L 350 0 L 0 0 Z" fill="#ffffff" opacity="0.6"/>
                  <path d="M0 40 Q 35 8, 85 30 Q 135 4, 185 24 Q 235 6, 285 26 Q 325 10, 350 40 L 350 0 L 0 0 Z" fill="#ffffff" opacity="0.4"/>
                </svg>
              </div>

              {{-- Ikon Presisi Sesuai Image 2 --}}
              <div class="template-svg-wrap">
                {!! $item->icon_html !!}
              </div>
            </div>

            {{-- Label Judul di Bawah Kotak --}}
            <div class="template-card-title">
              {{ $item->judul }}
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 py-5 text-center text-muted">
          <i class="bi bi-file-earmark-text fs-1 d-block mb-2 text-muted"></i>
          Belum ada template dokumen yang dipublikasikan saat ini.
        </div>
      @endforelse
    </div>

  </div>
</section>
@endsection
