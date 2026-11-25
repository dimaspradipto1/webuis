@extends('layouts.frontend.template')

@section('title', 'Dokumen Panduan PMB (PDF) — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Unduh dan pelajari buku panduan resmi Penerimaan Mahasiswa Baru (PMB) Universitas Ibnu Sina (UIS) Batam format PDF.')
@section('meta_keywords', 'panduan pmb uis, buku panduan pmb universitas ibnu sina, syarat daftar uis, pdf pmb uis batam')

@push('styles')
<style>
  .hero-clean-panduan {
    background: linear-gradient(135deg, #023814 0%, #046B26 65%, #024719 100%) !important;
    color: #ffffff !important;
    padding: 42px 0 38px 0 !important;
    border-bottom: 3px solid #FED802 !important;
    position: relative;
  }
  .breadcrumb-clean {
    font-size: 13px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
  }
  .breadcrumb-clean a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: color 0.2s ease;
  }
  .breadcrumb-clean a:hover {
    color: #FED802;
  }
  .breadcrumb-clean span.separator {
    color: rgba(255, 255, 255, 0.45);
  }
  .breadcrumb-clean span.active {
    color: #FED802;
    font-weight: 700;
  }
  .doc-hero-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #fecaca;
    border-left: 6px solid #dc2626 !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    padding: 32px;
    transition: all 0.3s ease;
  }
  .doc-hero-card:hover {
    box-shadow: 0 16px 36px rgba(220, 38, 38, 0.08);
  }
  .btn-doc-download {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: #ffffff !important;
    font-weight: 700;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25);
  }
  .btn-doc-download:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(220, 38, 38, 0.35);
  }
  .btn-doc-read {
    background: #ffffff;
    color: #dc2626 !important;
    border: 1.5px solid #dc2626;
    font-weight: 700;
    border-radius: 12px;
    padding: 11px 22px;
    font-size: 14px;
    transition: all 0.2s ease;
  }
  .btn-doc-read:hover {
    background: #fef2f2;
    transform: translateY(-2px);
  }
  .chapter-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 24px;
    height: 100%;
    transition: all 0.25s ease;
  }
  .chapter-box:hover {
    border-color: #046B26;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  }
  .chapter-number {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #eef7f0;
    color: #046B26;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
  }
</style>
@endpush

@section('content')

@php
  $cleanWa = $pmb->clean_wa ?? '6282283958644';
  $pmbPortalUrl = $pmb->link_pendaftaran ?: ($pmbSetting->tombol_link_1 ?? 'https://pmb.uis.ac.id');
  if (!str_starts_with($pmbPortalUrl, 'http://') && !str_starts_with($pmbPortalUrl, 'https://')) {
      $pmbPortalUrl = 'https://' . $pmbPortalUrl;
  }
  $pdfUrl = $pmb->pdf_url;
@endphp

<!-- ══════════════════════════════════════════════════════
     1. HERO HEADER BERSIH (TANPA TITIK-TITIK)
     ══════════════════════════════════════════════════════ -->
<header class="hero-clean-panduan">
  <div class="container">
    <div class="breadcrumb-clean">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span class="separator">/</span>
      <a href="{{ route('homepage.informasi-pmb') }}">Admisi & PMB</a>
      <span class="separator">/</span>
      <span class="active">Dokumen Panduan PMB</span>
    </div>

    <div class="row align-items-center g-4">
      <div class="col-12">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 fw-bold" style="background: rgba(254, 216, 2, 0.2); border: 1px solid #FED802; color: #FED802; font-size: 12px;">
          <i class="bi bi-file-earmark-pdf-fill"></i> Dokumen Resmi Admisi PMB
        </div>
        <h1 class="fw-bold mb-2 text-white" style="font-size: clamp(24px, 3.2vw, 34px); letter-spacing: -0.3px;">
          Buku Panduan PMB (PDF) Universitas Ibnu Sina
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 14.5px; max-width: 820px; line-height: 1.6;">
          Unduh dan pelajari dokumen resmi buku panduan admisi mahasiswa baru Tahun Akademik 2026/2027 yang memuat alur pendaftaran, rincian biaya, tata tertib, dan kontak panitia.
        </p>
      </div>
    </div>
  </div>
</header>

<!-- ══════════════════════════════════════════════════════
     2. CONTENT DOKUMEN PANDUAN UTAMA
     ══════════════════════════════════════════════════════ -->
<main class="py-5" style="background-color: #f8fafc;">
  <div class="container">

    {{-- Main Document Card --}}
    <div class="doc-hero-card mb-5">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-flex align-items-start gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-danger flex-shrink-0" style="background-color: #fee2e2; width: 68px; height: 68px;">
              <i class="bi bi-file-earmark-pdf-fill fs-1 text-danger"></i>
            </div>
            <div>
              <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-0.5 fw-bold small">
                  DOKUMEN RESMI PMB
                </span>
                @if($pmb->pdf_size)
                  <span class="badge bg-light text-muted border rounded-pill px-2.5 py-0.5 small">
                    <i class="bi bi-hdd me-1"></i> {{ $pmb->pdf_size }}
                  </span>
                @endif
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-0.5 small fw-semibold">
                  <i class="bi bi-shield-check me-1"></i> Terverifikasi Panitia UIS
                </span>
              </div>

              <h4 class="fw-bold text-dark mb-2">
                {{ $pmb->file_pdf_nama ?: 'Buku Panduan & Rincian PMB TA 2026/2027.pdf' }}
              </h4>
              <p class="text-muted small mb-0" style="line-height: 1.7; max-width: 680px;">
                Buku panduan resmi memuat ketentuan umum pendaftaran, rincian biaya kuliah per program studi, petunjuk pengisian portal admisi daring, jadwal tes potensi akademik, serta panduan daftar ulang.
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 text-lg-end">
          @if(!empty($pdfUrl))
            <div class="d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
              <a href="{{ $pdfUrl }}" download class="btn-doc-download text-center text-decoration-none d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-download fs-6"></i>
                <span>Unduh Dokumen Panduan</span>
              </a>
              <a href="{{ $pdfUrl }}" target="_blank" class="btn-doc-read text-center text-decoration-none d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-book-half fs-6"></i>
                <span>Baca Dokumen Online</span>
                <i class="bi bi-box-arrow-up-right small ms-1"></i>
              </a>
            </div>
          @else
            <div class="p-3 rounded-3 bg-light text-center border">
              <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-3 py-1 fw-bold small mb-2 d-inline-block">
                <i class="bi bi-clock me-1"></i> Sedang Dipersiapkan
              </span>
              <p class="text-muted small mb-3">Dokumen PDF edisi revisi terbaru sedang dipersiapkan oleh Panitia PMB.</p>
              <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Panitia%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20ingin%20meminta%20dokumen%20panduan%20pendaftaran" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 fw-semibold w-100">
                <i class="bi bi-whatsapp me-1"></i> Minta Panduan via WhatsApp
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         3. DAFTAR ISI POKOK BUKU PANDUAN PMB
         ═════════════════════════════════════════════════════ --}}
    <div class="mb-5">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Struktur Isi Panduan
        </span>
        <h3 class="fw-bold text-dark mt-2">Pokok Pembahasan dalam Buku Panduan PMB</h3>
        <p class="text-muted small mx-auto" style="max-width: 620px;">
          Berikut ringkasan materi penting yang dapat Anda temukan di dalam berkas dokumen panduan resmi.
        </p>
      </div>

      <div class="row g-4">
        {{-- Bab 1 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">01</div>
              <h6 class="fw-bold text-dark mb-0">Profil & Keunggulan UIS</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Informasi visi misi universitas, akreditasi institusi dan program studi, fasilitas kampus, serta kemitraan industri.
            </p>
          </div>
        </div>

        {{-- Bab 2 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">02</div>
              <h6 class="fw-bold text-dark mb-0">Program Studi & Kurikulum</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Daftar 11 program studi S1 & S2 lintas Fakultas Teknik, FEB, dan FIKES berbasis Outcome-Based Education (OBE).
            </p>
          </div>
        </div>

        {{-- Bab 3 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">03</div>
              <h6 class="fw-bold text-dark mb-0">Rincian Biaya & Angsuran</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Tabel uang pangkal (gedung), biaya SPP per semester, dan simulasi skema angsuran bulanan yang transparan dan fleksibel.
            </p>
          </div>
        </div>

        {{-- Bab 4 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">04</div>
              <h6 class="fw-bold text-dark mb-0">Persyaratan & Berkas Admisi</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Checklist dokumen ijazah, SKL, kartu identitas (KK/KTP), pas foto, serta syarat khusus calon mahasiswa beasiswa/pindahan.
            </p>
          </div>
        </div>

        {{-- Bab 5 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">05</div>
              <h6 class="fw-bold text-dark mb-0">Petunjuk Teknis Portal PMB</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Langkah demi langkah pembuatan akun pendaftaran, verifikasi berkas, pembayaran registrasi, dan kartu ujian daring.
            </p>
          </div>
        </div>

        {{-- Bab 6 --}}
        <div class="col-md-6 col-lg-4">
          <div class="chapter-box">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="chapter-number">06</div>
              <h6 class="fw-bold text-dark mb-0">Daftar Ulang & Orientasi PKKMB</h6>
            </div>
            <p class="text-muted small mb-0" style="line-height: 1.6;">
              Prosedur verifikasi keabsahan dokumen asli, pengambilan jas almamater, pembagian NIM, serta jadwal pembekalan PKKMB.
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         4. CALL TO ACTION BOTTOM
         ═════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-white text-center" style="background: linear-gradient(135deg, #023814 0%, #046B26 60%, #024719 100%); border: 2px solid rgba(254, 216, 2, 0.4) !important;">
      <span class="badge px-3 py-1.5 rounded-pill mb-2 fw-bold text-dark mx-auto" style="background: #FED802;">
        PORTAL PMB DARING
      </span>
      <h3 class="fw-bold mb-2 text-white">Sudah Membaca Panduan? Daftarkan Diri Anda Sekarang</h3>
      <p class="text-white-50 mx-auto small mb-4" style="max-width: 600px; line-height: 1.7;">
        Masuk ke portal admisi resmi Universitas Ibnu Sina untuk memulai proses registrasi mahasiswa baru secara online.
      </p>

      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2 text-dark" style="background-color: #FED802; font-size: 14px;">
          <i class="bi bi-pencil-square fs-6"></i> Buka Portal PMB Online
          <i class="bi bi-box-arrow-up-right small ms-1"></i>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Panitia%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20sudah%20membaca%20dokumen%20panduan%20dan%20ingin%20konsultasi%20pendaftaran" target="_blank" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 14px;">
          <i class="bi bi-whatsapp text-success"></i> Hubungi Helpdesk PMB
        </a>
      </div>
    </div>

  </div>
</main>

@endsection
