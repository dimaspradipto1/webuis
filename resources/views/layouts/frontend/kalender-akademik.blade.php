@extends('layouts.frontend.template')

@section('title', ($item->judul ?? 'Kalender Akademik') . ' — Universitas Ibnu Sina')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HEADER & BREADCRUMB
═══════════════════════════════════════════════ -->
<section class="py-3 border-bottom" style="background-color: #ffffff;">
  <div class="container-fluid px-lg-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div>
        <h4 class="fw-bold mb-0 text-dark">Kalender Akademik</h4>
        <div class="text-muted small">Universitas Ibnu Sina (UIS) Batam</div>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('homepage') }}" class="text-decoration-none text-muted">Beranda</a></li>
          <li class="breadcrumb-item"><a href="{{ route('homepage.kalender-akademik') }}" class="text-decoration-none text-muted">Informasi</a></li>
          <li class="breadcrumb-item active text-success fw-semibold" aria-current="page">Kalender Akademik</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     HERO BANNER DOKUMEN KALENDER AKADEMIK
═══════════════════════════════════════════════ -->
<section class="py-4" style="background: linear-gradient(135deg, #046B26 0%, #03481a 100%); color: #ffffff;">
  <div class="container-fluid px-lg-5">
    <div class="row align-items-center g-3">
      <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
            <i class="bi bi-patch-check-fill me-1"></i> DOKUMEN RESMI BAAK UIS
          </span>
          @if($item->is_active)
            <span class="badge bg-success-subtle text-white border border-light-subtle px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px; background-color: rgba(255,255,255,0.2) !important;">
              <i class="bi bi-check-circle-fill me-1 text-warning"></i> Status: Berlaku Aktif
            </span>
          @else
            <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px;">
              <i class="bi bi-clock-history me-1"></i> Dalam Penyesuaian
            </span>
          @endif
        </div>
        <h2 class="fw-bolder mb-2 text-white">{{ $item->judul ?? 'Kalender Akademik Universitas Ibnu Sina' }}</h2>
        <p class="mb-0 text-white-50" style="font-size: 14px; max-width: 750px;">
          {{ $item->subjudul ?? 'Pedoman resmi linimasa perkuliahan, registrasi ulang, pengisian KRS, jadwal UTS, UAS, dan yudisium/wisuda sarjana & pascasarjana.' }}
        </p>
      </div>

      <div class="col-lg-4 text-lg-end">
        <div class="d-inline-flex flex-column align-items-lg-end align-items-start gap-1 p-3 rounded-4" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);">
          <div class="text-white-50 small fw-semibold">Pilih Tahun Akademik:</div>
          <div class="d-flex align-items-center gap-2">
            <select class="form-select form-select-sm fw-bold border-0 rounded-pill shadow-xs" id="filterTahunAkademik" onchange="gantiTahunKalender(this.value)" style="width: 170px; background-color: #ffffff; color: #046B26; cursor: pointer;">
              <option value="2026/2027" selected>TA 2026/2027 (Aktif)</option>
              <option value="2025/2026">TA 2025/2026</option>
              <option value="2024/2025">TA 2024/2025</option>
            </select>
          </div>
          <div class="text-white-50" style="font-size: 11px;">
            <i class="bi bi-clock-history me-1"></i> Diperbarui: {{ $item->updated_at ? $item->updated_at->translatedFormat('d F Y') : date('d F Y') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     KONTEN UTAMA: VIEWER FILE & INFORMASI
═══════════════════════════════════════════════ -->
<section class="py-4" style="background-color: #f3f5f8; min-height: 85vh;">
  <div class="container-fluid px-lg-5">
    
    @if(!$item->is_active)
      <div class="alert alert-warning border-0 rounded-4 shadow-sm p-4 mb-4 d-flex align-items-center gap-3">
        <i class="bi bi-exclamation-triangle-fill fs-2 text-warning"></i>
        <div>
          <h6 class="fw-bold mb-1 text-dark">Kalender Akademik Dalam Proses Penyesuaian</h6>
          <div class="small text-muted">Jadwal dan linimasa perkuliahan sedang dalam proses peninjauan / pembaruan resmi oleh Biro Administrasi Akademik UIS. Dokumen yang tampil merupakan arsip acuan sebelumnya.</div>
        </div>
      </div>
    @endif

    <div class="row g-4">
      
      {{-- ══════════════════════════════════════════════
           AREA UTAMA: TAMPILAN FILE OTOMATIS (PDF & GAMBAR)
      ══════════════════════════════════════════════ --}}
      <div class="col-xl-9 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
          
          {{-- Header Tab Navigasi File --}}
          <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <ul class="nav nav-pills card-header-pills gap-2" id="kalenderTab" role="tablist">
              @if($item->file_dokumen)
                <li class="nav-item" role="presentation">
                  <button class="nav-link active rounded-pill px-3 py-1.5 fw-bold d-flex align-items-center gap-2" id="pdf-tab" data-bs-toggle="tab" data-bs-target="#pdf-content" type="button" role="tab" style="font-size: 13px;">
                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i> Dokumen PDF Resmi
                  </button>
                </li>
              @endif

              @if($item->gambar)
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ !$item->file_dokumen ? 'active' : '' }} rounded-pill px-3 py-1.5 fw-bold d-flex align-items-center gap-2" id="infografis-tab" data-bs-toggle="tab" data-bs-target="#infografis-content" type="button" role="tab" style="font-size: 13px;">
                    <i class="bi bi-image-fill text-primary"></i> Poster Infografis
                  </button>
                </li>
              @endif

              <li class="nav-item" role="presentation">
                <button class="nav-link {{ (!$item->file_dokumen && !$item->gambar) ? 'active' : '' }} rounded-pill px-3 py-1.5 fw-bold d-flex align-items-center gap-2" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi-content" type="button" role="tab" style="font-size: 13px;">
                  <i class="bi bi-info-circle-fill text-success"></i> Ketentuan Perkuliahan
                </button>
              </li>
            </ul>

            {{-- Tombol Tindakan Cepat (Download & Fullscreen) --}}
            <div class="d-flex align-items-center gap-2">
              @if($item->file_dokumen)
                <a href="{{ $item->file_dokumen_url }}" download class="btn btn-sm btn-success fw-bold rounded-pill px-3 py-1.5 shadow-xs d-flex align-items-center gap-1.5" style="background-color: #046B26; border-color: #046B26;">
                  <i class="bi bi-download"></i> Unduh PDF
                </a>
                <a href="{{ $item->file_dokumen_url }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-none d-sm-inline-flex align-items-center gap-1.5">
                  <i class="bi bi-box-arrow-up-right"></i> Buka Layar Penuh
                </a>
              @elseif($item->gambar)
                <a href="{{ $item->gambar_url }}" download class="btn btn-sm btn-success fw-bold rounded-pill px-3 py-1.5 shadow-xs d-flex align-items-center gap-1.5" style="background-color: #046B26; border-color: #046B26;">
                  <i class="bi bi-download"></i> Unduh Poster
                </a>
              @endif
            </div>
          </div>

          {{-- Konten Tab --}}
          <div class="card-body p-0">
            <div class="tab-content" id="kalenderTabContent">
              
              {{-- TAB 1: PDF VIEWER INTERAKTIF OTOMATIS --}}
              @if($item->file_dokumen)
                <div class="tab-pane fade show active p-3" id="pdf-content" role="tabpanel" aria-labelledby="pdf-tab">
                  <div class="ratio ratio-16x9 rounded-4 overflow-hidden border shadow-xs" style="min-height: 820px; background-color: #525659;">
                    <iframe 
                      src="{{ $item->file_dokumen_url }}#toolbar=1&navpanes=1" 
                      width="100%" 
                      height="820px" 
                      style="border: none;"
                      title="Dokumen Kalender Akademik Universitas Ibnu Sina"
                      loading="lazy">
                    </iframe>
                  </div>
                  <div class="p-3 bg-light rounded-3 border mt-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-check-fill text-success fs-5"></i>
                      <div class="small text-muted">
                        Dokumen: <strong class="text-dark">{{ $item->file_nama ?: 'SK Kalender Akademik Resmi UIS' }}</strong>
                      </div>
                    </div>
                    <div class="small text-muted">
                      Mengalami kendala melihat pratinjau? <a href="{{ $item->file_dokumen_url }}" target="_blank" class="text-success fw-bold text-decoration-none">Buka langsung dokumen di sini <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              @endif

              {{-- TAB 2: POSTER INFOGRAFIS KALENDER --}}
              @if($item->gambar)
                <div class="tab-pane fade {{ !$item->file_dokumen ? 'show active' : '' }} p-4 text-center" id="infografis-content" role="tabpanel" aria-labelledby="infografis-tab">
                  <div class="p-2 rounded-4 border bg-light shadow-xs d-inline-block position-relative">
                    <img 
                      src="{{ $item->gambar_url }}" 
                      alt="{{ $item->judul }}" 
                      class="img-fluid rounded-3 shadow-sm"
                      style="max-height: 900px; width: auto; object-fit: contain; cursor: pointer;"
                      onclick="openImageModal('{{ $item->gambar_url }}', '{{ $item->judul }}')">
                  </div>
                  <div class="mt-3 d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-4" onclick="openImageModal('{{ $item->gambar_url }}', '{{ $item->judul }}')">
                      <i class="bi bi-arrows-fullscreen me-1"></i> Perbesar Poster
                    </button>
                    <a href="{{ $item->gambar_url }}" download class="btn btn-sm btn-success rounded-pill px-4" style="background-color: #046B26; border-color: #046B26;">
                      <i class="bi bi-download me-1"></i> Unduh Poster Gambar
                    </a>
                  </div>
                </div>
              @endif

              {{-- TAB 3: DESKRIPSI & KETENTUAN PERKULIAHAN --}}
              <div class="tab-pane fade {{ (!$item->file_dokumen && !$item->gambar) ? 'show active' : '' }} p-4" id="deskripsi-content" role="tabpanel" aria-labelledby="deskripsi-tab">
                <div class="prose max-w-none text-dark" style="line-height: 1.8;">
                  @if(!empty($item->deskripsi))
                    {!! $item->deskripsi !!}
                  @else
                    <div class="text-center py-5 text-muted">
                      <i class="bi bi-calendar-event fs-1 text-secondary d-block mb-3"></i>
                      <h6 class="fw-bold text-dark">Informasi Perkuliahan</h6>
                      <p class="small text-muted mb-0">Rincian linimasa perkuliahan mengacu penuh pada SK Dokumen Resmi Kalender Akademik Universitas Ibnu Sina.</p>
                    </div>
                  @endif
                </div>
              </div>

              {{-- JIKA BELUM ADA FILE DOKUMEN & GAMBAR SAMA SEKALI --}}
              @if(!$item->file_dokumen && !$item->gambar)
                <div class="p-5 text-center bg-light">
                  <i class="bi bi-file-earmark-arrow-up fs-1 text-secondary d-block mb-3"></i>
                  <h5 class="fw-bold text-dark mb-2">Berkas Dokumen Kalender Akademik Segera Diperbarui</h5>
                  <p class="text-muted small mb-3" style="max-width: 500px; margin: 0 auto;">
                    Salinan resmi Surat Keputusan (SK) Kalender Akademik Tahun Akademik 2026/2027 sedang dalam proses finalisasi arsip digital oleh Biro Administrasi Akademik & Kemahasiswaan (BAAK) UIS.
                  </p>
                  <a href="{{ route('homepage.contact') }}" class="btn btn-sm btn-outline-success rounded-pill px-4 fw-semibold">
                    Hubungi Bagian Akademik
                  </a>
                </div>
              @endif

            </div>
          </div>

        </div>

        {{-- Kartu Ringkasan Informasi Penting --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
          <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <i class="bi bi-journal-bookmark-fill text-success fs-5"></i>
            <h6 class="fw-bold mb-0 text-dark">Petunjuk & Ketentuan Kalender Akademik</h6>
          </div>
          <div class="row g-3 small text-muted">
            <div class="col-md-6 d-flex align-items-start gap-2.5">
              <i class="bi bi-check2-circle text-success fs-5 mt-n1"></i>
              <div>
                <strong class="text-dark d-block">Registrasi & Pembayaran KRS:</strong>
                Mahasiswa wajib menyelesaikan administrasi SPP dan validasi KRS via SIAKAD sesuai rentang tanggal yang tertera pada kalender.
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-start gap-2.5">
              <i class="bi bi-check2-circle text-success fs-5 mt-n1"></i>
              <div>
                <strong class="text-dark d-block">Pelaksanaan UTS & UAS:</strong>
                Syarat mengikuti ujian adalah kehadiran tatap muka minimal 75% serta kartu ujian yang telah disahkan fakultas.
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-start gap-2.5">
              <i class="bi bi-check2-circle text-success fs-5 mt-n1"></i>
              <div>
                <strong class="text-dark d-block">Yudisium & Wisuda:</strong>
                Pendaftaran wisuda dibuka setelah mahasiswa dinyatakan lulus sidang komprehensif / skripsi dan tervalidasi PD-DIKTI.
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-start gap-2.5">
              <i class="bi bi-check2-circle text-success fs-5 mt-n1"></i>
              <div>
                <strong class="text-dark d-block">Perubahan Jadwal:</strong>
                Jika terjadi perubahan jadwal libur nasional atau kebijakan kementerian, pembaruan resmi akan diumumkan via pengumuman web UIS.
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- ══════════════════════════════════════════════
           SIDEBAR KANAN: DOKUMEN IDENTITAS, PORTAL SIAKAD, LAYANAN
      ══════════════════════════════════════════════ --}}
      <div class="col-xl-3 col-lg-4">
        
        {{-- KARTU DOKUMEN UNDUHAN RESMI --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #046B26 0%, #064e1c 100%);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-file-earmark-pdf-fill fs-2 text-warning"></i>
            <div>
              <div class="text-white-50 small fw-semibold" style="font-size: 11px;">UNDUHAN RESMI</div>
              <h6 class="fw-bold mb-0 text-white">Salinan Kalender (PDF)</h6>
            </div>
          </div>

          <p class="small text-white-50 mb-3" style="font-size: 12px; line-height: 1.5;">
            Unduh salinan resmi Surat Keputusan (SK) Rektor tentang Kalender Akademik format PDF resolusi tinggi untuk dicetak atau disimpan.
          </p>

          @if($item->file_dokumen)
            <a href="{{ $item->file_dokumen_url }}" download class="btn btn-warning w-100 fw-bolder py-2.5 rounded-3 text-dark shadow-sm d-flex align-items-center justify-content-center gap-2 mb-2">
              <i class="bi bi-download fs-5"></i> Unduh File Sekarang
            </a>
            <a href="{{ $item->file_dokumen_url }}" target="_blank" class="btn btn-outline-light w-100 fw-semibold py-2 rounded-3 text-white small d-flex align-items-center justify-content-center gap-1.5">
              <i class="bi bi-eye"></i> Buka Dokumen Online
            </a>
          @else
            <button type="button" class="btn btn-warning w-100 fw-bolder py-2.5 rounded-3 text-dark shadow-sm disabled" disabled>
              <i class="bi bi-hourglass-split"></i> Dokumen Segera Tersedia
            </button>
          @endif
        </div>

        {{-- INFORMASI BERKAS DOKUMEN --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
          <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <h6 class="fw-bold mb-0 text-dark small">Informasi Dokumen</h6>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small">Valid</span>
          </div>

          <div class="d-flex flex-column gap-2.5 small">
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
              <span class="text-muted">Tahun Akademik:</span>
              <strong class="text-dark">2026 / 2027</strong>
            </div>
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
              <span class="text-muted">Status Dokumen:</span>
              <span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 11px;">Aktif Resmi</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
              <span class="text-muted">Terakhir Diperbarui:</span>
              <span class="text-dark fw-semibold">{{ $item->updated_at ? $item->updated_at->translatedFormat('d M Y') : date('d M Y') }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
              <span class="text-muted">Format Dokumen:</span>
              <span class="text-dark fw-semibold">PDF / Infografis</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-1">
              <span class="text-muted">Penerbit:</span>
              <span class="text-dark fw-semibold text-truncate" style="max-width: 140px;" title="BAAK Universitas Ibnu Sina">BAAK UIS Batam</span>
            </div>
          </div>
        </div>

        {{-- PORTAL SIAKAD --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: #ffffff; border-left: 4px solid #046B26 !important;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-laptop text-success fs-4"></i>
            <h6 class="fw-bold mb-0 text-dark">Portal SIAKAD UIS</h6>
          </div>
          <p class="small text-muted mb-3">
            Akses pengisian KRS online, cetak KHS, jadwal kuliah mahasiswa, dan penginputan nilai dosen via SIAKAD.
          </p>
          <a href="{{ $item->link_url ?: 'https://siakad.uis.ac.id' }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill py-2 fw-bold small d-flex align-items-center justify-content-center gap-1.5">
            Masuk Portal SIAKAD <i class="bi bi-box-arrow-up-right"></i>
          </a>
        </div>

        {{-- TAUTAN INFORMASI AKADEMIK TERKAIT --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
          <h6 class="fw-bold mb-3 pb-2 border-bottom text-dark small">Layanan Akademik Terkait</h6>
          <div class="d-flex flex-column gap-2">
            <a href="{{ route('homepage.akreditasi') }}" class="d-flex align-items-center justify-content-between p-2 rounded-3 text-decoration-none text-dark bg-light hover-bg-light transition">
              <span class="small fw-semibold"><i class="bi bi-patch-check-fill text-success me-2"></i>Sertifikat Akreditasi</span>
              <i class="bi bi-chevron-right text-muted small"></i>
            </a>
            <a href="{{ route('homepage.kurikulum') }}" class="d-flex align-items-center justify-content-between p-2 rounded-3 text-decoration-none text-dark bg-light hover-bg-light transition">
              <span class="small fw-semibold"><i class="bi bi-journal-text text-primary me-2"></i>Kurikulum & Capaian</span>
              <i class="bi bi-chevron-right text-muted small"></i>
            </a>
            <a href="{{ route('homepage.pedoman-akademik') }}" class="d-flex align-items-center justify-content-between p-2 rounded-3 text-decoration-none text-dark bg-light hover-bg-light transition">
              <span class="small fw-semibold"><i class="bi bi-book text-warning me-2"></i>Pedoman Akademik</span>
              <i class="bi bi-chevron-right text-muted small"></i>
            </a>
          </div>
        </div>

        {{-- BANTUAN & INFORMASI BAAK --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 text-center">
          <i class="bi bi-headset fs-1 text-success mb-2"></i>
          <h6 class="fw-bold text-dark mb-1 small">Bantuan Tata Usaha BAAK</h6>
          <p class="text-muted small mb-3" style="font-size: 11px;">
            Ada pertanyaan mengenai jadwal dispensasi, revisi KRS, atau pendaftaran yudisium?
          </p>
          <a href="{{ route('homepage.contact') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 w-100">
            Hubungi Bagian Akademik
          </a>
        </div>

      </div>

    </div>
  </div>
</section>

{{-- MODAL LIGHTBOX UNTUK POSTER INFOGRAFIS --}}
<div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content rounded-4 border-0 shadow-lg bg-dark">
      <div class="modal-header border-0 py-2 px-3 text-white">
        <h6 class="modal-title small text-white-50" id="imageLightboxTitle">Poster Kalender Akademik</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2 text-center">
        <img id="imageLightboxSrc" src="" alt="Poster Kalender" class="img-fluid rounded-3 shadow" style="max-height: 85vh; width: auto; object-fit: contain;">
      </div>
    </div>
  </div>
</div>

<script>
function openImageModal(url, title) {
  document.getElementById('imageLightboxSrc').src = url;
  document.getElementById('imageLightboxTitle').innerText = title || 'Poster Kalender Akademik';
  const modal = new bootstrap.Modal(document.getElementById('imageLightboxModal'));
  modal.show();
}

function gantiTahunKalender(tahun) {
  // Jika pengunjung memilih tahun akademik lain dari dropdown
  if (tahun === '2026/2027') {
    // Current active
  } else {
    alert('Menampilkan arsip Kalender Akademik Tahun ' + tahun + '. Jika berkas belum diunggah di sistem arsip, silakan hubungi BAAK UIS.');
  }
}
</script>
@endsection
