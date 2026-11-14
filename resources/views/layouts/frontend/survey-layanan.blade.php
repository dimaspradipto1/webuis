@extends('layouts.frontend.template')

@section('title', ($setting->judul_hero ?? 'Survey Layanan') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Kuesioner evaluasi dan survei kepuasan layanan Biro Humas & Informasi Universitas Ibnu Sina (UIS) Batam.')
@section('meta_keywords', 'survei layanan uis, survei kepuasan humas uis, kuesioner evaluasi uis batam')

@section('content')
<style>
  /* ═══════════════════════════════════════════════
     STYLING SURVEY LAYANAN (Presisi & Elegan)
  ═══════════════════════════════════════════════ */
  .survey-page {
    background-color: #f1f5f9;
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

  /* ── Section Title ── */
  .survey-heading-main {
    color: #1b5e20;
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin-bottom: 24px;
    text-align: center;
  }

  /* ── Kartu Survei Item Sesuai Screenshot User & Konsep Hover Gold ── */
  .survey-card-box {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 26px 26px 24px 26px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
  }

  /* Efek Hover: Berubah menjadi Kuning Emas (#FED802) seperti di Screenshot */
  .survey-card-box:hover {
    background: #FED802 !important;
    border-color: #FED802 !important;
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(254, 216, 2, 0.42), 0 6px 14px rgba(0, 0, 0, 0.06);
  }

  .survey-card-title {
    color: #1b5e20;
    font-size: 18px;
    font-weight: 800;
    line-height: 1.4;
    margin-bottom: 22px;
    letter-spacing: -0.2px;
    transition: color 0.3s ease;
  }

  .survey-card-box:hover .survey-card-title {
    color: #043615 !important;
    font-weight: 850;
  }

  /* ── Tombol Isi Survei ── */
  .btn-survey-action {
    background-color: #046B26;
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 750;
    padding: 9px 22px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1.5px solid #046B26;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: fit-content;
    box-shadow: 0 4px 10px rgba(4, 107, 38, 0.25);
  }

  /* Saat Card di-hover: Tombol lebih kontras & elegan */
  .survey-card-box:hover .btn-survey-action {
    background-color: #034217 !important;
    border-color: #034217 !important;
    color: #FED802 !important;
    transform: scale(1.04);
    box-shadow: 0 6px 16px rgba(3, 66, 23, 0.35);
  }

  .btn-survey-action:hover {
    background-color: #022e10 !important;
    border-color: #022e10 !important;
    color: #ffffff !important;
  }

  /* ── Empty State ── */
  .survey-empty-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    border: 1px dashed #cbd5e1;
  }
</style>

<div class="survey-page pb-5">

  {{-- HERO BANNER (Konsisten dengan Standar Hero UIS) --}}
  <div style="background: #046b26; border-bottom: 3px solid #fed802; color: #ffffff; padding: 32px 0 28px 0; position: relative;">
    <div class="container text-center position-relative" style="z-index: 1;">
      <div class="breadcrumb-custom justify-content-center mb-3">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.humas') }}">Humas</a>
        <span>/</span>
        <span class="active">{{ $setting->judul_hero ?? 'Survey Layanan' }}</span>
      </div>

      <h1 class="fw-bold mb-2 text-white" style="font-size: 32px; letter-spacing: -0.5px;">
        {{ $setting->judul_hero ?? 'Survey Layanan' }}
      </h1>
      <div class="divider-line-gold"></div>
      <p class="text-white-50 mx-auto mb-0" style="max-width: 680px; font-size: 14.5px; line-height: 1.6;">
        {{ $setting->subjudul_hero ?? 'Kuesioner Evaluasi Kepuasan & Mutu Pelayanan Humas Universitas Ibnu Sina' }}
      </p>
    </div>
  </div>

  {{-- MAIN CONTENT SECTON: SURVEI EVALUASI --}}
  <div class="container py-5">
    
    {{-- Judul Seksi (Sesuai Screenshot User: "Survei Evaluasi") --}}
    <h2 class="survey-heading-main" data-aos="fade-up">
      {{ $setting->judul_seksi ?? 'Survei Evaluasi' }}
    </h2>

    @if(!empty($setting->deskripsi_seksi))
      <p class="text-center text-muted mx-auto mb-4" style="max-width: 720px; font-size: 14.5px;" data-aos="fade-up" data-aos-delay="50">
        {{ $setting->deskripsi_seksi }}
      </p>
    @endif

    {{-- Grid Tombol & Kartu Survei --}}
    <div class="row g-4 justify-content-center pt-2">
      @forelse($buttons as $index => $btn)
        <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ (($index % 3) + 1) * 100 }}">
          <div class="survey-card-box">
            <h3 class="survey-card-title">
              {{ $btn->judul }}
            </h3>
            
            <div>
              <a href="{{ $btn->formatted_url }}" 
                 @if($btn->target_blank) target="_blank" rel="noopener noreferrer" @endif
                 class="btn-survey-action">
                <span>{{ $btn->tombol_teks ?: 'Isi Survei' }}</span>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 col-md-8 text-center" data-aos="fade-up">
          <div class="survey-empty-box">
            <i class="bi bi-chat-left-dots text-muted fs-1 mb-2 d-block"></i>
            <h5 class="fw-bold text-dark">Belum ada instrumen survei yang aktif</h5>
            <p class="text-muted small mb-0">Silakan tambahkan tombol dan tautan formulir survei melalui panel admin Layanan Humas.</p>
          </div>
        </div>
      @endforelse
    </div>

  </div>

</div>
@endsection
