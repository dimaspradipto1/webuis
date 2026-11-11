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
  .fasilitas-card-link {
    display: flex;
    flex-direction: column;
    height: 100%;
    text-decoration: none;
    color: inherit;
  }
  .fasilitas-card-link .fasilitas-box {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: left;
    padding: 32px 28px;
  }
  .fasilitas-card-footer {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px dashed rgba(15, 23, 42, 0.12);
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13.5px;
    font-weight: 700;
    color: #046B26;
  }
  .fasilitas-box:hover .fasilitas-card-footer {
    color: #034e1c;
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

    <!-- Grid Kartu Fasilitas & Laboratorium -->
    <div class="row g-4">
      @forelse($saranas as $index => $sarana)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 50 + ($index * 60) }}">
          <a href="{{ route('homepage.fasilitas.detail', $sarana->slug ?: $sarana->id) }}" class="fasilitas-card-link">
            <div class="fasilitas-box">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="fasilitas-icon m-0">
                    <i class="bi {{ $sarana->icon ?: 'bi-building' }}"></i>
                  </div>
                  <span class="badge bg-light text-secondary border rounded-pill px-3 py-1" style="font-size: 11.5px;">
                    {{ $sarana->kategori ?: 'Fasilitas Kampus' }}
                  </span>
                </div>
                <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
                <p class="fasilitas-desc mb-0">
                  {{ trim(html_entity_decode(strip_tags($sarana->deskripsi ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?: 'Fasilitas yang mendukung kegiatan akademik dan riset mahasiswa.' }}
                </p>
              </div>

              <div class="fasilitas-card-footer">
                <span>Lihat Detail & Spesifikasi</span>
                <i class="bi bi-arrow-right-circle-fill fs-5"></i>
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

