@extends('layouts.frontend.template')

@section('title', 'Visi & Misi — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Visi, Misi, dan Nilai-nilai Budaya Civitas Akademika Universitas Ibnu Sina.')
@section('meta_keywords', 'visi misi uis, visi universitas ibnu sina, misi universitas ibnu sina batam')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="visimisi-hero">
  <div class="container">
    <div data-aos="fade-up">
      <h1 class="visimisi-hero-title">
        Visi & <em>Misi</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil</a>
        <span>/</span>
        <span class="active">Visi & Misi</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     VISI & MISI CARDS
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label">Arah & Landasan Institusi</div>
      <h2 class="section-title">Visi & Misi <em>Universitas Ibnu Sina</em></h2>
      <p class="section-desc mx-auto" style="max-width: 650px;">
        Komitmen fundamental yang mengarahkan setiap langkah Tri Dharma Perguruan Tinggi di Universitas Ibnu Sina.
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      {{-- Visi --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi {{ $about->visi_icon ?? 'bi-eye' }}"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">{{ $about->visi_judul ?? 'Visi Kami' }}</h3>
          
          @php $visiPoin = $visiMisis['visi'] ?? collect(); @endphp
          @if($visiPoin->count())
            @foreach($visiPoin as $v)
              <p class="value-desc" style="font-size:15.5px; line-height:1.9; text-align: justify;">
                {{ trim(html_entity_decode(strip_tags($v->isi ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
              </p>
            @endforeach
          @else
            <p class="value-desc" style="font-size:15.5px; line-height:1.9; text-align: justify;">
              {{ trim(html_entity_decode(strip_tags($about->visi ?? 'Menjadi Universitas Unggul, Bermartabat, Bereputasi Nasional dan Internasional serta berjiwa Entrepreneur berbasis Imtaq tahun 2029.'), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
            </p>
          @endif
        </div>
      </div>

      {{-- Misi --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi {{ $about->misi_icon ?? 'bi-rocket-takeoff' }}"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">{{ $about->misi_judul ?? 'Misi Kami' }}</h3>
          @php
            $misiPoin = ($visiMisis['misi'] ?? collect())->pluck('isi');
            if ($misiPoin->isEmpty()) {
              $misiPoin = collect([
                'Menyelenggarakan pendidikan dan pengajaran berkualitas berbasis teknologi informasi dan komunikasi untuk menghasilkan lulusan yang kompeten, profesional, berjiwa entrepreneur, dan berakhlak mulia.',
                'Melaksanakan penelitian yang inovatif, terapan, dan bernilai guna bagi pengembangan ilmu pengetahuan, teknologi, dan industri di tingkat nasional maupun internasional.',
                'Melaksanakan pengabdian kepada masyarakat berbasis riset yang berdaya guna dalam meningkatkan kesejahteraan masyarakat dan kemajuan bangsa.',
                'Menjalin kerja sama yang strategis, luas, dan berkelanjutan dengan institusi dalam dan luar negeri, dunia usaha, dan industri (DUDI).',
                'Mengembangkan tata kelola universitas yang transparan, akuntabel, kredibel, dan berintegritas berlandaskan nilai-nilai iman dan taqwa (Imtaq).',
              ]);
            }
          @endphp
          <ul class="value-desc" style="font-size:15px; line-height:1.8; padding-left: 20px; text-align: justify; margin: 0;">
            @foreach($misiPoin as $poin)
              <li class="mb-3">{{ trim(html_entity_decode(strip_tags($poin ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection
