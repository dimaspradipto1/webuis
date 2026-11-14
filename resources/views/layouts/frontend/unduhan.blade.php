@extends('layouts.frontend.template')

@section('title', 'Downloads & Unduhan Berkas Media — Universitas Ibnu Sina (UIS)')
@section('meta_description', 'Pusat unduhan berkas resmi, logo universitas, aset grafis, video promosi, jingle mars, dan dokumen template resmi UIS.')
@section('meta_keywords', 'unduhan uis, logo uis, template uis, mars uis, audio uis, aset media universitas')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<style>
  /* Hero Banner & Breadcrumb (Matches standard site header banner) */
  .download-hero {
    background: #046b26 !important;
    border-bottom: 3px solid #fed802 !important;
    position: relative;
    overflow: hidden;
    padding-top: 26px !important;
    padding-bottom: 22px !important;
  }

  .download-hero-title {
    color: #ffffff !important;
    font-weight: 800 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
    font-size: 26px !important;
    margin-bottom: 6px !important;
    line-height: 1.25 !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .download-hero-title em {
    color: #fed802 !important;
    font-style: normal;
  }

  .unduhan-page-body {
    background: #f8fafc;
    min-height: 70vh;
    padding: 45px 0 80px 0;
  }

  /* Main Card (Reflects user screenshot) */
  .downloads-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    max-width: 1080px;
    margin: 0 auto;
  }

  .downloads-top-accent {
    height: 6px;
    background: linear-gradient(90deg, #15803d 0%, #d97706 50%, #15803d 100%);
    width: 100%;
  }

  .downloads-card-header {
    padding: 36px 24px 24px 24px;
    text-align: center;
  }

  .downloads-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    letter-spacing: -0.5px;
  }

  .downloads-tabs {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 6px;
  }

  .downloads-tab-btn {
    border: none;
    background: transparent;
    color: #334155;
    font-weight: 700;
    font-size: 15px;
    padding: 10px 26px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }

  .downloads-tab-btn:hover {
    color: #16a34a;
    background: #f1f5f9;
  }

  .downloads-tab-btn.active {
    background: #34a853;
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(52, 168, 83, 0.35);
  }

  /* Table Style */
  .downloads-table-wrap {
    overflow-x: auto;
  }

  .downloads-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
  }

  .downloads-table thead th {
    background: #e1f0fa;
    color: #0f2d4a;
    font-weight: 800;
    font-size: 13.5px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 16px 28px;
    border: none;
  }

  .downloads-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s ease;
  }

  .downloads-table tbody tr:hover {
    background: #f8fafc;
  }

  .downloads-table tbody td {
    padding: 16px 28px;
    font-size: 14.5px;
    vertical-align: middle;
    border: none;
  }

  .downloads-item-name {
    font-weight: 600;
    color: #334155;
    line-height: 1.4;
  }

  .downloads-item-size {
    display: inline-block;
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
    margin-left: 8px;
  }

  .downloads-action-link {
    color: #dc2626;
    font-weight: 600;
    text-decoration: none;
    font-size: 14.5px;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .downloads-action-link:hover {
    color: #991b1b;
    text-decoration: underline;
  }
</style>

<!-- ═══════════════════════════════════════════════
     1. DOWNLOAD HERO BANNER (GREEN BANNER WITH BREADCRUMB)
═══════════════════════════════════════════════ -->
<div class="download-hero">
  <div class="container">
    <div class="download-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="download-hero-title">
        Downloads Dokumen <em>Humas</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.humas') }}">Humas & Protokoler</a>
        <span>/</span>
        <span class="active">Downloads</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     2. MAIN CONTENT CARD
═══════════════════════════════════════════════ -->
<div class="unduhan-page-body">
  <div class="container">

    <!-- Main Downloads Card -->
    <div class="downloads-card" data-aos="fade-up" data-aos-duration="700">
      <div class="downloads-top-accent"></div>
      
      <div class="downloads-card-header">
        <h2 class="downloads-title">Downloads</h2>
        
        <!-- Category Tabs -->
        <div class="downloads-tabs">
          <button type="button" class="downloads-tab-btn {{ ($selectedCat ?? 'image') === 'image' ? 'active' : '' }}" onclick="filterCategory('image', this)">
            <i class="bi bi-image"></i> Image
          </button>
          <button type="button" class="downloads-tab-btn {{ ($selectedCat ?? '') === 'video' ? 'active' : '' }}" onclick="filterCategory('video', this)">
            <i class="bi bi-camera-video"></i> Video
          </button>
          <button type="button" class="downloads-tab-btn {{ ($selectedCat ?? '') === 'audio' ? 'active' : '' }}" onclick="filterCategory('audio', this)">
            <i class="bi bi-music-note-beamed"></i> Audio
          </button>
          <button type="button" class="downloads-tab-btn {{ ($selectedCat ?? '') === 'template' ? 'active' : '' }}" onclick="filterCategory('template', this)">
            <i class="bi bi-brush"></i> Template
          </button>
        </div>
      </div>

      <!-- Table Section -->
      <div class="downloads-table-wrap">
        <table class="downloads-table">
          <thead>
            <tr>
              <th style="text-align: left; width: 75%;">ITEM</th>
              <th style="text-align: right; width: 25%;">DOWNLOAD</th>
            </tr>
          </thead>
          <tbody id="downloadsTableBody">
            @php
              $activeItems = $unduhans ?? collect();
              $initCat = $selectedCat ?? 'image';
            @endphp

            @forelse($activeItems as $item)
              @php
                $itemCat = strtolower($item->kategori);
                $isMatch = ($itemCat === $initCat);
              @endphp
              <tr class="download-row category-{{ $itemCat }}" data-cat="{{ $itemCat }}" style="{{ $isMatch ? '' : 'display: none;' }}">
                <td class="text-start">
                  <span class="downloads-item-name">{{ $item->judul }}</span>
                  @if(!empty($item->file_size))
                    <span class="downloads-item-size">({{ $item->file_size }})</span>
                  @endif
                </td>
                <td class="text-end">
                  <a href="{{ $item->download_url }}" {{ $item->download_url !== '#' ? 'target=_blank download' : '' }} class="downloads-action-link">
                    Download
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center py-5 text-muted">
                  <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                  Belum ada berkas unduhan yang tersedia.
                </td>
              </tr>
            @endforelse

            <tr id="emptyCategoryRow" style="display: none;">
              <td colspan="2" class="text-center py-5 text-muted">
                <i class="bi bi-folder2-open fs-2 d-block mb-2 text-secondary"></i>
                Tidak ada berkas unduhan pada kategori ini.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script>
  function filterCategory(cat, btnElement) {
    // Update active tab styling
    document.querySelectorAll('.downloads-tab-btn').forEach(btn => btn.classList.remove('active'));
    if (btnElement) {
      btnElement.classList.add('active');
    }

    // Filter table rows
    const rows = document.querySelectorAll('.download-row');
    let visibleCount = 0;

    rows.forEach(row => {
      const rowCat = row.getAttribute('data-cat');
      if (rowCat === cat) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    const emptyRow = document.getElementById('emptyCategoryRow');
    if (emptyRow) {
      emptyRow.style.display = (visibleCount === 0) ? '' : 'none';
    }

    // Update URL with slug without page reload
    if (history.pushState) {
      const newUrl = "{{ url('/unduhan') }}/" + cat;
      window.history.replaceState({path: newUrl}, '', newUrl);
    }
  }

  // Handle URL query on load if present
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('kategori');
    if (catParam && ['image', 'video', 'audio', 'template'].includes(catParam.toLowerCase())) {
      const targetBtn = Array.from(document.querySelectorAll('.downloads-tab-btn')).find(b => b.textContent.toLowerCase().includes(catParam.toLowerCase()));
      if (targetBtn) {
        filterCategory(catParam.toLowerCase(), targetBtn);
      }
    }
  });
</script>
@endsection
