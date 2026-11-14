@extends('layouts.frontend.template')

@section('title', 'Program Beasiswa — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Informasi resmi program beasiswa Universitas Ibnu Sina (UIS) Batam: Beasiswa KIP-Kuliah, Prestasi Akademik, Tahfidz Al-Qur\'an, Mitra Industri, dan Afirmasi Daerah.')
@section('meta_keywords', 'beasiswa uis, beasiswa universitas ibnu sina, kip kuliah uis, beasiswa batam, beasiswa tahfidz batam, beasiswa prestasi')

@push('styles')
<style>
  /* ═══════════════════════════════════════════════════════════════
     PROGRAM BEASISWA STYLES — UIS GREEN & GOLD MODERN THEME
  ═══════════════════════════════════════════════════════════════ */
  :root {
    --uis-green: #046B26;
    --uis-green-dark: #024317;
    --uis-green-light: #eaf6ee;
    --uis-yellow: #FED802;
    --uis-yellow-hover: #e5c302;
  }

  /* Callout Card Status */
  .beasiswa-callout-card {
    background: #ffffff;
    border: 1px solid #e3ebe5;
    border-radius: 20px;
    padding: clamp(22px, 3.5vw, 32px);
    box-shadow: 0 8px 24px rgba(4, 107, 38, 0.05);
    border-left: 5px solid var(--uis-green);
    margin-top: 32px;
    margin-bottom: 28px;
  }
  .beasiswa-badge-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #eaf6ee;
    border: 1px solid #cce8d4;
    color: var(--uis-green);
    padding: 5px 14px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 0.3px;
  }
  .beasiswa-pulse-dot {
    width: 8px;
    height: 8px;
    background-color: var(--uis-green);
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(4, 107, 38, 0.7);
    animation: beasiswaPulse 1.8s infinite;
  }
  @keyframes beasiswaPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(4, 107, 38, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 7px rgba(4, 107, 38, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(4, 107, 38, 0); }
  }

  /* Stats Cards Grid */
  .beasiswa-stats-row {
    margin-bottom: 44px;
  }
  .beasiswa-stat-box {
    background: #ffffff;
    border: 1px solid #e2ebe4;
    border-radius: 16px;
    padding: 20px 18px;
    box-shadow: 0 6px 20px rgba(4, 107, 38, 0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .beasiswa-stat-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(4, 107, 38, 0.1);
    border-color: #cce3d2;
  }
  .beasiswa-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #eaf6ee;
    color: var(--uis-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }
  .beasiswa-stat-value {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: #12351f;
    line-height: 1.1;
  }
  .beasiswa-stat-label {
    font-size: 12.5px;
    color: #64748b;
    margin-top: 3px;
    font-weight: 500;
  }

  /* Overview & Showcase */
  .beasiswa-overview-card {
    background: #ffffff;
    border: 1px solid #e3ebe5;
    border-radius: 24px;
    padding: clamp(24px, 4vw, 44px);
    box-shadow: 0 8px 30px rgba(12, 47, 25, 0.05);
    margin-bottom: 48px;
  }
  .beasiswa-section-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--uis-green);
    background: #eaf6ee;
    border: 1px solid #d4ebdc;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    text-transform: uppercase;
  }
  .beasiswa-section-heading {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.5rem, 2.2vw, 1.95rem);
    font-weight: 800;
    color: #12351f;
    line-height: 1.3;
    margin-bottom: 16px;
    letter-spacing: -0.02em;
  }
  .beasiswa-desc-lead {
    font-size: 15px;
    line-height: 1.8;
    color: #334155;
    margin-bottom: 20px;
  }
  .beasiswa-feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px;
  }
  .beasiswa-feature-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 10px;
    font-size: 14px;
    color: #334155;
  }
  .beasiswa-feature-list i {
    color: var(--uis-green);
    font-size: 17px;
    margin-top: 1px;
    flex-shrink: 0;
  }

  /* Image Showcase Box */
  .beasiswa-img-box {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 14px 36px rgba(4, 107, 38, 0.16);
    height: 100%;
    min-height: 360px;
    background: #046B26;
  }
  .beasiswa-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
  }
  .beasiswa-img-box:hover img {
    transform: scale(1.03);
  }
  .beasiswa-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(4, 107, 38, 0.05) 0%, rgba(2, 56, 20, 0.88) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 24px;
    color: #fff;
  }
  .beasiswa-img-caption {
    background: rgba(4, 107, 38, 0.88);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(254, 216, 2, 0.4);
    border-radius: 14px;
    padding: 16px;
  }
  .beasiswa-img-caption h5 {
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 4px;
  }
  .beasiswa-img-caption p {
    color: rgba(255, 255, 255, 0.85);
    font-size: 12.5px;
    margin-bottom: 0;
  }

  /* Dropdown Selector Bar */
  .beasiswa-selector-card {
    background: #f8faf9;
    border: 1.5px solid #d4ebdc;
    border-radius: 18px;
    padding: 18px 22px;
    margin-bottom: 24px;
    box-shadow: 0 4px 16px rgba(4, 107, 38, 0.04);
  }
  .beasiswa-select-control {
    border: 2px solid #046B26;
    border-radius: 12px;
    padding: 11px 16px;
    font-size: 14.5px;
    font-weight: 700;
    color: #12351f;
    background-color: #ffffff;
    box-shadow: 0 3px 10px rgba(4, 107, 38, 0.06);
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .beasiswa-select-control:focus {
    border-color: var(--uis-yellow);
    box-shadow: 0 0 0 0.25rem rgba(4, 107, 38, 0.15);
  }

  /* Accordion Item Styling */
  .beasiswa-accordion .accordion-item {
    border: 1.5px solid #e2ebe4;
    border-radius: 18px !important;
    margin-bottom: 16px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 4px 18px rgba(12, 47, 25, 0.04);
    transition: all 0.25s ease;
  }
  .beasiswa-accordion .accordion-item:hover,
  .beasiswa-accordion .accordion-item.is-highlighted {
    border-color: #046B26;
    box-shadow: 0 10px 28px rgba(4, 107, 38, 0.1);
  }
  .beasiswa-accordion .accordion-button {
    padding: 20px 22px;
    background: #ffffff;
    color: #12351f;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 16.5px;
    border: none;
    box-shadow: none !important;
    gap: 16px;
  }
  .beasiswa-accordion .accordion-button:not(.collapsed) {
    background: #eaf6ee;
    color: var(--uis-green);
    border-bottom: 1.5px solid #d4ebdc;
  }
  .beasiswa-acc-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #edf7f0;
    color: var(--uis-green);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    transition: all 0.25s ease;
  }
  .beasiswa-accordion .accordion-button:not(.collapsed) .beasiswa-acc-icon {
    background: var(--uis-green);
    color: #ffffff;
  }
  .beasiswa-pill-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 999px;
    letter-spacing: 0.3px;
    background: #fdf5d3;
    color: #8c7302;
    border: 1px solid #fae69e;
  }
  .beasiswa-accordion .accordion-body {
    padding: 24px 26px;
    background: #ffffff;
  }

  /* Inside Accordion Details */
  .beasiswa-detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 18px;
    margin-top: 18px;
  }
  .beasiswa-detail-box {
    background: #f8faf9;
    border: 1px solid #e3ebe5;
    border-radius: 14px;
    padding: 16px 18px;
  }
  .beasiswa-detail-box h6 {
    font-weight: 700;
    font-size: 13.5px;
    color: var(--uis-green);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .beasiswa-detail-box ul {
    margin: 0;
    padding-left: 18px;
    font-size: 13px;
    color: #334155;
    line-height: 1.7;
  }

  /* Steps Timeline */
  .beasiswa-step-box {
    text-align: center;
    padding: 22px 16px;
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2ebe4;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    height: 100%;
    position: relative;
  }
  .beasiswa-step-num {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--uis-green);
    color: #ffffff;
    font-weight: 800;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    box-shadow: 0 5px 14px rgba(4, 107, 38, 0.22);
    border: 3px solid var(--uis-yellow);
  }
  .beasiswa-step-box h5 {
    font-size: 15px;
    font-weight: 700;
    color: #12351f;
    margin-bottom: 6px;
  }
  .beasiswa-step-box p {
    font-size: 12.5px;
    color: #64748b;
    margin: 0;
    line-height: 1.6;
  }

  /* Bottom CTA Banner */
  .beasiswa-cta-banner {
    background: linear-gradient(135deg, #023814 0%, #046B26 65%, #088a33 100%);
    border-radius: 24px;
    padding: clamp(30px, 4.5vw, 50px);
    color: #ffffff;
    box-shadow: 0 14px 40px rgba(4, 107, 38, 0.18);
    border: 2px solid var(--uis-yellow);
    position: relative;
    overflow: hidden;
    margin-top: 48px;
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

{{-- STATUS PENDAFTARAN & AJAKAN BEASISWA --}}
<section class="container">
  <div class="beasiswa-callout-card" data-aos="fade-up">
    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        @if(!empty($beasiswaSetting->hero_badge ?? 'PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA'))
        <div class="beasiswa-badge-status mb-3">
          <span class="beasiswa-pulse-dot"></span>
          <span>{{ $beasiswaSetting->hero_badge ?? 'PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA' }}</span>
        </div>
        @endif

        <h2 class="fw-bold text-dark mb-2" style="font-size: clamp(1.4rem, 2vw, 1.85rem); letter-spacing: -0.02em;">
          {{ $beasiswaSetting->hero_judul ?? 'Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina' }}
        </h2>

        <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.75;">
          {{ $beasiswaSetting->hero_deskripsi ?? "Universitas Ibnu Sina (UIS) Batam berkomitmen memberikan akses pendidikan tinggi bermutu melalui berbagai skema beasiswa penuh (100% Bebas SPP) maupun beasiswa potongan biaya pendidikan bagi calon mahasiswa berprestasi, tahfidz Al-Qur'an, dan mitra industri." }}
        </p>
      </div>

      <div class="col-lg-4 text-center text-lg-end">
        @php
          $defaultPmb = $pmbSetting->tombol_link_1 ?? route('homepage.kontak');
          if (!str_starts_with($defaultPmb, 'http') && !str_starts_with($defaultPmb, '/')) {
              $defaultPmb = '/' . $defaultPmb;
          }
          $pmbLink = !empty($beasiswaSetting->link_daftar) ? $beasiswaSetting->link_daftar : $defaultPmb;
        @endphp
        <div class="d-flex flex-column gap-2 justify-content-center">
          <a href="{{ $pmbLink }}" target="_blank" class="btn btn-warning px-4 py-3 fw-bold text-dark shadow-sm rounded-pill" style="background: var(--uis-yellow); border-color: var(--uis-yellow);">
            <i class="bi bi-pencil-square me-2"></i>Daftar Jalur Beasiswa
          </a>
          @if(($waAdminSetting->is_active ?? true) && !empty($waAdminSetting->clean_wa))
          <a href="{{ $waAdminSetting->wa_url }}" target="_blank" class="btn btn-outline-success px-4 py-3 fw-semibold rounded-pill">
            <i class="bi bi-whatsapp me-2"></i>Konsultasi via WhatsApp
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

{{-- STATS HIGHLIGHT ROW --}}
<section class="container beasiswa-stats-row">
  <div class="row g-3 g-md-4">
    <div class="col-6 col-lg-3">
      <div class="beasiswa-stat-box">
        <div class="beasiswa-stat-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
          <div class="beasiswa-stat-value">6+</div>
          <div class="beasiswa-stat-label">Jalur Beasiswa</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="beasiswa-stat-box">
        <div class="beasiswa-stat-icon"><i class="bi bi-award-fill"></i></div>
        <div>
          <div class="beasiswa-stat-value">100%</div>
          <div class="beasiswa-stat-label">Bebas SPP Penuh</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="beasiswa-stat-box">
        <div class="beasiswa-stat-icon"><i class="bi bi-people-fill"></i></div>
        <div>
          <div class="beasiswa-stat-value">Ratusan</div>
          <div class="beasiswa-stat-label">Kuota Tiap Tahun</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="beasiswa-stat-box">
        <div class="beasiswa-stat-icon"><i class="bi bi-buildings-fill"></i></div>
        <div>
          <div class="beasiswa-stat-value">150+</div>
          <div class="beasiswa-stat-label">Mitra Kerjasama</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- OVERVIEW & IMAGE SHOWCASE (DESKRIPSI & IMAGE) --}}
<section class="container mb-5">
  <div class="beasiswa-overview-card">
    <div class="row g-4 g-lg-5 align-items-center">
      <div class="col-lg-6">
        <span class="beasiswa-section-tag"><i class="bi bi-info-circle-fill"></i> Tentang Program Beasiswa UIS</span>
        <h2 class="beasiswa-section-heading">{{ $beasiswaSetting->tentang_judul ?? 'Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya' }}</h2>
        @if(!empty($beasiswaSetting->tentang_deskripsi))
          <div class="beasiswa-desc-lead" style="white-space: pre-line;">{!! nl2br(e($beasiswaSetting->tentang_deskripsi)) !!}</div>
        @else
          <p class="beasiswa-desc-lead">
            Sebagai institusi pendidikan tinggi terkemuka di Kota Batam yang berlandaskan nilai-nilai <strong>Iman, Ilmu, dan Amal</strong>, Universitas Ibnu Sina meyakini bahwa keterbatasan finansial tidak boleh menjadi penghalang bagi putra-putri bangsa untuk meraih gelar Sarjana (S1) maupun Magister (S2).
          </p>
          <p class="text-secondary" style="font-size: 14.5px; line-height: 1.8;">
            Program Beasiswa UIS dirancang secara komprehensif bersama Kementerian Pendidikan, Pemerintah Daerah, Yayasan Pendidikan Ibnu Sina Batam (YAPISNA), serta asosiasi industri multinasional. Mahasiswa penerima beasiswa tidak hanya mendapatkan bantuan pembiayaan, namun juga bimbingan intensif untuk kesiapan karir profesional dan technopreneurship global.
          </p>
        @endif

        <ul class="beasiswa-feature-list mt-3">
          <li><i class="bi bi-check-circle-fill"></i> <strong>Pembebasan Biaya Kuliah:</strong> Subsidi SPP/UKT hingga 100% bebas biaya sampai lulus.</li>
          <li><i class="bi bi-check-circle-fill"></i> <strong>Pembinaan Karakter & Akademik:</strong> Pelatihan kepemimpinan, riset terapan, dan sertifikasi kompetensi.</li>
          <li><i class="bi bi-check-circle-fill"></i> <strong>Penyaluran Magang & Karir:</strong> Akses prioritas magang kerja di perusahaan mitra industri Batam.</li>
        </ul>
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

{{-- DROPDOWN SELECTOR & DESKRIPSI ACCORDION --}}
<section class="container mb-5" id="jalur-beasiswa-section">
  <div class="text-center mb-4">
    <span class="beasiswa-section-tag"><i class="bi bi-grid-fill"></i> Pilihan Kategori Beasiswa</span>
    <h2 class="beasiswa-section-heading">Jelajahi Jalur Beasiswa yang Tersedia</h2>
    <p class="text-muted mx-auto" style="max-width: 650px;">
      Gunakan dropdown di bawah ini untuk memilih dan melihat rincian persyaratan, manfaat, serta cakupan setiap jalur beasiswa di Universitas Ibnu Sina.
    </p>
  </div>

  {{-- DROPDOWN FILTER BAR --}}
  <div class="beasiswa-selector-card">
    <div class="row align-items-center g-3">
      <div class="col-md-4">
        <label for="selectJalurBeasiswa" class="form-label fw-bold mb-0 text-dark">
          <i class="bi bi-funnel-fill text-success me-2"></i>Pilih Dropdown Jalur Beasiswa:
        </label>
      </div>
      <div class="col-md-8">
        <select id="selectJalurBeasiswa" class="form-select beasiswa-select-control" onchange="onSelectJalur(this.value)">
          <option value="all">-- Tampilkan Semua Jalur Beasiswa --</option>
          <option value="collapseKip">1. Beasiswa KIP-Kuliah (Pemerintah RI / Kemendikbudristek)</option>
          <option value="collapseAkademik">2. Beasiswa Prestasi Akademik (Juara Kelas / Nilai Rapor)</option>
          <option value="collapseNonAkademik">3. Beasiswa Prestasi Non-Akademik (Olahraga, Seni & Sains)</option>
          <option value="collapseTahfidz">4. Beasiswa Tahfidz Al-Qur'an (Hafiz & Hafizah 5 - 30 Juz)</option>
          <option value="collapseIndustri">5. Beasiswa Mitra Industri & BUMN Kawasan Batam</option>
          <option value="collapseAfirmasi">6. Beasiswa Afirmasi Daerah & Rekomendasi Yayasan (YAPISNA)</option>
        </select>
      </div>
    </div>
  </div>

  {{-- ACCORDION DROPDOWN LIST (DESKRIPSI DARI DROPDOWN) --}}
  <div class="accordion beasiswa-accordion" id="accordionBeasiswa">

    {{-- 1. BEASISWA KIP-KULIAH --}}
    <div class="accordion-item" id="item-collapseKip">
      <h2 class="accordion-header" id="headingKip">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKip" aria-expanded="true" aria-controls="collapseKip">
          <div class="beasiswa-acc-icon"><i class="bi bi-mortarboard-fill"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa KIP-Kuliah Merdeka (Kemendikbudristek)</span>
              <span class="beasiswa-pill-tag">Bebas 100% SPP + Biaya Hidup</span>
            </div>
            <small class="text-muted fw-normal d-block">Jalur bantuan biaya pendidikan dari Pemerintah RI untuk calon mahasiswa berprestasi dari keluarga prasejahtera.</small>
          </div>
        </button>
      </h2>
      <div id="collapseKip" class="accordion-collapse collapse show" aria-labelledby="headingKip" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Program Kartu Indonesia Pintar Kuliah (KIP-Kuliah) diselenggarakan bekerja sama dengan Pusat Pembiayaan Pendidikan Kemendikbudristek RI. Program ini ditujukan untuk menjamin keberlanjutan kuliah mahasiswa berprestasi tanpa terkendala ekonomi hingga wisuda.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Cakupan & Fasilitas Beasiswa</h6>
              <ul>
                <li>Bebas 100% biaya pendaftaran dan uang pangkal.</li>
                <li>Pembebasan seluruh biaya perkuliahan (SPP/UKT) selama 8 semester (S1).</li>
                <li>Bantuan biaya hidup bulanan langsung disalurkan ke rekening bank mahasiswa.</li>
                <li>Fasilitas bimbingan karir dan akses jejaring alumni nasional.</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Persyaratan Dokumen</h6>
              <ul>
                <li>Siswa SMA/SMK/MA sederajat yang lulus pada tahun berjalan atau maksimal 2 tahun sebelumnya.</li>
                <li>Memiliki Kartu KIP / KKS / Terdaftar di DTKS Kemensos RI.</li>
                <li>Fotokopi Ijazah / Surat Keterangan Lulus (SKL) & Nilai Rapor Semester 1 s.d. 5.</li>
                <li>Fotokopi Kartu Keluarga (KK), KTP calon mahasiswa, dan bukti rekening listrik/PBB.</li>
                <li>Lulus seleksi administrasi dan wawancara internal tim verifikasi UIS.</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Periode Seleksi: Mengikuti jadwal resmi SIM KIP-K Kemendikbudristek & PMB UIS</span>
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill">
              <i class="bi bi-arrow-right-circle me-1"></i> Daftar Jalur KIP-Kuliah
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- 2. BEASISWA PRESTASI AKADEMIK --}}
    <div class="accordion-item" id="item-collapseAkademik">
      <h2 class="accordion-header" id="headingAkademik">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAkademik" aria-expanded="false" aria-controls="collapseAkademik">
          <div class="beasiswa-acc-icon"><i class="bi bi-trophy-fill"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa Prestasi Akademik (Juara Kelas & Nilai Rapor)</span>
              <span class="beasiswa-pill-tag">Potongan 50% - 100% SPP</span>
            </div>
            <small class="text-muted fw-normal d-block">Penghargaan universitas bagi calon mahasiswa yang berprestasi akademik unggul selama di bangku sekolah.</small>
          </div>
        </button>
      </h2>
      <div id="collapseAkademik" class="accordion-collapse collapse" aria-labelledby="headingAkademik" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Universitas Ibnu Sina memberikan potongan biaya kuliah khusus bagi lulusan SMA/SMK/MA sederajat yang berhasil menduduki peringkat terbaik di kelas atau memiliki nilai rapor semester rata-rata di atas standar keunggulan.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Manfaat Beasiswa</h6>
              <ul>
                <li><strong>Ranking 1 Sekolah:</strong> Bebas 100% SPP semester 1 & 2.</li>
                <li><strong>Ranking 2 - 3 Sekolah:</strong> Potongan 50% - 75% SPP semester 1.</li>
                <li><strong>Rata-rata Nilai Rapor ≥ 85:</strong> Potongan biaya kuliah awal s.d. 50%.</li>
                <li>Dapat diperpanjang di semester berikutnya dengan menjaga IPK minimal 3.50.</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Persyaratan Berkas</h6>
              <ul>
                <li>Surat Keterangan Ranking / Peringkat Kelas resmi dari Kepala Sekolah.</li>
                <li>Fotokopi rapor semester 1 s.d. 5 yang telah dilegalisir basah sekolah.</li>
                <li>Fotokopi Ijazah / SKL dan Kartu Identitas Siswa / KTP.</li>
                <li>Pas foto terbaru ukuran 3x4 berwarna.</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Buka sepanjang Gelombang 1 & 2 PMB Universitas Ibnu Sina</span>
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill">
              <i class="bi bi-arrow-right-circle me-1"></i> Daftar Jalur Prestasi Akademik
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- 3. BEASISWA PRESTASI NON-AKADEMIK --}}
    <div class="accordion-item" id="item-collapseNonAkademik">
      <h2 class="accordion-header" id="headingNonAkademik">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNonAkademik" aria-expanded="false" aria-controls="collapseNonAkademik">
          <div class="beasiswa-acc-icon"><i class="bi bi-award-fill"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa Prestasi Non-Akademik (Olahraga, Seni, Budaya & Sains)</span>
              <span class="beasiswa-pill-tag">Bebas SPP Berjenjang</span>
            </div>
            <small class="text-muted fw-normal d-block">Dukungan penuh bagi atlet, seniman, inovator, dan talenta muda pemenang kejuaraan resmi.</small>
          </div>
        </button>
      </h2>
      <div id="collapseNonAkademik" class="accordion-collapse collapse" aria-labelledby="headingNonAkademik" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Bagi siswa yang berprestasi dalam bidang keolahragaan (atlet PON, POPDA, Porprov), seni budaya, debat, robotika, karya ilmiah remaja, atau kejuaraan keagamaan, UIS memberikan beasiswa khusus agar potensi bakat terus berkembang di tingkat perguruan tinggi.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Manfaat Beasiswa</h6>
              <ul>
                <li><strong>Tingkat Internasional / Nasional (Juara 1-3):</strong> Bebas SPP hingga 100%.</li>
                <li><strong>Tingkat Provinsi (Juara 1-3):</strong> Keringanan SPP 50% s.d. 75%.</li>
                <li><strong>Tingkat Kota / Kabupaten:</strong> Potongan biaya kuliah semester awal.</li>
                <li>Dispensasi izin resmi kampus saat bertanding mewakili daerah atau universitas.</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Persyaratan Berkas</h6>
              <ul>
                <li>Sertifikat / Piagam Kejuaraan asli dan fotokopi legalisir (maksimal 3 tahun terakhir).</li>
                <li>Surat rekomendasi dari Pengurus Cabang Olahraga / Lembaga Pembina terkait.</li>
                <li>Surat Keterangan Sehat dari fasilitas kesehatan (khusus cabang atletik).</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Kuota terbatas setiap semester untuk masing-masing cabang prestasi</span>
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill">
              <i class="bi bi-arrow-right-circle me-1"></i> Ajukan Jalur Bakat & Prestasi
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- 4. BEASISWA TAHFIDZ AL-QUR'AN --}}
    <div class="accordion-item" id="item-collapseTahfidz">
      <h2 class="accordion-header" id="headingTahfidz">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTahfidz" aria-expanded="false" aria-controls="collapseTahfidz">
          <div class="beasiswa-acc-icon"><i class="bi bi-book-half"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa Tahfidz Al-Qur'an (Hafiz & Hafizah)</span>
              <span class="beasiswa-pill-tag">Bebas SPP s.d. 100% Full</span>
            </div>
            <small class="text-muted fw-normal d-block">Program apresiasi bagi penghafal Al-Qur'an sebagai wujud nilai moralitas dan religiusitas kampus.</small>
          </div>
        </button>
      </h2>
      <div id="collapseTahfidz" class="accordion-collapse collapse" aria-labelledby="headingTahfidz" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Universitas Ibnu Sina memberikan beasiswa istimewa bagi para penghafal Al-Qur'an (Hafiz dan Hafizah). Kampus menyiapkan lingkungan akademik yang kondusif agar hafalan Al-Qur'an tetap terjaga seraya menuntut ilmu di bidang sains, kesehatan, dan teknologi.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Jenjang Beasiswa Tahfidz</h6>
              <ul>
                <li><strong>Hafal 30 Juz:</strong> Bebas 100% SPP & Uang Kuliah hingga lulus (8 Semester).</li>
                <li><strong>Hafal 20 Juz:</strong> Keringanan SPP 75%.</li>
                <li><strong>Hafal 10 Juz:</strong> Keringanan SPP 50%.</li>
                <li><strong>Hafal 5 Juz:</strong> Keringanan SPP 25%.</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Prosedur & Syarat</h6>
              <ul>
                <li>Ijazah / Syahadah Tahfidz dari Pondok Pesantren / Rumah Tahfidz / Lembaga Resmi.</li>
                <li>Mengikuti tes Tasmi' (Uji Hafalan) di hadapan tim penguji Lembaga Keislaman UIS.</li>
                <li>Menjaga muraja'ah hafalan dan berkelakuan baik selama menempuh studi di UIS.</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Uji tasmi' dilaksanakan berkala sesuai jadwal penerimaan mahasiswa baru</span>
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill">
              <i class="bi bi-arrow-right-circle me-1"></i> Daftar Beasiswa Tahfidz
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- 5. BEASISWA MITRA INDUSTRI & BUMN --}}
    <div class="accordion-item" id="item-collapseIndustri">
      <h2 class="accordion-header" id="headingIndustri">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIndustri" aria-expanded="false" aria-controls="collapseIndustri">
          <div class="beasiswa-acc-icon"><i class="bi bi-buildings-fill"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa Kemitraan Industri & CSR Perusahaan Batam</span>
              <span class="beasiswa-pill-tag">Subsidi Kuliah + Penempatan Karir</span>
            </div>
            <small class="text-muted fw-normal d-block">Sinergi antara UIS dengan dunia usaha, manufaktur, dan perbankan di Kawasan Industri Batam.</small>
          </div>
        </button>
      </h2>
      <div id="collapseIndustri" class="accordion-collapse collapse" aria-labelledby="headingIndustri" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Sebagai kampus yang berakar di jantung industri Batam dan Kepulauan Riau, UIS menjalin kemitraan dengan puluhan perusahaan terkemuka untuk mendanai perkuliahan mahasiswa bertalenta sekaligus mempersiapkan calon tenaga profesional terampil.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Manfaat Kemitraan</h6>
              <ul>
                <li>Bantuan dana perkuliahan dari program CSR perusahaan mitra industri.</li>
                <li>Prioritas magang kerja bersertifikat industri (MBKM Industri Batam).</li>
                <li>Peluang rekrutmen kerja langsung setelah menyelesaikan studi sarjana.</li>
                <li>Akses mentor profesional dari kalangan praktisi industri.</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Sasaran & Syarat</h6>
              <ul>
                <li>Diutamakan mahasiswa program studi bidang Teknik, Informatika, Sistem Informasi, dan Manajemen.</li>
                <li>Lulus seleksi tes bakat skolastik & wawancara komitmen profesional.</li>
                <li>Bersedia mengikuti ketentuan ikatan magang pada perusahaan mitra donor.</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Informasi mitra industri yang membuka kuota diumumkan setiap awal semester</span>
            <a href="{{ route('homepage.kerjasama') }}" class="btn btn-outline-success btn-sm px-3 rounded-pill">
              <i class="bi bi-buildings me-1"></i> Lihat Mitra Kerjasama UIS
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- 6. BEASISWA AFIRMASI DAERAH & YAYASAN --}}
    <div class="accordion-item" id="item-collapseAfirmasi">
      <h2 class="accordion-header" id="headingAfirmasi">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAfirmasi" aria-expanded="false" aria-controls="collapseAfirmasi">
          <div class="beasiswa-acc-icon"><i class="bi bi-heart-fill text-danger"></i></div>
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
              <span>Beasiswa Afirmasi Daerah & Rekomendasi Yayasan (YAPISNA)</span>
              <span class="beasiswa-pill-tag">Dukungan Penuh Yayasan</span>
            </div>
            <small class="text-muted fw-normal d-block">Pemberdayaan putra-putri daerah 3T kepulauan terluar Kepri serta keluarga besar civitas akademika.</small>
          </div>
        </button>
      </h2>
      <div id="collapseAfirmasi" class="accordion-collapse collapse" aria-labelledby="headingAfirmasi" data-bs-parent="#accordionBeasiswa">
        <div class="accordion-body">
          <p class="text-secondary">
            Program sosial Yayasan Pendidikan Ibnu Sina Batam (YAPISNA) untuk mendorong pemerataan pendidikan tinggi di pulau-pulau perbatasan dan daerah penyangga Kepulauan Riau, serta bentuk penghargaan bagi putra-putri tenaga pendidik dan alumni UIS.
          </p>

          <div class="beasiswa-detail-grid">
            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-gift-fill"></i> Skema Bantuan</h6>
              <ul>
                <li>Potongan biaya pengembangan institusi dan subsidi SPP semesteran.</li>
                <li>Skema pembayaran biaya kuliah yang fleksibel dan terjangkau.</li>
                <li>Fasilitas asrama mahasiswa kampus bagi perantau pulau terluar (sesuai ketersediaan).</li>
              </ul>
            </div>

            <div class="beasiswa-detail-box">
              <h6><i class="bi bi-card-checklist"></i> Persyaratan</h6>
              <ul>
                <li>KTP / Surat Keterangan Domisili wilayah kepulauan terluar / 3T Kepulauan Riau.</li>
                <li>Surat rekomendasi dari Kepala Desa / Tokoh Masyarakat / Pengurus Yayasan YAPISNA.</li>
                <li>Surat pernyataan komitmen menyelesaikan studi tepat waktu di UIS.</li>
              </ul>
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> Pendaftaran diproses melalui Panitia PMB UIS & Pengurus Yayasan</span>
            <a href="{{ $pmbLink }}" target="_blank" class="btn btn-success btn-sm px-3 rounded-pill">
              <i class="bi bi-arrow-right-circle me-1"></i> Ajukan Beasiswa Afirmasi
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- TAHAPAN PENDAFTARAN BEASISWA --}}
<section class="container mb-5">
  <div class="text-center mb-4">
    <span class="beasiswa-section-tag"><i class="bi bi-signpost-split-fill"></i> Langkah Mudah</span>
    <h2 class="beasiswa-section-heading">Alur Pendaftaran Beasiswa UIS</h2>
    <p class="text-muted mx-auto" style="max-width: 600px;">
      Empat tahapan terstruktur mulai dari pendaftaran online hingga penetapan kelulusan beasiswa.
    </p>
  </div>

  <div class="row g-3 g-lg-4">
    <div class="col-sm-6 col-lg-3">
      <div class="beasiswa-step-box">
        <div class="beasiswa-step-num">1</div>
        <h5>Registrasi Online PMB</h5>
        <p>Buka portal PMB UIS, buat akun pendaftaran, dan pilih program studi yang diminati.</p>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="beasiswa-step-box">
        <div class="beasiswa-step-num">2</div>
        <h5>Pilih Jalur & Upload Berkas</h5>
        <p>Tentukan kategori beasiswa yang Anda inginkan dan unggah seluruh dokumen persyaratan resmi.</p>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="beasiswa-step-box">
        <div class="beasiswa-step-num">3</div>
        <h5>Verifikasi & Seleksi</h5>
        <p>Mengikuti proses verifikasi berkas, tes wawancara, atau uji tasmi' hafalan Al-Qur'an.</p>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="beasiswa-step-box">
        <div class="beasiswa-step-num">4</div>
        <h5>Pengumuman & Kuliah</h5>
        <p>Cek pengumuman kelulusan di portal PMB, lakukan registrasi ulang, dan resmi menjadi mahasiswa UIS!</p>
      </div>
    </div>
  </div>
</section>

{{-- FAQ BEASISWA --}}
<section class="container mb-5">
  <div class="beasiswa-overview-card p-4 p-md-5">
    <div class="text-center mb-4">
      <span class="beasiswa-section-tag"><i class="bi bi-question-circle-fill"></i> Pertanyaan Umum</span>
      <h3 class="fw-bold text-dark">FAQ Seputar Program Beasiswa UIS</h3>
    </div>

    <div class="accordion accordion-flush" id="faqBeasiswaAccordion">
      <div class="accordion-item border-bottom py-2">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#faqB1">
            Apakah pendaftaran beasiswa UIS dipungut biaya tambahan?
          </button>
        </h2>
        <div id="faqB1" class="accordion-collapse collapse" data-bs-parent="#faqBeasiswaAccordion">
          <div class="accordion-body text-secondary">
            Tidak ada pungutan liar atau biaya seleksi tambahan di luar biaya registrasi resmi PMB UIS. Khusus penerima KIP-Kuliah, pendaftaran bahkan dibebaskan dari biaya seleksi sesuai aturan pemerintah.
          </div>
        </div>
      </div>

      <div class="accordion-item border-bottom py-2">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#faqB2">
            Bolehkah mendaftar lebih dari satu jalur beasiswa sekaligus?
          </button>
        </h2>
        <div id="faqB2" class="accordion-collapse collapse" data-bs-parent="#faqBeasiswaAccordion">
          <div class="accordion-body text-secondary">
            Calon mahasiswa disarankan memilih satu jalur beasiswa utama yang paling sesuai dengan kualifikasi terbaik (misalnya KIP-K atau Tahfidz). Namun jika tidak lolos di jalur prioritas, Anda dapat dialihkan ke jalur prestasi akademik atau reguler.
          </div>
        </div>
      </div>

      <div class="accordion-item py-2">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#faqB3">
            Bagaimana cara mempertahankan beasiswa di semester berikutnya?
          </button>
        </h2>
        <div id="faqB3" class="accordion-collapse collapse" data-bs-parent="#faqBeasiswaAccordion">
          <div class="accordion-body text-secondary">
            Mahasiswa penerima beasiswa wajib mempertahankan prestasi akademik (IPK minimal 3.00 untuk KIP-K, dan 3.50 untuk jalur prestasi), aktif dalam kegiatan kemahasiswaan positif, serta mematuhi tata tertib kampus Universitas Ibnu Sina.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CTA BOTTOM BANNER --}}
<section class="container mb-5">
  <div class="beasiswa-cta-banner text-center text-lg-start">
    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <span class="badge bg-warning text-dark px-3 py-2 fw-bold mb-3 rounded-pill">
          <i class="bi bi-star-fill me-1"></i> Jangan Lewatkan Kesempatan Ini
        </span>
        <h2 class="fw-bold text-white mb-2" style="font-size: clamp(1.8rem, 2.5vw, 2.4rem);">
          Siap Meraih Beasiswa Impian Anda di Universitas Ibnu Sina?
        </h2>
        <p class="text-white-50 mb-0 fs-6" style="max-width: 680px;">
          Kuota terbatas untuk setiap gelombang pendaftaran. Segera persiapkan dokumen Anda dan bergabunglah bersama ribuan mahasiswa berprestasi UIS Batam!
        </p>
      </div>
      <div class="col-lg-4 text-center text-lg-end">
        <div class="d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-center">
          <a href="{{ $pmbLink }}" target="_blank" class="btn btn-warning px-4 py-3 fw-bold text-dark shadow rounded-pill" style="background: var(--uis-yellow); border-color: var(--uis-yellow);">
            <i class="bi bi-pencil-square me-2"></i>Daftar Online PMB
          </a>
          @if(($waAdminSetting->is_active ?? true) && !empty($waAdminSetting->clean_wa))
          <a href="{{ $waAdminSetting->wa_url }}" target="_blank" class="btn btn-outline-light px-4 py-3 fw-semibold rounded-pill">
            <i class="bi bi-whatsapp me-2 text-success"></i>Tanya Syarat Beasiswa
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
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
