@extends('layouts.frontend.template')

@section('title', 'Mitra & Kerjasama — Universitas Ibnu Sina')
@section('meta_description', 'Jelajahi jejaring mitra dan data program kerjasama Universitas Ibnu Sina (MOU, MOA, dan IA).')

@section('content')
<style>
  .kerjasama-hero {
    position: relative;
    overflow: hidden;
    padding: 28px 0 30px;
    color: #fff;
    background: linear-gradient(125deg, #073b1b 0%, #0b5626 58%, #138044 100%);
  }
  .kerjasama-hero .container {
    position: relative;
    z-index: 1;
  }
  .kerjasama-hero .kerjasama-breadcrumb {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
    color: rgba(255, 255, 255, .65);
    font-size: 12px;
    line-height: 1.4;
  }
  .kerjasama-breadcrumb a {
    color: rgba(255, 255, 255, .65);
    text-decoration: none;
  }
  .kerjasama-breadcrumb a:hover,
  .kerjasama-breadcrumb .active {
    color: #ffdf4d;
  }
  .kerjasama-hero h1 {
    margin: 0 0 10px;
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.7rem, 2.5vw, 2rem);
    font-weight: 700;
    letter-spacing: -.025em;
    line-height: 1.25;
  }
  .kerjasama-hero h1 span {
    color: #ffdf4d;
  }
  .kerjasama-stats {
    position: relative;
    z-index: 2;
    margin-top: -30px;
  }
  .kerjasama-stat-card {
    height: 100%;
    border: 1px solid #e3ebe5;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 12px 32px rgba(12, 47, 25, .06);
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
  }
  .kerjasama-stat-icon {
    display: inline-flex;
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: #0b5b2a;
    background: #edf7f0;
    font-size: 21px;
  }
  .kerjasama-stat-value {
    color: #12351f;
    font-size: 24px;
    font-weight: 800;
    line-height: 1.1;
  }
  .kerjasama-stat-label {
    margin-top: 5px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
  }
  .kerjasama-section {
    padding: 60px 0;
  }
  .kerjasama-section-heading {
    max-width: 680px;
    margin: 0 auto 36px;
    text-align: center;
  }
  .kerjasama-section-heading h2 {
    color: #12351f;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.6rem, 2.3vw, 2.1rem);
    font-weight: 700;
    letter-spacing: -.02em;
    margin-bottom: 10px;
  }
  .kerjasama-section-heading p {
    margin: 0;
    color: #64748b;
    font-size: 14.5px;
  }
  .kerjasama-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: .02em;
    border: 1px solid #d6eadb;
    color: #0b5b2a;
    background: #edf7f0;
  }

  /* Mitra Logo Cards */
  .mitra-card {
    border: 1px solid #e3ebe5;
    border-radius: 16px;
    background: #fff;
    padding: 22px 18px 18px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(12, 47, 25, .04);
    transition: transform .25s ease, box-shadow .25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .mitra-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(12, 47, 25, .1);
  }
  .mitra-logo-wrap {
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
  }
  .mitra-logo-wrap img {
    max-height: 64px;
    max-width: 100%;
    object-fit: contain;
  }
  .mitra-card h3 {
    font-size: 14.5px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px;
    text-transform: capitalize;
  }
  .mitra-card-meta {
    font-size: 12px;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  /* Index Table Section */
  .kerjasama-table-container {
    max-width: 1080px;
    margin: 0 auto;
  }
  .kerjasama-tabs-nav {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 24px;
  }
  .kerjasama-tab-btn {
    background: #235334;
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 700;
    border-radius: 6px;
    cursor: pointer;
    transition: all .2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .kerjasama-tab-btn:hover {
    background: #1b4229;
    color: #f4c430;
  }
  .kerjasama-tab-btn.active {
    background: #1b4229;
    color: #f4c430;
    box-shadow: inset 0 -3px 0 #f4c430, 0 4px 12px rgba(27, 66, 41, .25);
  }
  .kerjasama-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 14px;
    font-size: 14px;
    color: #374151;
  }
  .kerjasama-table-wrap {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    background: #ffffff;
  }
  .kerjasama-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
  }
  .kerjasama-table thead th {
    background: #235334;
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 14px 18px;
    border: none;
    white-space: nowrap;
  }
  .kerjasama-table tbody td {
    padding: 13px 18px;
    font-size: 13.5px;
    color: #1f2937;
    border-bottom: 1px solid #eef0f2;
    vertical-align: middle;
  }
  .kerjasama-table tbody tr:nth-child(even) {
    background-color: #f9fafb;
  }
  .kerjasama-table tbody tr:hover {
    background-color: #eef7f1;
  }
  .kerjasama-empty {
    text-align: center;
    padding: 48px 20px;
    color: #6b7280;
    background: #fff;
    border-radius: 12px;
    border: 1px dashed #d1d5db;
  }
</style>

{{-- HERO --}}
<section class="kerjasama-hero">
  <div class="container">
    <nav class="kerjasama-breadcrumb" aria-label="breadcrumb">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill"></i> Beranda</a>
      <span>/</span>
      <span class="active">Mitra & Kerjasama</span>
    </nav>
    <div class="mt-3">
      <h1>Mitra <span>Kerjasama</span></h1>
    </div>
  </div>
</section>

{{-- STATISTIK KARTU TOP --}}
<section class="kerjasama-stats">
  <div class="container">
    <div class="row g-3 g-lg-4">
      <div class="col-sm-6 col-lg-3">
        <div class="kerjasama-stat-card">
          <div class="kerjasama-stat-icon"><i class="bi bi-buildings"></i></div>
          <div>
            <div class="kerjasama-stat-value">{{ $partners->count() }}</div>
            <div class="kerjasama-stat-label">Mitra Aktif</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="kerjasama-stat-card">
          <div class="kerjasama-stat-icon"><i class="bi bi-file-earmark-text"></i></div>
          <div>
            <div class="kerjasama-stat-value">{{ $agreementCounts->get('MOU', 0) }}</div>
            <div class="kerjasama-stat-label">Dokumen MOU</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="kerjasama-stat-card">
          <div class="kerjasama-stat-icon"><i class="bi bi-journal-text"></i></div>
          <div>
            <div class="kerjasama-stat-value">{{ $agreementCounts->get('MOA', 0) }}</div>
            <div class="kerjasama-stat-label">Dokumen MOA</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="kerjasama-stat-card">
          <div class="kerjasama-stat-icon"><i class="bi bi-clipboard-check"></i></div>
          <div>
            <div class="kerjasama-stat-value">{{ $agreementCounts->get('IA', 0) }}</div>
            <div class="kerjasama-stat-label">Dokumen IA</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- REKAN KOLABORASI (LOGO MITRA) --}}
@if($partners->isNotEmpty())
<section class="kerjasama-section pb-4">
  <div class="container">
    <div class="kerjasama-section-heading">
      <span class="kerjasama-eyebrow">
        <i class="bi bi-buildings"></i> Rekan Kolaborasi
      </span>
      <h2>Bergerak Bersama Para Mitra</h2>
      <p>Jejaring mitra yang mendukung pengembangan pendidikan, riset, dan pengalaman profesional mahasiswa.</p>
    </div>

    <div class="row g-3 g-lg-4 justify-content-center">
      @foreach($partners as $partner)
        <div class="col-6 col-md-4 col-xl-3">
          <article class="mitra-card">
            <div class="mitra-logo-wrap">
              @if($partner->logo)
                <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo {{ $partner->nama }}" loading="lazy">
              @else
                <i class="bi bi-building fs-1 text-secondary opacity-50" aria-hidden="true"></i>
              @endif
            </div>
            <h3>{{ $partner->nama }}</h3>
            <div class="mitra-card-meta">
              <span><i class="bi bi-file-earmark-text me-1"></i>{{ $partner->agreements_count }} kerjasama</span>
              <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
            </div>
          </article>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- TABEL KERJASAMA (INDEX PERSIS CONTOH GAMBAR) --}}
<section class="kerjasama-section pt-3" id="daftar-kerjasama">
  <div class="container">
    <div class="kerjasama-section-heading">
      <span class="kerjasama-eyebrow">
        <i class="bi bi-file-earmark-check"></i> Data Kerjasama
      </span>
      <h2>Program Kerjasama</h2>
      <p>Daftar resmi kerjasama yang dijalankan bersama mitra industri, institusi, dan pemerintahan.</p>
    </div>

    <div class="kerjasama-table-container">
      {{-- TABS FILTER JENIS KERJASAMA --}}
      <div class="kerjasama-tabs-nav" role="tablist">
        <button type="button" class="kerjasama-tab-btn active" data-filter="all" onclick="filterKerjasama('all', this)">
          <span>Semua Kerjasama</span>
          <span class="badge rounded-pill bg-light text-dark">{{ $agreements->count() }}</span>
        </button>
        @foreach($agreementTypes as $type)
          <button type="button" class="kerjasama-tab-btn" data-filter="{{ strtolower($type) }}" onclick="filterKerjasama('{{ strtolower($type) }}', this)">
            <span>{{ $type }}</span>
            <span class="badge rounded-pill bg-light text-dark">{{ $agreementCounts->get($type, 0) }}</span>
          </button>
        @endforeach
      </div>

      {{-- KONTROL TABEL (ENTRIES PER PAGE + SEARCH) --}}
      <div class="kerjasama-controls">
        <div class="d-flex align-items-center gap-2">
          <select class="form-select form-select-sm" id="kerjasamaLimitSelect" style="width: 90px;" onchange="applyKerjasamaFilters()">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100" selected>Semua</option>
          </select>
          <span>entries per page</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <label class="mb-0 fw-semibold">Search:</label>
          <input type="search"
                 class="form-control form-control-sm"
                 id="kerjasamaSearchInput"
                 style="width: 220px;"
                 placeholder="Cari mitra, judul, no..."
                 oninput="applyKerjasamaFilters()">
        </div>
      </div>

      {{-- TABEL INDEKS KERJASAMA --}}
      <div class="kerjasama-table-wrap">
        <div class="table-responsive">
          <table class="kerjasama-table" id="tableKerjasama">
            <thead>
              <tr>
                <th style="width: 60px;">No</th>
                <th style="width: 90px;">Jenis</th>
                <th>Nama Mitra</th>
                <th>Judul Kerjasama</th>
                <th>Nomor Dokumen</th>
                <th>Masa Berlaku</th>
                <th>Ruang Lingkup</th>
              </tr>
            </thead>
            <tbody id="kerjasamaTableBody">
              @forelse($agreements as $index => $item)
                <tr class="kerjasama-row"
                    data-jenis="{{ strtolower($item->jenis) }}"
                    data-search="{{ strtolower($item->partner->nama . ' ' . $item->judul . ' ' . $item->nomor . ' ' . $item->deskripsi . ' ' . $item->jenis) }}">
                  <td class="row-number fw-semibold">{{ $index + 1 }}</td>
                  <td>
                    <span class="badge rounded-pill text-bg-success px-2 py-1" style="font-size: 11px;">
                      {{ $item->jenis }}
                    </span>
                  </td>
                  <td class="fw-semibold text-dark">{{ $item->partner->nama }}</td>
                  <td class="fw-semibold">{{ $item->judul }}</td>
                  <td>{{ $item->nomor ?: '—' }}</td>
                  <td>
                    @if($item->tanggal_mulai)
                      {{ $item->tanggal_mulai->translatedFormat('d M Y') }}
                      @if($item->tanggal_selesai)
                        <br><small class="text-muted">s.d. {{ $item->tanggal_selesai->translatedFormat('d M Y') }}</small>
                      @endif
                    @else
                      —
                    @endif
                  </td>
                  <td>
                    @if($item->deskripsi)
                      <span>{{ $item->deskripsi }}</span>
                    @else
                      <span class="text-muted">—</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr id="emptyInitialRow">
                  <td colspan="7" class="text-center py-4 text-muted">
                    <i class="bi bi-folder2-open me-2 fs-5 align-middle"></i>
                    Belum ada data kerjasama yang dipublikasikan.
                  </td>
                </tr>
              @endforelse
              <tr id="noResultsRow" class="d-none">
                <td colspan="7" class="text-center py-4 text-muted">
                  <i class="bi bi-search me-2 fs-5 align-middle"></i>
                  Tidak ada data kerjasama yang sesuai dengan pencarian.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- KEMBALI KE BERANDA --}}
<section class="py-4 bg-white border-top">
  <div class="container text-center">
    <a href="{{ route('homepage') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
    </a>
  </div>
</section>

@push('scripts')
<script>
  let currentKerjasamaType = 'all';

  function filterKerjasama(type, btn) {
    currentKerjasamaType = type;
    document.querySelectorAll('.kerjasama-tab-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    applyKerjasamaFilters();
  }

  function applyKerjasamaFilters() {
    const searchVal = (document.getElementById('kerjasamaSearchInput')?.value || '').toLowerCase().trim();
    const limitVal = parseInt(document.getElementById('kerjasamaLimitSelect')?.value || '100', 10);
    const rows = document.querySelectorAll('.kerjasama-row');
    const noResultsRow = document.getElementById('noResultsRow');
    let matchedCount = 0;
    let visibleCount = 0;

    rows.forEach(row => {
      const rowJenis = row.getAttribute('data-jenis');
      const rowSearch = row.getAttribute('data-search') || '';

      const matchType = (currentKerjasamaType === 'all') || (rowJenis === currentKerjasamaType);
      const matchSearch = !searchVal || rowSearch.includes(searchVal);

      if (matchType && matchSearch) {
        matchedCount++;
        if (visibleCount < limitVal) {
          row.classList.remove('d-none');
          const numCell = row.querySelector('.row-number');
          if (numCell) numCell.textContent = visibleCount + 1;
          visibleCount++;
        } else {
          row.classList.add('d-none');
        }
      } else {
        row.classList.add('d-none');
      }
    });

    if (noResultsRow) {
      if (rows.length > 0 && matchedCount === 0) {
        noResultsRow.classList.remove('d-none');
      } else {
        noResultsRow.classList.add('d-none');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    applyKerjasamaFilters();
  });
</script>
@endpush
@endsection
