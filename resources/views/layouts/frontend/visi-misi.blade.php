@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     POSTER BANNER VISI, MISI & TATA NILAI UIS
     (Format Fullwidth Sesuai Desain Acuan Grafis Resmi UIS)
  ═══════════════════════════════════════════════ */
  .visimisi-fullwidth-wrapper {
    width: 100%;
    position: relative;
    overflow: hidden;
    background-color: #023612;
  }

  /* 1. Header Grafis Resmi Fullwidth (Logos, Waves & UNIVERSITAS IBNU SINA) */
  .visimisi-fw-header {
    width: 100%;
    line-height: 0;
    position: relative;
    z-index: 2;
  }
  .visimisi-fw-header img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
  }

  /* 2. Middle Konten Fullwidth (Background Foto Kampus & Konten Visi, Misi, Tata Nilai) */
  .visimisi-fw-body {
    width: 100%;
    background-color: #034b1a;
    background-image: 
      linear-gradient(180deg, rgba(2, 60, 22, 0.72) 0%, rgba(4, 90, 32, 0.75) 50%, rgba(2, 45, 16, 0.78) 100%),
      url('{{ asset('assets/img/visimisi-banner-middle.jpg') }}');
    background-size: cover;
    background-position: center top;
    background-repeat: repeat-y;
    padding-top: 24px;
    padding-bottom: 28px;
    position: relative;
    z-index: 2;
  }

  /* 3. Footer Grafis Resmi Fullwidth (Humas Pill & Ribbon Media Sosial) */
  .visimisi-fw-footer {
    width: 100%;
    line-height: 0;
    position: relative;
    z-index: 2;
  }
  .visimisi-fw-footer img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
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
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.38);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif;
  }

  /* Kotak Konten Transparan Frosted Glass */
  .visimisi-content-card {
    background: rgba(0, 36, 14, 0.64);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 16px;
    padding: 24px 32px;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    color: #ffffff;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.28);
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

  @media (max-width: 768px) {
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
    .visimisi-fw-body {
      padding-top: 14px;
      padding-bottom: 16px;
    }
    .visimisi-content-card {
      padding: 14px 16px;
      border-radius: 10px;
    }
    .visimisi-pill-badge {
      font-size: 12.5px;
      padding: 5px 16px;
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

  {{-- 1. HEADER GRAFIS RESMI FULLWIDTH (Logos & Judul UNIVERSITAS IBNU SINA) --}}
  <div class="visimisi-fw-header w-100">
    <img src="{{ asset('assets/img/visimisi-banner-header.jpg') }}" alt="Universitas Ibnu Sina" class="w-100 d-block">
  </div>

  {{-- 2. KONTEN TENGAH FULLWIDTH DENGAN LATAR BELAKANG KAMPUS --}}
  <div class="visimisi-fw-body w-100">
    <div class="container py-3">
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

  {{-- 3. FOOTER GRAFIS RESMI FULLWIDTH (Humas Pill & Bar Sosial Media) --}}
  <div class="visimisi-fw-footer w-100">
    <img src="{{ asset('assets/img/visimisi-banner-footer.jpg') }}" alt="Humas Universitas Ibnu Sina" class="w-100 d-block">
  </div>

</div>
@endsection
