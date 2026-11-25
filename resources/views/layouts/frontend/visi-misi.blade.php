@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     POSTER BANNER VISI, MISI & TATA NILAI UIS
     (100% Murni Codingan HTML, CSS, SVG — Best Practice & Fully Responsive)
  ═══════════════════════════════════════════════ */
  .visimisi-poster-banner {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 40, 15, 0.35);
    border: 2.5px solid #fed802; /* Golden UIS Outline */
    max-width: 940px;
    margin: 0 auto;
    background: 
      linear-gradient(165deg, rgba(2, 60, 22, 0.94) 0%, rgba(4, 107, 38, 0.92) 50%, rgba(2, 45, 16, 0.96) 100%),
      url('{{ asset('assets/img/visimisi-banner-middle.jpg') }}') center / cover no-repeat;
    padding: 38px 40px 32px 40px;
  }

  /* Dot Matrix Corner Accents */
  .visimisi-dot-matrix {
    position: absolute;
    width: 65px;
    height: 65px;
    pointer-events: none;
    opacity: 0.38;
    background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px);
    background-size: 8px 8px;
    z-index: 1;
  }
  .visimisi-dot-matrix.top-left {
    top: 16px;
    left: 18px;
  }
  .visimisi-dot-matrix.top-right {
    top: 16px;
    right: 18px;
  }

  /* Header Row (Logos & Institusi) */
  .visimisi-header-row {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding-bottom: 20px;
    border-bottom: 1.5px solid rgba(255, 255, 255, 0.22);
    margin-bottom: 26px;
  }

  .visimisi-brand-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .visimisi-logo-uis {
    height: 48px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));
  }
  .visimisi-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
  }
  .visimisi-brand-text .univ {
    font-size: 11px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
  }
  .visimisi-brand-text .name {
    font-size: 15px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 0.8px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
  }

  .visimisi-center-block {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .visimisi-logo-kemdikbud {
    height: 40px;
    width: 40px;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
  }
  .visimisi-humas-badge-pill {
    border: 1px solid rgba(254, 216, 2, 0.75);
    background: rgba(0, 0, 0, 0.35);
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 8.5px;
    font-weight: 800;
    color: #fed802;
    line-height: 1.25;
    text-align: center;
    letter-spacing: 0.5px;
  }
  .visimisi-humas-badge-pill span {
    display: block;
  }

  .visimisi-dikti-pill {
    background: #ffffff;
    border-radius: 8px;
    padding: 4px 12px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
  }
  .visimisi-logo-dikti {
    height: 32px;
    width: auto;
    object-fit: contain;
  }

  /* Judul Besar Banner */
  .visimisi-main-title {
    position: relative;
    z-index: 3;
    font-size: clamp(24px, 4.2vw, 38px);
    font-weight: 900;
    font-style: italic;
    color: #ffffff;
    text-align: center;
    text-transform: uppercase;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
    letter-spacing: 0.8px;
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.6);
    margin-bottom: 28px;
  }
  .visimisi-main-title .highlight-gold {
    color: #fed802;
    text-shadow: 0 0 16px rgba(254, 216, 2, 0.45);
  }

  /* Section Badge Pills: VISI:, MISI:, TATA NILAI UIS "CIP": */
  .visimisi-section-wrap {
    position: relative;
    z-index: 3;
    margin-bottom: 24px;
  }
  .visimisi-pill-badge {
    background: #fed802;
    color: #024618;
    font-size: 13.5px;
    font-weight: 800;
    border-radius: 50px;
    padding: 6px 20px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.35);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
  }
  .visimisi-pill-badge.center-badge {
    display: table;
    margin-left: auto;
    margin-right: auto;
  }

  /* Kotak Konten Transparan Frosted Glass */
  .visimisi-frosted-card {
    background: rgba(0, 36, 14, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 14px;
    padding: 22px 28px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    color: #ffffff;
    box-shadow: 0 6px 22px rgba(0, 0, 0, 0.28);
  }

  /* Tipografi Visi */
  .visi-highlight-quote {
    font-size: 20px;
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
    padding-left: 20px;
    margin-bottom: 0;
    color: #f8fafc;
  }
  .visimisi-misi-list li {
    margin-bottom: 12px;
    line-height: 1.8;
    text-align: justify;
    color: #f8fafc;
    font-size: 14.5px;
  }
  .visimisi-misi-list li:last-child {
    margin-bottom: 0;
  }
  .visimisi-frosted-card strong, .visimisi-frosted-card b {
    color: #fed802 !important;
  }

  /* Tipografi Tata Nilai */
  .visimisi-values-wrap {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .visimisi-value-row {
    font-size: 14.5px;
    line-height: 1.7;
    color: #ffffff;
  }
  .visimisi-value-row .key {
    font-weight: 800;
    color: #fed802;
    margin-right: 4px;
  }

  /* Bottom Humas Pill */
  .visimisi-humas-bottom-pill {
    background: #fed802;
    color: #024618;
    font-weight: 900;
    font-size: 13px;
    letter-spacing: 0.8px;
    border-radius: 50px;
    padding: 7px 26px;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
  }

  /* Bottom White Social Ribbon */
  .visimisi-social-ribbon {
    position: relative;
    z-index: 3;
    background: #ffffff;
    border-radius: 12px;
    padding: 10px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    margin-top: 18px;
    flex-wrap: wrap;
  }
  .visimisi-social-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
  }
  .visimisi-social-item i {
    font-size: 16px;
  }
  .visimisi-social-btn {
    background: #fed802;
    color: #024618;
    font-weight: 800;
    font-size: 12px;
    padding: 5px 16px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .visimisi-social-btn:hover {
    background: #e6c300;
    color: #024618;
  }

  /* Responsif Tablet & Mobile */
  @media (max-width: 768px) {
    .visimisi-poster-banner {
      padding: 24px 20px 20px 20px;
      border-radius: 18px;
    }
    .visimisi-header-row {
      gap: 12px;
      padding-bottom: 14px;
      margin-bottom: 18px;
    }
    .visimisi-logo-uis {
      height: 40px;
    }
    .visimisi-logo-kemdikbud {
      height: 34px;
      width: 34px;
    }
    .visimisi-logo-dikti {
      height: 28px;
    }
    .visimisi-main-title {
      margin-bottom: 20px;
    }
    .visimisi-frosted-card {
      padding: 16px 18px;
    }
    .visi-highlight-quote {
      font-size: 17px;
    }
    .visimisi-misi-list li, .visimisi-value-row {
      font-size: 13.5px;
    }
    .visimisi-social-ribbon {
      flex-direction: column;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      text-align: center;
    }
  }

  @media (max-width: 576px) {
    .visimisi-poster-banner {
      padding: 18px 14px 16px 14px;
      border-radius: 14px;
      border-width: 2px;
    }
    .visimisi-header-row {
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
    .visimisi-center-block {
      order: 2;
    }
    .visimisi-dikti-pill {
      order: 3;
    }
    .visimisi-brand-left {
      order: 1;
    }
    .visimisi-pill-badge {
      font-size: 12px;
      padding: 4px 14px;
    }
    .visi-highlight-quote {
      font-size: 15px;
    }
    .visimisi-misi-list {
      padding-left: 16px;
    }
    .visimisi-humas-bottom-pill {
      font-size: 11px;
      padding: 6px 18px;
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
     (100% Codingan Murni HTML/CSS/SVG — Best Practice)
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #ffffff;">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12" data-aos="fade-up" data-aos-delay="100">
        
        <div class="visimisi-poster-banner w-100">
          
          {{-- Dot Matrix Corner Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- 1. BARIS HEADER: 3 Identitas Brand Resmi --}}
          <div class="visimisi-header-row">
            {{-- Kiri: Logo UIS & Brand Name --}}
            <div class="visimisi-brand-left">
              <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" class="visimisi-logo-uis">
              <div class="visimisi-brand-text">
                <span class="univ">UNIVERSITAS</span>
                <span class="name">IBNU SINA</span>
              </div>
            </div>

            {{-- Tengah: Logo Kemdikbud & Badge Humas UIS --}}
            <div class="visimisi-center-block">
              <img src="{{ asset('assets/img/layanan-terkait/kemdikbud.svg') }}" alt="Logo Kemdikbud" class="visimisi-logo-kemdikbud">
              <div class="visimisi-humas-badge-pill">
                <span>HUMAS</span>
                <span>UNIVERSITAS</span>
                <span>IBNU SINA</span>
              </div>
            </div>

            {{-- Kanan: Logo Diktisaintek Berdampak --}}
            <div class="visimisi-dikti-pill">
              <img src="{{ asset('assets/img/layanan-terkait/diktisaintek.svg') }}" alt="Diktisaintek Berdampak" class="visimisi-logo-dikti">
            </div>
          </div>

          {{-- 2. JUDUL HERO BANNER: UNIVERSITAS IBNU SINA --}}
          <h1 class="visimisi-main-title">
            UNIVERSITAS <span class="highlight-gold">IBNU SINA</span>
          </h1>

          {{-- 3. BAGIAN 1: VISI --}}
          <div class="visimisi-section-wrap">
            <div class="visimisi-pill-badge center-badge">
              <i class="bi bi-eye-fill"></i> VISI:
            </div>
            <div class="visimisi-frosted-card text-center">
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

          {{-- 4. BAGIAN 2: MISI --}}
          <div class="visimisi-section-wrap">
            <div class="visimisi-pill-badge center-badge">
              <i class="bi bi-bullseye"></i> MISI:
            </div>
            <div class="visimisi-frosted-card">
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

          {{-- 5. BAGIAN 3: TATA NILAI UIS "CIP" --}}
          <div class="visimisi-section-wrap">
            <div class="visimisi-pill-badge center-badge">
              <i class="bi bi-gem"></i> {{ $about?->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"' }}:
            </div>
            <div class="visimisi-frosted-card">
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

          {{-- 6. FOOTER IDENTITAS: Pill Humas & Ribbon Media Sosial --}}
          <div class="text-center mt-3 mb-2">
            <span class="visimisi-humas-bottom-pill">HUMAS UNIVERSITAS IBNU SINA</span>
          </div>

          <div class="visimisi-social-ribbon">
            <div class="visimisi-social-item">
              <i class="bi bi-youtube text-danger"></i>
              <i class="bi bi-facebook text-primary"></i>
              <span>Universitas Ibnu Sina</span>
            </div>
            <div class="visimisi-social-item">
              <i class="bi bi-instagram" style="color: #e1306c;"></i>
              <i class="bi bi-tiktok text-dark"></i>
              <span>Official.uisbatam</span>
            </div>
            <a href="https://uis.ac.id" target="_blank" class="visimisi-social-btn">
              uis.ac.id
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
