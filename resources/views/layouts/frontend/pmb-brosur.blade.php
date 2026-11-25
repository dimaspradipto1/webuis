@extends('layouts.frontend.template')

@section('title', 'Brosur & Poster Resmi PMB — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Lihat dan unduh brosur serta poster resmi Penerimaan Mahasiswa Baru (PMB) Universitas Ibnu Sina (UIS) Batam Tahun Akademik 2026/2027.')
@section('meta_keywords', 'brosur pmb uis, poster pmb universitas ibnu sina, pendaftaran uis batam, biaya kuliah uis')

@push('styles')
<style>
  .hero-clean-pmb {
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
  .poster-card-box {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .poster-card-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(4, 107, 38, 0.12);
    border-color: #046B26;
  }
  .poster-img-container {
    position: relative;
    background: #f8fafc;
    overflow: hidden;
    cursor: pointer;
  }
  .poster-img-container img {
    width: 100%;
    height: auto;
    object-fit: contain;
    transition: transform 0.4s ease;
  }
  .poster-img-container:hover img {
    transform: scale(1.02);
  }
  .poster-overlay-badge {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.7);
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 600;
    backdrop-filter: blur(4px);
  }
  .btn-download-action {
    background: linear-gradient(135deg, #046B26 0%, #024719 100%);
    color: #ffffff !important;
    font-weight: 700;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 13.5px;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 4px 12px rgba(4, 107, 38, 0.2);
  }
  .btn-download-action:hover {
    background: linear-gradient(135deg, #03531e 0%, #012d10 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(4, 107, 38, 0.3);
  }
  .btn-preview-action {
    background: #ffffff;
    color: #046B26 !important;
    border: 1.5px solid #046B26;
    font-weight: 700;
    border-radius: 12px;
    padding: 10px 18px;
    font-size: 13.5px;
    transition: all 0.2s ease;
  }
  .btn-preview-action:hover {
    background: #f0fdf4;
    transform: translateY(-2px);
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
@endphp

<!-- ══════════════════════════════════════════════════════
     1. HERO HEADER BERSIH (TANPA TITIK-TITIK)
     ══════════════════════════════════════════════════════ -->
<header class="hero-clean-pmb">
  <div class="container">
    <div class="breadcrumb-clean">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span class="separator">/</span>
      <a href="{{ route('homepage.informasi-pmb') }}">Admisi & PMB</a>
      <span class="separator">/</span>
      <span class="active">Brosur & Poster PMB</span>
    </div>

    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 fw-bold" style="background: rgba(254, 216, 2, 0.2); border: 1px solid #FED802; color: #FED802; font-size: 12px;">
          <i class="bi bi-images"></i> Media Informasi Visual PMB
        </div>
        <h1 class="fw-bold mb-2 text-white" style="font-size: clamp(24px, 3.2vw, 34px); letter-spacing: -0.3px;">
          Brosur & Poster Resmi PMB Universitas Ibnu Sina
        </h1>
        <p class="text-white-50 mb-3" style="font-size: 14.5px; max-width: 760px; line-height: 1.6;">
          Dapatkan infografis rincian program studi, jalur penerimaan, tabel pembiayaan kuliah, dan panduan lengkap admisi mahasiswa baru Tahun Akademik 2026/2027.
        </p>

        <div class="d-flex flex-wrap align-items-center gap-2">
          <a href="{{ route('homepage.informasi-pmb') }}" class="btn btn-outline-light rounded-pill btn-sm px-3 py-2 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Informasi PMB
          </a>
          <a href="{{ route('homepage.pmb-panduan') }}" class="btn btn-outline-warning rounded-pill btn-sm px-3 py-2 fw-semibold text-warning">
            <i class="bi bi-file-earmark-pdf me-1"></i> Dokumen Panduan PDF
          </a>
        </div>
      </div>

      <div class="col-lg-4 text-lg-end d-none d-lg-block">
        <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(254, 216, 2, 0.3);">
          <i class="bi bi-cloud-arrow-down-fill text-warning fs-1 mb-2 d-block"></i>
          <h6 class="text-white fw-bold mb-1">Unduh Gratis Resolusi Penuh</h6>
          <p class="text-white-50 small mb-0">Klik tombol unduh di setiap poster untuk menyimpan salinan gambar kualitas tinggi.</p>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ══════════════════════════════════════════════════════
     2. CONTENT DAFTAR BROSUR & POSTER
     ══════════════════════════════════════════════════════ -->
<main class="py-5" style="background-color: #f8fafc;">
  <div class="container">

    @php
      $brosur1 = $pmb->gambar_brosur ? $pmb->gambar_brosur_url : null;
      $brosur2 = $pmb->gambar_brosur_2 ? $pmb->gambar_brosur_2_url : null;
    @endphp

    @if(!$brosur1 && !$brosur2)
      {{-- Placeholder jika admin belum mengunggah brosur --}}
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
          <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
            <div class="rounded-circle mx-auto p-4 mb-3 d-flex align-items-center justify-content-center text-success" style="background-color: #eef7f0; width: 90px; height: 90px;">
              <i class="bi bi-images fs-1 text-success"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Brosur Digital PMB Sedang Dipersiapkan</h4>
            <p class="text-muted small mx-auto mb-4" style="max-width: 540px; line-height: 1.7;">
              Panitia Penerimaan Mahasiswa Baru Universitas Ibnu Sina sedang memperbarui materi brosur visual untuk edisi terbaru. Anda dapat langsung mengunduh Dokumen Panduan PDF atau berkonsultasi via WhatsApp.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
              <a href="{{ route('homepage.pmb-panduan') }}" class="btn btn-download-action">
                <i class="bi bi-file-earmark-pdf me-1"></i> Buka Dokumen Panduan PDF
              </a>
              <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Panitia%20PMB%20UIS,%20saya%20ingin%20meminta%20brosur%20pendaftaran%20terbaru" target="_blank" class="btn btn-preview-action">
                <i class="bi bi-whatsapp text-success me-1"></i> Minta Brosur via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="row g-4 justify-content-center mb-5">
        {{-- Brosur 1: Brosur Utama PMB --}}
        @if($brosur1)
          <div class="{{ $brosur2 ? 'col-lg-6' : 'col-lg-8' }}">
            <div class="poster-card-box h-100 d-flex flex-column justify-content-between">
              <div>
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white">
                  <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold">
                    <i class="bi bi-patch-check-fill me-1"></i> Brosur Utama PMB
                  </span>
                  <span class="text-muted small"><i class="bi bi-file-image me-1"></i>Format Gambar HD</span>
                </div>

                <div class="poster-img-container" data-bs-toggle="modal" data-bs-target="#modalBrosur1">
                  <img src="{{ $brosur1 }}" alt="Brosur Utama PMB Universitas Ibnu Sina" class="d-block" loading="lazy">
                  <div class="poster-overlay-badge">
                    <i class="bi bi-arrows-fullscreen me-1"></i> Klik untuk Memperbesar
                  </div>
                </div>

                <div class="p-4">
                  <h5 class="fw-bold text-dark mb-1">Brosur Utama Penerimaan Mahasiswa Baru</h5>
                  <p class="text-muted small mb-0" style="line-height: 1.6;">
                    Menampilkan jalur penerimaan, keunggulan kampus, pilihan fakultas, fasilitas, serta informasi kontak resmi panitia PMB UIS.
                  </p>
                </div>
              </div>

              <div class="p-4 pt-0">
                <div class="d-flex flex-wrap gap-2">
                  <a href="{{ $brosur1 }}" download class="btn-download-action flex-fill text-center text-decoration-none">
                    <i class="bi bi-download me-1"></i> Unduh Brosur (HD)
                  </a>
                  <button type="button" class="btn-preview-action" data-bs-toggle="modal" data-bs-target="#modalBrosur1">
                    <i class="bi bi-eye me-1"></i> Pratinjau
                  </button>
                  <a href="{{ $brosur1 }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center px-3" title="Buka di Tab Baru" style="border-radius: 12px;">
                    <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- Modal Lightbox Brosur 1 --}}
          <div class="modal fade" id="modalBrosur1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
                <div class="modal-header bg-dark text-white py-2.5 px-3">
                  <h6 class="modal-title fw-bold small mb-0"><i class="bi bi-image me-2 text-warning"></i>Brosur Utama PMB Universitas Ibnu Sina</h6>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center bg-dark">
                  <img src="{{ $brosur1 }}" alt="Brosur Utama PMB UIS" class="img-fluid" style="max-height: 85vh; object-fit: contain;">
                </div>
                <div class="modal-footer bg-white py-2 px-3 d-flex justify-content-between">
                  <span class="text-muted small">Universitas Ibnu Sina (UIS) Batam</span>
                  <a href="{{ $brosur1 }}" download class="btn btn-success btn-sm px-4 fw-bold" style="background-color: #046B26;">
                    <i class="bi bi-download me-1"></i> Unduh Brosur Ini
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endif

        {{-- Brosur 2: Brosur Rincian Program Studi & Alur --}}
        @if($brosur2)
          <div class="{{ $brosur1 ? 'col-lg-6' : 'col-lg-8' }}">
            <div class="poster-card-box h-100 d-flex flex-column justify-content-between">
              <div>
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white">
                  <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-3 py-1 fw-bold">
                    <i class="bi bi-mortarboard-fill me-1 text-success"></i> Rincian Program Studi & Biaya
                  </span>
                  <span class="text-muted small"><i class="bi bi-file-image me-1"></i>Format Gambar HD</span>
                </div>

                <div class="poster-img-container" data-bs-toggle="modal" data-bs-target="#modalBrosur2">
                  <img src="{{ $brosur2 }}" alt="Brosur Rincian Prodi PMB Universitas Ibnu Sina" class="d-block" loading="lazy">
                  <div class="poster-overlay-badge">
                    <i class="bi bi-arrows-fullscreen me-1"></i> Klik untuk Memperbesar
                  </div>
                </div>

                <div class="p-4">
                  <h5 class="fw-bold text-dark mb-1">Brosur Program Studi, Alur & Pembiayaan</h5>
                  <p class="text-muted small mb-0" style="line-height: 1.6;">
                    Memuat rincian 11 program studi unggulan (Teknik, Ekonomi, Farmasi, Kebidanan, K3, Magister), alur pendaftaran, dan simulasi cicilan SPP.
                  </p>
                </div>
              </div>

              <div class="p-4 pt-0">
                <div class="d-flex flex-wrap gap-2">
                  <a href="{{ $brosur2 }}" download class="btn-download-action flex-fill text-center text-decoration-none">
                    <i class="bi bi-download me-1"></i> Unduh Brosur (HD)
                  </a>
                  <button type="button" class="btn-preview-action" data-bs-toggle="modal" data-bs-target="#modalBrosur2">
                    <i class="bi bi-eye me-1"></i> Pratinjau
                  </button>
                  <a href="{{ $brosur2 }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center px-3" title="Buka di Tab Baru" style="border-radius: 12px;">
                    <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- Modal Lightbox Brosur 2 --}}
          <div class="modal fade" id="modalBrosur2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
                <div class="modal-header bg-dark text-white py-2.5 px-3">
                  <h6 class="modal-title fw-bold small mb-0"><i class="bi bi-image me-2 text-warning"></i>Brosur Program Studi & Pembiayaan PMB UIS</h6>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center bg-dark">
                  <img src="{{ $brosur2 }}" alt="Brosur Program Studi PMB UIS" class="img-fluid" style="max-height: 85vh; object-fit: contain;">
                </div>
                <div class="modal-footer bg-white py-2 px-3 d-flex justify-content-between">
                  <span class="text-muted small">Universitas Ibnu Sina (UIS) Batam</span>
                  <a href="{{ $brosur2 }}" download class="btn btn-success btn-sm px-4 fw-bold" style="background-color: #046B26;">
                    <i class="bi bi-download me-1"></i> Unduh Brosur Ini
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    @endif

    {{-- ═════════════════════════════════════════════════════
         3. PANDUAN PRAKTIS & KEUNGGULAN UIS
         ═════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold small mb-2">
            KEUNGGULAN UTAMA UIS
          </span>
          <h4 class="fw-bold text-dark mb-3">Mengapa Memilih Universitas Ibnu Sina?</h4>
          <p class="text-muted small mb-4" style="line-height: 1.8;">
            Sebagai perguruan tinggi swasta terkemuka di Kota Batam, UIS mengintegrasikan keunggulan akademik dengan nilai-nilai moral keislaman (Imtaq) serta kesiapan karir internasional.
          </p>

          <div class="d-flex flex-column gap-2.5">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <span class="small fw-semibold text-dark">Akreditasi Institusi "Baik Sekali" oleh BAN-PT</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <span class="small fw-semibold text-dark">Biaya Kuliah Terjangkau & Bisa Diangsur Bulanan</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <span class="small fw-semibold text-dark">Pilihan Kelas Reguler Pagi & Kelas Karyawan Malam</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <span class="small fw-semibold text-dark">Lokasi Strategis di Pusat Kota Batam (Dekat Kawasan Industri)</span>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #023814 0%, #046B26 100%); color: #ffffff;">
            <h5 class="fw-bold text-white mb-2"><i class="bi bi-file-earmark-pdf-fill text-warning me-2"></i>Butuh Dokumen Buku Panduan Lengkap?</h5>
            <p class="text-white-50 small mb-4" style="line-height: 1.7;">
              Untuk membaca petunjuk teknis admisi, rincian biaya pendaftaran per semester, serta jadwal ujian CBT, Anda dapat membuka halaman khusus Dokumen Panduan PMB (PDF).
            </p>
            <a href="{{ route('homepage.pmb-panduan') }}" class="btn px-4 py-2.5 rounded-pill fw-bold text-dark d-inline-flex align-items-center gap-2" style="background-color: #FED802;">
              <i class="bi bi-file-earmark-pdf"></i> Buka Dokumen Panduan PDF
              <i class="bi bi-arrow-right small ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ═════════════════════════════════════════════════════
         4. CALL TO ACTION BOTTOM
         ═════════════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-white text-center" style="background: linear-gradient(135deg, #023814 0%, #046B26 60%, #024719 100%); border: 2px solid rgba(254, 216, 2, 0.4) !important;">
      <span class="badge px-3 py-1.5 rounded-pill mb-2 fw-bold text-dark mx-auto" style="background: #FED802;">
        PENDAFTARAN DARING
      </span>
      <h3 class="fw-bold mb-2 text-white">Daftar Sekarang Sebagai Mahasiswa Baru UIS</h3>
      <p class="text-white-50 mx-auto small mb-4" style="max-width: 600px; line-height: 1.7;">
        Proses pendaftaran cepat, transparan, dan dapat diakses dari mana saja melalui portal resmi PMB online Universitas Ibnu Sina.
      </p>

      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{ $pmbPortalUrl }}" target="_blank" class="btn px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2 text-dark" style="background-color: #FED802; font-size: 14px;">
          <i class="bi bi-pencil-square fs-6"></i> Daftar PMB Online Sekarang
          <i class="bi bi-box-arrow-up-right small ms-1"></i>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Panitia%20PMB%20Universitas%20Ibnu%20Sina,%20saya%20ingin%20konsultasi%20mengenai%20brosur%20pendaftaran" target="_blank" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 14px;">
          <i class="bi bi-whatsapp text-success"></i> Tanya Panitia PMB
        </a>
      </div>
    </div>

  </div>
</main>

@endsection
