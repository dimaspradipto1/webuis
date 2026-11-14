@extends('layouts.frontend.template')

@section('title', 'Program Beasiswa — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Informasi resmi program beasiswa Universitas Ibnu Sina (UIS) Batam: Beasiswa KIP-Kuliah, Prestasi Akademik, Tahfidz Al-Qur\'an, Mitra Industri, dan Afirmasi Daerah.')
@section('meta_keywords', 'beasiswa uis, beasiswa universitas ibnu sina, kip kuliah uis, beasiswa batam, beasiswa tahfidz batam, beasiswa prestasi')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════════════════════
     PROGRAM BEASISWA STYLES — UIS GREEN & GOLD MODERN THEME
     Dioptimalkan khusus layar laptop 14" & desktop:
     Tinggi / Spacing / Margin Rapat, Ringkas, dan Proporsional
  ═══════════════════════════════════════════════════════════════ */
  :root {
    --uis-green: #046B26;
    --uis-green-dark: #024317;
    --uis-green-light: #eaf6ee;
    --uis-yellow: #FED802;
    --uis-yellow-hover: #e5c302;
  }

  /* RESET MUTLAK PADDING 80px DEFAULT DARI GLOBAL SECTION */
  .beasiswa-page-wrapper section,
  section.beasiswa-section {
    padding: 0 !important;
  }

  /* Compact About Hero Breadcrumb */
  .about-hero {
    padding: 24px 0 20px !important;
    border-bottom: 2px solid var(--uis-yellow) !important;
  }
  .about-hero-title {
    font-size: clamp(22px, 2.5vw, 28px) !important;
    margin-bottom: 4px !important;
  }
  .breadcrumb-custom {
    font-size: 12.5px !important;
  }

  /* Callout Card Status */
  .beasiswa-callout-card {
    background: #ffffff;
    border: 1px solid #e3ebe5;
    border-radius: 16px;
    padding: 16px 22px;
    box-shadow: 0 4px 16px rgba(4, 107, 38, 0.05);
    border-left: 5px solid var(--uis-green);
    margin-top: 14px;
    margin-bottom: 14px;
  }
  .beasiswa-badge-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #eaf6ee;
    border: 1px solid #cce8d4;
    color: var(--uis-green);
    padding: 3px 10px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.3px;
  }
  .beasiswa-pulse-dot {
    width: 7px;
    height: 7px;
    background-color: var(--uis-green);
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(4, 107, 38, 0.7);
    animation: beasiswaPulse 1.8s infinite;
  }
  @keyframes beasiswaPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(4, 107, 38, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(4, 107, 38, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(4, 107, 38, 0); }
  }

  /* Stats Cards Grid */
  .beasiswa-stats-row {
    margin-bottom: 16px;
  }
  .beasiswa-stat-box {
    background: #ffffff;
    border: 1px solid #e2ebe4;
    border-radius: 12px;
    padding: 12px 14px;
    box-shadow: 0 3px 10px rgba(4, 107, 38, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .beasiswa-stat-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(4, 107, 38, 0.08);
    border-color: #cce3d2;
  }
  .beasiswa-stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: #eaf6ee;
    color: var(--uis-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .beasiswa-stat-value {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 18px;
    font-weight: 800;
    color: #12351f;
    line-height: 1.1;
  }
  .beasiswa-stat-label {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
    font-weight: 500;
  }

  /* Overview & Showcase */
  .beasiswa-overview-card {
    background: #ffffff;
    border: 1px solid #e3ebe5;
    border-radius: 16px;
    padding: clamp(16px, 2.5vw, 24px);
    box-shadow: 0 4px 18px rgba(12, 47, 25, 0.04);
    margin-bottom: 16px;
  }
  .beasiswa-section-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--uis-green);
    background: #eaf6ee;
    border: 1px solid #d4ebdc;
    letter-spacing: 0.4px;
    margin-bottom: 8px;
    text-transform: uppercase;
  }
  .beasiswa-section-heading {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.25rem, 1.8vw, 1.6rem);
    font-weight: 800;
    color: #12351f;
    line-height: 1.25;
    margin-bottom: 10px;
    letter-spacing: -0.02em;
  }
  .beasiswa-desc-lead {
    font-size: 13.5px;
    line-height: 1.6;
    color: #334155;
    margin-bottom: 8px;
  }
  .beasiswa-feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .beasiswa-feature-list li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-bottom: 7px;
    font-size: 13px;
    color: #334155;
    line-height: 1.45;
  }
  .beasiswa-feature-list i {
    color: var(--uis-green);
    font-size: 15px;
    margin-top: 1px;
    flex-shrink: 0;
  }

  /* Image Showcase Box */
  .beasiswa-img-box {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 22px rgba(4, 107, 38, 0.12);
    height: 100%;
    min-height: 280px;
    background: #046B26;
  }
  .beasiswa-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }
  .beasiswa-img-box:hover img {
    transform: scale(1.02);
  }
  .beasiswa-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(4, 107, 38, 0.05) 0%, rgba(2, 56, 20, 0.85) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 16px;
    color: #fff;
  }
  .beasiswa-img-caption {
    background: rgba(4, 107, 38, 0.88);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(254, 216, 2, 0.4);
    border-radius: 10px;
    padding: 12px;
  }
  .beasiswa-img-caption h5 {
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .beasiswa-img-caption p {
    color: rgba(255, 255, 255, 0.88);
    font-size: 11.5px;
    margin-bottom: 0;
    line-height: 1.45;
  }

  /* Dropdown Selector Bar */
  .beasiswa-selector-card {
    background: #f8faf9;
    border: 1.5px solid #d4ebdc;
    border-radius: 14px;
    padding: 10px 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(4, 107, 38, 0.03);
  }
  .beasiswa-select-control {
    border: 2px solid #046B26;
    border-radius: 8px;
    padding: 7px 12px;
    font-size: 13.5px;
    font-weight: 700;
    color: #12351f;
    background-color: #ffffff;
    box-shadow: 0 2px 6px rgba(4, 107, 38, 0.04);
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .beasiswa-select-control:focus {
    border-color: var(--uis-yellow);
    box-shadow: 0 0 0 0.15rem rgba(4, 107, 38, 0.15);
  }

  /* Accordion Item Styling */
  .beasiswa-accordion .accordion-item {
    border: 1.5px solid #e2ebe4;
    border-radius: 14px !important;
    margin-bottom: 10px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(12, 47, 25, 0.03);
    transition: all 0.2s ease;
  }
  .beasiswa-accordion .accordion-item:hover,
  .beasiswa-accordion .accordion-item.is-highlighted {
    border-color: #046B26;
    box-shadow: 0 6px 18px rgba(4, 107, 38, 0.08);
  }
  .beasiswa-accordion .accordion-button {
    padding: 12px 16px;
    background: #ffffff;
    color: #12351f;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    box-shadow: none !important;
    gap: 12px;
  }
  .beasiswa-accordion .accordion-button:not(.collapsed) {
    background: #eaf6ee;
    color: var(--uis-green);
    border-bottom: 1.5px solid #d4ebdc;
  }
  .beasiswa-acc-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #edf7f0;
    color: var(--uis-green);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    transition: all 0.2s ease;
  }
  .beasiswa-accordion .accordion-button:not(.collapsed) .beasiswa-acc-icon {
    background: var(--uis-green);
    color: #ffffff;
  }
  .beasiswa-pill-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 999px;
    letter-spacing: 0.3px;
    background: #fdf5d3;
    color: #8c7302;
    border: 1px solid #fae69e;
    white-space: nowrap;
    text-align: center;
    width: 220px;
    display: inline-block;
  }
  @media (max-width: 991px) {
    .beasiswa-pill-tag {
      width: 170px;
      font-size: 10.5px;
      padding: 3px 8px;
    }
  }
  @media (max-width: 576px) {
    .beasiswa-pill-tag {
      width: auto;
      font-size: 10px;
      padding: 2px 6px;
    }
  }
  .beasiswa-accordion .accordion-body {
    padding: 16px 18px;
    background: #ffffff;
  }

  /* Inside Accordion Details */
  .beasiswa-detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 12px;
    margin-top: 12px;
  }
  .beasiswa-detail-box {
    background: #f8faf9;
    border: 1px solid #e3ebe5;
    border-radius: 10px;
    padding: 12px 14px;
  }
  .beasiswa-detail-box h6 {
    font-weight: 700;
    font-size: 12.5px;
    color: var(--uis-green);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .beasiswa-detail-box ul {
    margin: 0;
    padding-left: 16px;
    font-size: 12px;
    color: #334155;
    line-height: 1.55;
  }

  /* Steps Timeline */
  .beasiswa-step-box {
    text-align: center;
    padding: 14px 12px;
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2ebe4;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    height: 100%;
    position: relative;
    transition: transform 0.2s ease;
  }
  .beasiswa-step-box:hover {
    transform: translateY(-2px);
    border-color: #046B26;
  }
  .beasiswa-step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--uis-green);
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    box-shadow: 0 3px 8px rgba(4, 107, 38, 0.18);
    border: 2px solid var(--uis-yellow);
  }
  .beasiswa-step-box h5 {
    font-size: 13.5px;
    font-weight: 700;
    color: #12351f;
    margin-bottom: 4px;
  }
  .beasiswa-step-box p {
    font-size: 11.5px;
    color: #64748b;
    margin: 0;
    line-height: 1.45;
  }

</style>
@endpush

@section('content')
<!-- ═══════════════════════════════════════════════
     HEADER HERO BANNER & BREADCRUMB (SESUAI ACUAN TENTANG UIS)
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="about-hero-title">
        Program <em>Beasiswa</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Program Beasiswa</span>
      </div>
    </div>
  </div>
</div>

<div class="beasiswa-page-wrapper">

  @php
    $defaultPmb = $pmbSetting->tombol_link_1 ?? route('homepage.kontak');
    if (!str_starts_with($defaultPmb, 'http') && !str_starts_with($defaultPmb, '/')) {
        $defaultPmb = '/' . $defaultPmb;
    }
    $pmbLink = !empty($beasiswaSetting->link_daftar) ? $beasiswaSetting->link_daftar : $defaultPmb;
  @endphp

  {{-- STATUS PENDAFTARAN & AJAKAN BEASISWA --}}
  <section class="container beasiswa-section">
    <div class="beasiswa-callout-card" data-aos="fade-up">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          @if(!empty($beasiswaSetting->hero_badge))
          <div class="beasiswa-badge-status mb-2">
            <span class="beasiswa-pulse-dot"></span>
            <span>{{ $beasiswaSetting->hero_badge }}</span>
          </div>
          @endif

          <h2 class="fw-bold text-dark mb-1" style="font-size: clamp(1.2rem, 1.6vw, 1.55rem); letter-spacing: -0.02em;">
            {{ $beasiswaSetting->hero_judul ?? 'Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina' }}
          </h2>

          <p class="text-secondary mb-0" style="font-size: 13.5px; line-height: 1.65;">
            {{ $beasiswaSetting->hero_deskripsi ?? "Universitas Ibnu Sina (UIS) Batam berkomitmen memberikan akses pendidikan tinggi bermutu melalui berbagai skema beasiswa penuh (100% Bebas SPP) maupun beasiswa potongan biaya pendidikan bagi calon mahasiswa berprestasi, tahfidz Al-Qur'an, dan mitra industri." }}
          </p>
        </div>

        <div class="col-lg-4 text-center text-lg-end">
          <div class="d-flex flex-column gap-2 justify-content-center">
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-warning px-3 py-2 fw-bold text-dark shadow-sm rounded-pill" style="background: var(--uis-yellow); border-color: var(--uis-yellow); font-size: 13.5px;">
              <i class="bi bi-pencil-square me-2"></i>{{ $beasiswaSetting->tombol_daftar_teks ?: 'Daftar Jalur Beasiswa' }}
            </a>
            @php
              $customWa = !empty($beasiswaSetting->link_wa) 
                  ? (str_starts_with($beasiswaSetting->link_wa, 'http') ? $beasiswaSetting->link_wa : ('https://wa.me/' . preg_replace('/[^0-9]/', '', $beasiswaSetting->link_wa)))
                  : ($waAdminSetting->wa_url ?? '');
              $showWa = $beasiswaSetting->show_wa ?? true;
            @endphp
            @if($showWa && !empty($customWa))
            <a href="{{ $customWa }}" target="_blank" class="btn btn-outline-success px-3 py-2 fw-semibold rounded-pill" style="font-size: 13px;">
              <i class="bi bi-whatsapp me-2"></i>{{ $beasiswaSetting->tombol_wa_teks ?: 'Konsultasi via WhatsApp' }}
            </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- STATS HIGHLIGHT ROW (DINAMIS DARI ADMIN) --}}
  @php
    $stats = $beasiswaSetting->effective_stats ?? [];
  @endphp
  @if(count($stats) > 0)
  <section class="container beasiswa-section beasiswa-stats-row">
    <div class="row g-2 g-md-3">
      @foreach($stats as $st)
        <div class="col-6 col-lg-3">
          <div class="beasiswa-stat-box">
            <div class="beasiswa-stat-icon"><i class="bi {{ $st['icon'] ?? 'bi-star-fill' }}"></i></div>
            <div>
              <div class="beasiswa-stat-value">{{ $st['nilai'] ?? '-' }}</div>
              <div class="beasiswa-stat-label">{{ $st['label'] ?? '' }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>
  @endif

  {{-- OVERVIEW & IMAGE SHOWCASE (DINAMIS DARI ADMIN) --}}
  <section class="container beasiswa-section mb-3">
    <div class="beasiswa-overview-card">
      <div class="row g-3 g-lg-4 align-items-center">
        <div class="col-lg-6">
          <span class="beasiswa-section-tag"><i class="bi bi-info-circle-fill"></i> Tentang Program Beasiswa UIS</span>
          <h2 class="beasiswa-section-heading">{{ $beasiswaSetting->tentang_judul ?? 'Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya' }}</h2>

          @if(!empty($beasiswaSetting->tentang_deskripsi))
            @php
              $paragrafList = array_values(array_filter(
                array_map('trim', explode("\n", str_replace("\r", "", $beasiswaSetting->tentang_deskripsi))),
                fn($line) => $line !== ''
              ));
            @endphp
            @foreach($paragrafList as $pText)
              <p class="beasiswa-desc-lead mb-2">{{ $pText }}</p>
            @endforeach
          @else
            <p class="beasiswa-desc-lead mb-2">
              Sebagai institusi pendidikan tinggi terkemuka di Kota Batam yang berlandaskan nilai-nilai <strong>Iman, Ilmu, dan Amal</strong>, Universitas Ibnu Sina meyakini bahwa keterbatasan finansial tidak boleh menjadi penghalang bagi putra-putri bangsa untuk meraih gelar Sarjana (S1) maupun Magister (S2).
            </p>
            <p class="beasiswa-desc-lead mb-2">
              Program Beasiswa UIS dirancang secara komprehensif bersama Kementerian Pendidikan, Pemerintah Daerah, Yayasan Pendidikan Ibnu Sina Batam (YAPISNA), serta asosiasi industri multinasional.
            </p>
          @endif

          {{-- KEUNGGULAN LIST (DINAMIS) --}}
          @php
            $keunggulanList = $beasiswaSetting->effective_keunggulan ?? [];
          @endphp
          @if(count($keunggulanList) > 0)
            <ul class="beasiswa-feature-list mt-2">
              @foreach($keunggulanList as $itemKeunggulan)
                <li><i class="bi bi-check-circle-fill"></i> <span>{{ $itemKeunggulan }}</span></li>
              @endforeach
            </ul>
          @endif
        </div>

        <div class="col-lg-6">
          <div class="beasiswa-img-box">
            @php
              $showcaseImg = !empty($beasiswaSetting->gambar) 
                  ? asset('storage/' . $beasiswaSetting->gambar)
                  : asset('storage/hero-humas/OwjSPkWxjRYVTkK9HyY1BvnXg8pFas3SNLMnFYTI.jpg');
            @endphp
            <img src="{{ $showcaseImg }}"
                 onerror="this.onerror=null; this.src='{{ asset('assets/img/logouis.png') }}';"
                 alt="Gedung Kampus Universitas Ibnu Sina Batam">
            <div class="beasiswa-img-overlay">
              <div class="beasiswa-img-caption">
                <h5>Kampus Terpadu Universitas Ibnu Sina</h5>
                <p>Mencetak generasi profesional muda berdaya saing global dengan fasilitas laboratorium modern & kurikulum industri.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- DROPDOWN SELECTOR & DESKRIPSI ACCORDION (DINAMIS DARI ADMIN) --}}
  @php
    $jalurList = $beasiswaSetting->effective_jalur ?? [];
  @endphp
  <section class="container beasiswa-section mb-3" id="jalur-beasiswa-section">
    <div class="text-center mb-2">
      <span class="beasiswa-section-tag"><i class="bi bi-grid-fill"></i> Pilihan Kategori Beasiswa</span>
      <h2 class="beasiswa-section-heading">Jelajahi Jalur Beasiswa yang Tersedia</h2>
      <p class="text-muted mx-auto mb-0" style="max-width: 650px; font-size: 13px;">
        Gunakan dropdown di bawah ini untuk memilih dan melihat rincian persyaratan, manfaat, serta cakupan setiap jalur beasiswa di Universitas Ibnu Sina.
      </p>
    </div>

    {{-- DROPDOWN FILTER BAR --}}
    <div class="beasiswa-selector-card">
      <div class="row align-items-center g-2">
        <div class="col-md-4">
          <label for="selectJalurBeasiswa" class="form-label fw-bold mb-0 text-dark" style="font-size: 13px;">
            <i class="bi bi-funnel-fill text-success me-1"></i>Pilih Dropdown Jalur Beasiswa:
          </label>
        </div>
        <div class="col-md-8">
          <select id="selectJalurBeasiswa" class="form-select beasiswa-select-control" onchange="onSelectJalur(this.value)">
            <option value="all">-- Tampilkan Semua Jalur Beasiswa --</option>
            @foreach($jalurList as $idx => $j)
              <option value="{{ $j['id'] ?? ('collapse_jalur_' . ($idx + 1)) }}">
                {{ ($idx + 1) }}. {{ $j['judul'] ?? 'Jalur Beasiswa' }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    {{-- ACCORDION DROPDOWN LIST (DESKRIPSI DARI DROPDOWN) --}}
    <div class="accordion beasiswa-accordion" id="accordionBeasiswa">
      @foreach($jalurList as $idx => $j)
        @php
          $cid = $j['id'] ?? ('collapse_jalur_' . ($idx + 1));
          $isFirst = ($idx === 0);
        @endphp
        <div class="accordion-item" id="item-{{ $cid }}">
          <h2 class="accordion-header" id="heading-{{ $cid }}">
            <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $cid }}" aria-expanded="{{ $isFirst ? 'true' : 'false' }}" aria-controls="{{ $cid }}">
              <div class="beasiswa-acc-icon"><i class="bi {{ $j['icon'] ?? 'bi-mortarboard-fill' }}"></i></div>
              <div class="flex-grow-1 me-2" style="min-width: 0;">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                  <span class="fw-bold text-dark beasiswa-jalur-title">{{ $j['judul'] ?? 'Jalur Beasiswa' }}</span>
                  @if(!empty($j['badge']))
                    <span class="beasiswa-pill-tag ms-auto flex-shrink-0">{{ $j['badge'] }}</span>
                  @endif
                </div>
                @if(!empty($j['ringkasan']))
                  <small class="text-muted fw-normal d-block text-truncate" style="font-size: 12px;">{{ $j['ringkasan'] }}</small>
                @endif
              </div>
            </button>
          </h2>
          <div id="{{ $cid }}" class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}" aria-labelledby="heading-{{ $cid }}" data-bs-parent="#accordionBeasiswa">
            <div class="accordion-body">
              @if(!empty($j['deskripsi']))
                <p class="text-secondary mb-2" style="font-size: 13px; line-height: 1.6;">
                  {{ $j['deskripsi'] }}
                </p>
              @endif

              <div class="beasiswa-detail-grid">
                {{-- MANFAAT / FASILITAS --}}
                @if(!empty($j['manfaat']))
                  <div class="beasiswa-detail-box">
                    <h6><i class="bi bi-gift-fill"></i> Cakupan & Fasilitas Beasiswa</h6>
                    <ul>
                      @foreach(explode("\n", str_replace("\r", "", $j['manfaat'])) as $mItem)
                        @if(trim($mItem) !== '')
                          <li>{{ trim($mItem) }}</li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                @endif

                {{-- PERSYARATAN DOKUMEN --}}
                @if(!empty($j['syarat']))
                  <div class="beasiswa-detail-box">
                    <h6><i class="bi bi-card-checklist"></i> Persyaratan Dokumen & Ketentuan</h6>
                    <ul>
                      @foreach(explode("\n", str_replace("\r", "", $j['syarat'])) as $sItem)
                        @if(trim($sItem) !== '')
                          <li>{{ trim($sItem) }}</li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                @endif
              </div>

              <div class="mt-2 pt-2 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span class="text-muted small" style="font-size: 11.5px;">
                  <i class="bi bi-clock-history me-1"></i> {{ $j['periode'] ?? 'Mengikuti jadwal resmi PMB UIS' }}
                </span>
                <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill fw-semibold" style="font-size: 12px;">
                  <i class="bi bi-arrow-right-circle me-1"></i> Daftar {{ $j['judul'] ?? 'Jalur Ini' }}
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- TAHAPAN PENDAFTARAN BEASISWA (DINAMIS DARI ADMIN) --}}
  @php
    $alurList = $beasiswaSetting->effective_alur ?? [];
  @endphp
  @if(count($alurList) > 0)
  <section class="container beasiswa-section mb-3">
    <div class="text-center mb-2">
      <span class="beasiswa-section-tag"><i class="bi bi-signpost-split-fill"></i> Langkah Mudah</span>
      <h2 class="beasiswa-section-heading">Alur Pendaftaran Beasiswa UIS</h2>
      <p class="text-muted mx-auto mb-0" style="max-width: 600px; font-size: 13px;">
        Empat tahapan terstruktur mulai dari pendaftaran online hingga penetapan kelulusan beasiswa.
      </p>
    </div>

    <div class="row g-2 g-md-3">
      @foreach($alurList as $idx => $al)
        <div class="col-sm-6 col-lg-3">
          <div class="beasiswa-step-box">
            <div class="beasiswa-step-num">{{ $al['nomor'] ?? ($idx + 1) }}</div>
            <h5>{{ $al['judul'] ?? ('Tahap ' . ($idx + 1)) }}</h5>
            <p>{{ $al['deskripsi'] ?? '' }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </section>
  @endif

  {{-- FAQ BEASISWA (DINAMIS DARI ADMIN) --}}
  @php
    $faqList = $beasiswaSetting->effective_faq ?? [];
  @endphp
  @if(count($faqList) > 0)
  <section class="container beasiswa-section mb-4">
    <div class="beasiswa-overview-card p-3">
      <div class="text-center mb-2">
        <span class="beasiswa-section-tag"><i class="bi bi-question-circle-fill"></i> Pertanyaan Umum</span>
        <h3 class="fw-bold text-dark mb-1" style="font-size: clamp(1.2rem, 1.5vw, 1.45rem);">FAQ Seputar Program Beasiswa UIS</h3>
        <p class="text-muted small mb-0">Jawaban resmi atas pertanyaan yang paling sering diajukan seputar beasiswa.</p>
      </div>

      <div class="accordion accordion-flush" id="faqBeasiswaAccordion">
        @foreach($faqList as $fIdx => $fq)
          <div class="accordion-item border-bottom py-1">
            <h2 class="accordion-header" id="faqH_{{ $fIdx }}">
              <button class="accordion-button collapsed fw-bold text-dark bg-transparent py-2" type="button" data-bs-toggle="collapse" data-bs-target="#faqB_{{ $fIdx }}" aria-expanded="false" style="font-size: 13.5px;">
                {{ $fq['tanya'] ?? '' }}
              </button>
            </h2>
            <div id="faqB_{{ $fIdx }}" class="accordion-collapse collapse" data-bs-parent="#faqBeasiswaAccordion">
              <div class="accordion-body text-secondary pt-0 pb-2" style="font-size: 13px; line-height: 1.6;">
                {{ $fq['jawab'] ?? '' }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

</div>
@endsection

@push('scripts')
<script>
  function onSelectJalur(collapseId) {
    if (!collapseId || collapseId === 'all') {
      // Buka semua item accordion
      document.querySelectorAll('#accordionBeasiswa .accordion-collapse').forEach(function(el) {
        var bsCollapse = bootstrap.Collapse.getOrCreateInstance(el, { toggle: false });
        bsCollapse.show();
      });
      document.querySelectorAll('#accordionBeasiswa .accordion-item').forEach(function(el) {
        el.classList.remove('is-highlighted');
      });
      return;
    }

    // Tutup yang lain, buka yang dipilih
    document.querySelectorAll('#accordionBeasiswa .accordion-collapse').forEach(function(el) {
      var bsCollapse = bootstrap.Collapse.getOrCreateInstance(el, { toggle: false });
      if (el.id === collapseId) {
        bsCollapse.show();
      } else {
        bsCollapse.hide();
      }
    });

    // Highlight dan scroll ke item yang dipilih
    var targetItem = document.getElementById('item-' + collapseId);
    if (targetItem) {
      document.querySelectorAll('#accordionBeasiswa .accordion-item').forEach(function(el) {
        el.classList.remove('is-highlighted');
      });
      targetItem.classList.add('is-highlighted');

      // Smooth scroll ke accordion terkait
      var yOffset = -90;
      var y = targetItem.getBoundingClientRect().top + window.pageYOffset + yOffset;
      window.scrollTo({ top: y, behavior: 'smooth' });
    }
  }
</script>
@endpush
