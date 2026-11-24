@extends('layouts.frontend.template')

@section('title', $item->judul . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
@php
  $pageKeyAkademik = match($item->tipe ?? '') {
      'kalender' => 'kalender-akademik',
      'pedoman' => 'pedoman-akademik',
      'sistem' => 'sistem-akademik',
      default => 'kurikulum'
  };
@endphp

@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => $pageKeyAkademik,
    'heroClass' => 'akademik-hero',
    'defaultTitle' => $item->judul ?? 'Layanan Akademik',
    'defaultSubtitle' => $item->subjudul ?? null,
    'defaultActive' => $pageTitle ?? 'Akademik'
])

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="row g-4">
      
      {{-- Kolom Konten Utama --}}
      <div class="col-lg-8" data-aos="fade-up">
        <div class="akademik-card">
          
          {{-- Banner Gambar jika ada --}}
          @if($item->gambar)
            <div class="mb-4 rounded-4 overflow-hidden shadow-sm">
              <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-100 img-fluid" style="max-height: 420px; object-fit: cover;">
            </div>
          @endif

          {{-- Dokumen Unduhan (PDF dll) --}}
          @if($item->file_dokumen)
            <div class="doc-download-box d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
              <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-white shadow-sm text-danger fs-3">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <div>
                  <h6 class="fw-bold text-dark mb-1">{{ $item->file_nama ?: 'Dokumen ' . $pageTitle }}</h6>
                  <div class="small text-muted">Klik tombol di samping untuk mengunduh dokumen resmi (PDF).</div>
                </div>
              </div>
              <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 22px; white-space: nowrap;">
                <i class="bi bi-download"></i> Unduh File PDF
              </a>
            </div>
          @endif

          {{-- Portal Link Eksternal (SIAKAD dll) --}}
          @if(!empty($item->link_url))
            <div class="p-4 rounded-4 mb-4 text-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" style="background: #032e12; border: 1px solid #046B26;">
              <div>
                <h5 class="fw-bold text-white mb-1"><i class="bi bi-laptop me-2" style="color: #FED802;"></i>Akses Langsung Sistem Online</h5>
                <p class="text-white-50 small mb-0">Klik tombol untuk masuk ke portal sistem resmi Universitas Ibnu Sina.</p>
              </div>
              <a href="{{ $item->link_url }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 24px; white-space: nowrap;">
                Buka Portal <i class="bi bi-box-arrow-up-right ms-1"></i>
              </a>
            </div>
          @endif

          {{-- Isi Teks Deskripsi --}}
          <div class="article-content" style="font-size: 15.5px; line-height: 1.8; color: #2d3748;">
            {!! $item->deskripsi !!}
          </div>

        </div>
      </div>

      {{-- Kolom Sidebar Navigasi Akademik --}}
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Widget Menu Akademik Lainnya --}}
        <div class="nav-akademik-sidebar mb-4">
          <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
            <i class="bi bi-mortarboard-fill text-primary me-2"></i>Menu Akademik
          </h6>
          <nav class="d-flex flex-column">
            <a href="{{ route('homepage.kurikulum') }}" class="nav-akademik-link {{ request()->routeIs('homepage.kurikulum') ? 'active' : '' }}">
              <i class="bi bi-journal-text"></i> Kurikulum
            </a>
            <a href="{{ route('homepage.kalender-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.kalender-akademik') ? 'active' : '' }}">
              <i class="bi bi-calendar-check"></i> Kalender Akademik
            </a>
            <a href="{{ route('homepage.pedoman-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.pedoman-akademik') ? 'active' : '' }}">
              <i class="bi bi-book"></i> Pedoman Akademik
            </a>
            <a href="{{ route('homepage.sistem-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.sistem-akademik') ? 'active' : '' }}">
              <i class="bi bi-laptop"></i> Sistem Akademik
            </a>
          </nav>
        </div>

        {{-- Widget Kontak / PMB --}}
        <div class="p-4 rounded-4 text-white" style="background: #032e12; border: 1px solid #046B26;">
          <div class="badge px-3 py-1 rounded-pill mb-2" style="background: #FED802; color: #046B26; font-weight: 800; font-size: 11px;">
            INFORMASI PMB
          </div>
          <h5 class="fw-bold text-white mb-2">Butuh Bantuan Akademik?</h5>
          <p class="text-white-50 small mb-3">
            Hubungi Bagian Tata Usaha & Layanan Akademik Universitas Ibnu Sina untuk informasi lebih lanjut.
          </p>
          <a href="{{ route('homepage.kontak') }}" class="btn btn-outline-light w-100 rounded-3 fw-bold py-2" style="font-size: 13.5px;">
            <i class="bi bi-telephone me-1"></i> Hubungi Kami
          </a>
        </div>

      </div>

    </div>
  </div>
</section>
@endsection
