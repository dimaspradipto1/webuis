@extends('layouts.frontend.template')

@section('title', $pimpinan->nama . ' — ' . $pimpinan->jabatan . ' | Universitas Ibnu Sina (UIS)')
@section('meta_description', Str::limit(strip_tags($pimpinan->biografi ?: ($pimpinan->nama . ' - ' . $pimpinan->jabatan)), 160))
@section('meta_keywords', strtolower($pimpinan->nama) . ', ' . strtolower($pimpinan->jabatan) . ', pimpinan uis, universitas ibnu sina')

@push('styles')
<style>
  .pimpinan-detail-section {
    padding: 36px 0 76px;
    background: #ffffff;
  }
  .pimpinan-breadcrumb-bar {
    font-size: 13.5px;
    color: #0b5d2a;
    margin-bottom: 28px;
  }
  .pimpinan-breadcrumb-bar a {
    color: #0b5d2a;
    text-decoration: none;
    font-weight: 600;
  }
  .pimpinan-breadcrumb-bar a:hover {
    text-decoration: underline;
  }
  .pimpinan-portrait-showcase {
    max-width: 580px;
    margin: 0 auto 36px;
    text-align: center;
  }
  .pimpinan-portrait-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 18px 46px rgba(0, 0, 0, 0.12);
    background: #f8faf9;
    display: inline-block;
    max-width: 100%;
  }
  .pimpinan-portrait-card img {
    width: 100%;
    max-width: 540px;
    height: auto;
    display: block;
    margin: 0 auto;
  }
  .pimpinan-thumb-btn {
    border: 2px solid transparent;
    border-radius: 10px;
    overflow: hidden;
    width: 72px;
    height: 72px;
    padding: 0;
    cursor: pointer;
    opacity: 0.65;
    transition: all 0.2s ease;
  }
  .pimpinan-thumb-btn.active,
  .pimpinan-thumb-btn:hover {
    border-color: #046B26;
    opacity: 1;
    transform: translateY(-2px);
  }
  .pimpinan-thumb-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .pimpinan-bio-container {
    max-width: 960px;
    margin: 0 auto;
    color: #1f2937;
    font-size: 15.5px;
    line-height: 1.85;
    text-align: justify;
  }
  .pimpinan-bio-paragraph {
    margin-bottom: 18px;
  }
  .pimpinan-bio-subheading {
    font-size: 17px;
    font-weight: 800;
    color: #046B26;
    margin-top: 28px;
    margin-bottom: 12px;
    text-align: left;
  }
  .other-pimpinan-card {
    background: #f8faf9;
    border: 1px solid #e4ede7;
    border-radius: 14px;
    padding: 14px;
    text-decoration: none;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.22s ease;
    height: 100%;
  }
  .other-pimpinan-card:hover {
    background: #eaf5ee;
    border-color: #046B26;
    transform: translateY(-3px);
    color: #046B26;
  }
  .other-pimpinan-card img {
    width: 58px;
    height: 72px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
  }
</style>
@endpush

@section('content')
@php
  $photos = $pimpinan->all_photo_urls;
  $rawBio = trim($pimpinan->biografi ?? '');
  $paragraphs = $rawBio !== ''
      ? array_values(array_filter(array_map('trim', preg_split('/\r\n\r\n|\n\n|\r\r/', $rawBio))))
      : [];
@endphp

<section class="pimpinan-detail-section">
  <div class="container">

    {{-- Top Back Link / Breadcrumb --}}
    <div class="pimpinan-breadcrumb-bar d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div>
        <a href="{{ route('homepage.struktur-organisasi') }}">
          <i class="bi bi-arrow-left me-1"></i> Profil Pimpinan dan Struktur
        </a>
        <span class="text-muted mx-2">/</span>
        <span class="text-secondary">{{ $pimpinan->nama }}</span>
      </div>
      <a href="{{ route('homepage.struktur-organisasi') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
        <i class="bi bi-grid me-1"></i> Lihat Semua Pimpinan
      </a>
    </div>

    {{-- Portrait Card Showcase (Persis seperti uis.ac.id/profil-andi-tenri-ummu/) --}}
    <div class="pimpinan-portrait-showcase" data-aos="zoom-in">
      <div class="pimpinan-portrait-card">
        <img src="{{ $photos[0] ?? $pimpinan->foto_url }}" alt="{{ $pimpinan->nama }}" id="mainPimpinanPhoto">
      </div>

      @if(count($photos) > 1)
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
          @foreach($photos as $idx => $photoUrl)
            <button type="button"
                    class="pimpinan-thumb-btn {{ $idx === 0 ? 'active' : '' }}"
                    onclick="switchPimpinanPhoto('{{ $photoUrl }}', this)">
              <img src="{{ $photoUrl }}" alt="Foto {{ $idx + 1 }}">
            </button>
          @endforeach
        </div>
      @endif

      <div class="mt-3">
        <span class="badge rounded-pill px-3 py-1.5 mb-2" style="background: #eaf5ee; color: #046B26; font-size: 12.5px;">
          {{ $pimpinan->jabatan }}
        </span>
        <h1 class="fw-extrabold text-dark mb-0" style="font-size: clamp(1.5rem, 2.8vw, 2.15rem);">
          {{ $pimpinan->nama }}
        </h1>
      </div>
    </div>

    {{-- Biography / Profil Lengkap --}}
    <div class="pimpinan-bio-container" data-aos="fade-up">
      @if(count($paragraphs) > 0)
        @foreach($paragraphs as $para)
          @php
            $isSubheading = strlen($para) < 85 && !str_ends_with($para, '.') && !str_ends_with($para, '"');
          @endphp
          @if($isSubheading)
            <h3 class="pimpinan-bio-subheading">{{ $para }}</h3>
          @else
            <p class="pimpinan-bio-paragraph" style="white-space: pre-line;">{{ $para }}</p>
          @endif
        @endforeach
      @else
        <p class="text-center text-muted py-4">
          {{ $pimpinan->nama }} menjabat sebagai {{ $pimpinan->jabatan }} di Universitas Ibnu Sina (UIS) Batam.
        </p>
      @endif
    </div>

    {{-- Navigasi Pimpinan Lainnya --}}
    @if($otherPimpinans->isNotEmpty())
      <div class="mx-auto mt-5 pt-4 border-top" style="max-width: 960px;" data-aos="fade-up">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="fw-bold mb-0" style="color: #0b2e19;">
            <i class="bi bi-people-fill text-success me-2"></i>Profil Pimpinan Universitas Ibnu Sina Lainnya
          </h5>
          <a href="{{ route('homepage.struktur-organisasi') }}" class="small fw-bold text-success text-decoration-none">
            Lihat Semua <i class="bi bi-arrow-right"></i>
          </a>
        </div>
        <div class="row g-3">
          @foreach($otherPimpinans as $item)
            <div class="col-lg-4 col-md-6">
              <a href="{{ route('homepage.pimpinan.detail', $item->slug) }}" class="other-pimpinan-card">
                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}">
                <div>
                  <div class="fw-bold small mb-1" style="line-height: 1.3;">{{ $item->nama }}</div>
                  <div class="text-muted" style="font-size: 11.5px; line-height: 1.35;">{{ $item->jabatan }}</div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</section>
@endsection

@push('scripts')
<script>
  function switchPimpinanPhoto(url, btn) {
    const img = document.getElementById('mainPimpinanPhoto');
    if (img) img.src = url;
    document.querySelectorAll('.pimpinan-thumb-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
  }
</script>
@endpush

