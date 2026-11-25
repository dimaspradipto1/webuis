@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     KONSEP POSTER / BANNER VISI, MISI & TATA NILAI UIS
     (Format Banner Tunggal Panjang ke Bawah Berbasis Background Image)
  ═══════════════════════════════════════════════ */
  .visimisi-poster-banner {
    background-color: #046B26;
    background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.88) 0%, rgba(2, 56, 20, 0.94) 100%);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 20px;
    padding: 34px 32px 26px 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0, 40, 15, 0.28);
    border: 2px solid rgba(254, 216, 2, 0.5);
    max-width: 900px;
    margin: 0 auto;
  }

  /* Dot Matrix Corner Accents */
  .visimisi-dot-matrix {
    position: absolute;
    width: 70px;
    height: 70px;
    pointer-events: none;
    opacity: 0.35;
    background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px);
    background-size: 8px 8px;
    z-index: 1;
  }
  .visimisi-dot-matrix.top-left {
    top: 14px;
    left: 16px;
  }
  .visimisi-dot-matrix.top-right {
    top: 14px;
    right: 16px;
  }

  /* Header Poster: 4 Logos Row */
  .visimisi-header-logos {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1.5px solid rgba(255, 255, 255, 0.22);
    margin-bottom: 22px;
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
  }

  .logo-uis-mini {
    width: 38px;
    height: 38px;
    object-fit: contain;
  }
  .brand-text-mini {
    font-size: 10px;
    line-height: 1.15;
  }
  .logo-kemdikbud-mini {
    width: 32px;
    height: 32px;
    object-fit: contain;
  }
  .badge-humas-mini {
    font-size: 8.5px;
    font-weight: 800;
    color: #fed802;
    text-align: center;
    line-height: 1.15;
    border: 1px solid rgba(254, 216, 2, 0.7);
    padding: 3px 8px;
    border-radius: 5px;
    background: rgba(0, 0, 0, 0.25);
  }
  .badge-humas-mini span {
    display: block;
  }
  .logo-dikti-mini {
    height: 26px;
    width: auto;
    object-fit: contain;
    background: rgba(255, 255, 255, 0.95);
    padding: 3px 6px;
    border-radius: 5px;
  }

  /* Judul Utama Poster */
  .visimisi-univ-title {
    font-size: 26px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 0.6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    margin-bottom: 18px;
    text-align: center;
  }
  .visimisi-univ-title .highlight-gold {
    color: #fed802;
    font-style: italic;
  }

  /* Section Headings: VISI:, MISI:, TATA NILAI: (Teks Bersih Sesuai Konsep Poster) */
  .visimisi-section-heading {
    color: #ffffff;
    font-weight: 800;
    font-size: 19px;
    text-align: center;
    letter-spacing: 0.8px;
    margin-bottom: 12px;
    text-transform: uppercase;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
  }

  /* Kotak Konten Transparan Menyatu dengan Background Image */
  .visimisi-content-box {
    background: rgba(0, 40, 15, 0.45);
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 14px;
    padding: 18px 24px;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    color: #ffffff;
    margin-bottom: 24px;
    position: relative;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.18);
  }

  /* Tipografi Teks Visi */
  .visi-text-highlight {
    font-size: 19px;
    font-weight: 700;
    color: #ffffff;
    font-style: italic;
    line-height: 1.65;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    letter-spacing: 0.3px;
  }
  .visi-text-highlight p {
    margin-bottom: 0;
  }

  /* Tipografi Butir Misi & Tata Nilai */
  .visimisi-content-box p {
    margin-bottom: 8px;
    color: #f8fafc;
    font-size: 14px;
    line-height: 1.75;
  }
  .visimisi-content-box p:last-child {
    margin-bottom: 0;
  }
  .visimisi-content-box ol, .visimisi-content-box ul {
    padding-left: 22px;
    margin-bottom: 0;
    color: #f8fafc;
  }
  .visimisi-content-box li {
    margin-bottom: 10px;
    line-height: 1.75;
    text-align: justify;
    color: #f8fafc;
    font-size: 14px;
  }
  .visimisi-content-box li:last-child {
    margin-bottom: 0;
  }
  .visimisi-content-box strong, .visimisi-content-box b {
    color: #fed802 !important;
  }

  /* Tata Nilai Items */
  .tatanilai-item-row {
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 8px;
    color: #ffffff;
  }
  .tatanilai-item-row:last-child {
    margin-bottom: 0;
  }
  .tatanilai-key {
    font-weight: 800;
    color: #fed802;
    margin-right: 4px;
  }

  /* Pill Kuning Humas UIS */
  .visimisi-humas-pill {
    background: linear-gradient(180deg, #ffe066 0%, #fed802 100%);
    color: #023814;
    font-weight: 800;
    font-size: 12px;
    border-radius: 50px;
    padding: 7px 24px;
    display: inline-block;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.25);
    text-transform: uppercase;
    letter-spacing: 0.6px;
    position: relative;
    z-index: 2;
  }

  /* Ribbon Putih Sosial Media di Footer Banner */
  .visimisi-card-footer-bar {
    background: #ffffff;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 11px;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
  }
  .footer-social-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
  }
  .footer-url-pill {
    background: #fed802;
    color: #111111;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 12px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
  }
  .footer-url-pill:hover {
    background: #e6c200;
    color: #000;
  }

  @media (max-width: 576px) {
    .visimisi-poster-banner {
      padding: 20px 14px 16px 14px;
      border-radius: 14px;
    }
    .visimisi-univ-title {
      font-size: 19px;
    }
    .visimisi-section-heading {
      font-size: 16px;
    }
    .visi-text-highlight {
      font-size: 16px;
    }
    .visimisi-content-box {
      padding: 14px 16px;
    }
    .visimisi-card-footer-bar {
      flex-direction: column;
      gap: 6px;
      text-align: center;
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
     BANNER POSTER VISI, MISI & TATA NILAI UIS
     (Sesuai Konsep Poster Resmi dengan Background Image)
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #ffffff;">
  <div class="container py-2">
    @php
      $bgPoster = $about?->visimisi_background_url;
    @endphp

    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12" data-aos="fade-up" data-aos-delay="100">
        
        <div class="visimisi-poster-banner w-100 d-flex flex-column" 
             style="@if($bgPoster) background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.85) 0%, rgba(2, 56, 20, 0.92) 100%), url('{{ $bgPoster }}'); @endif">
          
          {{-- Dot Matrix Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- Header Poster: 4 Logos --}}
          <div class="visimisi-header-logos">
            <div class="d-flex align-items-center gap-2">
              <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" class="logo-uis-mini">
              <div class="brand-text-mini">
                <span class="d-block fw-bold text-white lh-1">UNIVERSITAS</span>
                <span class="d-block fw-bold text-warning lh-1">IBNU SINA</span>
              </div>
            </div>
            <img src="{{ asset('assets/img/layanan-terkait/kemdikbud.svg') }}" alt="Kemdikbud" class="logo-kemdikbud-mini">
            <div class="badge-humas-mini">
              <span>HUMAS</span>
              <span>UNIVERSITAS</span>
              <span>IBNU SINA</span>
            </div>
            <img src="{{ asset('assets/img/layanan-terkait/diktisaintek.svg') }}" alt="Diktisaintek Berdampak" class="logo-dikti-mini">
          </div>

          {{-- Header Poster: Main Title --}}
          <div class="visimisi-header-titles">
            <h2 class="visimisi-univ-title">
              UNIVERSITAS <span class="highlight-gold">IBNU SINA</span>
            </h2>
          </div>

          {{-- ═══════════════════════════════════════════════
               BAGIAN 1: VISI
               ═══════════════════════════════════════════════ --}}
          <div class="visimisi-section-block">
            <h3 class="visimisi-section-heading">VISI:</h3>
            <div class="visimisi-content-box text-center">
              @php
                $rawVisi = $about?->visimisi_tagline_visi ?? $about?->visi ?? '';
                $hasVisi = !empty(trim(strip_tags($rawVisi)));
              @endphp
              @if($hasVisi)
                @if(strip_tags($rawVisi) !== $rawVisi)
                  <div class="visi-text-highlight mb-0">
                    {!! $rawVisi !!}
                  </div>
                @else
                  <p class="visi-text-highlight mb-0">
                    "{{ $rawVisi }}"
                  </p>
                @endif
              @else
                <p class="visi-text-highlight mb-0">
                  "Unggul, Berintegritas, Berjiwa Entrepreneurship"
                </p>
              @endif
            </div>
          </div>

          {{-- ═══════════════════════════════════════════════
               BAGIAN 2: MISI
               ═══════════════════════════════════════════════ --}}
          <div class="visimisi-section-block">
            <h3 class="visimisi-section-heading">MISI:</h3>
            <div class="visimisi-content-box">
              @php
                $rawMisi = $about?->visimisi_misi_items ?? $about?->misi ?? '';
                $hasMisi = !empty(trim(strip_tags($rawMisi)));
              @endphp
              @if($hasMisi)
                @if(strip_tags($rawMisi) !== $rawMisi)
                  {!! $rawMisi !!}
                @else
                  <ol class="ps-3 mb-0">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawMisi)) as $line)
                      @if(trim($line))
                        <li>{{ preg_replace('/^\d+[\.\)]\s*/', '', trim($line)) }}</li>
                      @endif
                    @endforeach
                  </ol>
                @endif
              @else
                <ol class="ps-3 mb-0">
                  <li>Menyelenggarakan pendidikan tinggi yang unggul dengan mengintegrasikan nilai-nilai integritas dan kewirausahaan dalam proses pembelajaran, penelitian, dan pengabdian kepada Masyarakat.</li>
                  <li>Mengembangkan penelitian inovatif dan relevan yang berkontribusi pada kemajuan ilmu pengetahuan, teknologi, dan pemecahan masalah di masyarakat.</li>
                  <li>Membangun ekosistem kewirausahaan yang mendorong kreativitas, inovasi, dan kemandirian di kalangan civitas akademika dan masyarakat luas.</li>
                  <li>Menerapkan tata kelola universitas yang kredibel, transparan, akuntabel, bertanggungjawab dan berintegritas tinggi untuk mendukung pencapaian keunggulan institusi.</li>
                  <li>Menjalin kerjasama strategis dengan berbagai pemangku kepentingan untuk meningkatkan daya saing, reputasi, dan kontribusi universitas di tingkat nasional dan internasional.</li>
                </ol>
              @endif
            </div>
          </div>

          {{-- ═══════════════════════════════════════════════
               BAGIAN 3: TATA NILAI UIS "CIP"
               ═══════════════════════════════════════════════ --}}
          <div class="visimisi-section-block">
            <h3 class="visimisi-section-heading">{{ $about?->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"' }}:</h3>
            <div class="visimisi-content-box">
              @php
                $rawTataNilai = $about?->visimisi_tatanilai_items ?? '';
                $hasTataNilai = !empty(trim(strip_tags($rawTataNilai)));
              @endphp
              @if($hasTataNilai)
                @if(strip_tags($rawTataNilai) !== $rawTataNilai)
                  {!! $rawTataNilai !!}
                @else
                  <div class="tatanilai-items-wrap">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawTataNilai)) as $tn)
                      @if(trim($tn))
                        @php
                          $parts = explode(':', trim($tn), 2);
                        @endphp
                        <div class="tatanilai-item-row">
                          @if(count($parts) === 2)
                            <strong class="tatanilai-key">{{ trim($parts[0]) }}:</strong>
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
                <div class="tatanilai-items-wrap">
                  <div class="tatanilai-item-row">
                    <strong class="tatanilai-key">(C) CERDAS:</strong>
                    <span>Spiritual, intelektual dan emosional</span>
                  </div>
                  <div class="tatanilai-item-row">
                    <strong class="tatanilai-key">(I) INTEGRITAS:</strong>
                    <span>Jujur, disiplin, Komitmen dan bertanggung jawab</span>
                  </div>
                  <div class="tatanilai-item-row">
                    <strong class="tatanilai-key">(P) PROFESIONAL:</strong>
                    <span>Objektif, Adil dan Transparan</span>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Bottom Humas Pill --}}
          <div class="text-center my-3">
            <div class="visimisi-humas-pill">
              {{ $about?->visimisi_badge_humas ?? 'HUMAS UNIVERSITAS IBNU SINA' }}
            </div>
          </div>

          {{-- Bottom White Footer Bar --}}
          <div class="visimisi-card-footer-bar">
            <div class="footer-social-item">
              <i class="bi bi-youtube text-danger fs-6"></i>
              <i class="bi bi-facebook text-primary fs-6"></i>
              <span>{{ $about?->visimisi_footer_fb ?? 'Universitas Ibnu Sina' }}</span>
            </div>
            <div class="footer-social-item">
              <i class="bi bi-instagram fs-6" style="color: #e1306c;"></i>
              <i class="bi bi-tiktok text-dark fs-6"></i>
              <span>{{ $about?->visimisi_footer_ig ?? 'Official.uisbatam' }}</span>
            </div>
            <a href="{{ $about?->visimisi_footer_url ?? 'https://uis.ac.id' }}" target="_blank" class="footer-url-pill">
              {{ $about?->visimisi_footer_url ?? 'https://uis.ac.id' }}
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
