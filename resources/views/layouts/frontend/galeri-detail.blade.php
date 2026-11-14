@extends('layouts.frontend.template')

@php
  $isHumas = ($gallery->kategori ?? '') === 'humas';
  $newsCategory = $gallery->kategori_berita ?: ($gallery->news->category ?? ($isHumas ? 'Dokumentasi Humas' : 'Berita Universitas'));
@endphp

@section('title', ($gallery->judul ?? 'Dokumentasi Visual') . ($isHumas ? ' — Galeri Humas UIS' : ' — Galeri Universitas Ibnu Sina'))
@section('meta_description', Str::limit(strip_tags($gallery->deskripsi ?? $gallery->judul), 160))

@section('content')
<style>
  .gallery-main-showcase {
    position: relative;
    background: #0b1510;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    min-height: 380px;
    max-height: 520px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .gallery-main-showcase img {
    max-height: 520px;
    width: 100%;
    object-fit: contain;
    transition: opacity 0.25s ease;
  }
  .gallery-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.55);
    color: #ffffff;
    border: 1.5px solid rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 5;
    text-decoration: none;
  }
  .gallery-nav-btn:hover {
    background: #046B26;
    color: #FED802;
    transform: translateY(-50%) scale(1.1);
  }
  .gallery-nav-btn.prev-btn { left: 16px; }
  .gallery-nav-btn.next-btn { right: 16px; }

  .gallery-thumb-card {
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.25s ease;
    background: #032e12;
    height: 100px;
  }
  .gallery-thumb-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  .gallery-thumb-card:hover img {
    transform: scale(1.08);
  }
  .gallery-thumb-card:hover {
    border-color: #FED802;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.2);
  }
  .gallery-thumb-card.active {
    border-color: #FED802;
    box-shadow: 0 0 0 2px #046B26;
  }
  .gallery-thumb-card .thumb-idx-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.75);
    color: #FED802;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 10px;
  }
</style>

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
      <span class="badge px-3 py-2 rounded-pill font-weight-bold" style="background: rgba(254, 216, 2, 0.2); border: 1.5px solid #FED802; color: #FED802; font-size: 12.5px;">
        <i class="bi bi-tag-fill me-1"></i> {{ $newsCategory }}
      </span>
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

      <!-- Kolom Kiri: Foto Utama & Multi-Foto Galeri (col-lg-8) -->
      <div class="col-lg-8" data-aos="fade-up">
        
        @php
          $albumPhotos = [];
          if (!empty($gallery->news) && is_array($gallery->news->gallery)) {
              if (!empty($gallery->news->thumbnail)) {
                  $albumPhotos[] = $gallery->news->thumbnail;
              }
              foreach ($gallery->news->gallery as $gp) {
                  if (!empty($gp) && !in_array($gp, $albumPhotos, true)) {
                      $albumPhotos[] = $gp;
                  }
              }
          }
          if (empty($albumPhotos) && is_array($gallery->galeri)) {
              $albumPhotos = $gallery->galeri;
          }
          if (!empty($gallery->url) && !in_array($gallery->url, $albumPhotos, true)) {
              array_unshift($albumPhotos, $gallery->url);
          }
          $totalPhotos = count($albumPhotos);
          $mainPhoto = $albumPhotos[0] ?? $gallery->url;
        @endphp

        <!-- Main Photo Viewer -->
        @if(!empty($mainPhoto))
          <div class="gallery-main-showcase mb-3">
            <img id="mainGalleryImg" src="{{ asset('storage/' . $mainPhoto) }}" alt="{{ $gallery->judul ?? 'Dokumentasi UIS' }}" class="img-fluid">
            
            {{-- Counter Pill --}}
            <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm" style="background: rgba(2, 56, 20, 0.88); backdrop-filter: blur(6px); color: #FED802; font-weight: 700; font-size: 12px; z-index: 4;">
              <i class="bi bi-camera-fill me-1"></i> Foto <span id="currentPhotoIdx">1</span> dari {{ $totalPhotos }}
            </span>

            {{-- Prev & Next Navigation Buttons --}}
            @if($totalPhotos > 1)
              <button type="button" class="gallery-nav-btn prev-btn" onclick="prevGalleryPhoto()" title="Foto Sebelumnya">
                <i class="bi bi-chevron-left"></i>
              </button>
              <button type="button" class="gallery-nav-btn next-btn" onclick="nextGalleryPhoto()" title="Foto Selanjutnya">
                <i class="bi bi-chevron-right"></i>
              </button>
            @endif

            {{-- Fullscreen button --}}
            <a id="mainGalleryFullLink" href="{{ asset('storage/' . $mainPhoto) }}" target="_blank" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-3 rounded-pill px-3 shadow" style="font-size: 12px; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); z-index: 4;">
              <i class="bi bi-arrows-fullscreen me-1"></i> Buka Ukuran Penuh
            </a>
          </div>
        @else
          <div class="p-5 rounded-4 text-center text-white mb-4 shadow-sm" style="background: #046B26;">
            <i class="bi bi-camera-fill" style="font-size: 64px; color: #FED802;"></i>
            <h4 class="fw-bold mt-2 mb-0">{{ $isHumas ? 'Dokumentasi Humas UIS' : 'Dokumentasi Universitas Ibnu Sina' }}</h4>
          </div>
        @endif

        <!-- Koleksi Semua Foto Galeri (Thumbnail Grid) -->
        @if($totalPhotos > 1)
          <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
              <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-grid-3x3-gap-fill text-success"></i> Semua Koleksi Foto Berita ({{ $totalPhotos }} Foto)
              </h5>
              <span class="badge bg-light text-secondary border fw-normal px-3 py-1" style="font-size: 12px;">
                <i class="bi bi-hand-index-thumb me-1"></i> Klik foto untuk melihat
              </span>
            </div>
            
            <div class="row g-2 g-md-3">
              @foreach($albumPhotos as $idx => $photo)
                <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                  <div class="gallery-thumb-card {{ $idx === 0 ? 'active' : '' }}" onclick="switchGalleryPhoto({{ $idx }})" title="Lihat Foto {{ $idx + 1 }}">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto {{ $idx + 1 }}" loading="lazy">
                    <span class="thumb-idx-badge">#{{ $idx + 1 }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- Card Banner Tautan ke Berita Lengkap (Jika Berasal dari Berita) -->
        @if(!empty($gallery->news) || !empty($gallery->news_id))
          @php
            $linkedNews = $gallery->news;
          @endphp
          @if($linkedNews)
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #023814 0%, #046B26 100%); color: #ffffff;">
              <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background: #FED802; color: #023814; font-size: 24px; flex-shrink: 0;">
                    <i class="bi bi-newspaper"></i>
                  </div>
                  <div>
                    <span class="badge mb-1 px-3 py-1 rounded-pill" style="background: rgba(254, 216, 2, 0.25); color: #FED802; border: 1px solid #FED802; font-size: 11.5px;">
                      <i class="bi bi-tag-fill me-1"></i>{{ $linkedNews->category ?: 'Berita Terkait' }}
                    </span>
                    <h5 class="fw-bold text-white mb-1" style="font-size: 17px;">{{ $linkedNews->title }}</h5>
                    <p class="text-white-50 small mb-0">Galeri foto ini merupakan dokumentasi visual dari liputan berita resmi ini.</p>
                  </div>
                </div>
                <a href="{{ route('homepage.news.detail', $linkedNews->slug ?: $linkedNews->id) }}" class="btn rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: #FED802; color: #023814; border: none; white-space: nowrap;">
                  <i class="bi bi-book-half me-1"></i> Baca Berita Lengkap
                </a>
              </div>
            </div>
          @endif
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
              {!! nl2br(e(trim(html_entity_decode(strip_tags($gallery->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8')))) !!}
            </div>
          @elseif(!empty($gallery->news) && !empty($gallery->news->content))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! Str::limit(strip_tags($gallery->news->content), 350) !!}
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
              <span class="badge rounded-pill px-3 py-1" style="background: #eaf7ee; color: #046B26; border: 1px solid #b7e4c7; font-size: 12px;">
                <i class="bi bi-tag-fill me-1"></i>{{ $newsCategory }}
              </span>
            </span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label">Jumlah Foto</span>
            <span class="info-meta-val text-dark fw-bold">
              <i class="bi bi-images me-1 text-success"></i>{{ $totalPhotos }} Foto Tersedia
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

          @if(!empty($gallery->news) || !empty($gallery->news_id))
            @php $nRef = $gallery->news; @endphp
            @if($nRef)
              <div class="info-meta-row">
                <span class="info-meta-label">Sumber Berita</span>
                <span class="info-meta-val">
                  <a href="{{ route('homepage.news.detail', $nRef->slug ?: $nRef->id) }}" class="text-decoration-none fw-bold small text-success">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Berita
                  </a>
                </span>
              </div>
            @endif
          @endif
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

@push('scripts')
<script>
  (function() {
    const photoUrls = @json(array_values(array_map(fn($p) => asset('storage/' . $p), $albumPhotos)));
    let currentIndex = 0;

    window.switchGalleryPhoto = function(index) {
      if (index < 0 || index >= photoUrls.length) return;
      currentIndex = index;

      const mainImg = document.getElementById('mainGalleryImg');
      const fullLink = document.getElementById('mainGalleryFullLink');
      const idxBadge = document.getElementById('currentPhotoIdx');

      if (mainImg) {
        mainImg.style.opacity = '0.3';
        setTimeout(() => {
          mainImg.src = photoUrls[currentIndex];
          mainImg.style.opacity = '1';
        }, 120);
      }
      if (fullLink) {
        fullLink.href = photoUrls[currentIndex];
      }
      if (idxBadge) {
        idxBadge.innerText = (currentIndex + 1);
      }

      document.querySelectorAll('.gallery-thumb-card').forEach((el, i) => {
        if (i === currentIndex) {
          el.classList.add('active');
        } else {
          el.classList.remove('active');
        }
      });
    };

    window.nextGalleryPhoto = function() {
      let nextIdx = (currentIndex + 1) % photoUrls.length;
      window.switchGalleryPhoto(nextIdx);
    };

    window.prevGalleryPhoto = function() {
      let prevIdx = (currentIndex - 1 + photoUrls.length) % photoUrls.length;
      window.switchGalleryPhoto(prevIdx);
    };

    document.addEventListener('keydown', function(e) {
      if (e.key === 'ArrowRight') {
        window.nextGalleryPhoto();
      } else if (e.key === 'ArrowLeft') {
        window.prevGalleryPhoto();
      }
    });
  })();
</script>
@endpush
