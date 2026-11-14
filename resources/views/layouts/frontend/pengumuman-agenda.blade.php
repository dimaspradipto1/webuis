@extends('layouts.frontend.template')

@section('title', 'Pengumuman & Agenda Akademik — Universitas Ibnu Sina')
@section('meta_description', 'Informasi pengumuman resmi akademik dan jadwal agenda kegiatan sivitas akademika Universitas Ibnu Sina Batam.')

@section('content')
<style>
  .pa-page-hero {
    background: #046b26 !important;
    border-bottom: 3px solid #fed802 !important;
    padding: 30px 0 24px;
    color: #fff;
  }
  .pa-filter-tab {
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
  .pa-filter-tab:hover {
    border-color: #046B26;
    color: #046B26;
  }
  .pa-filter-tab.active {
    background: #046B26;
    border-color: #046B26;
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.22);
  }
  .pa-card-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 24px;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
  }
  .pa-card-item:hover {
    transform: translateY(-4px);
    border-color: #86efac;
    box-shadow: 0 14px 28px rgba(4, 107, 38, 0.1);
    color: inherit;
  }
</style>

<!-- Header Hero -->
<div class="pa-page-hero">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">Pengumuman & Agenda</span>
    </div>
    <h1 class="fw-bold text-white mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
      Pengumuman & Agenda Akademik
    </h1>
    <p class="text-white-50 mb-0" style="max-width: 720px; font-size: 15.5px;">
      Pusat informasi pengumuman resmi akademik, jadwal perkuliahan, dan agenda kegiatan Universitas Ibnu Sina Batam.
    </p>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-2">

    <!-- Filter Kategori -->
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-5">
      <a href="{{ route('homepage.pengumuman-agenda') }}"
         class="pa-filter-tab {{ empty($selectedTipe) ? 'active' : '' }}">
        <i class="bi bi-grid-fill me-1"></i> Semua ({{ $allItems->count() }})
      </a>
      <a href="{{ route('homepage.pengumuman-agenda', ['tipe' => 'pengumuman']) }}"
         class="pa-filter-tab {{ $selectedTipe === 'pengumuman' ? 'active' : '' }}">
        <i class="bi bi-megaphone-fill me-1"></i> Pengumuman ({{ $pengumumans->count() }})
      </a>
      <a href="{{ route('homepage.pengumuman-agenda', ['tipe' => 'agenda']) }}"
         class="pa-filter-tab {{ $selectedTipe === 'agenda' ? 'active' : '' }}">
        <i class="bi bi-calendar4-week me-1"></i> Agenda ({{ $agendas->count() }})
      </a>
    </div>

    <!-- Grid Kartu Pengumuman & Agenda -->
    <div class="row g-4">
      @forelse($items as $idx => $item)
        @php
          $isAgenda = $item->tipe === 'agenda';
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 40 + ($idx * 50) }}">
          <a href="{{ route('homepage.pengumuman-agenda.detail', $item->slug ?: $item->id) }}" class="pa-card-item">
            <div>
              <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                @if($isAgenda)
                  <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: #f4d348; color: #1a202c; font-size: 11.5px;">
                    <i class="bi bi-calendar4-week me-1"></i> Agenda Akademik
                  </span>
                @else
                  <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: #eaf7ee; color: #046B26; font-size: 11.5px;">
                    <i class="bi bi-megaphone-fill me-1"></i> Pengumuman Resmi
                  </span>
                @endif
                <span class="text-muted small fw-semibold">
                  <i class="bi bi-clock me-1"></i>{{ $item->waktu }}
                </span>
              </div>

              @if(!empty($item->foto))
                <div class="mb-3 rounded-3 overflow-hidden" style="height: 165px;">
                  <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
              @endif

              <h4 class="fw-bold text-dark mb-2" style="font-size: 17px; line-height: 1.45;">
                {{ $item->judul }}
              </h4>

              @if(!empty($item->konten))
                <p class="text-muted small mb-0" style="line-height: 1.6;">
                  {{ Str::limit(strip_tags($item->konten), 115) }}
                </p>
              @endif
            </div>

            <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between fw-bold" style="font-size: 13px; color: #046B26;">
              <span>Baca Selengkapnya</span>
              <i class="bi bi-arrow-right-circle-fill fs-5"></i>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          Belum ada data pengumuman atau agenda yang dipublikasikan.
        </div>
      @endforelse
    </div>

  </div>
</section>
@endsection

