@extends('layouts.frontend.template')

@section('title', 'Profil dan Struktur Pimpinan — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Profil Pimpinan, Rektorat, Dekan Fakultas, serta Struktur Pimpinan dan Manajemen Universitas Ibnu Sina (UIS) Batam.')
@section('meta_keywords', 'profil pimpinan uis, struktur organisasi uis, rektor uis, yapista, pimpinan dan manajemen uis')

@push('styles')
<style>
  .pimpinan-page-section {
    padding: 56px 0 80px;
    background: #ffffff;
  }
  .pimpinan-main-heading {
    text-align: center;
    margin-bottom: 48px;
  }
  .pimpinan-main-heading h1 {
    font-size: clamp(1.65rem, 3.2vw, 2.35rem);
    font-weight: 800;
    color: #111827;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 14px;
  }
  .pimpinan-heading-line {
    width: 100%;
    max-width: 820px;
    height: 3px;
    background: #046B26;
    margin: 0 auto;
    border-radius: 99px;
  }

  /* Pimpinan Card */
  .pimpinan-card {
    text-align: center;
    padding: 12px 10px 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.25s ease;
  }
  .pimpinan-card:hover {
    transform: translateY(-5px);
  }
  .pimpinan-photo-frame {
    width: 100%;
    max-width: 245px;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    margin: 0 auto 16px;
    background: #f8faf9;
    transition: box-shadow 0.25s ease;
  }
  .pimpinan-card:hover .pimpinan-photo-frame {
    box-shadow: 0 18px 36px rgba(4, 107, 38, 0.22);
  }
  .pimpinan-photo-frame img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
  }
  .pimpinan-name {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 4px;
    line-height: 1.35;
  }
  .pimpinan-role {
    font-size: 12.5px;
    color: #4b5563;
    margin-bottom: 14px;
    line-height: 1.45;
    max-width: 280px;
  }
  .btn-pimpinan-detail {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #045D22;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 8px 26px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(4, 93, 34, 0.2);
  }
  .btn-pimpinan-detail:hover {
    background: #034719;
    color: #f4c430 !important;
    transform: translateY(-1px);
  }

  /* Pimpinan dan Manajemen Section */
  .manajemen-block {
    max-width: 980px;
    margin: 56px auto 0;
  }
  .manajemen-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 24px;
    font-weight: 800;
    color: #216e39;
    margin-bottom: 22px;
  }
  .manajemen-tabs-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 20px;
  }
  @media (max-width: 767px) {
    .manajemen-tabs-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  .manajemen-tab-btn {
    background: #2b6329;
    color: #ffffff;
    border: none;
    padding: 13px 16px;
    font-size: 14px;
    font-weight: 700;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
  }
  .manajemen-tab-btn:hover {
    background: #1f4d1e;
    color: #f4c430;
  }
  .manajemen-tab-btn.active {
    background: #1d5120;
    color: #f4c430;
    box-shadow: inset 0 -3px 0 #f4c430, 0 4px 12px rgba(29, 81, 32, 0.25);
  }

  /* Table Controls & Styling */
  .manajemen-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 14px;
    font-size: 14px;
    color: #374151;
  }
  .manajemen-table-wrap {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    background: #ffffff;
  }
  .manajemen-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
  }
  .manajemen-table thead th {
    background: #235334;
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 14px 18px;
    border: none;
  }
  .manajemen-table tbody td {
    padding: 13px 18px;
    font-size: 13.5px;
    color: #1f2937;
    border-bottom: 1px solid #eef0f2;
    vertical-align: middle;
  }
  .manajemen-table tbody tr:nth-child(even) {
    background-color: #f9fafb;
  }
  .manajemen-table tbody tr:hover {
    background-color: #eef7f1;
  }
</style>
@endpush

@section('content')
<section class="pimpinan-page-section">
  <div class="container">

    {{-- JUDUL UTAMA --}}
    <div class="pimpinan-main-heading" data-aos="fade-up">
      <h1>PROFIL PIMPINAN DAN STRUKTUR</h1>
      <div class="pimpinan-heading-line"></div>
    </div>

    {{-- KARTU PROFIL PIMPINAN PER BARIS --}}
    <div class="mx-auto" style="max-width: 980px;">
      @foreach($pimpinansByBaris as $baris => $listPimpinan)
        <div class="row g-4 justify-content-center mb-4" data-aos="fade-up">
          @foreach($listPimpinan as $pimpinan)
            @php
              $colClass = ($baris == 1 && $listPimpinan->count() <= 2)
                  ? 'col-md-6 col-sm-6'
                  : 'col-lg-4 col-md-6';
            @endphp
            <div class="{{ $colClass }}">
              <div class="pimpinan-card">
                <div class="w-100">
                  <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}" class="text-decoration-none d-block">
                    <div class="pimpinan-photo-frame">
                      <img src="{{ $pimpinan->foto_url }}" alt="{{ $pimpinan->nama }}" loading="lazy">
                    </div>
                  </a>
                  <div class="pimpinan-name">{{ $pimpinan->nama }}</div>
                  <div class="pimpinan-role mx-auto">{{ $pimpinan->jabatan }}</div>
                </div>
                <div>
                  <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}" class="btn-pimpinan-detail">
                    Detail
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>

    {{-- TABEL PIMPINAN DAN MANAJEMEN (REKTORAT, FEB, FST, FIKES) --}}
    <div class="manajemen-block" data-aos="fade-up">
      <div class="manajemen-title">
        <i class="bi bi-folder2-open"></i>
        <span>Pimpinan dan Manajemen</span>
      </div>

      {{-- 4 TABS --}}
      <div class="manajemen-tabs-grid" role="tablist">
        @foreach($kategoriTabs as $idx => $kat)
          <button type="button"
                  class="manajemen-tab-btn {{ $idx === 0 ? 'active' : '' }}"
                  data-target-tab="tab-manajemen-{{ Str::slug($kat) }}"
                  onclick="switchManajemenTab('tab-manajemen-{{ Str::slug($kat) }}', this)">
            {{ $kat }}
          </button>
        @endforeach
      </div>

      {{-- TAB PANES --}}
      @foreach($kategoriTabs as $idx => $kat)
        @php
          $rows = $manajemensAll->get($kat, collect());
          $tabId = 'tab-manajemen-' . Str::slug($kat);
        @endphp
        <div id="{{ $tabId }}" class="manajemen-tab-pane {{ $idx === 0 ? '' : 'd-none' }}">
          <div class="manajemen-controls">
            <div class="d-flex align-items-center gap-2">
              <select class="form-select form-select-sm manajemen-limit-select" style="width: 85px;" data-table-id="table-{{ Str::slug($kat) }}">
                <option value="100" selected>Semua</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
              </select>
              <span>entries per page</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <label class="mb-0 fw-semibold">Search:</label>
              <input type="search"
                     class="form-control form-control-sm manajemen-search-input"
                     style="width: 210px;"
                     placeholder="Cari nama atau jabatan..."
                     data-table-id="table-{{ Str::slug($kat) }}">
            </div>
          </div>

          <div class="manajemen-table-wrap">
            <div class="table-responsive">
              <table class="manajemen-table" id="table-{{ Str::slug($kat) }}">
                <thead>
                  <tr>
                    <th style="width: 70px;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($rows as $rowIdx => $mRow)
                    <tr class="manajemen-data-row">
                      <td class="fw-semibold">{{ $mRow->no_urut ?: ($rowIdx + 1) }}</td>
                      <td class="fw-semibold text-dark">{{ $mRow->nama }}</td>
                      <td>{{ $mRow->jabatan }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="text-center text-muted py-4">Belum ada data pimpinan & manajemen pada kategori {{ $kat }}.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- OPSIONAL: BAGAN GAMBAR STRUKTUR ORGANISASI JIKA ADA --}}
    @if(isset($struktur) && !empty($struktur->url_struktur))
      <div class="manajemen-block mt-5 pt-3 text-center" data-aos="fade-up">
        <h4 class="fw-bold mb-3" style="color: #0b2e19;">Bagan Struktur Organisasi</h4>
        <div class="p-3 bg-light rounded-4 border d-inline-block">
          <img src="{{ asset($struktur->url_struktur) }}" alt="Bagan Struktur Organisasi UIS" class="img-fluid rounded-3" style="max-width: 900px; width: 100%;">
        </div>
      </div>
    @endif

  </div>
</section>
@endsection

@push('scripts')
<script>
  function switchManajemenTab(tabId, btn) {
    document.querySelectorAll('.manajemen-tab-pane').forEach(el => el.classList.add('d-none'));
    document.querySelectorAll('.manajemen-tab-btn').forEach(el => el.classList.remove('active'));

    const target = document.getElementById(tabId);
    if (target) {
      target.classList.remove('d-none');
    }
    if (btn) {
      btn.classList.add('active');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    function filterTable(tableId) {
      const table = document.getElementById(tableId);
      if (!table) return;
      const searchInput = document.querySelector(`.manajemen-search-input[data-table-id="${tableId}"]`);
      const limitSelect = document.querySelector(`.manajemen-limit-select[data-table-id="${tableId}"]`);
      const keyword = (searchInput ? searchInput.value : '').toLowerCase().trim();
      const limit = parseInt(limitSelect ? limitSelect.value : '100', 10) || 100;

      let shown = 0;
      table.querySelectorAll('tbody tr.manajemen-data-row').forEach(row => {
        const text = row.textContent.toLowerCase();
        const matches = keyword === '' || text.includes(keyword);
        if (matches && shown < limit) {
          row.style.display = '';
          shown++;
        } else {
          row.style.display = 'none';
        }
      });
    }

    document.querySelectorAll('.manajemen-search-input').forEach(input => {
      input.addEventListener('input', function () {
        filterTable(this.getAttribute('data-table-id'));
      });
    });

    document.querySelectorAll('.manajemen-limit-select').forEach(select => {
      select.addEventListener('change', function () {
        filterTable(this.getAttribute('data-table-id'));
      });
    });
  });
</script>
@endpush
