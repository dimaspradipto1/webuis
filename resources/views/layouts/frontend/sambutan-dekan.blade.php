@extends('layouts.frontend.template')

@section('title', 'Sambutan Rektor — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Sambutan resmi Rektor Universitas Ibnu Sina (UIS) Batam — Kampusnya Profesional Muda.')
@section('meta_keywords', 'sambutan rektor uis, rektor universitas ibnu sina, pimpinan universitas ibnu sina, uis batam')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'sambutan-rektor',
    'heroClass' => 'rektor-hero'
])

<!-- ═══════════════════════════════════════════════
     SAMBUTAN REKTOR CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container py-3">
    <div class="row g-5">

      {{-- Left Column: Rektor Portrait --}}
      <div class="col-lg-4" data-aos="fade-right">
        <div class="rektor-portrait-box">
          @if(!empty($sambutanDekan?->foto_dekan))
            <img src="{{ asset('storage/' . $sambutanDekan->foto_dekan) }}" alt="{{ $sambutanDekan->nama_dekan ?? 'Rektor Universitas Ibnu Sina' }}" class="rektor-portrait-img">
          @else
            <div class="rektor-avatar-fallback">
              <i class="bi bi-person-badge"></i>
              <span style="font-size: 14px; font-weight: 600; margin-top: 10px;">Foto Rektor</span>
            </div>
          @endif

          <h3 class="rektor-name-title">{{ $sambutanDekan->nama_dekan ?? 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.' }}</h3>
          <span class="rektor-role-badge">
            <i class="bi bi-award-fill me-1"></i> {{ $sambutanDekan->jabatan_dekan ?? 'Rektor Universitas Ibnu Sina (UIS) Batam' }}
          </span>

          <div class="pt-3 border-top mt-3 text-muted small text-start">
            <div class="mb-2"><i class="bi bi-mortarboard me-2" style="color: #046B26;"></i> Universitas Ibnu Sina (UIS) Batam</div>
            <div><i class="bi bi-geo-alt me-2 text-danger"></i> Kampus Utama Universitas Ibnu Sina</div>
          </div>
        </div>
      </div>

      {{-- Right Column: Full Message --}}
      <div class="col-lg-8" data-aos="fade-left">
        <div class="section-label">Amanat & Sambutan Resmi</div>
        <h2 class="section-title mb-4">
          Mewujudkan Generasi Unggul <em>Entrepreneur & Berkarakter Imtaq</em>
        </h2>

        {{-- Kutipan Singkat --}}
        <div class="rektor-quote-callout">
          <i class="bi bi-quote fs-3 d-block mb-1" style="color: #046B26;"></i>
          "{{ strip_tags($sambutanDekan->kutipan_singkat ?? ($sambutanDekan->sambutan_dekan ?? 'Selamat datang di Universitas Ibnu Sina (UIS) Batam — Kampusnya Profesional Muda. Kami bertekad membentuk generasi intelektual yang unggul, inovatif, berjiwa entrepreneur, dan berkarakter Imtaq yang siap memimpin industri di kancah nasional maupun global.')) }}"
        </div>

        {{-- Isi Lengkap Sambutan --}}
        <div class="sambutan-content-body" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
          @if(!empty($sambutanDekan?->sambutan_dekan))
            {!! $sambutanDekan->sambutan_dekan !!}
          @else
            <p>
              <em>Assalamu’alaikum Warahmatullahi Wabarakatuh,</em><br>
              Salam sejahtera untuk kita semua.
            </p>
            <p>
              Puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, atas limpahan rahmat dan karunia-Nya sehingga <strong>Universitas Ibnu Sina (UIS) Batam</strong> terus tumbuh dan berkembang menjadi institusi pendidikan tinggi terkemuka di kawasan Kepulauan Riau dan Indonesia.
            </p>
            <p>
              Sebagai kampus yang berakar di jantung industri Batam dengan slogan <em>"Kampusnya Profesional Muda"</em>, Universitas Ibnu Sina mengintegrasikan keunggulan akademik di bidang <strong>Fakultas Teknik (Sains & Teknologi)</strong>, <strong>Fakultas Ekonomi dan Bisnis (FEB)</strong>, <strong>Fakultas Ilmu Kesehatan (FIKES)</strong>, dan <strong>Program Pascasarjana</strong> dengan kebutuhan nyata dunia usaha dan industri global.
            </p>
            <p>
              Kepada seluruh civitas akademika, mahasiswa, alumni, dan masyarakat luas, mari bersama-sama melangkah maju mewujudkan visi UIS 2029 sebagai universitas unggul, bermartabat, dan bereputasi internasional berbasis Imtaq.
            </p>
            <p class="fw-bold mt-4 mb-1">
              <em>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</em>
            </p>
            <p class="text-muted">
              <strong>{{ $sambutanDekan->nama_dekan ?? 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.' }}</strong><br>
              <small>{{ $sambutanDekan->jabatan_dekan ?? 'Rektor Universitas Ibnu Sina (UIS) Batam' }}</small>
            </p>
          @endif
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
