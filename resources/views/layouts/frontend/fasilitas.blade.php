@extends('layouts.frontend.template')

@section('title', 'Fasilitas & Laboratorium — Universitas Ibnu Sina')
@section('meta_description', 'Daftar lengkap fasilitas kampus, laboratorium riset, smart classroom, perpustakaan digital, dan studio praktikum di Universitas Ibnu Sina Batam.')

@section('content')
<style>
  .fasilitas-page-hero {
    background: linear-gradient(135deg, #034e1c 0%, #046B26 60%, #068932 100%);
    padding: 64px 0 54px;
    color: #fff;
  }
  .fasilitas-filter-btn {
    border-radius: 999px;
    padding: 9px 22px;
    font-size: 14px;
    font-weight: 600;
    border: 1.5px solid #cbd5e1;
    color: #334155;
    background: #ffffff;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .fasilitas-filter-btn:hover {
    border-color: #046B26;
    color: #046B26;
  }
  .fasilitas-filter-btn.active {
    background: #046B26;
    border-color: #046B26;
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.22);
  }
  .gallery-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 5px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 43px;
  }
  .gallery-card-desc {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.82);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 38px;
  }
</style>

<!-- Header Hero -->
<div class="fasilitas-page-hero">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">Fasilitas & Laboratorium</span>
    </div>
    <h1 class="fw-bold text-white mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
      Fasilitas & Laboratorium Kampus
    </h1>
    <p class="text-white-50 mb-0" style="max-width: 720px; font-size: 15.5px;">
      Menunjang proses riset, praktikum laboratorium, dan kegiatan akademik mahasiswa Universitas Ibnu Sina dengan sarana berteknologi mutakhir.
    </p>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-2">

    <!-- Filter Kategori -->
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-5">
      <a href="{{ route('homepage.fasilitas') }}"
         class="fasilitas-filter-btn {{ empty($selectedKategori) ? 'active' : '' }}">
        <i class="bi bi-grid-fill me-1"></i> Semua Sarana ({{ $allSaranas->count() }})
      </a>
      <a href="{{ route('homepage.fasilitas', ['kategori' => 'Laboratorium & Studio']) }}"
         class="fasilitas-filter-btn {{ $selectedKategori === 'Laboratorium & Studio' ? 'active' : '' }}">
        <i class="bi bi-cpu-fill me-1"></i> Laboratorium & Studio ({{ $allSaranas->where('kategori', 'Laboratorium & Studio')->count() }})
      </a>
      <a href="{{ route('homepage.fasilitas', ['kategori' => 'Fasilitas Kampus']) }}"
         class="fasilitas-filter-btn {{ $selectedKategori === 'Fasilitas Kampus' ? 'active' : '' }}">
        <i class="bi bi-building-fill me-1"></i> Fasilitas Kampus ({{ $allSaranas->where('kategori', 'Fasilitas Kampus')->count() }})
      </a>
    </div>

    <!-- Grid Kartu Fasilitas & Laboratorium (Gallery Style) -->
    <div class="row g-4">
      @forelse($saranas as $index => $sarana)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 50 + ($index * 60) }}">
          <a href="{{ route('homepage.fasilitas.detail', $sarana->slug ?: $sarana->id) }}" class="gallery-card-item d-block text-decoration-none">
            <div class="gallery-img-container">
              @php
                $saranaImg = null;
                if (!empty($sarana->foto) && file_exists(public_path('storage/' . $sarana->foto))) {
                    $saranaImg = asset('storage/' . $sarana->foto);
                } elseif (!empty($sarana->galeri) && is_array($sarana->galeri) && count($sarana->galeri) > 0 && file_exists(public_path('storage/' . $sarana->galeri[0]))) {
                    $saranaImg = asset('storage/' . $sarana->galeri[0]);
                } else {
                    $defaultImgs = [
                        'storage/sarana/j5iAAWkR5yjvsSxUGIIruUQd1NqAnL9XKl0NHtuN.png',
                        'storage/sarana/cli6lBRpE2SShWKl7nuR0KLND0K9YNJXsahId013.png',
                        'storage/sarana/nXYvBgXCtS8344RDhQ3AjLY6wUjU4UxadDq6hVS5.png',
                        'storage/sarana/B87I02qirKpALPEG0r7xNJv2tKam7MewKBykz8H0.png',
                        'storage/sarana/Q0ykrPz1MNPQHYUVjXQ5uDwAeo2vD6zLmlHJyjw4.webp',
                        'storage/sarana/f21hCPgLRLDMaQ0q2RbHcZ1mAt78pt7xsIWbDGGw.webp',
                    ];
                    $saranaImg = asset($defaultImgs[$index % count($defaultImgs)]);
                }
              @endphp
              <img src="{{ $saranaImg }}" alt="{{ $sarana->nama }}" class="gallery-card-img" loading="lazy">
              <div class="gallery-card-overlay">
                <span class="gallery-tag"><i class="bi bi-tag-fill me-1"></i>{{ strtoupper($sarana->kategori ?: 'Fasilitas') }}</span>
                <h5 class="gallery-card-title">{{ $sarana->nama }}</h5>
                <p class="gallery-card-desc mb-0">{{ Str::limit(trim(html_entity_decode(strip_tags($sarana->deskripsi ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 85) ?: 'Sarana dan fasilitas mutakhir penunjang riset akademik.' }}</p>
              </div>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          Belum ada data fasilitas atau laboratorium pada kategori ini.
        </div>
      @endforelse
    </div>

  </div>
</section>
@endsection

