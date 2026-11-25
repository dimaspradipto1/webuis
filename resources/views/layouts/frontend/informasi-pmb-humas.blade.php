@extends('layouts.frontend.template')

@section('title', ($pmb->judul ?? 'Informasi Khusus PMB') . ' — Universitas Ibnu Sina (UIS)')
@section('meta_description', $pmb->deskripsi_singkat ?? 'Informasi resmi dan panduan Penerimaan Mahasiswa Baru Universitas Ibnu Sina.')
@section('meta_keywords', 'pmb uis, pendaftaran universitas ibnu sina, kuliah di batam, brosur pmb uis, panduan pmb pdf')

@push('styles')
<style>
  /* Hero Banner Konsisten dengan Standar Hero UIS */
  .pmb-hero {
    background: #046b26 !important;
    border-bottom: 3px solid #fed802 !important;
    color: #ffffff !important;
    padding: 24px 0 22px 0 !important;
    position: relative;
    overflow: hidden;
  }
  .pmb-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(254, 216, 2, 0.12) 1.5px, transparent 1.5px);
    background-size: 24px 24px;
    opacity: 0.45;
    pointer-events: none;
  }
  .pmb-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    background: rgba(254, 216, 2, 0.18) !important;
    border: 1px solid #FED802 !important;
    color: #FED802 !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    letter-spacing: 0.4px !important;
    padding: 3px 12px !important;
    border-radius: 50px !important;
    margin-bottom: 8px !important;
  }
  .pmb-hero h1,
  .pmb-hero-title {
    color: #ffffff !important;
    font-weight: 800 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35) !important;
    font-size: clamp(22px, 2.6vw, 28px) !important;
    line-height: 1.25 !important;
    margin-bottom: 6px !important;
    letter-spacing: -0.3px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
  }
  .pmb-hero p,
  .pmb-hero-subtitle {
    color: rgba(255, 255, 255, 0.92) !important;
    font-size: 13.5px !important;
    max-width: 780px;
    margin-bottom: 14px !important;
    line-height: 1.5 !important;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.25) !important;
  }
  .breadcrumb-custom {
    display: inline-flex !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    font-size: 12.5px !important;
    line-height: 1.4 !important;
    color: rgba(255, 255, 255, 0.7) !important;
    margin-bottom: 10px !important;
  }
  .breadcrumb-custom a {
    color: #ffffff !important;
    text-decoration: none !important;
    font-size: 12.5px !important;
    font-weight: 500 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    transition: color 0.2s ease !important;
  }
  .breadcrumb-custom a:hover {
    color: #fed802 !important;
    text-decoration: underline !important;
  }
  .breadcrumb-custom span {
    color: rgba(255, 255, 255, 0.6) !important;
    font-size: 12px !important;
  }
  .breadcrumb-custom .active {
    color: #fed802 !important;
    font-size: 12.5px !important;
    font-weight: 700 !important;
  }

  /* Card Brosur Poster */
  .pmb-poster-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  .pmb-poster-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(2, 56, 20, 0.14);
    border-color: #046B26;
  }
  .pmb-poster-wrap {
    position: relative;
    cursor: pointer;
    overflow: hidden;
    background-color: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .pmb-poster-wrap img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.4s ease;
  }
  .pmb-poster-wrap:hover img {
    transform: scale(1.02);
  }
  .pmb-poster-overlay {
    position: absolute;
    inset: 0;
    background: rgba(2, 56, 20, 0.45);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .pmb-poster-wrap:hover .pmb-poster-overlay {
    opacity: 1;
  }
  .pmb-zoom-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ffffff;
    color: #046B26;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
  }

  /* Card PDF Dokumen Premium */
  .pmb-pdf-card {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
    border-radius: 18px;
    border: 1.5px solid #e5e7eb;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
    padding: 28px;
    position: relative;
    overflow: hidden;
  }
  .pmb-pdf-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: #dc2626;
  }
  .pmb-pdf-icon-badge {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    background: #fee2e2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    flex-shrink: 0;
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.15);
  }

  /* Info Boxes */
  .pmb-info-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    padding: 24px;
    height: 100%;
  }

  /* CTA Banner */
  .pmb-cta-card {
    background: radial-gradient(circle at center, #0a5c24 0%, #023814 100%);
    border-radius: 20px;
    padding: 40px 30px;
    color: #ffffff;
    box-shadow: 0 16px 36px rgba(2, 56, 20, 0.25);
    border: 2px solid rgba(254, 216, 2, 0.3);
  }
</style>
@endpush

@section('content')

<!-- ══════════════════════════════════════════════════════
     HERO BANNER INFORMASI KHUSUS PMB
══════════════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'informasi-pmb',
    'heroClass' => 'pmb-hero'
])

      <div class="d-flex flex-wrap align-items-center gap-2 pt-1">
        @if(!empty($pmb->link_pendaftaran))
          <a href="{{ $pmb->link_pendaftaran }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm fw-bold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #FED802; color: #023814; border-radius: 50px; font-size: 13.5px;">
            <i class="bi bi-box-arrow-up-right"></i> Daftar PMB Online
          </a>
        @endif

        @if(!empty($pmb->file_pdf))
          <a href="{{ $pmb->pdf_url }}" download class="btn btn-sm btn-outline-light fw-bold px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 50px; font-size: 13.5px;">
            <i class="bi bi-file-earmark-pdf-fill text-danger"></i> Unduh Panduan PDF
          </a>
        @endif

        @if(!empty($pmb->no_wa_pmb))
          <a href="https://wa.me/{{ $pmb->clean_wa }}?text=Halo%20Panitia%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20ingin%20bertanya%20mengenai%20pendaftaran%20mahasiswa%20baru" target="_blank" rel="noopener noreferrer" class="btn btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2 text-white" style="background-color: #25D366; border-radius: 50px; font-size: 13.5px;">
            <i class="bi bi-whatsapp"></i> Chat Panitia PMB
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     KONTEN UTAMA: PANDUAN PDF & POSTER BROSUR
══════════════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">

    {{-- Sambutan Pengantar Singkat --}}
    @if(!empty($pmb->deskripsi_singkat))
      <div class="alert alert-light border border-success-subtle shadow-sm p-4 mb-5" style="border-radius: 14px; background: #ffffff;" data-aos="fade-up">
        <div class="d-flex align-items-start gap-3">
          <div class="rounded-circle p-2 bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
            <i class="bi bi-info-circle-fill fs-5"></i>
          </div>
          <div>
            <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">Pengumuman Resmi PMB Universitas Ibnu Sina</h5>
            <p class="text-muted mb-0 small" style="line-height: 1.7; font-size: 14.5px;">
              {{ $pmb->deskripsi_singkat }}
            </p>
          </div>
        </div>
      </div>
    @endif

    {{-- ═════════════════════════════════════════════════════
         1. DOKUMEN PANDUAN PDF RESMI
         ═════════════════════════════════════════════════════ --}}
    <div class="mb-5" id="unduh-panduan" data-aos="fade-up">
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="badge bg-danger px-2 py-1"><i class="bi bi-file-earmark-pdf-fill me-1"></i>Dokumen Resmi</span>
        <h4 class="fw-bold text-dark mb-0" style="font-size: 20px;">Buku Panduan & Rincian PMB (PDF)</h4>
      </div>

      <div class="pmb-pdf-card">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
          <div class="d-flex align-items-center gap-3">
            <div class="pmb-pdf-icon-badge">
              <i class="bi bi-file-earmark-pdf-fill"></i>
            </div>
            <div>
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1 fw-bold">DOKUMEN RESMI PDF</span>
              <h5 class="fw-bold text-dark mb-1" style="font-size: 18px;">
                {{ $pmb->file_pdf_nama ?: 'Buku Panduan & Rincian PMB TA 2026/2027.pdf' }}
              </h5>
              <p class="text-muted small mb-0">
                Memuat informasi persyaratan pendaftaran, pilihan program studi, tata cara seleksi, dan rincian pembiayaan kuliah.
                @if($pmb->pdf_size)
                  <span class="fw-semibold text-dark ms-1">({{ $pmb->pdf_size }})</span>
                @endif
              </p>
            </div>
          </div>

          <div class="d-flex flex-wrap align-items-center gap-2 flex-shrink-0">
            @if(!empty($pmb->file_pdf))
              <button type="button" class="btn btn-outline-success fw-bold px-3 py-2 d-inline-flex align-items-center gap-1" onclick="openPdfModal('{{ $pmb->pdf_url }}', '{{ addslashes($pmb->file_pdf_nama ?: 'Panduan PMB UIS') }}')">
                <i class="bi bi-eye-fill"></i> Pratinjau PDF
              </button>
              <a href="{{ $pmb->pdf_url }}" download class="btn btn-success fw-bold px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #046B26; border-color: #046B26;">
                <i class="bi bi-download"></i> Unduh File PDF
              </a>
            @else
              <span class="badge bg-light text-muted border p-2">
                <i class="bi bi-info-circle me-1"></i> File PDF sedang diperbarui oleh panitia
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         2. BROSUR & POSTER INFOGRAFIS PMB (IMAGE)
         ═════════════════════════════════════════════════════ --}}
    <div class="mb-5" id="brosur-pmb" data-aos="fade-up">
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-success px-2 py-1"><i class="bi bi-images me-1"></i>Infografis Visual</span>
          <h4 class="fw-bold text-dark mb-0" style="font-size: 20px;">Brosur & Poster Informasi PMB</h4>
        </div>
        <small class="text-muted"><i class="bi bi-zoom-in me-1"></i>Klik poster untuk memperbesar</small>
      </div>

      <div class="row g-4 justify-content-center">
        {{-- Brosur 1 (Utama) --}}
        @if(!empty($pmb->gambar_brosur))
          <div class="{{ !empty($pmb->gambar_brosur_2) ? 'col-lg-6 col-12' : 'col-lg-8 col-12' }}">
            <div class="pmb-poster-card h-100">
              <div class="pmb-poster-wrap" onclick="openPosterModal('{{ $pmb->gambar_brosur_url }}', 'Poster Utama PMB TA 2026/2027')">
                <img src="{{ $pmb->gambar_brosur_url }}" alt="Poster Utama PMB UIS" class="img-fluid w-100" loading="lazy">
                <div class="pmb-poster-overlay">
                  <div class="pmb-zoom-icon"><i class="bi bi-arrows-fullscreen"></i></div>
                  <span class="text-white fw-bold small">Klik untuk Ukuran Penuh</span>
                </div>
              </div>
              <div class="p-3 bg-white border-top d-flex align-items-center justify-content-between">
                <div>
                  <span class="badge bg-success-subtle text-success fw-bold small">Poster Utama</span>
                  <div class="fw-bold text-dark small mt-1">Brosur Penerimaan Mahasiswa Baru</div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="openPosterModal('{{ $pmb->gambar_brosur_url }}', 'Poster Utama PMB TA 2026/2027')">
                  <i class="bi bi-zoom-in me-1"></i> Perbesar
                </button>
              </div>
            </div>
          </div>
        @endif

        {{-- Brosur 2 (Tambahan / Alur / Biaya) --}}
        @if(!empty($pmb->gambar_brosur_2))
          <div class="{{ !empty($pmb->gambar_brosur) ? 'col-lg-6 col-12' : 'col-lg-8 col-12' }}">
            <div class="pmb-poster-card h-100">
              <div class="pmb-poster-wrap" onclick="openPosterModal('{{ $pmb->gambar_brosur_2_url }}', 'Poster Rincian Program Studi & Biaya PMB')">
                <img src="{{ $pmb->gambar_brosur_2_url }}" alt="Brosur Rincian PMB UIS" class="img-fluid w-100" loading="lazy">
                <div class="pmb-poster-overlay">
                  <div class="pmb-zoom-icon"><i class="bi bi-arrows-fullscreen"></i></div>
                  <span class="text-white fw-bold small">Klik untuk Ukuran Penuh</span>
                </div>
              </div>
              <div class="p-3 bg-white border-top d-flex align-items-center justify-content-between">
                <div>
                  <span class="badge bg-success-subtle text-success fw-bold small">Rincian Informasi</span>
                  <div class="fw-bold text-dark small mt-1">Brosur Alur & Rincian Studi</div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="openPosterModal('{{ $pmb->gambar_brosur_2_url }}', 'Poster Rincian Program Studi & Biaya PMB')">
                  <i class="bi bi-zoom-in me-1"></i> Perbesar
                </button>
              </div>
            </div>
          </div>
        @endif

        @if(empty($pmb->gambar_brosur) && empty($pmb->gambar_brosur_2))
          <div class="col-12 text-center py-4">
            <div class="p-4 bg-white rounded-3 border text-center shadow-sm">
              <i class="bi bi-images fs-1 text-muted opacity-50 mb-2 d-block"></i>
              <h6 class="fw-bold text-dark mb-1">Brosur Gambar Sedang Dipersiapkan</h6>
              <p class="text-muted small mb-0">Poster infografis PMB resmi akan segera ditayangkan di sini.</p>
            </div>
          </div>
        @endif
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         3. JADWAL GELOMBANG & PERSYARATAN BERKAS
         ═════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-5" id="jadwal-gelombang" data-aos="fade-up">
      {{-- Gelombang Pendaftaran --}}
      <div class="col-md-6 col-12">
        <div class="pmb-info-box">
          <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <div class="rounded-circle p-2 bg-success-subtle text-success fs-5 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
              <i class="bi bi-calendar-event"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-0" style="font-size: 17px;">Jadwal Gelombang PMB</h5>
              <small class="text-muted">Tahapan waktu seleksi penerimaan</small>
            </div>
          </div>

          @if(!empty($pmb->gelombang_info))
            <div class="text-dark small" style="line-height: 1.8; white-space: pre-line;">
              {{ $pmb->gelombang_info }}
            </div>
          @else
            <ul class="list-unstyled mb-0 small" style="line-height: 1.9;">
              <li><i class="bi bi-check2-circle text-success me-2"></i><strong>Gelombang I:</strong> Januari - Maret 2026 (Potongan Biaya Pendaftaran)</li>
              <li><i class="bi bi-check2-circle text-success me-2"></i><strong>Gelombang II:</strong> April - Juni 2026 (Jalur Reguler & Beasiswa)</li>
              <li><i class="bi bi-check2-circle text-success me-2"></i><strong>Gelombang III:</strong> Juli - September 2026 (Jalur Kuota Terakhir)</li>
            </ul>
          @endif
        </div>
      </div>

      {{-- Persyaratan Berkas --}}
      <div class="col-md-6 col-12" id="persyaratan-pmb">
        <div class="pmb-info-box">
          <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <div class="rounded-circle p-2 bg-success-subtle text-success fs-5 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
              <i class="bi bi-card-checklist"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-0" style="font-size: 17px;">Persyaratan Pendaftaran</h5>
              <small class="text-muted">Kelengkapan dokumen yang dipersiapkan</small>
            </div>
          </div>

          @if(!empty($pmb->persyaratan_info))
            <div class="text-dark small" style="line-height: 1.8; white-space: pre-line;">
              {{ $pmb->persyaratan_info }}
            </div>
          @else
            <ul class="list-unstyled mb-0 small" style="line-height: 1.9;">
              <li><i class="bi bi-file-earmark-check text-success me-2"></i>Salinan Ijazah / SKL SMA/SMK/MA/Sederajat dilegalisir (2 lembar)</li>
              <li><i class="bi bi-file-earmark-check text-success me-2"></i>Salinan Kartu Keluarga (KK) & KTP calon mahasiswa (2 lembar)</li>
              <li><i class="bi bi-file-earmark-check text-success me-2"></i>Pas foto berwarna ukuran 3x4 latar belakang merah/biru (3 lembar)</li>
              <li><i class="bi bi-file-earmark-check text-success me-2"></i>Melakukan pengisian formulir online di portal pmb.uis.ac.id</li>
            </ul>
          @endif
        </div>
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         4. CALL TO ACTION PENDAFTARAN & KONSULTASI
         ═════════════════════════════════════════════════════ --}}
    <div class="pmb-cta-card text-center" data-aos="fade-up">
      <div class="row justify-content-center">
        <div class="col-lg-9 col-12">
          <span class="badge bg-warning text-dark fw-bold px-3 py-2 mb-3 rounded-pill">
            <i class="bi bi-stars me-1"></i> Siap Menjadi Bagian dari Universitas Ibnu Sina?
          </span>
          <h3 class="fw-bold text-white mb-2" style="font-size: 26px;">
            Daftar Sekarang Secara Daring Melalui Portal Resmi PMB
          </h3>
          <p class="text-light opacity-90 small mb-4" style="line-height: 1.6;">
            Tersedia berbagai pilihan Fakultas Teknik, Fakultas Ekonomi & Bisnis, Fakultas Ilmu Kesehatan, dan Program Pascasarjana (S2) dengan akreditasi unggul dan biaya terjangkau.
          </p>

          <div class="d-flex flex-wrap justify-content-center gap-3">
            @if(!empty($pmb->link_pendaftaran))
              <a href="{{ $pmb->link_pendaftaran }}" target="_blank" rel="noopener noreferrer" class="btn fw-bold px-4 py-2 shadow" style="background-color: #FED802; color: #023814; border-radius: 50px;">
                <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi Portal pmb.uis.ac.id
              </a>
            @endif

            @if(!empty($pmb->no_wa_pmb))
              <a href="https://wa.me/{{ $pmb->clean_wa }}?text=Halo%20Panitia%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20butuh%20panduan%20pendaftaran" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light fw-bold px-4 py-2" style="border-radius: 50px;">
                <i class="bi bi-whatsapp me-1"></i> Konsultasi via WhatsApp ({{ $pmb->no_wa_pmb }})
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ══════════════════════════════════════════════════════
     MODAL LIGHTBOX POSTER GAMBAR
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalPosterPmb" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
    <div class="modal-content border-0 bg-transparent shadow-none">
      <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-light rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Tutup" style="width: 44px; height: 44px;">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <div class="text-center p-2">
        <img id="posterModalImg" src="" alt="Poster PMB Penuh" class="img-fluid rounded-3 shadow-lg" style="max-height: 88vh; width: auto; max-width: 100%; object-fit: contain; cursor: pointer;" data-bs-dismiss="modal" title="Klik untuk menutup">
      </div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MODAL PREVIEW PDF VIEWER
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalPdfViewer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 1100px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #023814 0%, #046B26 100%); color: #ffffff;">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
          <h6 class="modal-title fw-bold mb-0 text-white" id="pdfModalTitle">Pratinjau Dokumen Panduan PMB</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(!empty($pmb->file_pdf))
            <a href="{{ $pmb->pdf_url }}" download class="btn btn-sm btn-warning fw-bold text-dark">
              <i class="bi bi-download me-1"></i> Unduh PDF
            </a>
          @endif
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
      </div>
      <div class="modal-body p-0 bg-light" style="height: 75vh;">
        <iframe id="pdfIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const posterModalEl = document.getElementById('modalPosterPmb');
    const pdfModalEl = document.getElementById('modalPdfViewer');

    if (posterModalEl && posterModalEl.parentNode !== document.body) {
      document.body.appendChild(posterModalEl);
    }
    if (pdfModalEl && pdfModalEl.parentNode !== document.body) {
      document.body.appendChild(pdfModalEl);
    }
  });

  function openPosterModal(imgUrl, title) {
    const modalEl = document.getElementById('modalPosterPmb');
    if (!modalEl) return;
    document.getElementById('posterModalImg').src = imgUrl;
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }

  function openPdfModal(pdfUrl, title) {
    const modalEl = document.getElementById('modalPdfViewer');
    if (!modalEl) return;
    document.getElementById('pdfIframe').src = pdfUrl;
    if (title) {
      document.getElementById('pdfModalTitle').textContent = title;
    }
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
</script>
@endpush
