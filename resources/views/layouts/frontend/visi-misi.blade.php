@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Arah Sasaran Strategis Civitas Akademika Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     STYLING KARTU VISI, MISI & TATA NILAI UIS
     (Konsep 1:1 Mengikuti Desain Resmi Gambar UIS)
  ═══════════════════════════════════════════════ */
  .visimisi-card {
    background: linear-gradient(135deg, #13883a 0%, #086127 50%, #023814 100%);
    background-size: cover;
    background-position: center;
    border-radius: 18px;
    padding: 20px 18px 16px 18px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 14px 34px rgba(0, 40, 15, 0.22);
    border: 1.5px solid rgba(254, 216, 2, 0.45);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .visimisi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 42px rgba(0, 40, 15, 0.32);
    border-color: rgba(254, 216, 2, 0.85);
  }

  /* Dot Matrix Pattern Aksen di Sudut Atas */
  .visimisi-dot-matrix {
    position: absolute;
    width: 48px;
    height: 48px;
    pointer-events: none;
    opacity: 0.35;
    background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px);
    background-size: 7px 7px;
    z-index: 1;
  }
  .visimisi-dot-matrix.top-left {
    top: 10px;
    left: 12px;
  }
  .visimisi-dot-matrix.top-right {
    top: 10px;
    right: 12px;
  }

  /* Row 4 Logo di Bagian Atas Kartu */
  .visimisi-header-logos {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.16);
    margin-bottom: 12px;
    position: relative;
    z-index: 2;
  }

  .logo-uis-mini {
    width: 24px;
    height: 24px;
    object-fit: contain;
  }
  .brand-text-mini {
    font-size: 8px;
    line-height: 1.1;
  }
  .logo-kemdikbud-mini {
    width: 22px;
    height: 22px;
    object-fit: contain;
  }
  .badge-humas-mini {
    font-size: 7px;
    font-weight: 800;
    color: #fed802;
    text-align: center;
    line-height: 1.1;
    border: 1px solid rgba(254, 216, 2, 0.6);
    padding: 2px 5px;
    border-radius: 4px;
    background: rgba(0,0,0,0.2);
  }
  .badge-humas-mini span {
    display: block;
  }
  .logo-dikti-mini {
    height: 20px;
    width: auto;
    object-fit: contain;
    background: rgba(255, 255, 255, 0.95);
    padding: 2px 4px;
    border-radius: 4px;
  }

  /* Judul Utama Kartu */
  .visimisi-univ-title {
    font-size: 19px;
    font-weight: 900;
    color: #ffffff;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
  }
  .text-gold-gradient {
    background: linear-gradient(180deg, #fff7b3 0%, #fed802 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-style: italic;
  }
  .visimisi-section-subtitle {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* Kotak Konten Tengah (Glassmorphism Semi-Gelap Transparan) */
  .visimisi-glass-content {
    background: rgba(0, 32, 12, 0.62);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 14px;
    padding: 18px 16px;
    min-height: 300px;
    position: relative;
    z-index: 2;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.1), 0 6px 18px rgba(0,0,0,0.22);
  }

  /* Typography Spesifik */
  .visi-text-highlight {
    font-size: 17px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.6;
    font-style: italic;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
  }
  .misi-html-content, .tatanilai-html-content, .visi-html-content {
    color: #f8fafc;
    font-size: 12.5px;
    line-height: 1.6;
  }
  .misi-html-content ol, .misi-html-content ul,
  .tatanilai-html-content ol, .tatanilai-html-content ul {
    padding-left: 18px;
    margin-bottom: 0;
  }
  .misi-html-content li, .tatanilai-html-content li {
    margin-bottom: 7px;
    text-align: justify;
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
    font-size: 12px;
    line-height: 1.5;
    color: #f8fafc;
  }
  .misi-ordered-list li {
    margin-bottom: 7px;
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
    font-size: 12.5px;
    color: #ffffff;
  }

  /* Pill Kuning Humas UIS */
  .visimisi-humas-pill {
    background: #fed802;
    color: #111111;
    font-weight: 800;
    font-size: 10.5px;
    border-radius: 50px;
    padding: 4px 16px;
    display: inline-block;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 2;
  }

  /* Ribbon Putih Sosial Media di Footer Kartu */
  .visimisi-card-footer-bar {
    background: #ffffff;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 10px;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
  }
  .footer-social-item {
    display: flex;
    align-items: center;
    gap: 3px;
    font-size: 9.5px;
  }
  .footer-url-pill {
    background: #fed802;
    color: #111111;
    font-weight: 700;
    font-size: 9.5px;
    padding: 2px 7px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
  }
  .footer-url-pill:hover {
    background: #e6c200;
    color: #000;
  }

  @media (max-width: 576px) {
    .visimisi-glass-content {
      min-height: auto;
    }
    .visimisi-univ-title {
      font-size: 17px;
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
     3 KARTU VISI, MISI & TATA NILAI UIS
     (Format Teks Dinamis + Background Gambar Utama)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-2">
    @php
      $globalBg = $about?->visimisi_background_url;
      $fallbackBg1 = \App\Models\VisiMisi::where('urutan', 1)->value('gambar');
      $fallbackBg2 = \App\Models\VisiMisi::where('urutan', 2)->value('gambar');
      $fallbackBg3 = \App\Models\VisiMisi::where('urutan', 3)->value('gambar');

      $bgCard1 = $globalBg ?: ($fallbackBg1 ? asset('storage/' . $fallbackBg1) : null);
      $bgCard2 = $globalBg ?: ($fallbackBg2 ? asset('storage/' . $fallbackBg2) : null);
      $bgCard3 = $globalBg ?: ($fallbackBg3 ? asset('storage/' . $fallbackBg3) : null);
    @endphp
    <div class="row g-4 justify-content-center align-items-stretch">
      
      {{-- ═══════════════════════════════════════════════
           KARTU 1: VISI
           ═══════════════════════════════════════════════ --}}
      <div class="col-lg-4 col-md-6 col-12 d-flex" data-aos="fade-up" data-aos-delay="100">
        <div class="visimisi-card w-100 d-flex flex-column" 
             style="@if($bgCard1) background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.88) 0%, rgba(2, 53, 18, 0.93) 100%), url('{{ $bgCard1 }}'); @endif">
          
          {{-- Dot Matrix Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- Header Card: Logos --}}
          <div class="visimisi-header-logos">
            <div class="d-flex align-items-center gap-1">
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

          {{-- Header Card: Titles --}}
          <div class="visimisi-header-titles text-center">
            <h3 class="visimisi-univ-title">
              UNIVERSITAS <span class="text-gold-gradient">IBNU SINA</span>
            </h3>
            <h4 class="visimisi-section-subtitle">VISI:</h4>
          </div>

          {{-- Middle Content Box (Glassmorphism) --}}
          <div class="visimisi-glass-content flex-grow-1 d-flex flex-column justify-content-center text-center">
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
                <div class="mb-2">
                  <i class="bi bi-quote fs-1 text-warning opacity-75"></i>
                </div>
                <p class="visi-text-highlight mb-0">
                  "{{ $rawVisi }}"
                </p>
              @endif
            @else
              <div class="mb-2">
                <i class="bi bi-quote fs-1 text-warning opacity-75"></i>
              </div>
              <p class="visi-text-highlight mb-0">
                "Unggul, Berintegritas, Berjiwa Entrepreneurship"
              </p>
            @endif
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

      {{-- ═══════════════════════════════════════════════
           KARTU 2: MISI
           ═══════════════════════════════════════════════ --}}
      <div class="col-lg-4 col-md-6 col-12 d-flex" data-aos="fade-up" data-aos-delay="200">
        <div class="visimisi-card w-100 d-flex flex-column" 
             style="@if($bgCard2) background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.88) 0%, rgba(2, 53, 18, 0.93) 100%), url('{{ $bgCard2 }}'); @endif">
          
          {{-- Dot Matrix Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- Header Card: Logos --}}
          <div class="visimisi-header-logos">
            <div class="d-flex align-items-center gap-1">
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

          {{-- Header Card: Titles --}}
          <div class="visimisi-header-titles text-center">
            <h3 class="visimisi-univ-title">
              UNIVERSITAS <span class="text-gold-gradient">IBNU SINA</span>
            </h3>
            <h4 class="visimisi-section-subtitle">MISI:</h4>
          </div>

          {{-- Middle Content Box (Glassmorphism) --}}
          <div class="visimisi-glass-content flex-grow-1 d-flex flex-column justify-content-center">
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

      {{-- ═══════════════════════════════════════════════
           KARTU 3: TATA NILAI UIS "CIP"
           ═══════════════════════════════════════════════ --}}
      <div class="col-lg-4 col-md-6 col-12 d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="visimisi-card w-100 d-flex flex-column" 
             style="@if($bgCard3) background-image: linear-gradient(135deg, rgba(14, 114, 46, 0.88) 0%, rgba(2, 53, 18, 0.93) 100%), url('{{ $bgCard3 }}'); @endif">
          
          {{-- Dot Matrix Accents --}}
          <div class="visimisi-dot-matrix top-left"></div>
          <div class="visimisi-dot-matrix top-right"></div>

          {{-- Header Card: Logos --}}
          <div class="visimisi-header-logos">
            <div class="d-flex align-items-center gap-1">
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

          {{-- Header Card: Titles --}}
          <div class="visimisi-header-titles text-center">
            <h3 class="visimisi-univ-title">
              UNIVERSITAS <span class="text-gold-gradient">IBNU SINA</span>
            </h3>
            <h4 class="visimisi-section-subtitle">{{ $about?->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"' }}</h4>
          </div>

          {{-- Middle Content Box (Glassmorphism) --}}
          <div class="visimisi-glass-content flex-grow-1 d-flex flex-column justify-content-center">
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
                      <div class="tatanilai-item mb-3">
                        @if(count($parts) === 2)
                          <strong class="tatanilai-label d-block mb-1 text-warning">{{ trim($parts[0]) }}:</strong>
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
                <div class="tatanilai-item mb-3">
                  <strong class="tatanilai-label d-block mb-1 text-warning">(C) CERDAS:</strong>
                  <span class="tatanilai-desc text-white">Spiritual, intelektual dan emosional</span>
                </div>
                <div class="tatanilai-item mb-3">
                  <strong class="tatanilai-label d-block mb-1 text-warning">(I) INTEGRITAS:</strong>
                  <span class="tatanilai-desc text-white">Jujur, disiplin, Komitmen dan bertanggung jawab</span>
                </div>
                <div class="tatanilai-item mb-0">
                  <strong class="tatanilai-label d-block mb-1 text-warning">(P) PROFESIONAL:</strong>
                  <span class="tatanilai-desc text-white">Objektif, Adil dan Transparan</span>
                </div>
              </div>
            @endif
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

    </div>
  </div>
</section>

@endsection
