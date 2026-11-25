@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     BANNER FULLWIDTH VISI, MISI & TATA NILAI UIS
     (Sesuai Desain Acuan Asli UIS, Fullwidth, Responsif)
  ═══════════════════════════════════════════════ */
  .visimisi-fullwidth-wrapper {
    width: 100%;
    position: relative;
    background-color: #034b1a;
    background-image: 
      linear-gradient(180deg, rgba(2, 60, 22, 0.28) 0%, rgba(3, 75, 26, 0.40) 30%, rgba(2, 45, 16, 0.75) 100%),
      url('{{ asset('assets/img/visimisi-campus-clean-bg.jpg') }}');
    background-size: cover;
    background-position: center top;
    background-repeat: no-repeat;
    padding: 36px 0 65px 0;
    overflow: hidden;
  }

  /* Aksen Gelombang Hijau Lime Organis di Bagian Atas */
  .visimisi-wave-lines {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 160px;
    pointer-events: none;
    z-index: 1;
    opacity: 0.85;
  }

  /* Aksen Dot Matrix di Sudut Kiri & Kanan */
  .visimisi-dot-matrix {
    position: absolute;
    width: 75px;
    height: 75px;
    pointer-events: none;
    opacity: 0.38;
    background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px);
    background-size: 8px 8px;
    z-index: 2;
  }
  .visimisi-dot-matrix.top-left {
    top: 15px;
    left: 24px;
  }
  .visimisi-dot-matrix.top-right {
    top: 15px;
    right: 24px;
  }

  /* Baris Brand Fleksibel Sesuai Desain Acuan */
  .visimisi-brand-row {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 36px;
    flex-wrap: wrap;
    margin-bottom: 32px;
  }

  .brand-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .brand-logo-uis {
    height: 50px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 5px rgba(0,0,0,0.45));
  }

  .brand-logo-kemdikbud {
    height: 44px;
    width: 44px;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.35));
  }

  .brand-logo-dikti {
    height: 42px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
  }

  .brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
    color: #ffffff;
  }
  .brand-text .humas {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
  }
  .brand-text .univ {
    font-size: 12.5px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
  }
  .brand-text .name {
    font-size: 16.5px;
    font-weight: 900;
    letter-spacing: 0.8px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
  }

  /* Garis Pemisah Vertikal Antar Brand */
  .brand-divider {
    width: 2px;
    height: 38px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 2px;
  }

  /* Section Badge Pills: VISI:, MISI:, TATA NILAI UIS "CIP": */
  .visimisi-pill-badge {
    background: #fed802;
    color: #024618;
    font-size: 14px;
    font-weight: 800;
    border-radius: 50px;
    padding: 7px 26px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.42);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
  }

  /* Kotak Konten Transparan Frosted Glass */
  .visimisi-content-card {
    background: rgba(0, 36, 14, 0.68);
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 16px;
    padding: 24px 32px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    color: #ffffff;
    box-shadow: 0 6px 26px rgba(0, 0, 0, 0.32);
  }

  /* Tipografi Visi */
  .visi-highlight-quote {
    font-size: 21px;
    font-weight: 700;
    font-style: italic;
    color: #ffffff;
    line-height: 1.65;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.65);
    letter-spacing: 0.3px;
    margin-bottom: 0;
  }
  .visi-highlight-quote p {
    margin-bottom: 0;
  }

  /* Tipografi Misi */
  .visimisi-misi-list {
    padding-left: 22px;
    margin-bottom: 0;
    color: #f8fafc;
  }
  .visimisi-misi-list li {
    margin-bottom: 12px;
    line-height: 1.8;
    text-align: justify;
    color: #f8fafc;
    font-size: 15px;
  }
  .visimisi-misi-list li:last-child {
    margin-bottom: 0;
  }
  .visimisi-content-card strong, .visimisi-content-card b {
    color: #fed802 !important;
  }

  /* Tipografi Tata Nilai */
  .visimisi-values-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .visimisi-value-row {
    font-size: 15px;
    line-height: 1.7;
    color: #ffffff;
  }
  .visimisi-value-row .key {
    font-weight: 800;
    color: #fed802;
    margin-right: 4px;
  }

  /* Responsif Tablet & Mobile */
  @media (max-width: 991px) {
    .visimisi-fullwidth-wrapper {
      padding: 26px 0 46px 0;
    }
    .visimisi-brand-row {
      gap: 20px;
    }
    .brand-logo-uis {
      height: 44px;
    }
    .brand-logo-kemdikbud {
      height: 38px;
      width: 38px;
    }
    .brand-logo-dikti {
      height: 38px;
    }
    .brand-text .univ {
      font-size: 11.5px;
    }
    .brand-text .name {
      font-size: 15px;
    }
    .visimisi-content-card {
      padding: 20px 24px;
    }
    .visi-highlight-quote {
      font-size: 17px;
    }
    .visimisi-misi-list li, .visimisi-value-row {
      font-size: 14px;
    }
  }

  @media (max-width: 768px) {
    .visimisi-brand-row {
      gap: 16px;
    }
    .brand-divider {
      display: none;
    }
    .visimisi-content-card {
      padding: 18px 20px;
      border-radius: 12px;
    }
    .visi-highlight-quote {
      font-size: 17px;
    }
    .visimisi-misi-list li, .visimisi-value-row {
      font-size: 14px;
    }
  }

  @media (max-width: 576px) {
    .visimisi-fullwidth-wrapper {
      padding: 20px 0 35px 0;
    }
    .visimisi-brand-row {
      flex-direction: column;
      align-items: center;
      gap: 12px;
      margin-bottom: 16px;
    }
    .brand-divider {
      display: none;
    }
    .brand-item {
      justify-content: center;
    }
    .visimisi-content-card {
      padding: 14px 16px;
      border-radius: 12px;
    }
    .visimisi-pill-badge {
      font-size: 12px;
      padding: 5px 18px;
    }
    .visi-highlight-quote {
      font-size: 15px;
    }
    .visimisi-misi-list {
      padding-left: 18px;
    }
  }
</style>
@endpush

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER (Breadcrumb & Hero Navigasi)
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'visi-misi',
    'heroClass' => 'visimisi-hero'
])

<!-- ═══════════════════════════════════════════════
     POSTER RESMI VISI, MISI & TATA NILAI UIS
     (Format Fullwidth Sesuai Desain Acuan Resmi)
═══════════════════════════════════════════════ -->
<div class="visimisi-fullwidth-wrapper w-100 p-0 m-0">

  {{-- Garis Gelombang Hijau Lime Organis --}}
  <svg class="visimisi-wave-lines" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
    <path d="M0,35 C320,105 520,5 840,48 C1160,95 1340,25 1440,55 L1440,0 L0,0 Z" fill="none" stroke="rgba(112, 192, 65, 0.45)" stroke-width="2"/>
    <path d="M0,55 C360,125 580,22 900,68 C1220,118 1380,38 1440,75 L1440,0 L0,0 Z" fill="none" stroke="rgba(112, 192, 65, 0.30)" stroke-width="2"/>
    <path d="M0,75 C400,145 640,38 960,88 C1280,138 1400,55 1440,95 L1440,0 L0,0 Z" fill="none" stroke="rgba(112, 192, 65, 0.20)" stroke-width="1.5"/>
  </svg>

  {{-- Dot Matrix Accents di Sudut Kiri & Kanan --}}
  <div class="visimisi-dot-matrix top-left"></div>
  <div class="visimisi-dot-matrix top-right"></div>

  <div class="container position-relative" style="z-index: 3;">
    
    {{-- 1. Baris Brand Logo & Teks Sesuai Gambar Acuan Resmi --}}
    <div class="visimisi-brand-row">
      
      {{-- Brand 1: Universitas Ibnu Sina --}}
      <div class="brand-item">
        <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" class="brand-logo-uis">
        <div class="brand-text">
          <span class="univ">UNIVERSITAS</span>
          <span class="name">IBNU SINA</span>
        </div>
      </div>

      {{-- Divider 1 --}}
      <div class="brand-divider"></div>

      {{-- Brand 2: Humas Universitas Ibnu Sina & Kemdikbud --}}
      <div class="brand-item">
        <img src="{{ asset('assets/img/layanan-terkait/kemdikbud.svg') }}" alt="Logo Kemdikbud" class="brand-logo-kemdikbud">
        <div class="brand-text">
          <span class="humas">HUMAS</span>
          <span class="univ">UNIVERSITAS</span>
          <span class="name">IBNU SINA</span>
        </div>
      </div>

      {{-- Divider 2 --}}
      <div class="brand-divider"></div>

      {{-- Brand 3: Diktisaintek Berdampak --}}
      <div class="brand-item">
        <img src="{{ asset('assets/img/logo-diktisaintek-horizontal.svg') }}" alt="Diktisaintek Berdampak" class="brand-logo-dikti">
      </div>

    </div>

    {{-- Konten Dinamis Visi, Misi & Tata Nilai UIS --}}
    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12" data-aos="fade-up" data-aos-delay="100">
          
          {{-- VISI --}}
          <div class="visimisi-section-block text-center mb-4">
            <div class="visimisi-pill-badge">
              <i class="bi bi-eye-fill"></i> VISI:
            </div>
            <div class="visimisi-content-card text-center">
              @php
                $rawVisi = $about?->visimisi_tagline_visi ?? $about?->visi ?? '';
                $hasVisi = !empty(trim(strip_tags($rawVisi)));
              @endphp
              @if($hasVisi)
                @if(strip_tags($rawVisi) !== $rawVisi)
                  <div class="visi-highlight-quote">
                    {!! $rawVisi !!}
                  </div>
                @else
                  <p class="visi-highlight-quote">
                    "{{ $rawVisi }}"
                  </p>
                @endif
              @else
                <p class="visi-highlight-quote">
                  "Unggul, Berintegritas, Berjiwa Entrepreneurship"
                </p>
              @endif
            </div>
          </div>

          {{-- MISI --}}
          <div class="visimisi-section-block mb-4">
            <div class="text-center mb-2">
              <div class="visimisi-pill-badge">
                <i class="bi bi-bullseye"></i> MISI:
              </div>
            </div>
            <div class="visimisi-content-card">
              @php
                $rawMisi = $about?->visimisi_misi_items ?? $about?->misi ?? '';
                $hasMisi = !empty(trim(strip_tags($rawMisi)));
              @endphp
              @if($hasMisi)
                @if(strip_tags($rawMisi) !== $rawMisi)
                  {!! $rawMisi !!}
                @else
                  <ol class="visimisi-misi-list">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawMisi)) as $line)
                      @if(trim($line))
                        <li>{{ preg_replace('/^\d+[\.\)]\s*/', '', trim($line)) }}</li>
                      @endif
                    @endforeach
                  </ol>
                @endif
              @else
                <ol class="visimisi-misi-list">
                  <li>Menyelenggarakan pendidikan tinggi yang unggul dengan mengintegrasikan nilai-nilai integritas dan kewirausahaan dalam proses pembelajaran, penelitian, dan pengabdian kepada Masyarakat.</li>
                  <li>Mengembangkan penelitian inovatif dan relevan yang berkontribusi pada kemajuan ilmu pengetahuan, teknologi, dan pemecahan masalah di masyarakat.</li>
                  <li>Membangun ekosistem kewirausahaan yang mendorong kreativitas, inovasi, dan kemandirian di kalangan civitas akademika dan masyarakat luas.</li>
                  <li>Menerapkan tata kelola universitas yang kredibel, transparan, akuntabel, bertanggungjawab dan berintegritas tinggi untuk mendukung pencapaian keunggulan institusi.</li>
                  <li>Menjalin kerjasama strategis dengan berbagai pemangku kepentingan untuk meningkatkan daya saing, reputasi, dan kontribusi universitas di tingkat nasional dan internasional.</li>
                </ol>
              @endif
            </div>
          </div>

          {{-- TATA NILAI --}}
          <div class="visimisi-section-block mb-2">
            <div class="text-center mb-2">
              <div class="visimisi-pill-badge">
                <i class="bi bi-gem"></i> {{ $about?->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"' }}:
              </div>
            </div>
            <div class="visimisi-content-card">
              @php
                $rawTataNilai = $about?->visimisi_tatanilai_items ?? '';
                $hasTataNilai = !empty(trim(strip_tags($rawTataNilai)));
              @endphp
              @if($hasTataNilai)
                @if(strip_tags($rawTataNilai) !== $rawTataNilai)
                  {!! $rawTataNilai !!}
                @else
                  <div class="visimisi-values-wrap">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawTataNilai)) as $tn)
                      @if(trim($tn))
                        @php
                          $parts = explode(':', trim($tn), 2);
                        @endphp
                        <div class="visimisi-value-row">
                          @if(count($parts) === 2)
                            <strong class="key">{{ trim($parts[0]) }}:</strong>
                            <span>{{ trim($parts[1]) }}</span>
                          @else
                            <span>{{ $tn }}</span>
                          @endif
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
              @else
                <div class="visimisi-values-wrap">
                  <div class="visimisi-value-row">
                    <strong class="key">(C) CERDAS:</strong>
                    <span>Spiritual, intelektual dan emosional</span>
                  </div>
                  <div class="visimisi-value-row">
                    <strong class="key">(I) INTEGRITAS:</strong>
                    <span>Jujur, disiplin, Komitmen dan bertanggung jawab</span>
                  </div>
                  <div class="visimisi-value-row">
                    <strong class="key">(P) PROFESIONAL:</strong>
                    <span>Objektif, Adil dan Transparan</span>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>

</div>
@endsection
