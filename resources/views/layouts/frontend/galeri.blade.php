@extends('layouts.frontend.template')

@php
  $isHumas = ($kategori ?? '') === 'humas';
@endphp

@section('title', ($isHumas ? 'Galeri & Kegiatan Humas' : 'Galeri & Dokumentasi') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', $isHumas ? 'Galeri foto liputan, publikasi, dan dokumentasi kegiatan Humas Universitas Ibnu Sina (UIS).' : 'Galeri foto kegiatan akademik, praktikum laboratorium, pengabdian masyarakat, dan wisuda Universitas Ibnu Sina (UIS).')
@section('meta_keywords', 'galeri uis, dokumentasi uis, foto kampus uis, humas uis, universitas ibnu sina batam')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="galeri-hero">
  <div class="container">
    <div class="galeri-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="galeri-hero-title">
        @if($isHumas)
          Galeri & <em>Kegiatan Humas</em>
        @else
          Galeri & <em>Dokumentasi</em>
        @endif
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        @if($isHumas)
          <a href="{{ route('homepage.humas') }}">Humas</a>
          <span>/</span>
          <span class="active">Galeri Humas</span>
        @else
          <span class="active">Galeri & Dokumentasi</span>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     GALLERY GRID
═══════════════════════════════════════════════ -->
<section class="section-bg-white">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      @if($isHumas)
        <div class="section-label mx-auto">Dokumentasi Humas</div>
        <h2 class="section-title">Galeri & <em>Kegiatan Humas</em></h2>
        <div class="divider-line centered"></div>
        <p class="section-desc mx-auto">
          Kumpulan dokumentasi publikasi, liputan media, siaran pers, dan seluruh kegiatan kehumasan Universitas Ibnu Sina.
        </p>
      @else
        <div class="section-label mx-auto">Dokumentasi Kampus</div>
        <h2 class="section-title">Aktivitas & <em>Kegiatan Mahasiswa</em></h2>
        <div class="divider-line centered"></div>
        <p class="section-desc mx-auto">
          Kumpulan dokumentasi praktikum laboratorium, pengabdian masyarakat, seminar nasional, dan momen prestasi civitas akademika UIS.
        </p>
      @endif
    </div>

    @if($isHumas)
      {{-- Dedicated Humas Action Bar (Tanpa Univ) --}}
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 p-3 rounded-4" style="background: #eaf7ee; border: 1.5px solid #b7e4c7;" data-aos="fade-up">
        <div class="d-flex align-items-center gap-2">
          <span class="badge rounded-pill px-3 py-2" style="background: #046B26; color: #ffffff; font-size: 13.5px;">
            <i class="bi bi-megaphone-fill me-1"></i> Dokumentasi Humas
          </span>
          <span class="text-muted small fw-semibold">Menampilkan seluruh foto kegiatan Humas ({{ $galleries->total() ?? $galleries->count() }} foto)</span>
        </div>
        <a href="{{ route('homepage.humas') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Humas
        </a>
      </div>
    @endif

    @if($galleries->isEmpty())
      <div class="col-12 text-center py-5">
        <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
        <p class="text-muted">Belum ada foto dokumentasi yang diunggah.</p>
        <a href="{{ route('homepage') }}" class="btn-primary-hero mt-3">
          <i class="bi bi-house"></i> Kembali ke Beranda
        </a>
      </div>
    @else
      <div class="row g-4">
        @foreach($galleries as $item)
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <a href="{{ route('homepage.galeri.detail', $item->slug ?? $item->id) }}" class="gallery-card-item d-block text-decoration-none">
              <div class="gallery-img-container">
                @if(!empty($item->url))
                  <img src="{{ asset('storage/' . $item->url) }}" alt="{{ $item->judul ?? 'Dokumentasi UIS' }}" class="gallery-card-img" loading="lazy">
                @else
                  <div class="gallery-fallback-box">
                    <i class="bi bi-camera-fill fs-1 text-white-50"></i>
                  </div>
                @endif

                @php
                  $pCount = is_array($item->galeri) ? count($item->galeri) : (!empty($item->url) ? 1 : 0);
                  $catName = $item->kategori_berita ?: ($item->news->category ?? ($item->kategori ?: 'Dokumentasi'));
                @endphp
                @if($pCount > 1)
                  <span class="badge position-absolute top-0 end-0 m-3 rounded-pill px-2 py-1 shadow-sm" style="background: rgba(2, 56, 20, 0.88); backdrop-filter: blur(4px); color: #FED802; font-size: 11px; font-weight: 700; border: 1px solid rgba(254, 216, 2, 0.4); z-index: 2;">
                    <i class="bi bi-images me-1"></i> {{ $pCount }} Foto
                  </span>
                @endif

                <div class="gallery-card-overlay">
                  <span class="gallery-tag"><i class="bi bi-tag-fill me-1"></i>{{ strtoupper($catName) }}</span>
                  <h5 class="gallery-card-title">{{ $item->judul }}</h5>
                  @if(!empty($item->deskripsi))
                    <p class="gallery-card-desc mb-0">{!! Str::limit(strip_tags($item->deskripsi), 90) !!}</p>
                  @endif
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>

      @if(method_exists($galleries, 'links'))
        <div class="d-flex justify-content-center mt-5">
          {{ $galleries->links() }}
        </div>
      @endif
    @endif
  </div>
</section>

@endsection
