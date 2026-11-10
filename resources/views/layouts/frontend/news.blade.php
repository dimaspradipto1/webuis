@extends('layouts.frontend.template')

@section('title', 'Berita & Informasi Terkini — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Ikuti berita kampus, pengumuman akademik, riset teknologi & bisnis, dan publikasi terbaru dari Universitas Ibnu Sina (UIS) Batam.')
@section('meta_keywords', 'berita uis, pengumuman akademik uis, riset kampus batam, kegiatan mahasiswa uis, universitas ibnu sina batam')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="news-hero">
  <div class="container">
    <div data-aos="fade-up">
      <div class="badge px-2.5 py-1 rounded-pill mb-2" style="background: rgba(4, 107, 38, 0.45); color: var(--uis-orange); border: 1px solid rgba(254, 216, 2, 0.4); font-size: 11px;">
        <i class="bi bi-newspaper me-1"></i> Warta & Informasi Universitas Ibnu Sina
      </div>
      <h1 class="news-hero-title">Berita & <em>Warta Kampus</em> UIS</h1>
      <p class="text-white-50 mb-2" style="max-width: 650px; font-size: 13px; line-height: 1.45;">
        Kumpulan warta kegiatan universitas, pengumuman akademik, prestasi mahasiswa, riset terapan, dan inovasi civitas akademika Universitas Ibnu Sina Batam.
      </p>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Berita & Warta Kampus</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     NEWS PORTAL CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">

    {{-- Featured / Berita Utama --}}
    @if(isset($featured) && $featured)
      <div class="news-featured-box" data-aos="fade-up">
        <div class="row g-0 h-100 align-items-stretch">
          <div class="col-lg-5 col-md-5">
            <div class="news-featured-img-wrap">
              @if($featured->thumbnail)
                <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="{{ $featured->title }}" class="news-featured-thumb">
              @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: #e2e8f0; color: #64748b; min-height: 240px;">
                  <i class="bi bi-image" style="font-size: 3.5rem;"></i>
                </div>
              @endif
              <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2" style="background: #FED802; color: #046B26; font-weight: 800; font-size: 11px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.18);">
                <i class="bi bi-star-fill me-1"></i> BERITA UTAMA
              </span>
              @if(!empty($featured->gallery) && count($featured->gallery) > 0)
                <span class="news-gallery-badge">
                  <i class="bi bi-images me-1"></i> +{{ count($featured->gallery) }} Foto Galeri
                </span>
              @endif
            </div>
          </div>
          <div class="col-lg-7 col-md-7">
            <div class="news-featured-body">
              <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                <span><i class="bi bi-calendar3 me-1 text-secondary"></i> {{ $featured->created_at->format('d M Y') }}</span>
                <span>•</span>
                <span class="badge bg-light text-dark border">{{ $featured->category ?? 'Berita Universitas' }}</span>
              </div>
              <h3 class="news-featured-title">
                <a href="{{ route('homepage.news.detail', $featured->slug ?? $featured->id) }}" class="text-dark text-decoration-none">
                  {{ $featured->title }}
                </a>
              </h3>
              <p class="news-featured-desc">
                {{ $featured->description ?? Str::limit(strip_tags($featured->content), 170) }}
              </p>
              <div>
                <a href="{{ route('homepage.news.detail', $featured->slug ?? $featured->id) }}" class="btn-primary-hero" style="font-size: 13px; padding: 8px 20px;">
                  Baca Berita Lengkap <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Filter Kategori & Pencarian --}}
    <div class="news-filter-bar" data-aos="fade-up">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        
        {{-- Category Pills --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
          <a href="{{ route('homepage.news') }}" class="cat-pill-item {{ empty($selectedCat) && empty($search) ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Semua Kategori
          </a>

          @php
            $portalCategories = [
              'Berita Universitas'      => 'bi-newspaper',
              'Berita Humas'            => 'bi-megaphone-fill',
              'Akademik & Mahasiswa'    => 'bi-mortarboard',
              'K3 & Keselamatan Kerja'  => 'bi-shield-check',
              'Kesehatan Lingkungan'    => 'bi-tree',
              'Penelitian & Riset'      => 'bi-journal-medical',
              'Pengabdian Masyarakat'   => 'bi-people',
              'Pengumuman & Agenda'     => 'bi-megaphone',
            ];
          @endphp

          @foreach($portalCategories as $cName => $cIcon)
            <a href="{{ route('homepage.news', ['category' => $cName]) }}" class="cat-pill-item {{ ($selectedCat ?? '') === $cName ? 'active' : '' }}">
              <i class="bi {{ $cIcon }}"></i> {{ $cName }}
            </a>
          @endforeach
        </div>

        {{-- Search Input --}}
        <form action="{{ route('homepage.news') }}" method="GET" class="news-search-input-box ms-lg-auto">
          @if(!empty($selectedCat))
            <input type="hidden" name="category" value="{{ $selectedCat }}">
          @endif
          <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari artikel...">
          <button type="submit" aria-label="Cari"><i class="bi bi-search"></i></button>
        </form>

      </div>

      {{-- Active Filter Notification --}}
      @if(!empty($selectedCat) || !empty($search))
        <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top small text-muted">
          <div>
            @if(!empty($selectedCat))
              Menampilkan kategori: <strong class="text-dark">{{ $selectedCat }}</strong>
            @endif
            @if(!empty($search))
              {{ !empty($selectedCat) ? '• ' : '' }}Pencarian: <strong class="text-dark">"{{ $search }}"</strong>
            @endif
          </div>
          <a href="{{ route('homepage.news') }}" class="text-danger fw-bold text-decoration-none small">
            <i class="bi bi-x-circle me-1"></i> Reset Filter
          </a>
        </div>
      @endif
    </div>

    {{-- Grid Semua Berita --}}
    @if(isset($newsList) && $newsList->count() > 0)
      <div class="row g-4">
        @foreach($newsList as $article)
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="news-card-portal">
              <div class="news-card-thumb-wrap">
                @if($article->thumbnail)
                  <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="news-card-thumb" loading="lazy">
                @else
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: #e2e8f0; color: #64748b;">
                    <i class="bi bi-image fs-1"></i>
                  </div>
                @endif
                <span class="news-cat-badge">{{ $article->category ?? 'Berita' }}</span>
                @if(!empty($article->gallery) && count($article->gallery) > 0)
                  <span class="news-gallery-badge">
                    <i class="bi bi-images me-1"></i> +{{ count($article->gallery) }} Foto
                  </span>
                @endif
              </div>

              <div class="news-card-body">
                <div>
                  <div class="text-muted small mb-2" style="font-size: 11.5px;">
                    <i class="bi bi-calendar3 me-1"></i> {{ $article->created_at->format('d M Y') }}
                    <span class="mx-1">•</span>
                    <i class="bi bi-person me-1"></i> {{ $article->user?->name ?? 'Admin UIS' }}
                  </div>
                  <h5 class="fw-bold mb-2 text-dark" style="font-size: 15px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    <a href="{{ route('homepage.news.detail', $article->slug ?? $article->id) }}" class="text-dark text-decoration-none">
                      {{ $article->title }}
                    </a>
                  </h5>
                  <p class="text-muted small mb-3" style="font-size: 12.5px; line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ Str::limit($article->description ?? strip_tags($article->content), 110) }}
                  </p>
                </div>
                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                  <a href="{{ route('homepage.news.detail', $article->slug ?? $article->id) }}" class="fw-bold text-decoration-none" style="color: var(--uis-green); font-size: 12.5px;">
                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if(method_exists($newsList, 'links'))
        <div class="mt-5 d-flex justify-content-center">
          {{ $newsList->links('pagination::bootstrap-5') }}
        </div>
      @endif
    @else
      @if(!isset($featured) || !$featured)
        <div class="p-5 text-center bg-white rounded-4 shadow-sm">
          <i class="bi bi-newspaper fs-1 text-muted mb-3 d-block"></i>
          <h4 class="fw-bold text-dark">Belum Ada Berita</h4>
          <p class="text-muted small">Berita dan artikel terbaru Universitas Ibnu Sina akan segera dipublikasikan di sini.</p>
        </div>
      @endif
    @endif

  </div>
</section>

@endsection
