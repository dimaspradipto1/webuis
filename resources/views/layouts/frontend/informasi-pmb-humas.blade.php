@extends('layouts.frontend.template')

@section('title', ($pmb->judul ?? 'Informasi PMB') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', $pmb->deskripsi_singkat ?? 'Informasi resmi Penerimaan Mahasiswa Baru Universitas Ibnu Sina: jadwal gelombang, syarat pendaftaran, program beasiswa, brosur, dan panduan lengkap.')
@section('meta_keywords', 'pmb uis, pendaftaran universitas ibnu sina, kuliah di batam, beasiswa uis, gelombang pmb, brosur pmb uis')

@push('styles')
<style>
  /* ══════════════════════════════════════════════════════
     HERO BANNER PMB PREMIUM
     ══════════════════════════════════════════════════════ */
  .pmb-hero-modern {
    background: linear-gradient(135deg, #023814 0%, #046B26 60%, #03481a 100%) !important;
    border-bottom: 3px solid #FED802 !important;
    color: #ffffff !important;
    padding: 38px 0 34px 0 !important;
    position: relative;
    overflow: hidden;
  }
  .pmb-badge-gold {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    background: rgba(254, 216, 2, 0.18) !important;
    border: 1px solid #FED802 !important;
    color: #FED802 !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    letter-spacing: 0.5px !important;
    padding: 4px 14px !important;
    border-radius: 50px !important;
    margin-bottom: 10px !important;
  }
  .pmb-hero-title {
    color: #ffffff !important;
    font-weight: 800 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35) !important;
    font-size: clamp(24px, 3vw, 34px) !important;
    line-height: 1.25 !important;
    margin-bottom: 8px !important;
    letter-spacing: -0.3px !important;
  }
  .pmb-hero-subtitle {
    color: rgba(255, 255, 255, 0.92) !important;
    font-size: 14.5px !important;
    max-width: 820px;
    margin-bottom: 18px !important;
    line-height: 1.6 !important;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.25) !important;
  }

  /* ══════════════════════════════════════════════════════
     STICKY IN-PAGE NAVIGATION PILLS
     ══════════════════════════════════════════════════════ */
  .pmb-nav-pills-bar {
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    position: sticky;
    top: 72px;
    z-index: 1020;
    transition: all 0.3s ease;
  }
  .pmb-nav-pill-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
    border-radius: 50px;
    text-decoration: none !important;
    transition: all 0.2s ease;
    white-space: nowrap;
  }
  .pmb-nav-pill-link:hover {
    color: #046B26;
    background-color: #f0fdf4;
  }

  /* ══════════════════════════════════════════════════════
     HIGHLIGHT STATS CARDS
     ══════════════════════════════════════════════════════ */
  .pmb-stat-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    padding: 20px;
    height: 100%;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .pmb-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  }

  /* ══════════════════════════════════════════════════════
     GELOMBANG TIMELINE CARDS
     ══════════════════════════════════════════════════════ */
  .gelombang-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1.5px solid #e5e7eb;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
    padding: 24px;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
  }
  .gelombang-card.active-wave {
    border-color: #046B26;
    background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    box-shadow: 0 10px 25px rgba(4, 107, 38, 0.12);
  }
  .gelombang-card.active-wave::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #046B26;
  }

  /* ══════════════════════════════════════════════════════
     CHECKLIST PERSYARATAN & ALUR
     ══════════════════════════════════════════════════════ */
  .syarat-box {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
    padding: 28px;
    height: 100%;
  }
  .syarat-list-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px dashed #e5e7eb;
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
  }
  .syarat-list-item:last-child {
    border-bottom: none;
  }
  .syarat-check-icon {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #dcfce7;
    color: #15803d;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
    font-size: 14px;
    font-weight: bold;
  }

  .step-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px;
    border-radius: 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    margin-bottom: 12px;
    transition: all 0.2s ease;
  }
  .step-card:hover {
    background: #ffffff;
    border-color: #046B26;
    box-shadow: 0 4px 14px rgba(4, 107, 38, 0.08);
    transform: translateX(4px);
  }
  .step-number {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #046B26;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(4, 107, 38, 0.2);
  }

  /* ══════════════════════════════════════════════════════
     BEASISWA PMB CARDS
     ══════════════════════════════════════════════════════ */
  .beasiswa-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
    padding: 24px;
    height: 100%;
    display: flex;
    flex-column: column;
    justify-content: space-between;
    transition: all 0.25s ease;
  }
  .beasiswa-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    border-color: #046B26;
  }
  .beasiswa-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(4, 107, 38, 0.1);
    color: #046B26;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 14px;
  }

  /* ══════════════════════════════════════════════════════
     TOMBOL LIHAT DOKUMEN PROFESIONAL
     ══════════════════════════════════════════════════════ */
  .btn-doc-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 20px;
    font-size: 13.5px;
    font-weight: 600;
    color: #046B26;
    background-color: #ffffff;
    border: 1.5px solid #046B26;
    border-radius: 50px;
    text-decoration: none !important;
    white-space: nowrap;
    box-shadow: 0 2px 5px rgba(4, 107, 38, 0.08);
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }
  .btn-doc-link:hover, .btn-doc-link:focus {
    color: #ffffff !important;
    background-color: #046B26 !important;
    border-color: #046B26 !important;
    box-shadow: 0 5px 15px rgba(4, 107, 38, 0.28) !important;
    transform: translateY(-2px);
  }
  .btn-doc-link:hover .bi, .btn-doc-link:focus .bi {
    color: #ffffff !important;
  }

  /* ══════════════════════════════════════════════════════
     POSTER BROSUR VISUAL
     ══════════════════════════════════════════════════════ */
  .pmb-poster-wrap {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  }
  .pmb-poster-wrap img {
    transition: transform 0.35s ease;
  }
  .pmb-poster-wrap:hover img {
    transform: scale(1.03);
  }
  .pmb-poster-overlay {
    position: absolute;
    inset: 0;
    background: rgba(4, 107, 38, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.25s ease;
  }
  .pmb-poster-wrap:hover .pmb-poster-overlay {
    opacity: 1;
  }
</style>
@endpush

@section('content')

<!-- ══════════════════════════════════════════════════════
     1. HERO HEADER UTAMA PMB
     ══════════════════════════════════════════════════════ -->
<header class="pmb-hero-modern">
  <div class="container position-relative">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2" style="font-size: 12.5px;">
        <li class="breadcrumb-item"><a href="{{ route('homepage') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item text-white-50">Admisi</li>
        <li class="breadcrumb-item active text-warning fw-bold" aria-current="page">Informasi PMB</li>
      </ol>
    </nav>

    <div class="row align-items-center g-4">
      <div class="col-12">
        <span class="pmb-badge-gold">
          <i class="bi bi-patch-check-fill"></i> {{ $pmb->badge_text ?: 'PMB TA 2026/2027' }}
        </span>
        <h1 class="pmb-hero-title">
          {{ $pmb->judul ?: 'Informasi Khusus Penerimaan Mahasiswa Baru' }}
        </h1>
        <p class="pmb-hero-subtitle mb-0">
          {{ $pmb->subjudul ?: 'Tahun Akademik 2026/2027 — Universitas Ibnu Sina (UIS) Batam' }}
        </p>
      </div>
    </div>
  </div>
</header>

<!-- ══════════════════════════════════════════════════════
     3. HIGHLIGHT METRIK UTAMA
     ══════════════════════════════════════════════════════ -->
<section class="py-4" style="background-color: #f8fafc;">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="pmb-stat-card" style="border-left: 4px solid #046B26 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Status Pendaftaran</div>
              <div class="fw-bold text-dark fs-5 mt-1">Gelombang Buka</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1); width: 42px; height: 42px;">
              <i class="bi bi-check-circle-fill fs-5" style="color: #046B26;"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="pmb-stat-card" style="border-left: 4px solid #FED802 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Bantuan Beasiswa</div>
              <div class="fw-bold text-dark fs-5 mt-1">Hingga 100% SPP</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(254, 216, 2, 0.2); width: 42px; height: 42px;">
              <i class="bi bi-award-fill fs-5 text-warning"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="pmb-stat-card" style="border-left: 4px solid #0d6efd !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Pilihan Program Studi</div>
              <div class="fw-bold text-dark fs-5 mt-1">{{ $prodiCount ?? 11 }} Program Studi</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(13, 110, 253, 0.1); width: 42px; height: 42px;">
              <i class="bi bi-mortarboard-fill fs-5 text-primary"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="pmb-stat-card" style="border-left: 4px solid #10b981 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Akreditasi Institusi</div>
              <div class="fw-bold text-dark fs-5 mt-1">Baik Sekali</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(16, 185, 129, 0.1); width: 42px; height: 42px;">
              <i class="bi bi-patch-check-fill fs-5 text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     4. KONTEN UTAMA INFORMASI PMB TERPADU
     ══════════════════════════════════════════════════════ -->
<main class="py-5" style="background-color: #f7faf7;">
  <div class="container">

    {{-- ═════════════════════════════════════════════════════
         SEKSI 1: JADWAL GELOMBANG PENDAFTARAN
         ═════════════════════════════════════════════════════ --}}
    <section class="mb-5" id="jadwal-gelombang" data-aos="fade-up">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Jadwal Pendaftaran
        </span>
        <h3 class="fw-bold text-dark mt-2">Jadwal Gelombang Penerimaan Mahasiswa Baru</h3>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
          Pendaftaran dibuka dalam beberapa gelombang. Daftarkan diri Anda lebih awal untuk mendapatkan kemudahan registrasi dan prioritas beasiswa kuliah.
        </p>
      </div>

      <div class="row g-4 justify-content-center mb-4">
        {{-- Card Gelombang 1 --}}
        <div class="col-md-4">
          <div class="gelombang-card active-wave">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="badge bg-success rounded-pill px-3 py-1 fw-bold small">
                <i class="bi bi-broadcast me-1"></i> Sedang Dibuka
              </span>
              <span class="text-success fw-bold small">Gelombang I</span>
            </div>
            <h5 class="fw-bold text-dark mb-2">Gelombang Dini & Prestasi</h5>
            <div class="p-2.5 rounded-3 bg-light border mb-3 small">
              <i class="bi bi-calendar2-week text-success me-1"></i>
              <strong>Januari – Maret 2026</strong>
            </div>
            <ul class="list-unstyled small text-muted mb-4 d-flex flex-column gap-2" style="line-height: 1.6;">
              <li><i class="bi bi-check2 text-success me-1 fw-bold"></i> Potongan Biaya Pendaftaran Awal</li>
              <li><i class="bi bi-check2 text-success me-1 fw-bold"></i> Prioritas Seleksi Jalur Beasiswa Kuliah</li>
              <li><i class="bi bi-check2 text-success me-1 fw-bold"></i> Kepastian Kuota Program Studi Pilihan</li>
            </ul>
            <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn btn-success w-100 rounded-pill btn-sm fw-bold py-2 shadow-sm" style="background-color: #046B26;">
              Daftar Gelombang I
            </a>
          </div>
        </div>

        {{-- Card Gelombang 2 --}}
        <div class="col-md-4">
          <div class="gelombang-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold small">
                Mendatang
              </span>
              <span class="text-muted fw-bold small">Gelombang II</span>
            </div>
            <h5 class="fw-bold text-dark mb-2">Gelombang Reguler Utama</h5>
            <div class="p-2.5 rounded-3 bg-light border mb-3 small">
              <i class="bi bi-calendar2-week text-primary me-1"></i>
              <strong>April – Juni 2026</strong>
            </div>
            <ul class="list-unstyled small text-muted mb-4 d-flex flex-column gap-2" style="line-height: 1.6;">
              <li><i class="bi bi-check2 text-primary me-1 fw-bold"></i> Jalur Reguler Sarjana (S1) & Magister (S2)</li>
              <li><i class="bi bi-check2 text-primary me-1 fw-bold"></i> Seleksi Administrasi & CBT Online</li>
              <li><i class="bi bi-check2 text-primary me-1 fw-bold"></i> Program Beasiswa Kemitraan & Yayasan</li>
            </ul>
            <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill btn-sm fw-bold py-2">
              Daftar Gelombang II
            </a>
          </div>
        </div>

        {{-- Card Gelombang 3 --}}
        <div class="col-md-4">
          <div class="gelombang-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-3 py-1 fw-bold small">
                Kuota Terakhir
              </span>
              <span class="text-muted fw-bold small">Gelombang III</span>
            </div>
            <h5 class="fw-bold text-dark mb-2">Gelombang Penutup</h5>
            <div class="p-2.5 rounded-3 bg-light border mb-3 small">
              <i class="bi bi-calendar2-week text-warning me-1"></i>
              <strong>Juli – September 2026</strong>
            </div>
            <ul class="list-unstyled small text-muted mb-4 d-flex flex-column gap-2" style="line-height: 1.6;">
              <li><i class="bi bi-check2 text-dark me-1 fw-bold"></i> Pengisian Kuota Terakhir Program Studi</li>
              <li><i class="bi bi-check2 text-dark me-1 fw-bold"></i> Tes Masuk & Wawancara Khusus</li>
              <li><i class="bi bi-check2 text-dark me-1 fw-bold"></i> Pembekalan PKKMB Mahasiswa Baru</li>
            </ul>
            <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn btn-outline-secondary w-100 rounded-pill btn-sm py-2">
              Informasi Gelombang III
            </a>
          </div>
        </div>
      </div>
    </section>

    {{-- ═════════════════════════════════════════════════════
         SEKSI 2: SYARAT PENDAFTARAN & ALUR PENDAFTARAN
         ═════════════════════════════════════════════════════ --}}
    <section class="mb-5" id="syarat-pendaftaran" data-aos="fade-up">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Persyaratan & Tata Cara
        </span>
        <h3 class="fw-bold text-dark mt-2">Syarat Berkas & Alur Pendaftaran PMB</h3>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
          Persiapkan kelengkapan dokumen administrasi Anda dan ikuti 4 langkah mudah alur registrasi mahasiswa baru UIS.
        </p>
      </div>

      <div class="row g-4 align-items-stretch">
        {{-- Kolom Kiri: Checklist Berkas Dokumen --}}
        <div class="col-lg-6">
          <div class="syarat-box">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
              <div class="rounded-circle p-2 bg-success text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="bi bi-file-earmark-check fs-5"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-0">Kelengkapan Berkas Pendaftaran</h5>
                <small class="text-muted">Dokumen yang disiapkan calon mahasiswa</small>
              </div>
            </div>

            @if(!empty($pmb->persyaratan_info))
              @php
                $lines = explode("\n", trim($pmb->persyaratan_info));
              @endphp
              <div class="d-flex flex-column">
                @foreach($lines as $line)
                  @php $cleanLine = trim($line); @endphp
                  @if(!empty($cleanLine))
                    <div class="syarat-list-item">
                      <div class="syarat-check-icon"><i class="bi bi-check2"></i></div>
                      <div>{{ ltrim($cleanLine, "0..9.-• ") }}</div>
                    </div>
                  @endif
                @endforeach
              </div>
            @else
              <div class="d-flex flex-column">
                <div class="syarat-list-item">
                  <div class="syarat-check-icon"><i class="bi bi-check2"></i></div>
                  <div>Salinan Ijazah atau Surat Keterangan Lulus (SKL) SMA/SMK/MA/Sederajat yang telah dilegalisir (2 lembar).</div>
                </div>
                <div class="syarat-list-item">
                  <div class="syarat-check-icon"><i class="bi bi-check2"></i></div>
                  <div>Salinan Kartu Keluarga (KK) dan Kartu Tanda Penduduk (KTP) calon mahasiswa (2 lembar).</div>
                </div>
                <div class="syarat-list-item">
                  <div class="syarat-check-icon"><i class="bi bi-check2"></i></div>
                  <div>Pas foto resmi berwarna ukuran 3x4 latar belakang merah atau biru (3 lembar).</div>
                </div>
                <div class="syarat-list-item">
                  <div class="syarat-check-icon"><i class="bi bi-check2"></i></div>
                  <div>Mengisi formulir pendaftaran daring secara lengkap di portal resmi PMB UIS (pmb.uis.ac.id).</div>
                </div>
              </div>
            @endif

            <div class="alert alert-success border-0 bg-success-subtle rounded-3 p-3 mt-4 mb-0 small text-success-emphasis">
              <i class="bi bi-info-circle-fill me-1"></i>
              <strong>Catatan:</strong> Bagi calon mahasiswa pindahan / alih jenjang (D3 ke S1), wajib menyertakan Transkrip Nilai dan Surat Keterangan Pindah dari perguruan tinggi asal.
            </div>
          </div>
        </div>

        {{-- Kolom Kanan: 4 Tahapan Alur Pendaftaran --}}
        <div class="col-lg-6">
          <div class="syarat-box">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
              <div class="rounded-circle p-2 text-white d-flex align-items-center justify-content-center" style="background-color: #FED802; color: #046B26 !important; width: 38px; height: 38px;">
                <i class="bi bi-diagram-3-fill fs-5" style="color: #046B26;"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-0">Alur 4 Langkah Pendaftaran</h5>
                <small class="text-muted">Prosedur pendaftaran daring hingga kelulusan</small>
              </div>
            </div>

            <div class="step-card">
              <div class="step-number">1</div>
              <div>
                <h6 class="fw-bold text-dark mb-1">Registrasi Akun di Portal PMB</h6>
                <p class="text-muted small mb-0">Akses laman <strong>pmb.uis.ac.id</strong>, klik menu pendaftaran baru, dan buat akun menggunakan email aktif.</p>
              </div>
            </div>

            <div class="step-card">
              <div class="step-number">2</div>
              <div>
                <h6 class="fw-bold text-dark mb-1">Pengisian Biodata & Unggah Berkas</h6>
                <p class="text-muted small mb-0">Lengkapi formulir biodata pribadi, pilih program studi yang diminati, dan unggah scan dokumen persyaratan.</p>
              </div>
            </div>

            <div class="step-card">
              <div class="step-number">3</div>
              <div>
                <h6 class="fw-bold text-dark mb-1">Seleksi Berkas & Tes Online (CBT)</h6>
                <p class="text-muted small mb-0">Panitia memverifikasi dokumen. Ikuti seleksi nilai rapor atau Computer Based Test (CBT) sesuai jalur yang dipilih.</p>
              </div>
            </div>

            <div class="step-card">
              <div class="step-number">4</div>
              <div>
                <h6 class="fw-bold text-dark mb-1">Pengumuman & Registrasi Ulang</h6>
                <p class="text-muted small mb-0">Dapatkan Surat Keterangan Lulus (SKL) PMB dan lakukan pembayaran her-registrasi untuk mendapatkan NIM resmi mahasiswa UIS.</p>
              </div>
            </div>

            <div class="d-grid mt-3">
              <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn btn-success rounded-pill fw-bold py-2.5 shadow-sm" style="background-color: #046B26;">
                <i class="bi bi-box-arrow-up-right me-1"></i> Mulai Pendaftaran Daring Sekarang
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- ═════════════════════════════════════════════════════
         SEKSI 3: CALL TO ACTION AKHIR & KONSULTASI
         ═════════════════════════════════════════════════════ --}}
    <section class="card border-0 shadow-lg rounded-4 p-4 p-md-5 text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #023814 0%, #046B26 60%, #024719 100%); border: 2px solid rgba(254, 216, 2, 0.4) !important;" data-aos="fade-up">
      <div class="position-relative" style="z-index: 2;">
        <span class="badge px-3 py-1.5 rounded-pill mb-2 fw-bold text-dark" style="background: #FED802;">
          PENDAFTARAN DIBUKA
        </span>
        <h3 class="fw-bold mb-2 text-white">Siap Menjadi Bagian dari Universitas Ibnu Sina?</h3>
        <p class="text-white-50 mx-auto small mb-4" style="max-width: 650px; line-height: 1.7;">
          Wujudkan masa depan karir gemilang bersama universitas terkemuka di Kota Batam. Raih pengalaman akademik berkualitas dengan biaya terjangkau dan fasilitas modern.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2 text-dark" style="background-color: #FED802; font-size: 14px;">
            <i class="bi bi-pencil-square fs-6"></i> Daftar Daring di Portal PMB
          </a>

          @if(!empty($cleanWa))
            <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20ingin%20bertanya%20mengenai%20pendaftaran" target="_blank" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 14px;">
              <i class="bi bi-whatsapp text-success"></i> Konsultasi via WhatsApp
            </a>
          @endif
        </div>
      </div>
    </section>

  </div>
</main>

@endsection
