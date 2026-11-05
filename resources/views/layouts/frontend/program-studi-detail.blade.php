@extends('layouts.frontend.template')

@section('title', $prodi->nama . ' — Program Studi Universitas Ibnu Sina (UIS)')
@section('meta_description', Str::limit(strip_tags($prodi->deskripsi_singkat ?: $prodi->deskripsi), 160))
@section('meta_keywords', strtolower($prodi->nama) . ', ' . strtolower($prodi->fakultas) . ', program studi uis, universitas ibnu sina batam')

@push('styles')
<style>
  .prodi-detail-hero {
    background: linear-gradient(135deg, #062b16 0%, #0b4f26 55%, #116a34 100%);
    padding: 76px 0 60px;
    color: #ffffff;
    position: relative;
    overflow: hidden;
  }
  .prodi-detail-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 82% 22%, rgba(244, 196, 48, 0.16), transparent 45%);
    pointer-events: none;
  }
  .prodi-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 15px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.22);
  }
  .prodi-meta-pill.gold {
    background: rgba(244, 196, 48, 0.2);
    color: #f4c430;
    border-color: rgba(244, 196, 48, 0.45);
  }
  .prodi-detail-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e4ede7;
    padding: 32px;
    box-shadow: 0 10px 30px rgba(8, 46, 22, 0.05);
    margin-bottom: 24px;
  }
  .prodi-section-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 19px;
    font-weight: 800;
    color: #0b2e19;
    margin-bottom: 16px;
  }
  .prodi-section-heading i {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #eaf5ee;
    color: #0b5d2a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }
  .prodi-main-photo-wrap {
    border-radius: 16px;
    overflow: hidden;
    background: #0b2e19;
    max-height: 440px;
    position: relative;
  }
  .prodi-main-photo-wrap img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    display: block;
  }
  .prodi-thumb-btn {
    border: 2px solid transparent;
    border-radius: 10px;
    overflow: hidden;
    padding: 0;
    width: 82px;
    height: 60px;
    cursor: pointer;
    opacity: 0.65;
    transition: all 0.2s ease;
    background: #000;
  }
  .prodi-thumb-btn.active,
  .prodi-thumb-btn:hover {
    border-color: #0b5d2a;
    opacity: 1;
    transform: translateY(-2px);
  }
  .prodi-thumb-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .prodi-career-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 16px;
    border-radius: 12px;
    background: #f7faf8;
    border: 1px solid #e5efe8;
    font-weight: 600;
    color: #153220;
    font-size: 14.5px;
  }
  .prodi-sidebar-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e4ede7;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(8, 46, 22, 0.05);
    margin-bottom: 24px;
  }
  .prodi-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 600;
    color: #264030;
    transition: all 0.2s ease;
  }
  .prodi-nav-link:hover {
    background: #eef6f1;
    color: #0b5d2a;
  }
  .prodi-nav-link.active {
    background: #0b5d2a;
    color: #ffffff;
  }
</style>
@endpush

@section('content')
@php
  $photos = $prodi->all_photo_urls;
  $misiItems = $prodi->misi_list;
  $prospekItems = $prodi->prospek_list;
  $pmbUrl = $pmbSetting->tombol_link_1 ?? 'https://pmb.uis.ac.id';
  if (!str_starts_with($pmbUrl, 'http') && !str_starts_with($pmbUrl, '/')) {
      $pmbUrl = 'https://' . $pmbUrl;
  }
@endphp

<!-- ═══════════════════════════════════════════════
     HERO BANNER DETAIL PRODI
═══════════════════════════════════════════════ -->
<div class="prodi-detail-hero">
  <div class="container position-relative" style="z-index: 2;">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}" class="text-white-50 text-decoration-none"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span class="text-white-50 mx-2">/</span>
      <a href="{{ route('homepage.program-studi') }}" class="text-white-50 text-decoration-none">Program Studi</a>
      <span class="text-white-50 mx-2">/</span>
      <span class="text-warning fw-semibold">{{ $prodi->nama }}</span>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
      <span class="prodi-meta-pill gold">
        <i class="bi bi-mortarboard-fill"></i>
        {{ $prodi->jenjang === 'S2' ? 'Program Pascasarjana (S2)' : 'Program Sarjana (S1)' }}
      </span>
      <span class="prodi-meta-pill">
        <i class="bi bi-building"></i> {{ $prodi->fakultas }}
      </span>
      @if($prodi->akreditasi)
        <span class="prodi-meta-pill">
          <i class="bi bi-patch-check-fill text-warning"></i> Akreditasi: {{ $prodi->akreditasi }}
        </span>
      @endif
      @if($prodi->gelar)
        <span class="prodi-meta-pill">
          <i class="bi bi-award-fill text-warning"></i> Gelar Lulusan: {{ $prodi->gelar }}
        </span>
      @endif
    </div>

    <h1 class="fw-extrabold text-white mb-2" style="font-size: clamp(1.85rem, 3.6vw, 2.75rem);">
      {{ $prodi->nama }}
    </h1>
    @if($prodi->deskripsi_singkat)
      <p class="text-white-50 mb-0" style="max-width: 820px; font-size: 15.5px; line-height: 1.7;">
        {{ $prodi->deskripsi_singkat }}
      </p>
    @endif
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     MAIN DETAIL CONTENT
═══════════════════════════════════════════════ -->
<section class="py-5" style="background: #f5f8f6;">
  <div class="container py-2">
    <div class="row g-4">

      {{-- LEFT / MAIN COLUMN --}}
      <div class="col-lg-8">

        {{-- Photo Gallery (if photos exist) --}}
        @if(count($photos) > 0)
          <div class="prodi-detail-card p-3">
            <div class="prodi-main-photo-wrap">
              <img src="{{ $photos[0] }}" alt="{{ $prodi->nama }}" id="prodiMainImage">
            </div>
            @if(count($photos) > 1)
              <div class="d-flex flex-wrap gap-2 mt-3 px-1">
                @foreach($photos as $idx => $photoUrl)
                  <button type="button"
                          class="prodi-thumb-btn {{ $idx === 0 ? 'active' : '' }}"
                          onclick="switchProdiPhoto('{{ $photoUrl }}', this)">
                    <img src="{{ $photoUrl }}" alt="Foto {{ $idx + 1 }}">
                  </button>
                @endforeach
              </div>
            @endif
          </div>
        @endif

        {{-- Profil & Deskripsi Program Studi --}}
        <div class="prodi-detail-card">
          <div class="prodi-section-heading">
            <i class="bi {{ $prodi->icon ?: 'bi-mortarboard-fill' }}"></i>
            <span>Profil Program Studi {{ $prodi->nama }}</span>
          </div>
          <div class="text-secondary" style="font-size: 15.5px; line-height: 1.85; text-align: justify; white-space: pre-line;">{{ $prodi->deskripsi ?: $prodi->deskripsi_singkat }}</div>
        </div>

        {{-- Visi & Misi Program Studi --}}
        @if(!empty($prodi->visi) || count($misiItems) > 0)
          <div class="prodi-detail-card">
            <div class="row g-4">
              @if(!empty($prodi->visi))
                <div class="col-12">
                  <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #edf7f0 0%, #f7fbf8 100%); border-left: 5px solid #0b5d2a;">
                    <div class="d-flex align-items-center gap-2 fw-bold mb-2" style="color: #0b5d2a; font-size: 16px;">
                      <i class="bi bi-bullseye fs-5"></i>
                      <span>Visi Keilmuan / Program Studi</span>
                    </div>
                    <p class="mb-0 fst-italic fw-semibold text-dark" style="font-size: 15.5px; line-height: 1.75;">
                      "{{ $prodi->visi }}"
                    </p>
                  </div>
                </div>
              @endif

              @if(count($misiItems) > 0)
                <div class="col-12">
                  <div class="prodi-section-heading mb-3">
                    <i class="bi bi-list-check"></i>
                    <span>Misi Program Studi</span>
                  </div>
                  <div class="d-flex flex-column gap-2">
                    @foreach($misiItems as $index => $misi)
                      <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: #f8fbf9; border: 1px solid #e7f0ea;">
                        <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; background: #0b5d2a; color: #fff; flex-shrink: 0;">
                          {{ $index + 1 }}
                        </span>
                        <span class="text-secondary" style="font-size: 14.5px; line-height: 1.65;">{{ $misi }}</span>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
          </div>
        @endif

        {{-- Prospek Karir & Kompetensi Lulusan --}}
        @if(count($prospekItems) > 0)
          <div class="prodi-detail-card">
            <div class="prodi-section-heading">
              <i class="bi bi-briefcase-fill"></i>
              <span>Prospek Karir & Profesi Lulusan</span>
            </div>
            <p class="text-muted small mb-3">
              Lulusan {{ $prodi->nama }} Universitas Ibnu Sina memiliki peluang karir yang luas di berbagai sektor industri, korporasi, maupun instansi:
            </p>
            <div class="row g-3">
              @foreach($prospekItems as $karir)
                <div class="col-md-6">
                  <div class="prodi-career-item">
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                    <span>{{ $karir }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

      </div>

      {{-- RIGHT / SIDEBAR COLUMN --}}
      <div class="col-lg-4">

        {{-- CTA Pendaftaran & Website Prodi --}}
        <div class="prodi-sidebar-card p-4" style="background: linear-gradient(145deg, #07371b 0%, #0d5c2b 100%); color: #fff;">
          <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1 rounded-pill">Pendaftaran Mahasiswa Baru</span>
          <h4 class="fw-bold text-white mb-2" style="font-size: 20px;">Bergabung di {{ $prodi->nama }}</h4>
          <p class="text-white-50 small mb-4" style="line-height: 1.65;">
            Siap mengembangkan potensi Anda bersama Universitas Ibnu Sina? Daftar sekarang secara online atau kunjungi halaman resmi fakultas/prodi.
          </p>

          <div class="d-grid gap-2">
            <a href="{{ $pmbUrl }}" target="_blank" rel="noopener noreferrer" class="btn fw-bold py-2.5 rounded-3" style="background: #f4c430; color: #072914;">
              <i class="bi bi-pencil-square me-1"></i> Mulai Pendaftaran (PMB)
            </a>

            @if(!empty($prodi->link_website))
              <a href="{{ $prodi->link_website }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light fw-semibold py-2.5 rounded-3">
                <i class="bi bi-globe me-1"></i> Kunjungi Website Fakultas / Prodi
              </a>
            @endif

            <a href="{{ route('homepage.program-studi') }}" class="btn btn-sm text-white-50 mt-1">
              <i class="bi bi-arrow-left me-1"></i> Lihat Semua Program Studi
            </a>
          </div>
        </div>

        {{-- Ringkasan Informasi Prodi --}}
        <div class="prodi-sidebar-card p-4">
          <h5 class="fw-bold mb-3" style="font-size: 16px; color: #0b2e19;">
            <i class="bi bi-info-circle-fill text-success me-2"></i>Informasi Akademik
          </h5>
          <div class="d-flex flex-column gap-3 small">
            <div class="d-flex justify-content-between border-bottom pb-2">
              <span class="text-muted">Jenjang Pendidikan</span>
              <span class="fw-bold text-dark">{{ $prodi->jenjang === 'S2' ? 'Strata 2 (Magister)' : 'Strata 1 (Sarjana)' }}</span>
            </div>
            <div class="d-flex justify-content-between border-bottom pb-2">
              <span class="text-muted">Fakultas / Unit</span>
              <span class="fw-bold text-dark text-end">{{ $prodi->fakultas }}</span>
            </div>
            @if($prodi->gelar)
              <div class="d-flex justify-content-between border-bottom pb-2">
                <span class="text-muted">Gelar Lulusan</span>
                <span class="fw-bold text-success">{{ $prodi->gelar }}</span>
              </div>
            @endif
            @if($prodi->akreditasi)
              <div class="d-flex justify-content-between">
                <span class="text-muted">Status Akreditasi</span>
                <span class="badge bg-success-subtle text-success fw-bold">{{ $prodi->akreditasi }}</span>
              </div>
            @endif
          </div>
        </div>

        {{-- Daftar Program Studi Lainnya --}}
        <div class="prodi-sidebar-card p-4">
          <h5 class="fw-bold mb-3" style="font-size: 16px; color: #0b2e19;">
            <i class="bi bi-journal-bookmark-fill text-success me-2"></i>Program Studi UIS Lainnya
          </h5>

          @foreach($groupedProdis as $fakultasName => $items)
            <div class="mb-3 last-mb-0">
              <div class="text-uppercase fw-bold text-muted mb-1 px-2" style="font-size: 11px; letter-spacing: 0.6px;">
                {{ $fakultasName }}
              </div>
              <div class="d-flex flex-column gap-1">
                @foreach($items as $item)
                  <a href="{{ route('homepage.program-studi.detail', $item->slug) }}"
                     class="prodi-nav-link {{ $item->id === $prodi->id ? 'active' : '' }}">
                    <span class="d-flex align-items-center gap-2">
                      <i class="bi {{ $item->icon ?: 'bi-mortarboard-fill' }}"></i>
                      <span>{{ $item->nama }}</span>
                    </span>
                    <i class="bi bi-chevron-right" style="font-size: 11px;"></i>
                  </a>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>

      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  function switchProdiPhoto(url, btn) {
    const mainImg = document.getElementById('prodiMainImage');
    if (mainImg) {
      mainImg.src = url;
    }
    document.querySelectorAll('.prodi-thumb-btn').forEach(el => el.classList.remove('active'));
    if (btn) {
      btn.classList.add('active');
    }
  }
</script>
@endpush

