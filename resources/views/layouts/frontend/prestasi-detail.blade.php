@extends('layouts.frontend.template')

@php
  $prestasiTitle = $prestasi->title ?? $prestasi->judul_prestasi ?? 'Prestasi Mahasiswa';
  $prestasiThumb = $prestasi->thumbnail ?? $prestasi->foto ?? null;
  $prestasiDesc  = $prestasi->content ?? $prestasi->description ?? $prestasi->deskripsi ?? '';
  $prestasiDate  = ($prestasi->published_at ?? $prestasi->created_at)?->format('d F Y, H:i') . ' WIB';
  $prestasiAuthor = $prestasi->user?->name ?? 'Admin UIS';
@endphp
@section('title', $prestasiTitle . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($prestasi->description ?? $prestasiDesc ?: $prestasiTitle), 160))

@section('content')
<!-- Header Hero -->
<div class="detail-hero text-white">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.prestasi') }}">Prestasi Mahasiswa</a>
      <span>/</span>
      <span class="active">{{ Str::limit($prestasiTitle, 35) }}</span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
        <i class="bi bi-trophy-fill me-1"></i>{{ $prestasi->category ?? 'Prestasi Mahasiswa' }}
      </span>
      <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
        <i class="bi bi-calendar3 me-1"></i>{{ $prestasiDate }}
      </span>
    </div>
    <h1 class="fw-bold mb-0 text-white" style="font-size: 32px; line-height: 1.4;">
      {{ $prestasiTitle }}
    </h1>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">

      <!-- Kolom Kiri: Foto Utama & Deskripsi Rinci -->
      <div class="col-lg-8" data-aos="fade-up">
        
        <!-- Foto / Dokumentasi Prestasi -->
        @if(!empty($prestasiThumb))
          <div class="mb-4 text-center">
            <img src="{{ asset('storage/' . $prestasiThumb) }}" alt="{{ $prestasiTitle }}" class="prestasi-img-main img-fluid rounded-4 shadow-sm">
          </div>
        @endif

        <!-- Card Deskripsi Lengkap -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
          <h3 class="fw-bold mb-3 text-dark" style="font-size: 22px;">
            <i class="bi bi-card-text text-primary me-2"></i>Ulasan & Rincian Prestasi
          </h3>
          <div class="divider-line mb-4"></div>

          @if(!empty($prestasiDesc))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! $prestasiDesc !!}
            </div>
          @else
            <p class="text-muted">
              Selamat dan sukses atas keberhasilan mahasiswa Universitas Ibnu Sina dalam meraih prestasi pada <strong>{{ $prestasiTitle }}</strong>.
            </p>
          @endif

          {{-- Galeri Foto Tambahan jika ada --}}
          @if(!empty($prestasi->gallery) && is_array($prestasi->gallery) && count($prestasi->gallery) > 0)
            <div class="mt-4 pt-4 border-top">
              <h5 class="fw-bold mb-3 text-dark" style="font-size: 17px;">
                <i class="bi bi-images text-primary me-2"></i>Galeri Dokumentasi
              </h5>
              <div class="row g-3">
                @foreach($prestasi->gallery as $galImg)
                  <div class="col-6 col-md-4">
                    <a href="{{ asset('storage/' . $galImg) }}" target="_blank" class="d-block rounded-3 overflow-hidden border shadow-sm">
                      <img src="{{ asset('storage/' . $galImg) }}" alt="Dokumentasi {{ $prestasiTitle }}" class="img-fluid w-100" style="height: 140px; object-fit: cover;">
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
            <a href="{{ route('homepage.prestasi') }}" class="btn btn-outline-secondary rounded-pill px-4" style="font-size: 13.5px;">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Prestasi
            </a>

            @php
              $shareUrl  = urlencode(url()->current());
              $shareText = urlencode("Prestasi Mahasiswa Universitas Ibnu Sina: " . $prestasiTitle);
            @endphp
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small fw-semibold">Bagikan:</span>
              <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="btn btn-sm btn-primary rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-facebook"></i>
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Kolom Kanan: Informasi Publikasi & Prestasi Lainnya -->
      <div class="col-lg-4" data-aos="fade-left">
        
        <!-- Info Box Publikasi Prestasi -->
        <div class="info-badge-card mb-4">
          <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-trophy-fill text-warning me-2"></i>Informasi Prestasi
          </h5>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-tag me-1"></i> Kategori</span>
            <span class="info-meta-val text-primary">{{ $prestasi->category ?? 'Prestasi Mahasiswa' }}</span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-calendar-event me-1"></i> Tanggal Publish</span>
            <span class="info-meta-val">{{ ($prestasi->published_at ?? $prestasi->created_at)?->format('d M Y') }}</span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-person me-1"></i> Dipublikasikan Oleh</span>
            <span class="info-meta-val">{{ $prestasiAuthor }}</span>
          </div>
        </div>

        <!-- Prestasi Lainnya Box -->
        @if(isset($otherPrestasis) && $otherPrestasis->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h5 class="fw-bold mb-3 text-dark">
              <i class="bi bi-trophy text-warning me-2"></i>Prestasi Lainnya
            </h5>
            <div class="d-flex flex-column">
              @foreach($otherPrestasis as $other)
                @php
                  $otherTitle = $other->title ?? $other->judul_prestasi ?? 'Prestasi Mahasiswa';
                  $otherThumb = $other->thumbnail ?? $other->foto ?? null;
                @endphp
                <a href="{{ route('homepage.prestasi.detail', $other->slug ?? $other->id) }}" class="other-prestasi-item">
                  @if(!empty($otherThumb))
                    <img src="{{ asset('storage/' . $otherThumb) }}" alt="{{ $otherTitle }}" class="other-prestasi-img">
                  @else
                    <div class="other-prestasi-img d-flex align-items-center justify-content-center" style="background: #e2e8f0; color: #64748b;">
                      <i class="bi bi-image"></i>
                    </div>
                  @endif
                  <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 13.5px; line-height: 1.4;">
                      {{ Str::limit($otherTitle, 55) }}
                    </h6>
                    <div class="text-muted" style="font-size: 11.5px;">
                      <i class="bi bi-calendar3 me-1"></i>{{ ($other->published_at ?? $other->created_at)?->format('d M Y') }}
                    </div>
                  </div>
                </a>
              @endforeach
            </div>

            <div class="mt-3 text-center pt-2 border-top">
              <a href="{{ route('homepage.prestasi') }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill" style="color: #046B26; border-color: #046B26;">
                Lihat Semua Prestasi
              </a>
            </div>
          </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endsection
