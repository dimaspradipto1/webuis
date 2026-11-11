@extends('layouts.frontend.template')

@section('title', ($setting->judul_hero ?? 'Pendampingan Acara') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Layanan pendampingan acara, protokoler resmi, dan konsultasi kegiatan kampus Universitas Ibnu Sina (UIS) Batam. Panduan SOP, perizinan, dan suksesi event.')
@section('meta_keywords', 'pendampingan acara uis, protokoler uis, sop acara uis batam, humas uis event, konsultasi protokol uis')

@section('content')
<style>
  /* ═══════════════════════════════════════════════
     STYLING PENDAMPINGAN ACARA (State-of-the-Art)
  ═══════════════════════════════════════════════ */
  .pendampingan-page {
    background-color: #f8fafc;
    color: #334155;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .divider-line-gold {
    width: 48px;
    height: 3px;
    background: #fab005;
    border-radius: 4px;
    margin: 10px auto 16px auto;
  }

  /* ── 1. Showcase Hero Box (Left Column) ── */
  .event-main-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    padding: 30px 32px;
    position: relative;
    overflow: hidden;
  }
  .event-main-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #046B26 0%, #fab005 100%);
  }

  .event-salutation-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #e8f5e9;
    color: #046B26;
    border: 1px solid #c8e6c9;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 14px;
  }

  .event-salutation-title {
    color: #0f172a;
    font-size: 24px;
    font-weight: 800;
    line-height: 1.35;
    letter-spacing: -0.4px;
    margin-bottom: 14px;
  }
  .event-salutation-title span {
    color: #046B26;
  }

  .event-desc-lead {
    color: #475569;
    font-size: 14.5px;
    line-height: 1.7;
    margin-bottom: 16px;
  }

  /* ── TinyMCE Rich Content Rendered Styling ── */
  .event-rendered-content {
    color: #475569;
    font-size: 14.5px;
    line-height: 1.7;
  }
  .event-rendered-content p {
    margin-bottom: 0.85rem;
    color: #475569;
    line-height: 1.7;
  }
  .event-rendered-content strong,
  .event-rendered-content b {
    color: #0f172a;
    font-weight: 700;
  }
  .event-rendered-content ul {
    list-style: none !important;
    padding-left: 0 !important;
    margin: 0.9rem 0 1rem 0 !important;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 10px;
  }
  .event-rendered-content ul li {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px 10px 42px;
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
    position: relative;
    line-height: 1.45;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
  }
  .event-rendered-content ul li::before {
    content: "\F26E";
    font-family: "bootstrap-icons";
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #046B26;
    font-size: 18px;
    font-weight: bold;
  }
  .event-rendered-content ul li:hover {
    background: #ffffff;
    border-color: #046B26;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.08);
  }
  .event-rendered-content ol {
    padding-left: 1.25rem;
    margin-bottom: 1rem;
  }
  .event-rendered-content ol li {
    margin-bottom: 0.4rem;
    color: #334155;
    font-weight: 500;
  }

  /* ── 2. Feature Assistance Grid (Fallback) ── */
  .assistance-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 11px 14px;
    display: flex;
    align-items: center;
    gap: 11px;
    transition: all 0.25s ease;
    height: 100%;
  }
  .assistance-item:hover {
    background: #ffffff;
    border-color: #046B26;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.08);
  }
  .assistance-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #046B26;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
  }
  .assistance-text {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.4;
  }

  /* ── 3. High-Impact CTA Box (Right Column) ── */
  .cta-showcase-box {
    background: linear-gradient(145deg, #064e3b 0%, #046B26 60%, #03521d 100%);
    border-radius: 18px;
    padding: 28px 24px;
    color: #ffffff;
    box-shadow: 0 16px 36px rgba(4, 107, 38, 0.22);
    position: relative;
    overflow: hidden;
    height: auto;
  }
  .cta-showcase-box::after {
    content: "";
    position: absolute;
    top: -50px;
    right: -50px;
    width: 140px;
    height: 140px;
    background: radial-gradient(circle, rgba(254, 216, 2, 0.2) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .cta-badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(8px);
    color: #fed802;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 11px;
    border-radius: 50px;
    margin-bottom: 12px;
  }

  .cta-heading {
    font-size: 20px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 8px;
  }
  .cta-desc {
    color: #e2e8f0;
    font-size: 13px;
    line-height: 1.55;
    margin-bottom: 16px;
    opacity: 0.95;
  }

  /* Action Buttons Group */
  .cta-btn-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 14px;
  }

  /* Main Action Button (Ajukan Permohonan) */
  .btn-ajukan-utama {
    background: #fed802;
    color: #046B26;
    font-weight: 800;
    font-size: 14px;
    padding: 12px 18px;
    border-radius: 11px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    border: 2px solid #fed802;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
  }
  .btn-ajukan-utama:hover {
    background: #ffffff;
    color: #046B26;
    border-color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  .cta-check-list {
    margin-top: 14px;
    padding: 14px 16px;
    background: rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
  }
  .cta-check-item {
    font-size: 12.5px;
    color: #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    font-weight: 500;
  }
  .cta-check-item:last-child {
    margin-bottom: 0;
  }
  .cta-check-item i {
    color: #fed802;
    font-size: 15px;
  }

  /* Quick Contact / Hotline Box inside CTA */
  .cta-hotline-box {
    margin-top: 12px;
    padding: 12px 16px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
  }
  .cta-hotline-item a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  .cta-hotline-item a:hover {
    color: #fed802;
    text-decoration: underline;
  }
</style>

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="faq-hero">
  <div class="container">
    <div class="faq-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="faq-hero-title">
        {{ $setting->judul_hero ?? 'Pendampingan Acara' }} <em>(Humas)</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.humas') }}">Humas</a>
        <span>/</span>
        <span class="active">{{ $setting->judul_hero ?? ($item->nama ?? 'Pendampingan Acara') }}</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     KONTEN UTAMA PENDAMPINGAN ACARA
═══════════════════════════════════════════════ -->
<div class="pendampingan-page py-4">
  <div class="container py-2">

    {{-- Header Judul Seksi Utama --}}
    <div class="text-center mb-4" data-aos="fade-up">
      <div class="section-label mx-auto mb-2">
        {{ strtoupper($item->badge_text ?? 'Protokoler') }} & SUKSESI KEGIATAN KAMPUS
      </div>
      
      <h2 class="fw-bold mb-0" style="color: #0f172a; font-size: 30px; letter-spacing: -0.5px;">
        {{ $setting->judul_seksi ?? ($item->nama ?? 'Pendampingan Acara') }}
      </h2>
      
      <div class="divider-line-gold"></div>

      <p class="text-muted mx-auto mb-0" style="max-width: 760px; font-size: 14.5px; line-height: 1.65;">
        {!! !empty($item->deskripsi) ? strip_tags($item->deskripsi) : 'Layanan konsultasi protokoler, perancangan tata letak acara, penyusunan rundown, serta pendampingan langsung oleh Tim Humas & Protokoler Universitas Ibnu Sina (UIS).' !!}
      </p>
    </div>

    {{-- SECTION 1: MAIN SHOWCASE (Row 2 Kolom) --}}
    <div class="row g-4 align-items-start mb-2">
      
      {{-- Kolom Kiri: Informasi Layanan & Lingkup Bantuan --}}
      <div class="col-lg-8 col-12" data-aos="fade-up" data-aos-delay="100">
        <div class="event-main-card">
          
          <div class="event-salutation-badge">
            <i class="bi {{ $item->icon ?? 'bi-people-fill' }} text-success"></i>
            <span>{{ !empty($item->badge_text) ? 'Layanan ' . $item->badge_text . ' Humas UIS' : 'Layanan Resmi Biro Humas UIS' }}</span>
          </div>

          <h3 class="event-salutation-title">
            {{ $setting->sapaan ?? 'Halo, Civitas Akademika Universitas Ibnu Sina dan Mitra Eksternal!' }}
          </h3>

          @if(!empty($setting->konten))
            <div class="event-rendered-content">
              {!! $setting->konten !!}
            </div>
          @else
            <p class="event-desc-lead">
              {!! nl2br(e(trim(html_entity_decode(strip_tags($setting->paragraf_1 ?? 'Kami hadir untuk mendukung kesuksesan acara dan kegiatan Anda melalui layanan konsultasi yang profesional, terstruktur, dan sesuai dengan Standar Operasional Prosedur (SOP) Universitas Ibnu Sina.'), ENT_QUOTES | ENT_HTML5, 'UTF-8')))) !!}
            </p>

            <p class="fw-bold text-dark mb-3" style="font-size: 15px;">
              {!! nl2br(e(trim(html_entity_decode(strip_tags($setting->paragraf_2 ?? 'Apakah Anda sedang merencanakan seminar, workshop, kegiatan sosial, atau event lainnya? Tim kami siap membantu dalam hal:'), ENT_QUOTES | ENT_HTML5, 'UTF-8')))) !!}
            </p>

            {{-- Grid Poin Lingkup Bantuan (Visual Cards) --}}
            @php
              $rawPoints = $setting->poin_bantuan ?? "Perencanaan dan konsep acara,\nStrategi promosi dan publikasi,\nPengelolaan logistik,\nPengurusan SOP dan perizinan, serta\nPendampingan selama pelaksanaan acara.";
              $pointsArray = array_filter(array_map('trim', explode("\n", $rawPoints)));
              
              // Icon visual default untuk tiap poin
              $pointIcons = [
                'bi-lightbulb-fill',
                'bi-megaphone-fill',
                'bi-box-seam-fill',
                'bi-shield-check',
                'bi-person-check-fill',
                'bi-camera-video-fill',
              ];
            @endphp

            <div class="row g-3 mb-4">
              @foreach($pointsArray as $idx => $point)
                <div class="col-md-6 col-12">
                  <div class="assistance-item">
                    <div class="assistance-icon-wrap">
                      <i class="bi {{ $pointIcons[$idx % count($pointIcons)] }}"></i>
                    </div>
                    <div class="assistance-text">
                      {{ ltrim($point, '-• ') }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <p class="text-muted small mb-0 pt-2" style="line-height: 1.7;">
              {!! $setting->paragraf_3 ?? 'Untuk memulai, silakan isi formulir konsultasi melalui tombol <strong>“Ajukan Permohonan”</strong> di panel samping.' !!}
            </p>
          @endif

        </div>
      </div>

      {{-- Kolom Kanan: High-Impact Action Showcase Card --}}
      <div class="col-lg-4 col-12" data-aos="fade-up" data-aos-delay="200">
        <div class="cta-showcase-box">
          
          <div>
            <div class="cta-badge-tag">
              <i class="bi {{ $item->icon ?? 'bi-people-fill' }}"></i> {{ !empty($item->badge_text) ? 'Layanan ' . $item->badge_text : 'Layanan Terintegrasi' }}
            </div>

            <h4 class="cta-heading">
              Siap Menggelar Acara Berkualitas?
            </h4>

            <p class="cta-desc">
              {!! !empty($item->deskripsi) ? strip_tags($item->deskripsi) : 'Kirimkan draf permohonan Anda. Tim Protokoler & Humas UIS siap mendampingi mulai dari pra-acara hingga evaluasi kegiatan.' !!}
            </p>

            @php
              $targetForm = trim($setting->link_form ?? ($item->url ?? ''));
              if (!empty($targetForm) && !str_starts_with($targetForm, 'http://') && !str_starts_with($targetForm, 'https://') && !str_starts_with($targetForm, '/') && !str_starts_with($targetForm, '#')) {
                  $targetForm = 'https://' . $targetForm;
              }
            @endphp
            
            <div class="cta-btn-group">
              <a href="{{ !empty($targetForm) ? $targetForm : 'javascript:void(0)' }}" 
                 @if(!empty($targetForm)) target="_blank" rel="noopener noreferrer" @endif
                 class="btn-ajukan-utama">
                <span>{{ $setting->tombol_teks ?? 'Ajukan Permohonan' }}</span>
                <i class="bi bi-arrow-right-circle-fill fs-5"></i>
              </a>
            </div>
          </div>

          <div class="cta-check-list">
            <div class="cta-check-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Respon cepat 1x24 jam kerja</span>
            </div>
            <div class="cta-check-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Standar Protokol Resmi Institusi</span>
            </div>
            <div class="cta-check-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Dukungan Media & Publikasi Humas</span>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>
@endsection
