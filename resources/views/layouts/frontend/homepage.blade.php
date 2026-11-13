@extends('layouts.frontend.template')

@section('title', 'Universitas Ibnu Sina (UIS) — Unggul, Profesional & Berintegritas')
@section('meta_description', 'Portal Resmi Universitas Ibnu Sina (UIS) Batam — Mewujudkan Perguruan Tinggi Terkemuka Berdaya Saing Global, Inovatif, dan Berakhlak Mulia.')

@section('content')
{{-- Tata letak beranda (urutan & visibilitas section diatur dari Admin > Warna Header, Footer & Layout) --}}
<style id="uis-home-layout-style">
  #uisHomeLayout { display: flex; flex-direction: column; }
  #uisHomeLayout > section { width: 100%; }
@foreach(($tampilan->layout ?? []) as $sectionKey => $sectionRow)
  #uisHomeLayout > section#{{ $sectionKey }} { order: {{ (int) $sectionRow['order'] }};{{ empty($sectionRow['visible']) ? ' display: none !important;' : '' }} }
@endforeach
</style>
<div id="uisHomeLayout">
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact?->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<!-- ═══════════════════════════════════════════════
     1. HERO BANNER (FULL IMAGE PROMOTION)
═══════════════════════════════════════════════ -->
<section class="hero-slider-section p-0" id="hero-banner">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500" data-bs-pause="false" data-bs-wrap="true" data-bs-touch="true">
    
    @php
      $activeBanners = isset($banners) ? $banners->filter(fn($b) => !empty($b->url) || !empty($b->gambar)) : collect();
    @endphp

    @if($activeBanners->count() > 1)
      <div class="carousel-indicators">
        @foreach($activeBanners as $index => $banner)
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $loop->iteration }}"></button>
        @endforeach
      </div>
    @endif

    <div class="carousel-inner">
      @if($activeBanners->count() > 0)
        @foreach($activeBanners as $index => $banner)
          @php $imgPath = $banner->url ?? $banner->gambar; @endphp
          <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $banner->judul ?? 'Banner Promosi Universitas Ibnu Sina' }}" class="hero-banner-img">
          </div>
        @endforeach
      @else
        <div class="carousel-item active">
          <div class="hero-banner-img d-flex align-items-center justify-content-center" style="background: #032e12; min-height: 360px; color: #ffffff;">
            <div class="text-center p-4">
              <div class="mb-3">
                <i class="bi bi-megaphone fs-1" style="color: var(--uis-orange);"></i>
              </div>
              <h2 class="fw-bold mb-2" style="color: #ffffff; letter-spacing: -0.5px;">UNIVERSITAS IBNU SINA (UIS)</h2>
              <p class="text-white-50 small mb-0" style="max-width: 540px; margin: 0 auto;">
                Banner Promosi & Iklan Fakultas dapat diunggah melalui menu Admin (<strong>Profil & Konten UIS ➔ Banner Hero</strong>).
              </p>
            </div>
          </div>
        </div>
      @endif
    </div>

    @if($activeBanners->count() > 1)
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Selanjutnya</span>
      </button>
    @endif

  </div>
</section>

<!-- ═══════════════════════════════════════════════
     2. KARTU KEUNGGULAN BERANDA (HIGHLIGHT PILLARS)
═══════════════════════════════════════════════ -->
@php
  $pillarCards = (isset($features) && $features->count() > 0)
      ? $features
      : collect([
          (object) [
              'icon' => 'bi-layers',
              'judul' => 'Program Studi',
              'deskripsi' => 'Terakreditasi BAN-PT dengan kurikulum berbasis industri',
              'badge' => 'TERAKREDITASI',
              'urutan' => 1,
          ],
          (object) [
              'icon' => 'bi-people',
              'judul' => 'Kerjasama',
              'deskripsi' => 'Mitra industri dan institusi nasional & internasional',
              'badge' => 'MOU AKTIF',
              'urutan' => 2,
          ],
          (object) [
              'icon' => 'bi-award',
              'judul' => 'Program Beasiswa',
              'deskripsi' => 'Jalur beasiswa prestasi, ekonomi, dan afirmasi daerah',
              'badge' => 'BUKA 2025',
              'urutan' => 3,
          ],
      ]);
@endphp
<style>
  .uis-pillars-section {
    background: #ffffff;
    padding: 44px 0 18px;
  }
  .uis-pillar-card {
    position: relative;
    overflow: hidden;
    height: 100%;
    min-height: 292px;
    border-radius: 22px;
    padding: 32px 28px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #ffffff;
    border: 1.5px solid #dbeee1;
    box-shadow: 0 6px 22px rgba(15, 23, 42, 0.03);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  }
  .uis-pillar-link {
    display: block;
    height: 100%;
    color: inherit;
    text-decoration: none;
  }
  .uis-pillar-link:focus-visible {
    outline: 3px solid #facc15;
    outline-offset: 4px;
    border-radius: 22px;
  }
  .uis-pillar-card::after {
    content: "";
    position: absolute;
    top: -26px;
    right: -26px;
    width: 132px;
    height: 132px;
    border-radius: 50%;
    background: #ecf8f0;
    pointer-events: none;
    transition: transform 0.3s ease;
  }
  .uis-pillar-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(10, 84, 36, 0.08);
    border-color: #b7e1c5;
  }
  .uis-pillar-card:hover::after {
    transform: scale(1.06);
  }
  .uis-pillar-card.is-primary {
    background: #0b5626;
    border-color: #0b5626;
    box-shadow: 0 14px 32px rgba(11, 86, 38, 0.18);
  }
  .uis-pillar-card.is-primary::after {
    background: rgba(255, 255, 255, 0.06);
  }
  .uis-pillar-icon {
    position: relative;
    z-index: 1;
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #eef8f1;
    color: #0f6830;
    font-size: 22px;
    margin-bottom: 26px;
  }
  .uis-pillar-card.is-primary .uis-pillar-icon {
    background: rgba(255, 255, 255, 0.13);
    color: #ffffff;
  }
  .uis-pillar-title {
    position: relative;
    z-index: 1;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 19px;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: #111827;
    margin-bottom: 12px;
    line-height: 1.3;
  }
  .uis-pillar-card.is-primary .uis-pillar-title {
    color: #ffffff;
  }
  .uis-pillar-desc {
    position: relative;
    z-index: 1;
    font-size: 13.5px;
    line-height: 1.65;
    color: #64748b;
    margin-bottom: 26px;
  }
  .uis-pillar-card.is-primary .uis-pillar-desc {
    color: rgba(255, 255, 255, 0.82);
  }
  .uis-pillar-badge {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    width: fit-content;
    padding: 8px 16px;
    border-radius: 999px;
    background: #eef8f1;
    border: 1px solid #d2ebd9;
    color: #0f6830;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }
  .uis-pillar-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #16a34a;
    flex-shrink: 0;
  }
  .uis-pillar-card.is-primary .uis-pillar-badge {
    background: rgba(255, 255, 255, 0.11);
    border-color: rgba(255, 255, 255, 0.22);
    color: #facc15;
  }
  .uis-pillar-card.is-primary .uis-pillar-badge-dot {
    background: #facc15;
  }
  @media (max-width: 767.98px) {
    .uis-pillars-section {
      padding: 28px 0 10px;
    }
    .uis-pillar-card {
      min-height: 245px;
      padding: 24px 22px;
    }
  }
</style>

@php
  $featureLink = function ($card) {
      $judul = strtolower(trim((string) ($card->judul ?? '')));

      if ($judul !== '' && str_contains($judul, 'program studi')) {
          return route('homepage.program-studi');
      }

      if (empty($card->id)) {
          return '#';
      }

      return route('homepage.feature.detail', $card);
  };
@endphp

<section class="uis-pillars-section" id="keunggulan-beranda">
  <div class="container">
    <div class="row g-4">
      @foreach($pillarCards as $card)
        <div class="col-12 col-sm-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 70 }}">
          @if(!empty($card->id) || (!empty($card->judul) && str_contains(strtolower($card->judul), 'program studi')))
          <a class="uis-pillar-link" href="{{ $featureLink($card) }}" aria-label="Lihat detail {{ $card->judul }}">
          @endif
          <div class="uis-pillar-card {{ $loop->first ? 'is-primary' : '' }}">
            <div>
              <div class="uis-pillar-icon">
                <i class="bi {{ $card->icon ?: 'bi-layers' }}"></i>
              </div>
              <h3 class="uis-pillar-title">{{ $card->judul }}</h3>
              <p class="uis-pillar-desc">{{ trim(html_entity_decode(strip_tags($card->deskripsi), ENT_QUOTES, 'UTF-8')) }}</p>
            </div>
            <div>
              <span class="uis-pillar-badge">
                <span class="uis-pillar-badge-dot"></span>
                <span>{{ $card->badge ?? 'AKTIF' }}</span>
              </span>
            </div>
          </div>
          @if(!empty($card->id) || (!empty($card->judul) && str_contains(strtolower($card->judul), 'program studi')))
          </a>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     3. PROFIL SINGKAT Universitas Ibnu Sina & SAMBUTAN REKTOR
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="profil-singkat">
  <div class="container py-2">
    <!-- Header Section Full -->
    <div class="row justify-content-center text-center mb-4" data-aos="fade-up">
      <div class="col-12">
        <div class="section-label mx-auto">Profil Universitas</div>
        <h2 class="section-title">
          {{ $about->judul_profil ?? 'Universitas Ibnu Sina' }}
        </h2>
        <div class="divider-line centered"></div>
      </div>
    </div>

    <!-- VIDEO KIRI & CONTENT KANAN (SIDE-BY-SIDE) -->
    @if($about?->hasVideo())
      <div class="row g-4 align-items-center mb-5" data-aos="fade-up" data-aos-delay="150">
        {{-- Video Profil Kiri --}}
        <div class="col-lg-6">
          <div class="position-relative rounded-4 overflow-hidden shadow-sm border w-100" style="border-color: #e2e8f0; background: #000;">
            @if($about->video_file)
              <video controls class="w-100 d-block" style="max-height: 440px; object-fit: contain;">
                <source src="{{ asset('storage/' . $about->video_file) }}">
                Browser Anda tidak mendukung tag video.
              </video>
            @elseif($about->youtube_embed_url)
              <div class="ratio ratio-16x9">
                <iframe 
                  src="{{ $about->youtube_embed_url }}" 
                  title="Video Profil Universitas Ibnu Sina" 
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                  referrerpolicy="strict-origin-when-cross-origin" 
                  allowfullscreen>
                </iframe>
              </div>
            @endif
          </div>
          @if($about->youtube_watch_url)
            <div class="d-flex justify-content-between align-items-center gap-2 mt-2 px-1">
              <span class="text-muted small" style="font-size: 12px;">Video bermasalah saat diputar?</span>
              <a href="{{ $about->youtube_watch_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #046B26; font-size: 12px; border-radius: 6px; padding: 4px 12px;">
                <i class="bi bi-youtube text-warning"></i> Buka Langsung di YouTube <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 10px;"></i>
              </a>
            </div>
          @endif
        </div>

        {{-- Content / Deskripsi Kanan --}}
        <div class="col-lg-6">
          <div class="h-100 p-4 p-md-4 rounded-4 shadow-sm" style="font-size: 15.5px; line-height: 1.85; color: #2d3748; background: #f8faf9; border-left: 5px solid var(--uis-green, #046B26); border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
            <div class="about-desc-content" style="text-align: justify;">
              {!! $about->deskripsi_profil_1 ?? 'Universitas Ibnu Sina (UIS) Batam merupakan perguruan tinggi swasta terkemuka di Provinsi Kepulauan Riau yang lahir dari perpaduan keunggulan akademik Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES) di bawah naungan Yayasan Pendidikan Ibnu Sina Batam (YAPISNA). Berlokasi strategis di kawasan industri dan perdagangan internasional Kota Batam, UIS mengelola tiga fakultas unggulan: Fakultas Teknik (Sains & Teknologi), Fakultas Ekonomi dan Bisnis (FEB), serta Fakultas Ilmu Kesehatan (FIKES), beserta Program Pascasarjana (Magister). UIS bertekad mencetak lulusan profesional muda yang inovatif, berdaya saing global, berjiwa entrepreneur, dan berakhlak mulia berlandaskan Iman dan Taqwa (Imtaq).' !!}
            </div>
          </div>
        </div>
      </div>
    @else
      {{-- Fallback jika belum ada video --}}
      <div class="row mb-5" data-aos="fade-up" data-aos-delay="150">
        <div class="col-12">
          <div class="w-100 p-4 p-md-5 rounded-4 shadow-sm" style="text-align: justify; font-size: 16.5px; line-height: 1.9; color: #2d3748; background: #f8faf9; border-left: 6px solid var(--uis-green, #046B26); border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
            <div class="about-desc-content">
              {!! $about->deskripsi_profil_1 ?? 'Universitas Ibnu Sina (UIS) Batam merupakan perguruan tinggi swasta terkemuka di Provinsi Kepulauan Riau yang lahir dari perpaduan keunggulan akademik Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES) di bawah naungan Yayasan Pendidikan Ibnu Sina Batam (YAPISNA). Berlokasi strategis di kawasan industri dan perdagangan internasional Kota Batam, UIS mengelola tiga fakultas unggulan: Fakultas Teknik (Sains & Teknologi), Fakultas Ekonomi dan Bisnis (FEB), serta Fakultas Ilmu Kesehatan (FIKES), beserta Program Pascasarjana (Magister). UIS bertekad mencetak lulusan profesional muda yang inovatif, berdaya saing global, berjiwa entrepreneur, dan berakhlak mulia berlandaskan Iman dan Taqwa (Imtaq).' !!}
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- TOMBOL CTA PROFIL LENGKAP -->
    <div class="row justify-content-center mb-4" data-aos="fade-up" data-aos-delay="250">
      <div class="col-12 text-center">
        <a href="{{ route('homepage.tentang') }}" class="btn-primary-hero">
          <i class="bi bi-info-circle"></i>
          Profil Lengkap Universitas Ibnu Sina
        </a>
      </div>
    </div>

  </div>
</section>

<!-- ═══════════════════════════════════════════════
     3b. STATISTIK UNIVERSITAS — "UIS DALAM ANGKA"
═══════════════════════════════════════════════ -->
@if(isset($facultyStat) && $facultyStat && $facultyStat->is_active)
<style>
  .uis-stat-banner {
    position: relative;
    padding: 90px 0 85px 0;
    overflow: hidden;
    perspective: 1200px;
    transform-style: preserve-3d;
  }
  .uis-stat-3d-scene {
    position: absolute;
    inset: -30px;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
  }
  .uis-stat-3d-bg {
    position: absolute;
    inset: -60px;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    transform-origin: center center;
    will-change: transform;
    transform-style: preserve-3d;
    transform: scale(1.12) translate3d(0, 0, 0);
  }
  .uis-stat-3d-bg.ambient-float {
    animation: uis3dAmbient 18s ease-in-out infinite alternate;
  }
  @keyframes uis3dAmbient {
    0% {
      transform: scale(1.12) translate3d(-12px, -8px, 0) rotateX(1.5deg) rotateY(-2deg);
    }
    50% {
      transform: scale(1.16) translate3d(10px, 8px, 12px) rotateX(-1.5deg) rotateY(2deg);
    }
    100% {
      transform: scale(1.12) translate3d(-8px, -5px, 0) rotateX(2deg) rotateY(-1.2deg);
    }
  }
  .uis-stat-banner-content {
    position: relative;
    z-index: 2;
    transform-style: preserve-3d;
    will-change: transform;
  }
  .uis-stat-heading {
    color: #ffffff;
    font-size: clamp(1.8rem, 3.6vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.5px;
    text-shadow: none;
  }
  .uis-stat-tab-btn {
    background: #edf2f7;
    color: #334155;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 32px;
    border: none;
    border-radius: 3px;
    transition: all 0.25s ease;
    cursor: pointer;
    box-shadow: none;
  }
  .uis-stat-tab-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
    transform: translateY(-2px);
  }
  .uis-stat-tab-btn.active {
    background: #00875a;
    color: #ffffff;
    box-shadow: none;
    transform: translateY(-1px);
  }
  .uis-stat-number {
    font-size: clamp(2.8rem, 5.5vw, 4.4rem);
    font-weight: 900;
    color: #ffffff;
    line-height: 1.1;
    letter-spacing: -0.5px;
    font-family: 'Poppins', 'Plus Jakarta Sans', sans-serif;
    text-shadow: none;
    margin-bottom: 8px;
  }
  .uis-stat-label {
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.2px;
    text-shadow: none;
  }
</style>

<section id="statistik-fakultas" class="uis-stat-banner">
  {{-- 3D Motion Background Scene (Tanpa background hitam/overlay gelap) --}}
  <div class="uis-stat-3d-scene">
    <div class="uis-stat-3d-bg ambient-float" id="uis3dStatBg" style="background-image: url('{{ $facultyStat->bg_image_url }}');"></div>
  </div>

  <div class="container uis-stat-banner-content" id="uis3dStatContent">
    
    {{-- Heading --}}
    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="uis-stat-heading">
        {{ trim(preg_replace('/\bFIKES\b\s*/i', '', $facultyStat->title ?? 'UIS Dalam Angka')) ?: 'UIS Dalam Angka' }}
      </h2>
    </div>

    {{-- Tab Buttons --}}
    <div class="d-flex align-items-center justify-content-center gap-2 mb-5 flex-wrap" data-aos="fade-up" data-aos-delay="100">
      <button type="button" class="uis-stat-tab-btn active" id="btnTabMahasiswa" onclick="switchStatTab('mahasiswa')">
        {{ $facultyStat->tab_1_label ?? 'Mahasiswa' }}
      </button>
      <button type="button" class="uis-stat-tab-btn" id="btnTabPrestasi" onclick="switchStatTab('prestasi')">
        {{ $facultyStat->tab_2_label ?? 'Prestasi' }}
      </button>
      <button type="button" class="uis-stat-tab-btn" id="btnTabKerjasama" onclick="switchStatTab('kerjasama')">
        {{ $facultyStat->tab_3_label ?? 'Kerjasama' }}
      </button>
    </div>

    {{-- Tab 1: Mahasiswa --}}
    <div id="statPanelMahasiswa" class="stat-panel" data-aos="zoom-in" data-aos-delay="200">
      <div class="row g-4 justify-content-center text-center">
        <div class="col-6 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->mhs_total ?? 5273 }}">
            {{ number_format($facultyStat->mhs_total ?? 5273, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->mhs_total_label ?? 'Total Mahasiswa' }}
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->mhs_baru ?? 1520 }}">
            {{ number_format($facultyStat->mhs_baru ?? 1520, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->mhs_baru_label ?? 'Jumlah Mahasiswa Baru 2026' }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->mhs_alumni ?? 7968 }}">
            {{ number_format($facultyStat->mhs_alumni ?? 7968, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->mhs_alumni_label ?? 'Alumni' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Tab 2: Prestasi --}}
    <div id="statPanelPrestasi" class="stat-panel d-none">
      <div class="row g-4 justify-content-center text-center">
        <div class="col-4 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->prestasi_nasional ?? 37 }}">
            {{ number_format($facultyStat->prestasi_nasional ?? 37, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->prestasi_nasional_label ?? 'Nasional' }}
          </div>
        </div>
        <div class="col-4 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->prestasi_provinsi ?? 39 }}">
            {{ number_format($facultyStat->prestasi_provinsi ?? 39, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->prestasi_provinsi_label ?? 'Provinsi' }}
          </div>
        </div>
        <div class="col-4 col-md-4">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->prestasi_internasional ?? 10 }}">
            {{ number_format($facultyStat->prestasi_internasional ?? 10, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->prestasi_internasional_label ?? 'International' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Tab 3: Kerjasama --}}
    <div id="statPanelKerjasama" class="stat-panel d-none">
      <div class="row g-4 justify-content-center text-center">
        <div class="col-6 col-md-3">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->kerjasama_total ?? 50 }}">
            {{ number_format($facultyStat->kerjasama_total ?? 50, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->kerjasama_total_label ?? 'Jumlah Kerjasama' }}
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->kerjasama_perusahaan ?? 8 }}">
            {{ number_format($facultyStat->kerjasama_perusahaan ?? 8, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->kerjasama_perusahaan_label ?? 'Perusahaan' }}
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->kerjasama_pemerintahan ?? 19 }}">
            {{ number_format($facultyStat->kerjasama_pemerintahan ?? 19, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->kerjasama_pemerintahan_label ?? 'Pemerintahan' }}
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="uis-stat-number stat-count" data-target="{{ $facultyStat->kerjasama_sekolah ?? 5 }}">
            {{ number_format($facultyStat->kerjasama_sekolah ?? 5, 0, ',', '.') }}
          </div>
          <div class="uis-stat-label">
            {{ $facultyStat->kerjasama_sekolah_label ?? 'Sekolah' }}
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
  function switchStatTab(tab) {
    const btnMhs = document.getElementById('btnTabMahasiswa');
    const btnPrestasi = document.getElementById('btnTabPrestasi');
    const btnKerjasama = document.getElementById('btnTabKerjasama');

    const panelMhs = document.getElementById('statPanelMahasiswa');
    const panelPrestasi = document.getElementById('statPanelPrestasi');
    const panelKerjasama = document.getElementById('statPanelKerjasama');

    [btnMhs, btnPrestasi, btnKerjasama].forEach(b => b.classList.remove('active'));
    [panelMhs, panelPrestasi, panelKerjasama].forEach(p => p.classList.add('d-none'));

    if (tab === 'mahasiswa') {
      btnMhs.classList.add('active');
      panelMhs.classList.remove('d-none');
    } else if (tab === 'prestasi') {
      btnPrestasi.classList.add('active');
      panelPrestasi.classList.remove('d-none');
    } else if (tab === 'kerjasama') {
      btnKerjasama.classList.add('active');
      panelKerjasama.classList.remove('d-none');
    }
  }
</script>

{{-- Counter animation script --}}
@push('scripts')
<script>
(function () {
  function formatNum(n) {
    return n.toLocaleString('id-ID'); // ribuan: 1.814
  }

  function animateCounters() {
    document.querySelectorAll('.stat-count').forEach(function (el) {
      const target = parseInt(el.getAttribute('data-target'), 10);
      if (!target || el.dataset.animated) return;
      el.dataset.animated = '1';
      const duration = 1800;
      const step = 16;
      const steps = Math.floor(duration / step);
      let current = 0;
      const increment = target / steps;
      const timer = setInterval(function () {
        current += increment;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        el.textContent = formatNum(Math.floor(current));
      }, step);
    });
  }

  // Trigger on scroll into view
  const section = document.getElementById('statistik-fakultas');
  if (section && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          animateCounters();
          observer.disconnect();
        }
      });
    }, { threshold: 0.3 });
    observer.observe(section);
  } else if (section) {
    animateCounters();
  }

  // ═══════════════════════════════════════════════
  // 3D MOTION BACKGROUND ENGINE (Mouse & Gyroscope)
  // ═══════════════════════════════════════════════
  const bg3d = document.getElementById('uis3dStatBg');
  const content3d = document.getElementById('uis3dStatContent');

  if (section && bg3d) {
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;
    let isHovering = false;
    let animFrameId = null;

    function render3D() {
      // Lerp smoothing (0.08 for smooth buttery inertia)
      currentX += (targetX - currentX) * 0.08;
      currentY += (targetY - currentY) * 0.08;

      if (isHovering) {
        // 3D background tilt & translation
        const bgRotX = -currentY * 7;
        const bgRotY = currentX * 9;
        const bgTransX = -currentX * 28;
        const bgTransY = -currentY * 18;
        bg3d.style.transform = `scale(1.15) translate3d(${bgTransX}px, ${bgTransY}px, 0) rotateX(${bgRotX}deg) rotateY(${bgRotY}deg)`;

        // Foreground content slight opposite depth parallax
        if (content3d) {
          const fgRotX = -currentY * 2.5;
          const fgRotY = currentX * 3.5;
          const fgTransX = currentX * 10;
          const fgTransY = currentY * 8;
          content3d.style.transform = `translate3d(${fgTransX}px, ${fgTransY}px, 20px) rotateX(${fgRotX}deg) rotateY(${fgRotY}deg)`;
        }
      }

      animFrameId = requestAnimationFrame(render3D);
    }

    // Start 3D loop
    render3D();

    // Mouse Move event
    section.addEventListener('mouseenter', function () {
      isHovering = true;
      bg3d.classList.remove('ambient-float');
    });

    section.addEventListener('mousemove', function (e) {
      const rect = section.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width;   // 0 to 1
      const y = (e.clientY - rect.top) / rect.height;  // 0 to 1
      targetX = (x - 0.5) * 2; // -1 to 1
      targetY = (y - 0.5) * 2; // -1 to 1
    });

    section.addEventListener('mouseleave', function () {
      isHovering = false;
      targetX = 0;
      targetY = 0;
      // Reset smoothly
      bg3d.style.transform = 'scale(1.12) translate3d(0, 0, 0)';
      if (content3d) {
        content3d.style.transform = 'translate3d(0, 0, 0)';
      }
      setTimeout(function () {
        if (!isHovering) {
          bg3d.classList.add('ambient-float');
        }
      }, 300);
    });

    // Mobile Gyroscope 3D motion
    if (window.DeviceOrientationEvent && 'ontouchstart' in window) {
      window.addEventListener('deviceorientation', function (e) {
        if (e.gamma !== null && e.beta !== null) {
          const gamma = Math.min(Math.max(e.gamma, -30), 30); // -30 to 30
          const beta = Math.min(Math.max(e.beta - 45, -30), 30); // normalized reading angle
          targetX = gamma / 30;
          targetY = beta / 30;
          isHovering = true;
          bg3d.classList.remove('ambient-float');
        }
      });
    }
  }
})();
</script>
@endpush

@endif


<!-- ═══════════════════════════════════════════════
     5. MENGAPA MEMILIH Universitas Ibnu Sina
═══════════════════════════════════════════════ -->
<section class="section-bg-white" id="keunggulan">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Keunggulan Kami</div>
      <h2 class="section-title">Mengapa Memilih <em>Universitas Ibnu Sina</em>?</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Kami memberikan ekosistem belajar yang menyeluruh antara pemahaman teoritis berstandar mutakhir dan pelatihan praktikal di lapangan.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-book-half"></i></div>
          <div class="value-title">Kurikulum Berbasis Industri</div>
          <p class="value-desc">Materi kuliah diselaraskan dengan kebutuhan kompetensi industri, Permenaker, dan standar sertifikasi internasional.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-person-video3"></i></div>
          <div class="value-title">Dosen Ahli & Praktisi</div>
          <p class="value-desc">Diajar langsung oleh akademisi bergelar doktor (S3) dan praktisi industri berpengalaman di bidang IT, manufaktur, bisnis, dan K3.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-cpu-fill"></i></div>
          <div class="value-title">Laboratorium Mutakhir</div>
          <p class="value-desc">Peralatan komputasi AI, laboratorium jaringan Cisco, studio teknik industri, perancangan logistik, dan pengujian K3 lingkungan.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-buildings-fill"></i></div>
          <div class="value-title">100+ Mitra Industri & Korporasi</div>
          <p class="value-desc">Kerjasama magang dan penempatan kerja luas di kawasan industri Batamindo, Panbil, BUMN, galangan kapal, dan instansi perbankan.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-stars"></i></div>
          <div class="value-title">Karakter Imtaq & Entrepreneur</div>
          <p class="value-desc">Pembinaan karakter profesional muda yang jujur, amanah, berjiwa wirausaha mandiri, dan berlandaskan keimanan dan ketaqwaan.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
        <div class="value-card">
          <div class="value-icon-wrap"><i class="bi bi-award-fill"></i></div>
          <div class="value-title">Sertifikasi Kompetensi SKPI</div>
          <p class="value-desc">Kesempatan memperoleh Surat Keterangan Pendamping Ijazah (SKPI) dan sertifikasi kompetensi keahlian BNSP berstandar internasional.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     PMB BANNER (PENERIMAAN MAHASISWA BARU)
═══════════════════════════════════════════════ -->
@if(!isset($pmbSetting) || $pmbSetting->is_active)
<section class="section-bg-sand" id="pmb">
  <div class="container" data-aos="fade-up">
    <div class="pmb-cta-box">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="badge pmb-badge-wrap px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange); color: #032e12; font-weight: 800; font-size: 12px; letter-spacing: 1px;">
            {{ $pmbSetting->badge_text ?? 'PENERIMAAN MAHASISWA BARU (PMB) T.A. 2026/2027' }}
          </div>
          <h2 class="text-white fw-bold mb-3" style="font-size: clamp(1.5rem, 3.5vw, 2.1rem); line-height: 1.3;">
            {{ $pmbSetting->judul ?? 'Daftar Sekarang & Raih Masa Depan Cerah Bersama Universitas Ibnu Sina!' }}
          </h2>
          <div class="text-white mb-4 pmb-desc-content" style="line-height: 1.7; max-width: 620px; opacity: 0.92; font-size: 14.5px;">
            {!! $pmbSetting->deskripsi ?? 'Tersedia berbagai jalur seleksi: Jalur Bebas Tes / Prestasi, Jalur Reguler, Jalur KIP-Kuliah, dan Jalur Alih Jenjang Karyawan.' !!}
          </div>
          <div class="d-flex flex-wrap gap-3 pmb-btn-group">
            @php
              $link1 = $pmbSetting->tombol_link_1 ?? route('homepage.kontak');
              if (!str_starts_with($link1, 'http') && !str_starts_with($link1, '/')) {
                  $link1 = '/' . $link1;
              }
            @endphp
            <a href="{{ $link1 }}" target="{{ str_starts_with($link1, 'http') ? '_blank' : '_self' }}" class="btn-primary-hero">
              <i class="bi bi-pencil-square"></i> {{ $pmbSetting->tombol_text_1 ?? 'Daftar PMB Sekarang' }}
            </a>

            @php
              $link2 = $pmbSetting->tombol_link_2 ?? '';
              if (empty($link2) && !empty($cleanWa)) {
                  $link2 = "https://wa.me/{$cleanWa}?text=" . urlencode("Halo Admin PMB Universitas Ibnu Sina, saya ingin konsultasi pendaftaran mahasiswa baru");
              }
            @endphp
            @if(!empty($link2))
              <a href="{{ $link2 }}" target="_blank" class="btn-pmb-wa">
                <i class="bi bi-whatsapp"></i> {{ $pmbSetting->tombol_text_2 ?? 'Konsultasi WhatsApp PMB' }}
              </a>
            @endif
          </div>
        </div>

        <div class="col-lg-4">
          <div class="p-4 rounded-4" style="background: rgba(0, 0, 0, 0.22); border: 1px solid rgba(255, 255, 255, 0.22); backdrop-filter: blur(8px);">
            <h5 class="text-white fw-bold mb-3"><i class="bi bi-calendar-event text-warning me-2"></i>Jadwal Gelombang:</h5>
            <ul class="text-white small list-unstyled mb-0" style="line-height: 2; opacity: 0.95;">
              @php
                $waveList = $pmbSetting->waves ?? ['Gelombang 1: Jan - Apr', 'Gelombang 2: Mei - Jul', 'Gelombang 3: Agu - Sep'];
              @endphp
              @foreach($waveList as $waveItem)
                <li><i class="bi bi-check2 text-warning me-1"></i> {{ $waveItem }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════
     6. FASILITAS & LABORATORIUM
═══════════════════════════════════════════════ -->
<section class="section-bg-sand" id="fasilitas">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Sarana Kampus</div>
      <h2 class="section-title">Fasilitas & <em>Laboratorium</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Menunjang proses riset dan praktikum mahasiswa dengan sarana pengujian berteknologi mutakhir.
      </p>
    </div>

    <div class="row g-4">
      @if(isset($saranas) && $saranas->count())
        @foreach($saranas as $index => $sarana)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
            <a href="{{ route('homepage.fasilitas.detail', $sarana->slug ?: $sarana->id) }}" class="text-decoration-none d-block h-100" style="color: inherit;">
              <div class="fasilitas-box d-flex flex-column justify-content-between h-100">
                <div>
                  <div class="fasilitas-icon"><i class="bi {{ $sarana->icon ?? 'bi-building' }}"></i></div>
                  <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
                  <p class="fasilitas-desc mb-3">{{ trim(html_entity_decode(strip_tags($sarana->deskripsi ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?: 'Fasilitas yang mendukung kegiatan akademik dan riset mahasiswa.' }}</p>
                </div>
                <div class="pt-2 mt-auto">
                  <span class="d-inline-flex align-items-center gap-1 fw-bold" style="font-size: 13px; color: inherit; opacity: 0.9;">
                    Lihat Detail <i class="bi bi-arrow-right"></i>
                  </span>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted py-4">
          Belum ada data sarana yang dipublikasikan.
        </div>
      @endif
    </div>

    @if(isset($saranas) && $saranas->count())
      <div class="text-center mt-5" data-aos="fade-up">
        <a href="{{ route('homepage.fasilitas') }}" class="btn btn-uis-outline rounded-pill px-4 py-2 fw-semibold">
          <i class="bi bi-grid-fill me-2"></i>Lihat Seluruh Laboratorium & Fasilitas
        </a>
      </div>
    @endif
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     8. PRESTASI MAHASISWA & STUDENT LIFE
═══════════════════════════════════════════════ -->
<section class="section-bg-white" id="prestasi">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Kebanggaan Kampus</div>
      <h2 class="section-title">Prestasi Gemilang <em>Mahasiswa UIS</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Bukti dedikasi, keunggulan riset, dan daya saing mahasiswa Universitas Ibnu Sina di berbagai kompetisi ilmiah dan kejuaraan.
      </p>
    </div>

    @if(isset($prestasis) && $prestasis->count() > 0)
      <div class="row g-4 mb-5">
        @foreach($prestasis as $index => $prestasi)
          @php
            $prestasiTitle = $prestasi->title ?? $prestasi->judul_prestasi ?? 'Prestasi Mahasiswa';
            $prestasiThumb = $prestasi->thumbnail ?? $prestasi->foto ?? null;
            $prestasiDesc  = $prestasi->description ?? $prestasi->content ?? $prestasi->deskripsi ?? '';
            $prestasiDate  = ($prestasi->published_at ?? $prestasi->created_at)?->format('d M Y');
          @endphp
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
            <div class="prestasi-card">
              <div class="prestasi-img-wrap">
                @if(!empty($prestasiThumb))
                  <img src="{{ asset('storage/' . $prestasiThumb) }}" alt="{{ $prestasiTitle }}" class="prestasi-img">
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
                    <div class="text-muted small mt-2" style="font-size: 12.5px; line-height: 1.6;">
                      {{ Str::limit(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($prestasiDesc)))), 115) }}
                    </div>
                  @endif
                </div>

                <div class="pt-3 border-top mt-3">
                  <a href="{{ route('homepage.prestasi.detail', $prestasi->slug ?? $prestasi->id) }}" class="fw-bold text-decoration-none d-flex align-items-center justify-content-between" style="color: var(--uis-purple); font-size: 13px;">
                    <span>Lihat Selengkapnya</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Tombol Lihat Semua Prestasi --}}
      <div class="text-center mt-2 mb-5">
        <a href="{{ route('homepage.prestasi') }}" class="btn-uis-pill">
          <i class="bi bi-trophy-fill me-1 text-warning"></i> Lihat Semua Prestasi Mahasiswa
        </a>
      </div>
    @endif


  </div>
</section>

<!-- ═══════════════════════════════════════════════
     9.3 ORGANISASI & KEGIATAN MAHASISWA (MIRROR MOTION / 3D U-CURVE CAROUSEL)
═══════════════════════════════════════════════ -->
<style>
  .uis-cylinder-viewport {
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
    position: relative;
    perspective: 1200px;
    perspective-origin: 50% 50%;
    padding: 20px 0 40px 0;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    touch-action: pan-y;
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
  }
  .uis-cylinder-viewport:active {
    cursor: grabbing;
  }
  .uis-cylinder-track {
    position: relative;
    width: 100%;
    height: 335px;
    transform-style: preserve-3d;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .uis-cylinder-card {
    position: absolute;
    top: 0;
    left: 0;
    width: 230px;
    height: 310px;
    transform-style: preserve-3d;
    transform-origin: center bottom;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    will-change: transform, opacity;
    cursor: pointer;
    pointer-events: auto;
  }
  @media (max-width: 768px) {
    .uis-cylinder-card {
      width: 165px;
      height: 235px;
    }
    .uis-cylinder-track {
      height: 255px;
    }
    .uis-cylinder-viewport {
      padding-bottom: 25px;
    }
  }
  .uis-card-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 10px;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    transition: color 0.3s ease;
  }
  .uis-cylinder-card.is-active .uis-card-label {
    color: #fed802;
    text-shadow: 0 0 10px rgba(254, 216, 2, 0.6);
  }
  .uis-card-body {
    width: 100%;
    height: 270px;
    background: linear-gradient(165deg, rgba(6, 94, 33, 0.95) 0%, rgba(3, 56, 20, 0.96) 60%, rgba(2, 32, 11, 0.98) 100%);
    border: 1.5px solid rgba(254, 216, 2, 0.35);
    border-radius: 16px;
    padding: 10px;
    display: flex;
    align-items: stretch;
    justify-content: stretch;
    box-sizing: border-box;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  @media (max-width: 768px) {
    .uis-card-body {
      height: 200px;
      padding: 7px;
    }
  }
  .uis-cylinder-card.is-active .uis-card-body,
  .uis-cylinder-card:hover .uis-card-body {
    border-color: rgba(254, 216, 2, 0.9);
    box-shadow: 0 0 32px rgba(254, 216, 2, 0.5), 0 18px 40px rgba(0, 0, 0, 0.75);
  }
  .uis-card-media {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    box-sizing: border-box;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.04), 0 4px 14px rgba(0, 0, 0, 0.14);
    overflow: hidden;
    position: relative;
  }
  .uis-card-logo {
    width: 90%;
    height: 90%;
    max-width: 92%;
    max-height: 195px;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.35s ease;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
  }
  @media (max-width: 768px) {
    .uis-card-media {
      padding: 6px;
    }
    .uis-card-logo {
      width: 92%;
      height: 92%;
      max-height: 145px;
      max-width: 94%;
    }
  }
  #organisasi-mahasiswa .uis-card-body {
    padding: 0;
  }
  #organisasi-mahasiswa .uis-card-media {
    padding: 0;
    border-radius: 14px;
    background: transparent;
  }
  #organisasi-mahasiswa .uis-card-logo {
    width: 100%;
    height: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 14px;
    display: block;
    filter: none;
  }
  #organisasi-mahasiswa .mirror-card-fallback-icon {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 14px;
  }
</style>

@if(isset($organisasis) && $organisasis->count() > 0)
<section class="layanan-terkait-section" id="organisasi-mahasiswa">
  {{-- Header inside Container --}}
  <div class="container position-relative">
    <div class="mirror-hall-badge" data-aos="fade-down">
      <span><i class="bi bi-people-fill me-1"></i> {{ $organisasiSetting?->badge_teks ?: 'LEMBAGA KEMAHASISWAAN · UIS' }}</span>
    </div>

    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="layanan-terkait-title">
        {{ $organisasiSetting?->judul ?: 'ORGANISASI MAHASISWA UIS' }}
      </h2>
      <p class="layanan-terkait-desc">
        “{{ trim(strip_tags($organisasiSetting?->deskripsi ?: 'Eksplorasi ragam organisasi kemahasiswaan, himpunan program studi, dan unit kegiatan minat bakat di Universitas Ibnu Sina Batam. Ruang kolaborasi untuk mengasah karakter, kepemimpinan, dan inovasi civitas kampus.')) }}”
      </p>
    </div>
  </div>

  {{-- Full Width Continuous 3D Cylinder Arc Stage --}}
  <div class="uis-cylinder-viewport position-relative" id="ormawaCylinderViewport">
    <div class="uis-cylinder-track" id="ormawaCylinderTrack">
      @php
        $ormawaTotalCount = $organisasis->count();
        $ormawaRepeats = max(4, (int) ceil(12 / max(1, $ormawaTotalCount)));
      @endphp
      @for($r = 0; $r < $ormawaRepeats; $r++)
        @foreach($organisasis as $idx => $ormawa)
          @php
            $singkat = $ormawa->singkatan ?: $ormawa->nama_organisasi;
            $fullTitle = $ormawa->nama_organisasi . (!empty($ormawa->singkatan) ? ' (' . $ormawa->singkatan . ')' : '');
            $ormawaDesc = trim(strip_tags($ormawa->deskripsi ?: ($ormawa->visi ?: 'Lembaga kemahasiswaan aktif di lingkungan Universitas Ibnu Sina.')));
            $ormawaUrl = route('homepage.organisasi.detail', $ormawa->slug);
            $itemNum = $idx + 1;
          @endphp
          <div class="uis-cylinder-card"
               data-index="{{ sprintf('%02d', $itemNum) }}"
               data-total="{{ sprintf('%02d', $ormawaTotalCount) }}"
               data-name="{{ $fullTitle }}"
               data-desc="{{ Str::limit($ormawaDesc, 160) }}"
               data-url="{{ $ormawaUrl }}"
               role="button"
               tabindex="0"
               aria-label="Profil {{ $ormawa->nama_organisasi }}">

            <div class="uis-card-label">{{ $singkat }}</div>
            <div class="uis-card-body">
              <div class="uis-card-media">
                @php
                  $ormawaCardImg = $ormawa->logo ?: $ormawa->foto_kegiatan;
                @endphp
                @if(!empty($ormawaCardImg))
                  <img src="{{ asset('storage/' . $ormawaCardImg) }}" alt="{{ $ormawa->nama_organisasi }}" class="uis-card-logo" loading="lazy">
                @else
                  <div class="mirror-card-fallback-icon">
                    <i class="bi bi-people-fill"></i>
                    <span class="mirror-fallback-title">{{ $singkat }}</span>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @endfor
    </div>
  </div>

  {{-- Floor Info & Active Details (Mirror Hall Footer) inside Container --}}
  <div class="container position-relative">
    @php
      $firstOrmawa = $organisasis->first();
      $firstOrmawaTitle = $firstOrmawa ? ($firstOrmawa->nama_organisasi . (!empty($firstOrmawa->singkatan) ? ' (' . $firstOrmawa->singkatan . ')' : '')) : 'Organisasi Mahasiswa UIS';
      $firstOrmawaDesc = $firstOrmawa ? Str::limit(trim(strip_tags($firstOrmawa->deskripsi ?: ($firstOrmawa->visi ?: 'Lembaga kemahasiswaan aktif di lingkungan Universitas Ibnu Sina.'))), 160) : '';
      $firstOrmawaUrl = $firstOrmawa ? route('homepage.organisasi.detail', $firstOrmawa->slug) : route('homepage.organisasi');
    @endphp
    <div class="mirror-hall-floor" data-aos="fade-up" data-aos-delay="200">
      <div class="mirror-counter-badge" id="ormawaMirrorCounter">
        01 / {{ sprintf('%02d', $organisasis->count()) }}
      </div>
      <h3 class="mirror-active-title" id="ormawaMirrorActiveTitle">
        {{ $firstOrmawaTitle }}
      </h3>
      <p class="mirror-active-desc" id="ormawaMirrorActiveDesc">
        {{ $firstOrmawaDesc }}
      </p>
      <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
        <a href="{{ $firstOrmawaUrl }}" class="mirror-active-cta" id="ormawaMirrorActiveBtn">
          <span>Profil Lengkap</span>
          <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
        <a href="{{ !empty($organisasiSetting?->tombol_url) ? $organisasiSetting->tombol_url : route('homepage.organisasi') }}"
           class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold"
           style="font-size: 13px; border-color: rgba(254, 216, 2, 0.5); color: #fed802;">
          <span>{{ $organisasiSetting?->tombol_teks ?: 'Jelajahi Semua Organisasi' }}</span>
          <i class="bi bi-grid-fill ms-1"></i>
        </a>
      </div>
    </div>
  </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════
     9.5 GALERI DOKUMENTASI & KEGIATAN KAMPUS
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" id="galeri">
  <div class="container py-3">
    <div class="d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3" data-aos="fade-up">
      <div>
        <div class="section-label mb-2">Dokumentasi Visual</div>
        <h2 class="section-title mb-0">Galeri & <em>Kegiatan Universitas Ibnu Sina</em></h2>
      </div>
      <a href="{{ route('homepage.galeri.universitas') }}" class="btn-outline-hero" style="color: var(--uis-purple); border-color: var(--uis-purple); font-size: 13.5px; padding: 10px 22px;">
        <i class="bi bi-images me-1"></i> Lihat Semua Galeri
      </a>
    </div>

    @if(isset($galleries) && $galleries->count() > 0)
      <div class="row g-4">
        @foreach($galleries->take(6) as $index => $gal)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
            <a href="{{ route('homepage.galeri.detail', $gal->slug ?? $gal->id) }}" class="gallery-card-item d-block text-decoration-none">
              <div class="gallery-img-container">
                @if(!empty($gal->url))
                  <img src="{{ asset('storage/' . $gal->url) }}" alt="{{ $gal->judul }}" class="gallery-card-img" loading="lazy">
                @else
                  <div class="gallery-fallback-box">
                    <i class="bi bi-camera-fill fs-1 text-white-50"></i>
                  </div>
                @endif
                <div class="gallery-card-overlay">
                  <span class="gallery-tag"><i class="bi bi-tag-fill me-1"></i>Dokumentasi</span>
                  <h5 class="gallery-card-title">{{ $gal->judul }}</h5>
                  @if(!empty($gal->deskripsi))
                    <p class="gallery-card-desc mb-0">{!! Str::limit(strip_tags($gal->deskripsi), 90) !!}</p>
                  @endif
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-5 bg-white rounded-4 border">
        <i class="bi bi-images fs-1 text-muted d-block mb-2"></i>
        <p class="text-muted mb-0">Belum ada dokumentasi foto yang diunggah.</p>
      </div>
    @endif
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     MEDIA SOSIAL (IKUTI UIS DI MEDIA SOSIAL)
═══════════════════════════════════════════════ -->
@if(isset($socialMedias) && $socialMedias->count() > 0)
<section class="social-media-section" id="media-sosial">
  <div class="container">
    {{-- Header Judul Seksi --}}
    <h2 class="social-media-title" data-aos="fade-up">
      {{ $socialMediaSetting->judul_seksi ?? 'IKUTI UIS DI MEDIA SOSIAL' }}
    </h2>

    {{-- Divider Garis Ikon Share --}}
    <div class="social-divider-wrap" data-aos="fade-up" data-aos-delay="50">
      <span class="social-divider-line"></span>
      <span class="social-divider-icon"><i class="bi bi-share"></i></span>
      <span class="social-divider-line"></span>
    </div>

    {{-- Deskripsi Kutipan Ajakan --}}
    @if(!empty($socialMediaSetting?->subjudul_seksi))
      <p class="social-media-quote" data-aos="fade-up" data-aos-delay="100">
        {{ $socialMediaSetting->subjudul_seksi }}
      </p>
    @endif

    {{-- Tombol Baris Ikon Media Sosial --}}
    <div class="social-media-grid" data-aos="fade-up" data-aos-delay="150">
      @foreach($socialMedias as $sm)
        <a href="{{ $sm->url }}"
           target="_blank"
           rel="noopener noreferrer"
           class="social-media-btn"
           title="{{ $sm->nama }}"
           aria-label="{{ $sm->nama }}">
          @if($sm->logo_url)
            <img src="{{ $sm->logo_url }}" alt="{{ $sm->nama }}" class="social-media-img-logo">
          @else
            <i class="bi {{ $sm->icon ?: 'bi-globe' }} social-media-icon-fallback"></i>
          @endif
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════
     11. BERITA, PENGUMUMAN & AGENDA (LAYOUT BARU)
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="berita">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      
      {{-- KOLOM KIRI (BERITA): 2-KOLOM GRID --}}
      <div class="col-lg-8" data-aos="fade-right">
        {{-- Header Berita + Search Bar --}}
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-newspaper fs-2" style="color: var(--uis-purple, #046B26);"></i>
            <h2 class="section-heading-uis mb-0">Berita</h2>
          </div>
          <form action="{{ route('homepage') }}#berita" method="GET" class="news-search-pill" id="homepageNewsSearchForm">
            <input type="text"
                   name="q"
                   id="homepageNewsSearchInput"
                   value="{{ $search ?? request('q', '') }}"
                   placeholder="Cari Berita Lainnya.."
                   autocomplete="off">
            <button type="button"
                    id="homepageNewsSearchClear"
                    class="news-search-clear {{ empty($search) && !request('q') ? 'd-none' : '' }}"
                    aria-label="Hapus Pencarian"
                    title="Hapus Pencarian">
              <i class="bi bi-x-circle-fill"></i>
            </button>
            <button type="submit" id="homepageNewsSearchBtn" aria-label="Cari Berita">
              <i class="bi bi-search" id="homepageNewsSearchIcon"></i>
              <span class="spinner-border spinner-border-sm d-none" id="homepageNewsSearchSpinner" role="status" aria-hidden="true" style="width: 14px; height: 14px; border-width: 2px;"></span>
            </button>
          </form>
        </div>

        {{-- Container Grid Berita (Mendukung Live Search AJAX & Server-side Filter) --}}
        <div id="homepageNewsGridContainer" class="news-grid-container position-relative">
          @include('layouts.frontend.partials.homepage-news-grid', ['latestNews' => $latestNews, 'search' => $search ?? request('q', '')])
        </div>

        {{-- Tombol Lihat Berita Lainnya --}}
        <div class="text-center mt-3 pt-2">
          <a href="{{ route('homepage.news') }}{{ !empty($search) ? '?q=' . urlencode($search) : '' }}" class="btn-uis-pill" id="btnSeeAllNews">
            Lihat Berita Lainnya
          </a>
        </div>
      </div>

      {{-- KOLOM KANAN (PENGUMUMAN & AGENDA) --}}
      <div class="col-lg-4" data-aos="fade-left">
        
        {{-- SECTION PENGUMUMAN --}}
        <div class="mb-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-megaphone-fill fs-3" style="color: var(--uis-purple, #046B26);"></i>
            <h3 class="section-heading-uis mb-0" style="font-size: 24px;">Pengumuman</h3>
          </div>

          <div class="announcement-list">
            @if(isset($pengumumans) && $pengumumans->count() > 0)
              @foreach($pengumumans as $item)
                <a href="{{ route('homepage.pengumuman-agenda.detail', $item->slug ?: $item->id) }}" class="announcement-card-box text-decoration-none d-block">
                  <div class="announcement-card-title">{{ $item->judul }}</div>
                  <div class="announcement-card-date d-flex align-items-center justify-content-between">
                    <span>{{ $item->waktu ?: '-' }}</span>
                    <span class="small fw-semibold" style="color: #046B26; font-size: 11.5px;">Detail <i class="bi bi-arrow-right"></i></span>
                  </div>
                </a>
              @endforeach
            @elseif(isset($announcements) && $announcements->count() > 0)
              @foreach($announcements as $ann)
                <a href="{{ route('homepage.news.detail', $ann->slug ?? $ann->id) }}" class="announcement-card-box">
                  <div class="announcement-card-title">{{ $ann->title }}</div>
                  <div class="announcement-card-date">{{ $ann->created_at ? $ann->created_at->format('d F Y') : '-' }}</div>
                </a>
              @endforeach
            @else
              {{-- Default Item Pengumuman Fakultas --}}
              <div class="announcement-card-box">
                <div class="announcement-card-title">Pengumuman Pengisian KRS dan validasi KRS Tahun Akademik 2026/2027 Gasal</div>
                <div class="announcement-card-date">15 August 2026</div>
              </div>
              <div class="announcement-card-box">
                <div class="announcement-card-title">Pengumuman Semester Antara TA. 2025-2026</div>
                <div class="announcement-card-date">1 August 2026</div>
              </div>
            @endif
          </div>
        </div>

        {{-- SECTION AGENDA --}}
        <div class="mt-4 pt-3 border-top">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-calendar4-week fs-3" style="color: var(--uis-purple, #046B26);"></i>
            <h3 class="section-heading-uis mb-0" style="font-size: 24px;">Agenda</h3>
          </div>

          <div class="agenda-list">
            @if(isset($agendas) && $agendas->count() > 0)
              @foreach($agendas as $agenda)
                <div class="agenda-row mb-3">
                  <div class="agenda-time-text">{{ rtrim($agenda->waktu, ':') }}:</div>
                  <a href="{{ route('homepage.pengumuman-agenda.detail', $agenda->slug ?: $agenda->id) }}" class="agenda-badge-card d-flex align-items-center justify-content-between text-decoration-none">
                    <span>{{ $agenda->judul }}</span>
                    <i class="bi bi-chevron-right small ms-2"></i>
                  </a>
                </div>
              @endforeach
            @else
              <div class="agenda-row mb-3">
                <div class="agenda-time-text">20 - 31 Juli 2026:</div>
                <div class="agenda-badge-card">
                  Pendaftaran Semester Antara
                </div>
              </div>

              <div class="agenda-row mb-3">
                <div class="agenda-time-text">03 - 28 Agustus 2026:</div>
                <div class="agenda-badge-card">
                  Perkuliahan Semester Antara
                </div>
              </div>

              <div class="agenda-row mb-3">
                <div class="agenda-time-text">31 Agustus - 05 September 2026:</div>
                <div class="agenda-badge-card">
                  Penyerahan Nilai Semester Antara
                </div>
              </div>
            @endif

            <div class="mt-3">
              <a href="{{ route('homepage.pengumuman-agenda') }}" class="btn-agenda-pill">
                Lihat Seluruh Agenda & Pengumuman
              </a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     10. ALUMNI & KARIER
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="alumni">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Kisah Sukses Alumni</div>
      <h2 class="section-title">Jejak Karir <em>Alumni Universitas Ibnu Sina</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Lulusan Universitas Ibnu Sina telah berkarier di berbagai perusahaan multinasional, industri manufaktur, sektor logistik maritim, perbankan, instansi BUMN, pemerintahan, serta sukses menjadi wirausahawan mandiri.
      </p>
    </div>

    <!-- Swiper Testimonial Slider -->
    <div class="position-relative px-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper alumniSwiper pb-5">
        <div class="swiper-wrapper">
          @if(isset($testimonials) && $testimonials->count() > 0)
            @foreach($testimonials as $index => $testi)
              @php
                $initials = '';
                $words = explode(' ', $testi->nama);
                foreach ($words as $w) {
                    $initials .= strtoupper(substr($w, 0, 1));
                }
                $initials = substr($initials, 0, 2);
              @endphp
              <div class="swiper-slide h-auto">
                <div class="testi-card h-100 shadow-sm" style="background: #ffffff; border: 1.5px solid #f0e6f5; border-radius: 20px; padding: 28px 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
                  <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="testi-stars m-0" style="color: #FED802; font-size: 15px; display: flex; gap: 3px;">
                        @for($s = 1; $s <= 5; $s++)
                          <i class="bi bi-star{{ $s <= $testi->bintang ? '-fill' : '' }}"></i>
                        @endfor
                      </div>
                      <span class="badge" style="background: #f5edf8; color: #046B26; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 8px;">
                        {{ $testi->kategori ?? 'Alumni' }}
                      </span>
                    </div>
                    <p class="testi-text mb-4" style="font-size: 14px; line-height: 1.6; color: #333333; font-style: italic;">"{{ $testi->pesan }}"</p>
                  </div>
                  <div class="testi-author pt-3 border-top d-flex align-items-center gap-3" style="border-color: #f7effa !important;">
                    <div class="testi-avatar flex-shrink-0" style="width: 44px; height: 44px; border-radius: 50%; background: #046B26; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">{{ $initials ?: 'AL' }}</div>
                    <div>
                      <div class="testi-name text-dark fw-bold" style="font-size: 14px; line-height: 1.3;">{{ $testi->nama }}</div>
                      <div class="testi-role text-muted small" style="font-size: 12px;">{{ $testi->pekerjaan ?? 'Alumni Universitas Ibnu Sina' }}</div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>

        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div>
      </div>

      <!-- Navigation Arrows -->
      <div class="swiper-button-prev alumni-prev" style="color: #046B26;"></div>
      <div class="swiper-button-next alumni-next" style="color: #046B26;"></div>
    </div>

    <div class="text-center mt-3" data-aos="fade-up">
      <a href="{{ route('homepage.testimoni') }}" class="btn-outline-hero px-4 py-2" style="color: var(--uis-purple); border-color: var(--uis-purple); border-radius: 25px; font-weight: 600;">
        <i class="bi bi-chat-heart me-1"></i> Lihat Semua Ulasan Alumni
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     LAYANAN TERKAIT (MIRROR MOTION / 3D U-CURVE CAROUSEL)
═══════════════════════════════════════════════ -->
@if(isset($layananTerkaits) && $layananTerkaits->count() > 0)
<section class="layanan-terkait-section" id="layanan-terkait">
  {{-- Header inside Container --}}
  <div class="container position-relative">
    <div class="mirror-hall-badge" data-aos="fade-down">
      <span><i class="bi bi-grid-3x3-gap-fill me-1"></i> PORTAL DIGITAL & SISTEM INFORMASI</span>
    </div>
    
    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="layanan-terkait-title">
        {{ $layananTerkaitSetting->judul_seksi ?? 'LAYANAN TERKAIT' }}
      </h2>
      @if(!empty($layananTerkaitSetting?->subjudul_seksi))
        <p class="layanan-terkait-desc">
          “{{ $layananTerkaitSetting->subjudul_seksi }}”
        </p>
      @endif
    </div>
  </div>

<style>
  .uis-cylinder-viewport {
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
    position: relative;
    perspective: 1200px;
    perspective-origin: 50% 50%;
    padding: 20px 0 40px 0;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    touch-action: pan-y;
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
  }
  .uis-cylinder-viewport:active {
    cursor: grabbing;
  }
  .uis-cylinder-track {
    position: relative;
    width: 100%;
    height: 335px;
    transform-style: preserve-3d;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .uis-cylinder-card {
    position: absolute;
    top: 0;
    left: 0;
    width: 230px;
    height: 310px;
    transform-style: preserve-3d;
    transform-origin: center bottom;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    will-change: transform, opacity;
    cursor: pointer;
    pointer-events: auto;
  }
  @media (max-width: 768px) {
    .uis-cylinder-card {
      width: 165px;
      height: 235px;
    }
    .uis-cylinder-track {
      height: 255px;
    }
    .uis-cylinder-viewport {
      padding-bottom: 25px;
    }
  }
  .uis-card-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 10px;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    transition: color 0.3s ease;
  }
  .uis-cylinder-card.is-active .uis-card-label {
    color: #fed802;
    text-shadow: 0 0 10px rgba(254, 216, 2, 0.6);
  }
  .uis-card-body {
    width: 100%;
    height: 270px;
    background: linear-gradient(165deg, rgba(6, 94, 33, 0.95) 0%, rgba(3, 56, 20, 0.96) 60%, rgba(2, 32, 11, 0.98) 100%);
    border: 1.5px solid rgba(254, 216, 2, 0.35);
    border-radius: 16px;
    padding: 10px;
    display: flex;
    align-items: stretch;
    justify-content: stretch;
    box-sizing: border-box;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  @media (max-width: 768px) {
    .uis-card-body {
      height: 200px;
      padding: 7px;
    }
  }
  .uis-cylinder-card.is-active .uis-card-body,
  .uis-cylinder-card:hover .uis-card-body {
    border-color: rgba(254, 216, 2, 0.9);
    box-shadow: 0 0 32px rgba(254, 216, 2, 0.5), 0 18px 40px rgba(0, 0, 0, 0.75);
  }
  .uis-card-media {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    box-sizing: border-box;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.04), 0 4px 14px rgba(0, 0, 0, 0.14);
    overflow: hidden;
    position: relative;
  }
  .uis-card-logo {
    width: 90%;
    height: 90%;
    max-width: 92%;
    max-height: 195px;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.35s ease;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
  }
  @media (max-width: 768px) {
    .uis-card-media {
      padding: 6px;
    }
    .uis-card-logo {
      width: 92%;
      height: 92%;
      max-height: 145px;
      max-width: 94%;
    }
  }
  #organisasi-mahasiswa .uis-card-body {
    padding: 0;
  }
  #organisasi-mahasiswa .uis-card-media {
    padding: 0;
    border-radius: 14px;
    background: transparent;
  }
  #organisasi-mahasiswa .uis-card-logo {
    width: 100%;
    height: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 14px;
    display: block;
    filter: none;
  }
  #organisasi-mahasiswa .mirror-card-fallback-icon {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 14px;
  }
</style>

  {{-- Full Width Continuous 3D Cylinder Arc Stage --}}
  <div class="uis-cylinder-viewport position-relative" id="uisCylinderViewport">
    <div class="uis-cylinder-track" id="uisCylinderTrack">
      @php
        $totalCount = $layananTerkaits->count();
        // 4x duplikasi memastikan pita berjalan kontinu tanpa henti (seamless infinite loop)
        $repeats = 4;
      @endphp
      @for($r = 0; $r < $repeats; $r++)
        @foreach($layananTerkaits as $idx => $item)
          @php
            $itemDesc = trim(strip_tags($item->deskripsi ?? 'Akses layanan digital terpadu Universitas Ibnu Sina'));
            $itemNum = $idx + 1;
          @endphp
          <div class="uis-cylinder-card"
               data-index="{{ sprintf('%02d', $itemNum) }}"
               data-total="{{ sprintf('%02d', $totalCount) }}"
               data-name="{{ $item->nama }}"
               data-desc="{{ $itemDesc }}"
               data-url="{{ $item->url }}"
               role="button"
               tabindex="0"
               aria-label="Kunjungi Layanan {{ $item->nama }}">
            
            <div class="uis-card-label">{{ $item->nama }}</div>
            <div class="uis-card-body">
              <div class="uis-card-media">
                @if($item->logo_url)
                  <img src="{{ $item->logo_url }}" alt="{{ $item->nama }}" class="uis-card-logo" loading="lazy">
                @else
                  <div class="mirror-card-fallback-icon">
                    <i class="bi {{ $item->icon ?: 'bi-globe' }}"></i>
                    <span class="mirror-fallback-title">{{ $item->nama }}</span>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @endfor
    </div>
    {{-- Interactive Water Ripple Canvas on Reflective Floor --}}
    <canvas id="mirrorWaterCanvas" class="mirror-water-canvas"></canvas>
  </div>

  {{-- Floor Info & Active Details (Mirror Hall Footer) inside Container --}}
  <div class="container position-relative">
    <div class="mirror-hall-floor" data-aos="fade-up" data-aos-delay="200">
      <div class="mirror-counter-badge" id="mirrorCounter">
        01 / {{ sprintf('%02d', $layananTerkaits->count()) }}
      </div>
      <h3 class="mirror-active-title" id="mirrorActiveTitle">
        {{ $layananTerkaits->first()->nama ?? 'Layanan Digital' }}
      </h3>
      <p class="mirror-active-desc" id="mirrorActiveDesc">
        {{ trim(strip_tags($layananTerkaits->first()->deskripsi ?? 'Akses layanan digital terpadu Universitas Ibnu Sina')) }}
      </p>
      <a href="{{ $layananTerkaits->first()->url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="mirror-active-cta" id="mirrorActiveBtn">
        <span>Kunjungi Layanan</span>
        <i class="bi bi-arrow-right-circle-fill"></i>
      </a>
    </div>
  </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════
     13. PARTNER & KERJA SAMA (2-ROW INFINITE SLIDER)
═══════════════════════════════════════════════ -->
@if(isset($partners) && $partners->count() > 0)
<section class="section-bg-white py-5" id="mitra">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Jejaring Mitra</div>
      <h2 class="section-title">Mitra <em>Kerjasama</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Universitas Ibnu Sina bermitra dengan berbagai sektor industri terkemuka dalam penempatan magang, riset, dan rekrutmen lulusan.
      </p>
    </div>
  </div>

  @php
    $totalPartners = $partners->count();
    $half = ceil($totalPartners / 2);
    $rawRow1 = $partners->slice(0, $half);
    $rawRow2 = $partners->slice($half);

    if ($rawRow2->isEmpty()) {
        $rawRow2 = $rawRow1;
    }

    // Perbanyak item agar loop slider terasa panjang dan mulus di layar lebar
    $row1 = collect();
    while ($row1->count() < 8) {
        $row1 = $row1->concat($rawRow1);
    }
    $row2 = collect();
    while ($row2->count() < 8) {
        $row2 = $row2->concat($rawRow2);
    }
  @endphp

  <div class="marquee-wrapper" data-aos="fade-up">
    <!-- Baris 1: Bergerak ke Kiri -->
    <div class="marquee-track-container mb-3">
      <div class="marquee-track marquee-left">
        @foreach($row1 as $p)
          <div class="partner-marquee-card">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
        {{-- Duplicate Set for Continuous Loop --}}
        @foreach($row1 as $p)
          <div class="partner-marquee-card" aria-hidden="true">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
      </div>
    </div>

    <!-- Baris 2: Bergerak ke Kanan -->
    <div class="marquee-track-container">
      <div class="marquee-track marquee-right">
        @foreach($row2 as $p)
          <div class="partner-marquee-card">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
        {{-- Duplicate Set for Continuous Loop --}}
        @foreach($row2 as $p)
          <div class="partner-marquee-card" aria-hidden="true">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════
     14. FAQ (FREQUENTLY ASKED QUESTIONS)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand" id="faq">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Tanya Jawab</div>
      <h2 class="section-title">Pertanyaan yang Sering <em>Diajukan</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Jawaban seputar program studi, biaya perkuliahan, fasilitas laboratorium, dan prospek karir di Universitas Ibnu Sina.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <div class="accordion" id="homeFaqAccordion">
          @if(isset($faqs) && $faqs->count() > 0)
            @foreach($faqs->take(5) as $index => $faq)
              <div class="accordion-item shadow-sm">
                <h2 class="accordion-header" id="headingH{{ $faq->id ?? $index }}">
                  <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseH{{ $faq->id ?? $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                    <i class="bi bi-question-circle-fill me-2" style="color: var(--uis-purple);"></i>
                    {{ $faq->question ?? $faq->pertanyaan }}
                  </button>
                </h2>
                <div id="collapseH{{ $faq->id ?? $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#homeFaqAccordion">
                  <div class="accordion-body">
                    {{ trim(html_entity_decode(strip_tags($faq->answer ?? $faq->jawaban ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')) }}
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>

        <div class="text-center mt-4">
          <a href="{{ route('homepage.faq') }}" class="btn-outline-hero" style="color: var(--uis-purple); border-color: var(--uis-purple);">
            <i class="bi bi-question-circle"></i> Lihat Semua FAQ & Bantuan
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</div>{{-- /#uisHomeLayout --}}
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ── Hero Banner Carousel Auto Slide & Click / Swipe Interaction ───────────
    const heroCarouselEl = document.getElementById('heroCarousel');
    if (heroCarouselEl && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
      const carouselInstance = bootstrap.Carousel.getOrCreateInstance(heroCarouselEl, {
        interval: 4500,
        ride: 'carousel',
        pause: false,
        wrap: true,
        touch: true
      });

      // Mulai auto slide langsung saat DOM selesai dimuat
      carouselInstance.cycle();

      // Tombol Navigasi Prev / Next (Manual Click Fallback)
      const prevBtn = heroCarouselEl.querySelector('.carousel-control-prev');
      const nextBtn = heroCarouselEl.querySelector('.carousel-control-next');
      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          carouselInstance.prev();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          carouselInstance.next();
        });
      }

      // Indikator Titik / Kapsul
      const indicatorBtns = heroCarouselEl.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
      indicatorBtns.forEach((btn) => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          const targetIndex = parseInt(this.getAttribute('data-bs-slide-to'), 10);
          if (!isNaN(targetIndex)) {
            carouselInstance.to(targetIndex);
          }
        });
      });

      // Geser / Swipe Banner (Touch & Mouse Drag)
      let touchStartX = 0;
      let touchEndX = 0;
      let mouseStartX = 0;
      let isMouseDown = false;

      heroCarouselEl.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
      }, { passive: true });

      heroCarouselEl.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            carouselInstance.next();
          } else {
            carouselInstance.prev();
          }
        }
      }, { passive: true });

      heroCarouselEl.addEventListener('mousedown', function (e) {
        if (e.target.closest('.carousel-control-prev') || e.target.closest('.carousel-control-next') || e.target.closest('.carousel-indicators')) {
          return;
        }
        isMouseDown = true;
        mouseStartX = e.clientX;
        heroCarouselEl.classList.add('is-dragging');
      });

      window.addEventListener('mouseup', function (e) {
        if (!isMouseDown) return;
        isMouseDown = false;
        heroCarouselEl.classList.remove('is-dragging');
        const diff = mouseStartX - e.clientX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            carouselInstance.next();
          } else {
            carouselInstance.prev();
          }
        }
      });
    }

    if (document.querySelector('.alumniSwiper')) {
      new Swiper('.alumniSwiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: {
          delay: 3800,
          disableOnInteraction: false,
          pauseOnMouseEnter: true
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          dynamicBullets: true
        },
        navigation: {
          nextEl: '.alumni-next',
          prevEl: '.alumni-prev'
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 26
          }
        }
      });
    }

    // ── Live Search Berita Homepage ─────────────────────────────────────────
    const searchInput = document.getElementById('homepageNewsSearchInput');
    const searchForm  = document.getElementById('homepageNewsSearchForm');
    const clearBtn    = document.getElementById('homepageNewsSearchClear');
    const searchIcon  = document.getElementById('homepageNewsSearchIcon');
    const searchSpin  = document.getElementById('homepageNewsSearchSpinner');
    const gridContainer = document.getElementById('homepageNewsGridContainer');
    const seeAllBtn   = document.getElementById('btnSeeAllNews');

    let searchDebounceTimer = null;
    let searchAbortController = null;

    function performNewsSearch(query, customUrl = null) {
      if (searchSpin) searchSpin.classList.remove('d-none');
      if (searchIcon) searchIcon.classList.add('d-none');
      if (gridContainer) gridContainer.classList.add('is-loading');

      if (searchAbortController) {
        searchAbortController.abort();
      }
      searchAbortController = new AbortController();

      const url = customUrl || `{{ route('homepage') }}?q=${encodeURIComponent(query)}&page_berita=1`;

      fetch(url, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        signal: searchAbortController.signal
      })
      .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
      })
      .then(data => {
        if (gridContainer && data.html) {
          gridContainer.innerHTML = data.html;
        }

        // Update link "Lihat Berita Lainnya"
        if (seeAllBtn) {
          if (query && query.trim() !== '') {
            seeAllBtn.href = `{{ route('homepage.news') }}?q=${encodeURIComponent(query)}`;
          } else {
            seeAllBtn.href = `{{ route('homepage.news') }}`;
          }
        }

        // Update URL query string tanpa reload halaman
        const newUrl = query && query.trim() !== ''
          ? `{{ route('homepage') }}?q=${encodeURIComponent(query)}#berita`
          : `{{ route('homepage') }}#berita`;
        window.history.replaceState({ q: query }, '', newUrl);
      })
      .catch(err => {
        if (err.name !== 'AbortError') {
          console.error('Error saat mencari berita:', err);
        }
      })
      .finally(() => {
        if (searchSpin) searchSpin.classList.add('d-none');
        if (searchIcon) searchIcon.classList.remove('d-none');
        if (gridContainer) gridContainer.classList.remove('is-loading');
      });
    }

    if (searchInput) {
      searchInput.addEventListener('input', function () {
        const val = this.value;
        if (clearBtn) {
          if (val.trim().length > 0) {
            clearBtn.classList.remove('d-none');
          } else {
            clearBtn.classList.add('d-none');
          }
        }

        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
          performNewsSearch(val.trim());
        }, 300);
      });
    }

    if (clearBtn) {
      clearBtn.addEventListener('click', function () {
        if (searchInput) {
          searchInput.value = '';
          searchInput.focus();
        }
        clearBtn.classList.add('d-none');
        performNewsSearch('');
      });
    }

    if (searchForm) {
      searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(searchDebounceTimer);
        const val = searchInput ? searchInput.value.trim() : '';
        performNewsSearch(val);
      });
    }

    // Event delegation untuk tombol reset dan navigasi pagination AJAX
    document.addEventListener('click', function (e) {
      const resetBtn = e.target.closest('#btnResetNewsSearch') || e.target.closest('#btnResetNewsSearchFallback');
      if (resetBtn) {
        e.preventDefault();
        if (searchInput) {
          searchInput.value = '';
          searchInput.focus();
        }
        if (clearBtn) clearBtn.classList.add('d-none');
        performNewsSearch('');
        return;
      }

      const paginationLink = e.target.closest('#homepageNewsPaginationWrap a');
      if (paginationLink && gridContainer && gridContainer.contains(paginationLink)) {
        e.preventDefault();
        const pageHref = paginationLink.getAttribute('href');
        if (pageHref) {
          const currentQuery = searchInput ? searchInput.value.trim() : '';
          performNewsSearch(currentQuery, pageHref);

          const beritaSec = document.getElementById('berita');
          if (beritaSec) {
            beritaSec.scrollIntoView({ behavior: 'smooth' });
          }
        }
      }
    });
    // ── Continuous 3D Cylinder Horizon Motion Engine (Ormawa & Kegiatan Mahasiswa) ────────
    const ormawaViewport = document.getElementById('ormawaCylinderViewport');
    const ormawaTrack = document.getElementById('ormawaCylinderTrack');

    if (ormawaViewport && ormawaTrack) {
      const cards = Array.from(ormawaTrack.querySelectorAll('.uis-cylinder-card'));
      const totalCards = cards.length;
      const uniqueCount = {{ isset($organisasis) ? $organisasis->count() : 0 }};

      if (totalCards > 0 && uniqueCount > 0) {
        const counterEl = document.getElementById('ormawaMirrorCounter');
        const titleEl = document.getElementById('ormawaMirrorActiveTitle');
        const descEl = document.getElementById('ormawaMirrorActiveDesc');
        const btnEl = document.getElementById('ormawaMirrorActiveBtn');

        let cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
        let gap = window.innerWidth < 768 ? 14 : 22;
        let itemStep = cardWidth + gap;
        let singleCycleWidth = uniqueCount * itemStep;

        let scrollPos = 0;
        let baseSpeed = 0.85;
        let currentSpeed = baseSpeed;
        let targetSpeed = baseSpeed;
        let isDragging = false;
        let dragStartX = 0;
        let dragStartPos = 0;
        let lastDragX = 0;
        let dragVel = 0;
        let activeCardRef = null;

        function updateOrmawaDimensions() {
          cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
          gap = window.innerWidth < 768 ? 14 : 22;
          itemStep = cardWidth + gap;
          singleCycleWidth = uniqueCount * itemStep;
        }
        window.addEventListener('resize', updateOrmawaDimensions);
        updateOrmawaDimensions();

        function renderOrmawaCylinder() {
          if (!isDragging) {
            currentSpeed += (targetSpeed - currentSpeed) * 0.08;
            scrollPos += currentSpeed;

            if (Math.abs(dragVel) > 0.05) {
              scrollPos += dragVel;
              dragVel *= 0.92;
            }
          }

          if (scrollPos >= singleCycleWidth) {
            scrollPos -= singleCycleWidth;
            if (isDragging) dragStartPos -= singleCycleWidth;
          } else if (scrollPos < 0) {
            scrollPos += singleCycleWidth;
            if (isDragging) dragStartPos += singleCycleWidth;
          }

          const viewWidth = ormawaViewport.offsetWidth || window.innerWidth;
          const centerX = viewWidth / 2;
          const radius = Math.min(2400, Math.max(900, viewWidth * 1.05));
          const totalWidth = totalCards * itemStep;

          let closestCard = null;
          let minDistance = Infinity;

          for (let i = 0; i < totalCards; i++) {
            const card = cards[i];
            let cardBaseX = (i * itemStep) - scrollPos;

            while (cardBaseX - centerX < -totalWidth / 2) cardBaseX += totalWidth;
            while (cardBaseX - centerX > totalWidth / 2) cardBaseX -= totalWidth;

            const cardCenter = cardBaseX + cardWidth / 2;
            const distFromCenter = cardCenter - centerX;
            const absDist = Math.abs(distFromCenter);

            const angleRad = distFromCenter / radius;
            const angleDeg = angleRad * (180 / Math.PI);

            const transX = Math.sin(angleRad) * radius + centerX - cardWidth / 2;
            const transZ = -(1 - Math.cos(angleRad)) * radius * 0.95;
            const transY = Math.pow(Math.abs(angleRad), 1.8) * 32;

            const scale = Math.max(0.82, 1.0 - Math.abs(angleRad) * 0.16);
            const zIndex = Math.round(1000 - absDist);
            const maxVisibleDist = viewWidth * 0.58;
            const isVisible = absDist < maxVisibleDist;
            const opacity = isVisible ? Math.max(0, Math.min(1, (maxVisibleDist - absDist) / (viewWidth * 0.22))) : 0;

            card.style.transform = `translate3d(${transX}px, ${transY}px, ${transZ}px) rotateY(${-angleDeg * 1.1}deg) scale(${scale})`;
            card.style.zIndex = zIndex;
            card.style.opacity = isVisible ? opacity : 0;
            card.style.visibility = isVisible && opacity > 0.02 ? 'visible' : 'hidden';
            card.style.pointerEvents = isVisible && opacity > 0.5 ? 'auto' : 'none';

            if (absDist < minDistance) {
              minDistance = absDist;
              closestCard = card;
            }
          }

          if (closestCard && closestCard !== activeCardRef) {
            activeCardRef = closestCard;
            cards.forEach(c => c.classList.remove('is-active'));
            closestCard.classList.add('is-active');

            const name = closestCard.getAttribute('data-name');
            const desc = closestCard.getAttribute('data-desc');
            const url = closestCard.getAttribute('data-url');
            const idx = closestCard.getAttribute('data-index');
            const total = closestCard.getAttribute('data-total');

            if (counterEl && idx && total) counterEl.textContent = `${idx} / ${total}`;
            if (titleEl && name && titleEl.textContent.trim() !== name.trim()) {
              titleEl.textContent = name;
            }
            if (descEl && desc && descEl.textContent.trim() !== desc.trim()) {
              descEl.textContent = desc;
            }
            if (btnEl && url) btnEl.setAttribute('href', url);
          }

          requestAnimationFrame(renderOrmawaCylinder);
        }

        requestAnimationFrame(renderOrmawaCylinder);

        ormawaViewport.addEventListener('mouseenter', () => {
          targetSpeed = 0.2;
        });
        ormawaViewport.addEventListener('mouseleave', () => {
          if (!isDragging) targetSpeed = baseSpeed;
        });

        let hasMovedSignificantly = false;

        ormawaViewport.addEventListener('pointerdown', (e) => {
          isDragging = true;
          hasMovedSignificantly = false;
          dragStartX = e.clientX;
          dragStartPos = scrollPos;
          lastDragX = e.clientX;
          dragVel = 0;
          ormawaViewport.setPointerCapture(e.pointerId);
        });

        ormawaViewport.addEventListener('pointermove', (e) => {
          if (!isDragging) return;
          const delta = e.clientX - lastDragX;
          if (Math.abs(e.clientX - dragStartX) > 6) {
            hasMovedSignificantly = true;
          }
          dragVel = -delta;
          lastDragX = e.clientX;
          scrollPos = dragStartPos - (e.clientX - dragStartX);
        });

        function endOrmawaDrag() {
          if (!isDragging) return;
          isDragging = false;
          targetSpeed = baseSpeed;
        }

        ormawaViewport.addEventListener('pointerup', endOrmawaDrag);
        ormawaViewport.addEventListener('pointercancel', endOrmawaDrag);

        ormawaTrack.addEventListener('click', (e) => {
          if (hasMovedSignificantly) return;
          const card = e.target.closest('.uis-cylinder-card');
          if (!card) return;
          const url = card.getAttribute('data-url');

          if (card.classList.contains('is-active')) {
            if (url && url !== '#' && url.trim() !== '') {
              window.location.href = url;
            }
          } else {
            const viewWidth = ormawaViewport.offsetWidth || window.innerWidth;
            const centerX = viewWidth / 2;
            const rect = card.getBoundingClientRect();
            const vRect = ormawaViewport.getBoundingClientRect();
            const cardScreenCenter = rect.left - vRect.left + rect.width / 2;
            const diff = cardScreenCenter - centerX;
            dragVel = diff * 0.18;
          }
        });
      }
    }

    // ═══════════════════════════════════════════════
    // CONTINUOUS 3D CYLINDER HORIZON MOTION ENGINE (LAYANAN TERKAIT)
    // Transisi Berjalan Terus Menerus (Infinite Cylinder Arch)
    // ═══════════════════════════════════════════════
    const cylinderViewport = document.getElementById('uisCylinderViewport');
    const cylinderTrack = document.getElementById('uisCylinderTrack');

    if (cylinderViewport && cylinderTrack) {
      const cards = Array.from(cylinderTrack.querySelectorAll('.uis-cylinder-card'));
      const totalCards = cards.length;
      const uniqueCount = {{ $layananTerkaits->count() }};

      if (totalCards > 0) {
        const counterEl = document.getElementById('mirrorCounter');
        const titleEl = document.getElementById('mirrorActiveTitle');
        const descEl = document.getElementById('mirrorActiveDesc');
        const btnEl = document.getElementById('mirrorActiveBtn');

        let cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
        let gap = window.innerWidth < 768 ? 14 : 22;
        let itemStep = cardWidth + gap;
        let singleCycleWidth = uniqueCount * itemStep;

        // Fisika posisi & transisi terus berjalan
        let scrollPos = 0;
        let baseSpeed = 0.85; // Kecepatan gerak kontinu otomatis
        let currentSpeed = baseSpeed;
        let targetSpeed = baseSpeed;
        let isDragging = false;
        let dragStartX = 0;
        let dragStartPos = 0;
        let lastDragX = 0;
        let dragVel = 0;
        let activeCardRef = null;

        function updateDimensions() {
          cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
          gap = window.innerWidth < 768 ? 14 : 22;
          itemStep = cardWidth + gap;
          singleCycleWidth = uniqueCount * itemStep;
        }
        window.addEventListener('resize', updateDimensions);
        updateDimensions();

        function renderCylinder() {
          // Transisi terus berjalan tanpa henti
          if (!isDragging) {
            currentSpeed += (targetSpeed - currentSpeed) * 0.08;
            scrollPos += currentSpeed;

            if (Math.abs(dragVel) > 0.05) {
              scrollPos += dragVel;
              dragVel *= 0.92;
            }
          }

          // Loop tak berujung (seamless infinite wrap)
          if (scrollPos >= singleCycleWidth) {
            scrollPos -= singleCycleWidth;
            if (isDragging) dragStartPos -= singleCycleWidth;
          } else if (scrollPos < 0) {
            scrollPos += singleCycleWidth;
            if (isDragging) dragStartPos += singleCycleWidth;
          }

          const viewWidth = cylinderViewport.offsetWidth || window.innerWidth;
          const centerX = viewWidth / 2;
          const radius = Math.min(2400, Math.max(900, viewWidth * 1.05));
          const totalWidth = totalCards * itemStep;

          let closestCard = null;
          let minDistance = Infinity;

          for (let i = 0; i < totalCards; i++) {
            const card = cards[i];
            let cardBaseX = (i * itemStep) - scrollPos;

            // Sirkulasi posisi relatif terhadap titik tengah
            while (cardBaseX - centerX < -totalWidth / 2) cardBaseX += totalWidth;
            while (cardBaseX - centerX > totalWidth / 2) cardBaseX -= totalWidth;

            const cardCenter = cardBaseX + cardWidth / 2;
            const distFromCenter = cardCenter - centerX;
            const absDist = Math.abs(distFromCenter);

            // Proyeksi 3D Silinder (Lengkung U-Arch Horizon Cembung/Cekung)
            const angleRad = distFromCenter / radius;
            const angleDeg = angleRad * (180 / Math.PI);

            const transX = Math.sin(angleRad) * radius + centerX - cardWidth / 2;
            const transZ = -(1 - Math.cos(angleRad)) * radius * 0.95;
            const transY = Math.pow(Math.abs(angleRad), 1.8) * 32; // Lengkung busur atas dan bawah persis referensi

            const scale = Math.max(0.82, 1.0 - Math.abs(angleRad) * 0.16);
            const zIndex = Math.round(1000 - absDist);
            const maxVisibleDist = viewWidth * 0.58;
            const isVisible = absDist < maxVisibleDist;
            const opacity = isVisible ? Math.max(0, Math.min(1, (maxVisibleDist - absDist) / (viewWidth * 0.22))) : 0;

            card.style.transform = `translate3d(${transX}px, ${transY}px, ${transZ}px) rotateY(${-angleDeg * 1.1}deg) scale(${scale})`;
            card.style.zIndex = zIndex;
            card.style.opacity = isVisible ? opacity : 0;
            card.style.visibility = isVisible && opacity > 0.02 ? 'visible' : 'hidden';
            card.style.pointerEvents = isVisible && opacity > 0.5 ? 'auto' : 'none';

            if (absDist < minDistance) {
              minDistance = absDist;
              closestCard = card;
            }
          }

          // Sinkronisasi data kartu aktif di tengah
          if (closestCard && closestCard !== activeCardRef) {
            activeCardRef = closestCard;
            cards.forEach(c => c.classList.remove('is-active'));
            closestCard.classList.add('is-active');

            const name = closestCard.getAttribute('data-name');
            const desc = closestCard.getAttribute('data-desc');
            const url = closestCard.getAttribute('data-url');
            const idx = closestCard.getAttribute('data-index');
            const total = closestCard.getAttribute('data-total');

            if (counterEl && idx && total) counterEl.textContent = `${idx} / ${total}`;
            if (titleEl && name && titleEl.textContent.trim() !== name.trim()) {
              titleEl.textContent = name;
            }
            if (descEl && desc && descEl.textContent.trim() !== desc.trim()) {
              descEl.textContent = desc;
            }
            if (btnEl && url) btnEl.setAttribute('href', url);

            if (typeof spawnCenterRipple === 'function') {
              spawnCenterRipple();
            }
          }

          requestAnimationFrame(renderCylinder);
        }

        requestAnimationFrame(renderCylinder);

        // Hover: perlambat halus agar nyaman dibaca dan diklik
        cylinderViewport.addEventListener('mouseenter', () => {
          targetSpeed = 0.2;
        });
        cylinderViewport.addEventListener('mouseleave', () => {
          if (!isDragging) targetSpeed = baseSpeed;
        });

        let hasMovedSignificantly = false;

        cylinderViewport.addEventListener('pointerdown', (e) => {
          isDragging = true;
          hasMovedSignificantly = false;
          dragStartX = e.clientX;
          dragStartPos = scrollPos;
          lastDragX = e.clientX;
          dragVel = 0;
          cylinderViewport.setPointerCapture(e.pointerId);
        });

        cylinderViewport.addEventListener('pointermove', (e) => {
          if (!isDragging) return;
          const delta = e.clientX - lastDragX;
          if (Math.abs(e.clientX - dragStartX) > 6) {
            hasMovedSignificantly = true;
          }
          dragVel = -delta;
          lastDragX = e.clientX;
          scrollPos = dragStartPos - (e.clientX - dragStartX);
        });

        function endDrag() {
          if (!isDragging) return;
          isDragging = false;
          targetSpeed = baseSpeed;
        }

        cylinderViewport.addEventListener('pointerup', endDrag);
        cylinderViewport.addEventListener('pointercancel', endDrag);

        // Klik Card
        cylinderTrack.addEventListener('click', (e) => {
          if (hasMovedSignificantly) return; // Cegah trigger klik saat pengguna sedang drag / geser
          const card = e.target.closest('.uis-cylinder-card');
          if (!card) return;
          const url = card.getAttribute('data-url');

          if (card.classList.contains('is-active')) {
            if (url && url !== '#' && url.trim() !== '') {
              window.open(url, '_blank', 'noopener,noreferrer');
            }
          } else {
            // Bergulir mulus ke posisi tengah jika kartu samping diklik
            const viewWidth = cylinderViewport.offsetWidth || window.innerWidth;
            const centerX = viewWidth / 2;
            const rect = card.getBoundingClientRect();
            const vRect = cylinderViewport.getBoundingClientRect();
            const cardScreenCenter = rect.left - vRect.left + rect.width / 2;
            const diff = cardScreenCenter - centerX;
            dragVel = diff * 0.18; // Dorong inersia halus ke tengah
          }
        });
      }
    }

    // ═══════════════════════════════════════════════
    // EFEK CERMIN ELEGAN (WATER RIPPLE ON SLIDE / CLICK)
    // ═══════════════════════════════════════════════
    const waterCanvas = document.getElementById('mirrorWaterCanvas');
    let spawnCenterRipple = null;

    if (waterCanvas && cylinderViewport) {
        const ctx = waterCanvas.getContext('2d');
        let ripples = [];
        let animId = null;

        function resizeWaterCanvas() {
          waterCanvas.width = waterCanvas.offsetWidth || window.innerWidth;
          waterCanvas.height = waterCanvas.offsetHeight || 260;
        }
        resizeWaterCanvas();
        window.addEventListener('resize', resizeWaterCanvas);

        function spawnRipple(x, y, intensity = 1.0) {
          ripples.push({
            x: x,
            y: y,
            radius: 5,
            maxRadius: 100 * intensity,
            opacity: 0.6 * intensity,
            speed: 2.0,
            width: 1.8
          });
          if (!animId) {
            animId = requestAnimationFrame(animateRipples);
          }
        }

        spawnCenterRipple = function() {
          const rect = waterCanvas.getBoundingClientRect();
          spawnRipple(rect.width / 2, rect.height * 0.45, 1.2);
        };

        function animateRipples() {
          ctx.clearRect(0, 0, waterCanvas.width, waterCanvas.height);

          for (let i = ripples.length - 1; i >= 0; i--) {
            const r = ripples[i];
            r.radius += r.speed;
            r.opacity -= 0.016;

            if (r.opacity <= 0 || r.radius >= r.maxRadius) {
              ripples.splice(i, 1);
              continue;
            }

            // Lingkaran gelombang elips lembut di lantai cermin
            ctx.save();
            ctx.beginPath();
            ctx.ellipse(r.x, r.y, r.radius, r.radius * 0.3, 0, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(56, 189, 248, ${r.opacity * 0.6})`;
            ctx.lineWidth = r.width;
            ctx.stroke();

            // Cincin emas lembut
            if (r.radius > 14) {
              ctx.beginPath();
              ctx.ellipse(r.x, r.y, r.radius * 0.65, (r.radius * 0.65) * 0.3, 0, 0, Math.PI * 2);
              ctx.strokeStyle = `rgba(254, 216, 2, ${r.opacity * 0.35})`;
              ctx.lineWidth = r.width * 0.7;
              ctx.stroke();
            }
            ctx.restore();
          }

          if (ripples.length > 0) {
            animId = requestAnimationFrame(animateRipples);
          } else {
            animId = null;
          }
        }

        waterCanvas.addEventListener('click', function(e) {
          const rect = waterCanvas.getBoundingClientRect();
          spawnRipple(e.clientX - rect.left, Math.max(20, Math.min(e.clientY - rect.top, rect.height - 20)), 1.2);
        });
      }
  });
</script>
@endpush
