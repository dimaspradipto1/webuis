@extends('layouts.frontend.template')

@php
  $isHumas = ($gallery->kategori ?? '') === 'humas';
@endphp

@section('title', ($gallery->judul ?? 'Dokumentasi Visual') . ($isHumas ? ' — Galeri Humas UIS' : ' — Galeri Universitas Ibnu Sina'))
@section('meta_description', Str::limit(strip_tags($gallery->deskripsi ?? $gallery->judul), 160))

@section('content')
<!-- Header Hero -->
<div class="detail-hero text-white" style="{{ $isHumas ? 'background: linear-gradient(135deg, #022e11 0%, #034b1c 55%, #046B26 100%); border-bottom: 2px solid #FED802;' : '' }}">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      @if($isHumas)
        <a href="{{ route('homepage.humas') }}">Humas</a>
        <span>/</span>
        <a href="{{ route('homepage.galeri.humas') }}">Galeri Humas</a>
      @else
        <a href="{{ route('homepage.galeri') }}">Galeri Dokumentasi</a>
      @endif
      <span>/</span>
      <span class="active">{{ Str::limit($gallery->judul ?? 'Detail Dokumentasi', 40) }}</span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
      @if($isHumas)
        <span class="badge px-3 py-2 rounded-pill font-weight-bold" style="background: rgba(254, 216, 2, 0.2); border: 1.5px solid #FED802; color: #FED802; font-size: 12.5px;">
          <i class="bi bi-megaphone-fill me-1"></i> Dokumentasi Humas
        </span>
      @else
        <span class="badge px-3 py-2 rounded-pill font-weight-bold" style="background: var(--uis-purple); color: white; font-size: 12.5px;">
          <i class="bi bi-camera-fill me-1"></i> Dokumentasi Visual
        </span>
      @endif
      <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 12px;">
        <i class="bi bi-calendar3 me-1"></i> {{ $gallery->created_at->translatedFormat('d F Y') }}
      </span>
    </div>
    <h1 class="fw-bold mb-0 text-white" style="font-size: 32px; line-height: 1.35; letter-spacing: -0.5px;">
      {{ $gallery->judul ?? ($isHumas ? 'Dokumentasi Kegiatan Humas UIS' : 'Dokumentasi Kegiatan Universitas Ibnu Sina') }}
    </h1>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">

      <!-- Kolom Kiri: Foto Utama & Deskripsi Rinci (col-lg-8) -->
      <div class="col-lg-8" data-aos="fade-up">
        
        <!-- Foto Dokumentasi Utama & Multi-Foto Galeri -->
        @php
          $albumPhotos = is_array($gallery->galeri) ? $gallery->galeri : [];
          if (!empty($gallery->url) && !in_array($gallery->url, $albumPhotos, true)) {
              array_unshift($albumPhotos, $gallery->url);
          }
          $mainPhoto = $gallery->url ?: ($albumPhotos[0] ?? null);
        @endphp

        @if(!empty($mainPhoto))
          <div class="mb-3 text-center position-relative rounded-4 overflow-hidden shadow-sm border bg-white" style="background: #000;">
            <img id="mainGalleryImg" src="{{ asset('storage/' . $mainPhoto) }}" alt="{{ $gallery->judul ?? 'Dokumentasi UIS' }}" class="galeri-img-main img-fluid">
            <a id="mainGalleryFullLink" href="{{ asset('storage/' . $mainPhoto) }}" target="_blank" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-3 rounded-pill px-3 shadow" style="font-size: 12px; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2);">
              <i class="bi bi-arrows-fullscreen me-1"></i> Buka Ukuran Penuh
            </a>
          </div>

          @if(count($albumPhotos) > 1)
            <div class="bg-white p-3 rounded-4 shadow-sm border mb-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-dark"><i class="bi bi-images text-success me-1"></i> Koleksi Foto Dokumentasi ({{ count($albumPhotos) }} Foto)</span>
                <span class="text-muted" style="font-size: 11.5px;">Klik foto untuk memperbesar</span>
              </div>
              <div class="row g-2">
                @foreach($albumPhotos as $idx => $photoPath)
                  <div class="col-4 col-sm-3 col-md-2">
                    <button type="button"
                            onclick="switchGalleryMainPhoto('{{ asset('storage/' . $photoPath) }}', this)"
                            class="p-0 border-2 rounded-3 overflow-hidden w-100 bg-transparent gallery-thumb-btn {{ $photoPath === $mainPhoto ? 'border-success' : 'border-transparent' }}"
                            style="height: 68px; cursor: pointer;">
                      <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto {{ $idx + 1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </button>
                  </div>
                @endforeach
              </div>
            </div>
            <script>
              function switchGalleryMainPhoto(src, btn) {
                document.getElementById('mainGalleryImg').src = src;
                document.getElementById('mainGalleryFullLink').href = src;
                document.querySelectorAll('.gallery-thumb-btn').forEach(el => {
                  el.classList.remove('border-success');
                  el.classList.add('border-transparent');
                });
                btn.classList.remove('border-transparent');
                btn.classList.add('border-success');
              }
            </script>
          @endif
        @else
          <div class="p-5 rounded-4 text-center text-white mb-4 shadow-sm" style="background: #046B26;">
            <i class="bi bi-camera-fill" style="font-size: 64px; color: #FED802;"></i>
            <h4 class="fw-bold mt-2 mb-0">{{ $isHumas ? 'Dokumentasi Humas UIS' : 'Dokumentasi Universitas Ibnu Sina' }}</h4>
          </div>
        @endif

        <!-- Card Deskripsi Lengkap -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $isHumas ? '#eaf7ee' : '#f3e8ff' }}; color: {{ $isHumas ? '#046B26' : 'var(--uis-purple)' }}; display: flex; align-items: center; justify-content: center; font-size: 18px;">
              <i class="bi bi-info-circle-fill"></i>
            </div>
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 21px;">Keterangan & Informasi Kegiatan</h3>
          </div>
          <div class="divider-line mb-4" style="{{ $isHumas ? 'background: #046B26;' : '' }}"></div>

          @if(!empty($gallery->deskripsi))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! nl2br(e($gallery->deskripsi)) !!}
            </div>
          @else
            <p class="text-muted mb-0">
              Dokumentasi visual kegiatan dan publikasi resmi {{ $isHumas ? 'kehumasan' : 'sivitas akademika' }} Universitas Ibnu Sina (UIS).
            </p>
          @endif

          <!-- Footer Card: Back button & Share buttons -->
          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
            @if($isHumas)
              <a href="{{ route('homepage.galeri.humas') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold" style="font-size: 13.5px; border-width: 1.5px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Galeri Humas
              </a>
            @else
              <a href="{{ route('homepage.galeri') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" style="font-size: 13.5px; border-width: 1.5px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Semua Galeri
              </a>
            @endif

            @php
              $shareUrl  = urlencode(url()->current());
              $shareText = urlencode(($isHumas ? 'Dokumentasi Humas UIS: ' : 'Dokumentasi UIS: ') . ($gallery->judul ?? 'Dokumentasi Visual'));
            @endphp
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small fw-semibold">Bagikan:</span>
              <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="btn btn-sm btn-success rounded-circle shadow-sm" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:#25D366;border-color:#25D366;" title="Bagikan ke WhatsApp">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="btn btn-sm btn-primary rounded-circle shadow-sm" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:#1877F2;border-color:#1877F2;" title="Bagikan ke Facebook">
                <i class="bi bi-facebook"></i>
              </a>
              <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan dokumentasi berhasil disalin!');" class="btn btn-sm btn-secondary rounded-circle shadow-sm" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;" title="Salin Tautan">
                <i class="bi bi-link-45deg"></i>
              </button>
            </div>
          </div>
        </div>

      </div><!-- End col-lg-8 -->

      <!-- Kolom Kanan: Info Metadata & Galeri Lainnya (col-lg-4) -->
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">

        <!-- Card Informasi Metadata -->
        <div class="info-badge-card mb-4">
          <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <div style="width: 34px; height: 34px; border-radius: 10px; background: {{ $isHumas ? '#eaf7ee' : '#f3e8ff' }}; color: {{ $isHumas ? '#046B26' : 'var(--uis-purple)' }}; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="bi bi-camera-reels-fill"></i>
            </div>
            <h5 class="fw-bold mb-0 text-dark" style="font-size: 16.5px;">Informasi Dokumentasi</h5>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label">Kategori</span>
            <span class="info-meta-val">
              @if($isHumas)
                <span class="badge rounded-pill px-3 py-1" style="background: #eaf7ee; color: #046B26; border: 1px solid #b7e4c7; font-size: 12px;">
                  <i class="bi bi-megaphone-fill me-1"></i>Humas
                </span>
              @else
                <span class="badge rounded-pill px-3 py-1" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 12px;">
                  <i class="bi bi-building me-1"></i>Universitas
                </span>
              @endif
            </span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label">Unit Penerbit</span>
            <span class="info-meta-val text-dark">{{ $isHumas ? 'Biro Humas & Promosi' : 'Universitas Ibnu Sina' }}</span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label">Tanggal Terbit</span>
            <span class="info-meta-val text-dark"><i class="bi bi-calendar-event me-1 text-muted"></i>{{ $gallery->created_at->translatedFormat('d F Y') }}</span>
          </div>
        </div>

        <!-- Card Galeri Lainnya -->
        @if(isset($otherGalleries) && $otherGalleries->count() > 0)
          <div class="info-badge-card">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
              <div class="d-flex align-items-center gap-2">
                <div style="width: 34px; height: 34px; border-radius: 10px; background: {{ $isHumas ? '#eaf7ee' : '#f3e8ff' }}; color: {{ $isHumas ? '#046B26' : 'var(--uis-purple)' }}; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="bi bi-images"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark" style="font-size: 16.5px;">{{ $isHumas ? 'Dokumentasi Humas Lain' : 'Dokumentasi Lainnya' }}</h5>
              </div>
              <a href="{{ $isHumas ? route('homepage.galeri.humas') : route('homepage.galeri') }}" class="small fw-semibold text-decoration-none" style="font-size: 12.5px; color: {{ $isHumas ? '#046B26' : 'var(--uis-purple)' }};">Lihat Semua</a>
            </div>

            <div>
              @foreach($otherGalleries as $other)
                <a href="{{ route('homepage.galeri.detail', $other->slug ?? $other->id) }}" class="other-galeri-item">
                  @if(!empty($other->url))
                    <img src="{{ asset('storage/' . $other->url) }}" alt="{{ $other->judul }}" class="other-galeri-img">
                  @else
                    <div class="other-galeri-img d-flex align-items-center justify-content-center text-white" style="background: #046B26;">
                      <i class="bi bi-camera-fill small"></i>
                    </div>
                  @endif
                  <div class="d-flex flex-column justify-content-center">
                    <span class="other-galeri-title text-truncate-2" style="font-size: 13.5px; line-height: 1.4;">{{ Str::limit($other->judul, 48) }}</span>
                    <span class="text-muted small mt-1" style="font-size: 11.5px;">
                      <i class="bi bi-calendar3 me-1"></i>{{ $other->created_at->translatedFormat('d M Y') }}
                    </span>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif

      </div><!-- End col-lg-4 -->

    </div><!-- End row -->
  </div><!-- End container -->
</section>

@endsection
