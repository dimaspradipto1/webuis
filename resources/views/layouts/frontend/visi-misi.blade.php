@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     STYLING KONTEN VISI, MISI & TATA NILAI UIS
     (Format Bersih, Elegan & Modern Sesuai Standar Profil UIS)
  ═══════════════════════════════════════════════ */
  .visimisi-content-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    border-left: 5px solid var(--uis-green, #046B26) !important;
    box-shadow: 0 10px 30px rgba(4, 107, 38, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .visimisi-content-card:hover {
    box-shadow: 0 14px 35px rgba(4, 107, 38, 0.08);
  }

  .visimisi-card-icon {
    width: 48px;
    height: 48px;
    background: #edf6f0;
    color: var(--uis-green, #046B26);
    font-size: 22px;
    border: 1px solid #cce5d4;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .visimisi-badge-label {
    background: #edf6f0;
    color: var(--uis-green, #046B26);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-block;
  }

  .visimisi-card-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0a2313;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 0;
    margin-top: 4px;
    letter-spacing: -0.2px;
  }

  /* Styling Teks Visi */
  .visi-highlight-box {
    background: #f8faf9;
    border: 1px solid #eef5f0;
    border-radius: 12px;
    padding: 24px;
  }
  .visi-text-content {
    font-size: 1.18rem;
    font-weight: 600;
    color: #0a2313;
    line-height: 1.75;
    font-style: italic;
  }
  .visi-text-content p {
    margin-bottom: 0.5rem;
  }
  .visi-text-content p:last-child {
    margin-bottom: 0;
  }

  /* Styling Misi & Tata Nilai HTML List */
  .misi-html-formatted,
  .tatanilai-html-formatted {
    font-size: 15px;
    line-height: 1.85;
    color: #334155;
  }
  .misi-html-formatted ol, .misi-html-formatted ul,
  .tatanilai-html-formatted ol, .tatanilai-html-formatted ul {
    padding-left: 1.5rem;
    margin-bottom: 0;
  }
  .misi-html-formatted li,
  .tatanilai-html-formatted li {
    margin-bottom: 0.75rem;
    line-height: 1.8;
    text-align: justify;
  }
  .misi-html-formatted li:last-child,
  .tatanilai-html-formatted li:last-child {
    margin-bottom: 0;
  }
  .misi-html-formatted p,
  .tatanilai-html-formatted p {
    margin-bottom: 0.5rem;
  }
  .misi-html-formatted p:last-child,
  .tatanilai-html-formatted p:last-child {
    margin-bottom: 0;
  }
  .tatanilai-html-formatted strong,
  .tatanilai-html-formatted b {
    color: var(--uis-green, #046B26);
  }

  /* Tata Nilai CIP Grid Cards */
  .cip-card-item {
    background: #f8faf9;
    border: 1px solid #eef5f0;
    border-top: 4px solid var(--uis-green, #046B26);
    border-radius: 12px;
    padding: 20px;
    height: 100%;
    transition: transform 0.2s ease;
  }
  .cip-card-item:hover {
    transform: translateY(-2px);
  }
  .cip-letter-badge {
    width: 32px;
    height: 32px;
    background: var(--uis-green, #046B26);
    color: #ffffff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    flex-shrink: 0;
  }
  .cip-card-title {
    font-weight: 700;
    font-size: 16px;
    color: var(--uis-green, #046B26);
    margin-bottom: 0;
    letter-spacing: 0.2px;
  }
  .cip-card-desc {
    color: #475569;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 0;
  }

  @media (max-width: 576px) {
    .visimisi-card-title {
      font-size: 18px;
    }
    .visi-text-content {
      font-size: 1.05rem;
    }
    .misi-html-formatted,
    .tatanilai-html-formatted {
      font-size: 14px;
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
     KONTEN VISI, MISI & TATA NILAI UIS
     (Tampilan Bersih, Ringan & Elegan Tanpa Background Poster)
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" style="background: #ffffff;">
  <div class="container py-2">
    
    {{-- Section Header --}}
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Landasan & Orientasi Institusi</div>
      <h2 class="section-title">Visi, Misi & <em>Tata Nilai UIS</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto" style="max-width: 720px;">
        Landasan arah gerak, cita-cita luhur, dan komitmen seluruh civitas akademika Universitas Ibnu Sina dalam menyelenggarakan tridharma perguruan tinggi yang bermutu.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12">

        {{-- ═══════════════════════════════════════════════
             1. VISI UNIVERSITAS IBNU SINA
             ═══════════════════════════════════════════════ --}}
        <div class="visimisi-content-card p-4 p-md-5 mb-4" data-aos="fade-up">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="visimisi-card-icon">
              <i class="bi bi-eye-fill"></i>
            </div>
            <div>
              <span class="visimisi-badge-label">Visi Institusi</span>
              <h3 class="visimisi-card-title">Visi Universitas Ibnu Sina</h3>
            </div>
          </div>

          <div class="visi-highlight-box mt-3">
            @php
              $rawVisi = $about?->visimisi_tagline_visi ?? $about?->visi ?? '';
              $hasVisi = !empty(trim(strip_tags($rawVisi)));
            @endphp
            @if($hasVisi)
              @if(strip_tags($rawVisi) !== $rawVisi)
                <div class="visi-text-content mb-0">
                  {!! $rawVisi !!}
                </div>
              @else
                <p class="visi-text-content mb-0">
                  "{{ $rawVisi }}"
                </p>
              @endif
            @else
              <p class="visi-text-content mb-0">
                "Unggul, Berintegritas, Berjiwa Entrepreneurship"
              </p>
            @endif
          </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             2. MISI UNIVERSITAS IBNU SINA
             ═══════════════════════════════════════════════ --}}
        <div class="visimisi-content-card p-4 p-md-5 mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="visimisi-card-icon">
              <i class="bi bi-bullseye"></i>
            </div>
            <div>
              <span class="visimisi-badge-label">Misi Institusi</span>
              <h3 class="visimisi-card-title">Misi Universitas Ibnu Sina</h3>
            </div>
          </div>

          <div class="misi-clean-wrap">
            @php
              $rawMisi = $about?->visimisi_misi_items ?? $about?->misi ?? '';
              $hasMisi = !empty(trim(strip_tags($rawMisi)));
            @endphp
            @if($hasMisi)
              @if(strip_tags($rawMisi) !== $rawMisi)
                <div class="misi-html-formatted">
                  {!! $rawMisi !!}
                </div>
              @else
                <ol class="misi-html-formatted ps-3 mb-0">
                  @foreach(preg_split('/\r\n|\r|\n/', trim($rawMisi)) as $line)
                    @if(trim($line))
                      <li>{{ preg_replace('/^\d+[\.\)]\s*/', '', trim($line)) }}</li>
                    @endif
                  @endforeach
                </ol>
              @endif
            @else
              <ol class="misi-html-formatted ps-3 mb-0">
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
             3. TATA NILAI UIS "CIP"
             ═══════════════════════════════════════════════ --}}
        <div class="visimisi-content-card p-4 p-md-5" data-aos="fade-up" data-aos-delay="200">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="visimisi-card-icon">
              <i class="bi bi-gem"></i>
            </div>
            <div>
              <span class="visimisi-badge-label">Budaya Nilai Institusi</span>
              <h3 class="visimisi-card-title">
                {{ $about?->visimisi_tatanilai_judul ?: 'TATA NILAI UIS "CIP"' }}
              </h3>
            </div>
          </div>

          <div class="tatanilai-clean-wrap">
            @php
              $rawTataNilai = $about?->visimisi_tatanilai_items ?? '';
              $hasTataNilai = !empty(trim(strip_tags($rawTataNilai)));
            @endphp
            @if($hasTataNilai && strip_tags($rawTataNilai) !== $rawTataNilai)
              <div class="tatanilai-html-formatted">
                {!! $rawTataNilai !!}
              </div>
            @else
              {{-- Standard 3 CIP Cards --}}
              <div class="row g-3">
                <div class="col-md-4 col-12">
                  <div class="cip-card-item">
                    <div class="d-flex align-items-center gap-2 mb-2">
                      <span class="cip-letter-badge">C</span>
                      <h4 class="cip-card-title">CERDAS</h4>
                    </div>
                    <p class="cip-card-desc">Spiritual, intelektual dan emosional</p>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="cip-card-item">
                    <div class="d-flex align-items-center gap-2 mb-2">
                      <span class="cip-letter-badge">I</span>
                      <h4 class="cip-card-title">INTEGRITAS</h4>
                    </div>
                    <p class="cip-card-desc">Jujur, disiplin, komitmen dan bertanggung jawab</p>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="cip-card-item">
                    <div class="d-flex align-items-center gap-2 mb-2">
                      <span class="cip-letter-badge">P</span>
                      <h4 class="cip-card-title">PROFESIONAL</h4>
                    </div>
                    <p class="cip-card-desc">Objektif, adil dan transparan</p>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
