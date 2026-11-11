@extends('layouts.frontend.template')

@section('title', 'Prestasi Mahasiswa — Universitas Ibnu Sina')
@section('meta_description', 'Daftar capaian prestasi, kejuaraan, dan penghargaan mahasiswa Universitas Ibnu Sina (UIS) UIS di tingkat regional, nasional, dan internasional.')

@section('content')
<!-- Header Banner -->
<div class="prestasi-hero text-white">
  <div class="container text-center">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(254, 216, 2, 0.18); color: #FED802; border: 1px solid rgba(254, 216, 2, 0.45); font-weight: 700; font-size: 13px; letter-spacing: 0.5px;">
      <i class="bi bi-trophy-fill me-1"></i> Hall of Fame & Prestasi
    </div>
    <h1 class="fw-bold mb-3 text-white" style="font-size: 38px; color: #ffffff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.35);">Prestasi Mahasiswa Universitas Ibnu Sina</h1>
    <p class="mx-auto text-white mb-2" style="max-width: 680px; line-height: 1.7; color: rgba(255, 255, 255, 0.92) !important; font-size: 15.5px;">
      Koleksi prestasi gemilang, medali kejuaraan, dan publikasi ilmiah sivitas akademika Universitas Ibnu Sina di tingkat regional, nasional, dan internasional.
    </p>
    <div class="breadcrumb-custom justify-content-center mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">Prestasi Mahasiswa</span>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="section-bg-sand py-5">
  <div class="container py-3">

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-5">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
          <a href="{{ route('homepage.prestasi') }}" class="cat-pill-item {{ empty($search) ? 'active' : '' }}">
            <i class="bi bi-trophy-fill"></i> Semua Prestasi Mahasiswa
          </a>
        </div>

        <form action="{{ route('homepage.prestasi') }}" method="GET" class="d-flex align-items-center gap-2">
          <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control form-control-sm rounded-pill px-3" placeholder="Cari prestasi mahasiswa..." style="max-width: 260px;">
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" style="background: #046B26; border-color: #046B26;">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

      @if(!empty($search))
        <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top small text-muted">
          <div>
            Pencarian: <strong class="text-dark">"{{ $search }}"</strong>
          </div>
          <a href="{{ route('homepage.prestasi') }}" class="text-danger fw-bold text-decoration-none small">
            <i class="bi bi-x-circle me-1"></i> Reset Pencarian
          </a>
        </div>
      @endif
    </div>

    <!-- Grid Kartu Prestasi -->
    @if(isset($prestasiList) && $prestasiList->count() > 0)
      <div class="row g-4">
        @foreach($prestasiList as $prestasi)
          @php
            $prestasiTitle = $prestasi->title ?? $prestasi->judul_prestasi ?? 'Prestasi Mahasiswa';
            $prestasiThumb = $prestasi->thumbnail ?? $prestasi->foto ?? null;
            $prestasiDesc  = $prestasi->description ?? $prestasi->content ?? $prestasi->deskripsi ?? '';
            $prestasiDate  = ($prestasi->published_at ?? $prestasi->created_at)?->format('d M Y');
          @endphp
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="prestasi-card-portal">
              <div class="prestasi-thumb-wrap">
                @if(!empty($prestasiThumb))
                  <img src="{{ asset('storage/' . $prestasiThumb) }}" alt="{{ $prestasiTitle }}" class="prestasi-thumb">
                @else
                  <div class="d-flex align-items-center justify-content-center h-100 flex-column gap-2" style="background: #e2e8f0; color: #64748b;">
                    <i class="bi bi-image" style="font-size: 44px;"></i>
                  </div>
                @endif
                <span class="prestasi-tingkat-badge badge bg-success text-white">
                  <i class="bi bi-trophy-fill me-1 text-warning"></i>{{ $prestasi->category ?? 'Prestasi Mahasiswa' }}
                </span>
              </div>

              <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                <div>
                  @if($prestasiDate)
                    <div class="text-muted small mb-2" style="font-size: 12px;">
                      <i class="bi bi-calendar3 me-1"></i>{{ $prestasiDate }}
                    </div>
                  @endif

                  <h4 class="fw-bold mb-2 text-dark" style="font-size: 16.5px; line-height: 1.45;">
                    <a href="{{ route('homepage.prestasi.detail', $prestasi->slug ?? $prestasi->id) }}" class="text-dark text-decoration-none">
                      {{ $prestasiTitle }}
                    </a>
                  </h4>

                  @if(!empty($prestasiDesc))
                    <div class="text-muted small mb-3 mt-2" style="font-size: 12.5px; line-height: 1.6;">
                      {{ Str::limit(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($prestasiDesc)))), 115) }}
                    </div>
                  @endif
                </div>

                <div class="pt-3 border-top">
                  <a href="{{ route('homepage.prestasi.detail', $prestasi->slug ?? $prestasi->id) }}" class="fw-bold text-decoration-none d-flex align-items-center justify-content-between" style="color: var(--uis-purple); font-size: 13.5px;">
                    <span>Lihat Selengkapnya</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if(method_exists($prestasiList, 'hasPages') && $prestasiList->hasPages())
        <div class="mt-5 d-flex justify-content-center">
          {{ $prestasiList->links('pagination::bootstrap-5') }}
        </div>
      @endif
    @else
      <div class="p-5 text-center bg-white rounded-4 shadow-sm">
        <i class="bi bi-trophy fs-1 text-muted mb-3 d-block"></i>
        <h4 class="fw-bold text-dark">Belum Ada Data Prestasi</h4>
        <p class="text-muted small">Data prestasi mahasiswa Universitas Ibnu Sina akan segera diperbarui di sini.</p>
        <a href="{{ route('homepage.prestasi') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4 mt-2">
          Lihat Semua Prestasi
        </a>
      </div>
    @endif

  </div>
</section>
@endsection
