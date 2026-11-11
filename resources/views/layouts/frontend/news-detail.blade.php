@extends('layouts.frontend.template')

@section('title', $news->title . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit($news->description ?? strip_tags($news->content), 160))
@section('meta_keywords', 'berita uis, universitas ibnu sina, ' . ($news->category ?? 'artikel kesehatan'))
@section('meta_author', $news->user?->name ?? 'Admin UIS')

@php
  $ogImage = !empty($news->thumbnail) ? asset('storage/' . $news->thumbnail) : asset('assets/img/logouis.png');
  $ogWidth = '1200';
  $ogHeight = '630';
  $ogType = 'image/jpeg';
  if (!empty($news->thumbnail)) {
      $localThumbPath = storage_path('app/public/' . $news->thumbnail);
      if (file_exists($localThumbPath)) {
          $imgInfo = @getimagesize($localThumbPath);
          if ($imgInfo) {
              $ogWidth = (string) $imgInfo[0];
              $ogHeight = (string) $imgInfo[1];
              $ogType = $imgInfo['mime'] ?? 'image/jpeg';
          }
      }
  }
@endphp

{{-- Open Graph & Social Share Preview Meta Data --}}
@section('og_type', 'article')
@section('og_title', $news->title)
@section('og_description', Str::limit($news->description ?? strip_tags($news->content), 160))
@section('og_image', $ogImage)
@section('og_image_width', $ogWidth)
@section('og_image_height', $ogHeight)
@section('og_image_type', $ogType)

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO / TITLE BANNER
═══════════════════════════════════════════════ -->
<div class="article-hero">
  <div class="container">
    <div data-aos="fade-up">
      <div class="article-meta-badge">
        <i class="bi bi-tag-fill"></i>
        <span>{{ $news->category ?? 'Berita Universitas' }}</span>
      </div>
      <h1 class="article-title-main">{{ $news->title }}</h1>
      <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 small mb-3">
        <span><i class="bi bi-calendar3 me-1" style="color:var(--uis-orange);"></i> {{ ($news->published_at ?? $news->created_at)->translatedFormat('d F Y • H:i') }} WIB</span>
        <span>•</span>
        <span><i class="bi bi-person me-1" style="color:var(--uis-orange);"></i> {{ $news->user?->name ?? 'Redaksi Universitas Ibnu Sina' }}</span>
        <span>•</span>
        <span><i class="bi bi-clock me-1" style="color:var(--uis-orange);"></i> {{ ceil(str_word_count(strip_tags($news->content ?? '')) / 200) ?: 1 }} menit baca</span>
      </div>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.news') }}">Berita</a>
        <span>/</span>
        <span class="active">{{ Str::limit($news->title, 35) }}</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     ARTICLE CONTENT & GALLERY
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="row g-5">

      <!-- Kolom Konten Berita -->
      <div class="col-lg-8" data-aos="fade-right">
        <div class="article-main-card">

          {{-- Thumbnail Utama --}}
          @if($news->thumbnail)
            <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="article-main-thumb">
          @else
            <div class="article-main-thumb d-flex align-items-center justify-content-center rounded-4 mb-4" style="height: 320px; background-color: #e2e8f0; color: #64748b;">
              <i class="bi bi-image" style="font-size: 4rem;"></i>
            </div>
          @endif

          {{-- Isi Berita --}}
          <div class="article-typography">
            {!! $news->content !!}
          </div>

          {{-- DOKUMENTASI GALERI FOTO BERITA (JIKA ADA) --}}
          @if(!empty($news->gallery) && is_array($news->gallery) && count($news->gallery) > 0)
            @php
              $photoCount = count($news->gallery);
              $gridClass = $photoCount === 1 ? 'gallery-grid-1' : ($photoCount === 2 ? 'gallery-grid-2' : 'gallery-grid-3');
            @endphp
            <div class="gallery-section-box">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0 text-dark">
                  <i class="bi bi-images me-2" style="color:var(--uis-purple);"></i>Dokumentasi Foto Kegiatan ({{ $photoCount }} Foto)
                </h5>
                <span class="badge" style="background: var(--uis-orange); color:#032e12;">Galeri Foto</span>
              </div>
              <p class="text-muted small mb-3">Klik gambar untuk melihat tampilan resolusi penuh.</p>

              <div class="gallery-grid-dynamic {{ $gridClass }}">
                @foreach($news->gallery as $gIndex => $photoPath)
                  <div class="gallery-item-wrap" onclick="showImageModal('{{ asset('storage/' . $photoPath) }}')">
                    <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto Dokumentasi #{{ $gIndex + 1 }}">
                    <div class="gallery-item-overlay">
                      <i class="bi bi-zoom-in"></i>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Author Card --}}
          <div class="author-box">
            <div class="author-avatar">{{ strtoupper(substr($news->user?->name ?? 'A', 0, 1)) }}</div>
            <div>
              <div class="small text-muted">Diterbitkan oleh:</div>
              <div class="fw-bold text-dark">{{ $news->user?->name ?? 'Redaksi Universitas Ibnu Sina' }}</div>
              <div class="small text-muted">Universitas Ibnu Sina — Universitas Ibnu Sina</div>
            </div>
          </div>

          {{-- Share & Back --}}
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 mt-4 border-top">
            <a href="{{ route('homepage.news') }}" class="btn-outline-hero" style="color:var(--uis-purple); border-color:var(--uis-purple); font-size:13px; padding:8px 18px;">
              <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
            </a>
            <div class="d-flex align-items-center gap-2">
              <span class="small fw-semibold text-muted">Bagikan:</span>
              <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-whatsapp"></i>
              </a>
              <button onclick="copyCurrentUrl()" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;" title="Salin Tautan">
                <i class="bi bi-link-45deg"></i>
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4" data-aos="fade-left">

        {{-- Ringkasan --}}
        <div class="sidebar-box">
          <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-info-circle me-2" style="color:var(--uis-purple);"></i>Sekilas Berita</h5>
          <p class="text-muted small mb-0" style="line-height:1.7;">
            {{ $news->description ?? Str::limit(strip_tags($news->content), 180) }}
          </p>
        </div>

        {{-- Berita Terkait --}}
        @if(isset($relatedNews) && $relatedNews->count() > 0)
          <div class="sidebar-box">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-newspaper me-2" style="color:var(--uis-orange);"></i>Berita Lainnya</h5>
            <div class="d-flex flex-column gap-3">
              @foreach($relatedNews as $related)
                <a href="{{ route('homepage.news.detail', $related->slug ?? $related->id) }}" class="d-flex gap-3 text-decoration-none text-dark group-hover">
                  @if($related->thumbnail)
                    <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->title }}" class="related-thumb">
                  @else
                    <div class="related-thumb border d-flex align-items-center justify-content-center" style="background-color: #e2e8f0; color: #64748b;">
                      <i class="bi bi-image"></i>
                    </div>
                  @endif
                  <div>
                    <h6 class="fw-bold mb-1 small text-dark" style="line-height:1.4;">{{ Str::limit($related->title, 55) }}</h6>
                    <span class="text-muted" style="font-size:11px;"><i class="bi bi-calendar3 me-1"></i>{{ $related->created_at->format('d M Y') }}</span>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Widget Kategori Berita --}}
        <div class="sidebar-box">
          <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-grid-fill me-2" style="color:var(--uis-purple);"></i>Kategori Berita
          </h5>
          <div class="category-widget-list">
            @php
              $allCategories = [
                'Berita Universitas'      => 'bi-newspaper',
                'Berita Humas'            => 'bi-megaphone-fill',
                'Prestasi Mahasiswa'      => 'bi-trophy-fill',
                'Akademik & Kemahasiswaan'=> 'bi-mortarboard',
                'Teknologi & Rekayasa'    => 'bi-cpu',
                'Bisnis & Manajemen'      => 'bi-briefcase',
                'K3 & Lingkungan Industri'=> 'bi-shield-check',
                'Penelitian & Riset'      => 'bi-journal-medical',
                'Pengabdian Masyarakat'   => 'bi-people',
                'Kerjasama Industri'      => 'bi-building',
                'Pengumuman & Agenda'     => 'bi-megaphone',
              ];
              $counts = isset($categories) ? $categories->pluck('total', 'category')->toArray() : [];
            @endphp

            @foreach($allCategories as $catName => $icon)
              @php $count = $counts[$catName] ?? 0; @endphp
              <a href="{{ route('homepage.news', ['category' => $catName]) }}" class="category-widget-link {{ ($news->category ?? '') === $catName ? 'active' : '' }}">
                <div class="d-flex align-items-center gap-2">
                  <i class="bi {{ $icon }} cat-icon"></i>
                  <span>{{ $catName }}</span>
                </div>
                <span class="cat-count-badge">{{ $count }}</span>
              </a>
            @endforeach
          </div>
        </div>

        {{-- Banner PMB Mini --}}
        <div class="sidebar-box text-white" style="background: var(--obsidian-dark); border: 2px solid var(--uis-green);">
          <span class="badge mb-2" style="background: var(--uis-yellow); color:#032e12; font-weight:800;">PMB 2026/2027</span>
          <h5 class="fw-bold mb-2">Ingin Kuliah di Universitas Ibnu Sina?</h5>
          <p class="text-white-50 small mb-3">Tersedia Fakultas Teknik, Fakultas Ekonomi & Bisnis, Fakultas Ilmu Kesehatan, dan Program Pascasarjana (S2).</p>
          <a href="{{ route('homepage.kontak') }}" class="btn-primary-hero w-100 justify-content-center" style="font-size:13px; padding:9px 14px;">
            Daftar Sekarang <i class="bi bi-arrow-right"></i>
          </a>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- Modal Lightbox Galeri Foto -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 text-center position-relative">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <img id="modalImg" src="" class="img-fluid rounded shadow-lg" style="max-height:85vh; object-fit:contain;">
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function showImageModal(src) {
    document.getElementById('modalImg').src = src;
    var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
    myModal.show();
  }

  function copyCurrentUrl() {
    navigator.clipboard.writeText(window.location.href);
    alert('Tautan berita berhasil disalin ke clipboard!');
  }

  /* Susun Otomatis Gambar di Dalam Teks Artikel Menjadi Grid Rapi */
  document.addEventListener('DOMContentLoaded', function() {
    const typography = document.querySelector('.article-typography');
    if (!typography) return;

    const children = Array.from(typography.children);
    let currentGroup = [];

    function processGroup(group) {
      if (group.length === 0) return;

      let imgs = [];
      group.forEach(el => {
        if (el.tagName === 'IMG') {
          imgs.push(el);
        } else {
          imgs.push(...el.querySelectorAll('img'));
        }
      });

      if (imgs.length === 0) return;

      if (imgs.length === 1) {
        // 1 Gambar: Tampil Penuh (100% Full Width)
        const wrap = document.createElement('div');
        wrap.className = 'content-image-single';
        const singleImg = document.createElement('img');
        singleImg.src = imgs[0].src;
        singleImg.alt = imgs[0].alt || 'Gambar Berita';
        singleImg.setAttribute('onclick', `showImageModal('${imgs[0].src}')`);
        singleImg.style.cursor = 'zoom-in';
        wrap.appendChild(singleImg);
        group[0].replaceWith(wrap);
        for (let i = 1; i < group.length; i++) group[i].remove();
        return;
      }

      // Jika 2 gambar = 2 kolom (50% - 50%)
      // Jika 3 gambar = 3 kolom (kiri, tengah, kanan)
      // Jika 4+ gambar = grid 3 kolom per baris
      const colCount = Math.min(imgs.length, 3);
      const grid = document.createElement('div');
      grid.className = `content-image-grid content-image-grid-${colCount}`;

      imgs.forEach((img, idx) => {
        const item = document.createElement('div');
        item.className = 'content-image-item';
        const newImg = document.createElement('img');
        newImg.src = img.src;
        newImg.alt = img.alt || `Gambar Dokumentasi ${idx + 1}`;
        newImg.setAttribute('onclick', `showImageModal('${img.src}')`);
        item.appendChild(newImg);
        grid.appendChild(item);
      });

      group[0].replaceWith(grid);
      for (let i = 1; i < group.length; i++) {
        group[i].remove();
      }
    }

    children.forEach(el => {
      // Cek apakah elemen hanya berupa gambar atau paragraf kosong yang berisi gambar
      const hasImg = el.querySelector('img') || el.tagName === 'IMG';
      const textOnly = el.textContent.replace(/\u00a0/g, ' ').trim();

      if (hasImg && textOnly === '') {
        currentGroup.push(el);
      } else {
        processGroup(currentGroup);
        currentGroup = [];
      }
    });

    processGroup(currentGroup);
  });
</script>
@endpush
