@extends('layouts.frontend.template')

@section('title', $sarana->nama . ' — Fasilitas & Laboratorium Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($sarana->deskripsi ?: $sarana->konten_detail ?: $sarana->nama), 160))

@section('content')
<style>
  .fasilitas-hero {
    background: linear-gradient(135deg, #034e1c 0%, #046B26 60%, #068932 100%);
    padding: 64px 0 56px;
    position: relative;
    overflow: hidden;
  }
  .fasilitas-hero::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(254, 216, 2, 0.08);
    pointer-events: none;
  }
  .fasilitas-hero-icon {
    width: 68px;
    height: 68px;
    border-radius: 18px;
    background: rgba(254, 216, 2, 0.16);
    border: 1.5px solid rgba(254, 216, 2, 0.45);
    color: #FED802;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    flex-shrink: 0;
  }
  .fasilitas-main-photo {
    width: 100%;
    max-height: 440px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
  }
  .spec-item-card {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    height: 100%;
  }
  .spec-item-card:hover {
    background: #f0fdf4;
    border-color: #86efac;
    transform: translateY(-2px);
  }
  .spec-item-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #dcfce7;
    color: #046B26;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
    margin-top: 1px;
  }
  .fasilitas-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 12px;
    text-decoration: none;
    color: #1e293b;
    border: 1px solid transparent;
    transition: all 0.2s ease;
    margin-bottom: 6px;
  }
  .fasilitas-nav-item:hover {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #046B26;
  }
  .fasilitas-nav-item.active {
    background: #046B26;
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.2);
  }
  .fasilitas-nav-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f0fdf4;
    color: #046B26;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .fasilitas-nav-item.active .fasilitas-nav-icon {
    background: #FED802;
    color: #046B26;
  }
  .galeri-thumb-card {
    border-radius: 14px;
    overflow: hidden;
    height: 190px;
    border: 1px solid #e2e8f0;
  }
  .galeri-thumb-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
  }
  .galeri-thumb-card:hover img {
    transform: scale(1.05);
  }
</style>

<!-- Header Hero -->
<div class="fasilitas-hero text-white">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.fasilitas') }}">Fasilitas & Laboratorium</a>
      <span>/</span>
      <span class="active">{{ Str::limit($sarana->nama, 45) }}</span>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
        <i class="bi bi-layers-fill me-1"></i>{{ $sarana->kategori ?: 'Fasilitas Kampus' }}
      </span>
      @if(!empty($sarana->lokasi))
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-semibold" style="font-size: 12px;">
          <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $sarana->lokasi }}
        </span>
      @endif
    </div>

    <div class="d-flex align-items-center gap-3 mt-2">
      <div class="fasilitas-hero-icon">
        <i class="bi {{ $sarana->icon ?: 'bi-building' }}"></i>
      </div>
      <div>
        <h1 class="fw-bold mb-1 text-white" style="font-size: clamp(24px, 3.2vw, 36px); line-height: 1.3;">
          {{ $sarana->nama }}
        </h1>
        @if(!empty($sarana->deskripsi))
          <p class="mb-0 text-white-50" style="font-size: 15px; max-width: 780px;">
            {{ trim(html_entity_decode(strip_tags($sarana->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
          </p>
        @endif
      </div>
    </div>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-2">
    <div class="row g-4 g-lg-5">

      <!-- Kolom Kiri: Foto, Deskripsi Detail, Spesifikasi, Galeri -->
      <div class="col-lg-8" data-aos="fade-up">

        <!-- Foto Utama & Switcher Multi-Foto -->
        @php
          $saranaPhotos = is_array($sarana->galeri) ? $sarana->galeri : [];
          if (!empty($sarana->foto) && !in_array($sarana->foto, $saranaPhotos, true)) {
              array_unshift($saranaPhotos, $sarana->foto);
          }
          $mainSaranaPhoto = $sarana->foto ?: ($saranaPhotos[0] ?? null);
        @endphp
        @if(!empty($mainSaranaPhoto))
          <div class="mb-3 position-relative">
            <img id="mainSaranaImg" src="{{ asset('storage/' . $mainSaranaPhoto) }}" alt="{{ $sarana->nama }}" class="fasilitas-main-photo">
            <a id="mainSaranaFullLink" href="{{ asset('storage/' . $mainSaranaPhoto) }}" target="_blank" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-3 rounded-pill px-3 shadow" style="font-size: 12px; background: rgba(0,0,0,0.65);">
              <i class="bi bi-arrows-fullscreen me-1"></i> Ukuran Penuh
            </a>
          </div>
        @else
          <div class="mb-4 position-relative overflow-hidden rounded-4 shadow-sm" style="height: 320px; background: linear-gradient(135deg, #046B26 0%, #034e1c 100%);">
            <img src="{{ asset('frontend/img/gedung-uis.jpg') }}" alt="{{ $sarana->nama }}" class="w-100 h-100" style="object-fit: cover; opacity: 0.32;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 text-white">
              <div class="rounded-4 d-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px; background: #FED802; color: #046B26; font-size: 36px;">
                <i class="bi {{ $sarana->icon ?: 'bi-building' }}"></i>
              </div>
              <h4 class="fw-bold mb-1 text-white">{{ $sarana->nama }}</h4>
              <span class="small text-white-50">{{ $sarana->lokasi ?: 'Kampus Universitas Ibnu Sina Batam' }}</span>
            </div>
          </div>
        @endif

        <!-- Card Deskripsi Lengkap -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
          <h3 class="fw-bold mb-3 text-dark" style="font-size: 21px;">
            <i class="bi bi-info-circle-fill text-success me-2"></i>Profil & Deskripsi {{ $sarana->kategori === 'Laboratorium & Studio' ? 'Laboratorium' : 'Fasilitas' }}
          </h3>
          <div class="divider-line mb-4"></div>

          @if(!empty($sarana->konten_detail))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! $sarana->konten_detail !!}
            </div>
          @elseif(!empty($sarana->deskripsi))
            <p style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {{ trim(html_entity_decode(strip_tags($sarana->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
            </p>
          @else
            <p class="text-muted">
              Fasilitas penunjang kegiatan akademik, praktikum, dan riset sivitas akademika Universitas Ibnu Sina Batam.
            </p>
          @endif
        </div>

        <!-- Card Spesifikasi & Peralatan Unggulan -->
        @php
          $specLines = !empty($sarana->spesifikasi)
              ? array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $sarana->spesifikasi))))
              : [];
        @endphp
        @if(count($specLines) > 0)
          <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
            <h3 class="fw-bold mb-3 text-dark" style="font-size: 21px;">
              <i class="bi bi-cpu-fill text-success me-2"></i>Fasilitas Unggulan & Spesifikasi Teknis
            </h3>
            <div class="divider-line mb-4"></div>

            <div class="row g-3">
              @foreach($specLines as $spec)
                <div class="col-md-6">
                  <div class="spec-item-card">
                    <div class="spec-item-icon">
                      <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="fw-medium text-dark" style="font-size: 14px; line-height: 1.45;">
                      {{ $spec }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- Galeri Dokumentasi -->
        @if(!empty($sarana->galeri) && is_array($sarana->galeri) && count($sarana->galeri) > 0)
          <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
            <h3 class="fw-bold mb-3 text-dark" style="font-size: 21px;">
              <i class="bi bi-images text-success me-2"></i>Galeri Dokumentasi Ruangan
            </h3>
            <div class="divider-line mb-4"></div>

            <div class="row g-3">
              @foreach($sarana->galeri as $fotoGaleri)
                <div class="col-sm-6 col-md-4">
                  <a href="{{ asset('storage/' . $fotoGaleri) }}" target="_blank" class="d-block galeri-thumb-card">
                    <img src="{{ asset('storage/' . $fotoGaleri) }}" alt="Galeri {{ $sarana->nama }}">
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
          <a href="{{ route('homepage.fasilitas') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold" style="font-size: 14px;">
            <i class="bi bi-arrow-left me-1"></i> Lihat Semua Fasilitas & Laboratorium
          </a>
        </div>

      </div>

      <!-- Kolom Kanan: Info Teknis & Menu Daftar Laboratorium / Fasilitas -->
      <div class="col-lg-4" data-aos="fade-left">

        <!-- Box Informasi Operasional -->
        <div class="info-badge-card mb-4">
          <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-clipboard2-data-fill text-success me-2"></i>Informasi Layanan
          </h5>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-tag me-1"></i> Kategori</span>
            <span class="info-meta-val text-success fw-semibold">{{ $sarana->kategori ?: 'Fasilitas Kampus' }}</span>
          </div>

          @if(!empty($sarana->lokasi))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-geo-alt me-1"></i> Lokasi</span>
              <span class="info-meta-val">{{ $sarana->lokasi }}</span>
            </div>
          @endif

          @if(!empty($sarana->jam_operasional))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-clock me-1"></i> Jam Operasional</span>
              <span class="info-meta-val" style="font-size: 13px;">{{ $sarana->jam_operasional }}</span>
            </div>
          @endif

          @if(!empty($sarana->penanggung_jawab))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-person-Check me-1"></i> Pengelola</span>
              <span class="info-meta-val" style="font-size: 13px;">{{ $sarana->penanggung_jawab }}</span>
            </div>
          @endif
        </div>

        <!-- Menu Navigasi Masing-Masing Laboratorium & Fasilitas -->
        @if(isset($otherSaranas) && $otherSaranas->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h5 class="fw-bold mb-1 text-dark">
              <i class="bi bi-grid-1x2-fill text-success me-2"></i>Menu Laboratorium & Fasilitas
            </h5>
            <p class="text-muted small mb-3">Pilih untuk melihat detail masing-masing sarana:</p>

            <div class="d-flex flex-column">
              @foreach($otherSaranas as $item)
                @php
                  $isCurrent = $item->id === $sarana->id;
                @endphp
                <a href="{{ route('homepage.fasilitas.detail', $item->slug ?: $item->id) }}"
                   class="fasilitas-nav-item {{ $isCurrent ? 'active' : '' }}">
                  <div class="fasilitas-nav-icon">
                    <i class="bi {{ $item->icon ?: 'bi-building' }}"></i>
                  </div>
                  <div class="flex-grow-1">
                    <div class="fw-bold" style="font-size: 13.5px; line-height: 1.35;">
                      {{ $item->nama }}
                    </div>
                    <div class="{{ $isCurrent ? 'text-white-50' : 'text-muted' }}" style="font-size: 11.5px;">
                      {{ $item->kategori ?: 'Fasilitas Kampus' }}
                    </div>
                  </div>
                  <i class="bi bi-chevron-right small"></i>
                </a>
              @endforeach
            </div>
          </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endsection

