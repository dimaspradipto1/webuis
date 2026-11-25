@extends('layouts.frontend.template')

@section('title', 'Akreditasi — Universitas Ibnu Sina')
@section('meta_description', 'Informasi resmi status dokumen akreditasi institusi, fakultas, dan seluruh program studi Universitas Ibnu Sina (UIS) oleh BAN-PT dan Lembaga Akreditasi Mandiri (LAM).')

@section('content')
<style>
  .btn-doc-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 7px 18px;
    font-size: 13px;
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

  .btn-doc-link .btn-doc-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
  }

  .btn-doc-link .btn-doc-arrow {
    font-size: 11.5px;
    opacity: 0.75;
    transition: transform 0.2s ease, opacity 0.2s ease, color 0.2s ease;
  }

  .btn-doc-link:hover,
  .btn-doc-link:focus {
    color: #ffffff !important;
    background-color: #046B26 !important;
    border-color: #046B26 !important;
    box-shadow: 0 5px 15px rgba(4, 107, 38, 0.28) !important;
    transform: translateY(-2px);
  }

  .btn-doc-link:hover .btn-doc-icon,
  .btn-doc-link:focus .btn-doc-icon {
    transform: scale(1.12);
  }

  .btn-doc-link:hover .btn-doc-arrow,
  .btn-doc-link:focus .btn-doc-arrow {
    opacity: 1;
    transform: translate(2px, -2px);
    color: #ffffff !important;
  }

  /* Khusus icon Google & PDF saat dihover agar tetap kontras & bersih (putih) */
  .btn-doc-link:hover .bi,
  .btn-doc-link:focus .bi {
    color: #ffffff !important;
  }

  .btn-doc-link:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(4, 107, 38, 0.2) !important;
  }
</style>
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.components.breadcrumb-hero', [
    'pageKey' => 'akreditasi',
    'heroClass' => 'akreditasi-hero',
    'defaultTitle' => 'Akreditasi',
    'defaultSubtitle' => 'Penjaminan mutu pendidikan tinggi dan legalitas dokumen akreditasi resmi institusi, fakultas, serta seluruh program studi Universitas Ibnu Sina.',
    'defaultActive' => 'Akreditasi'
])

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" style="background-color: #f7faf7;">
  <div class="container">

    {{-- STATISTIK SINGKAT --}}
    <div class="row g-3 mb-5" data-aos="fade-up">
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white" style="border-left: 4px solid #046B26 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Total Dokumen</div>
              <div class="fs-4 fw-bold text-dark mt-1">{{ $allAkreditasis->count() }}</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1); width: 44px; height: 44px;">
              <i class="bi bi-folder-check fs-5" style="color: #046B26;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white" style="border-left: 4px solid #fed802 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Institusi / Universitas</div>
              <div class="fs-4 fw-bold text-dark mt-1">{{ $allAkreditasis->where('tingkat', 'universitas')->count() }}</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(254, 216, 2, 0.2); width: 44px; height: 44px;">
              <i class="bi bi-building fs-5 text-warning"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white" style="border-left: 4px solid #0d6efd !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Tingkat Fakultas</div>
              <div class="fs-4 fw-bold text-dark mt-1">{{ $fakultasAkreditasis->count() }}</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(13, 110, 253, 0.1); width: 44px; height: 44px;">
              <i class="bi bi-mortarboard-fill fs-5 text-primary"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white" style="border-left: 4px solid #198754 !important;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-semibold">Program Studi</div>
              <div class="fs-4 fw-bold text-dark mt-1">{{ $prodiAkreditasis->count() }}</div>
            </div>
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(25, 135, 84, 0.1); width: 44px; height: 44px;">
              <i class="bi bi-journal-check fs-5 text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- SECTION UTAMA: DATATABLE DOKUMEN AKREDITASI --}}
    <div id="dataTableAkreditasiSection" class="mb-5" data-aos="fade-up">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="background: #eef7f0; color: #046B26; font-size: 12px; letter-spacing: 0.5px;">
          Tabel Informasi Resmi
        </span>
        <h3 class="fw-bold text-dark mt-2">Daftar Dokumen Akreditasi Universitas Ibnu Sina</h3>
        <p class="text-muted small mx-auto" style="max-width: 700px;">
          Seluruh dokumen akreditasi resmi untuk Institusi, Fakultas, dan Program Studi (S1 & S2) terhimpun secara transparan lengkap dengan tautan arsip Google Drive resmi dan nomor ketetapan SK.
        </p>
      </div>

      {{-- Kontrol Filter & Pencarian DataTable --}}
      <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3 p-md-4">
        <div class="row g-3 align-items-center justify-content-between">
          {{-- Tab Tingkat Filter --}}
          <div class="col-xl-7 col-lg-8">
            <div class="d-flex flex-wrap gap-2" id="filterTingkatGroup">
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-bold btn-table-filter active text-white" style="background-color: #046B26;" onclick="filterTableTingkat('all', this)">
                Semua Dokumen ({{ $allAkreditasis->count() }})
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-table-filter bg-light text-dark" onclick="filterTableTingkat('universitas', this)">
                Universitas ({{ $allAkreditasis->where('tingkat', 'universitas')->count() }})
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-table-filter bg-light text-dark" onclick="filterTableTingkat('fakultas', this)">
                Fakultas ({{ $fakultasAkreditasis->count() }})
              </button>
              <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-table-filter bg-light text-dark" onclick="filterTableTingkat('prodi', this)">
                Program Studi ({{ $prodiAkreditasis->count() }})
              </button>
            </div>
          </div>

          {{-- Filter Dropdown Lembaga & Pencarian --}}
          <div class="col-xl-5 col-lg-4">
            <div class="row g-2">
              <div class="col-sm-5">
                <select id="filterLembagaSelect" class="form-select form-select-sm bg-light border-0 py-2 small fw-semibold" onchange="filterTableLembaga(this.value)">
                  <option value="all">Semua Lembaga</option>
                  @foreach($lembagaList as $lembaga)
                    <option value="{{ $lembaga }}">{{ $lembaga }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-7">
                <div class="input-group input-group-sm">
                  <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                  <input type="text" id="searchTableInput" class="form-control bg-light border-0 py-2 small" placeholder="Cari prodi, SK, lembaga..." onkeyup="searchTable(this.value)">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- TABEL DATATABLE AKREDITASI --}}
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-check-fill text-success fs-5"></i>
            <span id="tableInfoTitle">Semua Dokumen Akreditasi UIS</span>
          </div>
          <span class="badge bg-light text-muted px-3 py-1.5 rounded-pill fw-semibold" id="tableRecordCount">
            Menampilkan {{ $allAkreditasis->count() }} Dokumen
          </span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="mainAkreditasiTable">
            <thead class="table-light text-muted small text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
              <tr>
                <th class="ps-4 text-center" style="width: 55px;">No</th>
                <th style="min-width: 250px;">Nama Dokumen / Entitas</th>
                <th style="min-width: 170px;">Fakultas / Unit</th>
                <th style="min-width: 130px;">Lembaga</th>
                <th style="min-width: 120px;">Peringkat</th>
                <th style="min-width: 220px;">Nomor SK & Masa Berlaku</th>
                <th class="text-center pe-4" style="min-width: 180px; white-space: nowrap;">Dokumen</th>
              </tr>
            </thead>
            <tbody id="akreditasiTableBody">
              @forelse($allAkreditasis as $index => $item)
                @php
                  $isUniv = $item->tingkat === 'universitas';
                  $isFak = $item->tingkat === 'fakultas';
                  $isProdi = $item->tingkat === 'prodi';
                  $isS2 = $item->jenjang === 'S2' || str_contains($item->nama, 'S2') || str_contains($item->nama, 'Magister');

                  $badgeTingkatClass = match($item->tingkat) {
                    'universitas' => 'bg-warning text-dark',
                    'fakultas' => 'bg-primary-subtle text-primary border border-primary-subtle',
                    default => ($isS2 ? 'bg-purple-subtle text-white' : 'bg-success-subtle text-success border border-success-subtle')
                  };
                  $badgeTingkatLabel = match($item->tingkat) {
                    'universitas' => 'Institusi / Universitas',
                    'fakultas' => 'Fakultas',
                    default => ($isS2 ? 'Magister (S2)' : 'Sarjana (S1)')
                  };
                @endphp
                <tr class="akreditasi-row-item" 
                    data-tingkat="{{ $item->tingkat }}" 
                    data-lembaga="{{ $item->lembaga }}" 
                    data-search="{{ strtolower($item->nama . ' ' . $item->kategori_label . ' ' . $item->lembaga . ' ' . $item->peringkat . ' ' . $item->nomor_sk . ' ' . $item->jenjang) }}">
                  
                  {{-- No Urut --}}
                  <td class="ps-4 text-center text-muted fw-bold row-index-number">
                    {{ $index + 1 }}
                  </td>

                  {{-- Nama Dokumen / Entitas --}}
                  <td>
                    <div class="d-flex align-items-start gap-2">
                      <div class="rounded-circle p-1.5 mt-0.5 d-flex align-items-center justify-content-center flex-shrink-0" style="background: rgba(4, 107, 38, 0.1); width: 32px; height: 32px;">
                        <i class="bi {{ $isUniv ? 'bi-shield-check' : ($isFak ? 'bi-building' : 'bi-mortarboard') }} fs-6" style="color: #046B26;"></i>
                      </div>
                      <div>
                        <div class="fw-bold text-dark" style="font-size: 14.5px;">
                          {{ $item->nama }}
                        </div>
                        <div class="mt-1 d-flex flex-wrap gap-1">
                          <span class="badge {{ $badgeTingkatClass }} rounded-pill px-2 py-0.5 small fw-semibold" @if($isS2) style="background-color: #5925dc !important;" @endif>
                            {{ $badgeTingkatLabel }}
                          </span>
                          @if($item->tahun_sk)
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-0.5 small">
                              SK {{ $item->tahun_sk }}
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </td>

                  {{-- Fakultas / Kategori --}}
                  <td>
                    <div class="text-dark fw-semibold small">
                      {{ $item->kategori_label }}
                    </div>
                  </td>

                  {{-- Lembaga Akreditasi --}}
                  <td>
                    <span class="badge bg-dark-subtle text-dark border rounded-pill px-2.5 py-1 fw-bold small">
                      {{ $item->lembaga }}
                    </span>
                  </td>

                  {{-- Peringkat --}}
                  <td>
                    <span class="badge {{ $item->badge_class }} rounded-pill px-3 py-1 fw-bold small">
                      {{ $item->peringkat }}
                    </span>
                  </td>

                  {{-- Nomor SK & Masa Berlaku --}}
                  <td>
                    <div class="small fw-semibold text-dark text-truncate" style="max-width: 240px;" title="{{ $item->nomor_sk }}">
                      {{ $item->nomor_sk ?: '-' }}
                    </div>
                    <div class="small text-muted mt-0.5">
                      <i class="bi bi-clock me-1 text-success"></i>
                      {{ $item->masa_berlaku ?: ($item->tahun_sk ? 'Tahun ' . $item->tahun_sk : 'Masih Berlaku') }}
                    </div>
                  </td>

                  {{-- Link Google Drive / Aksi Dokumen --}}
                  <td class="text-center pe-4" style="white-space: nowrap; width: 1%;">
                    @if($item->link_gdrive)
                      <a href="{{ $item->link_gdrive }}" target="_blank" class="btn-doc-link" title="Buka Dokumen Akreditasi di Google Drive">
                        <span class="btn-doc-icon"><i class="bi bi-google text-primary fs-6"></i></span>
                        <span>Lihat Dokumen</span>
                        <i class="bi bi-box-arrow-up-right btn-doc-arrow"></i>
                      </a>
                    @elseif($item->file_sertifikat)
                      <a href="{{ $item->file_url }}" target="_blank" class="btn-doc-link" title="Unduh Berkas Akreditasi Resmi">
                        <span class="btn-doc-icon"><i class="bi bi-file-earmark-pdf-fill text-danger fs-6"></i></span>
                        <span>Lihat Dokumen</span>
                        <i class="bi bi-box-arrow-up-right btn-doc-arrow"></i>
                      </a>
                    @else
                      <span class="badge bg-light text-muted border rounded-pill px-3 py-1.5 small fw-semibold">
                        <i class="bi bi-shield-check text-success me-1"></i> Terakreditasi
                      </span>
                    @endif
                  </td>

                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                    Belum ada data dokumen akreditasi yang tersimpan.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- State Kosong Pencarian --}}
        <div id="noAkreditasiMatch" class="d-none text-center py-5 bg-white">
          <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
          <h6 class="fw-bold text-dark">Dokumen Akreditasi Tidak Ditemukan</h6>
          <p class="text-muted small mb-0">Coba gunakan kata kunci prodi, nomor SK, atau pilih filter lembaga yang berbeda.</p>
        </div>

        {{-- Footer Tabel --}}
        <div class="card-footer bg-light py-3 px-4 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="small text-muted">
            <i class="bi bi-info-circle me-1 text-success"></i>
            Dokumen akreditasi diperbarui secara berkala sesuai ketetapan BAN-PT dan Lembaga Akreditasi Mandiri terkait.
          </div>
          <div class="small fw-semibold text-muted">
            Universitas Ibnu Sina (UIS) Batam
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- JAVASCRIPT DATATABLE FILTER & SEARCH AKREDITASI --}}
<script>
let currentTingkatFilter = 'all';
let currentLembagaFilter = 'all';

function filterTableTingkat(tingkat, btn) {
  currentTingkatFilter = tingkat;

  // Toggle button styling
  const buttons = document.querySelectorAll('.btn-table-filter');
  buttons.forEach(b => {
    b.classList.remove('active', 'text-white');
    b.classList.add('bg-light', 'text-dark');
    b.style.backgroundColor = '';
  });
  btn.classList.add('active', 'text-white');
  btn.classList.remove('bg-light', 'text-dark');
  btn.style.backgroundColor = '#046B26';

  // Update table title header
  const titleMap = {
    'all': 'Semua Dokumen Akreditasi UIS',
    'universitas': 'Dokumen Akreditasi Universitas (Institusi)',
    'fakultas': 'Dokumen Akreditasi Tingkat Fakultas',
    'prodi': 'Dokumen Akreditasi Program Studi (S1 & S2)'
  };
  const titleEl = document.getElementById('tableInfoTitle');
  if (titleEl) {
    titleEl.textContent = titleMap[tingkat] || 'Dokumen Akreditasi UIS';
  }

  applyTableFilters();
}

function filterTableLembaga(lembaga) {
  currentLembagaFilter = lembaga;
  applyTableFilters();
}

function searchTable(keyword) {
  applyTableFilters();
}

function applyTableFilters() {
  const keyword = document.getElementById('searchTableInput').value.toLowerCase().trim();
  const rows = document.querySelectorAll('.akreditasi-row-item');
  let visibleCount = 0;

  rows.forEach(row => {
    const rowTingkat = row.getAttribute('data-tingkat');
    const rowLembaga = row.getAttribute('data-lembaga');
    const rowSearch = row.getAttribute('data-search');

    const matchTingkat = (currentTingkatFilter === 'all') || (rowTingkat === currentTingkatFilter);
    const matchLembaga = (currentLembagaFilter === 'all') || (rowLembaga === currentLembagaFilter);
    const matchSearch = (keyword === '') || (rowSearch.includes(keyword));

    if (matchTingkat && matchLembaga && matchSearch) {
      row.classList.remove('d-none');
      visibleCount++;
      // Update nomor urut baris yang tampil
      const indexEl = row.querySelector('.row-index-number');
      if (indexEl) {
        indexEl.textContent = visibleCount;
      }
    } else {
      row.classList.add('d-none');
    }
  });

  const noMatchBox = document.getElementById('noAkreditasiMatch');
  const countBadge = document.getElementById('tableRecordCount');
  
  if (countBadge) {
    countBadge.textContent = 'Menampilkan ' + visibleCount + ' Dokumen';
  }

  if (visibleCount === 0) {
    if (noMatchBox) noMatchBox.classList.remove('d-none');
  } else {
    if (noMatchBox) noMatchBox.classList.add('d-none');
  }
}
</script>
@endsection
