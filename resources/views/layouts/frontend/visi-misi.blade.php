@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Tata Nilai Budaya Institusi Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam, tata nilai uis')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════
     KONSEP POSTER BANNER MODULAR VISI, MISI & TATA NILAI UIS
     (Struktur Seamless: Header Grafis + Konten Kampus Tengah + Footer Grafis)
  ═══════════════════════════════════════════════ */
  .visimisi-poster-banner {
    background-color: #046B26;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 42px rgba(0, 40, 15, 0.32);
    border: 2.5px solid rgba(254, 216, 2, 0.65);
    max-width: 920px;
    margin: 0 auto;
  }

  /* Middle Konten (Background Kampus & Konten Teks Dinamis) */
  .visimisi-banner-middle {
    background-size: cover;
    background-position: center top;
    background-repeat: repeat-y;
    padding: 34px 36px 24px 36px;
    position: relative;
    z-index: 2;
  }

  /* 3. Footer Bagian Bawah (Pill Humas & Ribbon Media Sosial) */
  .visimisi-banner-footer {
    width: 100%;
    position: relative;
    z-index: 2;
    line-height: 0;
  }
  .visimisi-banner-footer img {
    width: 100%;
    height: auto;
    display: block;
  }

  /* Section Headings: VISI:, MISI:, TATA NILAI UIS "CIP": */
  .visimisi-section-heading {
    color: #ffffff;
    font-weight: 800;
    font-size: 20px;
    text-align: center;
    letter-spacing: 0.8px;
    margin-top: 6px;
    margin-bottom: 12px;
    text-transform: uppercase;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.65);
  }

  /* Kotak Konten Transparan Menyatu dengan Background Foto Kampus */
  .visimisi-content-box {
    background: rgba(0, 36, 14, 0.52);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 14px;
    padding: 18px 24px;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    color: #ffffff;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
  }

  /* Tipografi Teks Visi */
  .visi-text-highlight {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    font-style: italic;
    line-height: 1.65;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
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

  @media (max-width: 768px) {
    .visimisi-banner-middle {
      padding: 24px 20px 20px 20px;
    }
  }

  @media (max-width: 576px) {
    .visimisi-poster-banner {
      border-radius: 14px;
      border-width: 1.5px;
    }
    .visimisi-banner-middle {
      padding: 18px 14px 16px 14px;
    }
    .visimisi-section-heading {
      font-size: 16px;
      margin-bottom: 8px;
    }
    .visi-text-highlight {
      font-size: 16px;
    }
    .visimisi-content-box {
      padding: 12px 14px;
      margin-bottom: 16px;
      border-radius: 10px;
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
     BANNER POSTER RESMI VISI, MISI & TATA NILAI UIS
     (Struktur Seamless Sesuai Desain Acuan Resmi UIS)
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #ffffff;">
  <div class="container py-2">
    @php
      $customBg = !empty($about?->visimisi_background) ? $about->visimisi_background_url : null;
      $middleBg = $customBg ?: asset('assets/img/visimisi-banner-middle.jpg');
    @endphp

    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-10 col-12" data-aos="fade-up" data-aos-delay="100">
        
        <div class="visimisi-poster-banner w-100 d-flex flex-column">
          
          {{-- KONTEN UTAMA VISI, MISI, TATA NILAI DENGAN BACKGROUND KAMPUS --}}
          <div class="visimisi-banner-middle" style="background-image: url('{{ $middleBg }}');">
            
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

          </div>

          {{-- 3. BAGIAN FOOTER BAWAH (Pill Humas & Bar Media Sosial) --}}
          <div class="visimisi-banner-footer">
            <img src="{{ asset('assets/img/visimisi-banner-footer.jpg') }}" alt="Footer Humas Universitas Ibnu Sina" class="w-100 d-block">
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
