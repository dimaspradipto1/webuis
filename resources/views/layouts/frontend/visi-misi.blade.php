@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Arah Sasaran Strategis Civitas Akademika Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     STYLING 1 BANNER TUNGGAL VISI, MISI & TATA NILAI UIS
     (1 Banner Panjang ke Bawah Sesuai Konsep Poster Resmi UIS)
  ═══════════════════════════════════════════════ */
  .visimisi-poster-card {
    background: linear-gradient(135deg, #13883a 0%, #086127 50%, #023814 100%);
    background-size: cover;
    background-position: center;
    border-radius: 20px;
    padding: 30px 28px 22px 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0, 40, 15, 0.28);
    border: 2px solid rgba(254, 216, 2, 0.6);
    max-width: 880px;
    margin: 0 auto;
  }

  /* Dot Matrix Pattern Aksen di Sudut Atas */
  .visimisi-dot-matrix {
    position: absolute;
    width: 64px;
    height: 64px;
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

  /* Row Logo di Bagian Atas */
  .visimisi-header-logos {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-bottom: 14px;
    border-bottom: 1.5px solid rgba(255, 255, 255, 0.18);
    margin-bottom: 18px;
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
  }

  .logo-uis-mini {
    width: 36px;
    height: 36px;
    object-fit: contain;
  }
  .brand-text-mini {
    font-size: 10px;
    line-height: 1.15;
  }
  .logo-kemdikbud-mini {
    width: 30px;
    height: 30px;
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
    background: rgba(0,0,0,0.25);
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
    font-size: 24px;
    font-weight: 900;
    color: #ffffff;
    margin-bottom: 3px;
    letter-spacing: 0.6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
  }
  .text-gold-gradient {
    background: linear-gradient(180deg, #fff7b3 0%, #fed802 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-style: italic;
  }

  /* Section Title Badge */
  .section-title-badge {
    background: linear-gradient(180deg, #fff7b3 0%, #fed802 100%);
    color: #023814;
    font-weight: 900;
    font-size: 13.5px;
    letter-spacing: 0.6px;
    padding: 4px 14px;
    border-radius: 20px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
    text-transform: uppercase;
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  /* Kotak Konten (Transparan Menyatu Tanpa Background Kotak Gelap) */
  .visimisi-glass-content {
    background: transparent;
    border: none;
    border-radius: 0;
    padding: 6px 10px;
    position: relative;
    z-index: 2;
    box-shadow: none;
  }

  /* Typography Spesifik */
  .visi-text-highlight {
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.6;
    font-style: italic;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
  }
  .misi-html-content, .tatanilai-html-content, .visi-html-content {
    color: #f8fafc;
    font-size: 13px;
    line-height: 1.65;
  }
  .misi-html-content ol, .misi-html-content ul,
  .tatanilai-html-content ol, .tatanilai-html-content ul {
    padding-left: 20px;
    margin-bottom: 0;
  }
  .misi-html-content li, .tatanilai-html-content li {
    margin-bottom: 8px;
    text-align: justify;
  }
  .misi-html-content li:last-child, .tatanilai-html-content li:last-child {
    margin-bottom: 0;
  }
  .misi-html-content p, .tatanilai-html-content p {
    margin-bottom: 6px;
  }
  .misi-html-content p:last-child, .tatanilai-html-content p:last-child {
    margin-bottom: 0;
  }
  .tatanilai-html-content strong, .tatanilai-html-content b {
    color: #fed802 !important;
  }
  .misi-ordered-list {
    font-size: 13px;
    line-height: 1.6;
    color: #f8fafc;
  }
  .misi-ordered-list li {
    margin-bottom: 8px;
    text-align: justify;
  }
  .misi-ordered-list li:last-child {
    margin-bottom: 0;
  }

  .tatanilai-label {
    font-size: 13.5px;
    font-weight: 800;
    color: #fed802 !important;
  }
  .tatanilai-desc {
    font-size: 13px;
    color: #ffffff;
  }

  /* Pill Kuning Humas UIS */
  .visimisi-humas-pill {
    background: #fed802;
    color: #111111;
    font-weight: 800;
    font-size: 11px;
    border-radius: 50px;
    padding: 5px 20px;
    display: inline-block;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
    text-transform: uppercase;
    letter-spacing: 0.6px;
    position: relative;
    z-index: 2;
  }

  /* Ribbon Putih Sosial Media di Footer Kartu */
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
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.14);
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
  }
  .footer-social-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 10.5px;
  }
  .footer-url-pill {
    background: #fed802;
    color: #111111;
    font-weight: 700;
    font-size: 10.5px;
    padding: 3px 10px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
  }
  .footer-url-pill:hover {
    background: #e6c200;
    color: #000;
  }

  @media (max-width: 576px) {
    .visimisi-poster-card {
      padding: 20px 14px 16px 14px;
      border-radius: 14px;
    }
    .visimisi-univ-title {
      font-size: 18px;
    }
    .visimisi-card-footer-bar {
      flex-direction: column;
      gap: 6px;
      text-align: center;
    }
    .visi-text-highlight {
      font-size: 15px;
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
     1 BANNER TUNGGAL VISI, MISI & TATA NILAI UIS
     (Format Teks Dinamis + Background Gambar Panjang ke Bawah)
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #ffffff;">
  <div class="container py-2">
    @php
      $bgPoster = $about?->visimisi_background_url;
    @endphp

    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12" data-aos="fade-up" data-aos-delay="100">
        
        <div class="visimisi-poster-card w-100 d-flex flex-column" 
             style="@if($bgPoster) background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.90) 0%, rgba(2, 53, 18, 0.95) 100%), url('{{ $bgPoster }}'); @endif">
          
          {{-- Dot Matrix Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- Header Poster: Logos --}}
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

          {{-- Header Poster: Main Titles --}}
          <div class="visimisi-header-titles text-center my-2 pb-2">
            <h2 class="visimisi-univ-title mb-1">
              UNIVERSITAS <span class="text-gold-gradient">IBNU SINA</span>
            </h2>
          </div>

          {{-- ═══════════════════════════════════════════════
               BAGIAN 1: VISI
               ═══════════════════════════════════════════════ --}}
          <div class="visimisi-section-block mb-3">
            <div class="text-center mb-2">
              <span class="section-title-badge">
                <i class="bi bi-eye-fill"></i> VISI:
              </span>
            </div>
            <div class="visimisi-glass-content text-center py-3 px-4">
              @php
                $rawVisi = $about?->visimisi_tagline_visi ?? $about?->visi ?? '';
                $hasVisi = !empty(trim(strip_tags($rawVisi)));
              @endphp
              @if($hasVisi)
                @if(strip_tags($rawVisi) !== $rawVisi)
                  <div class="visi-html-content mb-0">
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
          <div class="visimisi-section-block mb-3">
            <div class="text-center mb-2">
              <span class="section-title-badge">
                <i class="bi bi-bullseye"></i> MISI:
              </span>
            </div>
            <div class="visimisi-glass-content py-3 px-4">
              @php
                $rawMisi = $about?->visimisi_misi_items ?? $about?->misi ?? '';
                $hasMisi = !empty(trim(strip_tags($rawMisi)));
              @endphp
              @if($hasMisi)
                @if(strip_tags($rawMisi) !== $rawMisi)
                  <div class="misi-html-content">
                    {!! $rawMisi !!}
                  </div>
                @else
                  <ol class="misi-ordered-list mb-0 ps-3">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawMisi)) as $line)
                      @if(trim($line))
                        <li>{{ preg_replace('/^\d+[\.\)]\s*/', '', trim($line)) }}</li>
                      @endif
                    @endforeach
                  </ol>
                @endif
              @else
                <ol class="misi-ordered-list mb-0 ps-3">
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
          <div class="visimisi-section-block mb-3">
            <div class="text-center mb-2">
              <span class="section-title-badge">
                <i class="bi bi-gem"></i> {{ $about?->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"' }}:
              </span>
            </div>
            <div class="visimisi-glass-content py-3 px-4">
              @php
                $rawTataNilai = $about?->visimisi_tatanilai_items ?? '';
                $hasTataNilai = !empty(trim(strip_tags($rawTataNilai)));
              @endphp
              @if($hasTataNilai)
                @if(strip_tags($rawTataNilai) !== $rawTataNilai)
                  <div class="tatanilai-html-content">
                    {!! $rawTataNilai !!}
                  </div>
                @else
                  <div class="tatanilai-items-wrap">
                    @foreach(preg_split('/\r\n|\r|\n/', trim($rawTataNilai)) as $tn)
                      @if(trim($tn))
                        @php
                          $parts = explode(':', trim($tn), 2);
                        @endphp
                        <div class="tatanilai-item mb-2">
                          @if(count($parts) === 2)
                            <strong class="tatanilai-label text-warning">{{ trim($parts[0]) }}:</strong>
                            <span class="tatanilai-desc text-white">{{ trim($parts[1]) }}</span>
                          @else
                            <span class="tatanilai-desc text-white">{{ $tn }}</span>
                          @endif
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
              @else
                <div class="tatanilai-items-wrap">
                  <div class="tatanilai-item mb-2">
                    <strong class="tatanilai-label text-warning">(C) CERDAS:</strong>
                    <span class="tatanilai-desc text-white">Spiritual, intelektual dan emosional</span>
                  </div>
                  <div class="tatanilai-item mb-2">
                    <strong class="tatanilai-label text-warning">(I) INTEGRITAS:</strong>
                    <span class="tatanilai-desc text-white">Jujur, disiplin, Komitmen dan bertanggung jawab</span>
                  </div>
                  <div class="tatanilai-item mb-0">
                    <strong class="tatanilai-label text-warning">(P) PROFESIONAL:</strong>
                    <span class="tatanilai-desc text-white">Objektif, Adil dan Transparan</span>
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
              <i class="bi bi-youtube text-danger"></i>
              <i class="bi bi-facebook text-primary"></i>
              <span>{{ $about?->visimisi_footer_fb ?? 'Universitas Ibnu Sina' }}</span>
            </div>
            <div class="footer-social-item">
              <i class="bi bi-instagram" style="color: #e1306c;"></i>
              <i class="bi bi-tiktok text-dark"></i>
              <span>{{ $about?->visimisi_footer_ig ?? 'Official.uisbatam' }}</span>
            </div>
            <a href="{{ $about?->visimisi_footer_url ?? 'https://uis.ac.id' }}" target="_blank" class="footer-url-pill">
              {{ str_replace(['https://', 'http://'], '', $about?->visimisi_footer_url ?? 'https://uis.ac.id') }}
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
